<aside class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 text-white shadow-2xl flex flex-col">

    <div class="px-6 py-7 border-b border-slate-700/60 flex items-center gap-3">

        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
            <i class="fa-solid fa-shield-halved text-lg"></i>
        </div>

        <span class="text-xl font-bold">
            Clash<span class="text-blue-400">Admin</span>
        </span>

    </div>

    <nav class="flex-1 px-4 mt-6 space-y-2">

        <a
            href="{{ route('dashboard') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth',
                'bg-blue-600/20 text-white font-medium' => request()->routeIs('dashboard'),
                'text-slate-300 hover:bg-slate-700/50 hover:text-white' => !request()->routeIs('dashboard'),
            ])
        >
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        <a
            href="{{ route('clashers.index') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth',
                'bg-blue-600/20 text-white font-medium' => request()->routeIs('clashers.*'),
                'text-slate-300 hover:bg-slate-700/50 hover:text-white' => !request()->routeIs('clashers.*'),
            ])
        >
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span>Clashers</span>
        </a>

        <a
            href="{{ route('th-buildings.index') }}"
            @class([
                'flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth',
                'bg-blue-600/20 text-white font-medium' => request()->routeIs('th-buildings.*'),
                'text-slate-300 hover:bg-slate-700/50 hover:text-white' => !request()->routeIs('th-buildings.*'),
            ])
        >
            <i class="fa-solid fa-building w-5 text-center"></i>
            <span>TH Buildings</span>
        </a>

    </nav>

</aside>