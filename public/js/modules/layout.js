// public/js/modules/layout.js
(function ($) {
    "use strict";

    // Parallax
    $.Scrollax();

    // Scroll Up
    $.scrollUp({ scrollText: '<i class="fal fa-long-arrow-up"></i>' });

    // Sticky Sidebar
    $('.sticky-sidebar').stickySidebar({
        topSpacing: 60,
        bottomSpacing: 60,
        containerSelector: '.sticky-sidebar-container',
        innerWrapperSelector: '.sticky-sidebar-inner',
        minWidth: 992
    });

    // Magnific Popup
    $('.video-popup').magnificPopup({ type: 'iframe' });
    $('.image-gallery').magnificPopup({ delegate: 'a', type: 'image', fixedContentPos: false, gallery: { enabled: true } });

    // Bootstrap Collapse
    $('.collapse').on('show.bs.collapse hide.bs.collapse', function (e) {
        $(this).closest('.card').toggleClass('active').siblings().removeClass('active');
    });

    // Post Share
    $('.post-share').on('click', '.toggle', function () {
        $(this).parent().toggleClass('active');
    });

    window.Learts = window.Learts || {};
    Learts.layout = { init: () => {} };

})(jQuery);
