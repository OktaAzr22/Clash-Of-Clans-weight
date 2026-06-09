<h2>Daftar TH Building</h2>

@if(session('success'))

    <p>
        {{ session('success') }}
    </p>

@endif

<a href="{{ route('th-buildings.create') }}">
    Tambah TH Building
</a>

<br><br>

<table border="1" cellpadding="5">

    <tr>
        <th>ID</th>
        <th>TH</th>
        <th>Building</th>
        <th>Jumlah</th>
        <th>Max Level</th>
    </tr>

    @forelse($thBuildings as $item)

        <tr>

            <td>
                {{ $item->id }}
            </td>

            <td>
                TH {{ $item->town_hall }}
            </td>

            <td>
                {{ $item->building->name }}
            </td>

            <td>
                {{ $item->quantity }}
            </td>

            <td>
                {{ $item->max_level }}
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="5">
                Belum ada konfigurasi TH Building.
            </td>

        </tr>

    @endforelse

</table>