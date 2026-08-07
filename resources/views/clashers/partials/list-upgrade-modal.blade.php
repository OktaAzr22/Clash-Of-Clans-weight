<x-modal
    id="upgrade-modal"
    title="Daftar Upgrade Bangunan"
    size="6xl">

    <!-- body tabel -->
      <div class="p-6 overflow-y-auto flex-1">
        
        <!-- Tabel sesuai permintaan: th, nama, bangunan, lv sekarang, lv target, jumlah level kurang (span) -->
        <div class="overflow-x-auto">
           <div class="flex justify-between items-center mb-4">
          <p class="text-sm text-slate-500"><i class="fas fa-table mr-2"></i>Daftar bangunan dengan level dan target</p>
          
          <a
            href="{{ route('upgrades.export.pdf') }}">

            <button id="exportDataBtn" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl shadow flex items-center gap-2 text-sm transition">
            <i class="fas fa-file-export"></i> Export Data
          </button>

        </a>
        </div>
          <table class="min-w-full divide-y divide-slate-200 border border-slate-200 rounded-xl overflow-hidden">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">TH</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Bangunan</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Lv Sekarang</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Lv Target</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kurang</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                
                @forelse($players as $player)

                    @foreach($player['upgrades'] as $upgrade)

                      <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-50 transition-colors">

                            <td class="px-4 py-3 whitespace-nowrap">
                                TH {{ $player['player']->town_hall }}
                            </td>

                            <td class="px-4 py-3 ">
                                {{ $player['player']->name }}
                            </td>

                            <td class="px-4 py-3 ">
                                {{ $upgrade['building'] }}
                            </td>

                            <td class="px-4 py-3 ">
                                {{ $upgrade['current'] }}
                            </td>

                            <td class="px-4 py-3 ">
                                {{ $upgrade['target'] }}
                            </td>

                            <td class="px-4 py-3 ">
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $upgrade['difference'] }} Level
                                </span>
                            </td>

                        </tr>

                    @endforeach

                    @empty

                    <tr>

                        <td colspan="7" class="py-8 text-center text-slate-500">

                            Tidak ada akun yang perlu di-upgrade.

                        </td>

                    </tr>

                @endforelse
            </tbody>
          </table>
        </div>
       
        <x-slot:footer>

        <div class="flex justify-between items-center">

            <p class="text-xs text-slate-400">
                <i class="fas fa-info-circle mr-1"></i>
                Jumlah Akun {{ $totalPlayers }}, Yok Semangat.
            </p>

            <x-button
                type="button"
                variant="secondary"
                class="close-modal">

                Tutup

            </x-button>

        </div>

    </x-slot:footer>
      </div>
</x-modal>