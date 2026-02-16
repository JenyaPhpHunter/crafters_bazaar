// public/js/modules/product/common.js
(function ($) {
    "use strict";

    // === WISHLIST ===
    (function () {
        if (typeof mojs === 'undefined') return;

        const burst = new mojs.Burst({
            left: 0, top: 0,
            radius: { 4: 32 },
            angle: 45,
            count: 14,
            children: {
                radius: 2.5,
                fill: ['#F8796C'],
                scale: { 1: 0, easing: 'quad.in' },
                pathScale: [.8, null],
                degreeShift: [13, null],
                duration: [500, 700],
                easing: 'quint.out'
            }
        });

        $('.add-to-wishlist').on('click', function (e) {
            const $this = $(this);
            const productId = $this.data('product-id');

            if (!$this.hasClass('wishlist-added')) {
                e.preventDefault();
                $this.addClass('wishlist-added').find('i').removeClass('far').addClass('fas');

                const coords = {
                    x: $this.offset().left + $this.width() / 2,
                    y: $this.offset().top + $this.height() / 2
                };

                burst.tune(coords).replay();
                window.location.href = "/wishlist/index/" + productId;
            }
        });
    })();

    // === QUANTITY ===
    $('.qty-btn').on('click', function (e) {
        e.preventDefault();

        const $this = $(this);
        const $input = $this.siblings('.qty-input');

        let oldValue = parseFloat($input.val()) || 0;
        const delta = $this.hasClass('plus') ? 1 : -1;
        let newVal = Math.max(0, oldValue + delta);

        $input.val(newVal).trigger('change');
    });

    // === QUICK VIEW MODAL ===
    $('#quickViewModal').on('shown.bs.modal', function () {
        if (typeof Learts?.sliders?.initSlick === 'function') {
            Learts.sliders.initSlick($('.product-gallery-slider-quickview'), {
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
            });
        }
    });

    // === КАСТОМНА ЛОГІКА (універсальна для всіх сторінок з товаром) ===
    $(document).ready(function () {
        $('.buy-btn').on('click', function (e) {
            e.preventDefault();
            $(this).siblings('.product-details').slideDown(400);
        });
    });

    // === ГЛОБАЛЬНА ФУНКЦІЯ ДЛЯ ФАЙЛІВ ===
    window.updateFileLabel = function (input) {
        const fileLabel = document.getElementById('file-label');
        if (!fileLabel) return;

        if (input.files.length > 0) {
            fileLabel.textContent = input.files.length + ' фото обрано';
            fileLabel.style.backgroundColor = '#006666';
            fileLabel.style.color = '#F5F5DC';
        } else {
            fileLabel.textContent = 'Виберіть фото';
            fileLabel.style.backgroundColor = '#00CED1';
            fileLabel.style.color = '#D2B48C';
        }
    };

    // Make photo main (admin only UI)
    $(document).on('click', '.make-main-badge', async function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        const photoId = $btn.data('photo-id');
        if (!photoId) return;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrf) {
            console.error('CSRF token meta tag not found');
            alert('CSRF token не знайдено. Перевір <meta name="csrf-token"> у layout.');
            return;
        }

        $btn.addClass('is-loading');

        try {
            const res = await fetch(`/product-photos/${photoId}/make-main`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (!res.ok) {
                let msg = `Request failed (${res.status})`;
                try {
                    const json = await res.json();
                    if (json?.message) msg = json.message;
                } catch (_) {}
                throw new Error(msg);
            }

            // ✅ UI: зробити це фото "головним" без reload
            makePhotoMainInUI(photoId);

            // (не обов’язково) маленький фідбек
            // alert('Головне фото оновлено');

        } catch (err) {
            console.error(err);
            alert('Не вдалося зробити фото головним: ' + (err?.message || 'помилка'));
        } finally {
            $btn.removeClass('is-loading');
        }
    });

    function makePhotoMainInUI(photoId) {
        const $gallery = $('#product-gallery');          // твій id галереї
        const $thumbs  = $('#productThumbSlider');       // твій id прев’ю (thumbs)

        // 1) знайти індекс слайду в slick по data-photo-id
        let targetIndex = null;

        // slick додає дублікати, тому беремо перший реальний елемент
        $gallery.find('a.product-zoom').each(function () {
            const pid = String($(this).data('photo-id') ?? '');
            if (pid === String(photoId)) {
                // slick-index сидить на .slick-slide
                const $slide = $(this).closest('.slick-slide');
                const idx = $slide.data('slick-index');
                if (idx !== undefined && idx !== null) targetIndex = Number(idx);
                return false; // break
            }
        });

        // 2) перейти на це фото в галереї
        if ($gallery.hasClass('slick-initialized') && targetIndex !== null) {
            $gallery.slick('slickGoTo', targetIndex, true);
        }

        // 3) оновити бейджі/кнопки "Головне"
        //    - прибрати "main" з усіх
        $('.make-main-badge').removeClass('is-main').text('Зробити головним фото');

        //    - поставити "main" на поточне
        const $newMainBtn = $(`.make-main-badge[data-photo-id="${photoId}"]`);
        $newMainBtn.addClass('is-main').text('Головне фото');

        // 4) (опціонально) підсвітити thumb зліва
        if ($thumbs.length) {
            $thumbs.find('.item').removeClass('is-main-thumb');
            $thumbs.find(`.item[data-photo-id="${photoId}"]`).addClass('is-main-thumb');
        }
    }

    // ЕКСПОРТ
    window.Learts = window.Learts || {};
    Learts.product = Learts.product || {};
    Learts.product.common = { init: () => {} };

})(jQuery);
