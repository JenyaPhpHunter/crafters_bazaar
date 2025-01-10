<!-- Header Section Start -->
<div class="sticky-header section bg-white section-fluid d-none d-xl-block">
    <div class="container">
        <div class="row align-items-center">

            <!-- Header Logo Start -->
            <div class="col-xl-auto col">
                <div class="header-logo">
                    <a href="{{ route('welcome') }}"><img src="{{ asset('images/logo/logo-2.webp') }}" alt="Crafters bazaar"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Search Start -->
            <div class="col d-none d-xl-block">
                <nav class="site-main-menu justify-content-center menu-height-60">
                    <ul>
                        <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                            @if(isset($header_kind_products))
                                <ul class="sub-menu mega-menu">
                                    @foreach($header_kind_products as $kind_product)
                                        <li class="has-children"><a href="{{ route('products_kind',['kind_products' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->title }}</span></a>
                                            <ul class="sub-menu">
                                                @if(!empty($kind_product->sub_kind_products))
                                                    @foreach($kind_product->sub_kind_products as $sub_kind_product)
                                                        <li><a href="{{ route('products_kind_subkind',['sub_kind_products' => $sub_kind_product->id]) }}"><span class="menu-text">{{ $sub_kind_product->title }}</span></a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        @if(isset($user_products) && $user_products->count() > 0)
                            <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Мої товари</span></a>
                                <ul class="sub-menu mega-menu">
                                    @if(isset($statuses_products))
                                        @foreach ($statuses_products as $status_product)
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
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li class="has-children"><a href="#"><span class="menu-text">Курси</span></a>
                            <ul class="sub-menu mega-menu">
                                <li>
                                    <a href="#" class="mega-menu-title"><span class="menu-text">SHOP PAGES</span></a>
                                    <ul>
                                        <li><a href="shop.html"><span class="menu-text">Shop No Sidebar</span></a></li>
                                        <li><a href="shop-left-sidebar.html"><span class="menu-text">Shop Left Sidebar</span></a></li>
                                        <li><a href="shop-right-sidebar.html"><span class="menu-text">Shop Right Sidebar</span></a></li>
                                        <li><a href="shop-fullwidth-no-gutters.html"><span class="menu-text">Shop Fullwidth No Space</span></a></li>
                                        <li><a href="shop-fullwidth.html"><span class="menu-text">Shop Fullwidth No Sidebar</span></a></li>
                                        <li><a href="shop-fullwidth-left-sidebar.html"><span class="menu-text">Shop Fullwidth Left Sidebar</span></a></li>
                                        <li><a href="shop-fullwidth-right-sidebar.html"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="mega-menu-title"><span class="menu-text">PRODUCT PAGES</span></a>
                                    <ul>
                                        <li><a href="product-details.html"><span class="menu-text">Basic</span></a></li>
                                        <li><a href="product-details-fullwidth.html"><span class="menu-text">Fullwidth</span></a></li>
                                        <li><a href="product-details-sticky.html"><span class="menu-text">Sticky Details</span></a></li>
                                        <li><a href="product-details-sidebar.html"><span class="menu-text">Width Sidebar</span></a></li>
                                        <li><a href="product-details-extra-content.html"><span class="menu-text">Extra Content</span></a></li>
                                        <li><a href="product-details-image-variation.html"><span class="menu-text">Variations Images</span></a></li>
                                        <li><a href="product-details-group.html"><span class="menu-text">Bought Together</span></a></li>
                                        <li><a href="product-details-360.html"><span class="menu-text">Product 360</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="mega-menu-title"><span class="menu-text">PRODUCT & Other PAGES</span></a>
                                    <ul>
                                        <li><a href="product-details-background.html"><span class="menu-text">Product with Background</span></a></li>
                                        <li><a href="shopping-cart.html"><span class="menu-text">Shopping Cart</span></a></li>
                                        <li><a href="checkout.html"><span class="menu-text">Checkout</span></a></li>
                                        <li><a href="order-tracking.html"><span class="menu-text">Order Tracking</span></a></li>
                                        <li><a href="wishlist.html"><span class="menu-text">Wishlist</span></a></li>
                                        <li><a href="login-register.html"><span class="menu-text">Customer Login</span></a></li>
                                        <li><a href="my-account.html"><span class="menu-text">My Account</span></a></li>
                                        <li><a href="lost-password.html"><span class="menu-text">Lost Password</span></a></li>
                                    </ul>
                                </li>
                                <li class="align-self-center">
                                    <a href="#" class="menu-banner"><img src="{{ asset('images/banner/menu-banner-2.webp') }}" alt="Shop Menu Banner"></a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-children"><a href="#"><span class="menu-text">Марафони</span></a>
                            <ul class="sub-menu">
                                <li><a href="portfolio-3-columns.html"><span class="menu-text">Portfolio 3 Columns</span></a></li>
                                <li><a href="portfolio-4-columns.html"><span class="menu-text">Portfolio 4 Columns</span></a></li>
                                <li><a href="portfolio-5-columns.html"><span class="menu-text">Portfolio 5 Columns</span></a></li>
                                <li><a href="portfolio-details.html"><span class="menu-text">Portfolio Details</span></a></li>
                            </ul>
                        </li>
                        <li class="has-children"><a href="#"><span class="menu-text">Форум</span></a>
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
                        <li class="has-children"><a href="{{ route('products.create') }}"><span class="menu-text">Додати свій товар</span></a>
                            <ul class="sub-menu">
                                @isset($header_kind_products)
                                    @foreach($header_kind_products as $kind_product)
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
                    </ul>
                </nav>
            </div>
            <!-- Search End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">
                    <div class="header-login">
                        @if(isset($user))
                            <a href="{{ route('users.show',['user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
                        @else
                            <a href="{{ route('login-register') }}"><i class="fal fa-user"></i>&nbsp;Увійти</a>
                        @endif
                    </div>
                    <div class="header-search d-none d-sm-block">
                        <a href="#offcanvas-search" class="offcanvas-toggle"><i class="fal fa-search"></i></a>
                    </div>
                    <div class="header-wishlist">
                        <a href="{{ route('wishlist.index') }}"><span class="wishlist-count">{{ $wishItemsCount }}</span><i class="fal fa-heart"></i></a>
                    </div>
                    <div class="header-cart">
                        <a href="{{ route('carts.index') }}" class="offcanvas-toggle"><span class="cart-count">{{ $cartItemsCount }}</span><i class="fal fa-shopping-cart"></i></a>
                    </div>
                    <div class="mobile-menu-toggle d-xl-none">
                        <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                            <svg viewBox="0 0 800 600">
                                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" class="top"></path>
                                <path d="M300,320 L540,320" class="middle"></path>
                                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" class="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Header Tools End -->

        </div>
    </div>
</div>
<!-- Header Sticky Section End -->
