<h2>Daftar TH Building</h2>

<a href="{{ route('th-buildings.create') }}">
    Tambah TH Building
</a>

<br><br>

<table border="1">

    <tr>
        <th>ID</th>
        <th>TH</th>
        <th>Building</th>
        <th>Jumlah</th>
    </tr>

    @foreach($thBuildings as $item)

        <tr>

            <td>{{ $item->id }}</td>

            <td>
                TH {{ $item->town_hall }}
            </td>

            <td>
                {{ $item->building->name }}
            </td>

            <td>
                {{ $item->quantity }}
            </td>

        </tr>

    @endforeach

</table>