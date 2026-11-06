export function initLoadingButton() {

    document.addEventListener('submit', function (e) {

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

}