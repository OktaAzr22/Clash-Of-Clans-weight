<h2>Tambah TH Building</h2>

<form method="POST"
      action="{{ route('th-buildings.store') }}">

    @csrf

    <div>
        <label>Town Hall</label>

        <input
            type="number"
            name="town_hall"
            min="1"
            max="17"
            value="{{ old('town_hall') }}"
            required
        >

        @error('town_hall')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Building</label>

        <select name="building_id" required>

            <option value="">
                -- Pilih Building --
            </option>

            @foreach($buildings as $building)

                <option
                    value="{{ $building->id }}"
                    @selected(old('building_id') == $building->id)
                >
                    {{ $building->name }}
                </option>

            @endforeach

        </select>

        @error('building_id')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Jumlah Bangunan</label>

        <input
            type="number"
            name="quantity"
            min="1"
            value="{{ old('quantity') }}"
            required
        >

        @error('quantity')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Max Level</label>

        <input
            type="number"
            name="max_level"
            min="1"
            value="{{ old('max_level') }}"
            required
        >

        @error('max_level')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>

</form>