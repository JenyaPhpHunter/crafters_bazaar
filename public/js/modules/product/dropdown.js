(function ($) {
    "use strict";

    document.addEventListener('DOMContentLoaded', () => {
        let kindDropdown = null;
        let subkindDropdown = null;

        // === Оновлення стану хрестика для виду ===
        const updateKindState = () => {
            const kind = document.querySelector('.custom-dropdown[data-name="kind"]');
            if (!kind) return;

            const selected = kind.querySelector('.dropdown-selected');
            const textSpan = selected.querySelector('.selected-text');
            const hidden   = kind.querySelector('input[type="hidden"]');

            if (hidden.value) {
                selected.classList.add('has-value', 'selected-value');
                if (!textSpan.textContent.trim() || textSpan.textContent.trim() === 'Оберіть вид товару') {
                    const option = kind.querySelector(`li[data-value="${hidden.value}"]`);
                    if (option) textSpan.textContent = option.textContent.trim();
                }
            } else {
                selected.classList.remove('has-value', 'selected-value');
                textSpan.textContent = 'Оберіть вид товару';
            }
        };

        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            const wrapper     = dropdown.closest('.custom-dropdown-wrapper');
            const section     = wrapper.closest('.form-section');
            const selected    = dropdown.querySelector('.dropdown-selected');
            const options     = dropdown.querySelector('.dropdown-options');
            const search      = dropdown.querySelector('.dropdown-search');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            if (dropdown.getAttribute('data-name') === 'kind') kindDropdown = dropdown;
            if (dropdown.getAttribute('data-name') === 'subkind') subkindDropdown = dropdown;

            // Фокус
            if (section) {
                selected.addEventListener('focus', () => section.classList.add('focused'));
                selected.addEventListener('blur',  () => section.classList.remove('focused'));
                search?.addEventListener('focus', () => section.classList.add('focused'));
                search?.addEventListener('blur',  () => section.classList.remove('focused'));
            }

            // Відкриття/закриття
            selected.addEventListener('click', () => {
                const wasOpen = dropdown.classList.contains('open');
                document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
                dropdown.classList.toggle('open', !wasOpen);

                if (dropdown.classList.contains('open') && search) {
                    search.style.display = 'block';
                    search.focus();
                } else if (search) {
                    search.style.display = 'none';
                }
            });

            // Пошук
            if (search) {
                search.addEventListener('input', () => {
                    const query = search.value.toLowerCase();
                    const kindId = kindDropdown?.querySelector('input[type="hidden"]')?.value || '';

                    options.querySelectorAll('li').forEach(li => {
                        const text = (li.getAttribute('data-title') || '').toLowerCase();
                        const liKindId = li.getAttribute('data-kind') || '';
                        const matchesSearch = text.includes(query);
                        const matchesKind = !kindId || liKindId === kindId;
                        li.style.display = (matchesSearch && matchesKind) ? 'flex' : 'none';
                    });
                });
            }

            // Клік по опціях
            options.querySelectorAll('li').forEach(option => {
                option.addEventListener('click', () => {
                    const textSpan = selected.querySelector('.selected-text') || selected;
                    textSpan.textContent = option.textContent.trim();
                    hiddenInput.value = option.getAttribute('data-value');
                    selected.classList.add('selected-value');
                    dropdown.classList.remove('open');
                    if (search) {
                        search.value = '';
                        search.style.display = 'none';
                    }

                    // === ТРИГЕРИМО ОНОВЛЕННЯ LABEL ===
                    $(hiddenInput).trigger('change');

                    // Фільтрація підвидів (якщо це вид)
                    if (dropdown === kindDropdown && subkindDropdown) {
                        const kindId = hiddenInput.value;
                        subkindDropdown.querySelectorAll('li').forEach(sub => {
                            sub.style.display = sub.getAttribute('data-kind') === kindId ? 'flex' : 'none';
                        });

                        // Скидаємо підвид, якщо не підходить
                        const subHidden = subkindDropdown.querySelector('input[type="hidden"]');
                        const subSelected = subkindDropdown.querySelector('.dropdown-selected');
                        const subText = subSelected.querySelector('.selected-text') || subSelected;
                        if (subHidden.value && !Array.from(subkindDropdown.querySelectorAll('li')).some(li =>
                            li.getAttribute('data-value') === subHidden.value && li.style.display !== 'none'
                        )) {
                            subHidden.value = '';
                            subText.textContent = 'Оберіть підвид товару';
                            subSelected.classList.remove('selected-value');
                            $(subHidden).trigger('change');
                        }
                    }

                    // Автопідстановка виду при виборі підвиду
                    if (dropdown === subkindDropdown) {
                        const kindIdFromSub = option.getAttribute('data-kind');
                        if (kindIdFromSub && kindDropdown && !kindDropdown.querySelector('input[type="hidden"]').value) {
                            const kindOption = kindDropdown.querySelector(`li[data-value="${kindIdFromSub}"]`);
                            if (kindOption) {
                                const kindText = kindDropdown.querySelector('.selected-text');
                                const kindHidden = kindDropdown.querySelector('input[type="hidden"]');
                                kindText.textContent = kindOption.textContent.trim();
                                kindHidden.value = kindIdFromSub;
                                kindDropdown.querySelector('.dropdown-selected').classList.add('selected-value');
                                updateKindState();
                                $(kindHidden).trigger('change');
                            }
                        }
                    }

                    updateKindState();
                });
            });

            // Закриття при кліку поза
            document.addEventListener('click', e => {
                if (!dropdown.contains(e.target) && !e.target.closest('.custom-dropdown')) {
                    dropdown.classList.remove('open');
                    if (search) search.style.display = 'none';
                    wrapper.classList.remove('has-focus');
                    if (section) section.classList.remove('focused');
                }
            });

            // Ініціалізація old()/edit
            if (hiddenInput.value) {
                const opt = options.querySelector(`li[data-value="${hiddenInput.value}"]`);
                if (opt) {
                    const textSpan = selected.querySelector('.selected-text') || selected;
                    textSpan.textContent = opt.textContent.trim();
                    selected.classList.add('selected-value');
                }
            }
        });

        // Автопідстановка виду при old(sub_kind) без kind
        if (subkindDropdown && kindDropdown) {
            const subHidden = subkindDropdown.querySelector('input[type="hidden"]');
            const kindHidden = kindDropdown.querySelector('input[type="hidden"]');

            if (subHidden.value && !kindHidden.value) {
                const subLi = subkindDropdown.querySelector(`li[data-value="${subHidden.value}"]`);
                if (subLi) {
                    const kindId = subLi.getAttribute('data-kind');
                    const kindLi = kindDropdown.querySelector(`li[data-value="${kindId}"]`);
                    if (kindLi) {
                        const kindText = kindDropdown.querySelector('.selected-text');
                        kindText.textContent = kindLi.textContent.trim();
                        kindHidden.value = kindId;
                        kindDropdown.querySelector('.dropdown-selected').classList.add('selected-value');
                        updateKindState();
                        $(kindHidden).trigger('change');
                    }
                }
            }

            if (kindHidden.value) {
                subkindDropdown.querySelectorAll('li').forEach(li => {
                    li.style.display = li.getAttribute('data-kind') === kindHidden.value ? 'flex' : 'none';
                });
            }
        }

        updateKindState();

        // === ХРЕСТИК ОЧИЩЕННЯ (з тригером + оновленням пошуку!) ===
        document.querySelectorAll('.custom-dropdown[data-name="kind"] .clear-selection').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();

                const dropdown = this.closest('.custom-dropdown');
                const hidden   = dropdown.querySelector('input[type="hidden"]');
                const selected = dropdown.querySelector('.dropdown-selected');
                const textSpan = selected.querySelector('.selected-text');
                const search   = dropdown.querySelector('.dropdown-search'); // Додано!

                // Очищення виду
                textSpan.textContent = 'Оберіть вид товару';
                hidden.value = '';
                selected.classList.remove('has-value', 'selected-value');

                // Очищення пошуку + примусове оновлення списку видів
                if (search) {
                    search.value = '';
                    search.dispatchEvent(new Event('input')); // Ключовий рядок!
                }

                // Скидання підвиду
                if (subkindDropdown) {
                    const subHidden = subkindDropdown.querySelector('input[type="hidden"]');
                    const subSelected = subkindDropdown.querySelector('.dropdown-selected');
                    const subText = subSelected.querySelector('.selected-text') || subSelected;

                    subText.textContent = 'Оберіть підвид товару';
                    subHidden.value = '';
                    subSelected.classList.remove('selected-value');
                    $(subHidden).trigger('change');

                    // Показуємо всі підвиди (бо вид скинуто)
                    subkindDropdown.querySelectorAll('.dropdown-options li').forEach(li => {
                        li.style.display = 'flex';
                    });

                    // Якщо в підвиді є активний пошук — теж оновлюємо
                    const subSearch = subkindDropdown.querySelector('.dropdown-search');
                    if (subSearch) {
                        subSearch.value = '';
                        subSearch.dispatchEvent(new Event('input'));
                    }
                }

                $(hidden).trigger('change');
                updateKindState();
            });
        });
    });

    // === ГЛОБАЛЬНИЙ ТРИГЕР ДЛЯ label-focused (один раз!) ===
    $(document).on('change', 'input[name="kind_product_id"], input[name="sub_kind_product_id"]', function () {
        $(document).trigger('field-updated');
    });

    // При завантаженні — якщо вже є значення
    $(document).ready(function () {
        if ($('input[name="kind_product_id"]').val() || $('input[name="sub_kind_product_id"]').val()) {
            setTimeout(() => $(document).trigger('field-updated'), 300);
        }
    });

    // ЕКСПОРТ
    window.Learts = window.Learts || {};
    Learts.dropdown = { init: () => {} };

})(jQuery);
