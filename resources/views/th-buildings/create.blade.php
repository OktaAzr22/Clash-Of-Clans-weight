<h2>Tambah TH Building</h2>

<form method="POST"
      action="{{ route('th-buildings.store') }}">

    @csrf

    <div>

        <label>Town Hall</label>

        <input
            type="number"
            name="town_hall"
        >

    </div>

    <div>

        <label>Building</label>

        <select name="building_id">

            @foreach($buildings as $building)

                <option value="{{ $building->id }}">
                    {{ $building->name }}
                </option>

            @endforeach

        </select>

    </div>

    <div>

        <label>Jumlah</label>

        <input
            type="number"
            name="quantity"
        >

    </div>

    <button type="submit">
        Simpan
    </button>

</form>