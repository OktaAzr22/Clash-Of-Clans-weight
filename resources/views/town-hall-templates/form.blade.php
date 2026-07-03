@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>
            Template TH {{ $townHall }}
        </h3>

        <a
            href="{{ route('town-hall-templates.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>

    <form
    action="{{ $isEdit
        ? route('town-hall-templates.update', $townHall)
        : route('town-hall-templates.store') }}"
    method="POST"
>


        @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <input
        type="hidden"
        name="town_hall"
        value="{{ $townHall }}"
    >

        @foreach($buildings as $building)

            <div class="card mb-3">

                <div class="card-header">

                    <strong>

                        {{ $building->building->name }}

                    </strong>

                </div>

                <div class="card-body">

                    @for($slot = 1; $slot <= $building->quantity; $slot++)

                        <div class="row mb-2">

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

                                    Maksimal Level {{ $building->max_level }}

                                </small>

                            </div>

                        </div>

                    @endfor

                </div>

            </div>

        @endforeach

        <button
            class="btn btn-primary"
            type="submit"
        >
            Simpan Template
        </button>

    </form>

</div>

@endsection