@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Перегляд товару</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin_products.index') }}">Товари</a></li>
            @isset($product)
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            @endisset
        </ul>
    </div>

    <div class="page-title-section section" data-bg-image="{{ asset('images/bg/page-title-1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col">

                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <!-- Single Products Section Start -->
    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <!-- Product Images Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-images">
                    <button class="product-gallery-popup hintT-left" data-hint="Click to enlarge" data-images='[
                    {"src": "{{ asset('images/product/single/1/product-zoom-1.webp') }}", "w": 700, "h": 1100},
                    {"src": "{{ asset('images/product/single/1/product-zoom-2.webp') }}", "w": 700, "h": 1100},
                    {"src": "{{ asset('images/product/single/1/product-zoom-3.webp') }}", "w": 700, "h": 1100},
                    {"src": "{{ asset('images/product/single/1/product-zoom-4.webp') }}", "w": 700, "h": 1100}
                ]'><i class="far fa-expand"></i></button>
                    <a href="https://www.youtube.com/watch?v=1jSsy7DtYgc"
                       class="product-video-popup video-popup hintT-left" data-hint="Click to see video"><i
                            class="fal fa-play"></i></a>
                    <div class="product-gallery-slider">
                        @foreach ($photos as $photo)
                            <div class="product-zoom"
                                 data-image="{{ asset($photo->zoom_path . '/' . $photo->zoom_filename) }}">
                                <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">
                            </div>
                        @endforeach
                        <div class="product-zoom"
                             data-image="{{ asset('images/product/single/1/product-zoom-1.webp') }}">
                            {{--                            <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">--}}
                            <img src="{{ asset('images/product/single/1/product-1.webp') }}" alt="">
                        </div>
                        <div class="product-zoom"
                             data-image="{{ asset('images/product/single/1/product-zoom-2.webp') }}">
                            <img src="{{ asset('images/product/single/1/product-2.webp') }}" alt="">
                        </div>
                        <div class="product-zoom"
                             data-image="{{ asset('images/product/single/1/product-zoom-3.webp') }}">
                            <img src="{{ asset('images/product/single/1/product-3.webp') }}" alt="">
                        </div>
                        <div class="product-zoom"
                             data-image="{{ asset('images/product/single/1/product-zoom-4.webp') }}">
                            <img src="{{ asset('images/product/single/1/product-4.webp') }}" alt="">
                        </div>
                    </div>
                    <div class="product-thumb-slider">
                        @foreach ($photos as $photo)
                            <div class="item">
                                <img src="{{ asset($photo->path.'/'.$photo->filename) }}" alt="">
                                {{--                                {{ $photo->zoomhoverphoto->first->path }}--}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Product Images End -->

            <!-- Product Summery Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-summery">
                    <div class="product-nav">
                        <a href="#"><i class="fal fa-long-arrow-left"></i></a>
                        <a href="#"><i class="fal fa-long-arrow-right"></i></a>
                    </div>
                    <div class="product-ratings">
                    <span class="star-rating">
                        <span class="rating-active" style="width: 100%;">рейтинг</span>
                    </span>
                        <a href="#reviews" class="review-link">(<span class="count">3</span> відгуки покупців)</a>
                    </div>
                    <h3 class="product-title">{{ $product->name }}</h3>
                    @if($user_id == $product->user_id)
                        <h4> (Статус Вашого замовлення - {{ $product->status_product->name }})</h4>
                    @endif
                    <br>
                    <div class="product-price">{{ $product->price }} грн</div>
                    <div class="product-description">
                        <p>{{ $product->content }}</p>
                    </div>
                    <div class="product-variations">
                        <table>
                            <tbody>
                            <tr>
                                <td class="label"><span>Розмір</span></td>
                                <td class="value">
                                    @if($product->size_id)
                                        <div class="product-sizes"></div>
                                        {{ $product->size->name }}
                                    @else
                                        <div class="product-sizes">Розмір не вказаний</div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><span>Колір</span></td>
                                <td class="value">
                                    @if($product->color_id)
                                        <div class="circle" style="background-color: {{ $product->color->code }}"></div>
                                        <style>
                                            .circle {
                                                width: 18px;
                                                height: 18px;
                                                margin-right: 15px;
                                                border: 1px solid #DDDDDD;
                                                border-radius: 50%;
                                                display: inline-block;
                                                cursor: pointer;
                                            }
                                        </style>
                                    @else
                                        <div class="circle">Колір не вказаний</div>
                                    @endif
                                </td>
                            </tr>
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
                    <div class="product-meta">
                        <table>
                            <tbody>
                            <tr>
                                <td class="label"><span>ID</span></td>
                                <td class="value">{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <td class="label"><span>Вид</span></td>
                                <td class="value">
                                    <ul class="product-category">
                                        <li><a href="#">{{ $product->kind_product->name }}</a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"><span>Підвид</span></td>
                                <td class="value">
                                    <ul class="product-category">
                                        <li><a href="#">{{ $product->sub_kind_product->name }}</a></li>
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
                    <div class="col-auto learts-mb-20">
                        <a href="{{ route('admin_products.edit', ['admin_product' => $product->id]) }}" class="btn btn-primary2">Редагувати</a>
                        <br><br>
                        <form id="delete-form-show" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('admin_products.destroy', ['admin_product' => $product->id]) }}" class="btn btn-primary"
                               onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Product Summery End -->
        </div>
    </div>
    <!-- Single Products Section End -->

    <!-- Single Products Infomation Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Description</a></li>
                <li><a data-bs-toggle="tab" href="#tab-pwb_tab">Brand</a></li>
                <li><a data-bs-toggle="tab" href="#tab-additional_information">Additional information</a></li>
                <li><a data-bs-toggle="tab" href="#tab-reviews">Reviews (3)</a></li>
            </ul>
            <div class="tab-content product-infor-tab-content">
                <div class="tab-pane fade show active" id="tab-description">
                    <div class="row">
                        <div class="col-lg-10 col-12 mx-auto">
                            <p>Easy clip-on handle – Hold the brush and dustpan together for storage; the dustpan edge
                                is serrated to allow easy scraping off the hair without entanglement. High-quality
                                bristles – no burr damage, no scratches, thick and durable, comfortable to remove dust
                                and smaller particles. Rubber lip – The rubber lip on the front of the dustpan helps to
                                remove all dust at once.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pwb_tab">
                    <div class="row learts-mb-n30">
                        <div class="col-12 learts-mb-30">
                            <div class="row learts-mb-n10">
                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img
                                        src="{{ asset('images/brands/brand-3.webp') }}" alt=""></div>
                                <div class="col learts-mb-10">
                                    <p>We’ve worked with numerous industries and famous fashion brands around the world.
                                        We have also created tremendous impacts on fashion manufacturing and online
                                        sales. When we partner with an eCommerce agency, we connect every activity to
                                        set the trend and win customers’ trust. We make sure our customers are always
                                        happy with our products.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 learts-mb-30">
                            <div class="row learts-mb-n10">
                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img
                                        src="{{ asset('images/brands/brand-8.webp') }}" alt=""></div>
                                <div class="col learts-mb-10">
                                    <p>Prior to Houdini, there have been many clothing brands that achieved such a
                                        roaring success. However, there’s no other brand that can obtain such a precious
                                        position like us. We have successfully built our site to make more people know
                                        about our products as well as our motto. We’ve been the inspiration for many
                                        other small and medium-sized businesses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-additional_information">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 col-12 mx-auto">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>Size</td>
                                        <td>Large, Medium, Small</td>
                                    </tr>
                                    <tr>
                                        <td>Color</td>
                                        <td>Black, White</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-reviews">
                    <div class="product-review-wrapper">
                        <span class="title">3 reviews for Cleaning Dustpan & Brush</span>
                        <ul class="product-review-list">
                            <li>
                                <div class="product-review">
                                    <div class="thumb"><img src="{{ asset('images/review/review-1.webp') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="ratings">
                                        <span class="star-rating">
                                            <span class="rating-active" style="width: 100%;">ratings</span>
                                        </span>
                                        </div>
                                        <div class="meta">
                                            <h5 class="title">Edna Watson</h5>
                                            <span class="date">November 27, 2020</span>
                                        </div>
                                        <p>Thanks for always keeping your WordPress themes up to date. Your level of
                                            support and dedication is second to none.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="product-review">
                                    <div class="thumb"><img src="{{ asset('images/review/review-2.webp') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="ratings">
                                        <span class="star-rating">
                                            <span class="rating-active" style="width: 80%;">ratings</span>
                                        </span>
                                        </div>
                                        <div class="meta">
                                            <h5 class="title">Scott James</h5>
                                            <span class="date">November 27, 2020</span>
                                        </div>
                                        <p>Thanks for always keeping your WordPress themes up to date. Your level of
                                            support and dedication is second to none.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="product-review">
                                    <div class="thumb"><img src="{{ asset('images/review/review-3.webp') }}" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="ratings">
                                        <span class="star-rating">
                                            <span class="rating-active" style="width: 60%;">ratings</span>
                                        </span>
                                        </div>
                                        <div class="meta">
                                            <h5 class="title">Owen Christ</h5>
                                            <span class="date">November 27, 2020</span>
                                        </div>
                                        <p>Good Product!</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <span class="title">Add a review</span>
                        <div class="review-form">
                            <p class="note">Your email address will not be published. Required fields are marked *</p>
                            <form action="#">
                                <div class="row learts-mb-n30">
                                    <div class="col-md-6 col-12 learts-mb-30"><input type="text" placeholder="Name *">
                                    </div>
                                    <div class="col-md-6 col-12 learts-mb-30"><input type="email" placeholder="Email *">
                                    </div>
                                    <div class="col-12 learts-mb-10">
                                        <div class="form-rating">
                                            <span class="title">Your rating</span>
                                            <span class="rating"><span class="star"></span></span>
                                        </div>
                                    </div>
                                    <div class="col-12 learts-mb-30"><textarea placeholder="Your Review *"></textarea>
                                    </div>
                                    <div class="col-12 text-center learts-mb-30">
                                        <button class="btn btn-dark btn-outline-hover-dark">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Single Products Infomation Section End -->

@endsection

