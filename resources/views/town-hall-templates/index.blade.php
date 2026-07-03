@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>
            Template Town Hall
        </h3>

    </div>

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="120">
                            Town Hall
                        </th>

                        <th>
                            Status
                        </th>

                        <th width="180">
                            Total Building
                        </th>

                        <th width="220">
                            Terakhir Diupdate
                        </th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($townHalls as $th)

                        <tr>

                            <td>

                                <strong>
                                    TH {{ $th['town_hall'] }}
                                </strong>

                            </td>

                            <td>

                                @if($th['has_template'])

                                    <span class="badge bg-success">

                                        Template tersedia

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Belum ada template

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $th['total_buildings'] ?: '-' }}

                            </td>

                            <td>

                                @if($th['updated_at'])

                                    {{ \Carbon\Carbon::parse($th['updated_at'])->format('d M Y H:i') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($th['has_template'])

                                    <a
                                        href="{{ route('town-hall-templates.edit', $th['town_hall']) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Edit
                                    </a>

                                @else

                                    <a
                                        href="{{ route('town-hall-templates.create', $th['town_hall']) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Buat Template
                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted py-4"
                            >

                                Belum ada data Town Hall.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection