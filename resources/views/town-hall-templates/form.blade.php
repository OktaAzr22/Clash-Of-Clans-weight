
@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm">

                <i class="fas fa-layer-group text-lg"></i>

            </div>

            <div>

                <h2 class="text-2xl font-bold text-slate-800">

                    {{ $template->name }}

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Template Building Town Hall {{ $template->town_hall }}

                </p>

            </div>

        </div>

        <a
            href="{{ route('town-hall-templates.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 transition text-sm font-medium"
        >

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    <form
        action="{{ route(
            'town-hall-templates.update',
            $template
        ) }}"
        method="POST"
        class="space-y-5"
    >

        @csrf
        @method('PUT')

        @foreach($buildings as $building)

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="font-semibold text-slate-800">

                                {{ $building->building->name }}

                            </h3>

                            <p class="text-xs text-slate-500 mt-1">

                                Maksimal Level:
                                {{ $building->max_level }}

                            </p>

                        </div>

                        <div class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">

                            {{ $building->quantity }} Slot

                        </div>

                    </div>

                </div>

                <div class="p-6 space-y-4">

                    @for($slot = 1; $slot <= $building->quantity; $slot++)

                        <div class="flex items-center gap-4">

                            <div class="w-28 shrink-0">

                                <label class="text-sm font-medium text-slate-700">

                                    Slot {{ $slot }}

                                </label>

                            </div>

                            <div class="flex-1">

                                <input
                                    type="number"
                                    min="1"
                                    max="{{ $building->max_level }}"
                                    name="levels[{{ $building->building_id }}][{{ $slot }}]"
                                    value="{{ old(
                                        "levels.{$building->building_id}.{$slot}",
                                        optional(
                                            $existingLevels->get(
                                                $building->building_id . '_' . $slot
                                            )
                                        )->level
                                    ) }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >

                            </div>

                            <div class="w-40 text-right">

                                <span class="text-xs text-slate-500">

                                    Max Lv
                                    {{ $building->max_level }}

                                </span>

                            </div>

                        </div>

                    @endfor

                </div>

            </div>

        @endforeach

        <div class="flex justify-end pt-2">

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition text-sm font-medium shadow-sm"
            >

                <i class="fas fa-save"></i>

                Simpan Template

            </button>

        </div>

    </form>

</div>

@endsection

