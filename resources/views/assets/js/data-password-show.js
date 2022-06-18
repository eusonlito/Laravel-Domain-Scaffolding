(function () {
    'use strict';

    document.querySelectorAll('[data-password-show]').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const field = document.querySelector(element.dataset.passwordShow);

            if (!field) {
                return;
            }

            const isHidden = field.type === 'password';

            field.type = isHidden ? 'text' : 'password';

            element.querySelector('i:first-child').className = isHidden ? 'bx bx-show' : 'bx bx-hide';

            field.focus();
        }, false);
    });
})();
