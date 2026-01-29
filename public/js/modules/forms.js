// public/js/modules/forms.js
(function ($) {
    "use strict";

    const updateAllLabels = () => {
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
        $('#content').closest('.form-field').find('.form-label')
            .toggleClass('label-focused', $('#content').val()?.trim().length > 0);

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

    // Автоматичне підсвічування мітки для contenteditable полів (Назва та Вартість)
    document.querySelectorAll('.title-price-input').forEach(field => {
        const updateLabel = () => {
            const hasText = field.textContent.trim().length > 0;
            field.classList.toggle('has-content', hasText);

            // Підсвічуємо мітку бірюзовим, коли є текст
            const wrapper = field.closest('.title-price-wrapper');
            if (wrapper) {
                const label = wrapper.querySelector('.form-label');
                if (label) {
                    label.classList.toggle('label-focused', hasText || field === document.activeElement);
                }
            }
        };

        // При вводі
        field.addEventListener('input', updateLabel);
        field.addEventListener('paste', () => setTimeout(updateLabel, 0));
        field.addEventListener('blur', updateLabel);

        // При завантаженні — перевіряємо old()
        updateLabel();
    });

})(jQuery);
