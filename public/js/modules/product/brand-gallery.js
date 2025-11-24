// public/js/modules/product/brand-gallery.js
// НОВИЙ ВИБІР БРЕНДУ 2025 — ГОРИЗОНТАЛЬНА ГАЛЕРЕЯ (з можливістю зняти вибір!)

$(document).on('click', '.brand-square-card', function () {
    const $card = $(this);
    const $section = $card.closest('#brand-section');
    const $label = $section.find('.form-label');

    // Ripple + звук
    $card.addClass('ripple');
    setTimeout(() => $card.removeClass('ripple'), 600);

    const clickSound = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-select-click-1239.mp3');
    clickSound.volume = 0.3;
    clickSound.play().catch(() => {});

    // Повторний клік — знімає вибір
    if ($card.hasClass('selected')) {
        $card.removeClass('selected');
        $('#selectedBrand').val('');
        $label.removeClass('label-focused');
        return;
    }

    // Звичайний вибір
    $('.brand-square-card').removeClass('selected');
    $card.addClass('selected');
    $('#selectedBrand').val($card.data('id'));
    $label.addClass('label-focused');
});

$(document).on('keydown', '.brand-square-card', function (e) {
    if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        $(this).click();
    }
});

// Стрілки + плавний скрол + підсвітка label при завантаженні
document.addEventListener('DOMContentLoaded', () => {
    const gallery = document.getElementById('brandGallery');
    const prevBtn = document.getElementById('brandPrev');
    const nextBtn = document.getElementById('brandNext');

    if (!gallery || !prevBtn || !nextBtn) return;

    const step = 318; // 92px картка + 14px gap × 3

    prevBtn.addEventListener('click', () => {
        gallery.scrollBy({ left: -step, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        gallery.scrollBy({ left: step, behavior: 'smooth' });
    });

    const updateArrows = () => {
        const atStart = gallery.scrollLeft <= 10;
        const atEnd = Math.abs(gallery.scrollWidth - gallery.clientWidth - gallery.scrollLeft) <= 10;

        prevBtn.style.opacity = atStart ? '0.3' : '1';
        prevBtn.style.pointerEvents = atStart ? 'none' : 'auto';
        nextBtn.style.opacity = atEnd ? '0.3' : '1';
        nextBtn.style.pointerEvents = atEnd ? 'none' : 'auto';
    };

    gallery.addEventListener('scroll', updateArrows);
    window.addEventListener('resize', updateArrows);
    updateArrows();

    // Підсвітка label при edit / old()
    if ($('#selectedBrand').val()) {
        $('#brand-section .form-label').addClass('label-focused');
    }
});
