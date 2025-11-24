// public/js/modules/product/price-input.js
$(document).on('input paste blur', '#price', function () {
    let value = $(this).text().replace(/[^0-9]/g, '');
    $(this).text(value);
    $('#price-hidden').val(value);

    // Тригеримо оновлення label
    $(document).trigger('field-updated');
});
