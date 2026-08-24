<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ClasherBuilding;
use App\Models\ThBuilding;
use App\Services\ClashOfClansService;
use Illuminate\Http\Request;
use App\Services\TemplateLabelService;
use App\Services\UpgradeAnalyzerService;
use App\Services\ClasherSyncService;
use App\Http\Requests\StoreClasherRequest;
use App\Jobs\SyncAllTownHallJob;
use Barryvdh\DomPDF\Facade\Pdf;

class ClasherController extends Controller
{
    /**
     * Daftar clasher.
     */
    public function index(
        Request $request,
        UpgradeAnalyzerService $upgradeAnalyzer
    ) {
        $status = $request->status ?? 'all';
        $search = $request->search;

        $query = Clasher::withTemplate();

        $query
            ->when(
                $status === 'filled',
                fn ($query) => $query->filledProfile()
            )

            ->when(
                $status === 'empty',
                fn ($query) => $query->emptyProfile()
            )

            ->when(
                $search,
                fn ($query) => $query->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
            );

        $clashers = $query
            ->latest()
            ->paginate(7)
            ->withQueryString();

        /*
         * Daftar akun yang membutuhkan upgrade.
         */
        $upgradeClashers = Clasher::needUpgrade()
            ->with([
                'buildings.building',
                'template.buildings.building',
            ])
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();

        $players = $upgradeAnalyzer->analyze($upgradeClashers);

        $totalPlayers = $players->count();

        return view(
            'clashers.index',
            compact(
                'clashers',
                'status',
                'search',
                'players',
                'totalPlayers'
            )
        );
    }


    /**
     * Tambah / sync clasher dari API Clash of Clans.
     */
    public function store(
        StoreClasherRequest $request,
        ClashOfClansService $coc,
        ClasherSyncService $clasherSync
    ) {
        try {

            $data = $coc->getPlayer(
                $request->validated('tag')
            );

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'tag' => $e->getMessage(),
                ])
                ->withInput();
        }

        $clasherSync->sync($data);

        return redirect()
            ->route('clashers.index')
            ->with(
                'success',
                'Clasher berhasil disimpan.'
            );
    }


    /**
     * Form data war profile.
     */
    public function warProfile(Clasher $clasher)
    {
        /*
         * Ambil konfigurasi building terakhir
         * yang tersedia untuk TH clasher.
         */
        $buildings = ThBuilding::with('building')
            ->where(
                'town_hall',
                '<=',
                $clasher->town_hall
            )
            ->orderBy('town_hall')
            ->get()
            ->groupBy('building_id')
            ->map(
                fn ($items) => $items->last()
            );

        /*
         * Level building yang sudah dimiliki clasher.
         */
        $existingLevels = ClasherBuilding::where(
                'clasher_id',
                $clasher->id
            )
            ->get()
            ->keyBy(
                fn ($item) =>
                    $item->building_id . '_' . $item->slot
            );

        /*
         * Jika request AJAX,
         * kembalikan partial form saja.
         */
        if (request()->ajax()) {

            return view(
                'clashers.partials.war-profile-form',
                compact(
                    'clasher',
                    'buildings',
                    'existingLevels'
                )
            );
        }

        return view(
            'clashers.war-profile',
            compact(
                'clasher',
                'buildings',
                'existingLevels'
            )
        );
    }


    /**
     * Simpan data war profile.
     *
     * Setelah data building disimpan,
     * TemplateLabelService langsung menghitung:
     *
     * - label
     * - ready
     * - template
     * - needs_upgrade
     */
    public function saveWarProfile(
        Request $request,
        Clasher $clasher,
        TemplateLabelService $templateLabelService
    ) {

        /*
         * Simpan semua level building.
         */
        foreach ($request->levels ?? [] as $buildingId => $slots) {

            foreach ($slots as $slot => $level) {

                ClasherBuilding::updateOrCreate(
                    [
                        'clasher_id' => $clasher->id,
                        'building_id' => $buildingId,
                        'slot' => $slot,
                    ],
                    [
                        'level' => $level,
                    ]
                );
            }
        }

        /*
         * Refresh data clasher beserta building.
         *
         * Penting:
         * Kita harus menggunakan data terbaru setelah
         * updateOrCreate di atas.
         */
        $clasher->load('buildings');

        /*
         * Analisa template.
         */
        $result = $templateLabelService->analyze($clasher);

        /*
         * Simpan hasil analisa.
         */
        $clasher->update([
            'label' => $result['label'],

            /*
             * READY ditentukan sepenuhnya oleh service.
             *
             * TRUE hanya jika seluruh building template
             * sama persis dengan building clasher.
             */
            'is_ready_war' => $result['ready'],

            /*
             * Template terbaik yang digunakan.
             */
            'town_hall_template_id' =>
                $result['template']?->id,

            /*
             * Waktu terakhir profile diperbarui.
             */
            'last_war_profile_update' => now(),

            /*
             * Daftar building yang masih kurang level.
             */
            'upgrade_notes' =>
                $result['needs_upgrade'],
        ]);

        return redirect('/clashers')
            ->with(
                'success',
                'Data bangunan berhasil disimpan.'
            );
    }


    /**
     * Overview kekuatan building clasher.
     */
    public function overview(Request $request)
    {
        $selectedTh = $request->th ?? 'all';

        $query = Clasher::with([
                'clasherBuildings.building'
            ])
            ->has('clasherBuildings');

        if ($selectedTh !== 'all') {
            $query->where(
                'town_hall',
                $selectedTh
            );
        }

        $clashers = $query->get();

        /*
         * Hitung total level building.
         */
        $clashers->each(function ($clasher) {

            $clasher->total_level =
                $clasher->clasherBuildings->sum('level');
        });

        /*
         * Jika memilih TH tertentu:
         * urutkan berdasarkan total level.
         */
        if ($selectedTh !== 'all') {

            $clashers = $clashers
                ->sortBy('total_level')
                ->values();

        } else {

            /*
             * Jika semua TH:
             *
             * TH terbesar dahulu,
             * kemudian total level terkecil.
             */
            $clashers = $clashers
                ->sortBy([
                    ['town_hall', 'desc'],
                    ['total_level', 'asc'],
                ])
                ->values();
        }

        $townHalls = Clasher::select('town_hall')
            ->distinct()
            ->orderByDesc('town_hall')
            ->pluck('town_hall');

        /*
         * Response AJAX.
         */
        if ($request->ajax()) {

            return view(
                'clashers.partials.overview-list',
                compact('clashers')
            )->render();
        }

        return view(
            'clashers.overview',
            compact(
                'clashers',
                'townHalls',
                'selectedTh'
            )
        );
    }


    /**
     * Sinkronisasi label + status ready semua clasher.
     */
    public function syncLabels(
        TemplateLabelService $templateLabelService
    ) {

        /*
         * Ambil semua clasher yang memiliki
         * data building.
         */
        $clashers = Clasher::with('buildings')
            ->has('clasherBuildings')
            ->get();

        $updated = 0;

        foreach ($clashers as $clasher) {

            /*
             * Analisa ulang berdasarkan template.
             */
            $result = $templateLabelService
                ->analyze($clasher);

            /*
             * Simpan seluruh hasil analisa.
             */
            $clasher->update([
                'label' =>
                    $result['label'],

                'is_ready_war' =>
                    $result['ready'],

                'upgrade_notes' =>
                    $result['needs_upgrade'],

                'town_hall_template_id' =>
                    $result['template']?->id,

                'last_war_profile_update' =>
                    now(),
            ]);

            $updated++;
        }

        return back()->with(
            'success',
            "{$updated} clasher berhasil disinkronkan."
        );
    }


    /**
     * Sinkronisasi seluruh Town Hall.
     */
    public function syncAllTownHall()
    {
        SyncAllTownHallJob::dispatch();

        return back()->with(
            'success',
            'Sinkronisasi Town Hall sedang diproses di background.'
        );
    }


    /**
     * Export daftar upgrade ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Clasher::with([
            'buildings.building',
            'template.buildings.building',
        ])
            ->where('label', 'perlu up');

        /*
         * Filter TH jika diberikan.
         */
        if ($request->filled('th')) {

            $query->where(
                'town_hall',
                $request->th
            );
        }

        $clashers = $query
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();

        $players = collect();

        foreach ($clashers as $clasher) {

            /*
             * Tidak ada template.
             */
            if (!$clasher->template) {
                continue;
            }

            $upgrades = collect();

            foreach (
                $clasher->template->buildings
                as $templateBuilding
            ) {

                /*
                 * Cari building clasher berdasarkan:
                 *
                 * building_id
                 * slot
                 */
                $current = $clasher->buildings->first(
                    function ($building) use ($templateBuilding) {

                        return
                            $building->building_id
                            ==
                            $templateBuilding->building_id

                            &&

                            $building->slot
                            ==
                            $templateBuilding->slot;
                    }
                );

                /*
                 * Building tidak ditemukan.
                 */
                if (!$current) {
                    continue;
                }

                /*
                 * Level clasher masih di bawah template.
                 */
                if (
                    $current->level
                    <
                    $templateBuilding->level
                ) {

                    $upgrades->push([
                        'building' =>
                            $templateBuilding
                                ->building
                                ->name,

                        'slot' =>
                            $templateBuilding->slot,

                        'current' =>
                            $current->level,

                        'target' =>
                            $templateBuilding->level,

                        'difference' =>
                            $templateBuilding->level
                            -
                            $current->level,
                    ]);
                }
            }

            /*
             * Hanya masukkan player yang memang
             * mempunyai daftar upgrade.
             */
            if ($upgrades->isNotEmpty()) {

                $players->push([
                    'player' =>
                        $clasher,

                    'upgrades' =>
                        $upgrades,
                ]);
            }
        }

        $pdf = Pdf::loadView(
            'clashers.partials.pdf',
            [
                'players' => $players,
            ]
        )->setPaper(
            'a4',
            'portrait'
        );

        return $pdf->download(
            'list-upgrade-'
            . now()->format('Y-m-d')
            . '.pdf'
        );
    }
}