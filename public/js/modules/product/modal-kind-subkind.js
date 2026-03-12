document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('kindSubkindModal');
    if (!modalElement) return;

    const modal = modalElement;
    const form = document.getElementById('kindSubkindForm');
    const kindSelect = document.getElementById('kindSelect');
    const subkindSelect = document.getElementById('subkindSelect');
    const titleKindInput = document.getElementById('title_kind_product');
    const titleSubkindInput = document.getElementById('title_sub_kind_product');
    const modalTitle = document.getElementById('kindSubkindModalLabel');

    let kindTs = null;
    let subkindTs = null;
    let settingKindFromSubkind = false;

    function getSelectedKindId() {
        if (!kindTs) return null;
        const val = kindTs.getValue();
        if (!val) return null;
        return /^\d+$/.test(val) ? val : 'new';
    }

    function filterSubkinds(keepValue) {
        if (!subkindTs) return;
        const kindId = getSelectedKindId();

        subkindTs.clearOptions();

        // Якщо новий вид — підвидів немає, залишаємо порожньо
        if (kindId !== 'new') {
            Array.from(subkindSelect.options).forEach(opt => {
                if (!kindId || opt.dataset.kind === kindId) {
                    subkindTs.addOption({ value: opt.value, text: opt.text });
                }
            });
        }

        subkindTs.load('');

        if (keepValue && subkindTs.options[keepValue]) {
            subkindTs.setValue(keepValue, true);
        } else {
            subkindTs.clear(true);
            titleSubkindInput.value = '';
        }

        subkindTs.close();
    }

    function updateQuickSubkinds() {
        const kindId = getSelectedKindId();
        const el = document.getElementById('quickSubkinds');
        if (!el) return;
        el.querySelectorAll('a.quick-subkind').forEach(link => {
            const opt = Array.from(subkindSelect.options).find(o => o.text === link.dataset.title);
            link.style.display = (!kindId || !opt || opt.dataset.kind === kindId) ? '' : 'none';
        });
    }

    function lockAfterSelect(ts) {
        setTimeout(() => {
            ts.close();
            ts.control_input.value = '';
            ts.control_input.blur();
        }, 0);
    }

    function onKindCleared() {
        titleKindInput.value = '';
        if (subkindTs) {
            subkindTs.clear(true);
            titleSubkindInput.value = '';
        }
        filterSubkinds();
        updateQuickSubkinds();
    }

    function updateDropdowns(newKind, newSubkind) {
        if (newKind) {
            const kindDropdown = document.querySelector('.custom-dropdown[data-name="kind"]');
            if (kindDropdown) {
                const kindList   = kindDropdown.querySelector('.dropdown-options');
                const kindHidden = kindDropdown.querySelector('input[type="hidden"]');

                if (!kindList.querySelector(`li[data-value="${newKind.id}"]`)) {
                    const li = document.createElement('li');
                    li.dataset.value = String(newKind.id);
                    li.dataset.title = newKind.title;
                    li.innerHTML = `<i class="fas fa-box-open"></i> ${newKind.title}`;
                    kindList.appendChild(li);
                }

                kindHidden.value = newKind.id;
                kindDropdown.querySelector('.selected-text').textContent = newKind.title;
                kindDropdown.querySelector('.dropdown-selected').classList.add('selected-value');
                kindDropdown.closest('.form-section')?.querySelector('.form-label')?.classList.add('label-focused');
            }
        }

        if (newSubkind) {
            const subDropdown = document.querySelector('.custom-dropdown[data-name="subkind"]');
            if (subDropdown) {
                const subList   = subDropdown.querySelector('.dropdown-options');
                const subHidden = subDropdown.querySelector('input[type="hidden"]');

                if (!subList.querySelector(`li[data-value="${newSubkind.id}"]`)) {
                    const li = document.createElement('li');
                    li.dataset.value = String(newSubkind.id);
                    li.dataset.title = newSubkind.title;
                    li.dataset.kind  = String(newSubkind.kind_product_id);
                    li.innerHTML = `<i class="fas fa-layer-group"></i> ${newSubkind.title}`;
                    subList.appendChild(li);
                }

                subHidden.value = newSubkind.id;
                subDropdown.querySelector('.selected-text').textContent = newSubkind.title;
                subDropdown.querySelector('.dropdown-selected').classList.add('selected-value');
                subDropdown.closest('.form-section')?.querySelector('.form-label')?.classList.add('label-focused');

                if (newKind) {
                    subList.querySelectorAll('li').forEach(li => {
                        li.style.display = li.dataset.kind === String(newKind.id) ? 'flex' : 'none';
                    });
                }
            }
        }
    }

    modal.addEventListener('shown.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;

        // Тільки візуальна зміна заголовка — на логіку не впливає
        const mode = button.getAttribute('data-mode') || 'subkind';
        modalTitle.textContent = mode === 'kind'
            ? 'Додати вид товару'
            : 'Додати підвид товару';

        if (kindSelect && window.TomSelect && !kindTs) {
            kindTs = new TomSelect(kindSelect, {
                create: true,
                createOnBlur: true,
                persist: false,
                maxItems: 1,
                maxOptions: 50,
                openOnFocus: true,
                selectOnTab: true,
                closeAfterSelect: true,
                placeholder: 'Введіть назву виду або оберіть...',
                sortField: [{ field: 'text', direction: 'asc' }],
                render: {
                    no_results: () => '<div class="no-results">Нічого не знайдено</div>',
                    option_create: (data, escape) =>
                        '<div class="create">Створити новий вид: <strong>' + escape(data.input) + '</strong></div>'
                },
                onItemAdd: function (value) {
                    if (settingKindFromSubkind) return;
                    titleKindInput.value = /^\d+$/.test(value) ? '' : value;
                    if (subkindTs) {
                        subkindTs.clear(true);
                        titleSubkindInput.value = '';
                    }
                    filterSubkinds();
                    updateQuickSubkinds();
                    lockAfterSelect(kindTs);
                },
                onDelete: function () {
                    setTimeout(() => onKindCleared(), 0);
                }
            });

            kindTs.control_input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && kindTs.getValue()) {
                    setTimeout(() => onKindCleared(), 0);
                }
            });
        }

        if (subkindSelect && window.TomSelect && !subkindTs) {
            subkindTs = new TomSelect(subkindSelect, {
                create: true,
                createOnBlur: true,
                persist: false,
                maxItems: 1,
                maxOptions: 50,
                openOnFocus: true,
                selectOnTab: true,
                closeAfterSelect: true,
                placeholder: 'Введіть назву підвиду або оберіть...',
                sortField: [{ field: 'text', direction: 'asc' }],
                render: {
                    no_results: () => '<div class="no-results">Нічого не знайдено</div>',
                    option_create: (data, escape) =>
                        '<div class="create">Створити новий підвид: <strong>' + escape(data.input) + '</strong></div>'
                },
                onItemAdd: function (value) {
                    titleSubkindInput.value = /^\d+$/.test(value) ? '' : value;
                    const selectedOption = subkindSelect.querySelector(`option[value="${value}"]`);
                    if (selectedOption && selectedOption.dataset.kind && kindTs && !getSelectedKindId()) {
                        settingKindFromSubkind = true;
                        kindTs.setValue(selectedOption.dataset.kind, true);
                        titleKindInput.value = '';
                        settingKindFromSubkind = false;
                        filterSubkinds(value);
                        updateQuickSubkinds();
                    }
                    lockAfterSelect(subkindTs);
                },
                onDelete: function () {
                    titleSubkindInput.value = '';
                }
            });
        }

        if (kindTs)    { kindTs.clear(true);    kindTs.close(); }
        if (subkindTs) { subkindTs.clear(true); subkindTs.close(); }

        filterSubkinds();
        updateQuickSubkinds();

        if (form) form.reset();
    });

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    updateDropdowns(data.newKind, data.newSubkind);
                    bootstrap.Modal.getInstance(modal).hide();
                    alert(data.message);
                } else {
                    alert(data.message || 'Помилка валідації');
                }
            } catch (err) {
                console.error(err);
                alert('Помилка зв\'язку');
            }
        });
    }

    document.querySelectorAll('.quick-kind').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            if (!kindTs) return;

            const title = link.dataset.title;
            const existingOption = Array.from(kindSelect.options).find(o => o.text === title);

            if (subkindTs) {
                subkindTs.clear(true);
                titleSubkindInput.value = '';
            }

            if (existingOption) {
                kindTs.setValue(existingOption.value, true);
                titleKindInput.value = '';
            } else {
                if (!kindTs.options[title]) kindTs.addOption({ value: title, text: title });
                kindTs.setValue(title, true);
                titleKindInput.value = title;
            }

            kindTs.close();
            kindTs.control_input.value = '';
            filterSubkinds();
            updateQuickSubkinds();
        });
    });

    document.querySelectorAll('.quick-subkind').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            if (link.style.display === 'none') return;
            if (!subkindTs) return;

            const title = link.dataset.title;
            const selectedKindId = getSelectedKindId();
            const existingOption = Array.from(subkindSelect.options).find(o => o.text === title);

            if (selectedKindId && existingOption && existingOption.dataset.kind !== selectedKindId) {
                alert('Цей підвид не належить до обраного виду!');
                return;
            }

            if (existingOption) {
                subkindTs.setValue(existingOption.value, true);
                titleSubkindInput.value = '';
                if (!selectedKindId && existingOption.dataset.kind && kindTs) {
                    settingKindFromSubkind = true;
                    kindTs.setValue(existingOption.dataset.kind, true);
                    titleKindInput.value = '';
                    kindTs.control_input.value = '';
                    settingKindFromSubkind = false;
                    filterSubkinds(existingOption.value);
                    updateQuickSubkinds();
                }
            } else {
                if (!subkindTs.options[title]) subkindTs.addOption({ value: title, text: title });
                subkindTs.setValue(title, true);
                titleSubkindInput.value = title;
            }

            subkindTs.close();
            subkindTs.control_input.value = '';
        });
    });
});
