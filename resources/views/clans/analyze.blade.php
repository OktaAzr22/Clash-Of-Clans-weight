<h2>Analisis Clan</h2>

<p>Clan : {{ $clan['name'] }}</p>
<p>Tag : {{ $clan['tag'] }}</p>
<p>Total Member : {{ $totalMembers }}</p>

<hr>

<h3>Ukuran War Yang Bisa Dilakukan</h3>

<ul>

    @foreach($warSizes as $size)

        <li>
            {{ $size }} vs {{ $size }}
        </li>

    @endforeach

</ul>

<hr>

<h3>Pilih War</h3>

<form method="POST"
      action="{{ route('clans.generate') }}">

    @csrf

    <input
        type="hidden"
        name="clan_tag"
        value="{{ $clan['tag'] }}"
    >

    <select name="war_size">

        @foreach($warSizes as $size)

            <option value="{{ $size }}">
                {{ $size }} vs {{ $size }}
            </option>

        @endforeach

    </select>

    <button type="submit">
        Generate Roster
    </button>

</form>

<hr>

<h3>Komposisi TH Clan</h3>

<table border="1">

    <tr>
        <th>TH</th>
        <th>Jumlah Member</th>
    </tr>

    @foreach($thSummary as $th => $count)

        <tr>

            <td>
                TH {{ $th }}
            </td>

            <td>
                {{ $count }}
            </td>

        </tr>

    @endforeach

</table>