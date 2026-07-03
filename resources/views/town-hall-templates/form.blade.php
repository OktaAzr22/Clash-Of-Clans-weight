
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-1">

                {{ $template->name }}

            </h3>

            <small class="text-muted">

                TH {{ $template->town_hall }}

            </small>

        </div>

        <a
            href="{{ route('town-hall-templates.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>

    <form
        action="{{ route(
            'town-hall-templates.update',
            $template
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        @foreach($buildings as $building)

            <div class="card mb-3 shadow-sm">

                <div class="card-header">

                    <strong>

                        {{ $building->building->name }}

                    </strong>

                </div>

                <div class="card-body">

                    @for($slot = 1; $slot <= $building->quantity; $slot++)

                        <div class="row mb-3 align-items-center">

                            <label class="col-md-2 col-form-label">

                                Slot {{ $slot }}

                            </label>

                            <div class="col-md-3">

                                <input
                                    type="number"
                                    min="1"
                                    max="{{ $building->max_level }}"
                                    class="form-control"
                                    name="levels[{{ $building->building_id }}][{{ $slot }}]"
                                    value="{{ old(
                                        "levels.{$building->building_id}.{$slot}",
                                        optional(
                                            $existingLevels->get(
                                                $building->building_id . '_' . $slot
                                            )
                                        )->level
                                    ) }}"
                                    required
                                >

                            </div>

                            <div class="col-md-4">

                                <small class="text-muted">

                                    Maksimal Level:
                                    {{ $building->max_level }}

                                </small>

                            </div>

                        </div>

                    @endfor

                </div>

            </div>

        @endforeach

        <div class="d-flex justify-content-end">

            <button
                class="btn btn-primary"
                type="submit"
            >
                Simpan Template
            </button>

        </div>

    </form>

</div>

@endsection

