@extends('layouts.app')

@section('content')
    <body>
    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="{{ asset('images/bg/page-title-1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h1 class="title">Перегляд товару</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Товари</a></li>
                            @isset($product)
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <!-- Single Products Section Start -->
    <div class="section section-fluid section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n50">

                <div class="col-xl-9 col-lg-8 col-12 learts-mb-50">
                    <div class="row learts-mb-n40">

                        <!-- Product Images Start -->
                        <div class="col-xl-6 col-12 learts-mb-40">
                            <div class="product-images">
                                <span class="product-badges">
                                    <span class="hot">hot</span>
                                </span>
                                <button class="product-gallery-popup hintT-left" data-hint="Натисніть, щоб збільшити" data-images='[
                                                {"src": "{{ asset('images/product/single/4/product-zoom-1.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-2.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-3.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-4.webp') }}", "w": 700, "h": 1100}
                                            ]'><i class="far fa-expand"></i></button>
                                <div class="product-gallery-slider">
                                    @foreach ($photos as $photo)
                                        <div class="product-zoom"
                                             data-image="{{ asset($photo->path . '/' . $photo->filename) }}">
                                            <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-thumb-slider">
                                    @foreach ($photos as $photo)
                                        <div class="item">
                                            <img src="{{ asset($photo->small_path . '/' . $photo->small_filename) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Product Images End -->

                        <!-- Product Summery Start -->
                        <div class="col-xl-6 col-12 learts-mb-40">
                            <div class="product-summery product-summery-center">
                                <div class="product-nav">
                                    <a href="#"><i class="fal fa-long-arrow-left"></i></a>
                                    <a href="#"><i class="fal fa-long-arrow-right"></i></a>
                                </div>
                                <div class="product-ratings">
                                <span class="star-rating">
                                    <span class="rating-active" style="width: 80%;">ratings</span>
                                </span>
                                    <a href="#reviews" class="review-link">(<span class="count">2</span> відгуки покупців)</a>
                                </div>
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <div class="product-price">{{ $product->price }} грн</div>
                                <div class="product-description">
                                    <p> {{ $product->content }}</p>
                                </div>
                                <div class="product-variations">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="label"><span>Кількість</span></td>
                                            <td class="value">
                                                <div class="product-quantity">
                                                    <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                                    <input type="text" class="input-qty" value="{{ $product->stock_balance }}">
                                                    <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="product-buttons">
                                    <a href="{{ route('wishlist.addToWishlist',['product' => $product->id]) }}" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Додати до улюблених"><i class="fal fa-heart"></i></a>
                                    <a href="{{ route('carts.addToCart',['product' => $product->id]) }}" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i> Додати до корзини</a>
                                    <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Порівняти"><i class="fal fa-random"></i></a>
                                </div>
                                <div class="product-brands">
                                    <span class="title">Автор товару</span>
                                    <div class="brands">
                                        <a href="#"><img src="{{ asset('images/brands/brand-4.webp')}}" alt=""></a>
                                    </div>
                                </div>
                                <div class="col-auto learts-mb-20">
                                    <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-primary2">Редагувати</a>
                                    <br><br>
{{--                                    <form id="delete-form-show" method="post">--}}
{{--                                        @csrf--}}
{{--                                        @method('delete')--}}
{{--                                        <a href="{{ route('products.destroy', ['product' => $product->id]) }}" class="btn btn-primary"--}}
{{--                                           onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>--}}
{{--                                    </form>--}}
                                </div>
                                <div class="product-meta">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="label"><span>SKU</span></td>
                                            <td class="value">040422</td>
                                        </tr>
                                        <tr>
                                            <td class="label"><span>Категорія</span></td>
                                            <td class="value">
                                                <ul class="product-category">
                                                    <li><a href="{{ route('products.filter', ['categories' => [$product->kind_product->id]]) }}">{{ $product->kind_product->name }}</a></li>
                                                    <li><a href="{{ route('products.filter', ['sub_categories' => [$product->sub_kind_product->id]]) }}">{{ $product->sub_kind_product->name }}</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label"><span>Теги</span></td>
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
                                            <td class="label"><span>Поділитися</span></td>
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

                <div class="col-xl-3 col-lg-4 col-12 learts-mb-50">

                    <!-- Search Start -->
                    <div class="single-widget learts-mb-40">
                        <div class="widget-search">
                            <form action="#">
                                <input type="text" placeholder="Пошук товару....">
                                <button><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- Search End -->

                    <!-- Categories Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Види товарів</h3>
                        <ul class="widget-list">
                            @foreach($kind_products as $kind_product)
                                @if($kind_product->product)
                                    <li><a href="{{ route('products.filter', ['categories' => [$kind_product->id]]) }}">{{ $kind_product->name }}</a> <span class="count">{{ $kind_product->product->count() }}</span></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!-- Categories End -->

                    <!-- Price Range Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Фільтрувати по вартосі</h3>
                        <div class="widget-price-range">
                            <input class="range-slider" type="text" data-min="0" data-max="350" data-from="0" data-to="350" />
                        </div>
                    </div>
                    <!-- Price Range End -->

                    <!-- List Product Widget Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Товари</h3>
                        <ul class="widget-products">
                            @foreach($featured_products as $featured_product)
                                <li class="product">
                                    <div class="thumbnail">
                                        <a href="{{ route('products.show',['product' => $featured_product->id]) }}">
                                            @php
                                                $selectedPhoto = $featured_product->productphotos->where('queue', 1)->first();
                                            @endphp
                                            @isset($selectedPhoto)
                                                <img src="{{ asset($selectedPhoto->small_path . '/' . $selectedPhoto->small_filename) }}" alt="Featured product">
                                            @else
                                                <img src="{{ asset('images/product/widget-1.webp') }}" alt="Featured product">
                                            @endisset
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="title"><a href="product-details.html">{{ $featured_product->name }}</a></h6>
                                        <span class="price">
                                                {{ $featured_product->price }} грн
                                            </span>
                                        <div class="ratting">
                                            <span class="rate" style="width: 80%;"></span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- List Product Widget End -->

                    <!-- Tags Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Теги товарів</h3>
                        <div class="widget-tags">
                            <a href="#">handmade</a>
                            <a href="#">learts</a>
                            <a href="#">mug</a>
                            <a href="#">product</a>
                            <a href="#">learts</a>
                        </div>
                    </div>
                    <!-- Tags End -->

                </div>

            </div>
        </div>

    </div>
    <!-- Single Products Section End -->
    <!-- Single Products Infomation Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Опис</a></li>
                <li><a data-bs-toggle="tab" href="#tab-pwb_tab">Бренд</a></li>
                <li><a data-bs-toggle="tab" href="#tab-reviews">Відгуки (2)</a></li>
            </ul>
            <div class="tab-content product-infor-tab-content">
                <div class="tab-pane fade show active" id="tab-description">
                    <div class="row">
                        <div class="col-lg-10 col-12 mx-auto">
                            <p>Place and move your wireless Blink camera anywhere around your home both inside and out. Start off with a small system and expand to up to 10 cameras on one Blink Sync Module. Built-in motion sensor alarm. When motion detector is triggered, Wi-Fi cameras will send an alert to your smartphone and record a short clip of the event to the cloud.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pwb_tab">
                    <div class="row learts-mb-n30">
                        <div class="col-12 learts-mb-30">
                            <div class="row learts-mb-n10">
                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img src="{{ asset('images/brands/brand-4.webp') }}" alt=""></div>
                                <div class="col learts-mb-10">
                                    <p>Most people are not ready to immediately buy upon seeing an online ad or visiting a new website about eCommerce. But that’s not the story with us. We are here to take the lead and tackle all challenges. By retargeting the subject, we’ve been able to reach out to more customers worldwide and become one of the most favored brands in the industry.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-reviews">
                    <div class="product-review-wrapper">
                        <span class="title">2 reviews for Modern Camera</span>
                        <ul class="product-review-list">
                            <li>
                                <div class="product-review">
                                    <div class="thumb"><img src="{{ asset('images/review/review-2.webp') }}" alt=""></div>
                                    <div class="content">
                                        <div class="ratings">
                                        <span class="star-rating">
                                            <span class="rating-active" style="width: 100%;">ratings</span>
                                        </span>
                                        </div>
                                        <div class="meta">
                                            <h5 class="title">Scott James</h5>
                                            <span class="date">November 27, 2020</span>
                                        </div>
                                        <p>Thanks for always keeping your WordPress themes up to date. Your level of support and dedication is second to none.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="product-review">
                                    <div class="thumb"><img src="{{ asset('images/review/review-1.webp') }}" alt=""></div>
                                    <div class="content">
                                        <div class="ratings">
                                        <span class="star-rating">
                                            <span class="rating-active" style="width: 80%;">ratings</span>
                                        </span>
                                        </div>
                                        <div class="meta">
                                            <h5 class="title">Edna Watson</h5>
                                            <span class="date">November 27, 2020</span>
                                        </div>
                                        <p>Wonderful quality, and an awesome design !</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <span class="title">Add a review</span>
                        <div class="review-form">
                            <p class="note">Your email address will not be published. Required fields are marked *</p>
                            <form action="#">
                                <div class="row learts-mb-n30">
                                    <div class="col-md-6 col-12 learts-mb-30"><input type="text" placeholder="Name *"></div>
                                    <div class="col-md-6 col-12 learts-mb-30"><input type="email" placeholder="Email *"></div>
                                    <div class="col-12 learts-mb-10">
                                        <div class="form-rating">
                                            <span class="title">Your rating</span>
                                            <span class="rating"><span class="star"></span></span>
                                        </div>
                                    </div>
                                    <div class="col-12 learts-mb-30"><textarea placeholder="Your Review *"></textarea></div>
                                    <div class="col-12 text-center learts-mb-30"><button class="btn btn-dark btn-outline-hover-dark">Submit</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Single Products Infomation Section End -->

    {{--    <!-- Page Title/Header Start -->--}}
    {{--    <div class="page-title">--}}
    {{--        <h1 class="title">Перегляд товару</h1>--}}
    {{--        <ul class="breadcrumb">--}}
    {{--            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>--}}
    {{--            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Товари</a></li>--}}
    {{--            @isset($product)--}}
    {{--                <li class="breadcrumb-item active">{{ $product->name }}</li>--}}
    {{--            @endisset--}}
    {{--        </ul>--}}
    {{--    </div>--}}

    {{--    <div class="page-title-section section" data-bg-image="{{ asset('images/bg/page-title-1.webp') }}">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col">--}}

    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <!-- Page Title/Header End -->--}}

    {{--    <!-- Single Products Section Start -->--}}
    {{--    <div class="section section-padding border-bottom">--}}
    {{--        <div class="row learts-mb-n40">--}}
    {{--            <!-- Product Images Start -->--}}
    {{--            <div class="col-lg-6 col-12 learts-mb-40">--}}
    {{--                <div class="product-images">--}}
    {{--                    <button class="product-gallery-popup hintT-left" data-hint="Click to enlarge" data-images='[--}}
    {{--                    {"src": "{{ asset('images/product/single/1/product-zoom-1.webp') }}", "w": 700, "h": 1100},--}}
    {{--                    {"src": "{{ asset('images/product/single/1/product-zoom-2.webp') }}", "w": 700, "h": 1100},--}}
    {{--                    {"src": "{{ asset('images/product/single/1/product-zoom-3.webp') }}", "w": 700, "h": 1100},--}}
    {{--                    {"src": "{{ asset('images/product/single/1/product-zoom-4.webp') }}", "w": 700, "h": 1100}--}}
    {{--                ]'><i class="far fa-expand"></i></button>--}}
    {{--                    <a href="https://www.youtube.com/watch?v=1jSsy7DtYgc"--}}
    {{--                       class="product-video-popup video-popup hintT-left" data-hint="Click to see video"><i--}}
    {{--                            class="fal fa-play"></i></a>--}}
    {{--                    <div class="product-gallery-slider">--}}
    {{--                        @foreach ($photos as $photo)--}}
    {{--                            <div class="product-zoom"--}}
    {{--                                 data-image="{{ asset($photo->zoom_path . '/' . $photo->zoom_filename) }}">--}}
    {{--                                <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                        <div class="product-zoom"--}}
    {{--                             data-image="{{ asset('images/product/single/1/product-zoom-1.webp') }}">--}}
    {{--                            <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">--}}
    {{--                            <img src="{{ asset('images/product/single/1/product-1.webp') }}" alt="">--}}
    {{--                        </div>--}}
    {{--                        <div class="product-zoom"--}}
    {{--                             data-image="{{ asset('images/product/single/1/product-zoom-2.webp') }}">--}}
    {{--                            <img src="{{ asset('images/product/single/1/product-2.webp') }}" alt="">--}}
    {{--                        </div>--}}
    {{--                        <div class="product-zoom"--}}
    {{--                             data-image="{{ asset('images/product/single/1/product-zoom-3.webp') }}">--}}
    {{--                            <img src="{{ asset('images/product/single/1/product-3.webp') }}" alt="">--}}
    {{--                        </div>--}}
    {{--                        <div class="product-zoom"--}}
    {{--                             data-image="{{ asset('images/product/single/1/product-zoom-4.webp') }}">--}}
    {{--                            <img src="{{ asset('images/product/single/1/product-4.webp') }}" alt="">--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-thumb-slider">--}}
    {{--                        @foreach ($photos as $photo)--}}
    {{--                            <div class="item">--}}
    {{--                                <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">--}}
    {{--                                {{ $photo->zoomhoverphoto->first->path }}--}}
    {{--                            </div>--}}
    {{--                        @endforeach--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <!-- Product Images End -->--}}

    {{--            <!-- Product Summery Start -->--}}
    {{--            <div class="col-lg-6 col-12 learts-mb-40">--}}
    {{--                <div class="product-summery">--}}
    {{--                    <div class="product-nav">--}}
    {{--                        <a href="#"><i class="fal fa-long-arrow-left"></i></a>--}}
    {{--                        <a href="#"><i class="fal fa-long-arrow-right"></i></a>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-ratings">--}}
    {{--                    <span class="star-rating">--}}
    {{--                        <span class="rating-active" style="width: 100%;">рейтинг</span>--}}
    {{--                    </span>--}}
    {{--                        <a href="#reviews" class="review-link">(<span class="count">3</span> відгуки покупців)</a>--}}
    {{--                    </div>--}}
    {{--                    <h3 class="product-title">{{ $product->name }}</h3>--}}
    {{--                    @if($user_id == $product->user_id)--}}
    {{--                        <h4> (Статус Вашого замовлення - {{ $product->status_product->name }})</h4>--}}
    {{--                    @endif--}}
    {{--<br>--}}
    {{--                    <div class="product-price">{{ $product->price }} грн</div>--}}
    {{--                    <div class="product-description">--}}
    {{--                        <p>{{ $product->content }}</p>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-variations">--}}
    {{--                        <table>--}}
    {{--                            <tbody>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Розмір</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    @if($product->size_id)--}}
    {{--                                        <div class="product-sizes"></div>--}}
    {{--                                        {{ $product->size->name }}--}}
    {{--                                    @else--}}
    {{--                                        <div class="product-sizes">Розмір не вказаний</div>--}}
    {{--                                    @endif--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Колір</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    @if($product->color_id)--}}
    {{--                                        <div class="circle" style="background-color: {{ $product->color->code }}"></div>--}}
    {{--                                        <style>--}}
    {{--                                            .circle {--}}
    {{--                                                width: 18px;--}}
    {{--                                                height: 18px;--}}
    {{--                                                margin-right: 15px;--}}
    {{--                                                border: 1px solid #DDDDDD;--}}
    {{--                                                border-radius: 50%;--}}
    {{--                                                display: inline-block;--}}
    {{--                                                cursor: pointer;--}}
    {{--                                            }--}}
    {{--                                        </style>--}}
    {{--                                    @else--}}
    {{--                                        <div class="circle">Колір не вказаний</div>--}}
    {{--                                    @endif--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Кількість</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    <div class="product-quantity">--}}
    {{--                                        <span class="qty-btn minus"><i class="ti-minus"></i></span>--}}
    {{--                                        <input type="text" class="input-qty" value="{{ $product->stock_balance }}">--}}
    {{--                                        <span class="qty-btn plus"><i class="ti-plus"></i></span>--}}
    {{--                                    </div>--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            </tbody>--}}
    {{--                        </table>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-meta">--}}
    {{--                        <table>--}}
    {{--                            <tbody>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>ID</span></td>--}}
    {{--                                <td class="value">{{ $product->id }}</td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Вид</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    <ul class="product-category">--}}
    {{--                                        <li><a href="#">{{ $product->kind_product->name }}</a></li>--}}
    {{--                                    </ul>--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Підвид</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    <ul class="product-category">--}}
    {{--                                        <li><a href="#">{{ $product->sub_kind_product->name }}</a></li>--}}
    {{--                                    </ul>--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Tags</span></td>--}}
    {{--                                <td class="value">--}}
    {{--                                    <ul class="product-tags">--}}
    {{--                                        <li><a href="#">handmade</a></li>--}}
    {{--                                        <li><a href="#">learts</a></li>--}}
    {{--                                        <li><a href="#">mug</a></li>--}}
    {{--                                        <li><a href="#">product</a></li>--}}
    {{--                                        <li><a href="#">learts</a></li>--}}
    {{--                                    </ul>--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            <tr>--}}
    {{--                                <td class="label"><span>Share on</span></td>--}}
    {{--                                <td class="va">--}}
    {{--                                    <div class="product-share">--}}
    {{--                                        <a href="#"><i class="fab fa-facebook-f"></i></a>--}}
    {{--                                        <a href="#"><i class="fab fa-twitter"></i></a>--}}
    {{--                                        <a href="#"><i class="fab fa-google-plus-g"></i></a>--}}
    {{--                                        <a href="#"><i class="fab fa-pinterest"></i></a>--}}
    {{--                                        <a href="#"><i class="fal fa-envelope"></i></a>--}}
    {{--                                    </div>--}}
    {{--                                </td>--}}
    {{--                            </tr>--}}
    {{--                            </tbody>--}}
    {{--                        </table>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-buttons">--}}
    {{--                        <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top"--}}
    {{--                           data-hint="Add to Wishlist"><i class="fal fa-heart"></i></a>--}}
    {{--                        <a href="#" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i>--}}
    {{--                            Add to Cart</a>--}}
    {{--                        <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top"--}}
    {{--                           data-hint="Compare"><i class="fal fa-random"></i></a>--}}
    {{--                    </div>--}}
    {{--                    <div class="product-brands">--}}
    {{--                        <span class="title">Brands</span>--}}
    {{--                        <div class="brands">--}}
    {{--                            <a href="#"><img src="{{ asset('images/brands/brand-3.webp') }}" alt=""></a>--}}
    {{--                            <a href="#"><img src="{{ asset('images/brands/brand-8.webp') }}" alt=""></a>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <!-- Product Summery End -->--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <!-- Single Products Section End -->--}}

    {{--    <!-- Single Products Infomation Section Start -->--}}
    {{--    <div class="section section-padding border-bottom">--}}
    {{--        <div class="container">--}}

    {{--            <ul class="nav product-info-tab-list">--}}
    {{--                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Description</a></li>--}}
    {{--                <li><a data-bs-toggle="tab" href="#tab-pwb_tab">Brand</a></li>--}}
    {{--                <li><a data-bs-toggle="tab" href="#tab-additional_information">Additional information</a></li>--}}
    {{--                <li><a data-bs-toggle="tab" href="#tab-reviews">Reviews (3)</a></li>--}}
    {{--            </ul>--}}
    {{--            <div class="tab-content product-infor-tab-content">--}}
    {{--                <div class="tab-pane fade show active" id="tab-description">--}}
    {{--                    <div class="row">--}}
    {{--                        <div class="col-lg-10 col-12 mx-auto">--}}
    {{--                            <p>Easy clip-on handle – Hold the brush and dustpan together for storage; the dustpan edge--}}
    {{--                                is serrated to allow easy scraping off the hair without entanglement. High-quality--}}
    {{--                                bristles – no burr damage, no scratches, thick and durable, comfortable to remove dust--}}
    {{--                                and smaller particles. Rubber lip – The rubber lip on the front of the dustpan helps to--}}
    {{--                                remove all dust at once.</p>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="tab-pane fade" id="tab-pwb_tab">--}}
    {{--                    <div class="row learts-mb-n30">--}}
    {{--                        <div class="col-12 learts-mb-30">--}}
    {{--                            <div class="row learts-mb-n10">--}}
    {{--                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img--}}
    {{--                                        src="{{ asset('images/brands/brand-3.webp') }}" alt=""></div>--}}
    {{--                                <div class="col learts-mb-10">--}}
    {{--                                    <p>We’ve worked with numerous industries and famous fashion brands around the world.--}}
    {{--                                        We have also created tremendous impacts on fashion manufacturing and online--}}
    {{--                                        sales. When we partner with an eCommerce agency, we connect every activity to--}}
    {{--                                        set the trend and win customers’ trust. We make sure our customers are always--}}
    {{--                                        happy with our products.</p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="col-12 learts-mb-30">--}}
    {{--                            <div class="row learts-mb-n10">--}}
    {{--                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img--}}
    {{--                                        src="{{ asset('images/brands/brand-8.webp') }}" alt=""></div>--}}
    {{--                                <div class="col learts-mb-10">--}}
    {{--                                    <p>Prior to Houdini, there have been many clothing brands that achieved such a--}}
    {{--                                        roaring success. However, there’s no other brand that can obtain such a precious--}}
    {{--                                        position like us. We have successfully built our site to make more people know--}}
    {{--                                        about our products as well as our motto. We’ve been the inspiration for many--}}
    {{--                                        other small and medium-sized businesses.</p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="tab-pane fade" id="tab-additional_information">--}}
    {{--                    <div class="row">--}}
    {{--                        <div class="col-lg-8 col-md-10 col-12 mx-auto">--}}
    {{--                            <div class="table-responsive">--}}
    {{--                                <table class="table table-bordered">--}}
    {{--                                    <tbody>--}}
    {{--                                    <tr>--}}
    {{--                                        <td>Size</td>--}}
    {{--                                        <td>Large, Medium, Small</td>--}}
    {{--                                    </tr>--}}
    {{--                                    <tr>--}}
    {{--                                        <td>Color</td>--}}
    {{--                                        <td>Black, White</td>--}}
    {{--                                    </tr>--}}
    {{--                                    </tbody>--}}
    {{--                                </table>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="tab-pane fade" id="tab-reviews">--}}
    {{--                    <div class="product-review-wrapper">--}}
    {{--                        <span class="title">3 reviews for Cleaning Dustpan & Brush</span>--}}
    {{--                        <ul class="product-review-list">--}}
    {{--                            <li>--}}
    {{--                                <div class="product-review">--}}
    {{--                                    <div class="thumb"><img src="{{ asset('images/review/review-1.webp') }}" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="content">--}}
    {{--                                        <div class="ratings">--}}
    {{--                                        <span class="star-rating">--}}
    {{--                                            <span class="rating-active" style="width: 100%;">ratings</span>--}}
    {{--                                        </span>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="meta">--}}
    {{--                                            <h5 class="title">Edna Watson</h5>--}}
    {{--                                            <span class="date">November 27, 2020</span>--}}
    {{--                                        </div>--}}
    {{--                                        <p>Thanks for always keeping your WordPress themes up to date. Your level of--}}
    {{--                                            support and dedication is second to none.</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </li>--}}
    {{--                            <li>--}}
    {{--                                <div class="product-review">--}}
    {{--                                    <div class="thumb"><img src="{{ asset('images/review/review-2.webp') }}" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="content">--}}
    {{--                                        <div class="ratings">--}}
    {{--                                        <span class="star-rating">--}}
    {{--                                            <span class="rating-active" style="width: 80%;">ratings</span>--}}
    {{--                                        </span>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="meta">--}}
    {{--                                            <h5 class="title">Scott James</h5>--}}
    {{--                                            <span class="date">November 27, 2020</span>--}}
    {{--                                        </div>--}}
    {{--                                        <p>Thanks for always keeping your WordPress themes up to date. Your level of--}}
    {{--                                            support and dedication is second to none.</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </li>--}}
    {{--                            <li>--}}
    {{--                                <div class="product-review">--}}
    {{--                                    <div class="thumb"><img src="{{ asset('images/review/review-3.webp') }}" alt="">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="content">--}}
    {{--                                        <div class="ratings">--}}
    {{--                                        <span class="star-rating">--}}
    {{--                                            <span class="rating-active" style="width: 60%;">ratings</span>--}}
    {{--                                        </span>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="meta">--}}
    {{--                                            <h5 class="title">Owen Christ</h5>--}}
    {{--                                            <span class="date">November 27, 2020</span>--}}
    {{--                                        </div>--}}
    {{--                                        <p>Good Product!</p>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </li>--}}
    {{--                        </ul>--}}
    {{--                        <span class="title">Add a review</span>--}}
    {{--                        <div class="review-form">--}}
    {{--                            <p class="note">Your email address will not be published. Required fields are marked *</p>--}}
    {{--                            <form action="#">--}}
    {{--                                <div class="row learts-mb-n30">--}}
    {{--                                    <div class="col-md-6 col-12 learts-mb-30"><input type="text" placeholder="Name *">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-md-6 col-12 learts-mb-30"><input type="email" placeholder="Email *">--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-12 learts-mb-10">--}}
    {{--                                        <div class="form-rating">--}}
    {{--                                            <span class="title">Your rating</span>--}}
    {{--                                            <span class="rating"><span class="star"></span></span>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-12 learts-mb-30"><textarea placeholder="Your Review *"></textarea>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-12 text-center learts-mb-30">--}}
    {{--                                        <button class="btn btn-dark btn-outline-hover-dark">Submit</button>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </form>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <!-- Single Products Infomation Section End -->--}}


    <!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

<!-- Background of PhotoSwipe.
 It's a separate element as animating opacity is faster than rgba(). -->
<div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
        PhotoSwipe keeps only 3 of them in the DOM to save memory.
        Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>

@endsection
