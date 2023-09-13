<!-- Header Section Start -->
<div class="header-section section bg-white d-none d-xl-block">
    <div class="container">
        <div class="row row-cols-lg-3 align-items-center">

            <!-- Header Language & Currency Start -->
            <div class="col">
                <ul class="header-lan-curr">
                    <li><a href="#">Українська</a>
                        <ul class="curr-lan-sub-menu">
                            <li><a href="#">English</a></li>
                        </ul>
                    </li>
                    <li><a href="#">UAH</a>
                        <ul class="curr-lan-sub-menu">
                            <li><a href="#">EUR</a></li>
                            <li><a href="#">USD</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Header Language & Currency End -->

            <!-- Header Logo Start -->
            <div class="col">
                <div class="header-logo justify-content-center">
                    <a href="{{ asset('index.html') }}"><img src="{{ asset('images/logo/logo.webp') }}" alt="HandmateGPT Logo"></a>
                </div>
            </div>
            <!-- Header Logo End -->

            <!-- Header Tools Start -->
            <div class="col">
                <div class="header-tools justify-content-end">
                    <div class="header-login">
                        <a href="{{ asset('my-account.html') }}"><i class="fal fa-user"></i></a>
                    </div>
                    <div class="header-search">
                        <a href="{{ asset('#offcanvas-search') }}" class="offcanvas-toggle"><i class="fal fa-search"></i></a>
                    </div>
                    <div class="header-wishlist">
                        <a href="{{ asset('#offcanvas-wishlist') }}" class="offcanvas-toggle"><span class="wishlist-count">3</span><i class="fal fa-heart"></i></a>
                    </div>
                    <div class="header-cart">
                        <a href="{{ asset('#offcanvas-cart') }}" class="offcanvas-toggle"><span class="cart-count">3</span><i class="fal fa-shopping-cart"></i></a>
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
                    <li class="has-children"><a href="#"><span class="menu-text">Редагування</span></a>
                        <ul class="sub-menu">
                            <li class="has-children"><a href="{{ asset('blog-right-sidebar.html') }}"><span class="menu-text">Standard Layout</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                            <li class="has-children"><a href="{{ asset('blog-grid-right-sidebar.html') }}"><span class="menu-text">Grid Layout</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-grid-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-grid-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-grid-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                            <li class="has-children"><a href="{{ asset('blog-list-right-sidebar.html') }}"><span class="menu-text">List Layout</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-list-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-list-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-list-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                            <li class="has-children"><a href="{{ asset('blog-masonry-right-sidebar.html') }}"><span class="menu-text">Masonry Layout</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-masonry-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-masonry-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-masonry-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                            <li class="has-children"><a href="{{ asset('blog-details-right-sidebar.html') }}"><span class="menu-text">Single Post Layout</span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{ asset('blog-details-right-sidebar.html') }}"><span class="menu-text">Right Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-details-left-sidebar.html') }}"><span class="menu-text">Left Sidebar</span></a></li>
                                    <li><a href="{{ asset('blog-details-fullwidth.html') }}"><span class="menu-text">Full Width</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Види товарів</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('kind_products.create') }}"><span class="menu-text">Створити вид товару</span></a></li>
                            <li><a href="{{ route('kind_products.index') }}"><span class="menu-text">Всі види товарів</span></a></li>
                            @if(isset($kind_products))
                                @foreach ($kind_products as $kind_product)
                                    <li><a href="{{ asset('portfolio-details.html') }}"><span class="menu-text">{{ $kind_product->name }}</span></a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
{{--                    <li class="has-children"><a href="#"><span class="menu-text">Підвиди товарів</span></a>--}}
{{--                        <ul class="sub-menu">--}}
{{--                            <li><a href="{{ route('sub_kind_products.create') }}"><span class="menu-text">Створити підвид товару</span></a></li>--}}
{{--                            <li><a href="{{ route('sub_kind_products.index') }}"><span class="menu-text">Всі підвиди товари</span></a></li>--}}
{{--                            @if(isset($sub_kind_products))--}}
{{--                                @foreach ($sub_kind_products as $sub_kind_product)--}}
{{--                                    <li><a href="{{ asset('portfolio-details.html') }}"><span class="menu-text">{{ $sub_kind_product->name }}</span></a></li>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <li class="has-children">
                        <a href="#"><span class="menu-text">Підвиди товарів</span></a>
                        <ul class="sub-menu mega-menu">
                            @if(isset($kind_products))
                                @foreach ($kind_products as $kind_product)
                                    <li>
                                        <a href="{{ route('kind_products.index') }}" class="mega-menu-title">
                                            <span class="menu-text">{{ $kind_product->name }}</span>
                                        </a>
                                        @if(isset($sub_kind_products))
                                            <ul>
                                                @foreach ($sub_kind_products as $sub_kind_product)
                                                    @if($kind_product->id == $sub_kind_product->kind_product_id)
                                                        <li>
                                                        <li>
                                                            <a href="#" onclick="createSubKindProduct({{ $kind_product->id }})">
                                                                <span class="menu-text">Створити підвид товару</span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('sub_kind_products.index', ['kind_product_id' => $kind_product->id]) }}">
                                                                <span class="menu-text">Всі підвиди товарів</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('portfolio-details.html') }}">
                                                                <span class="menu-text">{{ $sub_kind_product->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <ul>
                                                <li>
                                                    <a href="#" onclick="createSubKindProduct({{ $kind_product->id }})">
                                                        <span class="menu-text">Створити підвид товару</span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('sub_kind_products.index', ['kind_product_id' => $kind_product->id]) }}">
                                                        <span class="menu-text">Всі підвиди товарів</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Ролі</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('roles.create') }}"><span class="menu-text">Створити роль</span></a></li>
                            <li><a href="{{ route('roles.index') }}"><span class="menu-text">Всі ролі</span></a></li>
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
    </div>
    <!-- Site Menu Section End -->

</div>
<!-- Header Section End -->
<script>
    function createSubKindProduct(kindProductId) {
        // Створення об'єкта FormData для передачі даних на сервер
        var formData = new FormData();
        formData.append('kind_product_id', kindProductId);

        // Виконання AJAX-запиту
        $.ajax({
            type: 'POST', // Метод запиту (POST)
            url: '/admin/sub_kind_products/create', // URL, на який буде відправлено запит
            data: formData, // Дані для відправки
            processData: false,
            contentType: false,
            success: function (response) {
                // Обробка відповіді від сервера
                console.log('Підвид товару створено успішно.');
                // Тут ви можете виконати додаткову логіку, яка пов'язана з успішним створенням підвиду товару
            },
            error: function (error) {
                // Обробка помилок
                console.error('Помилка при створенні підвиду товару:', error);
            }
        });
    }
</script>
