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
            $(document).trigger('field-updated'); // ← ЦЕ ВАЖЛИВО
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

