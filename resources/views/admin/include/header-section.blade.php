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
                    <li class="has-children"><a href="{{ route('admin_users.index') }}"><span class="menu-text">Користувачі</span></a>
                        <ul class="sub-menu">
                            @foreach($roles as $role)
                                <li><a href="{{ route('admin_users.index', ['role' => $role->id]) }}"><span class="menu-text">{{ $role->name }}</span></a></li>
                            @endforeach
                        </ul>
                    <li class="has-children"><a href="{{ route('sellers_buyers.index') }}"><span class="menu-text">Покупці та продавці</span></a>
                        <ul class="sub-menu">
                                <li><a href="{{ route('sellers_buyers.index', ['role_id' => 5, 'category_user_id' => 3]) }}"><span class="menu-text">ВІП продавці</span></a></li>
                                <li><a href="{{ route('sellers_buyers.index', ['role_id' => 6, 'category_user_id' => 3]) }}"><span class="menu-text">Продавці</span></a></li>
                                <li><a href="{{ route('sellers_buyers.index', ['role_id' => 5, 'category_user_id' => 4]) }}"><span class="menu-text">ВІП покупці</span></a></li>
                                <li><a href="{{ route('sellers_buyers.index', ['role_id' => 6, 'category_user_id' => 4]) }}"><span class="menu-text">Покупці</span></a></li>
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
                                        <a href="{{ route('products.filter', ['status_product' => $status_product->id]) }}" class="mega-menu-title"><span class="menu-text">{{ $status_product->title }}</span></a>
                                        @isset($products)
                                            <ul>
                                                @foreach($products as $product)
                                                    @if($status_product->id == $product->status_product_id)
                                                        @php
                                                            $selectedPhoto = $product->productphotos->where('queue', 1)->first();
                                                        @endphp
                                                        @isset($selectedPhoto)
                                                            <li> <img class="mmh_img " src="{{ asset($selectedPhoto->path . '/' . $selectedPhoto->filename) }}" alt="home-01"> <a href="{{ route('products.show',['product' => $product->id]) }}"><span class="menu-text">{{ $product->title }}</span></a></li>
                                                        @else
                                                            <li> <img class="mmh_img " src="{{ asset('images/product/s328/product-14.webp') }}" alt="home-01"> <a href="{{ route('products.show',['product' => $product->id]) }}"><span class="menu-text">{{ $product->title }}</span></a></li>
                                                        @endisset
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endisset
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
                            <li><a href="{{ route('admin_kind_products.index', ['not_checked' => true]) }}"><span class="menu-text">Незатверджені види товарів</span></a></li>
                            @if(isset($header_kind_products))
                                @foreach ($header_kind_products as $kind_product)
                                    <li><a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}"><span class="menu-text">{{ $kind_product->title }}</span></a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="has-children">
                        <a href="{{ route('admin_sub_kind_products.index') }}"><span class="menu-text">Підвиди товарів</span></a>
                        <ul class="sub-menu mega-menu">
                            <li><a href="{{ route('admin_sub_kind_products.create') }}"><span class="menu-text">Створити підвид товару</span></a></li>
                            <li><a href="{{ route('admin_sub_kind_products.index') }}"><span class="menu-text">Всі підвиди товарів</span></a></li>
                            <li><a href="{{ route('admin_sub_kind_products.index', ['not_checked' => true]) }}"><span class="menu-text">Незатверджені підвиди товарів</span></a></li>
                            @if(isset($header_kind_products))
                                @foreach ($header_kind_products as $kind_product)
                                    <li>
                                        <a href="{{ route('admin_kind_products.show',  ['admin_kind_product' => $kind_product->id]) }}" class="mega-menu-title">
                                            <span class="menu-text">{{ $kind_product->title }}</span>
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
                                                        <span class="menu-text">{{ $sub_kind_product->title }}</span>
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
                        <li class="has-children"><a href="{{ route('admin_roles.index') }}"><span class="menu-text">Ролі</span></a>
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
                    @if($user->role_id == 1)
                        <li class="has-children"><a href="{{ route('admin_tags.index') }}"><span class="menu-text">Теги</span></a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('admin_tags.create') }}"><span class="menu-text">Створити тег</span></a></li>
                                <li><a href="{{ route('admin_tags.index') }}"><span class="menu-text">Всі теги</span></a></li>
                                @if(isset($tags))
                                    @foreach ($tags as $tag)
                                        <li><a href="{{ route('admin_tags.edit', ['admin_tag' => $tag]) }}"><span class="menu-text">{{ $tag->name }}</span></a></li>
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
