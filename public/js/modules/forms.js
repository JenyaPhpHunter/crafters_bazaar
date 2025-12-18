// // public/js/modules/forms.js
// // 100% стійкий до відсутності елементів + працює навіть при динамічному додаванні
//
// (function ($) {
//     "use strict";
//
//     const $doc = $(document);
//
//     const updateAllLabels = () => {
//         // Усі функції тепер захищені від undefined
//
//         // 1. Назва товару
//         const $title = $('#title');
//         if ($title.length) {
//             const hasTitle = $title.text().trim().length > 0;
//             $title.closest('.form-group-title-price').find('.form-label')
//                 .toggleClass('label-focused', hasTitle);
//         }
//
//         // 2. Ціна
//         const $price = $('#price');
//         if ($price.length) {
//             const hasPrice = $price.text().trim().length > 0;
//             $price.closest('.form-group-title-price').find('.form-label')
//                 .toggleClass('label-focused', hasPrice);
//         }
//
//         // 3. Кількість + термін виготовлення
//         const stock = parseInt($('#stock_balance').val() || 0);
//         const canProduce = $('#can_produce').is(':checked');
//         const term = parseInt($('#term_creation').val() || 0);
//         const hasQuantity = stock > 0 || (canProduce && term > 0);
//         $('.quantity-produce-container').closest('.mb-4').find('.form-label')
//             .toggleClass('label-focused', hasQuantity);
//
//         // 4. Кольори — головний винуватець
//         const $selectedColors = $('.color-circle.selected');
//         const hasColors = $selectedColors && $selectedColors.length > 0;
//         $('.product-variations').closest('.mb-4').find('.form-label')
//             .toggleClass('label-focused', hasColors);
//
//         // 5. Фото
//         const photoCount = parseInt($('#photoCount').text() || '0', 10);
//         $('#fileDropZone').closest('.mb-4').find('.form-label')
//             .toggleClass('label-focused', photoCount > 0);
//
//         // 6. Бренд
//         const brandVal = $('#selectedBrand').val();
//         const hasBrand = brandVal && brandVal.trim().length > 0;
//         $('#brand-section').find('.form-label')
//             .toggleClass('label-focused', hasBrand);
//
//         // 7. Вид товару
//         const kindVal = $('input[name="kind_product_id"]').val();
//         const hasKind = kindVal && kindVal.trim().length > 0;
//         $('.custom-dropdown[data-name="kind"]').closest('.form-section').find('.form-label')
//             .toggleClass('label-focused', hasKind);
//
//         // 8. Підвид товару
//         const subkindVal = $('input[name="sub_kind_product_id"]').val();
//         const hasSubkind = subkindVal && subkindVal.trim().length > 0;
//         $('.custom-dropdown[data-name="subkind"]').closest('.form-section').find('.form-label')
//             .toggleClass('label-focused', hasSubkind);
//     };
//
//     // === ТРИГЕРИ — все, що може змінити стан полів ===
//     $doc.on('input change keyup paste blur click field-updated', updateAllLabels);
//     $doc.on('click', '.qty-btn, #can_produce', updateAllLabels);
//
//     // Спостерігаємо за зміною кількості фото
//     const counter = document.getElementById('photoCount');
//     if (counter) {
//         const observer = new MutationObserver(updateAllLabels);
//         observer.observe(counter, { childList: true, characterData: true, subtree: true });
//     }
//
//     // Запускаємо після повного завантаження DOM + з маленькою затримкою (на випадок динамічного контенту)
//     $(function () {
//         setTimeout(updateAllLabels, 300);
//         // І ще раз через секунду — на 100% все встигне
//         setTimeout(updateAllLabels, 1000);
//     });
//
//     // Tooltips (Bootstrap 5)
//     document.addEventListener('DOMContentLoaded', function () {
//         const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
//         tooltipTriggerList.forEach(el =>Tooltip => {
//             new bootstrap.Tooltip(el, {
//                 delay: { show: 100, hide: 100 },
//                 trigger: 'hover focus'
//             });
//         });
//     });
//
// })(jQuery);

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
})(jQuery);
