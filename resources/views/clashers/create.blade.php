<form method="POST" action="/clashers/store">
    @csrf

    <label>Tag Akun</label>
    <input type="text" name="tag" placeholder="#ABC123XYZ">

    <button type="submit">
        Ambil & Simpan
    </button>
</form>