@extends('layouts.app')

@section('content')
    <div class="shop-page-modern section section-padding pt-0">

        @include('products.partials.shop-toolbar')

        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">

                    <!-- Товари -->
                    <div class="col-lg-9 col-12 learts-mb-50">
                        @include('products.partials.products-grid')
                    </div>

                    <!-- Сайдбар -->
                    @include('products.partials.shop-sidebar')

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Маппінг: бажана кількість колонок → Bootstrap клас
            // row-cols-xl-N означає рівно N колонок на xl+ екранах
            const columnMap = {
                3: 'row-cols-xl-3',
                4: 'row-cols-xl-4',
                5: 'row-cols-xl-5',
            };
            const allColClasses = Object.values(columnMap);
            const container    = document.getElementById('shop-products');

            function setColumns(desired) {
                if (!container) return;
                container.classList.remove(...allColClasses);
                const cls = columnMap[desired];
                if (cls) {
                    container.classList.add(cls);
                    console.log(`✅ ${desired} колонок → ${cls}`);
                }
            }

            // Клік по кнопках 3 / 4 / 5
            document.querySelectorAll('.product-column-toggle .toggle').forEach(btn => {
                btn.addEventListener('click', function () {
                    const desired = parseInt(this.dataset.column);

                    document.querySelectorAll('.product-column-toggle .toggle')
                        .forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    setColumns(desired);
                });
            });

            // За замовчуванням — 4 колонки
            setColumns(4);
            const defaultBtn = document.querySelector('.product-column-toggle .toggle[data-column="4"]');
            if (defaultBtn) {
                document.querySelectorAll('.product-column-toggle .toggle').forEach(b => b.classList.remove('active'));
                defaultBtn.classList.add('active');
            }
        });
    </script>
@endsection
