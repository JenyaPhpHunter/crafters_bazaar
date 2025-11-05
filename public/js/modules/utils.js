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
    $window.on('scroll', function () {
        if ($window.scrollTop() > 350) {
            $('.sticky-header').addClass('is-sticky');
        } else {
            $('.sticky-header').removeClass('is-sticky');
        }
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
