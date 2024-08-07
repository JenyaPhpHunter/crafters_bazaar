@extends('admin.layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Створення товару</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Товари</a></li>
            @isset($product->name)
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->
    <!-- Заголовок сторінки/Хедер Початок -->
    {{--<div class="page-title" style="background: linear-gradient(to right, #f5f5dc, #ffdab9); padding: 15px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">--}}
    {{--    <h1 class="title" style="margin: 0; font-size: 24px; color: #4b4b4b;">Створення товару</h1>--}}
    {{--    <ul class="breadcrumb" style="list-style: none; padding: 0; margin: 10px 0 0 0; display: flex; gap: 10px;">--}}
    {{--        <li class="breadcrumb-item">--}}
    {{--            <a href="{{ route('welcome') }}" style="color: #4b4b4b; text-decoration: none; font-weight: 600;">Головна</a>--}}
    {{--        </li>--}}
    {{--        <li class="breadcrumb-item">--}}
    {{--            <a href="{{ route('products.index') }}" style="color: #4b4b4b; text-decoration: none; font-weight: 600;">Товари</a>--}}
    {{--        </li>--}}
    {{--        @isset($product->name)--}}
    {{--            <li class="breadcrumb-item active" style="color: #8b8b8b;">{{ $product->name }}</li>--}}
    {{--        @endisset--}}
    {{--    </ul>--}}
    {{--</div>--}}
    <!-- Заголовок сторінки/Хедер Кінець -->


    <!-- Single Products Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <!-- Product Images Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-images">
                        <button class="product-gallery-popup hintT-left" data-hint="Натисніть, щоб збільшити" data-images='[
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
                        <form method="post" action="{{ route('admin_products.store') }}">
                            @csrf
                            <input type="hidden" id="selectedColor" name="color" value="">

                            <label for="name">Назва</label>
                            <br>
                            <input id="name" name="name" type="text" class="product-title"
                                   placeholder="Введіть назву товару">
                            <br>

                            <label for="price">Вартість, грн</label>
                            <br>
                            <input type="number" id="price" name="price" min="0" step="1" class="product-title"
                                   placeholder="Введіть вартість товару">
                            <br>

                            <label for="content">Інформація про товар</label>
                            <br>
                            <textarea id="content" name="content" rows="10" cols="50"
                                      placeholder="Введіть опис товару, щоб зацікавити покупця"></textarea>
                            <br>

                            <label for="kind_product_id">Вид товару</label>
                            <br>

                            <select id="kind_product_id" name="kind_product_id">
                                @foreach($kind_products as $kind_product)
                                    <option value="{{ $kind_product->id }}">{{ $kind_product->name }}</option>
                                @endforeach
                            </select>
                            <br><br>
                            <button type="submit" name="action" value="Додати вид товару" class="btn btn-primary3">
                                <i class="fab fa-galactic-republic"></i> Додати вид товару
                            </button>
                            <br><br>

                            <label for="sub_kind_product_id">Підвид товару</label>
                            <br>
                            <select id="sub_kind_product_id" name="sub_kind_product_id">
                                @foreach($sub_kind_products as $sub_kind_product)
                                    <option value="{{ $sub_kind_product->id }}">{{ $sub_kind_product->name }}</option>
                                @endforeach
                            </select>
                            <br><br>
                            <button type="submit" name="action" value="Додати підвид товару" class="btn btn-primary3">
                                <i class="fab fa-galactic-republic"></i> Додати відвид товару
                            </button>
                            <br><br>

                            <label for="quantity">Кількість виробів в наявності</label>
                            <div class="product-quantity">
                                <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                <input type="text" class="input-qty" name="stock_balance" id="stockBalance" value="1">
                                <span class="qty-btn plus"><i class="ti-plus"></i></span>
                            </div>
                            <br><br>

                            <label for="quantity">Можу виробити цей товар ще</label>
                            <input type="checkbox" id="canProduce" name="can_produce">

                            {{--                        <div id="termCreationBlock" style="display: none;">--}}
                            <label for="quantity_day">Кількість днів для виготовлення і відправки</label>
                            <div id="termCreationBlock">
                                <div class="product-quantity">
                                    <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                    <input type="text" class="input-qty" name="term_creation" value="0">
                                    <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                </div>
                            </div>
                            <br>

                            <script>
                                $(function () {
                                    // Отримання посилання на елементи
                                    let stockBalanceInput = $("#stockBalance");
                                    let canProduceCheckbox = $("#canProduce");
                                    let termCreationBlock = $("#termCreationBlock");

                                    // Функція для оновлення стану елементів залежно від значення "Кількість виробів в наявності"
                                    function updateElementsState() {
                                        let stockBalanceValue = parseInt(stockBalanceInput.val());

                                        // Відмітити галочку, якщо "Кількість виробів в наявності" дорівнює 0
                                        canProduceCheckbox.prop("checked", stockBalanceValue === 0);

                                        // Показати або приховати блок "Кількість днів для виготовлення і відправки" залежно від галочки
                                        termCreationBlock.toggle(canProduceCheckbox.prop("checked"));
                                    }

                                    // Виклик функції під час завантаження сторінки та при зміні значення "Кількість виробів в наявності"
                                    updateElementsState();
                                    stockBalanceInput.change(updateElementsState);
                                });

                            </script>
                            <div class="product-variations">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="label"><span>Колір</span></td>
                                        <td class="value">
                                            @foreach($colors as $key => $color)
                                                <div
                                                    class="circle"
                                                    id="circle{{ $key + 1 }}"
                                                    data-name="Circle {{ $key + 1 }}"
                                                    data-color="{{ $color->code }}"
                                                    onclick="selectColor(this)"
                                                ></div>
                                                <style>
                                                    #circle{{ $key+1 }}  {
                                                        background-color: {{ $color->code }};
                                                    }
                                                </style>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <label for="product_photo" class="file-input-label">
                                <i class="fas fa-image"></i> <span id="file-label">Виберіть фото</span>
                            </label>
                            <input type="file" id="product_photo" name="product_photo[]" multiple style="display: none;" onchange="updateFileLabel(this);">
                            <br><br>
                            <div class="product-buttons">
                                <button type="submit" name="action" value="Виставити на продаж"
                                        class="btn btn-dark btn-outline-hover-dark">
                                    <i class="fas fa-donate"></i> Виставити на продаж
                                </button>
                                <button type="submit" name="action" value="Зберегти"
                                        class="btn btn-dark btn-outline-hover-dark">
                                    <i class="fas fa-save"></i> Зберегти
                                </button>
                            </div>
                        </form>
                        <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                            @isset($user_id)
                                <div class="col-auto learts-mb-20"><a href="{{ route('users.show',['user' => $user_id]) }}#account-info" class="btn btn-secondary">Перейти в профіль</a></div>
                            @endisset
                            <p>Перед тим як виставити товар на продаж, збережіть цей товар та  заповніть обов'язкові поля у своєму профілі.</p>
                        </div>
                        <div class="product-meta">
                            <table>
                                <tbody>
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

