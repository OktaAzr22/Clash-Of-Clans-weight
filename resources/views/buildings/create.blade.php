<h2>Tambah Building</h2>

<form method="POST"
      action="{{ route('buildings.store') }}">

    @csrf

    <input
        type="text"
        name="name"
        placeholder="Nama Building"
    >

    <button type="submit">
        Simpan
    </button>

</form>