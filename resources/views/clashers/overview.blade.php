<h2>Data Clasher Berdasarkan Town Hall</h2>

<a href="{{ route('clashers.index') }}">
    Kembali ke Daftar Clasher
</a>

<hr>

<form method="GET"
      action="{{ route('clashers.overview') }}">

    <label>Pilih TH :</label>

    <select name="th">

        <option value="all">
            Semua
        </option>

        @foreach($townHalls as $th)

            <option
                value="{{ $th }}"
                {{ ($selectedTh == $th) ? 'selected' : '' }}
            >
                TH {{ $th }}
            </option>

        @endforeach

    </select>

    <button type="submit">
        Tampilkan
    </button>

</form>

<hr>

@if($clashers->isEmpty())

    <p>
        Tidak ada data clasher.
    </p>

@else

    @foreach($clashers as $clasher)

        <div style="margin-bottom: 30px;">

            <h3>
                {{ $clasher->name }}
            </h3>

            <p>
                <strong>Tag :</strong>
                {{ $clasher->tag }}
            </p>

            <p>
                <strong>Clan :</strong>
                {{ $clasher->clan_name ?? '-' }}
            </p>

            <p>
                <strong>Town Hall :</strong>
                TH {{ $clasher->town_hall }}
            </p>

            @if($clasher->clasherBuildings->isEmpty())

                <p>
                    Belum ada data bangunan.
                </p>

            @else
<p>
    <strong>Total Level :</strong>
    {{ $clasher->total_level }}
</p>

<p>
    <strong>Update Bangunan :</strong>

    @if($clasher->last_war_profile_update)

     {{ $clasher->last_war_profile_update->format('F d, Y') }}


    @else

        Belum pernah diupdate

    @endif
</p>
                @php
                    $groupedBuildings = $clasher->clasherBuildings
                        ->groupBy(function ($item) {
                            return $item->building->name;
                        });

                    $maxRows = $groupedBuildings
                        ->map(fn($items) => $items->count())
                        ->max();
                @endphp

                <table border="1" cellpadding="5">

                    <tr>
                        <td>Bangunan</td>

                        @foreach($groupedBuildings as $buildingName => $items)
                            <td>{{ $buildingName }}</td>
                        @endforeach
                    </tr>

                    @for($row = 0; $row < $maxRows; $row++)

                        <tr>

                            <td>
                                {{ $row == 0 ? 'Level' : '' }}
                            </td>

                            @foreach($groupedBuildings as $items)

                                <td>
                                    {{ $items->values()[$row]->level ?? '-' }}
                                </td>

                            @endforeach

                        </tr>

                    @endfor

                </table>

            @endif

        </div>

        <hr>

    @endforeach

@endif