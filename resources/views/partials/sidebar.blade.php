<aside class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 text-white shadow-2xl flex flex-col">

    {{-- Brand --}}
    <div class="px-6 py-7 border-b border-slate-700/60 flex items-center gap-3">

        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
            <i class="fa-solid fa-shield-halved text-lg"></i>
        </div>

        <span class="text-xl font-bold">
            Clash<span class="text-blue-400">Admin</span>
        </span>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 mt-6 space-y-2 overflow-y-auto">

        {{-- Dashboard --}}
        <a
            href="{{ route('dashboard') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 border-l-2',
                'bg-slate-700/30 text-white border-blue-500' => request()->routeIs('dashboard'),
                'border-transparent text-slate-300 hover:bg-slate-700/50 hover:text-white hover:border-blue-500' => !request()->routeIs('dashboard'),
            ])
        >
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        {{-- Clashers --}}
        <a
            href="{{ route('clashers.index') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 border-l-2',
                'bg-slate-700/30 text-white border-blue-500' => request()->routeIs('clashers.*'),
                'border-transparent text-slate-300 hover:bg-slate-700/50 hover:text-white hover:border-blue-500' => !request()->routeIs('clashers.*'),
            ])
        >
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span>Clashers</span>
        </a>

        {{-- TH Buildings --}}
        <a
            href="{{ route('th-buildings.index') }}"
            @class([
            'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 border-l-2',
            'bg-slate-700/30 text-white border-blue-500' => request()->routeIs('th-buildings.*'),
            'border-transparent text-slate-300 hover:bg-slate-700/50 hover:text-white hover:border-blue-500' => !request()->routeIs('th-buildings.*'),
            ])
        >
            <i class="fa-solid fa-building w-5 text-center"></i>
            <span>TH Buildings</span>
        </a>

        @php
            $clanMenuActive = 
            
            request()->routeIs('base-groups.*'); 
        @endphp

        {{-- Clan --}}
        <div class="nav-parent rounded-xl transition-all duration-200
            {{ $clanMenuActive ? 'bg-slate-700/30' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">

            <div class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer">

                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved w-5 text-center"></i>
                    <span>Clan</span>
                </div>

                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 icon-rotate
                    {{ $clanMenuActive ? 'rotate-180' : '' }}">
                </i>

            </div>

            <div class="submenu-container overflow-hidden transition-all duration-300 ease-in-out
                {{ $clanMenuActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">

                <div class="pl-2 space-y-1 pt-1 pb-1">

                    {{-- Daftar Clan --}}
                    

                    <a
                        href="{{ route('base-groups.index') }}"
                        @class([
                            'flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-200 border-l-2 ml-1',
                            'bg-slate-700/30 text-white border-blue-500' => request()->routeIs('base-groups.*'),
                            'text-slate-300 hover:text-white hover:bg-slate-700/30 border-transparent hover:border-blue-500' => !request()->routeIs('base-groups.*'),
                        ])
                    >
                        <i class="fa-solid fa-users text-xs text-blue-400 w-5"></i>
                        <span>Daftar Grup</span>
                    </a>

                </div>

            </div>

        </div>

      
        <a
            href="{{ route('town-hall-templates.index') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 border-l-2',

                'bg-slate-700/30 text-white border-blue-500'
                    => request()->routeIs('town-hall-templates.*'),

                'border-transparent text-slate-300 hover:bg-slate-700/50 hover:text-white hover:border-blue-500'
                    => !request()->routeIs('town-hall-templates.*'),
            ])
        >
            <i class="fa-solid fa-layer-group w-5 text-center"></i>

            <span>
                Town Hall Templates
            </span>
        </a>

       



    </nav>

</aside>