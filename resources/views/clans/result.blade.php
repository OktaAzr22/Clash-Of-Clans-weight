<h2>{{ $clan['name'] }}</h2>

<p>Tag : {{ $clan['tag'] }}</p>
<p>Total Member : {{ $clan['members'] }}</p>

<hr>

<h3>Komposisi Town Hall</h3>

<table border="1">

    <tr>
        <th>TH</th>
        <th>Jumlah</th>
    </tr>

    @foreach($thSummary as $th => $jumlah)

        <tr>
            <td>{{ $th }}</td>
            <td>{{ $jumlah }}</td>
        </tr>

    @endforeach

</table>

<hr>

<hr>

<form method="POST"
      action="{{ route('clans.analyze') }}">

    @csrf

    <input
        type="hidden"
        name="clan_tag"
        value="{{ $clan['tag'] }}"
    >

    <button type="submit">
        Analisis War
    </button>

</form>

<h3>Daftar Member</h3>

<table border="1">

    <tr>
        <th>Nama</th>
        <th>TH</th>
        <th>Trophy</th>
    </tr>

    @foreach($members as $member)

        <tr>

            <td>
                {{ $member['name'] }}
            </td>

            <td>
                {{ $member['townHallLevel'] }}
            </td>

            <td>
                {{ $member['trophies'] }}
            </td>

        </tr>

    @endforeach

</table>