(function ($) {
    "use strict";

    // === УНІФІКОВАНА ПІДСВІТКА LABEL ПРИ ФОКУСІ ===
    document.addEventListener('DOMContentLoaded', () => {
        const focusableElements = document.querySelectorAll('input, textarea, .dropdown-selected, .dropdown-search, .form-control-wide-center');
        focusableElements.forEach(element => {
            const label = element.closest('.form-group, .form-group-title-price, .custom-dropdown-wrapper')?.previousElementSibling;
            if (label && label.classList.contains('form-label')) {
                element.addEventListener('focus', () => {
                    label.classList.add('label-focused');
                });
                element.addEventListener('blur', () => {
                    label.classList.remove('label-focused');
                });
            }
        });
    });

    // === CUSTOM DROPDOWN: ФУНКЦІОНАЛ ===
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            const wrapper = dropdown.closest('.custom-dropdown-wrapper');
            const section = wrapper.closest('.form-section');
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelector('.dropdown-options');
            const search = dropdown.querySelector('.dropdown-search');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            // Додавання/зняття класу .focused при фокусі
            const handleFocus = () => {
                wrapper.classList.add('has-focus');
                if (section) section.classList.add('focused');
            };
            const handleBlur = () => {
                wrapper.classList.remove('has-focus');
                if (section) section.classList.remove('focused');
            };

            selected.addEventListener('click', () => {
                dropdown.classList.toggle('open');
                if (dropdown.classList.contains('open')) {
                    search.focus();
                }
            });

            selected.addEventListener('focus', handleFocus);
            selected.addEventListener('blur', handleBlur);
            search.addEventListener('focus', handleFocus);
            search.addEventListener('blur', handleBlur);

            search.addEventListener('input', () => {
                const query = search.value.toLowerCase();
                options.querySelectorAll('li').forEach(option => {
                    const text = option.getAttribute('data-title').toLowerCase();
                    option.style.display = text.includes(query) ? 'flex' : 'none';
                });
            });

            options.querySelectorAll('li').forEach(option => {
                option.addEventListener('click', () => {
                    selected.textContent = option.textContent;
                    hiddenInput.value = option.getAttribute('data-value');
                    selected.classList.add('selected-value');
                    dropdown.classList.remove('open');
                    search.value = '';
                    selected.focus();
                });
            });

            // Закриття при кліку поза dropdown
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                    search.value = '';
                    wrapper.classList.remove('has-focus');
                    if (section) section.classList.remove('focused');
                }
            });

            // Ініціалізація: якщо вже є обране значення
            if (hiddenInput.value) {
                const initialOption = Array.from(options.querySelectorAll('li'))
                    .find(option => option.getAttribute('data-value') === hiddenInput.value);
                if (initialOption) {
                    selected.textContent = initialOption.textContent;
                    selected.classList.add('selected-value');
                }
            }
        });
    });

    // === ЕКСПОРТ ===
    window.Learts = window.Learts || {};
    Learts.forms = Learts.forms || {};
    Learts.forms.init = function () {
        // Ніяких дій при ініціалізації, якщо потрібно — додай
    };

    $(document).ready(function () {
        Learts.forms.init();
    });

})(jQuery);
