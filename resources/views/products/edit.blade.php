@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Редагування товару</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Товари</a></li>
            @isset($product->name)
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            @endisset
        </ul>
    </div>
    @isset($product)
        <div class="breadcrumb-item active">Статус товару: {{ $product->status_product->name }}</div>
    @endisset
    <!-- Page Title/Header End -->

    <!-- Single Products Section Start -->
    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <!-- Product Images Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-images">
{{--                                <span class="product-badges">--}}
{{--                                    <span class="hot">hot</span>--}}
{{--                                </span>--}}
                    <button class="product-gallery-popup hintT-left" data-hint="Натисніть, щоб збільшити" data-images='[
                                                {"src": "{{ asset('images/product/single/4/product-zoom-1.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-2.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-3.webp') }}", "w": 700, "h": 1100},
                                                {"src": "{{ asset('images/product/single/4/product-zoom-4.webp') }}", "w": 700, "h": 1100}
                                            ]'><i class="far fa-expand"></i></button>
                    <a href="https://www.youtube.com/watch?v=1jSsy7DtYgc"
                       class="product-video-popup video-popup hintT-left" data-hint="Натисніть, щоб подивтись відео"><i
                            class="fal fa-play"></i></a>
                    @if($photos->count() > 0)
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
                    @else
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
                    @endif
                </div>
            </div>
            <!-- Product Images End -->

            <!-- Product Summery Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-summery">
                    <form method="post" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" id="selectedColor" name="color" value="">

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
                            @foreach($kind_products as $kind_product)
                                <option value="{{ $kind_product->id }}" {{ $product->kind_product->id == $kind_product->id ? 'selected' : '' }}>{{ $kind_product->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <button type="submit" name="action" value="Додати вид товару" class="btn btn-primary3">
                            <i class="fab fa-galactic-republic"></i> Додати вид товару
                        </button>
                        <br><br>

                        <label for="sub_kind_product_id">Підвид товару</label>
                        <br>
                        <select id="sub_kind_product_id" name="sub_kind_product_id">
                            @foreach($sub_kind_products as $sub_kind_product)
                                <option value="{{ $sub_kind_product->id }}" {{ $product->sub_kind_product->id == $sub_kind_product->id ? 'selected' : '' }}>{{ $sub_kind_product->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <button type="submit" name="action" value="Додати підвид товару" class="btn btn-primary3">
                            <i class="fab fa-galactic-republic"></i> Додати відвид товару
                        </button>
                        <br><br>

                        <label for="quantity">Кількість виробів в наявності</label>
                        <div class="product-quantity">
                            <span class="qty-btn minus"><i class="ti-minus"></i></span>
                            <input type="text" class="input-qty" name="stock_balance" id="stockBalance" value={{ $product->stock_balance }}>
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
                                <input type="text" class="input-qty" name="term_creation" value={{ $product->term_creation }}>
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
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Колір</span></td>
                                    <td class="value">
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
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <label for="product_photo" class="file-input-label">
                            <i class="fas fa-image"></i> <span id="file-label">Виберіть фото</span>
                        </label>
                        <input type="file" id="product_photo" name="product_photo[]" multiple style="display: none;" onchange="updateFileLabel(this);">
                        <div class="product-buttons">
                            <button type="submit" name="action" value="Зберегти"
                                    class="btn btn-dark btn-outline-hover-dark">
                                <i class="fas fa-save"></i> Зберегти
                            </button>
                            <button type="submit" name="action" value="Виставити на продаж"
                                    class="btn btn-dark btn-outline-hover-dark">
                                <i class="fas fa-donate"></i> Виставити на продаж
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
        <!-- Slides wrapper with overflow:hidden. -->
{{--        <div class="pswp__scroll-wrap">--}}

            <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
{{--            <div class="pswp__container">--}}
{{--                <div class="pswp__item"></div>--}}
{{--                <div class="pswp__item"></div>--}}
{{--                <div class="pswp__item"></div>--}}
{{--            </div>--}}

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
{{--            <div class="pswp__ui pswp__ui--hidden">--}}

{{--                <div class="pswp__top-bar">--}}

{{--                    <!--  Controls are self-explanatory. Order can be changed. -->--}}

{{--                    <div class="pswp__counter"></div>--}}

{{--                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>--}}

{{--                    <button class="pswp__button pswp__button--share" title="Share"></button>--}}

{{--                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>--}}

{{--                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>--}}

{{--                    <div class="pswp__preloader">--}}
{{--                        <div class="pswp__preloader__icn">--}}
{{--                            <div class="pswp__preloader__cut">--}}
{{--                                <div class="pswp__preloader__donut"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">--}}
{{--                    <div class="pswp__share-tooltip"></div>--}}
{{--                </div>--}}

{{--                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">--}}
{{--                </button>--}}

{{--                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">--}}
{{--                </button>--}}

{{--                <div class="pswp__caption">--}}
{{--                    <div class="pswp__caption__center"></div>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
    <!-- Root element of PhotoSwipe. Must have class pswp. -->
{{--    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">--}}

{{--        <!-- Background of PhotoSwipe.--}}
{{--         It's a separate element as animating opacity is faster than rgba(). -->--}}
{{--        <div class="pswp__bg"></div>--}}

{{--        <!-- Slides wrapper with overflow:hidden. -->--}}
{{--        <div class="pswp__scroll-wrap">--}}

{{--            <!-- Container that holds slides.--}}
{{--            PhotoSwipe keeps only 3 of them in the DOM to save memory.--}}
{{--            Don't modify these 3 pswp__item elements, data is added later on. -->--}}
{{--            <div class="pswp__container">--}}
{{--                <div class="pswp__item"></div>--}}
{{--                <div class="pswp__item"></div>--}}
{{--                <div class="pswp__item"></div>--}}
{{--            </div>--}}

{{--            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->--}}
{{--            <div class="pswp__ui pswp__ui--hidden">--}}

{{--                <div class="pswp__top-bar">--}}

{{--                    <!--  Controls are self-explanatory. Order can be changed. -->--}}

{{--                    <div class="pswp__counter"></div>--}}

{{--                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>--}}

{{--                    <button class="pswp__button pswp__button--share" title="Share"></button>--}}

{{--                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>--}}

{{--                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>--}}

{{--                    <div class="pswp__preloader">--}}
{{--                        <div class="pswp__preloader__icn">--}}
{{--                            <div class="pswp__preloader__cut">--}}
{{--                                <div class="pswp__preloader__donut"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">--}}
{{--                    <div class="pswp__share-tooltip"></div>--}}
{{--                </div>--}}

{{--                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">--}}
{{--                </button>--}}

{{--                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">--}}
{{--                </button>--}}

{{--                <div class="pswp__caption">--}}
{{--                    <div class="pswp__caption__center"></div>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </div>--}}
@endsection
