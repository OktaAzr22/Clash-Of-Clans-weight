<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin Dashboard Interaktif | TailwindCSS</title>
    <!-- TailwindCSS + Font Awesome + Google Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Chart.js untuk grafik interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        /* transisi halus dan efek modern */
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        .sidebar-item {
            transition: all 0.2s;
        }
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(4px);
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 5px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-slate-100 antialiased">
<button
    data-modal-target="productModal"
    class="bg-primary text-red px-5 py-2 rounded-xl">

    Tambah Produk

</button>
    <x-modal
    id="productModal"
    title="Tambah Produk">

    <form>

        <div class="mb-4">
            <label class="block text-sm font-medium">
                Nama Produk
            </label>

            <input
                type="text"
                class="w-full border rounded-xl px-4 py-2">
        </div>

        <button
            type="submit"
            class="w-full bg-primary text-white py-2 rounded-xl">
            Simpan
        </button>

    </form>

</x-modal>

<script>
        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll('[data-modal-target]').forEach(btn => {

                btn.addEventListener('click', function() {

                    const modal = document.getElementById(
                        this.dataset.modalTarget
                    );

                    modal.classList.remove('invisible','opacity-0');

                    modal.querySelector('.modal-container')
                        .classList.remove('scale-95');

                    modal.querySelector('.modal-container')
                        .classList.add('scale-100');
                });
            });

            document.querySelectorAll('.close-modal').forEach(btn => {

                btn.addEventListener('click', function() {

                    const modal = this.closest('.modal-overlay');

                    modal.classList.add('invisible','opacity-0');

                    modal.querySelector('.modal-container')
                        .classList.add('scale-95');

                    modal.querySelector('.modal-container')
                        .classList.remove('scale-100');
                });

            });

        });
    </script>
</body>
</html>