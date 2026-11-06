<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use Illuminate\Http\Request;

class ClasherConfigurationController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request)
    {
        $clashers = $this->getActiveClashers($request);

        $totalActive = Clasher::query()
            ->where('is_active', true)
            ->count();

        $inactiveClashers = $this->getInactiveClashers();

        if ($request->expectsJson()) {
            return $this->ajaxResponse(
                $clashers,
                $inactiveClashers,
                $totalActive
            );
        }

        return view('clashers.configuration', compact(
            'clashers',
            'inactiveClashers',
            'totalActive'
        ));
    }

    public function toggleActive(
        Request $request,
        Clasher $clasher
    ) {
        $clasher->update([
            'is_active' => ! $clasher->is_active,
        ]);

        $message = $clasher->is_active
            ? 'Akun berhasil diaktifkan.'
            : 'Akun berhasil dinonaktifkan.';

        /*
         * Pertahankan halaman pagination saat ini.
         */
        $clashers = $this->getActiveClashers($request);

        $inactiveClashers = $this->getInactiveClashers();

        $totalActive = Clasher::query()
            ->where('is_active', true)
            ->count();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,

                'message' => $message,

                'is_active' => (bool) $clasher->is_active,

                'total_active' => $totalActive,

                'total_inactive' => $inactiveClashers->count(),

                'active_html' => view(
                    'clashers.partials.active-table',
                    compact('clashers')
                )->render(),

                'inactive_html' => view(
                    'clashers.partials.inactive-list',
                    compact('inactiveClashers')
                )->render(),
            ]);
        }

        return back()->with('success', $message);
    }

    private function getActiveClashers(Request $request)
    {
        return Clasher::query()
            ->where('is_active', true)
            ->with('template')
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->paginate(
                self::PER_PAGE,
                ['*'],
                'page',
                $request->integer('page', 1)
            )
            ->withQueryString()
            ->setPath(route('configuration'));
    }

    private function getInactiveClashers()
    {
        return Clasher::query()
            ->where('is_active', false)
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();
    }

    private function ajaxResponse(
        $clashers,
        $inactiveClashers,
        int $totalActive
    ) {
        return response()->json([
            'success' => true,

            'total_active' => $totalActive,

            'total_inactive' => $inactiveClashers->count(),

            'active_html' => view(
                'clashers.partials.active-table',
                compact('clashers')
            )->render(),

            'inactive_html' => view(
                'clashers.partials.inactive-list',
                compact('inactiveClashers')
            )->render(),
        ]);
    }
}