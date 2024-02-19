@extends('admin.layouts.app')

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
    <div class="page-title">
        <h1 class="title">Редагування та підтвердження товару</h1>
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin_products.index') }}">Товари</a></li>
        @isset($product)
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        @endisset
        </ul>
    </div>
    @isset($product)
        <div class="breadcrumb-item active">Статус товару: {{ $product->status_product->name }}</div>
    @endisset
    <!-- Page Title/Header End -->

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
                                <button class="product-gallery-popup hintT-left" data-hint="Click to enlarge" data-images='[
                                                {"src": "assets/images/product/single/4/product-zoom-1.webp", "w": 700, "h": 1100},
                                                {"src": "assets/images/product/single/4/product-zoom-2.webp", "w": 700, "h": 1100},
                                                {"src": "assets/images/product/single/4/product-zoom-3.webp", "w": 700, "h": 1100},
                                                {"src": "assets/images/product/single/4/product-zoom-1.webp", "w": 700, "h": 1100}
                                            ]'><i class="far fa-expand"></i></button>
                                <div class="product-gallery-slider">
                                    <div class="product-zoom" data-image="assets/images/product/single/4/product-zoom-1.webp">
                                        <img src="assets/images/product/single/4/product-1.webp" alt="">
                                    </div>
                                    <div class="product-zoom" data-image="assets/images/product/single/4/product-zoom-2.webp">
                                        <img src="assets/images/product/single/4/product-2.webp" alt="">
                                    </div>
                                    <div class="product-zoom" data-image="assets/images/product/single/4/product-zoom-3.webp">
                                        <img src="assets/images/product/single/4/product-3.webp" alt="">
                                    </div>
                                    <div class="product-zoom" data-image="assets/images/product/single/4/product-zoom-1.webp">
                                        <img src="assets/images/product/single/4/product-1.webp" alt="">
                                    </div>
                                </div>
                                <div class="product-thumb-slider">
                                    <div class="item">
                                        <img src="assets/images/product/single/4/product-thumb-1.webp" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="assets/images/product/single/4/product-thumb-2.webp" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="assets/images/product/single/4/product-thumb-3.webp" alt="">
                                    </div>
                                    <div class="item">
                                        <img src="assets/images/product/single/4/product-thumb-1.webp" alt="">
                                    </div>
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
                                    <a href="#reviews" class="review-link">(<span class="count">2</span> customer reviews)</a>
                                </div>
                                <h3 class="product-title">Modern Camera</h3>
                                <div class="product-price">£380.00</div>
                                <div class="product-description">
                                    <p>Place and move your wireless Blink camera anywhere around your home both inside and out. Start off with a small system and expand to up to 10 cameras on one Blink Sync Module. Built-in motion sensor alarm. When motion detector is triggered, Wi-Fi cameras will send an alert to your smartphone.</p>
                                    <p>The camera’s high resolution makes it perfect for landscapes and portraits and the 8 frames per second top shooting speed at full 18 Megapixel resolution allows the EOS 7D to capture the action, no matter how fast it’s happening. If you’re into travel photography, the movie function.</p>
                                    <p>If you’re more into making videos, then you’ll find the APS-C sized sensor is a good choice for Full HD shooting. The APS-C format, whilst smaller than full-frame, is still larger than 16mm film and, as such, provides more control over depth-of-field than high-end video and film movie cameras.</p>
                                </div>
                                <div class="product-variations">
                                    <table>
                                        <tbody>
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
                                    <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Add to Wishlist"><i class="fal fa-heart"></i></a>
                                    <a href="#" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i> Add to Cart</a>
                                    <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                                </div>
                                <div class="product-brands">
                                    <span class="title">Brands</span>
                                    <div class="brands">
                                        <a href="#"><img src="assets/images/brands/brand-4.webp" alt=""></a>
                                    </div>
                                </div>
                                <div class="product-meta">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="label"><span>SKU</span></td>
                                            <td class="value">040422</td>
                                        </tr>
                                        <tr>
                                            <td class="label"><span>Category</span></td>
                                            <td class="value">
                                                <ul class="product-category">
                                                    <li><a href="#">Gift ideas</a></li>
                                                    <li><a href="#">Home Decor</a></li>
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

                <div class="col-xl-3 col-lg-4 col-12 learts-mb-50">

                    <!-- Search Start -->
                    <div class="single-widget learts-mb-40">
                        <div class="widget-search">
                            <form action="#">
                                <input type="text" placeholder="Search products....">
                                <button><i class="fal fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <!-- Search End -->

                    <!-- Categories Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Product categories</h3>
                        <ul class="widget-list">
                            <li><a href="#">Gift ideas</a> <span class="count">16</span></li>
                            <li><a href="#">Home Decor</a> <span class="count">16</span></li>
                            <li><a href="#">Kids &amp; Babies</a> <span class="count">6</span></li>
                            <li><a href="#">Kitchen</a> <span class="count">15</span></li>
                            <li><a href="#">Kniting &amp; Sewing</a> <span class="count">4</span></li>
                            <li><a href="#">Pots</a> <span class="count">4</span></li>
                            <li><a href="#">Toys</a> <span class="count">6</span></li>
                        </ul>
                    </div>
                    <!-- Categories End -->

                    <!-- Price Range Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Filters by price</h3>
                        <div class="widget-price-range">
                            <input class="range-slider" type="text" data-min="0" data-max="350" data-from="0" data-to="350" />
                        </div>
                    </div>
                    <!-- Price Range End -->

                    <!-- List Product Widget Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Products</h3>
                        <ul class="widget-products">
                            <li class="product">
                                <div class="thumbnail">
                                    <a href="product-details.html"><img src="assets/images/product/widget-1.webp" alt="List product"></a>
                                </div>
                                <div class="content">
                                    <h6 class="title"><a href="product-details.html">Walnut Cutting Board</a></h6>
                                    <span class="price">
                                        $100.00
                                    </span>
                                    <div class="ratting">
                                        <span class="rate" style="width: 80%;"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="product">
                                <div class="thumbnail">
                                    <a href="product-details.html"><img src="assets/images/product/widget-2.webp" alt="List product"></a>
                                </div>
                                <div class="content">
                                    <h6 class="title"><a href="product-details.html">Decorative Christmas Fox</a></h6>
                                    <span class="price">
                                        $50.00
                                    </span>
                                    <div class="ratting">
                                        <span class="rate" style="width: 80%;"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="product">
                                <div class="thumbnail">
                                    <a href="product-details.html"><img src="assets/images/product/widget-3.webp" alt="List product"></a>
                                </div>
                                <div class="content">
                                    <h6 class="title"><a href="product-details.html">Lucky Wooden Elephant</a></h6>
                                    <span class="price">
                                        $35.00
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- List Product Widget End -->

                    <!-- Tags Start -->
                    <div class="single-widget learts-mb-40">
                        <h3 class="widget-title product-filter-widget-title">Product Tags</h3>
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
                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Description</a></li>
                <li><a data-bs-toggle="tab" href="#tab-pwb_tab">Brand</a></li>
                <li><a data-bs-toggle="tab" href="#tab-reviews">Reviews (2)</a></li>
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
                                <div class="col-lg-2 col-md-3 col-12 learts-mb-10"><img src="assets/images/brands/brand-4.webp" alt=""></div>
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
                                    <div class="thumb"><img src="assets/images/review/review-2.webp" alt=""></div>
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
                                    <div class="thumb"><img src="assets/images/review/review-1.webp" alt=""></div>
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
                        <div class="product-zoom"
                             data-image="{{ asset('images/product/single/1/product-zoom-1.webp') }}">
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
                        <div class="item">
                            <img src="{{ asset('images/product/single/1/product-thumb-1.webp') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/product/single/1/product-thumb-2.webp') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/product/single/1/product-thumb-3.webp') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('images/product/single/1/product-thumb-4.webp') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Images End -->

            <!-- Product Summery Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-summery">
                    <form method="post" action="{{ route('admin_products.update', ['admin_product' => $product->id]) }}">
                        @csrf
                        @method('put')
                        <input type="hidden" id="selectedColor" name="product_color" value="{{ $product->color_id }}">

                        <label for="name">Назва</label>
                        <br>
                        <input id="name" name="name" type="text" class="product-title"
                               placeholder="Введіть назву товару" value="{{ $product->name }}">
                        <br>

                        <label for="price">Вартість, грн</label>
                        <br>
                        <input type="number" id="price" name="price" min="0" step="1" class="product-title"
                               placeholder="Введіть вартість товару" value="{{ $product->price }}">
                        <br>

                        <label for="content">Інформація про товар</label>
                        <br>
                        <textarea id="content" name="content" rows="10" cols="50"
                                  placeholder="Введіть опис товару, щоб зацікавити покупця">{{ $product->content }}</textarea>
                        <br>

                        <label for="kind_product_id">Вид товару</label>
                        <br>
                        <select id="kind_product_id" name="kind_product_id">
                            @if(isset($kind_product_obj))
                                @foreach($kind_products as $kind_product)
                                    <option
                                        value="{{ $kind_product_obj->id }}" {{ $kind_product_obj->id == $kind_product->id ? 'selected' : '' }}>{{ $kind_product->name }}</option>
                                @endforeach
                            @else
                                @foreach($kind_products as $kind_product)
                                    <option value="{{ $kind_product->id }}">{{ $kind_product->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <button type="submit" name="action" value="Додати вид товару" class="btn btn-primary3">
                            <i class="fab fa-galactic-republic"></i> Додати вид товару
                        </button>
                        <br><br>

                        <label for="sub_kind_product_id">Підвид товару</label>
                        <br>
                        <select id="sub_kind_product_id" name="sub_kind_product_id">
                            @if(isset($sub_kind_product_obj))
                                @foreach($sub_kind_products as $sub_kind_product)
                                    <option
                                        value="{{ $sub_kind_product_obj->id }}" {{ $sub_kind_product_obj->id == $sub_kind_product->id ? 'selected' : '' }}>{{ $sub_kind_product->name }}</option>
                                @endforeach
                            @else
                                @foreach($sub_kind_products as $sub_kind_product)
                                    <option value="{{ $sub_kind_product->id }}">{{ $sub_kind_product->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <button type="submit" name="action" value="Додати підвид товару" class="btn btn-primary3">
                            <i class="fab fa-galactic-republic"></i> Додати відвид товару
                        </button>
                        <br><br>

                        <label for="quantity">Кількість</label>
                        <div class="product-quantity">
                            <span class="qty-btn minus"><i class="ti-minus"></i></span>
                            <input type="text" class="input-qty" name="stock_balance" value= {{ $product->stock_balance }}>
                            <span class="qty-btn plus"><i class="ti-plus"></i></span>
                        </div>
                        <div class="product-variations">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="label"><span>Розмір</span></td>
                                    <td class="value">
                                        <div class="product-sizes">
                                            @foreach($sizes as $size)
                                                @php
                                                    $isSelected = $product->size_id === $size->id;
                                                @endphp
                                                <a href="#" data-size-id="{{ $size->id }}" onclick="selectSize(this); return false;" class="{{ $isSelected ? 'selected' : '' }}">
                                                    {{ $size->name }}
                                                </a>
                                            @endforeach
                                            <input type="hidden" name="selected_size" id="selected_size" value="{{ $product->size_id }}">

                                            <script>
                                                function selectSize(sizeLink) {
                                                    // Знімаємо виділення з усіх розмірів
                                                    var sizeLinks = document.querySelectorAll('.product-sizes a');
                                                    var sizeId = sizeLink.getAttribute('data-size-id');
                                                    sizeLinks.forEach(function (link) {
                                                        link.classList.remove('selected');
                                                    });

                                                    // Виділяємо обраний розмір
                                                    sizeLink.classList.add('selected');
                                                    document.getElementById('selected_size').value = sizeId;

                                                    // Тепер ви можете зберегти це значення у прихованому полі або використовувати його інакше в вашій формі
                                                }
                                            </script>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Колір</span></td>
                                    <td class="value">
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

                                            .circle.selected {
                                                border: 2px solid #007BFF;
                                            }
                                        </style>
                                        @foreach($colors as $key => $color)
                                            @php
                                                $isSelected = $product->color_id === $color->id;
                                            @endphp
                                            <div
                                                class="circle {{ $isSelected ? 'selected' : '' }}"
                                                id="circle{{ $color->id }}"
                                                data-name="Circle {{ $key + 1 }}"
                                                data-color="{{ $color->code }}"
                                                onclick="selectColor(this)"
                                            ></div>
                                            <style>
                                                #circle{{ $color->id }} {
                                                    background-color: {{ $color->code }};
                                                }
                                            </style>
                                        @endforeach
                                        <script>
                                            function selectColor(circle) {
                                                // Знімаємо виділення з усіх кружечків
                                                var circles = document.querySelectorAll('.circle');
                                                circles.forEach(function (c) {
                                                    c.classList.remove('selected');
                                                });

                                                // Виділяємо вибраний кружечок
                                                circle.classList.add('selected');

                                                // Отримуємо id кружка з його id
                                                var selectedColor = circle.id.replace('circle', '');

                                                // Оновлюємо значення прихованого поля з id обраного кружка
                                                document.getElementById('selectedColor').value = selectedColor;
                                            }
                                        </script>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="product-buttons">
                            <button type="submit" name="action" value="Зберегти"
                                    class="btn btn-dark btn-outline-hover-dark">
                                <i class="fas fa-save"></i> Зберегти
                            </button>
                            <button type="submit" name="action" value="Виставити на продаж"
                                    class="btn btn-danger">
                                <i class="fab fa-angellist"></i> Виставити на продаж
                            </button>
                        </div>
                    </form>
                    <div class="product-meta">
                        <table>
                            <tbody>
                            <tr>
                                <td class="label"><span>ID товара</span></td>
                                <td class="value">{{ $product->id }}</td>
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
                                <td class="label"><span>Поширити</span></td>
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
    <!-- Single Products Section End -->

    <!-- Single Products Infomation Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Опис</a></li>
                <li><a data-bs-toggle="tab" href="#tab-additional_information">Додаткова інформація</a></li>
                <li><a data-bs-toggle="tab" href="#tab-reviews">Відгуки (3)</a></li>
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
@endsection
