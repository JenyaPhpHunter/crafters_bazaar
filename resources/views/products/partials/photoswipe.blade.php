{{-- resources/views/products/partials/photoswipe.blade.php --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/photoswipe.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/umd/photoswipe-lightbox.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const galleryEl = document.querySelector('#product-gallery');
        if (!galleryEl) return;

        // Прибираємо IDE попередження (не обов'язково)
        /** @type {any} */
        const PhotoSwipeLightboxRef = window.PhotoSwipeLightbox;
        /** @type {any} */
        const PhotoSwipeRef = window.PhotoSwipe;

        if (!PhotoSwipeLightboxRef || !PhotoSwipeRef) {
            console.warn('PhotoSwipe assets not loaded');
            return;
        }

        // Якщо lightbox вже створений — не створюємо вдруге
        if (window.__pswpLightbox) {
            if (typeof window.__pswpLightbox.refresh === 'function') {
                window.__pswpLightbox.refresh();
            }
            return;
        }

        window.__pswpLightbox = new PhotoSwipeLightboxRef({
            gallery: '#product-gallery',
            children: 'a',
            pswpModule: PhotoSwipeRef,
        });

        window.__pswpLightbox.init();

        // ✅ Важливо: якщо ти натискаєш на кнопку всередині <a>, не відкривати двічі
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.product-gallery-popup');
            if (!btn) return;

            // зупиняємо стандартну поведінку <a>
            e.preventDefault();
            e.stopPropagation();

            // відкриваємо PhotoSwipe по кліку в батьківський <a>
            const link = btn.closest('a');
            if (!link) return;

            // знаходимо індекс <a> серед дітей галереї
            const links = Array.from(galleryEl.querySelectorAll('a'));
            const index = links.indexOf(link);
            if (index < 0) return;

            // відкриваємо
            if (window.__pswpLightbox && typeof window.__pswpLightbox.loadAndOpen === 'function') {
                window.__pswpLightbox.loadAndOpen(index);
            }
        }, true);
    });
</script>
