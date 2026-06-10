<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    
</head>
<body class="bg-gray-100">

    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 pt-4">
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    </div>
@endif

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 pt-4">
        <x-alert type="danger">
            {{ session('error') }}
        </x-alert>
    </div>
@endif
 @yield('content')
    
    <script>

    function openModal(id) {

        const modal = document.getElementById(id);

        if (!modal) return;

        modal.classList.remove(
            'invisible',
            'opacity-0'
        );

        const container =
            modal.querySelector('.modal-container');

        container.classList.remove('scale-95');

        container.classList.add('scale-100');
    }

    function closeModal(id) {

        const modal = document.getElementById(id);

        if (!modal) return;

        modal.classList.add(
            'opacity-0'
        );

        const container =
            modal.querySelector('.modal-container');

        container.classList.remove('scale-100');

        container.classList.add('scale-95');

        setTimeout(() => {

            modal.classList.add('invisible');

        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {

        // tombol buka modal
        document
            .querySelectorAll('[data-modal-target]')
            .forEach(button => {

                button.addEventListener('click', () => {

                    openModal(
                        button.dataset.modalTarget
                    );

                });

            });

        // tombol close modal
        document
            .querySelectorAll('.close-modal')
            .forEach(button => {

                button.addEventListener('click', () => {

                    const modal =
                        button.closest('.modal-overlay');

                    closeModal(modal.id);

                });

            });

        // klik backdrop
        document
            .querySelectorAll('.modal-overlay')
            .forEach(modal => {

                modal.addEventListener('click', e => {

                    if (e.target === modal) {

                        closeModal(modal.id);

                    }

                });

            });

        // tombol ESC
        document.addEventListener('keydown', e => {

            if (e.key === 'Escape') {

                document
                    .querySelectorAll('.modal-overlay')
                    .forEach(modal => {

                        if (
                            !modal.classList.contains(
                                'invisible'
                            )
                        ) {

                            closeModal(modal.id);

                        }

                    });

            }

        });

    });

</script>

@if(old('modal'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        openModal('{{ old('modal') }}');
    });
</script>
@endif
<script>

document.addEventListener('submit', function(e) {

    const form = e.target;

    const button = form.querySelector(
        '[data-loading="true"]'
    );

    if (!button) return;

    button.disabled = true;

    button.classList.add(
        'opacity-75',
        'cursor-not-allowed'
    );

    const text =
        button.querySelector('.btn-text');

    const spinner =
        button.querySelector('.btn-spinner');

    if (text) {

        text.textContent =
            button.dataset.loadingText;

    }

    if (spinner) {

        spinner.classList.remove('hidden');

    }

});

</script>

<script>

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.alert-message')
        .forEach(alert => {

            // Muncul
            setTimeout(() => {

                alert.classList.remove(
                    'opacity-0',
                    '-translate-y-3'
                );

            }, 100);

            // Auto hide setelah 4 detik
            setTimeout(() => {

                hideAlert(alert);

            }, 4000);

        });

    document.querySelectorAll('.close-alert')
        .forEach(button => {

            button.addEventListener('click', () => {

                hideAlert(
                    button.closest('.alert-message')
                );

            });

        });

});

function hideAlert(alert) {

    alert.classList.add(
        'opacity-0',
        '-translate-y-3'
    );

    setTimeout(() => {

        alert.remove();

    }, 300);

}

</script>
</body>
</html>