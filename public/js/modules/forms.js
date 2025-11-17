(function ($) {
    "use strict";

    // === УНІФІКОВАНА ПІДСВІТКА LABEL ПРИ ФОКУСІ ===
    document.addEventListener('DOMContentLoaded', () => {
        // Вибираємо всі елементи, які можуть отримувати фокус
        const focusableElements = document.querySelectorAll('input, textarea, .dropdown-selected, .dropdown-search, .form-control-wide-center, .color-circle');
        focusableElements.forEach(element => {
            // Знаходимо найближчий label
            const label = element.closest('.product-variations, .form-group, .form-group-title-price, .custom-dropdown-wrapper')?.previousElementSibling;
            if (label && label.classList.contains('form-label')) {
                // Додаємо клас label-focused при фокусі
                element.addEventListener('focus', () => {
                    label.classList.add('label-focused');
                });
                // Знімаємо клас при втраті фокусу
                element.addEventListener('blur', () => {
                    label.classList.remove('label-focused');
                });
                // Для .color-circle додаємо label-focused при кліку
                if (element.classList.contains('color-circle')) {
                    element.addEventListener('click', () => {
                        label.classList.add('label-focused');
                    });
                }
            }
        });
    });

    // === ПІДСВІТКА LABEL ДЛЯ БЛОКУ КОЛЬОРІВ ===
    $(document).on('focusin click', '.color-circle', function () {
        $('#color-label').addClass('label-focused');
    });

    $(document).on('focusout', '.color-circle', function () {
        // Знімаємо клас тільки якщо жоден кружечок не у фокусі/вибраний
        if ($('.color-circle:focus').length === 0 && $('.color-circle.selected').length === 0) {
            $('#color-label').removeClass('label-focused');
        }
    });

    // === CUSTOM DROPDOWN: ФУНКЦІОНАЛ ===
    document.addEventListener('DOMContentLoaded', () => {
        let kindDropdown = null;
        let subkindDropdown = null;

        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            const wrapper = dropdown.closest('.custom-dropdown-wrapper');
            const section = wrapper.closest('.form-section');
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelector('.dropdown-options');
            const search = dropdown.querySelector('.dropdown-search');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            // Зберігаємо посилання на dropdown'и
            if (dropdown.getAttribute('data-name') === 'kind') kindDropdown = dropdown;
            if (dropdown.getAttribute('data-name') === 'subkind') subkindDropdown = dropdown;

            // === ФОКУС ===
            const handleFocus = () => {
                wrapper.classList.add('has-focus');
                if (section) section.classList.add('focused');
            };
            const handleBlur = () => {
                wrapper.classList.remove('has-focus');
                if (section) section.classList.remove('focused');
            };

            // === ВІДКРИТТЯ / ЗАКРИТТЯ ===
            selected.addEventListener('click', () => {
                const isOpen = dropdown.classList.contains('open');
                dropdown.classList.toggle('open');
                if (dropdown.classList.contains('open') && !isOpen) {
                    search.classList.add('active');
                    search.style.display = 'block';
                    search.focus();

                    // Оновлюємо фільтр підвидів при відкритті
                    if (dropdown === subkindDropdown && kindDropdown) {
                        const kindId = kindDropdown.querySelector('input[type="hidden"]').value;
                        const query = search.value.toLowerCase();
                        options.querySelectorAll('li').forEach(option => {
                            const text = option.getAttribute('data-title').toLowerCase();
                            const optionKindId = option.getAttribute('data-kind');
                            const matchesSearch = text.includes(query);
                            const matchesKind = !kindId || optionKindId === kindId;
                            option.style.display = (matchesSearch && matchesKind) ? 'flex' : 'none';
                        });
                    }
                } else {
                    search.classList.remove('active');
                    search.style.display = 'none';
                }
            });

            selected.addEventListener('focus', handleFocus);
            selected.addEventListener('blur', handleBlur);
            search.addEventListener('focus', handleFocus);
            search.addEventListener('blur', handleBlur);

            // === ПОШУК ===
            search.addEventListener('input', () => {
                const query = search.value.toLowerCase();
                const kindId = kindDropdown ? kindDropdown.querySelector('input[type="hidden"]').value : null;

                options.querySelectorAll('li').forEach(option => {
                    const text = option.getAttribute('data-title').toLowerCase();
                    const optionKindId = option.getAttribute('data-kind') || null;

                    const matchesSearch = text.includes(query);
                    const matchesKind = !kindId || optionKindId === kindId;

                    option.style.display = (matchesSearch && matchesKind) ? 'flex' : 'none';
                });
            });

            // === КЛІК ПО ОПЦІЯХ: РОЗДІЛЕНА ЛОГІКА ===
            if (dropdown.getAttribute('data-name') === 'kind') {
                // --- ВИБІР ВИДУ ---
                options.querySelectorAll('li').forEach(option => {
                    option.addEventListener('click', () => {
                        selected.textContent = option.textContent;
                        hiddenInput.value = option.getAttribute('data-value');
                        selected.classList.add('selected-value');
                        dropdown.classList.remove('open');
                        search.classList.remove('active');
                        search.value = '';
                        search.style.display = 'none';
                        selected.focus();

                        // Фільтрація підвидів
                        if (subkindDropdown) {
                            const kindId = hiddenInput.value;
                            const subkindOptions = subkindDropdown.querySelectorAll('li');
                            subkindOptions.forEach(subOption => {
                                const subKindId = subOption.getAttribute('data-kind');
                                subOption.style.display = kindId === subKindId ? 'flex' : 'none';
                            });

                            // Скидаємо підвид, якщо не відповідає
                            const subkindHidden = subkindDropdown.querySelector('input[type="hidden"]');
                            const subkindSelected = subkindDropdown.querySelector('.dropdown-selected');
                            if (subkindHidden.value && !Array.from(subkindOptions).some(opt =>
                                opt.getAttribute('data-value') === subkindHidden.value && opt.style.display !== 'none'
                            )) {
                                subkindHidden.value = '';
                                subkindSelected.textContent = 'Оберіть підвид товару';
                                subkindSelected.classList.remove('selected-value');
                            }
                        }
                    });
                });
            } else if (dropdown.getAttribute('data-name') === 'subkind') {
                // --- ВИБІР ПІДВИДУ + АВТОПІДСТАНОВКА ВИДУ ---
                options.querySelectorAll('li').forEach(option => {
                    option.addEventListener('click', () => {
                        selected.textContent = option.textContent;
                        hiddenInput.value = option.getAttribute('data-value');
                        selected.classList.add('selected-value');
                        dropdown.classList.remove('open');
                        search.classList.remove('active');
                        search.value = '';
                        search.style.display = 'none';
                        selected.focus();

                        // АВТОПІДСТАНОВКА ВИДУ
                        if (kindDropdown && !kindDropdown.querySelector('input[type="hidden"]').value) {
                            const subKindId = option.getAttribute('data-kind');
                            if (subKindId) {
                                const kindOptions = kindDropdown.querySelector('.dropdown-options');
                                const kindOption = kindOptions.querySelector(`li[data-value="${subKindId}"]`);
                                if (kindOption) {
                                    const kindSelected = kindDropdown.querySelector('.dropdown-selected');
                                    const kindHidden = kindDropdown.querySelector('input[type="hidden"]');

                                    kindSelected.textContent = kindOption.textContent;
                                    kindHidden.value = subKindId;
                                    kindSelected.classList.add('selected-value');

                                    // Оновлюємо фільтр підвидів
                                    const subkindOptions = subkindDropdown.querySelectorAll('li');
                                    subkindOptions.forEach(subOption => {
                                        const subOptionKindId = subOption.getAttribute('data-kind');
                                        subOption.style.display = subKindId === subOptionKindId ? 'flex' : 'none';
                                    });
                                }
                            }
                        }
                    });
                });
            }

            // === ЗАКРИТТЯ ПРИ КЛІКУ ПОЗА ===
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                    search.classList.remove('active');
                    search.value = '';
                    search.style.display = 'none';
                    wrapper.classList.remove('has-focus');
                    if (section) section.classList.remove('focused');
                }
            });

            // === ІНІЦІАЛІЗАЦІЯ: old() значення ===
            if (hiddenInput.value) {
                const initialOption = Array.from(options.querySelectorAll('li'))
                    .find(opt => opt.getAttribute('data-value') === hiddenInput.value);
                if (initialOption) {
                    selected.textContent = initialOption.textContent;
                    selected.classList.add('selected-value');
                }
            }
        });

        // === АВТОПІДСТАНОВКА ВИДУ ПРИ old('sub_kind_product_id') ===
        if (subkindDropdown && kindDropdown) {
            const subkindHidden = subkindDropdown.querySelector('input[type="hidden"]');
            const kindHidden = kindDropdown.querySelector('input[type="hidden"]');

            if (subkindHidden.value && !kindHidden.value) {
                const selectedLi = subkindDropdown.querySelector(`li[data-value="${subkindHidden.value}"]`);
                if (selectedLi) {
                    const kindId = selectedLi.getAttribute('data-kind');
                    const kindLi = kindDropdown.querySelector(`li[data-value="${kindId}"]`);
                    if (kindLi) {
                        const kindSelected = kindDropdown.querySelector('.dropdown-selected');
                        kindSelected.textContent = kindLi.textContent;
                        kindHidden.value = kindId;
                        kindSelected.classList.add('selected-value');
                    }
                }
            }

            // Ініціалізація фільтрації при завантаженні
            if (kindHidden.value) {
                const subkindOptions = subkindDropdown.querySelectorAll('li');
                subkindOptions.forEach(subOption => {
                    const subKindId = subOption.getAttribute('data-kind');
                    subOption.style.display = kindHidden.value === subKindId ? 'flex' : 'none';
                });
            }
        }
    });

    // === ЕКСПОРТ ===
    window.Learts = window.Learts || {};
    Learts.forms = Learts.forms || {};
    Learts.forms.init = function () {};
    $(document).ready(function () {
        Learts.forms.init();
    });

})(jQuery);
