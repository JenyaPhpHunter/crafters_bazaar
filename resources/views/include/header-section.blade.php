<!-- Header Section Start -->
<div class="header-section section bg-white d-none d-xl-block">
    <div class="container">
        <div class="row justify-content-between align-items-center">

            <!-- Header Logo Start -->
            <div class="col-auto">
                <div class="header-logo justify-content-center">
                    <a href="{{ route('welcome') }}"><img src="{{ asset('images/logo/logo.webp') }}" alt="Learts Logo"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Search Start -->
            <div class="col">
                <div class="header6-search">
                    <form action="#">
                        <div class="row g-0">
                            <div class="col">
                                <input type="text" placeholder="Пошук товарів...">
                            </div>
                            <button type="submit"><i class="fal fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Header Search End -->

            <!-- Header Tools Start -->
            <div class="col-auto">
                <div class="header-tools justify-content-end">
                    <div class="header-login">
                        @isset($user)
                            @if ($user->role_id != 7)
                                @if($user->category_users_id == 2)
                                    <a href="{{ route('users.show_seller',['user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
                                @elseif($user->category_users_id == 3)
                                    <a href="{{ route('users.show_buyer',['user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
                                @elseif($user->category_users_id == 1)
                                    <a href="{{ route('users.show',['user' => $user->id]) }}"><i class="fal fa-user"></i>&nbsp;{{ $user->name }}</a>
                                @endif
                            @else
                                <a href="{{ route('login-register') }}"><i class="fal fa-user"></i>&nbsp;Увійти</a>
                            @endif
                        @else
                            <a href="{{ route('login-register') }}"><i class="fal fa-user"></i>&nbsp;Увійти</a>
                        @endisset
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
    <div class="site-menu-section section border-top">
        <div class="container">
{{--            <div class="header-categories">--}}
{{--                <button class="category-toggle"><i class="fal fa-bars"></i> Вибери категорію</button>--}}
{{--                    <ul class="header-category-list">--}}
{{--                        @isset($orders)--}}
{{--                            @foreach($kind_products as $kind_product)--}}
{{--                                <li class="has-children"><a href="{{ route('products.index',  ['kind_product' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->name }}</span></a>--}}
{{--                                    <ul class="sub-menu">--}}
{{--                                        <li><a href="{{ asset('blog-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>--}}
{{--                                        <li><a href="{{ asset('blog-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>--}}
{{--                                        <li><a href="{{ asset('blog-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        @endisset--}}
{{--                    </ul>--}}
{{--                <ul class="header-category-list">--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-1.webp') }}" alt=""> Knitting</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-2.webp') }}" alt=""> Sewing</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-3.webp') }}" alt=""> Holyday gifts</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-4.webp') }}" alt=""> Birthday gifts</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-5.webp') }}" alt=""> Home decor</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-6.webp') }}" alt=""> For kids & babies</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-7.webp') }}" alt=""> Garden decor</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-8.webp') }}" alt=""> Accessories</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-9.webp') }}" alt=""> Soap</a></li>--}}
{{--                    <li><a href="#"><img src="{{ asset('images/icons/cat-icon-10.webp') }}" alt=""> Sale</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
            <nav class="site-main-menu justify-content-center menu-height-60">
                <ul>
                    @if($user)
                        @if($user->category_users_id == 2)
                        <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                            <ul class="sub-menu mega-menu">
                                @if(isset($statuses_products))
                                    @foreach ($statuses_products as $status_product)
                                        <li>
                                            <a href="#" class="mega-menu-title"><span class="menu-text">{{ $status_product->name }}</span></a>
                                            <ul>
                                                @foreach($products as $product)
                                                    @if($status_product->id == $product->status_product_id)
                                                        <li> <img class="mmh_img " src="{{ asset($product->path . '/' . $product->filename) }}" alt="home-01"> <a href="{{ route('products.show',['product' => $product->id]) }}"><span class="menu-text">{{ $product->name }}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        @else
                            <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                        @endif
                    @else
                        <li class="has-children"><a href="{{ route('products.index') }}"><span class="menu-text">Товари</span></a>
                    @endif
                    <li class="has-children"><a href="#"><span class="menu-text">Shop</span></a>
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
                    <li class="has-children"><a href="#"><span class="menu-text">Project</span></a>
                        <ul class="sub-menu">
                            <li><a href="portfolio-3-columns.html"><span class="menu-text">Portfolio 3 Columns</span></a></li>
                            <li><a href="portfolio-4-columns.html"><span class="menu-text">Portfolio 4 Columns</span></a></li>
                            <li><a href="portfolio-5-columns.html"><span class="menu-text">Portfolio 5 Columns</span></a></li>
                            <li><a href="portfolio-details.html"><span class="menu-text">Portfolio Details</span></a></li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Elements</span></a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column One</span></a>
                                <ul>
                                    <li><a href="elements-products.html"><span class="menu-text">Product Styles</span></a></li>
                                    <li><a href="elements-products-tabs.html"><span class="menu-text">Product Tabs</span></a></li>
                                    <li><a href="elements-product-sale-banner.html"><span class="menu-text">Product & Sale Banner</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Two</span></a>
                                <ul>
                                    <li><a href="elements-category-banner.html"><span class="menu-text">Category Banner</span></a></li>
                                    <li><a href="elements-team.html"><span class="menu-text">Team Member</span></a></li>
                                    <li><a href="elements-testimonials.html"><span class="menu-text">Testimonials</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Three</span></a>
                                <ul>
                                    <li><a href="elements-gallery.html"><span class="menu-text">Gallery</span></a></li>
                                    <li><a href="elements-map.html"><span class="menu-text">Google Map</span></a></li>
                                    <li><a href="elements-icon-box.html"><span class="menu-text">Icon Box</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Four</span></a>
                                <ul>
                                    <li><a href="elements-buttons.html"><span class="menu-text">Buttons</span></a></li>
                                    <li><a href="elements-faq.html"><span class="menu-text">FAQs / Toggles</span></a></li>
                                    <li><a href="elements-brands.html"><span class="menu-text">Brands</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="{{ route('products.create') }}"><span class="menu-text">Додати свій товар</span></a>
                        <ul class="sub-menu">
                            @isset($kind_products)
                                @foreach($kind_products as $kind_product)
                                    <li class="has-children"><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->name }}</span></a>
                                        <ul class="sub-menu">
                                            @php
                                                $counter = 0;
                                            @endphp
                                            @forelse ($sub_kind_products as $sub_kind_product)
                                                @if($kind_product->id == $sub_kind_product->kind_product_id)
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                    <li><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id, 'sub_kind_product_id' => $sub_kind_product->id]) }}"><span class="menu-text">{{ $sub_kind_product->name }}</span></a></li>
                                                @endif
                                            @empty
                                            @endforelse
                                            @if($counter == 0)
                                            <li><a href="{{ route('products.create', ['kind_product_id' => $kind_product->id]) }}"><span class="menu-text">Додати перший товар в категорію {{ $kind_product->name }}</span></a></li>
                                            @endif
                                        </ul>
                                    </li>
                                @endforeach
                            @endisset
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="header-call">
                <p><i class="fa fa-phone"></i> 067 329 14 19</p>
            </div>
        </div>
    </div>
    <!-- Site Menu Section End -->

</div>
<!-- Header Section End -->
