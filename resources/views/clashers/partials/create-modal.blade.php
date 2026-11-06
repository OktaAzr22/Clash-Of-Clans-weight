<x-modal
    id="createClasherModal"
    title="Tambah Clasher">

    <form
        method="POST"
        action="{{ route('clashers.store') }}"
    >

        @csrf

        <input
            type="hidden"
            name="modal"
            value="createClasherModal"
        >

        <x-input
            name="tag"
            label="Tag Akun"
            placeholder="#ABC123XYZ"
            :value="old('tag')"
            required
        />

        <p class="text-sm text-slate-500 mb-6">
            Masukkan tag pemain Clash of Clans untuk mengambil data dari API.
        </p>

        <div class="flex justify-end gap-2">

            <x-button
                type="button"
                variant="secondary"
                class="close-modal"
            >
                Batal
            </x-button>

            <x-button
                type="submit"
                loading
                loading-text="Mengambil Data..."
            >
                <i class="fa-solid fa-download mr-2"></i>
                Ambil & Simpan
            </x-button>

        </div>

    </form>

</x-modal>