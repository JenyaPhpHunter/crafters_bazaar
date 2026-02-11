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

    function reInitProductSliders() {
        if (!window.jQuery) return;
        const $ = window.jQuery;

        const $gallery = $('#product-gallery');
        const $thumbs  = $('#productThumbSlider');

        if ($gallery.hasClass('slick-initialized')) $gallery.slick('unslick');
        if ($thumbs.hasClass('slick-initialized'))  $thumbs.slick('unslick');

        if ($gallery.children().length) {
            $gallery.slick({
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '#productThumbSlider',
                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>',
                appendArrows: '#product-gallery'
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

    function renderGalleryFromFiles() {
        // знести slick перед зміною DOM
        if (window.jQuery) {
            const $ = window.jQuery;
            const $gallery = $('#product-gallery');
            const $thumbs  = $('#productThumbSlider');
            if ($gallery.hasClass('slick-initialized')) $gallery.slick('unslick');
            if ($thumbs.hasClass('slick-initialized'))  $thumbs.slick('unslick');
        }

        thumbSliderEl.innerHTML = '';
        gallerySliderEl.innerHTML = '';

        const mainIdx = Number(document.getElementById('main_photo_index')?.value || 0);

        Array.from(storedFiles.files).forEach((file, idx) => {
            const url = URL.createObjectURL(file);
            const isMain = (idx === mainIdx);

            // thumbs
            const thumbItem = document.createElement('div');
            thumbItem.className = 'item' + (isMain ? ' is-main-thumb' : '');
            thumbItem.innerHTML = `<img src="${url}" alt="Thumb ${idx + 1}">`;
            thumbSliderEl.appendChild(thumbItem);

            // gallery
            const link = document.createElement('a');
            link.className = 'product-zoom';
            link.href = url;
            link.setAttribute('data-pswp-width', '1200');
            link.setAttribute('data-pswp-height', '1600');

            link.innerHTML = `
                <img src="${url}" alt="Product ${idx + 1}">
                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>

                <button
                    type="button"
                    class="make-main-btn ${isMain ? 'is-main' : ''}"
                    data-local-index="${idx}"
                    title="${isMain ? 'Головне фото' : 'Зробити головним фото'}"
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
    }

    // ✅ ОДИН обробник кліку — ЗОВНІ renderGalleryFromFiles
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.make-main-btn[data-local-index]');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation(); // зупиняємо всі події

        // Якщо вже головне — нічого не робимо
        if (btn.classList.contains('is-main')) return;

        const idx = Number(btn.dataset.localIndex);
        const hidden = document.getElementById('main_photo_index');
        if (hidden) hidden.value = String(idx);

        console.log('Main photo index set to:', idx); // debug

        // ✅ ОНОВЛЮЄМО UI БЕЗ REBUILD — тільки класи та текст
        updateMainPhotoUI(idx);
    }, true); // capture phase!

    // ✅ Функція оновлення UI без rebuild
    function updateMainPhotoUI(newMainIndex) {
        // 1. Оновлюємо всі кнопки в галереї
        document.querySelectorAll('.make-main-btn').forEach((button, i) => {
            const isMain = (i === newMainIndex);
            const icon = button.querySelector('i');
            const span = button.querySelector('span');

            if (isMain) {
                button.classList.add('is-main');
                button.title = 'Головне фото';
                if (icon) icon.className = 'fa-solid fa-star';
                if (span) span.textContent = 'Головне фото';
            } else {
                button.classList.remove('is-main');
                button.title = 'Зробити головним фото';
                if (icon) icon.className = 'fa-solid fa-star-half-stroke';
                if (span) span.textContent = 'Зробити головним';
            }
        });

        // 2. Оновлюємо thumbs зліва
        document.querySelectorAll('#productThumbSlider .item').forEach((item, i) => {
            if (i === newMainIndex) {
                item.classList.add('is-main-thumb');
            } else {
                item.classList.remove('is-main-thumb');
            }
        });
    }

    function addFiles(fileList) {
        const files = Array.from(fileList || []);
        for (const file of files) {
            if (storedFiles.files.length >= MAX_FILES) { showError('Максимум 10 фото'); break; }
            if (!file.type.startsWith('image/')) { showError('Дозволені тільки зображення'); continue; }
            if (file.size > 10 * 1024 * 1024) { showError(`${file.name} — більше 10 МБ`); continue; }
            storedFiles.items.add(file);
        }

        fileInput.files = storedFiles.files;

        updateCounter();
        renderGalleryFromFiles();

        if (window.jQuery) window.jQuery(document).trigger('field-updated');
    }

    // DnD
    ['dragover', 'drop'].forEach(ev =>
        dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); })
    );
    dropZone.addEventListener('dragenter', () => dropZone.classList.add('drag-over'));
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => { dropZone.classList.remove('drag-over'); addFiles(e.dataTransfer.files); });

    // picker
    dropZone.addEventListener('click', () => { fileInput.value = ''; fileInput.click(); });
    fileInput.addEventListener('change', () => { if (fileInput.files?.length) addFiles(fileInput.files); });

    updateCounter();
    renderGalleryFromFiles();
});
