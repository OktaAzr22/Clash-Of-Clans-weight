<table border="1">

    <tr>
        <th>Nama</th>
        <th>Tag</th>
        <th>Clan</th>
        <th>TH</th>
        <th>War Stars</th>
        <th>Level</th>
        <th>Aksi</th>
    </tr>

    @foreach($clashers as $clasher)

    <tr>
        <td>{{ $clasher->name }}</td>
        <td>{{ $clasher->tag }}</td>
        <td>{{ $clasher->clan_name }}</td>
        <td>{{ $clasher->town_hall }}</td>
        <td>{{ $clasher->war_stars }}</td>
        <td>{{ $clasher->exp_level }}</td>

        <td>
            <a href="{{ route('clashers.war-profile', $clasher) }}">
    Kelola Bangunan
</a>
        </td>
    </tr>

    @endforeach

</table>