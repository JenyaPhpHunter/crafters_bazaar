// public/js/modules/utils.js
(function ($) {
    "use strict";

    var $window = $(window),
        $body = $('body');

    // Background Image & Color
    $('[data-bg-image]').each(function () {
        var $this = $(this),
            $image = $this.data('bg-image');
        $this.css('background-image', 'url(' + $image + ')');
    });
    $('[data-bg-color]').each(function () {
        var $this = $(this),
            $color = $this.data('bg-color');
        $this.css('background-color', $color);
    });

    // Header Sticky
// === СУЧАСНИЙ STICKY HEADER — ФІНАЛЬНА ВЕРСІЯ (працює ідеально) ===
    let lastScrollTop = 0;
    const headerHeight = 120; // висота твого основного хедера

    $window.on('scroll', function () {
        let st = $window.scrollTop();

        if (st > lastScrollTop && st > headerHeight) {
            // Скрол вниз → ховаємо основний, показуємо sticky
            $('.header-section').css('transform', 'translateY(-100%)');
            $('.sticky-header')
                .removeClass('d-none')
                .addClass('d-block is-sticky'); // ← ОБОВ’ЯЗКОВО is-sticky!
        } else if (st < lastScrollTop) {
            // Скрол вгору → показуємо основний
            $('.header-section').css('transform', 'translateY(0)');

            if (st <= 80) {
                // Біля верху — ховаємо sticky повністю
                $('.sticky-header')
                    .removeClass('d-block is-sticky')
                    .addClass('d-none');
            }
        }

        // На самому верху — гарантовано показуємо основний
        if (st <= 80) {
            $('.header-section').css('transform', 'translateY(0)');
            $('.sticky-header')
                .removeClass('d-block is-sticky')
                .addClass('d-none');
        }

        lastScrollTop = st;
    });

    // Sub Menu & Mega Menu Alignment
    var subMenuMegaMenuAlignment = () => {
        var $this, $subMenu, $megaMenu, $siteMainMenu = $('.site-main-menu');

        $siteMainMenu.each(function () {
            $this = $(this);
            if ($this.is('.site-main-menu-left, .site-main-menu-right') && $this.closest('.section-fluid').length) {
                $megaMenu = $this.find('.mega-menu');
                $this.css("position", "relative");
                if ($this.hasClass('site-main-menu-left')) {
                    $megaMenu.css({ "left": "0px", "right": "auto" });
                } else if ($this.hasClass('site-main-menu-right')) {
                    $megaMenu.css({ "right": "0px", "left": "auto" });
                }
            }
        });

        $subMenu = $('.sub-menu');
        if ($subMenu.length) {
            $subMenu.each(function () {
                $this = $(this);
                var $elementOffsetLeft = $this.offset().left,
                    $elementWidth = $this.outerWidth(true),
                    $windowWidth = $window.outerWidth(true) - 10,
                    isElementVisible = ($elementOffsetLeft + $elementWidth < $windowWidth);

                if (!isElementVisible) {
                    if ($this.hasClass('mega-menu')) {
                        var $thisOffsetLeft = $this.parent().offset().left,
                            $widthDiff = $windowWidth - $elementWidth,
                            $left = $thisOffsetLeft - ($widthDiff / 2);
                        $this.attr("style", "left:" + -$left + "px !important").parent().css("position", "relative");
                    } else {
                        $this.parent().addClass('align-left');
                    }
                } else {
                    $this.removeAttr('style').parent().removeClass('align-left');
                }
            });
        }
    };

    // On Load & Resize
    $window.on('load resize', subMenuMegaMenuAlignment);

    // Export
    window.Learts = window.Learts || {};
    Learts.utils = { init: () => {} };

})(jQuery);
