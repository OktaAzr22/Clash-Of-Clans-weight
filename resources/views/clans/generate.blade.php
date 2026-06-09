<h2>Hasil Pembagian War</h2>

<p>Clan : {{ $clan['name'] }}</p>

<p>
    War Size :
    {{ $warSize }} vs {{ $warSize }}
</p>

<hr>

<h3>Ringkasan TH</h3>

<table border="1">

    <tr>
        <th>TH</th>
        <th>Clan A</th>
        <th>Clan B</th>
    </tr>

    @php

        $allTh = collect(
            array_merge(
                array_keys($summaryA->toArray()),
                array_keys($summaryB->toArray())
            )
        )->unique()->sortDesc();

    @endphp

    @foreach($allTh as $th)

        <tr>

            <td>
                TH {{ $th }}
            </td>

            <td>
                {{ $summaryA[$th] ?? 0 }}
            </td>

            <td>
                {{ $summaryB[$th] ?? 0 }}
            </td>

        </tr>

    @endforeach

</table>

<hr>

<h3>
    Clan A ({{ $clanA->count() }} Member)
</h3>

<table border="1">

    <tr>
        <th>Nama</th>
        <th>TH</th>
    </tr>

    @foreach($clanA as $member)

        <tr>

            <td>
                {{ $member['name'] }}
            </td>

            <td>
                {{ $member['townHallLevel'] }}
            </td>

        </tr>

    @endforeach

</table>

<hr>

<h3>
    Clan B ({{ $clanB->count() }} Member)
</h3>

<table border="1">

    <tr>
        <th>Nama</th>
        <th>TH</th>
    </tr>

    @foreach($clanB as $member)

        <tr>

            <td>
                {{ $member['name'] }}
            </td>

            <td>
                {{ $member['townHallLevel'] }}
            </td>

        </tr>

    @endforeach

</table>

<form method="POST"
      action="{{ route('wars.store') }}">

    @csrf

    <input type="hidden"
           name="source_clan_name"
           value="{{ $clan['name'] }}">

    <input type="hidden"
           name="clan_a_name"
           value="{{ $clan['name'] }} Alpha">

    <input type="hidden"
           name="clan_b_name"
           value="{{ $clan['name'] }} Bravo">

    <input type="hidden"
           name="war_size"
           value="{{ $warSize }}">

    <input type="hidden"
           name="summary_a"
           value="{{ json_encode($summaryA) }}">

    <input type="hidden"
           name="summary_b"
           value="{{ json_encode($summaryB) }}">

    <h3>Pemenang</h3>

    <select name="winner" required>

        <option value="">
            Pilih Pemenang
        </option>

        <option value="clan_a">
            {{ $clan['name'] }} Alpha
        </option>

        <option value="clan_b">
            {{ $clan['name'] }} Bravo
        </option>

        <option value="draw">
            Seri
        </option>

    </select>

    <button type="submit">
        Simpan Histori
    </button>

</form>