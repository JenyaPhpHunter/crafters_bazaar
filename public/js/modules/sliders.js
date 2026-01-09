(function ($) {
    "use strict";

    /*--
        Slick Slider Activation (ЗАХИЩЕНО)
    -----------------------------------*/
    function initSlick($el, options) {
        if ($el.length && $.fn.slick && !$el.hasClass('slick-initialized')) {
            $el.slick(options);
        }
    }

    // Ініціалізація Swiper Sliders
    function initSwipers() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.home1-slider', { loop: true, speed: 750, effect: 'fade', navigation: { nextEl: '.home1-slider-next', prevEl: '.home1-slider-prev' }, autoplay: {} });
            new Swiper('.home2-slider', { loop: true, speed: 750, effect: 'fade', navigation: { nextEl: '.home2-slider-next', prevEl: '.home2-slider-prev' }, autoplay: {}, on: { slideChange: function () { this.$el.find('.slide-product').removeClass('active'); } } });
            $('.home2-slider').on('click', '.slide-pointer', function (e) { e.preventDefault(); $(this).siblings('.slide-product').toggleClass('active'); });
            new Swiper('.home3-slider', { loop: true, speed: 750, effect: 'fade', navigation: { nextEl: '.home3-slider-next', prevEl: '.home3-slider-prev' }, autoplay: {} });
            new Swiper('.home4-slider', { loop: true, loopedSlides: 2, speed: 750, spaceBetween: 200, pagination: { el: '.home4-slider-pagination', clickable: true }, navigation: { nextEl: '.home4-slider-next', prevEl: '.home4-slider-prev' }, autoplay: {} });
            new Swiper('.home5-slider', { loop: true, speed: 750, spaceBetween: 30, pagination: { el: '.home5-slider-pagination', clickable: true }, navigation: { nextEl: '.home5-slider-next', prevEl: '.home5-slider-prev' } });
            new Swiper('.home7-slider', { loop: true, speed: 750, spaceBetween: 30, effect: 'fade', pagination: { el: '.home7-slider-pagination', clickable: true }, navigation: { nextEl: '.home7-slider-next', prevEl: '.home7-slider-prev' } });
            new Swiper('.home8-slider', { loop: true, speed: 750, spaceBetween: 30, effect: 'fade', pagination: { el: '.home8-slider-pagination', clickable: true }, navigation: { nextEl: '.home8-slider-next', prevEl: '.home8-slider-prev' } });
            new Swiper('.home12-slider', { loop: true, speed: 750, spaceBetween: 30, effect: 'fade', pagination: { el: '.home12-slider-pagination', clickable: true }, navigation: { nextEl: '.home12-slider-next', prevEl: '.home12-slider-prev' } });
        }
    }

    // Ініціалізація Slick Sliders
    function initSlickSliders() {
        if ($('.product-gallery-slider').length) {
            initSlick($('.product-gallery-slider'), {
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.product-thumb-slider, .product-thumb-slider-vertical',
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
                appendArrows: '.product-gallery-slider'   // ← це ключовий рядок!
            });
        }

        if ($('.product-thumb-slider-vertical').length) {
            initSlick($('.product-thumb-slider-vertical'), {
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                vertical: true,
                focusOnSelect: true,
                asNavFor: '.product-gallery-slider',
                prevArrow: '<button class="slick-prev"><i class="ti-angle-up"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-down"></i></button>',
                appendArrows: '.product-thumb-slider-vertical'   // ← це ключовий рядок!
            });
        }

        initSlick($('.product-carousel'), { infinite: true, slidesToShow: 4, slidesToScroll: 1, focusOnSelect: true, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 991, settings: { slidesToShow: 3 } }, { breakpoint: 767, settings: { slidesToShow: 2 } }, { breakpoint: 575, settings: { slidesToShow: 1 } }] });
        initSlick($('.product-list-slider'), { rows: 3, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>' });
        initSlick($('.product-thumb-slider'), { infinite: true, slidesToShow: 4, slidesToScroll: 1, focusOnSelect: true, asNavFor: '.product-gallery-slider', prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>' });
        initSlick($('.blog-carousel'), { infinite: true, slidesToShow: 3, slidesToScroll: 1, focusOnSelect: true, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 991, settings: { slidesToShow: 2 } }, { breakpoint: 767, settings: { slidesToShow: 1 } }] });
        initSlick($('.brand-carousel'), { infinite: true, slidesToShow: 5, slidesToScroll: 1, focusOnSelect: true, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 1199, settings: { slidesToShow: 4 } }, { breakpoint: 991, settings: { slidesToShow: 3 } }, { breakpoint: 767, settings: { slidesToShow: 2 } }, { breakpoint: 575, settings: { slidesToShow: 1 } }] });
        initSlick($('.testimonial-slider'), { infinite: true, slidesToShow: 1, slidesToScroll: 1, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>' });
        initSlick($('.testimonial-carousel'), { infinite: true, slidesToShow: 3, slidesToScroll: 1, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 991, settings: { slidesToShow: 2 } }, { breakpoint: 767, settings: { slidesToShow: 1 } }] });
        initSlick($('.category-banner1-carousel'), { infinite: true, slidesToShow: 3, slidesToScroll: 1, prevArrow: '<button class="slick-prev"><i class="fal fa-long-arrow-left"></i></button>', nextArrow: '<button class="slick-next"><i class="fal fa-long-arrow-right"></i></button>', responsive: [{ breakpoint: 991, settings: { slidesToShow: 2 } }, { breakpoint: 767, settings: { slidesToShow: 1 } }] });
    }

    // Isotope
    function initIsotope() {
        var $isotopeGrid = $('.isotope-grid');
        if ($isotopeGrid.length) {
            $isotopeGrid.imagesLoaded(function () {
                $isotopeGrid.isotope({ itemSelector: '.grid-item', masonry: { columnWidth: '.grid-sizer' } });
            });
            $('.isotope-filter').on('click', 'button', function () {
                var $this = $(this), $filterValue = $this.attr('data-filter'), $target = $this.parent().data('target');
                $this.addClass('active').siblings().removeClass('active');
                $($target).isotope({ filter: $filterValue });
            });
        }
    }

    // Instagram
    function initInstafeed() {
        const instafeedCarousel1 = () => initSlick($('.instafeed-carousel1'), { infinite: true, slidesToShow: 5, slidesToScroll: 1, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 1199, settings: { slidesToShow: 4 } }, { breakpoint: 991, settings: { slidesToShow: 3 } }, { breakpoint: 767, settings: { slidesToShow: 2 } }, { breakpoint: 479, settings: { slidesToShow: 1 } }] });
        const instafeedCarousel2 = () => initSlick($('.instafeed-carousel2'), { infinite: true, slidesToShow: 3, slidesToScroll: 1, prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>', nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>', responsive: [{ breakpoint: 767, settings: { slidesToShow: 2 } }, { breakpoint: 479, settings: { slidesToShow: 1 } }] });

        if ($('.instafeed').length) {
            $('.instafeed').each(function () {
                const $id = $(this).attr('id');
                const feed = new Instafeed({
                    accessToken: 'IGQVJVai1mRVNkalVIRDdOVTJ4WDBReENPZAndCNGNIT094d0ZAsX2NhYUxSbUFxQU9JbjlyVUkyRU5uRUxmWVBOU0tyWFpfb2lCMm1RUzVSTWgzN3pIb2Q4UjdiTlVZAWWZAOVzBINmlNc2VpUmZA3MGsxUAZDZD',
                    target: $id,
                    template: '<a class="instafeed-item" href="{{link}}"><img title="{{caption}}" src="{{image}}" /><i class="fab fa-instagram"></i></a>',
                    limit: 12,
                    after: function () {
                        if ($('.instafeed-carousel1').length) instafeedCarousel1();
                        if ($('.instafeed-carousel2').length) instafeedCarousel2();
                    }
                });
                feed.run();
            });
        }
    }

    // PhotoSwipe: Ініціалізація лайтбоксу для галереї
    function initPhotoSwipe() {
        if (typeof PhotoSwipeLightbox !== 'undefined' && $('.product-gallery-slider').length) {
            const lightbox = new PhotoSwipeLightbox({
                gallery: '.product-gallery-slider',
                children: '.product-zoom .product-gallery-popup', // Прив’язка до лупи всередині .product-zoom
                pswpModule: () => PhotoSwipe
            });
            lightbox.init();

            // Додаткова перевірка кліку на лупу
            $('.product-gallery-popup').on('click', function (e) {
                e.preventDefault();
                console.log('Popup clicked, initiating lightbox');
                const $zoom = $(this).closest('.product-zoom');
                const pswpSrc = $zoom.attr('data-pswp-src');
                if (pswpSrc) {
                    lightbox.loadAndOpen(0, { src: pswpSrc }); // Відкриваємо лайтбокс для поточного зображення
                }
            });
        }
    }

    // Ініціалізація всіх слайдерів
    window.Learts = window.Learts || {};
    Learts.sliders = {
        init: function () {
            initSwipers();
            initSlickSliders();
            initIsotope();
            initInstafeed();
            initPhotoSwipe();
        },
        initSlick
    };

    $(document).ready(function () {
        if (typeof Learts?.sliders?.init === 'function') {
            Learts.sliders.init();
        }
    });

})(jQuery);
