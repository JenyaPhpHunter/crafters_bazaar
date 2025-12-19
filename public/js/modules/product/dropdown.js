// public/js/modules/product/dropdown.js — фінальна версія, працює з першого кліку завжди

(function ($) {
    "use strict";

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

    // Функція прив'язки обробників до опцій
    const bindOptionClickHandlers = () => {
        document.querySelectorAll('.custom-dropdown .dropdown-options li').forEach(option => {
            // Очищаємо старий обробник, щоб не дублювати
            option.onclick = null;

            option.addEventListener('click', function () {
                const dropdown = this.closest('.custom-dropdown');
                const selected = dropdown.querySelector('.dropdown-selected');
                const textSpan = selected.querySelector('.selected-text');
                const hiddenInput = dropdown.querySelector('input[type="hidden"]');
                const search = dropdown.querySelector('.dropdown-search');

                const value = this.getAttribute('data-value');
                const title = this.textContent.trim();

                if (textSpan) {
                    textSpan.textContent = title;
                }

                hiddenInput.value = value;
                selected.classList.add('selected-value');

                // Плавне закриття
                setTimeout(() => {
                    dropdown.classList.remove('open');
                    if (search) {
                        search.value = '';
                        search.style.display = 'none';
                    }
                }, 100);

                $(hiddenInput).trigger('change');

                // Фільтрація підвидів і автопідстановка — весь твій оригінальний код
                const kindDropdown = document.querySelector('.custom-dropdown[data-name="kind"]');
                const subkindDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');

                if (dropdown.getAttribute('data-name') === 'kind' && subkindDropdown) {
                    const kindId = value;
                    subkindDropdown.querySelectorAll('li').forEach(sub => {
                        sub.style.display = sub.getAttribute('data-kind') === kindId ? 'flex' : 'none';
                    });

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

                if (dropdown.getAttribute('data-name') === 'subkind' && kindDropdown) {
                    const kindIdFromSub = this.getAttribute('data-kind');
                    if (kindIdFromSub && !kindDropdown.querySelector('input[type="hidden"]').value) {
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
    };

    $(function () {
        let kindDropdown = null;
        let subkindDropdown = null;

        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            const wrapper  = dropdown.closest('.custom-dropdown-wrapper');
            const section  = wrapper ? wrapper.closest('.form-section') : null;
            const selected = dropdown.querySelector('.dropdown-selected');
            const search   = dropdown.querySelector('.dropdown-search');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            if (dropdown.getAttribute('data-name') === 'kind') kindDropdown = dropdown;
            if (dropdown.getAttribute('data-name') === 'subkind') subkindDropdown = dropdown;

            // Фокус
            if (section) {
                selected.addEventListener('focus', () => section.classList.add('focused'));
                selected.addEventListener('blur', () => section.classList.remove('focused'));
                if (search) {
                    search.addEventListener('focus', () => section.classList.add('focused'));
                    search.addEventListener('blur', () => section.classList.remove('focused'));
                }
            }

            // Відкриття/закриття
            selected.addEventListener('click', () => {
                const wasOpen = dropdown.classList.contains('open');

                document.querySelectorAll('.custom-dropdown').forEach(d => {
                    d.classList.remove('open');
                });

                document.querySelectorAll('.mb-4').forEach(b => {
                    b.classList.remove('dropdown-open', 'dropdown-below-hidden');
                });

                dropdown.classList.toggle('open', !wasOpen);

                if (dropdown.classList.contains('open')) {
                    const currentMb4 = dropdown.closest('.mb-4');
                    if (!currentMb4) return;

                    currentMb4.classList.add('dropdown-open');

                    // 🔑 УСІ mb-4 НИЖЧЕ — опускаємо
                    let next = currentMb4.nextElementSibling;
                    while (next) {
                        if (next.classList.contains('mb-4')) {
                            next.classList.add('dropdown-below-hidden');
                        }
                        next = next.nextElementSibling;
                    }

                    if (search) {
                        search.style.display = 'block';
                        search.focus();
                    }

                    setTimeout(bindOptionClickHandlers, 50);
                } else {
                    if (search) search.style.display = 'none';
                }
            });

            // Пошук
            if (search) {
                search.addEventListener('input', () => {
                    const query = search.value.toLowerCase();
                    const kindId = kindDropdown?.querySelector('input[type="hidden"]')?.value || '';

                    dropdown.querySelectorAll('.dropdown-options li').forEach(li => {
                        const text = (li.getAttribute('data-title') || li.textContent).toLowerCase();
                        const liKindId = li.getAttribute('data-kind') || '';
                        const matchesSearch = text.includes(query);
                        const matchesKind = !kindId || liKindId === kindId;
                        li.style.display = (matchesSearch && matchesKind) ? 'flex' : 'none';
                    });
                });
            }

            // Закриття при кліку поза
            document.addEventListener('click', e => {
                if (!dropdown.contains(e.target) && !e.target.closest('.custom-dropdown')) {
                    dropdown.classList.remove('open');
                    if (search) search.style.display = 'none';
                    if (section) section.classList.remove('focused');
                }
            });

            // old() значення
            if (hiddenInput.value) {
                const opt = dropdown.querySelector(`.dropdown-options li[data-value="${hiddenInput.value}"]`);
                if (opt) {
                    const textSpan = selected.querySelector('.selected-text') || selected;
                    textSpan.textContent = opt.textContent.trim();
                    selected.classList.add('selected-value');
                }
            }
        });

        // Автопідстановка та фільтрація при завантаженні
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

        // Початкова прив'язка обробників
        bindOptionClickHandlers();

        // Страховка: ще раз через 500 мс після завантаження (для анімацій)
        setTimeout(bindOptionClickHandlers, 500);

        $(document).trigger('field-updated');
    });

    // Хрестик очищення
    $(document).on('click', '.custom-dropdown[data-name="kind"] .clear-selection', function (e) {
        e.stopPropagation();

        const dropdown = this.closest('.custom-dropdown');
        const hidden   = dropdown.querySelector('input[type="hidden"]');
        const selected = dropdown.querySelector('.dropdown-selected');
        const textSpan = selected.querySelector('.selected-text');
        const search   = dropdown.querySelector('.dropdown-search');

        textSpan.textContent = 'Оберіть вид товару';
        hidden.value = '';
        selected.classList.remove('has-value', 'selected-value');

        if (search) {
            search.value = '';
            search.dispatchEvent(new Event('input'));
        }

        const subkindDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');
        if (subkindDropdown) {
            const subHidden = subkindDropdown.querySelector('input[type="hidden"]');
            const subSelected = subkindDropdown.querySelector('.dropdown-selected');
            const subText = subSelected.querySelector('.selected-text') || subSelected;

            subText.textContent = 'Оберіть підвид товару';
            subHidden.value = '';
            subSelected.classList.remove('selected-value');
            $(subHidden).trigger('change');

            subkindDropdown.querySelectorAll('.dropdown-options li').forEach(li => {
                li.style.display = 'flex';
            });

            const subSearch = subkindDropdown.querySelector('.dropdown-search');
            if (subSearch) {
                subSearch.value = '';
                subSearch.dispatchEvent(new Event('input'));
            }
        }

        $(hidden).trigger('change');
        updateKindState();
        $(document).trigger('field-updated');
    });

    $(document).on('change', 'input[name="kind_product_id"], input[name="sub_kind_product_id"]', function () {
        $(document).trigger('field-updated');
    });

})(jQuery);
