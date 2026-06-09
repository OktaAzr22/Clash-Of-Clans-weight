<h2>Cari Clan</h2>

<form method="POST"
      action="{{ route('clans.result') }}">

    @csrf

    <input
        type="text"
        name="clan_tag"
        placeholder="#2ABCDEF"
        required
    >

    <button type="submit">
        Cari
    </button>

</form>