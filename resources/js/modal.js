export function initModal() {

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

        modal.classList.add('opacity-0');

        const container =
            modal.querySelector('.modal-container');

        container.classList.remove('scale-100');
        container.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('invisible');
        }, 300);
    }

    window.openModal = openModal;
    window.closeModal = closeModal;

    document
        .querySelectorAll('[data-modal-target]')
        .forEach(button => {

            button.addEventListener('click', () => {

                openModal(button.dataset.modalTarget);

            });

        });

    document
        .querySelectorAll('.close-modal')
        .forEach(button => {

            button.addEventListener('click', () => {

                const modal =
                    button.closest('.modal-overlay');

                closeModal(modal.id);

            });

        });

    document
        .querySelectorAll('.modal-overlay')
        .forEach(modal => {

            modal.addEventListener('click', e => {

                if (e.target === modal) {
                    closeModal(modal.id);
                }

            });

        });

    document.addEventListener('keydown', e => {

        if (e.key === 'Escape') {

            document
                .querySelectorAll('.modal-overlay')
                .forEach(modal => {

                    if (
                        !modal.classList.contains('invisible')
                    ) {
                        closeModal(modal.id);
                    }

                });

        }

    });

    const oldModal = document.body.dataset.oldModal;

    if (oldModal) {
        openModal(oldModal);
    }

}
