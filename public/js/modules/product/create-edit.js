
// public/js/modules/product/create-edit.js
(function ($) {
    "use strict";

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

    // === ТІЛЬКИ ЦИФРИ В ПОЛІ "ВАРТІСТЬ" ===
    $(document).on('input paste', '[data-only-numbers="true"]', function (e) {
        let value = $(this).text().replace(/[^0-9]/g, '');
        $(this).text(value);
        $('#price-hidden').val(value);
    });

    // === МНОЖИННИЙ ВИБІР КОЛЬОРІВ ===
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

        // Підсвітка label
        const hasSelected = $('.color-circle.selected').length > 0;
        $circle.closest('.product-variations').prev('.form-label').toggleClass('label-focused', hasSelected);
    });

    $(document).on('keydown', '.color-circle', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).trigger('click');
        }
    });

    // === КАТЕГОРІЇ ===
    $(document).on('click', '.category-container', function () {
        const categoryId = this.id.split('-')[1];
        const $sub = $('#subcategories-' + categoryId);
        $sub.toggleClass('subcategories-visible')
            .css('opacity', $sub.hasClass('subcategories-visible') ? '1' : '0');
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

    // НОВЕ: ІНІЦІАЛІЗАЦІЯ TOOLTIP ДЛЯ ІКОНКИ КОЛЬОРІВ
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    // ===================================================================
    // ФІНАЛЬНИЙ КОМПАКТНИЙ ЗАВАНТАЖУВАЧ ФОТО + КРАСИВИЙ ЛІЧИЛЬНИК (2025)
    // ===================================================================
    document.addEventListener('DOMContentLoaded', function () {
        const dropZone      = document.getElementById('fileDropZone');
        const fileInput     = document.getElementById('product_photo');
        const countSpan     = document.getElementById('photoCount');
        const badgeSpan     = document.getElementById('photoCountBadge');
        const badge         = document.getElementById('photoCounterBadge');  // новий ID!
        const errorBox      = document.getElementById('uploadError');

        if (!dropZone || !fileInput || !countSpan || !badge) return;

        let uploadedCount = 0;
        const MAX_FILES = 10;

        // Оновлюємо обидва лічильники + анімація бейджа
        function updateCounter() {
            countSpan.textContent = uploadedCount;
            badgeSpan.textContent = uploadedCount;

            if (uploadedCount > 0) {
                badge.classList.add('show');
            } else {
                badge.classList.remove('show');
            }
        }

        function showError(msg) {
            if (errorBox) {
                errorBox.textContent = msg;
                errorBox.style.display = 'block';
                setTimeout(() => errorBox.style.display = 'none', 5000);
            }
        }

        function handleFiles(files) {
            if (uploadedCount >= MAX_FILES) {
                showError('Максимум 10 фото');
                return;
            }

            const toAdd = files.slice(0, MAX_FILES - uploadedCount);
            let valid = true;

            for (const file of toAdd) {
                if (!file.type.startsWith('image/')) {
                    showError('Дозволені тільки зображення');
                    valid = false;
                }
                if (file.size > 10 * 1024 * 1024) {
                    showError(`${file.name} — більше 10 МБ`);
                    valid = false;
                }
            }

            if (valid) {
                uploadedCount += toAdd.length;
                updateCounter();
            }
        }

        // Блокування відкриття файлів у новій вкладці
        ['dragover', 'drop'].forEach(ev => {
            dropZone.addEventListener(ev, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Ефекти drag & drop
        dropZone.addEventListener('dragenter', () => dropZone.classList.add('drag-over'));
        dropZone.addEventListener('dragover',  () => dropZone.classList.add('drag-over'));
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
        dropZone.addEventListener('drop', e => {
            dropZone.classList.remove('drag-over');
            handleFiles(Array.from(e.dataTransfer.files));
        });

        // Клік по блоку = вибір файлів
        dropZone.addEventListener('click', () => fileInput.click());

        // Зміна в input
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                handleFiles(Array.from(fileInput.files));
            }
        });

        // Ініціалізація
        updateCounter();
    });
})(jQuery);
