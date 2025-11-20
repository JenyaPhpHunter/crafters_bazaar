(function ($) {
    "use strict";

    // УНІФІКОВАНА ПІДСВІТКА LABEL (працює на всіх формах + кольори)
    document.addEventListener('DOMContentLoaded', () => {
        const focusable = 'input, textarea, .dropdown-selected, .dropdown-search, ' +
            '.form-control-wide-center, .color-circle';

        document.querySelectorAll(focusable).forEach(el => {
            // Шукаємо label перед блоком (універсально)
            const block = el.closest('.form-group, .product-variations, .form-group-title-price, .custom-dropdown-wrapper, .quantity-produce-container');
            const label = block?.previousElementSibling;

            if (label && label.classList.contains('form-label')) {
                const add = () => label.classList.add('label-focused');
                const remove = () => {
                    // Для кольорів знімаємо тільки коли нічого не вибрано
                    if (el.classList.contains('color-circle')) {
                        if ($('.color-circle.selected').length === 0) {
                            label.classList.remove('label-focused');
                        }
                    } else {
                        label.classList.remove('label-focused');
                    }
                };

                el.addEventListener('focusin', add);
                el.addEventListener('focusout', remove);

                // Клік по кольору теж підсвічує label
                if (el.classList.contains('color-circle')) {
                    el.addEventListener('click', () => {
                        label.classList.toggle('label-focused', $('.color-circle.selected').length > 0);
                    });
                }
            }
        });
    });

    // ЕКСПОРТ
    window.Learts = window.Learts || {};
    Learts.forms = { init: () => {} };

})(jQuery);
