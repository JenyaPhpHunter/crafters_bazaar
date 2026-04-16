/**
 * public/js/pages/shop-index.js
 * Логіка сторінки каталогу товарів
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        /* ── 1. КОЛОНКИ ── */
        const columnMap     = { 3: 'row-cols-xl-3', 4: 'row-cols-xl-4', 5: 'row-cols-xl-5' };
        const allColClasses = Object.values(columnMap);
        const grid          = document.getElementById('shop-products');

        function setColumns(n) {
            if (!grid) return;
            grid.classList.remove(...allColClasses);
            if (columnMap[n]) grid.classList.add(columnMap[n]);
            const ci = document.getElementById('colsInput');
            if (ci) ci.value = n;
        }

        // Відновлюємо збережену кількість колонок або беремо з сервера
        const savedCols = parseInt(localStorage.getItem('shopCols') || window.SHOP_COLS || 4);
        setColumns(savedCols);

        document.querySelectorAll('.product-column-toggle .toggle').forEach(btn => {
            btn.addEventListener('click', function () {
                const n = parseInt(this.dataset.column);
                document.querySelectorAll('.product-column-toggle .toggle').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                setColumns(n);
                localStorage.setItem('shopCols', n);
            });

            // Активуємо кнопку яка відповідає поточній кількості
            if (parseInt(btn.dataset.column) === savedCols) {
                document.querySelectorAll('.product-column-toggle .toggle').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
        });

        /* ── 2. СОРТУВАННЯ ──
           nice-select замінює <select> на кастомний div.
           Слухаємо клік по li всередині nice-select dropdown.
        ── */
        const sortForm = document.getElementById('filterForm');

        // Варіант А: якщо nice-select вже ініціалізовано jQuery плагіном
        // Слухаємо через jQuery change на оригінальному select
        if (typeof jQuery !== 'undefined' && jQuery('#sortProducts').length) {
            jQuery('#sortProducts').on('change', function () {
                const si = document.getElementById('sortInput');
                if (si) si.value = this.value;
                if (sortForm) sortForm.submit();
            });
        } else {
            // Варіант Б: звичайний select без nice-select
            const sortSelect = document.getElementById('sortProducts');
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    const si = document.getElementById('sortInput');
                    if (si) si.value = this.value;
                    if (sortForm) sortForm.submit();
                });
            }
        }

        /* ── 3. TAB-ФІЛЬТРИ ──
           Перехід через URL ?tab=featured|new|sale
        ── */
        document.querySelectorAll('.isotope-filter.shop-product-filter button').forEach(btn => {
            btn.addEventListener('click', function () {
                const filter = this.dataset.filter; // '', 'featured', 'new', 'sale'
                const url    = new URL(window.location.href);

                if (!filter) {
                    url.searchParams.delete('tab');
                } else {
                    url.searchParams.set('tab', filter);
                }
                url.searchParams.delete('page'); // скидаємо на першу сторінку
                window.location.href = url.toString();
            });
        });

        /* ── 4. ПОКАЗАТИ ЩЕ (AJAX) ── */
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn && grid) {
            loadMoreBtn.addEventListener('click', function () {
                const btn      = this;
                const nextPage = parseInt(btn.dataset.nextPage);
                const lastPage = parseInt(btn.dataset.lastPage);

                btn.disabled  = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Завантаження...';

                const url = new URL(window.location.href);
                url.searchParams.set('page', nextPage);

                fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        const doc      = new DOMParser().parseFromString(html, 'text/html');
                        const newItems = doc.querySelectorAll('#shop-products .grid-item');
                        newItems.forEach(item => grid.appendChild(item));

                        const newNext = nextPage + 1;
                        btn.dataset.nextPage = newNext;

                        if (newNext > lastPage) {
                            document.getElementById('load-more-wrap')?.remove();
                        } else {
                            btn.disabled  = false;
                            btn.innerHTML = '<i class="ti-plus me-2"></i> Показати ще';
                        }
                    })
                    .catch(() => {
                        btn.disabled  = false;
                        btn.innerHTML = '<i class="ti-plus me-2"></i> Показати ще';
                    });
            });
        }

        /* ── 5. КОЛЬОРОВІ КРУЖЕЧКИ ── */
        document.querySelectorAll('.color-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                this.nextElementSibling?.classList.toggle('selected', this.checked);
            });
        });

        /* ── 6. WISHLIST ── */
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.js-wishlist');
            if (!btn) return;
            e.preventDefault();

            const icon      = btn.querySelector('i');
            const productId = btn.dataset.productId;
            const csrf      = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch(`/wishlist/toggle/${productId}`, {
                method:  'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'added') {
                        icon?.classList.replace('far', 'fas');
                        btn.dataset.tooltip = 'Видалити з улюблених';
                    } else {
                        icon?.classList.replace('fas', 'far');
                        btn.dataset.tooltip = 'Додати до улюблених';
                    }
                })
                .catch(() => {});
        });

        /* ── 7. ПОШИРИТИ (Web Share API або fallback) ── */
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.js-share');
            if (!btn) return;
            e.preventDefault();

            const shareData = {
                title: btn.dataset.title || document.title,
                url:   btn.dataset.url   || window.location.href,
            };

            if (navigator.share) {
                navigator.share(shareData).catch(() => {});
            } else {
                // Fallback: копіюємо посилання в буфер
                navigator.clipboard?.writeText(shareData.url).then(() => {
                    const orig = btn.dataset.tooltip;
                    btn.dataset.tooltip = 'Посилання скопійовано!';
                    setTimeout(() => { btn.dataset.tooltip = orig; }, 2000);
                }).catch(() => {});
            }
        });

        /* ── 8. ШВИДКИЙ ПЕРЕГЛЯД ── */
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.js-quick-view');
            if (!btn) return;
            e.preventDefault();

            const productId = btn.dataset.productId;
            const modal     = document.getElementById('quickViewModal');
            if (!modal) return;

            // Завантажуємо контент модалки через AJAX
            fetch(`/products/${productId}/quick-view`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(r => r.text())
                .then(html => {
                    const body = modal.querySelector('.modal-body');
                    if (body) body.innerHTML = html;

                    if (typeof bootstrap !== 'undefined') {
                        bootstrap.Modal.getOrCreateInstance(modal).show();
                    } else if (typeof jQuery !== 'undefined') {
                        jQuery(modal).modal('show');
                    }
                })
                .catch(() => {});
        });

    });

})();
