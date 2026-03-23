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

    // Існуючі фото з БД (передаються з blade через window.existingPhotos)
    // Формат: [{ id, src, main, thumb, is_main }]
    let existingPhotos = (window.existingPhotos || []).map(p => ({ ...p, deleted: false }));

    // ────────────────────────────────────────────────
    // Лічильник — існуючі (не видалені) + нові
    // ────────────────────────────────────────────────
    function totalCount() {
        return existingPhotos.filter(p => !p.deleted).length + storedFiles.files.length;
    }

    function updateCounter() {
        const count = totalCount();
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
    // Синхронізація deleted_photo_ids у форму
    // ────────────────────────────────────────────────
    function syncDeletedPhotos() {
        const container = document.getElementById('deleted-photos-container');
        if (!container) return;

        container.innerHTML = '';
        existingPhotos
            .filter(p => p.deleted)
            .forEach(p => {
                const input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = 'deleted_photo_ids[]';
                input.value = p.id;
                container.appendChild(input);
            });
    }

    // ────────────────────────────────────────────────
    // Оновлення UI головного фото
    // ────────────────────────────────────────────────
    function updateMainPhotoUI(newMainIndex) {
        const currentButtons = gallerySliderEl.querySelectorAll('.product-zoom:not(.slick-cloned) .make-main-btn');
        currentButtons.forEach((button, i) => {
            const isMain = (i === newMainIndex);
            const icon = button.querySelector('i');
            const span = button.querySelector('span');

            button.classList.toggle('is-main', isMain);
            button.title = isMain ? 'Головне фото' : 'Зробити головним';

            if (icon) icon.className = isMain ? 'fa-solid fa-star' : 'fa-solid fa-star-half-stroke';
            if (span) span.textContent = isMain ? 'Головне фото' : 'Зробити головним';
        });

        const currentThumbs = thumbSliderEl.querySelectorAll('.item');
        currentThumbs.forEach((item, i) => {
            item.classList.toggle('is-main-thumb', i === newMainIndex);
        });

        const hidden = document.getElementById('main_photo_index');
        if (hidden) hidden.value = String(newMainIndex);

        if (window.jQuery) {
            const $ = window.jQuery;
            if ($('#product-gallery').hasClass('slick-initialized')) $('#product-gallery').slick('refresh');
            if ($('#productThumbSlider').hasClass('slick-initialized')) $('#productThumbSlider').slick('refresh');
        }
    }

    // ────────────────────────────────────────────────
    // Повна перебудова галереї
    // ────────────────────────────────────────────────
    function renderGallery() {
        const mainIdx = Number(document.getElementById('main_photo_index')?.value || 0);

        // Знищення Slick
        if (window.jQuery) {
            const $ = window.jQuery;
            const $gallery = $('#product-gallery');
            const $thumbs  = $('#productThumbSlider');

            if ($gallery.hasClass('slick-initialized')) $gallery.slick('unslick');
            if ($thumbs.hasClass('slick-initialized'))  $thumbs.slick('unslick');

            $gallery.empty().removeClass('slick-initialized slick-slider slick-dotted');
            $thumbs.empty().removeClass('slick-initialized slick-slider');
        }

        thumbSliderEl.innerHTML = '';
        gallerySliderEl.innerHTML = '';

        document.querySelectorAll('img[src^="blob:"]').forEach(img => URL.revokeObjectURL(img.src));
        document.querySelectorAll('.slick-cloned').forEach(el => el.remove());

        let globalIdx = 0;

        // 1. Існуючі фото з БД (не видалені)
        existingPhotos.filter(p => !p.deleted).forEach((photo, i) => {
            const isMain = (globalIdx === mainIdx);

            // Thumb
            const thumbItem = document.createElement('div');
            thumbItem.className = 'item' + (isMain ? ' is-main-thumb' : '');
            thumbItem.innerHTML = `<img src="${photo.thumb}" alt="Thumb ${globalIdx + 1}">`;
            thumbSliderEl.appendChild(thumbItem);

            // Gallery
            const link = document.createElement('a');
            link.className = 'product-zoom';
            link.href = photo.src;
            link.dataset.pswpSrc    = photo.src;
            link.dataset.pswpWidth  = '1200';
            link.dataset.pswpHeight = '1600';
            link.dataset.index      = globalIdx;
            link.dataset.photoId    = photo.id; // id з БД

            link.innerHTML = `
                <img src="${photo.main}" alt="Product ${globalIdx + 1}">
                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
                <button type="button" class="make-main-btn ${isMain ? 'is-main' : ''}"
                    data-index="${globalIdx}"
                    title="${isMain ? 'Головне фото' : 'Зробити головним'}">
                    <i class="fa-solid ${isMain ? 'fa-star' : 'fa-star-half-stroke'}"></i>
                    <span>${isMain ? 'Головне фото' : 'Зробити головним'}</span>
                </button>
                <button type="button" class="delete-photo-btn" data-photo-id="${photo.id}" title="Видалити фото">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            gallerySliderEl.appendChild(link);
            globalIdx++;
        });

        // 2. Нові файли
        Array.from(storedFiles.files).forEach((file, i) => {
            const url    = URL.createObjectURL(file);
            const isMain = (globalIdx === mainIdx);

            // Thumb
            const thumbItem = document.createElement('div');
            thumbItem.className = 'item' + (isMain ? ' is-main-thumb' : '');
            thumbItem.innerHTML = `<img src="${url}" alt="Thumb ${globalIdx + 1}">`;
            thumbSliderEl.appendChild(thumbItem);

            // Gallery
            const link = document.createElement('a');
            link.className = 'product-zoom';
            link.href = url;
            link.dataset.pswpSrc    = url;
            link.dataset.pswpWidth  = '1200';
            link.dataset.pswpHeight = '1600';
            link.dataset.index      = globalIdx;
            link.dataset.newFileIdx = i; // індекс в storedFiles

            link.innerHTML = `
                <img src="${url}" alt="Product ${globalIdx + 1}">
                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
                <button type="button" class="make-main-btn ${isMain ? 'is-main' : ''}"
                    data-index="${globalIdx}"
                    title="${isMain ? 'Головне фото' : 'Зробити головним'}">
                    <i class="fa-solid ${isMain ? 'fa-star' : 'fa-star-half-stroke'}"></i>
                    <span>${isMain ? 'Головне фото' : 'Зробити головним'}</span>
                </button>
                <button type="button" class="delete-photo-btn" data-new-file-idx="${i}" title="Видалити фото">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            gallerySliderEl.appendChild(link);
            globalIdx++;
        });

        reInitProductSliders();

        if (window.__pswpLightbox && typeof window.__pswpLightbox.refresh === 'function') {
            window.__pswpLightbox.refresh();
        }

        if (totalCount() > 0) {
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
    // Обробник кліків — головне фото і видалення
    // ────────────────────────────────────────────────
    document.addEventListener('click', function (e) {

        // Кнопка "Зробити головним"
        const mainBtn = e.target.closest('.make-main-btn');
        if (mainBtn && !mainBtn.classList.contains('is-main')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            const parent = mainBtn.closest('.product-zoom');
            if (!parent) return;

            const idx = Number(parent.dataset.index);
            if (!isNaN(idx)) {
                updateMainPhotoUI(idx);
                mainBtn.style.transform = 'scale(1.15)';
                setTimeout(() => mainBtn.style.transform = '', 300);
            }
            return;
        }

        // Кнопка видалення
        const deleteBtn = e.target.closest('.delete-photo-btn');
        if (deleteBtn) {
            e.preventDefault();
            e.stopPropagation();

            const photoId    = deleteBtn.dataset.photoId;
            const newFileIdx = deleteBtn.dataset.newFileIdx;

            if (photoId) {
                // Видалення існуючого фото з БД — позначаємо як deleted
                const photo = existingPhotos.find(p => String(p.id) === String(photoId));
                if (photo) {
                    photo.deleted = true;
                    syncDeletedPhotos();
                }
            } else if (newFileIdx !== undefined) {
                // Видалення нового файлу
                const idx = Number(newFileIdx);
                const newDt = new DataTransfer();
                Array.from(storedFiles.files).forEach((f, i) => {
                    if (i !== idx) newDt.items.add(f);
                });
                // Очищаємо і заповнюємо знову
                while (storedFiles.items.length) storedFiles.items.remove(0);
                Array.from(newDt.files).forEach(f => storedFiles.items.add(f));
                fileInput.files = storedFiles.files;
            }

            // Скидаємо main_photo_index якщо видалили головне
            const currentMain = Number(document.getElementById('main_photo_index')?.value || 0);
            const parent = deleteBtn.closest('.product-zoom');
            if (parent && Number(parent.dataset.index) === currentMain) {
                const hidden = document.getElementById('main_photo_index');
                if (hidden) hidden.value = '0';
            }

            updateCounter();
            renderGallery();

            if (window.jQuery) window.jQuery(document).trigger('field-updated');
        }

    }, true);

    // ────────────────────────────────────────────────
    // Додавання файлів
    // ────────────────────────────────────────────────
    function addFiles(fileList) {
        const files = Array.from(fileList || []);
        let added = false;

        for (const file of files) {
            if (totalCount() >= MAX_FILES) {
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
            renderGallery();
            if (window.jQuery) window.jQuery(document).trigger('field-updated');
        }
    }

    // Drag & Drop та клік
    ['dragover', 'drop'].forEach(ev =>
        dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); })
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

    // ────────────────────────────────────────────────
    // Ініціалізація
    // ────────────────────────────────────────────────
    updateCounter();
    if (totalCount() > 0) {
        renderGallery();
    }
});
