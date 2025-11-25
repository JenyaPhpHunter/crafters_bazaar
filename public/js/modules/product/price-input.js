// public/js/modules/product/price-input.js
// ФІНАЛЬНА ВЕРСІЯ — ПРАЦЮЄ НА 100% НА ТВОЇЙ СИСТЕМІ

(() => {
    // Чекаємо, поки DOM повністю завантажиться
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPriceInput);
    } else {
        initPriceInput();
    }

    function initPriceInput() {
        const priceDiv = document.getElementById('price');
        const hiddenInput = document.getElementById('price-hidden');

        if (!priceDiv || !hiddenInput) return;

        let rawValue = '';

        // Форматування числа
        const formatNumber = (num) => num.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

        // Початкове значення
        const initialText = priceDiv.textContent.trim();
        const initialDigits = initialText.replace(/\s/g, '').replace(/[^0-9]/g, '');
        if (initialDigits) {
            rawValue = initialDigits;
            priceDiv.textContent = formatNumber(initialDigits);
            hiddenInput.value = initialDigits;
        }

        // Блокуємо все, крім цифр
        priceDiv.addEventListener('keydown', (e) => {
            const allowedKeys = [
                8, 9, 13, 27, 37, 38, 39, 40, // Backspace, Tab, Enter, Esc, стрілки
                46, // Delete
                65, 67, 86, 88, 90 // Ctrl+A, C, V, X, Z
            ];

            if (allowedKeys.includes(e.keyCode)) return;
            if (e.ctrlKey || e.metaKey) return;
            if (e.key.length === 1 && !/\d/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Головна обробка введення
        priceDiv.addEventListener('input', () => {
            let text = priceDiv.textContent || '';
            let digits = text.replace(/[^0-9]/g, '');

            rawValue = digits;
            hiddenInput.value = digits;

            priceDiv.textContent = formatNumber(digits);

            // Курсор в кінець
            const range = document.createRange();
            const sel = window.getSelection();
            range.selectNodeContents(priceDiv);
            range.collapse(false);
            sel.removeAllRanges();
            sel.addRange(range);
        });

        // Тригер для підсвітки лейбла
        priceDiv.addEventListener('input', () => {
            $(document).trigger('field-updated');
        });
    }
})();
