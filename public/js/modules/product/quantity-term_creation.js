// === КНОПКИ КІЛЬКОСТІ + / – (з захистом від 0) ===
$(document).on('click', '.qty-btn', function (e) {
    e.preventDefault();

    const $input = $(this).siblings('.qty-input');
    let value = parseInt($input.val()) || 0;
    const isPlus = $(this).hasClass('plus');
    let newValue = isPlus ? value + 1 : value - 1;

    // Визначаємо мінімальне значення залежно від поля
    const minValue = $input.attr('id') === 'stock_balance' ? 1 : 1; // обидва поля — мінімум 1

    if (newValue < minValue) {
        newValue = minValue;
    }

    $input.val(newValue).trigger('change');
});

// === ЗАБОРОНА ВВОДУ 0 вручну через клавіатуру ===
$(document).on('input', '.qty-input', function () {
    let value = parseInt($(this).val()) || 0;

    const minValue = $(this).attr('id') === 'stock_balance' ? 1 : 1;

    if (value < minValue) {
        $(this).val(minValue);
    }
});

// === ТЕРМІН ВИГОТОВЛЕННЯ + ЗАХИСТ ВІД 0 ===
$(function () {
    const $cb = $('#can_produce');
    const $container = $('#term_creation_container');
    const $input = $('#term_creation');

    const toggleTermField = () => {
        if ($cb.is(':checked')) {
            $container.show().addClass('animate__fadeIn animate__faster');
            // Якщо поле було 0 — ставимо 1
            if (parseInt($input.val()) < 1) {
                $input.val(1);
            }
        } else {
            $container.hide();
            $input.val(0); // обнуляємо, як і було раніше
        }
    };

    // Ініціалізація при завантаженні
    if ($cb.is(':checked')) {
        if (parseInt($input.val()) < 1) {
            $input.val(1);
        }
    }

    toggleTermField();
    $cb.on('change', toggleTermField);
});

// === ТЕРМІН ВИГОТОВЛЕННЯ ===
$(function () {
    const $cb = $('#can_produce');
    const $container = $('#term_creation_container');
    const $input = $container.find('input[name="term_creation"]');

    const toggle = () => {
        if ($cb.is(':checked')) {
            $container.css('display', 'block').addClass('animate__fadeIn animate__faster');
            $input.val('0');
        } else {
            $container.css('display', 'none');
            $input.val('0');
        }
    };

    if (parseInt($input.val()) > 0) $cb.prop('checked', true);
    toggle();
    $cb.on('change', toggle);
});
