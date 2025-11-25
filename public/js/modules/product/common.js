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
        // Buy button
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

    // ЕКСПОРТ
    window.Learts = window.Learts || {};
    Learts.product = Learts.product || {};
    Learts.product.common = { init: () => {} };

})(jQuery);
