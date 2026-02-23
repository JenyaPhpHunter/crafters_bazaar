<!-- Header Sticky Section Start -->
<div class="sticky-header section bg-white d-none">
    <div class="container-wide">
        <div class="row align-items-center justify-content-between">

            <!-- Логотип -->
            <div class="col-auto">
                <div class="header-logo">
                    @php
                        $route = isset($user) && $user->role_id < 5 ? 'dashboard' : 'welcome';
                    @endphp
                    <a href="{{ route($route) }}">
                        <img src="{{ asset('images/logo/new_logo2.webp') }}" alt="Handmade Luxury Logo">
                    </a>
                </div>
            </div>

            <!-- Головне меню (центр) — займає весь доступний простір -->
            <div class="col">
                <nav class="site-main-menu justify-content-center">
                    <ul>
                        {{-- Товари --}}
                        <li class="has-children">
                            <a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                            @if(isset($header_kind_products))
                                <ul class="sub-menu mega-menu">
                                    @foreach($header_kind_products as $kind_product)
                                        <li class="has-children">
                                            <a href="{{ route('products_kind', ['kind_products' => $kind_product->id]) }}">
                                                <span class="menu-text">{{ $kind_product->title }}</span>
                                            </a>
                                            @if($kind_product->sub_kind_products->isNotEmpty())
                                                <ul class="sub-menu">
                                                    @foreach($kind_product->sub_kind_products as $sub_kind_product)
                                                        <li>
                                                            <a href="{{ route('products_kind_subkind', ['sub_kind_products' => $sub_kind_product->id]) }}">
                                                                <span class="menu-text">{{ $sub_kind_product->title }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>

                        {{-- Мої товари (якщо є) --}}
                        @if(isset($user_products) && $user_products->count() > 0)
                            <li class="has-children">
                                <a href="{{ route('products.index') }}"><span class="menu-text">Мої товари</span></a>
                                <ul class="sub-menu mega-menu">
                                    @foreach($statuses_products as $status_product)
                                        <li>
                                            <a href="#" class="mega-menu-title"><span class="menu-text">{{ $status_product->title }}</span></a>
                                            <ul>
                                                @foreach($user_products as $user_product)
                                                    @if($status_product->id == $user_product->status_product_id)
                                                        @php
                                                            $selectedPhoto = $user_product->productphotos->where('queue', 1)->first();
                                                        @endphp
                                                        @isset($selectedPhoto)
                                                            <li> <img class="mmh_img " src="{{ asset($selectedPhoto->path . '/' . $selectedPhoto->filename) }}" alt="home-01"> <a href="{{ route('products.show',['product' => $user_product->id]) }}"><span class="menu-text">{{ $user_product->title }}</span></a></li>
                                                        @else
                                                            <li> <img class="mmh_img " src="{{ asset('images/product/s328/product-14.webp') }}" alt="home-01"> <a href="{{ route('products.show',['product' => $user_product->id]) }}"><span class="menu-text">{{ $user_product->title }}</span></a></li>
                                                        @endisset
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        <li class="has-children"><a href="{{ route('forum_topics.index') }}"><span class="menu-text">Форум</span></a>
                            <ul class="sub-menu">
                                <li class="has-children"><a href="{{ route('forum_categories.index') }}"><span class="menu-text">Всі категорії</span></a>
                                <li class="has-children"><a href="{{ route('forum_sub_categories.index') }}"><span class="menu-text">Всі підкатегорії</span></a>
                                <li class="has-children"><a href="{{ route('forum_topics.index') }}"><span class="menu-text">Всі теми</span></a>
                                @isset($categories)
                                    @foreach($categories as $category)
                                        <li class="has-children">
                                            <a href="{{ route('forum_categories.show', ['forum_category' => $category->id]) }}">
                                                <span class="menu-text">{{ $category->name }}</span>
                                            </a>
                                            <ul class="sub-menu">
                                                @php
                                                    $counter = 0;
                                                @endphp
                                                @forelse ($category->forum_sub_categories as $sub_category)
                                                    @if($category->id == $sub_category->forum_category_id)
                                                        @php
                                                            $counter++;
                                                        @endphp
                                                        <li>
                                                            <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $sub_category->id]) }}">
                                                                <span class="menu-text">{{ $sub_category->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @empty
                                                @endforelse
                                                @if($counter == 0)
                                                    <li>
                                                        <a href="{{ route('forum_sub_categories.create', ['category_id' => $category->id]) }}">
                                                            <span class="menu-text">Додати першу підкатегорію в категорію {{ $category->name }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </li>

                        {{-- Додати свій товар --}}
                        <li class="has-children"><a href="{{ route('products.create') }}"><span class="menu-text">Додати свій товар</span></a>
                            <ul class="sub-menu">
                                @isset($all_kind_products)
                                    @foreach($all_kind_products as $kind_product)
                                        <li class="has-children"><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->title }}</span></a>
                                            <ul class="sub-menu">
                                                @php
                                                    $counter = 0;
                                                @endphp
                                                @forelse ($kind_product->sub_kind_products as $sub_kind_product)
                                                    @if($kind_product->id == $sub_kind_product->kind_product_id)
                                                        @php
                                                            $counter++;
                                                        @endphp
                                                        <li><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id, 'sub_kind_product_id' => $sub_kind_product->id]) }}"><span class="menu-text">{{ $sub_kind_product->title }}</span></a></li>
                                                    @endif
                                                @empty
                                                @endforelse
                                                @if($counter == 0)
                                                    <li><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id]) }}"><span class="menu-text">Додати перший товар в категорію {{ $kind_product->title }}</span></a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </li>

                    @if(isset($user) && $user->role_id != 9)
                            <li class="has-children"><a href="{{ route('brands.index') }}"><span class="menu-text">Бренди</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('brands.create') }}"><span class="menu-text">Створити бренд</span></a></li>
                                    <li><a href="{{ route('brands.index') }}"><span class="menu-text">Всі бренди</span></a></li>
                                    @if(isset($brands))
                                        @foreach ($brands as $brand)
                                            <li><a href="{{ route('admin_tags.edit', ['admin_tag' => $brand]) }}"><span class="menu-text">{{ $brand->name }}</span></a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Права частина: логін, wishlist, cart, статус, мобільне меню -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">

                    <!-- Логін / Ім’я -->
                    <div class="header-login">
                        @auth
                            <a href="{{ route('users.show', auth()->user()) }}">
                                <i class="fal fa-user"></i> {{ auth()->user()->name }}
                            </a>
                        @else
                            <a href="{{ route('login-register') }}">
                                <i class="fal fa-user"></i> Увійти
                            </a>
                        @endauth
                    </div>

                    <!-- Wishlist -->
                    <div class="header-wishlist">
                        <a href="{{ route('wishlist.index') }}">
                            <span class="wishlist-count">{{ $wishItemsCount ?? 0 }}</span>
                            <i class="fal fa-heart"></i>
                        </a>
                    </div>

                    <!-- Cart -->
                    <div class="header-cart">
                        <a href="{{ route('carts.index') }}" class="offcanvas-toggle">
                            <span class="cart-count">{{ $cartItemsCount ?? 0 }}</span>
                            <i class="fal fa-shopping-cart"></i>
                        </a>
                    </div>

                    <!-- Статус замовлення (тільки для авторизованих) -->
                    @auth
                        <div class="header-status">
                            <a href="{{ route('orders.index') }}">
                                <i class="fa fa-truck"></i> Статус замовлення
                            </a>
                        </div>
                    @endauth

                    <!-- Мобільне меню (тільки на маленьких екранах) -->
                    <div class="mobile-menu-toggle d-xl-none">
                        <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                            <svg viewBox="0 0 800 600">
                                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" class="top"></path>
                                <path d="M300,320 L540,320" class="middle"></path>
                                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" class="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318)"></path>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Sticky Section End -->
