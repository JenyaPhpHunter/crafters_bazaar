document.addEventListener('DOMContentLoaded', function () {
    const dropZone  = document.getElementById('fileDropZone');
    const fileInput = document.getElementById('product_photo');

    const countSpan = document.getElementById('photoCount');
    const badgeSpan = document.getElementById('photoCountBadge');
    const badge     = document.getElementById('photoCounterBadge');
    const errorBox  = document.getElementById('uploadError');

    const thumbSliderEl   = document.getElementById('productThumbSlider');
    const gallerySliderEl = document.getElementById('product-gallery');

    if (!dropZone || !fileInput || !thumbSliderEl || !gallerySliderEl) return;

    const MAX_FILES = 10;
    const storedFiles = new DataTransfer();

    // ────────────────────────────────────────────────
    // Функції оновлення лічильника та помилок
    // ────────────────────────────────────────────────
    function updateCounter() {
        const count = storedFiles.files.length;
        if (countSpan) countSpan.textContent = count;
        if (badgeSpan) badgeSpan.textContent = count;
        if (badge) badge.classList.toggle('show', count > 0);
    }

    function showError(msg) {
        if (!errorBox) return;
        errorBox.textContent = msg;
        errorBox.style.display = 'block';
        setTimeout(() => errorBox.style.display = 'none', 5000);
    }

    // ────────────────────────────────────────────────
    // Оновлення UI головного фото
    // ────────────────────────────────────────────────
    function updateMainPhotoUI(newMainIndex) {
        // Оновлюємо ТІЛЬКИ оригінальні елементи (без slick-cloned)
        const currentButtons = gallerySliderEl.querySelectorAll('.make-main-btn:not(.slick-cloned .make-main-btn)');
        currentButtons.forEach((button, i) => {
            const isMain = (i === newMainIndex);
            const icon = button.querySelector('i');
            const span = button.querySelector('span');

            button.classList.toggle('is-main', isMain);
            button.title = isMain ? 'Головне фото' : 'Зробити головним';

            if (icon) icon.className = isMain ? 'fa-solid fa-star' : 'fa-solid fa-star-half-stroke';
            if (span) span.textContent = isMain ? 'Головне фото' : 'Зробити головним';
        });

        // Оновлюємо thumbs (вони не клонуються Slick)
        const currentThumbs = thumbSliderEl.querySelectorAll('.item');
        currentThumbs.forEach((item, i) => {
            item.classList.toggle('is-main-thumb', i === newMainIndex);
        });

        // Зберігаємо індекс
        const hidden = document.getElementById('main_photo_index');
        if (hidden) hidden.value = String(newMainIndex);

        // Оновлюємо Slick
        if (window.jQuery) {
            const $ = window.jQuery;
            const $gallery = $('#product-gallery');
            const $thumbs  = $('#productThumbSlider');

            if ($gallery.hasClass('slick-initialized')) $gallery.slick('refresh');
            if ($thumbs.hasClass('slick-initialized'))  $thumbs.slick('refresh');
        }
    }

    // ────────────────────────────────────────────────
    // Повна перебудова галереї
    // ────────────────────────────────────────────────
    function renderGalleryFromFiles() {
        const mainIdx = Number(document.getElementById('main_photo_index')?.value || 0);

        // 1. Повне знищення Slick
        if (window.jQuery) {
            const $ = window.jQuery;
            const $gallery = $('#product-gallery');
            const $thumbs  = $('#productThumbSlider');

            if ($gallery.hasClass('slick-initialized')) $gallery.slick('unslick');
            if ($thumbs.hasClass('slick-initialized')) $thumbs.slick('unslick');

            // Очищаємо DOM повністю
            $gallery.empty().removeClass('slick-initialized slick-slider slick-dotted');
            $thumbs.empty().removeClass('slick-initialized slick-slider');
        }

        thumbSliderEl.innerHTML = '';
        gallerySliderEl.innerHTML = '';

        // Очищення blob-URL
        document.querySelectorAll('img[src^="blob:"]').forEach(img => {
            URL.revokeObjectURL(img.src);
        });

        // Видалення всіх slick-cloned (на всяк випадок)
        document.querySelectorAll('.slick-cloned').forEach(el => el.remove());

        // Створюємо нові елементи
        Array.from(storedFiles.files).forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const isMain = (idx === mainIdx);

            // Thumb
            const thumbItem = document.createElement('div');
            thumbItem.className = 'item' + (isMain ? ' is-main-thumb' : '');
            thumbItem.innerHTML = `<img src="${url}" alt="Thumb ${idx + 1}">`;
            thumbSliderEl.appendChild(thumbItem);

            // Gallery
            const link = document.createElement('a');
            link.className = 'product-zoom';
            link.href = url;
            link.dataset.pswpSrc = url;
            link.dataset.pswpWidth = '1200';
            link.dataset.pswpHeight = '1600';
            link.dataset.index = idx;

            link.innerHTML = `
                <img src="${url}" alt="Product ${idx + 1}">
                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
                <button
                    type="button"
                    class="make-main-btn ${isMain ? 'is-main' : ''}"
                    data-index="${idx}"
                    title="${isMain ? 'Головне фото' : 'Зробити головним'}"
                >
                    <i class="fa-solid ${isMain ? 'fa-star' : 'fa-star-half-stroke'}"></i>
                    <span>${isMain ? 'Головне фото' : 'Зробити головним'}</span>
                </button>
            `;

            gallerySliderEl.appendChild(link);
        });

        reInitProductSliders();

        if (window.__pswpLightbox && typeof window.__pswpLightbox.refresh === 'function') {
            window.__pswpLightbox.refresh();
        }

        if (storedFiles.files.length > 0) {
            updateMainPhotoUI(mainIdx);
        }
    }

    function reInitProductSliders() {
        if (!window.jQuery) return;
        const $ = window.jQuery;

        const $gallery = $('#product-gallery');
        const $thumbs  = $('#productThumbSlider');

        if ($gallery.children().length) {
            $gallery.slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '#productThumbSlider',
                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>',
                appendArrows: '#product-gallery',
                // Важливо: вимикаємо клонування, щоб не було дублів
                centerMode: false,
                variableWidth: false
            });
        }

        if ($thumbs.children().length) {
            $thumbs.slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                vertical: true,
                verticalSwiping: true,
                focusOnSelect: true,
                asNavFor: '#product-gallery',
                arrows: false,
                dots: false
            });
        }
    }

    // ────────────────────────────────────────────────
    // Обробник кліку
    // ────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.make-main-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (btn.classList.contains('is-main')) return;

        const parent = btn.closest('.product-zoom');
        if (!parent) return;

        const idx = Number(parent.dataset.index);
        if (isNaN(idx)) return;

        updateMainPhotoUI(idx);

        btn.style.transform = 'scale(1.15)';
        setTimeout(() => btn.style.transform = '', 300);
    }, true);

    // ────────────────────────────────────────────────
    // Додавання файлів
    // ────────────────────────────────────────────────
    function addFiles(fileList) {
        const files = Array.from(fileList || []);
        let added = false;

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
            added = true;
        }

        if (added) {
            fileInput.files = storedFiles.files;
            updateCounter();
            renderGalleryFromFiles();

            if (storedFiles.files.length === 1) {
                updateMainPhotoUI(0);
            }

            if (window.jQuery) window.jQuery(document).trigger('field-updated');
        }
    }

    // Drag & Drop та клік
    ['dragover', 'drop'].forEach(ev =>
        dropZone.addEventListener(ev, e => {
            e.preventDefault();
            e.stopPropagation();
        })
    );

    dropZone.addEventListener('dragenter', () => dropZone.classList.add('drag-over'));
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        dropZone.classList.remove('drag-over');
        addFiles(e.dataTransfer.files);
    });

    dropZone.addEventListener('click', () => {
        fileInput.value = '';
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files?.length) addFiles(fileInput.files);
    });

    updateCounter();
    renderGalleryFromFiles();
});
