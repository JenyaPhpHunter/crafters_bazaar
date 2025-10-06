// Масив для збереження актуальних файлів для логотипу бренду
let selectedBrandFiles = [];

// Оновлення тексту label та прев’ю для логотипу бренду
function updateBrandFileLabel() {
    const label = document.getElementById('file-label'); // span з текстом
    const previewContainer = document.getElementById('preview-container'); // контейнер прев’ю
    const input = document.getElementById('image'); // file input
    const fileCount = selectedBrandFiles.length; // кількість обраних файлів

    // Оновлюємо текст label
    if (fileCount === 0) {
        label.innerText = 'Виберіть фото';
    } else if (fileCount === 1) {
        label.innerText = selectedBrandFiles[0].name;
    } else {
        label.innerText = fileCount + ' файлів обрано';
    }

    // Очищаємо прев’ю перед новим відмальовуванням
    previewContainer.innerHTML = '';

    // Малюємо прев’ю з selectedBrandFiles
    selectedBrandFiles.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const previewItem = document.createElement('div');
            previewItem.classList.add('preview-item');

            previewItem.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}" class="preview-image">
                <button type="button" class="remove-btn" onclick="removeBrandFile(${index})">&times;</button>
            `;

            previewContainer.appendChild(previewItem);
        };

        reader.readAsDataURL(file);
    });

    // Візуальний фідбек для кнопки (тільки для .file-input-label)
    const fileInputLabel = document.querySelector('.file-input-label');
    if (fileInputLabel) {
        if (fileCount > 0) {
            fileInputLabel.style.backgroundColor = '#5a8a7f'; // Бірюзовий колір при виборі файлу
            fileInputLabel.style.color = '#ffffff'; // Змінюємо колір тексту для контрасту
        } else {
            fileInputLabel.style.backgroundColor = '#72A499'; // Початковий колір
            fileInputLabel.style.color = '$primary3'; // Повертаємо початковий колір тексту
        }
    }
}

// Обробка зміни файлу
document.getElementById('image').addEventListener('change', function (e) {
    selectedBrandFiles = Array.from(e.target.files); // Оновлюємо масив файлів
    updateBrandFileLabel();
});

// Видалення файлу з прев’ю для логотипу бренду
function removeBrandFile(index) {
    const previewContainer = document.getElementById('preview-container');
    const previewItem = previewContainer.children[index];

    // Додаємо клас анімації
    previewItem.classList.add('fade-out');

    // Після завершення анімації реально видаляємо
    setTimeout(() => {
        selectedBrandFiles.splice(index, 1);

        // Оновлюємо FileList
        const dataTransfer = new DataTransfer();
        selectedBrandFiles.forEach(file => dataTransfer.items.add(file));

        const input = document.getElementById('image');
        input.files = dataTransfer.files;

        // Перезапускаємо updateBrandFileLabel
        updateBrandFileLabel();
    }, 400); // Час відповідає transition у CSS
}

// Функція вибору бренду
function selectBrand(item) {
    // Знімаємо виділення з усіх брендів
    document.querySelectorAll('.brand-item').forEach(function (b) {
        b.classList.remove('selected'); // Видаляємо клас selected
    });

    // Виділяємо вибраний бренд
    item.classList.add('selected'); // Додаємо клас selected

    // Отримуємо id бренду з data-атрибута і записуємо у приховане поле
    const selectedBrandId = item.dataset.id;
    document.getElementById('selectedBrand').value = selectedBrandId || '';
}

// Додаємо обробник подій для всіх брендів після завантаження сторінки
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.brand-item').forEach(function (item) {
        item.addEventListener('click', function () {
            selectBrand(this);
        });
    });
});


