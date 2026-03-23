$(document).on('click', '.qty-btn', function (e) {
    e.preventDefault();

    const $input = $(this).siblings('.qty-input');
    const id = $input.attr('id');
    let value = parseInt($input.val()) || 0;
    const isPlus = $(this).hasClass('plus');

    const minValue = 0; // ← для всіх полів мінімум 0

    let newValue = isPlus ? value + 1 : value - 1;
    if (newValue < minValue) newValue = minValue;

    $input.val(newValue).trigger('input');
});

$(document).on('input', '.qty-input', function () {
    const id = $(this).attr('id');
    let value = parseInt($(this).val()) || 0;

    if (value < 0) value = 0; // ← для всіх полів мінімум 0

    $(this).val(value);
});

$(function () {
    const $cb = $('#can_produce');
    const $container = $('#term_creation_container');
    const $input = $('#term_creation');

    const toggleTermField = () => {
        if ($cb.is(':checked')) {
            $container
                .show()
                .addClass('animate__fadeIn animate__faster');
            // ← прибрали примусове встановлення 1
        } else {
            $container.hide();
            $input.val(0);
        }
    };

    toggleTermField();
    $cb.on('change', toggleTermField);
});
