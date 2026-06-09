<h2>{{ $clasher->name }}</h2>

<p>Tag : {{ $clasher->tag }}</p>
<p>TH : {{ $clasher->town_hall }}</p>
<p>Clan : {{ $clasher->clan_name ?? '-' }}</p>

<hr>

@if(session('success'))

    <p>
        {{ session('success') }}
    </p>

@endif

@if($errors->any())

    <div>

        <p>
            Terdapat kesalahan:
        </p>

        <ul>

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

@if($buildings->isEmpty())

    <p>
        Belum ada konfigurasi bangunan war weight
        untuk Town Hall {{ $clasher->town_hall }}.
    </p>

    <p>
        Silakan tambahkan terlebih dahulu melalui menu
        TH Building.
    </p>

@else

    <form method="POST"
          action="{{ route('clashers.war-profile.save', $clasher) }}">

        @csrf

        @foreach($buildings as $item)

            <hr>

            <h3>
                {{ $item->building->name }}
            </h3>

            <p>
                Jumlah:
                {{ $item->quantity }}
            </p>

            @for($i = 1; $i <= $item->quantity; $i++)

                <div style="margin-bottom: 10px;">

                    <label>
                        {{ $item->building->name }}
                        {{ $i }}
                    </label>

                    <br>

                    <input
                        type="number"
                        min="0"
                        required
                        name="levels[{{ $item->building_id }}][{{ $i }}]"
                        value="{{ old(
                            'levels.' . $item->building_id . '.' . $i,
                            $existingLevels[
                                $item->building_id . '_' . $i
                            ]->level ?? ''
                        ) }}"
                    >

                </div>

            @endfor

        @endforeach

        <br>

        <button type="submit">
            Simpan
        </button>

    </form>

@endif