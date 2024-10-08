@extends('layouts.app')

@section('seo_title', 'Головна сторінка')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Page Title/Header End -->
<!-- Slider main container Start -->
<div class="home1-slider swiper-container">
    <div class="swiper-wrapper">
        <div class="home1-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home1/slide-1.webp') }}">
            <div class="home1-slide1-content">
                <span class="bg"></span>
                <span class="slide-border"></span>
                <span class="icon"><img src="{{ asset('images/slider/home1/slide-1-1.webp') }}" alt="Slide Icon"></span>
                <h2 class="title">Вікін магазин</h2>
                <h3 class="sub-title">Тільки для тебе</h3>
                <div class="link"><a href="{{ route('products.index') }}">купи зараз</a></div>
            </div>
        </div>
        <div class="home1-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home1/slide-2.webp') }}">
            <div class="home1-slide2-content">
                <span class="bg" data-bg-image="{{ asset('images/slider/home1/slide-2-1.webp') }}"></span>
                <span class="slide-border"></span>
                <span class="icon">
                        <img src="{{ asset('images/slider/home1/slide-2-2.webp') }}" alt="Slide Icon">
                        <img src="{{ asset('images/slider/home1/slide-2-3.webp') }}" alt="Slide Icon">
                    </span>
                <h2 class="title">нові надходження</h2>
                <h3 class="sub-title">Знижки до  <br>10%</h3>
                <div class="link"><a href="{{ route('products.index') }}">купи зараз</a></div>
            </div>
        </div>
        <div class="home1-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home1/slide-3.webp') }}">
            <div class="home1-slide3-content">
                <h2 class="title">Чудові подарунки</h2>
                <h3 class="sub-title">
                    <img class="left-icon " src="{{ asset('images/slider/home1/slide-2-2.webp') }}" alt="Slide Icon">
                    Для сім'ї та друзів
                    <img class="right-icon " src="{{ asset('images/slider/home1/slide-2-3.webp') }}" alt="Slide Icon">
                </h3>
                <div class="link"><a href="{{ route('products.index') }}">купи зараз</a></div>
            </div>
        </div>
    </div>
    <div class="home1-slider-prev swiper-button-prev"><i class="ti-angle-left"></i></div>
    <div class="home1-slider-next swiper-button-next"><i class="ti-angle-right"></i></div>
</div>
<!-- Slider main container End -->

<!-- Sale Banner Section Start -->
<div class="section section-padding">
    <div class="container">

        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h3 class="sub-title">Тільки для тебе</h3>
            <h2 class="title title-icon-both">Виготовлення та крафтінг</h2>
        </div>
        <!-- Section Title End -->

        <div class="row learts-mb-n40">

            <div class="col-lg-5 col-md-6 col-12 me-auto learts-mb-40">
                <div class="sale-banner1" data-bg-image="{{ asset('images/banner/sale/sale-banner1-1.webp') }}">
                    <div class="inner">
                        <img src="{{ asset('images/banner/sale/sale-banner1-1.1.webp') }}" alt="Sale Banner Icon">
                        <span class="title">Весняний розпродаж</span>
                        <h2 class="sale-percent">
                            <span class="number">40</span> % <br> off
                        </h2>
                        <a href="{{ route('products.index') }}" class="link">купи зараз</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-12 learts-mb-40">
                <div class="sale-banner2">
                    <div class="inner">
                        <div class="image"><img src="{{ asset('images/banner/sale/sale-banner2-1.webp') }}" alt=""></div>
                        <div class="content row justify-content-between mb-n3">
                            <div class="col-auto mb-3">
                                <h2 class="sale-percent">10% off</h2>
                                <span class="text">ВАША НАСТУПНА ПОКУПКА</span>
                            </div>
                            <div class="col-auto mb-3">
                                <a class="btn btn-hover-dark" href="{{ route('products.index') }}">КУПИ ЗАРАЗ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Sale Banner Section End -->

<!-- Category Banner Section Start -->
<div class="section section-fluid section-padding pt-0">
    <div class="container">
        <div class="category-banner1-carousel">

            <div class="col">
                <div class="category-banner1">
                    <div class="inner">
                        <a href="{{ route('products.index') }}" class="image"><img src="{{ asset('images/banner/category/banner-s1-1.webp') }}" alt=""></a>
                        <div class="content">
                            <h3 class="title">
                                <a href="{{ route('products.index') }}">Ідеї подарунків</a>
                                <span class="number">16</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="category-banner1">
                    <div class="inner">
                        <a href="{{ route('products.index') }}" class="image"><img src="{{ asset('images/banner/category/banner-s1-2.webp') }}" alt=""></a>
                        <div class="content">
                            <h3 class="title">
                                <a href="{{ route('products.index') }}">Домашній декор</a>
                                <span class="number">16</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="category-banner1">
                    <div class="inner">
                        <a href="{{ route('products.index') }}" class="image"><img src="{{ asset('images/banner/category/banner-s1-3.webp') }}" alt=""></a>
                        <div class="content">
                            <h3 class="title">
                                <a href="{{ route('products.index') }}">Діти та немовлята</a>
                                <span class="number">6</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="category-banner1">
                    <div class="inner">
                        <a href="{{ route('products.index') }}" class="image"><img src="{{ asset('images/banner/category/banner-s1-4.webp') }}" alt=""></a>
                        <div class="content">
                            <h3 class="title">
                                <a href="{{ route('products.index') }}">Кухня</a>
                                <span class="number">15</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="category-banner1">
                    <div class="inner">
                        <a href="{{ route('products.index') }}" class="image"><img src="{{ asset('images/banner/category/banner-s1-5.webp') }}" alt=""></a>
                        <div class="content">
                            <h3 class="title">
                                <a href="{{ route('products.index') }}">В'язання та шиття</a>
                                <span class="number">4</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Category Banner Section End -->

<!-- Product Section Start -->
<div class="section section-fluid section-padding pt-0">
    <div class="container">

        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h3 class="sub-title">Купи зараз</h3>
            <h2 class="title title-icon-both">Купуйте наші бестселери</h2>
        </div>
        <!-- Section Title End -->

        <!-- Products Start -->
        <div class="products row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                                <span class="product-badges">
                                    <span class="onsale">-13%</span>
                                </span>
                            <img src="{{ asset('images/product/s328/product-1.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-1-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Boho Beard Mug</a></h6>
                        <span class="price">
                                <span class="old">$45.00</span>
                            <span class="new">$39.00</span>
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-2.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-2-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Motorized Tricycle</a></h6>
                        <span class="price">
                                $35.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                            <span class="product-badges">
                                <span class="hot">hot</span>
                            </span>
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-3.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-3-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Walnut Cutting Board</a></h6>
                        <span class="price">
                                $100.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                                <span class="product-badges">
                                    <span class="onsale">-27%</span>
                                </span>
                            <img src="{{ asset('images/product/s328/product-4.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-4-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Pizza Plate Tray</a></h6>
                        <span class="price">
                                <span class="old">$30.00</span>
                            <span class="new">$22.00</span>
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-5.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-5-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                        <div class="product-options">
                            <ul class="colors">
                                <li style="background-color: #c2c2c2;">color one</li>
                                <li style="background-color: #374140;">color two</li>
                                <li style="background-color: #8ea1b2;">color three</li>
                            </ul>
                            <ul class="sizes">
                                <li>Large</li>
                                <li>Medium</li>
                                <li>Small</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Minimalist Ceramic Pot</a></h6>
                        <span class="price">
                                $120.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-6.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-6-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Clear Silicate Teapot</a></h6>
                        <span class="price">
                                $140.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                                <span class="product-badges">
                                    <span class="hot">hot</span>
                                </span>
                            <img src="{{ asset('images/product/s328/product-7.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-7-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Lucky Wooden Elephant</a></h6>
                        <span class="price">
                                $35.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                                <span class="product-badges">
                                    <span class="outofstock"><i class="fal fa-frown"></i></span>
                                <span class="hot">hot</span>
                                </span>
                            <img src="{{ asset('images/product/s328/product-8.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-8-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                        <div class="product-options">
                            <ul class="colors">
                                <li style="background-color: #000000;">color one</li>
                                <li style="background-color: #b2483c;">color two</li>
                            </ul>
                            <ul class="sizes">
                                <li>Large</li>
                                <li>Medium</li>
                                <li>Small</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Decorative Christmas Fox</a></h6>
                        <span class="price">
                                $50.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-9.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-9-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Aluminum Equestrian</a></h6>
                        <span class="price">
                                $100.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-10.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-10-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Fish Cut Out Set</a></h6>
                        <span class="price">
                                $9.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-11.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-11-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Electric Egg Blender</a></h6>
                        <span class="price">
                                $200.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-12.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-12-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Cape Cottage Playhouse</a></h6>
                        <span class="price">
                                $35.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-13.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-13-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                        <div class="product-options">
                            <ul class="colors">
                                <li style="background-color: #ffffff;">color one</li>
                                <li style="background-color: #01796f;">color two</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Kernel Popcorn Bowl</a></h6>
                        <span class="price">
                                $25.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                                <span class="product-badges">
                                    <span class="outofstock"><i class="fal fa-frown"></i></span>
                                </span>
                            <img src="{{ asset('images/product/s328/product-14.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-14-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                        <div class="product-options">
                            <ul class="colors">
                                <li style="background-color: #000000;">color one</li>
                                <li style="background-color: #ffffff;">color two</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Abstract Folded Pots</a></h6>
                        <span class="price">
                                $50.00 - $55.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <a href="product-details.html" class="image">
                            <img src="{{ asset('images/product/s328/product-15.webp') }}" alt="Product Image">
                            <img class="image-hover " src="{{ asset('images/product/s328/product-15-hover.webp') }}" alt="Product Image">
                        </a>
                        <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="product-details.html">Brush & Dustpan Set</a></h6>
                        <span class="price">
                                $9.00
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Products End -->

    </div>
</div>
<!-- Product Section End -->

@endsection

{{--@section('page-script')--}}
{{--    <script src="{{ asset('js/plugins/scrollax.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/plugins/instafeed.min.js') }}"></script>--}}
{{--@endsection--}}
