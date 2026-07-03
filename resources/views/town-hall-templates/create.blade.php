
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h4 class="mb-0">
                        Tambah Template Town Hall
                    </h4>

                </div>

                <div class="card-body">

                    <form
                        action="{{ route('town-hall-templates.store') }}"
                        method="POST"
                    >

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Town Hall

                            </label>

                            <select
                                name="town_hall"
                                class="form-select"
                                required
                            >

                                <option value="">

                                    -- Pilih Town Hall --

                                </option>

                                @foreach($townHalls as $th)

                                    <option
                                        value="{{ $th }}"
                                        @selected(
                                            old('town_hall') == $th
                                        )
                                    >

                                        TH {{ $th }}

                                    </option>

                                @endforeach

                            </select>

                            @error('town_hall')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Nama Template

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Hybrid"
                                required
                            >

                            @error('name')

                                <small class="text-danger">

                                    {{ $message }}

                                </small>

                            @enderror

                        </div>

                        <div class="d-flex justify-content-between">

                            <a
                                href="{{ route(
                                    'town-hall-templates.index'
                                ) }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Lanjut Atur Building
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

