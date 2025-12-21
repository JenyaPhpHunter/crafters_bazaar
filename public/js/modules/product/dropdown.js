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

        // При відкритті очищаємо поле пошуку і показуємо всі опції
        search.value = '';
        list.querySelectorAll('li').forEach(li => li.style.display = 'flex');
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

        e.stopPropagation();
        e.preventDefault();

        const kindDropdown = document.querySelector('.custom-dropdown[data-name="kind"]');
        const subDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');

        if (kindDropdown) {
            kindDropdown.querySelector('input[type="hidden"]').value = '';
            kindDropdown.querySelector('.selected-text').textContent = 'Оберіть вид товару';
            kindDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
            kindDropdown.closest('.form-section').querySelector('.form-label').classList.remove('label-focused');
        }

        if (subDropdown) {
            subDropdown.querySelector('input[type="hidden"]').value = '';
            subDropdown.querySelector('.selected-text').textContent = 'Оберіть підвид товару';
            subDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
            subDropdown.closest('.form-section').querySelector('.form-label').classList.remove('label-focused');
            subDropdown.querySelectorAll('li').forEach(li => li.style.display = 'flex');
        }

        closeActive();
        document.dispatchEvent(new Event('field-updated'));
    });

    // Ініціалізація дропдаунів
    // Ініціалізація дропдаунів
    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
        const selected = dropdown.querySelector('.dropdown-selected');
        const hidden = dropdown.querySelector('input[type="hidden"]');
        const search = dropdown.querySelector('.dropdown-search');
        const list = dropdown.querySelector('.dropdown-options');

        search.style.display = 'none';
        list.style.display = 'none';

        selected.addEventListener('click', e => {
            if (e.target.closest('.clear-selection')) return;
            e.stopPropagation();

            openDropdown(dropdown);

            // При відкритті — показуємо всі опції
            search.value = '';
            list.querySelectorAll('li').forEach(li => li.style.display = 'flex');

            // Фільтруємо підвиди по обраному виду
            if (dropdown.dataset.name === 'subkind') {
                const kindValue = document.querySelector('input[name="kind_product_id"]')?.value || '';
                list.querySelectorAll('li').forEach(li => {
                    li.style.display = li.dataset.kind === kindValue ? 'flex' : 'none';
                });
            }
        });

        // Пошук
        // Пошук
        search.addEventListener('input', () => {
            const query = search.value.toLowerCase();

            // Для видів
            if (dropdown.dataset.name === 'kind') {
                list.querySelectorAll('li').forEach(li => {
                    const text = (li.dataset.title || li.textContent).toLowerCase();
                    li.style.display = text.includes(query) ? 'flex' : 'none';
                });
            }

            // Для підвидів
            if (dropdown.dataset.name === 'subkind') {
                const kindId = document.querySelector('input[name="kind_product_id"]')?.value || '';
                list.querySelectorAll('li').forEach(li => {
                    const text = (li.dataset.title || li.textContent).toLowerCase();
                    const matchesKind = !kindId || li.dataset.kind === kindId;
                    li.style.display = (query === '' ? matchesKind : text.includes(query) && matchesKind) ? 'flex' : 'none';
                });
            }
        });

        // Вибір опції
        list.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', e => {
                e.stopPropagation();

                hidden.value = li.dataset.value;
                selected.querySelector('.selected-text').textContent = li.textContent.trim();
                selected.classList.add('selected-value');
                selected.closest('.form-section').querySelector('.form-label').classList.add('label-focused');

                // Якщо це вид — фільтруємо підвиди
                if (dropdown.dataset.name === 'kind') {
                    const subDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');
                    if (subDropdown) {
                        const subHidden = subDropdown.querySelector('input[type="hidden"]');
                        const subList = subDropdown.querySelectorAll('li');

                        // Показуємо лише підвиди, які належать обраному виду
                        subList.forEach(subLi => {
                            subLi.style.display = subLi.dataset.kind === li.dataset.value ? 'flex' : 'none';
                        });

                        // Очищуємо підвид, якщо він більше не належить цьому виду
                        if (subHidden.value && !Array.from(subList).some(subLi => subLi.dataset.value === subHidden.value && subLi.dataset.kind === li.dataset.value)) {
                            subHidden.value = '';
                            subDropdown.querySelector('.selected-text').textContent = 'Оберіть підвид товару';
                            subDropdown.querySelector('.dropdown-selected').classList.remove('selected-value');
                            subDropdown.closest('.form-section').querySelector('.form-label').classList.remove('label-focused');
                        }
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
                            kindDropdown.closest('.form-section').querySelector('.form-label').classList.add('label-focused');
                        }
                    }
                }

                closeActive();
                document.dispatchEvent(new Event('field-updated'));
            });
        });
    });
});
