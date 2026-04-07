@extends('layouts.app')

@section('content')
    <div class="shop-page-modern section section-padding pt-0">

        @include('products.partials.shop-toolbar')

        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">

                    <div class="col-lg-9 col-12 learts-mb-50">
                        @include('products.partials.products-grid')
                    </div>

                    @include('products.partials.shop-sidebar')

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── 1. КОЛОНКИ ── */
            const columnMap = { 3: 'row-cols-xl-3', 4: 'row-cols-xl-4', 5: 'row-cols-xl-5' };
            const allColClasses = Object.values(columnMap);
            const grid = document.getElementById('shop-products');

            function setColumns(n) {
                if (!grid) return;
                grid.classList.remove(...allColClasses);
                if (columnMap[n]) grid.classList.add(columnMap[n]);
                const ci = document.getElementById('colsInput');
                if (ci) ci.value = n;
            }

            document.querySelectorAll('.product-column-toggle .toggle').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.product-column-toggle .toggle').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    setColumns(parseInt(this.dataset.column));
                });
            });

            setColumns(4);
            const def4 = document.querySelector('.product-column-toggle .toggle[data-column="4"]');
            if (def4) {
                document.querySelectorAll('.product-column-toggle .toggle').forEach(b => b.classList.remove('active'));
                def4.classList.add('active');
            }

            /* ── 2. СОРТУВАННЯ ── */
            const sortSelect = document.getElementById('sortProducts');
            if (sortSelect) {
                sortSelect.value = '{{ $current_sort ?? "latest" }}';
                sortSelect.addEventListener('change', function () {
                    const si = document.getElementById('sortInput');
                    if (si) si.value = this.value;
                    document.getElementById('filterForm').submit();
                });
            }

            /* ── 3. КІЛЬКІСТЬ НА СТОРІНЦІ ── */
            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.value = '{{ $current_per_page ?? 12 }}';
                perPageSelect.addEventListener('change', function () {
                    const pi = document.getElementById('perPageInput');
                    if (pi) pi.value = this.value;
                    document.getElementById('filterForm').submit();
                });
            }

            /* ── 4. TAB-ФІЛЬТРИ (Всі / Гарячі / Новинки / Акції) ── */
            document.querySelectorAll('.isotope-filter.shop-product-filter button').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.isotope-filter.shop-product-filter button')
                        .forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;
                    const url = new URL(window.location.href);
                    if (filter === '*') { url.searchParams.delete('tab'); }
                    else                { url.searchParams.set('tab', filter); }
                    url.searchParams.set('page', 1);
                    window.location.href = url.toString();
                });
            });

            // Підсвічуємо активний таб при завантаженні
            const currentTab = new URLSearchParams(window.location.search).get('tab');
            if (currentTab) {
                document.querySelectorAll('.isotope-filter.shop-product-filter button').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.filter === currentTab);
                });
            }

            /* ── 5. ПОКАЗАТИ ЩЕ (AJAX) ── */
            const loadMoreBtn = document.getElementById('load-more-btn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function () {
                    const btn      = this;
                    const nextPage = parseInt(btn.dataset.nextPage);
                    const lastPage = parseInt(btn.dataset.lastPage);

                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Завантаження...';

                    const url = new URL(window.location.href);
                    url.searchParams.set('page', nextPage);

                    fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(r => r.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            doc.querySelectorAll('#shop-products .grid-item').forEach(item => grid.appendChild(item));

                            const newNext = nextPage + 1;
                            btn.dataset.nextPage = newNext;

                            if (newNext > lastPage) {
                                document.getElementById('load-more-wrap')?.remove();
                            } else {
                                btn.disabled = false;
                                btn.innerHTML = '<i class="ti-plus me-2"></i> Показати ще';
                            }
                        })
                        .catch(() => {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="ti-plus me-2"></i> Показати ще';
                        });
                });
            }

            /* ── 6. КОЛЬОРОВІ КРУЖЕЧКИ ── */
            document.querySelectorAll('.color-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    this.nextElementSibling?.classList.toggle('selected', this.checked);
                });
            });

            /* ── 7. WISHLIST ── */
            document.querySelectorAll('.add-to-wishlist').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');
                    fetch(`/wishlist/toggle/${this.dataset.productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.status === 'added') icon.classList.replace('far', 'fas');
                            else                         icon.classList.replace('fas', 'far');
                        })
                        .catch(() => {});
                });
            });

        });
    </script>
@endsection
