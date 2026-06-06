<h2>{{ $clasher->name }}</h2>

<p>Tag : {{ $clasher->tag }}</p>
<p>TH : {{ $clasher->town_hall }}</p>
<p>Clan : {{ $clasher->clan_name }}</p>

@if($buildings->isEmpty())

    <hr>

    <p>
        Tidak ada data war weight untuk Town Hall
        {{ $clasher->town_hall }}.
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

            @for($i = 1; $i <= $item->quantity; $i++)

                <div>

                    <label>
                        {{ $item->building->name }}
                        {{ $i }}
                    </label>

                    <input
                        type="number"
                        min="0"
                        name="levels[{{ $item->building_id }}][{{ $i }}]"
                        value="{{
                            $existingLevels[
                                $item->building_id . '_' . $i
                            ]->level ?? ''
                        }}"
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