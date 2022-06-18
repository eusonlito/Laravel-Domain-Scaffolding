(function () {
    'use strict';

    document.querySelectorAll('input[data-timezone]').forEach(element => {
        if (element.value) {
            return;
        }

        element.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    });
})();
