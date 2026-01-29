@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const $form = $('#product-form');
            if (!$form.length) return;

            // поля зліва (поза формою)
            const contentEl = document.getElementById('content');
            const tagsEl = document.getElementById('tags');
            const socialEl = document.getElementById('social_links');

            // hidden поля у формі
            const contentHidden = document.getElementById('content-hidden');
            const tagsHidden = document.getElementById('tags-hidden');
            const socialHidden = document.getElementById('social-links-hidden');

            function syncExtraFields() {
                if (contentHidden && contentEl) contentHidden.value = contentEl.value || '';
                if (tagsHidden && tagsEl) tagsHidden.value = tagsEl.value || '';
                if (socialHidden && socialEl) socialHidden.value = socialEl.value || '';
            }

            // синхронізація під час введення (не обов’язково, але зручно)
            [contentEl, tagsEl, socialEl].forEach((el) => {
                if (!el) return;
                el.addEventListener('input', syncExtraFields);
                el.addEventListener('change', syncExtraFields);
            });

            // один submit handler
            $form.on('submit', function () {

                // 0) синхронізувати content/tags/social_links у hidden
                syncExtraFields();

                // TITLE
                $('#title-hidden').val($('#title').text().trim());

                // PRICE
                $('#price-hidden').val(
                    $('#price').text().replace(/\s+/g, '').trim()
                );

                // COLORS: видаляємо старі hidden та додаємо нові
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

            // Відновлення кастомних dropdown-ів
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const hidden = dropdown.querySelector('input[type="hidden"]');
                if (!hidden || !hidden.value) return;

                const option = dropdown.querySelector(`li[data-value="${hidden.value}"]`);
                if (option) {
                    const text = dropdown.querySelector('.selected-text');
                    text.textContent = option.textContent.trim();
                    dropdown.querySelector('.dropdown-selected')
                        .classList.add('selected-value');
                }
            });

            // одразу синхронізувати (щоб hidden не були пусті)
            syncExtraFields();
        });
    </script>

    <script src="{{ asset('js/modules/product/price-input.js') }}"></script>
    <script src="{{ asset('js/modules/product/quantity-term_creation.js') }}"></script>
    <script src="{{ asset('js/modules/product/colors.js') }}"></script>
    <script src="{{ asset('js/modules/product/photo-upload.js') }}"></script>
    <script src="{{ asset('js/modules/product/brand-gallery.js') }}"></script>
@endpush
