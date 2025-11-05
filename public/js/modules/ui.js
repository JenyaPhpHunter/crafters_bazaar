// public/js/modules/ui.js
(function ($) {
    "use strict";

    // Off Canvas
    (function () {
        var $offCanvasToggle = $('.offcanvas-toggle'),
            $offCanvas = $('.offcanvas'),
            $offCanvasOverlay = $('.offcanvas-overlay'),
            $mobileMenuToggle = $('.mobile-menu-toggle');

        $offCanvasToggle.on('click', function (e) {
            e.preventDefault();
            var $this = $(this), $target = $this.attr('href');
            $('body').addClass('offcanvas-open');
            $($target).addClass('offcanvas-open');
            $offCanvasOverlay.fadeIn();
            if ($this.parent().hasClass('mobile-menu-toggle')) $this.addClass('close');
        });

        $('.offcanvas-close, .offcanvas-overlay').on('click', function (e) {
            e.preventDefault();
            $('body').removeClass('offcanvas-open');
            $offCanvas.removeClass('offcanvas-open');
            $offCanvasOverlay.fadeOut();
            $mobileMenuToggle.find('a').removeClass('close');
        });
    })();

    // Mobile Menu
    function mobileOffCanvasMenu() {
        var $offCanvasNav = $('.offcanvas-menu, .overlay-menu'),
            $subMenu = $offCanvasNav.find('.sub-menu');

        $subMenu.parent().prepend('<span class="menu-expand"></span>');

        $offCanvasNav.on('click', 'li a, .menu-expand', function (e) {
            var $this = $(this);
            if ($this.attr('href') === '#' || $this.hasClass('menu-expand')) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active');
                    $this.siblings('ul').slideUp();
                    $this.parent('li').find('li').removeClass('active');
                    $this.parent('li').find('ul:visible').slideUp();
                } else {
                    $this.parent('li').addClass('active');
                    $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.siblings('ul').slideDown();
                }
            }
        });
    }
    mobileOffCanvasMenu();

    // Header Category
    $('.header-categories').on('click', '.category-toggle', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.toggleClass('active').siblings('.header-category-list').slideToggle();
    });

    // Shop Toolbar
    $('.product-filter-toggle').on('click', function (e) {
        e.preventDefault();
        var $this = $(this), $target = $this.attr('href');
        $this.toggleClass('active');
        $($target).slideToggle();
        $('.customScroll').perfectScrollbar('update');
    });

    $('.product-column-toggle').on('click', '.toggle', function (e) {
        e.preventDefault();
        var $this = $(this),
            $column = $this.data('column'),
            $prevColumn = $this.siblings('.active').data('column');
        $this.addClass('active').siblings().removeClass('active');
        $('.products').removeClass('row-cols-xl-' + $prevColumn).addClass('row-cols-xl-' + $column);
        $.fn.matchHeight._update();
        $('.isotope-grid').isotope('layout');
    });

    // Custom Scroll
    $('.customScroll').perfectScrollbar({ suppressScrollX: true });

    // Select2
    $('.select2-basic').select2();
    $('.select2-noSearch').select2({ minimumResultsForSearch: Infinity });
    $('.select2-basic, .select2-noSearch').on('select2:open', function () {
        $('.select2-results__options').each(function () {
            new PerfectScrollbar($(this)[0], { suppressScrollX: true });
        });
    });

    // Nice Select
    $('.nice-select').niceSelect();

    // Match Height
    $('.isotope-grid .product').matchHeight();

    // Range Slider
    $(".range-slider").ionRangeSlider({
        skin: "learts",
        hide_min_max: true,
        type: 'double',
        postfix: "грн",
    });

    window.Learts = window.Learts || {};
    Learts.ui = { init: () => {} };

})(jQuery);
