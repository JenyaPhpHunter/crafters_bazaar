<!-- Header Section Start -->
<div class="header-section section bg-white d-none d-xl-block">
    <div class="container">
        <div class="row justify-content-between align-items-center">

            <!-- Header Logo Start -->
            <div class="col-auto">
                <div class="header-logo justify-content-center">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo/logo.webp') }}" alt="Learts Logo"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Search Start -->
            <div class="col">
                <div class="header6-search">
                    <form action="{{ route('products.filter') }}" method="GET">
                        <div class="row g-0">
                            <div class="col">
                                <input type="text" name="search" placeholder="Пошук товарів...">
                            </div>
                            <button type="submit"><i class="fal fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Header Search End -->

            <!-- Header Tools Start -->
            <div class="col">
                <div class="header-tools justify-content-end">
                    <a href="{{ route('admin_users.create') }}"><i class="fal fa-user-plus"></i>&nbsp;Створити користувача</a>
                    <div class="header-login">
                        @if(isset($user))
                            <a href="{{ route('admin_users.show',['admin_user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
                        @else
                            <a href="{{ route('login-register') }}"><i class="fal fa-user"></i>&nbsp;Увійти</a>
                        @endif
                    </div>
                    <div class="header-wishlist">
                        <a href="{{ route('wishlist.index') }}"><span class="wishlist-count">{{ $wishItemsCount }}</span><i class="fal fa-heart"></i></a>
                    </div>
                    <div class="header-cart">
                        <a href="{{ route('carts.index') }}"><span class="cart-count">{{ $cartItemsCount }}</span><i class="fal fa-shopping-cart"></i></a>
                    </div>
                </div>
            </div>
            <!-- Header Tools End -->
        </div>
    </div>

    <!-- Site Menu Section Start -->
    <div class="site-menu-section section">
        <div class="container">
            <nav class="site-main-menu justify-content-center">
                <ul>
                    <li class="has-children"><a href="#"><span class="menu-text">Продавці</span></a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">ВІП продавці</span></a>
                                <ul>
                                    <li><a href="{{ asset('shop.html') }}"><span class="menu-text">Shop No Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-left-sidebar.html') }}"><span class="menu-text">Shop Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-right-sidebar.html') }}"><span class="menu-text">Shop Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-no-gutters.html') }}"><span class="menu-text">Shop Fullwidth No Space</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth.html') }}"><span class="menu-text">Shop Fullwidth No Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-left-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('shop-fullwidth-right-sidebar.html') }}"><span class="menu-text">Shop Fullwidth Right Sidebar</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Середні продаввці</span></a>
                                <ul>
                                    <li><a href="{{ asset('product-details.html') }}"><span class="menu-text">Basic</span></a></li>
                                    <li><a href="{{ asset('product-details-fullwidth.html') }}"><span class="menu-text">Fullwidth</span></a></li>
                                    <li><a href="{{ asset('product-details-sticky.html') }}"><span class="menu-text">Sticky Details</span></a></li>
                                    <li><a href="{{ asset('product-details-sidebar.html') }}"><span class="menu-text">Width Sidebar</span></a></li>
                                    <li><a href="{{ asset('product-details-extra-content.html') }}"><span class="menu-text">Extra Content</span></a></li>
                                    <li><a href="{{ asset('product-details-image-variation.html') }}"><span class="menu-text">Variations Images</span></a></li>
                                    <li><a href="{{ asset('product-details-group.html') }}"><span class="menu-text">Bought Together</span></a></li>
                                    <li><a href="{{ asset('product-details-360.html') }}"><span class="menu-text">Product 360</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Початківці продавці</span></a>
                                <ul>
                                    <li><a href="{{ asset('product-details-background.html') }}"><span class="menu-text">Product with Background</span></a></li>
                                    <li><a href="{{ asset('shopping-cart.html') }}"><span class="menu-text">Shopping Cart</span></a></li>
                                    <li><a href="{{ asset('checkout.html') }}"><span class="menu-text">Checkout</span></a></li>
                                    <li><a href="{{ asset('order-tracking.html') }}"><span class="menu-text">Order Tracking</span></a></li>
                                    <li><a href="{{ asset('wishlist.html') }}"><span class="menu-text">Wishlist</span></a></li>
                                    <li><a href="{{ asset('login-register.html') }}"><span class="menu-text">Customer Login</span></a></li>
                                    <li><a href="{{ asset('my-account.html') }}"><span class="menu-text">My Account</span></a></li>
                                    <li><a href="{{ asset('lost-password.html') }}"><span class="menu-text">Lost Password</span></a></li>
                                </ul>
                            </li>
                            <li class="align-self-center">
                                <a href="#" class="menu-banner"><img src="{{ asset('images/banner/menu-banner-2.webp') }}" alt="Shop Menu Banner"></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Покупці</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ asset('portfolio-3-columns.html') }}"><span class="menu-text">ВІП покупці</span></a></li>
                            <li><a href="{{ asset('portfolio-4-columns.html') }}"><span class="menu-text">Середні покупці</span></a></li>
                            <li><a href="{{ asset('portfolio-5-columns.html') }}"><span class="menu-text">Почтаківці покупці</span></a></li>
                            <li><a href="{{ asset('portfolio-details.html') }}"><span class="menu-text">Portfolio Details</span></a></li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                        <ul class="sub-menu mega-menu">
                            @if(isset($statuses_products))
                                @php
                                $counter = 0;
                                @endphp
                                @foreach ($statuses_products as $status_product)
                                    @if($status_product->id == 4)
                                        @continue;
                                    @endif
                                    <li>
                                        @if($counter == 0)

                                            <a href="{{ route('products.create') }}" class="mega-menu-title"><span class="menu-text">Додати товар</span></a>
                                    </li>
                                    <li>
                                        @endif
                                        @php
                                            $counter ++;
                                        @endphp
                                        <a href="{{ route('products.filter', ['status_product' => $status_product->id]) }}" class="mega-menu-title"><span class="menu-text">{{ $status_product->name }}</span></a>
                                        <ul>
                                            @foreach($products as $product)
                                                @if($status_product->id == $product->status_product_id)
                                                    @php
                                                        $selectedPhoto = $product->productphotos->where('queue', 1)->first();
                                                    @endphp
                                                    @isset($selectedPhoto)
                                                        <li> <img class="mmh_img " src="{{ asset($selectedPhoto->path . '/' . $selectedPhoto->filename) }}" alt="home-01"> <a href="{{ route('products.show',['product' => $product->id]) }}"><span class="menu-text">{{ $product->name }}</span></a></li>
                                                    @else
                                                        <li> <img class="mmh_img " src="{{ asset('images/product/s328/product-14.webp') }}" alt="home-01"> <a href="{{ route('products.show',['product' => $product->id]) }}"><span class="menu-text">{{ $product->name }}</span></a></li>
                                                    @endisset
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="has-children"><a href="{{ route('admin_orders.index') }}"><span class="menu-text">Замовлення</span></a>
                        <ul class="sub-menu">
                            @isset($orders)
                                @foreach($statuses_orders as $status_orders)
                                <li class="has-children"><a href="{{ route('admin_orders.index',  ['status_orders' => $status_orders->id]) }}"><span class="menu-text">{{ $status_orders->name }}</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                                @endforeach
                            @endisset
                        </ul>
                    </li>
                    <li class="has-children"><a href="{{ route('admin_kind_products.index') }}"><span class="menu-text">Види товарів</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin_kind_products.create') }}"><span class="menu-text">Створити вид товару</span></a></li>
                            <li><a href="{{ route('admin_kind_products.index') }}"><span class="menu-text">Всі види товарів</span></a></li>
                            @if(isset($header_kind_products))
                                @foreach ($header_kind_products as $kind_product)
                                    <li><a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->name }}</span></a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="has-children">
                        <a href="{{ route('admin_sub_kind_products.index') }}"><span class="menu-text">Підвиди товарів</span></a>
                        <ul class="sub-menu mega-menu">
                            @if(isset($header_kind_products))
                                @foreach ($header_kind_products as $kind_product)
                                    <li>
                                        <a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}" class="mega-menu-title">
                                            <span class="menu-text">{{ $kind_product->name }}</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('admin_sub_kind_products.create', ['admin_kind_product' => $kind_product->id]) }}">
                                                    <span class="menu-text">Створити підвид товару</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin_sub_kind_products.index', ['admin_kind_product' => $kind_product->id]) }}">
                                                    <span class="menu-text">Всі підвиди товарів</span>
                                                </a>
                                            </li>
                                            <hr>
                                        @forelse ($kind_product->sub_kind_products as $sub_kind_product)
                                            @if($kind_product->id == $sub_kind_product->kind_product_id)
                                                <li>
                                                    <a href="{{ route('admin_sub_kind_products.show',  ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                        <span class="menu-text">{{ $sub_kind_product->name }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @empty
                                        @endforelse
                                        </ul>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @if($user->role_id == 1)
                        <li class="has-children"><a href="#"><span class="menu-text">Ролі</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('admin_roles.create') }}"><span class="menu-text">Створити роль</span></a></li>
                                <li><a href="{{ route('admin_roles.index') }}"><span class="menu-text">Всі ролі</span></a></li>
                                @if(isset($roles))
                                    @foreach ($roles as $role)
                                        <li><a href="{{ asset('portfolio-details.html') }}"><span class="menu-text">{{ $role->name }}</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    <!-- Site Menu Section End -->

</div>
<!-- Header Section End -->
