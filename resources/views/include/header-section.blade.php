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
                    <li class="has-children"><a href="#"><span class="menu-text">Home</span></a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">HOME GROUP</span></a>
                                <ul>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-01.webp') }}" alt="home-01') }}"> <a href="{{ asset('index.html') }}"><span class="menu-text">Arts Propelled</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-02.webp') }}" alt="home-02') }}"> <a href="{{ asset('index-2.html') }}"><span class="menu-text">Decor Thriving</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-03.webp') }}" alt="home-03') }}"> <a href="{{ asset('index-3.html') }}"><span class="menu-text">Savvy Delight</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-04.webp') }}" alt="home-04') }}"> <a href="{{ asset('index-4.html') }}"><span class="menu-text">Perfect Escapes</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ asset('index-2.html') }}" class="mega-menu-title"><span class="menu-text">HOME GROUP</span></a>
                                <ul>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-05.webp') }}" alt="home-05') }}"> <a href="{{ asset('index-5.html') }}"><span class="menu-text">Kitchen Cozy</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-06.webp') }}" alt="home-06') }}"> <a href="{{ asset('index-6.html') }}"><span class="menu-text">Dreamy Designs</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-07.webp') }}" alt="home-07') }}"> <a href="{{ asset('index-7.html') }}"><span class="menu-text">Crispy Recipes</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-08.webp') }}" alt="home-08') }}"> <a href="{{ asset('index-8.html') }}"><span class="menu-text">Decoholic Chic</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ asset('index-2.html') }}" class="mega-menu-title"><span class="menu-text">HOME GROUP</span></a>
                                <ul>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-9.webp" alt="home-9') }}"> <a href="{{ asset('index-9.html') }}"><span class="menu-text">Reblended Dish</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-10.webp" alt="home-10') }}"> <a href="{{ asset('index-10.html') }}"><span class="menu-text">Craftin House</span></a></li>
                                    <li> <img class="mmh_img " src="{{ asset('images/demo/menu/home-11.webp" alt="home-11') }}"> <a href="{{ asset('index-11.html') }}"><span class="menu-text">Craftswork Biz</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="menu-banner"><img src="{{ asset('images/banner/menu-banner-1.webp') }}" alt="Home Menu Banner"></a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Магазин</span></a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Сторінки магазину</span></a>
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
                                <a href="#" class="mega-menu-title"><span class="menu-text">PRODUCT PAGES</span></a>
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
                                <a href="#" class="mega-menu-title"><span class="menu-text">PRODUCT & Other PAGES</span></a>
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
                    <li class="has-children"><a href="#"><span class="menu-text">Project</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ asset('portfolio-3-columns.html') }}"><span class="menu-text">Portfolio 3 Columns</span></a></li>
                            <li><a href="{{ asset('portfolio-4-columns.html') }}"><span class="menu-text">Portfolio 4 Columns</span></a></li>
                            <li><a href="{{ asset('portfolio-5-columns.html') }}"><span class="menu-text">Portfolio 5 Columns</span></a></li>
                            <li><a href="{{ asset('portfolio-details.html') }}"><span class="menu-text">Portfolio Details</span></a></li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Elements</span></a>
                        <ul class="sub-menu mega-menu">
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column One</span></a>
                                <ul>
                                    <li><a href="{{ asset('elements-products.html') }}"><span class="menu-text">Product Styles</span></a></li>
                                    <li><a href="{{ asset('elements-products-tabs.html') }}"><span class="menu-text">Product Tabs</span></a></li>
                                    <li><a href="{{ asset('elements-product-sale-banner.html') }}"><span class="menu-text">Product & Sale Banner</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Two</span></a>
                                <ul>
                                    <li><a href="{{ asset('elements-category-banner.html') }}"><span class="menu-text">Category Banner</span></a></li>
                                    <li><a href="{{ asset('elements-team.html') }}"><span class="menu-text">Team Member</span></a></li>
                                    <li><a href="{{ asset('elements-testimonials.html') }}"><span class="menu-text">Testimonials</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Three</span></a>
                                <ul>
                                    <li><a href="{{ asset('elements-gallery.html') }}"><span class="menu-text">Gallery</span></a></li>
                                    <li><a href="{{ asset('elements-map.html') }}"><span class="menu-text">Google Map</span></a></li>
                                    <li><a href="{{ asset('elements-icon-box.html') }}"><span class="menu-text">Icon Box</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="mega-menu-title"><span class="menu-text">Column Four</span></a>
                                <ul>
                                    <li><a href="{{ asset('elements-buttons.html') }}"><span class="menu-text">Buttons</span></a></li>
                                    <li><a href="{{ asset('elements-faq.html') }}"><span class="menu-text">FAQs / Toggles</span></a></li>
                                    <li><a href="{{ asset('elements-brands.html') }}"><span class="menu-text">Brands</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-children"><a href="#"><span class="menu-text">Blog</span></a>
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
                    <li class="has-children"><a href="#"><span class="menu-text">Pages</span></a>
                        <ul class="sub-menu">
                            <li><a href="{{ asset('about-us.html') }}"><span class="menu-text">About us</span></a></li>
                            <li><a href="{{ asset('about-us-2.html') }}"><span class="menu-text">About us 02</span></a></li>
                            <li><a href="{{ asset('contact-us.html') }}"><span class="menu-text">Contact us</span></a></li>
                            <li><a href="{{ asset('coming-soon.html') }}"><span class="menu-text">Coming Soon</span></a></li>
                            <li><a href="{{ asset('404.html') }}"><span class="menu-text">Page 404</span></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Site Menu Section End -->

</div>
<!-- Header Section End -->
