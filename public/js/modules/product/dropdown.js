document.addEventListener('DOMContentLoaded', () => {
    "use strict";

    let activeDropdown = null;

    const closeActive = () => {
        if (!activeDropdown) return;
        const { search, list } = activeDropdown;

        search.style.display = 'none';
        list.style.display = 'none';

        activeDropdown = null;
    };

    const openDropdown = (dropdown) => {
        if (activeDropdown && activeDropdown.dropdown === dropdown) {
            closeActive();
            return;
        }
        closeActive();

        const search = dropdown.querySelector('.dropdown-search');
        const list = dropdown.querySelector('.dropdown-options');

        search.style.display = 'block';
        list.style.display = 'block';

        activeDropdown = { dropdown, search, list };
        search.focus();
    };

    // Клік поза дропдауном
    document.addEventListener('click', (e) => {
        if (!activeDropdown) return;
        if (!activeDropdown.dropdown.contains(e.target)) {
            closeActive();
        }
    });

    // Хрестик очищення виду та підвиду
    document.addEventListener('click', e => {
        const btn = e.target.closest('.clear-selection');
        if (!btn) return;

        e.stopPropagation(); // <--- Зупиняємо подальший bubbling
        e.preventDefault();

        const kindDropdown = document.querySelector('.custom-dropdown[data-name="kind"]');
        const subDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');

        if (kindDropdown) {
            kindDropdown.querySelector('input[type="hidden"]').value = '';
            kindDropdown.querySelector('.selected-text').textContent = 'Оберіть вид товару';
            kindDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
        }

        if (subDropdown) {
            subDropdown.querySelector('input[type="hidden"]').value = '';
            subDropdown.querySelector('.selected-text').textContent = 'Оберіть підвид товару';
            subDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
            subDropdown.querySelectorAll('li').forEach(li => li.style.display = 'flex');
        }

        closeActive();
        document.dispatchEvent(new Event('field-updated'));
    });

    // Ініціалізація дропдаунів
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        const selected = dropdown.querySelector('.dropdown-selected');
        const hidden = dropdown.querySelector('input[type="hidden"]');
        const search = dropdown.querySelector('.dropdown-search');
        const list = dropdown.querySelector('.dropdown-options');

        search.style.display = 'none';
        list.style.display = 'none';

        // Клік на поле — toggle
        selected.addEventListener('click', e => {
            // Якщо клік по хрестику — не відкриваємо дропдаун
            if (e.target.closest('.clear-selection')) return;

            e.stopPropagation();
            openDropdown(dropdown);
        });

        // Пошук
        search.addEventListener('input', () => {
            const query = search.value.toLowerCase();
            const kindId = document.querySelector('input[name="kind_product_id"]')?.value || '';

            list.querySelectorAll('li').forEach(li => {
                const text = (li.dataset.title || li.textContent).toLowerCase();
                const liKind = li.dataset.kind || '';
                li.style.display = text.includes(query) && (!kindId || liKind === kindId) ? 'flex' : 'none';
            });
        });

        // Вибір опції
        list.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', e => {
                e.stopPropagation();

                hidden.value = li.dataset.value;
                selected.querySelector('.selected-text').textContent = li.textContent.trim();
                selected.classList.add('selected-value');

                // Фільтрація підвидів при виборі виду
                if (dropdown.dataset.name === 'kind') {
                    const subDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');
                    if (subDropdown) {
                        subDropdown.querySelectorAll('li').forEach(subLi => {
                            subLi.style.display = subLi.dataset.kind === li.dataset.value ? 'flex' : 'none';
                        });
                        // Очищуємо підвид при зміні виду
                        const subHidden = subDropdown.querySelector('input[type="hidden"]');
                        subHidden.value = '';
                        subDropdown.querySelector('.selected-text').textContent = 'Оберіть підвид товару';
                        subDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
                    }
                }

                // Автопідстановка виду при виборі підвиду
                if (dropdown.dataset.name === 'subkind') {
                    const kindDropdown = document.querySelector('.custom-dropdown[data-name="kind"]');
                    if (kindDropdown && !kindDropdown.querySelector('input[type="hidden"]').value) {
                        const kindLi = kindDropdown.querySelector(`.dropdown-options li[data-value="${li.dataset.kind}"]`);
                        if (kindLi) {
                            kindDropdown.querySelector('input[type="hidden"]').value = kindLi.dataset.value;
                            kindDropdown.querySelector('.selected-text').textContent = kindLi.textContent.trim();
                            kindDropdown.querySelector('.dropdown-selected').classList.add('selected-value');
                        }
                    }
                }

                closeActive();
                document.dispatchEvent(new Event('field-updated'));
            });
        });
    });
});
