@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title-section section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Товари</a></li>
                            @isset($product)
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            @endisset
                        </ul>
                    </div>
                    @isset($product)
                        <div class="breadcrumb-item active">Статус товару: {{ $product->status_product->name }}</div>
                    @endisset
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
                                @php
                                    $galleryImages = $product->productphotos->map(function($photo) {
                                        return [
                                            'src' => asset('photos/' . $photo->zoom_filename),
                                            'w' => 700, // Можете замінити на реальну ширину зображення
                                            'h' => 1100 // Можете замінити на реальну висоту зображення
                                        ];
                                    });
                                @endphp
                                <button class="product-gallery-popup hintT-left" data-hint="Натисніть, щоб збільшити" data-images='@json($galleryImages)'>
                                    <i class="far fa-expand"></i>
                                </button>
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
                                <br><br><br>
                                <div>
                                    <!-- Chat Start -->
                                    @foreach($dialogs_with_answers as $dialog)
                                        <div class="comment-container">
                                            <div class="comment {{ $dialog->user_id != $creator ? 'comment-left' : 'comment-right' }}">
                                                @if($dialog->answer_to)
                                                    Відповідь на {{ $dialog->answerTo->comment }}
                                                @endif
                                                {{ $dialog->user->name }}: <br>
                                                {{ $dialog->comment }}
                                                <button class="reply-button" data-dialog-id="{{ $dialog->id }}">
                                                    <i class="fas fa-reply"></i> Відповісти
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $('.reply-button').click(function() {
                                                var dialogId = $(this).data('dialog-id');
                                                var commentText = $(this).closest('.comment-container').find('.comment').text();
                                                $('#dialogId').val(dialogId);
                                                $('#commentText').text(commentText);
                                                $('#replyModal').modal('show');
                                            });

                                            // Обробник події для кнопки закриття модального вікна
                                            $('#replyModal').on('hidden.bs.modal', function (e) {
                                                $('#replyTextarea').val(''); // Очистити вміст поля відповіді
                                            });
                                        });
                                    </script>

                                    <!-- Модальне вікно -->
                                    <div class="modal" id="replyModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Відповісти на коментар</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="commentText"></div> <!-- Додати блок для відображення тексту коментаря -->
                                                    <form id="replyForm" method="post" action="{{ route('products.sendquestion', ['product' => $product->id]) }}">
                                                        @csrf <!-- Додати токен CSRF -->
                                                        <input type="hidden" id="dialogId" name="dialogId" value="">
                                                        <textarea id="replyTextarea" name="replyText" rows="4" cols="50"></textarea>
                                                        <button type="submit" class="btn btn-primary">Відправити</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Chat End -->
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
                                            <td class="label"><span>Кількість виробів в наявності</span></td>
                                            <td class="value">
                                                <div class="product-price">
                                                    <span>{{ $product->stock_balance }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @if($product->term_creation != 0)
                                            <tr>
                                                <td class="label"><span>Кількість днів для виготовлення і відправки</span></td>
                                                <td class="value">
                                                    <div class="product-price">
                                                        <span>{{ $product->term_creation }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="product-buttons">
                                    @if($product->status_product_id == 3 && !$creator)
                                        <a href="{{ route('wishlist.addToWishlist',['product' => $product->id]) }}" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Додати до улюблених"><i class="fal fa-heart"></i></a>
                                        <a href="{{ route('carts.addToCart',['product' => $product->id]) }}" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i> Додати до корзини</a>
                                    @endif
                                    <a href="#" class="btn btn-icon btn-outline-body btn-hover-dark hintT-top" data-hint="Порівняти"><i class="fal fa-random"></i></a>
                                </div>
                                <div class="product-brands">
                                    <span class="title">Автор товару</span>
                                    {{ $product->user->name }}
                                    <div class="brands">
                                        <a href="#"><img src="{{ asset('images/brands/brand-4.webp')}}" alt=""></a>
                                    </div>
                                </div>
                                @if($user)
                                    @if($creator || $user->role_id < 5)
                                    <div class="col-auto learts-mb-20">
                                        <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-primary2">Редагувати</a>
                                        <br><br>
                                        <form id="delete-form-show" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('products.destroy', ['product' => $product->id]) }}" class="btn btn-primary"
                                               onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
                                        </form>
                                    </div>
                                    @endif
                                @endif
                                @if($product->status_product_id == 3 && !$creator)
                                    <div id="questionContainer">
                                        <button id="askAuthorBtn" class="btn btn-info" data-product-id="{{ $product->id }}">Запитати автора</button>
                                    </div>
                                    <br><br>
                                    <div id="questionField" style="display: none;">
                                        <form id="submitQuestionForm" method="post" action="{{ route('products.sendquestion', ['product' => $product->id]) }}">
                                            <textarea id="questionTextarea" name="questionText" rows="4" cols="50" style="border: 1px solid #000;"></textarea>
                                            <br><br>
                                            @csrf
                                            <button id="submitQuestionBtn" class="btn btn-primary">Запитати</button>
                                        </form>
                                        <button id="cancelQuestionBtn" class="btn btn-secondary">Відмінити</button>
                                    </div>
                                @endif
                                @if($user)
                                    @if(($creator && $product->status_product_id == 1) || ($user->role_id < 5 && $product->status_product_id == 1))
                                        <form method="post" action="{{ route('products.update', ['product' => $product->id]) }}">
                                            @csrf
                                            @method('put')
                                        <button type="submit" name="action" value="put_for_sale_from_show"
{{--                                        <button type="submit" name="action" value="put_for_sale"--}}
                                                class="btn btn-success">
                                            <i class="fas fa-donate"></i> {{$action_types['put_up_for_sale']}}
                                        </button>
                                        </form>
                                    @endif
                                @endif
                                <div class="product-meta">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="label"><span>SKU</span></td>
                                            <td class="value">{{ $product->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="label"><span>Категорія</span></td>
                                            <td class="value">
                                                <ul class="product-category">
                                                    <li><a href="{{ route('products.filter', ['categories' => [$product->sub_kind_product->kind_product_id]]) }}">{{ $product->sub_kind_product->kind_product->name }}</a></li>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#askAuthorBtn").click(function(){
                    // При нажатии на кнопку "Запитати автора"
                    @auth
                    $("#questionContainer").hide();  // Скрыть контейнер кнопки "Запитати автора"
                    $("#questionField").show();      // Показать текстовое поле
                    @else
                    // Если пользователь не аутентифицирован, перенаправить его на страницу входа с передачей product_id
                    // Получить значение product_id
                    var product_id = $(this).data('product-id');
                    window.location.href = '/login?sendquestion=sendquestion&product_id=' + product_id;
                    @endauth
                });

                $("#cancelQuestionBtn").click(function(){
                    // При нажатии на кнопку "Відмінити"
                    $("#questionField").hide();      // Скрыть текстовое поле
                    $("#questionContainer").show();  // Показать контейнер кнопки "Запитати автора"
                });
            });
        </script>
    </div>
    <!-- Single Products Section End -->
    <!-- Single Products Infomation Section Start -->
    <div class="section section-padding border-bottom">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-bs-toggle="tab" href="#tab-description">Опис від ШІ</a></li>
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
