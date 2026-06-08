<h2>Daftar Building</h2>

<a href="/buildings/create">
    Tambah Building
</a>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Nama</th>
    </tr>

    @foreach($buildings as $building)

        <tr>
            <td>{{ $building->id }}</td>
            <td>{{ $building->name }}</td>
        </tr>

    @endforeach

</table>