// public/js/modules/forms.js
(function ($) {
    "use strict";

    const updateAllLabels = () => {
        // Назва товару
        const titleText = $('#title').val()?.trim() || '';
        $('#title').closest('.form-field').find('.form-label').toggleClass('label-focused', titleText.length > 0);

        // Вартість
        const priceText = $('#price').val()?.trim() || '';
        $('#price').closest('.form-field').find('.form-label').toggleClass('label-focused', priceText.length > 0);

        // Кількість та терміни
        const stock = parseInt($('#stock_balance').val() || 0);
        const canProduce = $('#can_produce').is(':checked');
        const term = parseInt($('#term_creation').val() || 0);
        $('.quantity-produce-container').closest('.mb-4').find('.form-label').toggleClass('label-focused', stock > 0 || (canProduce && term > 0));

        // Колір
        $('.product-variations').closest('.mb-4').find('.form-label').toggleClass('label-focused', $('.color-circle.selected').length > 0);

        // Фото
        $('#fileDropZone').closest('.mb-4').find('.form-label').toggleClass('label-focused', parseInt($('#photoCount').text() || '0') > 0);

        // Бренд
        $('#brand-section').find('.form-label').toggleClass('label-focused', $('#selectedBrand').val()?.trim().length > 0);

        // Вид та підвид (тільки hidden input, не search поле)
        $('.custom-dropdown[data-name="kind"]').closest('.form-section').find('.form-label')
            .toggleClass('label-focused', $('input[name="kind_product_id"]').val()?.trim().length > 0);
        $('.custom-dropdown[data-name="subkind"]').closest('.form-section').find('.form-label')
            .toggleClass('label-focused', $('input[name="sub_kind_product_id"]').val()?.trim().length > 0);

        // Додаткова інформація
        $('#additional_information').closest('.form-field').find('.form-label')
            .toggleClass('label-focused', $('#additional_information').val()?.trim().length > 0);

        $('#tags').closest('.form-field').find('.form-label')
            .toggleClass('label-focused', $('#tags').val()?.trim().length > 0);

        $('#social_links').closest('.form-field').find('.form-label')
            .toggleClass('label-focused', $('#social_links').val()?.trim().length > 0);
    };

    const autoResize = (element) => {
        if (!element) return;
        element.style.height = 'auto';
        element.style.height = (element.scrollHeight + 10) + 'px';
    };

    $(document).on('input change keyup paste blur click field-updated', updateAllLabels);
    $(document).on('input', '#title, #price', function () { autoResize(this); });

    // Спостереження за кількістю фото
    const observer = new MutationObserver(updateAllLabels);
    const counter = document.getElementById('photoCount');
    if (counter) observer.observe(counter, { childList: true, characterData: true });

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
