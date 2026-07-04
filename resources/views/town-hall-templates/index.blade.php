
@extends('layouts.app')

@section('content')

<div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">

        <div class="flex items-center gap-3">

            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">

                <i class="fas fa-layer-group"></i>

            </div>

            <h3 class="text-base font-bold text-slate-800">

                Daftar Template Building

            </h3>

            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-0.5 rounded-full">

                {{ $templates->count() }} Template

            </span>

        </div>

        <a
            href="{{ route('town-hall-templates.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 text-sm shadow-sm"
        >

            <i class="fas fa-plus"></i>

            Tambah Template

        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>

                <tr class="bg-slate-50/80 border-b border-slate-200">

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        TH

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Nama Template

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Total Building

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Terakhir Diupdate

                    </th>

                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Action

                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($templates as $template)

                    <tr class="hover:bg-slate-50/60 transition duration-150">

                        <td class="px-6 py-4 font-semibold text-slate-700">

                            <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold border border-indigo-200">

                                TH{{ $template->town_hall }}

                            </span>

                        </td>

                        <td class="px-6 py-4 font-medium text-slate-800">

                            {{ $template->name }}

                        </td>

                        <td class="px-6 py-4 text-slate-600">

                            {{ $template->buildings_count }}

                        </td>

                        <td class="px-6 py-4 text-slate-500 text-xs">

                            {{ $template->updated_at->format('d M Y H:i') }}

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center justify-center gap-2">

                                <a
                                    href="{{ route(
                                        'town-hall-templates.builder',
                                        $template
                                    ) }}"
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition flex items-center justify-center"
                                    title="Edit"
                                >

                                    <i class="fas fa-edit text-sm"></i>

                                </a>

                                <form
                                    action="{{ route(
                                        'town-hall-templates.destroy',
                                        $template
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Hapus template ini?'
                                    )"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition flex items-center justify-center"
                                        title="Hapus"
                                    >

                                        <i class="fas fa-trash text-sm"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-8 text-slate-400"
                        >

                            Belum ada template.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

