// public/js/modules/forms.js

(function ($) {
    "use strict";

    // Універсальна функція оновлення всіх плаваючих міток
    const updateAllLabels = () => {
        // 1. Назва товару
        const titleText = $('#title').text().trim();
        $('#title').closest('.form-field').find('.form-label').toggleClass('label-focused', titleText.length > 0);

        // 2. Вартість
        const priceText = $('#price').text().trim();
        $('#price').closest('.form-field').find('.form-label').toggleClass('label-focused', priceText.length > 0);

        // 3–11. Всі інші поля (залишаємо як є — вони короткі)
        const stock = parseInt($('#stock_balance').val() || 0);
        const canProduce = $('#can_produce').is(':checked');
        const term = parseInt($('#term_creation').val() || 0);
        $('.quantity-produce-container').closest('.mb-4').find('.form-label').toggleClass('label-focused', stock > 0 || (canProduce && term > 0));

        $('.product-variations').closest('.mb-4').find('.form-label').toggleClass('label-focused', $('.color-circle.selected').length > 0);
        $('#fileDropZone').closest('.mb-4').find('.form-label').toggleClass('label-focused', parseInt($('#photoCount').text() || '0') > 0);
        $('#brand-section').find('.form-label').toggleClass('label-focused', $('#selectedBrand').val()?.trim().length > 0);

        $('.custom-dropdown[data-name="kind"]').closest('.form-section').find('.form-label').toggleClass('label-focused', $('input[name="kind_product_id"]').val()?.trim().length > 0);
        $('.custom-dropdown[data-name="subkind"]').closest('.form-section').find('.form-label').toggleClass('label-focused', $('input[name="sub_kind_product_id"]').val()?.trim().length > 0);

        $('#additional_information').closest('.form-field').find('.form-label').toggleClass('label-focused', $('#additional_information').val()?.trim().length > 0);
        $('#tags').closest('.form-field').find('.form-label').toggleClass('label-focused', $('#tags').val()?.trim().length > 0);
        $('#social_links').closest('.form-field').find('.form-label').toggleClass('label-focused', $('#social_links').val()?.trim().length > 0);
    };

    // Автоматичне розширення полів Назва та Вартість
    const autoResize = (element) => {
        if (!element) return;
        element.style.height = 'auto';
        element.style.height = (element.scrollHeight + 10) + 'px';
    };

    // Події
    $(document).on('input change keyup paste blur click field-updated', updateAllLabels);
    $(document).on('click', '.qty-btn, #can_produce', updateAllLabels);

    $(document).on('input', '#title, #price', function () {
        autoResize(this);
    });

    // Спостереження за кількістю фото
    const observer = new MutationObserver(updateAllLabels);
    const counter = document.getElementById('photoCount');
    if (counter) observer.observe(counter, { childList: true, characterData: true });

    // Ініціалізація
    $(document).ready(function () {
        setTimeout(() => {
            autoResize(document.getElementById('title'));
            autoResize(document.getElementById('price'));
            updateAllLabels();
        }, 300);

        // Bootstrap tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(trigger => new bootstrap.Tooltip(trigger, { delay: { show: 100, hide: 100 }, trigger: 'hover focus' }));
    });

})(jQuery);
