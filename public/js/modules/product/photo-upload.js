document.addEventListener('DOMContentLoaded', function () {
    const dropZone  = document.getElementById('fileDropZone');
    const fileInput = document.getElementById('product_photo');
    const countSpan = document.getElementById('photoCount');
    const badgeSpan = document.getElementById('photoCountBadge');
    const badge     = document.getElementById('photoCounterBadge');
    const errorBox  = document.getElementById('uploadError');

    console.log('[photo-upload] init', { dropZone: !!dropZone, fileInput: !!fileInput });

    if (!dropZone || !fileInput) return;

    const MAX_FILES = 10;
    const storedFiles = new DataTransfer(); // 🔑 ЄДИНЕ СХОВИЩЕ

    function updateCounter() {
        const count = storedFiles.files.length;

        console.log('[photo-upload] updateCounter ->', count);

        if (countSpan) countSpan.textContent = count;
        if (badgeSpan) badgeSpan.textContent = count;
        if (badge) badge.classList.toggle('show', count > 0);
    }

    function showError(msg) {
        console.log('[photo-upload] error:', msg);

        if (!errorBox) return;
        errorBox.textContent = msg;
        errorBox.style.display = 'block';
        setTimeout(() => errorBox.style.display = 'none', 5000);
    }

    function addFiles(files) {
        console.log('[photo-upload] addFiles called, incoming:', files?.length ?? 0);

        for (const file of files) {
            if (storedFiles.files.length >= MAX_FILES) {
                showError('Максимум 10 фото');
                break;
            }

            if (!file.type.startsWith('image/')) {
                showError('Дозволені тільки зображення');
                continue;
            }

            if (file.size > 10 * 1024 * 1024) {
                showError(`${file.name} — більше 10 МБ`);
                continue;
            }

            storedFiles.items.add(file);
        }

        fileInput.files = storedFiles.files; // 🔗 синхронізація
        console.log('[photo-upload] stored now:', fileInput.files.length);

        updateCounter();
    }

    // 🟣 Drag & drop
    ['dragover', 'drop'].forEach(ev => {
        dropZone.addEventListener(ev, e => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    dropZone.addEventListener('dragenter', () => dropZone.classList.add('drag-over'));
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        dropZone.classList.remove('drag-over');
        addFiles(e.dataTransfer.files);
    });

    // 🟢 Click → file picker
    dropZone.addEventListener('click', () => {
        console.log('[photo-upload] click -> open picker');
        fileInput.value = '';          // дозволяє знову вибрати ті самі файли
        fileInput.click();
    });

    // ✅ ОСЬ ЦЕ ГОЛОВНЕ: picker change
    fileInput.addEventListener('change', () => {
        console.log('[photo-upload] change fired, files:', fileInput.files.length);
        if (fileInput.files && fileInput.files.length) {
            addFiles(fileInput.files);
        }
    });

    updateCounter();
});
