@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ────────────────────────────────────────────────
            // 1. Синхронізація полів content / tags / social
            // ────────────────────────────────────────────────
            const $form = $('#product-form');
            if ($form.length) {
                const contentEl    = document.getElementById('content');
                const tagsEl       = document.getElementById('tags');
                const socialEl     = document.getElementById('social_links');

                const contentHidden = document.getElementById('content-hidden');
                const tagsHidden    = document.getElementById('tags-hidden');
                const socialHidden  = document.getElementById('social-links-hidden');

                function syncExtraFields() {
                    if (contentHidden && contentEl) contentHidden.value = contentEl.value || '';
                    if (tagsHidden    && tagsEl)    tagsHidden.value    = tagsEl.value    || '';
                    if (socialHidden  && socialEl)  socialHidden.value  = socialEl.value  || '';
                }

                [contentEl, tagsEl, socialEl].forEach(el => {
                    if (el) {
                        el.addEventListener('input', syncExtraFields);
                        el.addEventListener('change', syncExtraFields);
                    }
                });

                $form.on('submit', function () {
                    syncExtraFields();

                    $('#title-hidden').val($('#title').text().trim());
                    $('#price-hidden').val($('#price').text().replace(/\s+/g, '').trim());

                    // кольори
                    $('input[name="color_ids[]"]').remove();
                    $('.color-circle.selected').each(function () {
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'color_ids[]')
                            .val($(this).data('id'))
                            .appendTo('#product-form');
                    });

                    const selectedColorEl = document.getElementById('selectedColor');
                    if (selectedColorEl) {
                        const first = document.querySelector('.color-circle.selected');
                        selectedColorEl.value = first ? (first.dataset.id || '') : '';
                    }
                });

                syncExtraFields();
            }

            // ────────────────────────────────────────────────
            // 2. Логіка головного фото (make-main-btn) — create
            // ────────────────────────────────────────────────
            const gallery = document.querySelector('#product-gallery');
            if (gallery) {
                function updateMainPhotoButtons(newMainIndex) {
                    const buttons = gallery.querySelectorAll('.make-main-btn');
                    if (!buttons.length) return;

                    buttons.forEach((btn, idx) => {
                        const isMain = idx === newMainIndex;

                        btn.classList.toggle('is-main', isMain);
                        const span = btn.querySelector('span');
                        if (span) {
                            span.textContent = isMain ? 'Головне фото' : 'Зробити головним';
                        }
                        btn.title = isMain ? 'Це головне фото' : 'Зробити головним';

                        // зберігаємо індекс
                        const hidden = document.getElementById('main_photo_index');
                        if (hidden) hidden.value = newMainIndex;
                    });
                }

                gallery.addEventListener('click', function (e) {
                    const btn = e.target.closest('.make-main-btn[data-index]');  // ← data-index
                    if (!btn) return;
                    if (btn.classList.contains('is-main')) return;

                    const index = parseInt(btn.dataset.index, 10);
                    if (isNaN(index)) return;

                    updateMainPhotoButtons(index);

                    btn.style.transform = 'scale(1.15)';
                    setTimeout(() => btn.style.transform = '', 300);
                });

                // Ініціалізація: якщо вже є фото — перше головне
                const initialPhotos = gallery.querySelectorAll('.product-zoom');
                if (initialPhotos.length > 0) {
                    updateMainPhotoButtons(0);
                }
            }

            // ────────────────────────────────────────────────
            // 3. Відновлення кастомних dropdown-ів
            // ────────────────────────────────────────────────
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const hidden = dropdown.querySelector('input[type="hidden"]');
                if (!hidden || !hidden.value) return;

                const option = dropdown.querySelector(`li[data-value="${hidden.value}"]`);
                if (option) {
                    const text = dropdown.querySelector('.selected-text');
                    if (text) text.textContent = option.textContent.trim();
                    dropdown.querySelector('.dropdown-selected')?.classList.add('selected-value');
                }
            });
        });
    </script>

    <script src="{{ asset('js/modules/product/price-input.js') }}"></script>
    <script src="{{ asset('js/modules/product/quantity-term_creation.js') }}"></script>
    <script src="{{ asset('js/modules/product/colors.js') }}"></script>
    <script src="{{ asset('js/modules/product/photo-upload.js') }}"></script>
    <script src="{{ asset('js/modules/product/brand-gallery.js') }}"></script>
@endpush
