// public/js/modules/forms.js

(function ($) {
    "use strict";

    const updateAllLabels = () => {
        // 1. НАЗВА ТОВАРУ
        const titleText = $('#title').text().trim();
        $('#title').closest('.form-group-title-price').find('.form-label').toggleClass('label-focused', titleText.length > 0);

        // 2. Вартість
        const priceText = $('#price').text().trim();
        $('#price').closest('.form-group-title-price').find('.form-label').toggleClass('label-focused', priceText.length > 0);

        // 3. Кількість + Термін виготовлення
        const stock = parseInt($('#stock_balance').val() || 0);
        const canProduce = $('#can_produce').is(':checked');
        const term = parseInt($('#term_creation').val() || 0);
        const hasQuantity = stock > 0 || (canProduce && term > 0);
        $('.quantity-produce-container').closest('.mb-4').find('.form-label').toggleClass('label-focused', hasQuantity);

        // 4. КОЛЬОРИ
        const hasColors = $('.color-circle.selected').length > 0;
        $('.product-variations').closest('.mb-4').find('.form-label').toggleClass('label-focused', hasColors);

        // 5. ФОТО
        const photoCount = parseInt($('#photoCount').text() || '0');
        $('#fileDropZone').closest('.mb-4').find('.form-label').toggleClass('label-focused', photoCount > 0);

        // 6. БРЕНД
        const hasBrand = $('#selectedBrand').val()?.trim().length > 0;
        $('#brand-section').find('.form-label').toggleClass('label-focused', hasBrand);

        // 7. ВИД ТОВАРУ
        const kindValue = $('input[name="kind_product_id"]').val()?.trim();
        $('.custom-dropdown[data-name="kind"]').closest('.form-section').find('.form-label')
            .toggleClass('label-focused', kindValue.length > 0);

        // 8. ПІДВИД ТОВАРУ
        const subkindValue = $('input[name="sub_kind_product_id"]').val()?.trim();
        $('.custom-dropdown[data-name="subkind"]').closest('.form-section').find('.form-label')
            .toggleClass('label-focused', subkindValue.length > 0);

        // 9. ДОДАТКОВА ІНФОРМАЦІЯ
        const additionalText = $('#additional_information').val()?.trim();
        const hasAdditionalInfo = additionalText.length > 0;
        $('#additional_information').closest('.form-field').find('.form-label')
            .toggleClass('label-focused', hasAdditionalInfo);
    };

    // === ТРИГЕРИ ===
    $(document).on('input change keyup paste blur click field-updated', updateAllLabels);

    // Клік по кнопках кількості
    $(document).on('click', '.qty-btn, #can_produce', updateAllLabels);

    // Drag & drop фото
    const observer = new MutationObserver(updateAllLabels);
    const counter = document.getElementById('photoCount');
    if (counter) observer.observe(counter, { childList: true, characterData: true });

    // Ініціалізація при завантаженні
    $(document).ready(function () {
        setTimeout(updateAllLabels, 200);
    });


    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(trigger => {
            new bootstrap.Tooltip(trigger, {
                delay: { show: 100, hide: 100 },
                trigger: 'hover focus'
            });
        });
    });

    // Живе оновлення для textarea додаткової інформації
    $(document).on('input', '#additional_information', function () {
        const hasText = $(this).val().trim().length > 0;
        $(this).closest('.form-field').find('.form-label').toggleClass('label-focused', hasText);
        $(this).toggleClass('has-content', hasText);

        // Автоматичне розширення при введенні (якщо ще не у фокусі)
        if (hasText && !$(this).is(':focus')) {
            $(this).css('height', '200px');
        }
    });
})(jQuery);
