$(document).on('click', '.color-circle', function () {
    const $circle = $(this);
    const id = $circle.data('id');

    $circle.toggleClass('selected');

    if ($circle.hasClass('selected')) {
        if (!$('input[name="color_ids[]"][value="' + id + '"]').length) {
            $('<input>', {
                type: 'hidden',
                name: 'color_ids[]',
                value: id
            }).appendTo($circle.closest('.product-variations'));

            $circle.addClass('animate__animated animate__bounceIn');
            setTimeout(() => $circle.removeClass('animate__animated animate__bounceIn'), 600);
        }
    } else {
        $('input[name="color_ids[]"][value="' + id + '"]').remove();
    }

    // Тільки тригер — логіка в forms.js
    $(document).trigger('field-updated');
});

$(document).ready(function () {
    if ($('.color-circle.selected').length > 0) {
        $(document).trigger('field-updated');
    }
});
