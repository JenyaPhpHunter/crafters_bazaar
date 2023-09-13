    <!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('seo_title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.webp') }}">

    <!-- CSS
	============================================ -->

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/font-awesome-pro.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/themify-icons.css') }}">

    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="{{ asset('css/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/photoswipe-default-skin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/slick.css') }}">

    <!-- Main Style CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <!-- <link rel="stylesheet" href="{{ asset('css/vendor/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/plugins.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

{{--@include('admin.include.top-section')--}}
{{--@include('admin.include.header-section')--}}
@include('admin.include.header-section', ['kind_products' => $kind_products])

@include('admin.include.header-sticky-section')
@include('admin.include.mobile-header-section')
@include('admin.include.offcanvas-search-section')
@include('admin.include.offcanvas-wishlist-section')
@include('admin.include.offcanvas-cart-section')
@include('admin.include.offcanvas-mobile-menu-section')


<div class="offcanvas-overlay"></div>

@yield('content')

<div class="footer1-section section section-padding">
    <div class="container">
        <div class="row text-center row-cols-1">

            <div class="footer1-logo col text-center">
                <img src="{{ asset('images/logo/logo.webp') }}" alt="">
            </div>

            <div class="footer1-menu col">
                <ul class="widget-menu justify-content-center">
                    <li><a href="#">Про нас</a></li>
                    <li><a href="#">Локація магазину</a></li>
                    <li><a href="#">Контакти</a></li>
                    <li><a href="#">Підтримка</a></li>
{{--                    <li><a href="#">Policy</a></li>--}}
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer1-subscribe d-flex flex-column col">
                <form id="mc-form" class="mc-form widget-subscibe">
                    <input id="mc-email" autocomplete="off" type="email" placeholder="Введіть Ваш e-mail">
                    <button id="mc-submit" class="btn btn-dark">підписатися</button>
                </form>
                <!-- mailchimp-alerts Start -->
                <div class="mailchimp-alerts text-centre">
                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                    <div class="mailchimp-success text-success"></div><!-- mailchimp-success end -->
                    <div class="mailchimp-error text-danger"></div><!-- mailchimp-error end -->
                </div><!-- mailchimp-alerts end -->
            </div>
            <div class="footer1-social col">
                <ul class="widget-social justify-content-center">
                    <li class="hintT-top" data-hint="Twitter"> <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a></li>
                    <li class="hintT-top" data-hint="Facebook"> <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="hintT-top" data-hint="Instagram"> <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                    <li class="hintT-top" data-hint="Youtube"> <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
            <div class="footer1-copyright col">
                <p class="copyright">&copy; 2023 learts. All Rights Reserved | <strong>(+00) 123 567990</strong> | <a href="mailto:contact@learts.com">contact@learts.com</a></p>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="quickViewModal modal fade" id="quickViewModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="close" data-bs-dismiss="modal">&times;</button>
            <div class="row learts-mb-n30">

                <!-- Product Images Start -->
                <div class="col-lg-6 col-12 learts-mb-30">
                    <div class="product-images">
                        <div class="product-gallery-slider-quickview">
                            <div class="product-zoom" data-image="{{ asset('images/product/single/1/product-zoom-1.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-1.webp') }}" alt="">
                            </div>
                            <div class="product-zoom" data-image="{{ asset('images/product/single/1/product-zoom-2.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-2.webp') }}" alt="">
                            </div>
                            <div class="product-zoom" data-image="{{ asset('images/product/single/1/product-zoom-3.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-3.webp') }}" alt="">
                            </div>
                            <div class="product-zoom" data-image="{{ asset('images/product/single/1/product-zoom-4.webp') }}">
                                <img src="{{ asset('images/product/single/1/product-4.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Images End -->

                <!-- Product Summery Start -->
                <div class="col-lg-6 col-12 overflow-hidden position-relative learts-mb-30">
                    <div class="product-summery customScroll">
                        <div class="product-ratings">
                                <span class="star-rating">
                                <span class="rating-active" style="width: 100%;">ratings</span>
                                </span>
                            <a href="#reviews" class="review-link">(<span class="count">3</span> customer reviews)</a>
                        </div>
                        <h3 class="product-title">Cleaning Dustpan & Brush</h3>
                        <div class="product-price">£38.00 – £50.00</div>
                        <div class="product-description">
                            <p>Easy clip-on handle – Hold the brush and dustpan together for storage; the dustpan edge is serrated to allow easy scraping off the hair without entanglement. High-quality bristles – no burr damage, no scratches, thick and durable, comfortable to remove dust and smaller particles.</p>
                        </div>
                        <div class="product-variations">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="label"><span>Size</span></td>
                                    <td class="value">
                                        <div class="product-sizes">
                                            <a href="#">Large</a>
                                            <a href="#">Medium</a>
                                            <a href="#">Small</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Color</span></td>
                                    <td class="value">
                                        <div class="product-colors">
                                            <a href="#" data-bg-color="#000000"></a>
                                            <a href="#" data-bg-color="#ffffff"></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Quantity</span></td>
                                    <td class="value">
                                        <div class="product-quantity">
                                            <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                            <input type="text" class="input-qty" value="1">
                                            <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="product-buttons">
                            <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark"><i class="fal fa-heart"></i></a>
                            <a href="#" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i> Add to Cart</a>
                            <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark"><i class="fal fa-random"></i></a>
                        </div>
                        <div class="product-brands">
                            <span class="title">Brands</span>
                            <div class="brands">
                                <a href="#"><img src="{{ asset('images/brands/brand-3.webp') }}" alt=""></a>
                                <a href="#"><img src="{{ asset('images/brands/brand-8.webp') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="product-meta mb-0">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="label"><span>SKU</span></td>
                                    <td class="value">0404019</td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Category</span></td>
                                    <td class="value">
                                        <ul class="product-category">
                                            <li><a href="#">Kitchen</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Tags</span></td>
                                    <td class="value">
                                        <ul class="product-tags">
                                            <li><a href="#">handmade</a></li>
                                            <li><a href="#">learts</a></li>
                                            <li><a href="#">mug</a></li>
                                            <li><a href="#">product</a></li>
                                            <li><a href="#">learts</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Share on</span></td>
                                    <td class="va">
                                        <div class="product-share">
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                            <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                            <a href="#"><i class="fab fa-pinterest"></i></a>
                                            <a href="#"><i class="fal fa-envelope"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Product Summery End -->

            </div>
        </div>
    </div>
</div>

<!-- JS
============================================ -->

<!-- Vendors JS -->
<script src="{{ asset('js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-migrate-3.1.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>

<!-- Plugins JS -->
<script src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/plugins/swiper.min.js') }}"></script>
<script src="{{ asset('js/plugins/slick.min.js') }}"></script>
<script src="{{ asset('js/plugins/mo.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('js/plugins/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/plugins/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.matchHeight-min.js') }}"></script>
<script src="{{ asset('js/plugins/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/plugins/photoswipe.min.js') }}"></script>
<script src="{{ asset('js/plugins/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('js/plugins/ResizeSensor.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.sticky-sidebar.min.js') }}"></script>
<script src="{{ asset('js/plugins/product360.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.scrollUp.min.js') }}"></script>

@yield('page-script')

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<!-- <script src="{{ asset('js/vendor/vendor.min.js') }}"></script>
<script src="{{ asset('js/plugins/plugins.min.js') }}"></script> -->

<!-- Main Activation JS -->
<script src="{{ asset('js/main.js') }}"></script>

</body>

</html>


{{--<!doctype html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}

{{--    <!-- CSRF Token -->--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--    <title>{{ config('app.name', 'Laravel') }}</title>--}}

{{--    <!-- Scripts -->--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

{{--    <!-- Fonts -->--}}
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

{{--    <!-- Styles -->--}}
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--</head>--}}
{{--<body>--}}
{{--    <div id="app">--}}
{{--        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
{{--            <div class="container">--}}
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    {{ config('app.name', 'Laravel') }}--}}
{{--                </a>--}}
{{--                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                    <span class="navbar-toggler-icon"></span>--}}
{{--                </button>--}}

{{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                    <!-- Left Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav me-auto">--}}

{{--                    </ul>--}}

{{--                    <!-- Right Side Of Navbar -->--}}
{{--                    <ul class="navbar-nav ms-auto">--}}
{{--                        <!-- Authentication Links -->--}}
{{--                        @guest--}}
{{--                            @if (Route::has('login'))--}}
{{--                                <li class="nav-item">--}}
{{--                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Авторизація') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}

{{--                            @if (Route::has('register'))--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Реєстрація') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <li class="nav-item dropdown">--}}
{{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    {{ Auth::user()->name }}--}}
{{--                                </a>--}}

{{--                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
{{--                                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                       onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                        {{ __('Logout') }}--}}
{{--                                    </a>--}}

{{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        @endguest--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </nav>--}}

{{--        <main class="py-4">--}}
{{--            @yield('content')--}}
{{--        </main>--}}
{{--    </div>--}}
{{--</body>--}}
{{--</html>--}}
