export function initAlert() {

    document.querySelectorAll('.alert-message')
        .forEach(alert => {

            setTimeout(() => {

                alert.classList.remove(
                    'opacity-0',
                    '-translate-y-3'
                );

            }, 100);

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

}

function hideAlert(alert) {

    alert.classList.add(
        'opacity-0',
        '-translate-y-3'
    );

    setTimeout(() => {

        alert.remove();

    }, 300);

}