<!-- Header Section Start -->
<div class="sticky-header section bg-white section-fluid d-none d-xl-block">
    <div class="container">
        <div class="row align-items-center">

            <!-- Header Logo Start -->
            <div class="col-xl-auto col">
                <div class="header-logo">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo/logo-2.webp') }}" alt="Crafters bazaar"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Search Start -->
            <div class="col d-none d-xl-block">
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
                        <li class="has-children"><a href="#"><span class="menu-text">Товари</span></a>
                            <ul class="sub-menu mega-menu">
                                @if(isset($statuses_products))
                                    @foreach ($statuses_products as $status_product)
                                        <li>
                                            <a href="#" class="mega-menu-title"><span class="menu-text">{{ $status_product->name }}</span></a>
                                            <ul>
                                                <li><a href="{{ asset('elements-products.html') }}"><span class="menu-text">Product Styles</span></a></li>
                                                <li><a href="{{ asset('elements-products-tabs.html') }}"><span class="menu-text">Product Tabs</span></a></li>
                                                <li><a href="{{ asset('elements-product-sale-banner.html') }}"><span class="menu-text">Product & Sale Banner</span></a></li>
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
                                @if(isset($kind_products))
                                    @foreach ($kind_products as $kind_product)
                                        <li><a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->name }}</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        <li class="has-children">
                            <a href="{{ route('admin_sub_kind_products.index') }}"><span class="menu-text">Підвиди товарів</span></a>
                            <ul class="sub-menu mega-menu">
                                @if(isset($kind_products))
                                    @foreach ($kind_products as $kind_product)
                                        <li>
                                            <a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}" class="mega-menu-title">
                                                <span class="menu-text">{{ $kind_product->name }}</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('admin_sub_kind_products.create', ['admin_kind_product_id' => $kind_product->id]) }}">
                                                        <span class="menu-text">Створити підвид товару</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin_sub_kind_products.index', ['admin_kind_product_id' => $kind_product->id]) }}">
                                                        <span class="menu-text">Всі підвиди товарів</span>
                                                    </a>
                                                </li>
                                                <hr>
                                                @forelse ($sub_kind_products as $sub_kind_product)
                                                    @if($kind_product->id == $sub_kind_product->kind_product_id)
                                                        <li>
                                                            <a href="{{ route('admin_sub_kind_products.show',  ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                                <span class="menu-text">{{ $sub_kind_product->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @empty
                                                    <li>
                                                        <a href="{{ route('admin_sub_kind_products.create', ['admin_kind_product_id' => $kind_product->id]) }}">
                                                            <span class="menu-text">Створити підвид товару</span>
                                                        </a>
                                                    </li>
                                                    <hr>
                                                @endforelse
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
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
                    </ul>
                </nav>
            </div>
            <!-- Search End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">
                    <div class="header-login">
                        @if(isset($user))
                            <a href="{{ route('admin_users.show',['admin_user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
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
                        <a href="{{ asset('#offcanvas-mobile-menu') }}" class="offcanvas-toggle">
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
