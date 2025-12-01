{{-- resources/views/products/partials/photoswipe.blade.php --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/photoswipe.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ініціалізуємо PhotoSwipe тільки якщо є галерея на сторінці
        const gallery = document.querySelector('#product-gallery');
        if (gallery && typeof PhotoSwipeLightbox !== 'undefined') {
            const lightbox = new PhotoSwipeLightbox({
                gallery: '#product-gallery',
                children: 'a',
                pswpModule: PhotoSwipe,
                bgOpacity: 0.95,
                spacing: 0.12,
                showHideOpacity: true,
            });
            lightbox.init();
        }
    });
</script>
