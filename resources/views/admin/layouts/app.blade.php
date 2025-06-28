<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
{{--    <title>@yield('seo_title')</title>--}}
    <title>Головна сторінка</title>
    <meta name="robots" content="noindex, follow"/>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.webp') }}">

    <!-- CSS
	============================================ -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

@include('include.topbar-section')
@include('admin.include.header-section')
@include('admin.include.header-sticky-section')
@include('admin.include.mobile-header-section')
@include('admin.include.offcanvas-search-section')
@include('admin.include.offcanvas-wishlist-section')
<div class="offcanvas-overlay"></div>
@isset($includeSliderMain)
    @include('admin.include.slider-main')
@endisset
@isset($includeFeatureSection)
    @include('admin.include.feature-section')
@endisset
@isset($includeCategoryBannerSection)
    @include('admin.include.category-banner-section')
@endisset
@isset($includeSaleBanner)
    @include('admin.include.sale-banner')
@endisset
@isset($includeProductSection)
    @include('admin.include.product-section')
@endisset
@isset($includeDealDay)
    @include('admin.include.deal-day')
@endisset
@isset($includeListProductSection)
    @include('admin.include.list-product-section')
@endisset
@isset($includeInstagramSection)
    @include('admin.include.instagram-section')
@endisset
@isset($includeRecommendedProducts)
    @include('admin.include.recommended-products')
@endisset

@include('components.breadcrumps')
@yield('content')
@include('admin.include.footer')


<!-- JS
============================================ -->

<!-- Vendors JS -->
<script src="{{ asset('js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-migrate-3.1.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>

<!-- Plugins JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
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
<script src="{{ asset('js/plugins/scrollax.min.js') }}"></script>
<script src="{{ asset('js/plugins/instafeed.min.js') }}"></script>

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<!-- <script src="{{ asset('js/vendor/vendor.min.js') }}"></script>
<script src="{{ asset('js/plugins/plugins.min.js') }}"></script> -->

<!-- Main Activation JS -->
<script src="{{ asset('js/main.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
<script src="{{ asset('/js/styles.js') }}"></script>
</body>

</html>

