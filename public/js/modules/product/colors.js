// public/js/modules/product/colors.js
// ФІНАЛЬНА ВЕРСІЯ — підсвітка лейбла працює з першого кліку + все стабільно

$(document).on('click', '.color-circle', function () {
    const $circle = $(this);
    const id = $circle.data('id');

    // Перемикаємо клас
    $circle.toggleClass('selected');

    // Додаємо/видаляємо hidden input
    if ($circle.hasClass('selected')) {
        if (!$('input[name="color_ids[]"][value="' + id + '"]').length) {
            $('<input>', {
                type: 'hidden',
                name: 'color_ids[]',
                value: id
            }).appendTo($circle.closest('.product-variations'));

            // Анімація bounce
            $circle.addClass('animate__animated animate__bounceIn');
            setTimeout(() => $circle.removeClass('animate__animated animate__bounceIn'), 600);
        }
    } else {
        $('input[name="color_ids[]"][value="' + id + '"]').remove();
    }

    // Оновлюємо підсвітку лейбла + тригер для валідації
    updateColorLabelState();
    $(document).trigger('field-updated');
});

// === Функція — оновлює стан лейбла (підсвітка бірюзовим) ===
function updateColorLabelState() {
    const container = document.querySelector('.color-circles')?.closest('.mb-5');
    if (!container) return;

    const label = container.querySelector('.form-label');
    const hasSelected = container.querySelector('.color-circle.selected');

    if (hasSelected && label) {
        label.classList.add('label-focused');
    } else if (label) {
        label.classList.remove('label-focused');
    }
}

// При завантаженні сторінки — перевіряємо, чи вже є вибрані кольори (наприклад, при edit)
$(document).ready(function () {
    updateColorLabelState();

    if ($('.color-circle.selected').length > 0) {
        $(document).trigger('field-updated');
    }
});
