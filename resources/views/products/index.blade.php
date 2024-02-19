@extends('layouts.app')

@section('content')

    <div class="offcanvas-overlay"></div>

    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="{{ asset('images/bg/page-title-1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h1 class="title">Shop</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Товари</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <!-- Shop Products Section Start -->
    <div class="section section-padding pt-0">

        <!-- Shop Toolbar Start -->
        <div class="shop-toolbar section-fluid border-bottom">
            <div class="container">
                <div class="row learts-mb-n20">

                    <!-- Isotop Filter Start -->
                    <div class="col-md col-12 align-self-center learts-mb-20">
                        <div class="isotope-filter shop-product-filter" data-target="#shop-products">
                            <button class="active" data-filter="*">Всі</button>
                            <button data-filter=".featured">Рекомендовані товари</button>
                            <button data-filter=".new">Нові товари</button>
                            <button data-filter=".sales">Товари зі знижкою</button>
                        </div>
                    </div>
                    <!-- Isotop Filter End -->

                    <div class="col-md-auto col-12 learts-mb-20">
                        <ul class="shop-toolbar-controls">
                            <li>
                                <div class="product-sorting">
                                    <select class="nice-select" id="sortProducts">
                                        <option value="{{ route('products.filter', ['sort_by' => 'menu_order'] + request()->except('sort_by')) }}" selected="selected">Сортування за замовчуванням</option>
                                        <option value="{{ route('products.filter', ['sort_by' => 'popularity'] + request()->except('sort_by')) }}">Сортування за популярністю</option>
                                        <option value="{{ route('products.filter', ['sort_by' => 'rating'] + request()->except('sort_by')) }}">Сортування за середньою оцінкою</option>
                                        <option value="{{ route('products.filter', ['sort_by' => 'newness'] + request()->except('sort_by')) }}">Сортування за новизною</option>
                                        <option value="{{ route('products.filter', ['sort_by' => 'price_up'] + request()->except('sort_by')) }}">Сортування за ціною: від низької до високої</option>
                                        <option value="{{ route('products.filter', ['sort_by' => 'price_down'] + request()->except('sort_by')) }}">Сортування за ціною: від високої до низької</option>
                                    </select>
                                </div>
                            </li>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var sortSelect = document.getElementById('sortProducts');
                                    sortSelect.onchange = function () {
                                        var selectedSort = sortSelect.value;
                                        window.location.href = selectedSort;
                                    };
                                });
                            </script>
                            <li>
                                <div class="product-column-toggle d-none d-xl-flex">
                                    <button class="toggle hintT-top" data-hint="5 Column" data-column="5"><i class="ti-layout-grid4-alt"></i></button>
                                    <button class="toggle active hintT-top" data-hint="4 Column" data-column="4"><i class="ti-layout-grid3-alt"></i></button>
                                    <button class="toggle hintT-top" data-hint="3 Column" data-column="3"><i class="ti-layout-grid2-alt"></i></button>
                                </div>
                            </li>
                            <li>
                                <a class="product-filter-toggle" href="#product-filter">Фільтри</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Toolbar End -->

        <!-- Product Filter Start -->
        <form action="{{ route('products.filter') }}" method="GET" id="filterForm">
            <input type="hidden" name="sort_by" value="1">

            <!-- Product Filter Start -->
            <div id="product-filter" class="product-filter section-fluid bg-light">
                <div class="container-fluid">
                    <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 learts-mb-n30">

                        <!-- Sort by Start -->
                        <div class="col learts-mb-30">
                            <h3 class="widget-title product-filter-widget-title">Сортувати за</h3>
                            <ul class="widget-list product-filter-widget customScroll">
                                <li><a href="{{ route('products.filter', ['sort_by' => 'popularity'] + request()->except('sort_by')) }}">Популярність</a></li>
                                <li><a href="{{ route('products.filter', ['sort_by' => 'rating'] + request()->except('sort_by')) }}">Середня оцінка</a></li>
                                <li><a href="{{ route('products.filter', ['sort_by' => 'newness'] + request()->except('sort_by')) }}">Новизна</a></li>
                                <li><a href="{{ route('products.filter', ['sort_by' => 'price_up'] + request()->except('sort_by')) }}">Ціна: від низької до високої</a></li>
                                <li><a href="{{ route('products.filter', ['sort_by' => 'price_down'] + request()->except('sort_by')) }}">Ціна: від високої до низької</a></li>
                            </ul>
                        </div>
                        <!-- Sort by End -->

                        <!-- Price filter Start -->
                        <div class="col learts-mb-30">
                            <h3 class="widget-title product-filter-widget-title">Фільтр по вартості</h3>
                            <ul class="widget-list product-filter-widget customScroll">
                                <?php
                                $selectedPriceFilters = [];
                                if (isset($_GET['filter_price']) && is_array($_GET['filter_price'])) {
                                    $selectedPriceFilters = $_GET['filter_price'];
                                }
                                ?>
                                <li>
                                    <input type="checkbox" name="filter_price[all]" value="all" id="price_all" {{ in_array('all', $selectedPriceFilters) ? 'checked' : '' }}>
                                    &nbsp;
                                    <a href="{{ route('products.filter', ['filter_price' => 'all']) }}">Всі</a>
                                </li>
                                <li>
                                    <input type="checkbox" name="filter_price[0_10]" value="0;10" id="price_0_10" {{ in_array('0_10', $selectedPriceFilters) ? 'checked' : '' }}>
                                    &nbsp;
                                    <a href="{{ route('products.filter', ['filter_price' => '0;10']) }}"><span class="amount"><span class="cur-symbol"></span>0 грн</span> - <span class="amount"><span class="cur-symbol"></span>10 грн</span></a>
                                </li>
                                <li>
                                    <input type="checkbox" name="filter_price[10_100]" value="10;100" id="price_10_100" {{ in_array('10_100', $selectedPriceFilters) ? 'checked' : '' }}>
                                    &nbsp;
                                    <a href="{{ route('products.filter', ['filter_price' => '10;100']) }}"><span class="amount"><span class="cur-symbol"></span>10 грн</span> - <span class="amount"><span class="cur-symbol"></span>100 грн</span></a>
                                </li>
                                <li>
                                    <input type="checkbox" name="filter_price[100_1000]" value="100;1000" id="price_100_1000" {{ in_array('100_1000', $selectedPriceFilters) ? 'checked' : '' }}>
                                    &nbsp;
                                    <a href="{{ route('products.filter', ['filter_price' => '100;1000']) }}"><span class="amount"><span class="cur-symbol"></span>100 грн</span> - <span class="amount"><span class="cur-symbol"></span>1000 грн</span></a>
                                </li>
                                <li>
                                    <input type="checkbox" name="filter_price[more_1000]" value="1000;+" id="price_more_1000" {{ in_array('more_1000', $selectedPriceFilters) ? 'checked' : '' }}>
                                    &nbsp;
                                    <a href="{{ route('products.filter', ['filter_price' => '1000;+']) }}"><span class="amount"><span class="cur-symbol"></span>1000 грн</span> +</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Price filter End -->

                        <!-- Categories Start -->
                        <div class="col learts-mb-30">
                            <h3 class="widget-title product-filter-widget-title">Категорії</h3>
                            <ul class="widget-list product-filter-widget customScroll">
                                <?php
                                $selectedCategories = []; // Визначте змінну для вибраних категорій
                                if (isset($_GET['categories'])) {
                                    $selectedCategories = $_GET['categories'];
                                }
                                ?>
                                @foreach($kind_products as $kind_product)
                                    @if($kind_product->product)
                                        <li>
                                            <input type="checkbox" name="categories[]" value="{{ $kind_product->id }}" id="category_{{ $kind_product->id }}" {{ in_array($kind_product->id, $selectedCategories) ? 'checked' : '' }}>
                                            &nbsp;
                                            <label for="category_{{ $kind_product->id }}"><a href="#">{{ $kind_product->name }}</a> <span class="count">{{ $kind_product->product->count() }}</span></label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <!-- Categories End -->

                        <!-- Filters by colors Start -->
                        <div class="col learts-mb-30">
                            <h3 class="widget-title product-filter-widget-title">Фільтр по кольору</h3>
                            <ul class="widget-colors product-filter-widget customScroll">
                                <?php
                                $selectedColors = []; // Визначте змінну для вибраних кольорів
                                if (isset($_GET['filter_color'])) {
                                    $selectedColors = (array)$_GET['filter_color'];
                                }
                                ?>
                                @foreach($colors as $color)
                                    <li>
                                        <input type="checkbox" name="filter_color[]" value="{{ $color->php_name }}" id="color_{{ $color->php_name }}" {{ in_array($color->php_name, $selectedColors) ? 'checked' : '' }}>
                                        <a href="{{ route('products.filter', ['filter_color' => $color->php_name]) }}" class="hintT-top" data-hint="{{ $color->name }}"><span data-bg-color="{{ $color->code }}">{{ $color->name }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Filters by colors End -->

                        <!-- Brands Start -->
                        <div class="col learts-mb-30">
                            <h3 class="widget-title product-filter-widget-title">Бренди</h3>
                            <ul class="widget-list product-filter-widget customScroll">
                                <!-- Додайте вибір брендів тут, аналогічно до категорій та кольорів -->
                            </ul>
                        </div>
                        <!-- Brands End -->

                        <!-- Filter Button -->
                        <div class="col learts-mb-30">
                            <button type="button" onclick="applyFilters()">Фільтрувати</button>
                        </div>
                        <!-- Reset Filters Button -->
                        <div class="col learts-mb-30">
                            <button type="button" onclick="resetFilters()">Скинути фільтри</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Отримати елементи чекбоксів
                var checkboxes = document.querySelectorAll('input[type=checkbox]');

                // Додати обробник подій для кожного чекбокса
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', saveFilters);
                });

                // Перевірити наявність збережених фільтрів та застосувати їх
                restoreFilters();
            });

            // Функція для збереження вибраних фільтрів
            function saveFilters() {
                var selectedFilters = {};

                // Отримати значення вибраних чекбоксів
                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
                checkboxes.forEach(function (checkbox) {
                    selectedFilters[checkbox.name] = checkbox.value;
                });

                // Зберегти вибрані фільтри у локальному сховищі
                localStorage.setItem('selectedFilters', JSON.stringify(selectedFilters));
            }

            // Функція для відновлення збережених фільтрів
            function restoreFilters() {
                var selectedFilters = localStorage.getItem('selectedFilters');

                if (selectedFilters) {
                    selectedFilters = JSON.parse(selectedFilters);

                    // Встановити стан чекбоксів відповідно до збережених фільтрів
                    for (var name in selectedFilters) {
                        var checkbox = document.querySelector('input[name="' + name + '"][value="' + selectedFilters[name] + '"]');
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                }
            }
        </script>

        <!-- Product Filter End -->
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <!-- Products Start -->
                        <div id="shop-products" class="products isotope-grid row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                            <div class="grid-sizer col-1"></div>
                            @foreach($products as $product)
                                <div class="grid-item col
                                @if($product->new == 1) new
                                @elseif($product->discount != 0) sales featured
                                @elseif($product->featured != 0) featured
                                @elseif($product->discount != 0 && $product->featured != 0) sales featured
                                @endif">
                                        <span class="product-badges">
                                            @if($product->new == 1)
                                                <span class="new">new</span>
                                            @endif
                                            @if($product->stock_balance == 0)
                                                <span class="outofstock"><i class="fal fa-frown"></i></span>
                                            @endif
                                            @if($product->discount != 0)
                                                <span class="onsale">-10%</span>
                                            @endif
                                            @if($product->featured != 0)
                                                    <span class="hot">hot</span>
                                            @endif
                                        </span>
                                    <div class="product">
                                        <div class="product-thumb">
                                            <a href="{{ route('products.show',['product' => $product->id]) }}" class="image">
                                                @php
                                                    $selectedPhoto = $product->productphotos->where('queue', 1)->first();
                                                @endphp
                                                @isset($selectedPhoto)
                                                    <img src="{{ asset($selectedPhoto->small_path . '/' . $selectedPhoto->small_filename) }}" alt="Product Image">
                                                    @if(isset($selectedPhoto->hover_path) && isset($selectedPhoto->hover_filename))
                                                        <img class="image-hover " src="{{ asset($selectedPhoto->hover_path . '/' . $selectedPhoto->hover_filename) }}" alt="Product Image">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('images/product/s328/product-14.webp') }}" alt="Product Image">
                                                @endisset
                                            </a>
                                            <a href="#" class="add-to-wishlist hintT-left" data-hint="Додати до улюблених" data-product-id="{{ $product->id }}">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <h6 class="title"><a href="{{ route('products.show',['product' => $product->id]) }}">{{ $product->name }}</a></h6>
                                            <span class="price">
                                            {{ $product->price }} грн
                                            </span>
                                            @if($product->term_creation != 0)
                                                <span class="price">
                                                Виготовлення {{ $product->term_creation }}
                                                    @if($product->term_creation == 1) день
                                                    @elseif($product->term_creation > 1 && $product->term_creation < 5) дні
                                                    @else днів @endif
                                                </span>
                                            @endif
                                            <div class="product-buttons">
                                                <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top"
                                                   data-hint="Швидкий перегляд"><i class="fal fa-search"></i></a>
                                                <a href="{{ route('carts.addToCart',['product' => $product->id]) }}"
                                                   class="product-button hintT-top" data-hint="Додати до корзини"><i
                                                        class="fal fa-shopping-cart"></i></a>
                                                <a href="#" class="product-button hintT-top" data-hint="Поділитися"><i
                                                        class="fal fa-random"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Products End -->
                        <div class="text-center learts-mt-70">
                            <a href="#" class="btn btn-dark btn-outline-hover-dark"><i class="ti-plus"></i> Показати ще</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 learts-mb-10">
                        <form action="{{ route('products.filter') }}" method="GET" id="rightfilterForm">
                            <input type="hidden" name="sort_by" value="1">
                            <!-- Search Start -->
                            <div class="single-widget learts-mb-40">
                                <div class="widget-search">
                                    <input type="text" name="search" placeholder="Пошук товару....">
                                    <button type="button" onclick="applysecondFilters()"><i class="fal fa-search"></i></button>
                                </div>
                            </div>
                            <!-- Search End -->

                            <!-- Categories Start -->
                            <div class="single-widget learts-mb-40">
                                <h3 class="widget-title product-filter-widget-title">Види товарів</h3>
                                <ul class="widget-list">
                                    @foreach($kind_products as $kind_product)
                                        @if($kind_product->product_count > 0)
                                            <li>
                                                <a href="{{ route('products.filter', ['categories' => [$kind_product->id]]) }}">
                                                    {{ $kind_product->name }}
                                                    <span class="count">{{ $kind_product->product_count }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Categories End -->

                            <!-- Price Range Start -->
                            <div class="single-widget learts-mb-40">
                                <h3 class="widget-title product-filter-widget-title">Фільтрувати по вартості</h3>
                                <div class="widget-price-range">
                                    <input class="range-slider" type="text" name="filter_price[range]" data-min="0" data-max="150000" data-from="0" data-to="150000" />
                                </div>
                            </div>
                            <!-- Price Range End -->

                            <div class="col learts-mb-30">
                                <button type="button" onclick="applysecondFilters()">Фільтрувати</button>
                            </div>
                            <div class="col learts-mb-30">
                                <button type="button" onclick="resetFilters()">Скинути фільтри</button>
                            </div>
                        </form>

                        <!-- List Product Widget Start -->
                            <div class="single-widget learts-mb-40">
                                <h3 class="widget-title product-filter-widget-title">Рекомендовані товари</h3>
                                <ul class="widget-products">
                                    @foreach($featured_products as $featured_product)
                                        <li class="product">
                                            <div class="thumbnail">
                                                <a href="{{ route('products.show',['product' => $featured_product->id]) }}">
                                                    @php
                                                        $selectedPhoto = $featured_product->productphotos->where('queue', 1)->first();
                                                    @endphp
                                                    @isset($selectedPhoto)
                                                        <img src="{{ asset($selectedPhoto->small_path . '/' . $selectedPhoto->small_filename) }}" alt="Featured product">
                                                    @else
                                                        <img src="{{ asset('images/product/widget-1.webp') }}" alt="Featured product">
                                                    @endisset
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h6 class="title"><a href="product-details.html">{{ $featured_product->name }}</a></h6>
                                                <span class="price">
                                                {{ $featured_product->price }} грн
                                            </span>
                                                <div class="ratting">
                                                    <span class="rate" style="width: 80%;"></span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- List Product Widget End -->

                            <!-- Tags Start -->
                            <div class="single-widget learts-mb-40">
                                <h3 class="widget-title product-filter-widget-title">Теги товарів</h3>
                                <div class="widget-tags">
                                    <a href="#">handmade</a>
                                    <a href="#">learts</a>
                                    <a href="#">mug</a>
                                    <a href="#">product</a>
                                    <a href="#">learts</a>
                                </div>
                            </div>
                            <!-- Tags End -->
                    </div>

                </div>
            </div>
        </div>
    <!-- Shop Products Section End -->
        <script>
            function applyFilters() {
                document.getElementById('filterForm').submit();
            }
            function applysecondFilters() {
                document.getElementById('rightfilterForm').submit();
            }
            function resetFilters() {
                // Скидаємо збережені фільтри у локальному сховищі
                localStorage.removeItem('selectedFilters');

                // Знаходимо всі чекбокси та скидаємо їх стан
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Знаходимо скрите поле та встановлюємо в нього значення сортування, якщо воно існує
                const sortField = document.querySelector('input[name="sort_by"]');
                @isset($sort_by)
                    sortField.value = "{{ $sort_by }}"; // Встановіть значення змінної сортування
                @endisset

                // Отримуємо форму та відправляємо її, щоб оновити сторінку без фільтрів
                const form = document.getElementById('filterForm');
                form.submit();
            }
        </script>
@endsection
