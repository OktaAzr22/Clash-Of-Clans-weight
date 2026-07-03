
@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>
            Template Town Hall
        </h3>

        <a
            href="{{ route('town-hall-templates.create') }}"
            class="btn btn-primary"
        >
            Tambah Template
        </a>

    </div>

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="100">
                            TH
                        </th>

                        <th>
                            Nama Template
                        </th>

                        <th width="180">
                            Total Building
                        </th>

                        <th width="220">
                            Terakhir Diupdate
                        </th>

                        <th width="220">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($templates as $template)

                        <tr>

                            <td>

                                <strong>
                                    TH {{ $template->town_hall }}
                                </strong>

                            </td>

                            <td>

                                {{ $template->name }}

                            </td>

                            <td>

                                {{ $template->buildings_count }}

                            </td>

                            <td>

                                {{ $template->updated_at->format('d M Y H:i') }}

                            </td>

                            <td>

                                <a
                                    href="{{ route(
                                        'town-hall-templates.builder',
                                        $template
                                    ) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route(
                                        'town-hall-templates.destroy',
                                        $template
                                    ) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm(
                                        'Hapus template ini?'
                                    )"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        type="submit"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted py-4"
                            >

                                Belum ada template.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

