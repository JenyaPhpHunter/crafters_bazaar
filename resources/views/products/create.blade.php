@extends('layouts.app')

@section('content')
    <div class="section section-fluid section-padding border-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                    @include('products.include.images')
                    @include('products.include.additional-info')
                </div>
                <!-- Product Summery Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-summery product-summery-center animate__animated animate__slideInRight">
                        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data" id="product-form" class="animate__animated animate__zoomIn">
                            @csrf
                            <input type="hidden" name="color_id" id="selectedColor" value="">
                            <input type="hidden" name="brand_id" id="selectedBrand" value="">
                            <input type="hidden" name="action" id="form-action" value="">
                            <input type="hidden" name="additional_information" id="additional-info-hidden" value="">
                            <div class="mb-4">
                                @include('products.include.title-price')
                            </div>
                            <div class="mb-4">
                                @include('products.include.kind-subkind')
                            </div>
                            <div class="mb-4">
                                @include('products.include.quantity-produce')
                            </div>
                            <div class="mb-4">
                                @include('products.include.colors')
                            </div>
                            <div class="mb-4">
                                @include('products.include.file_upload')
                            </div>
                            <div class="mb-4">
                                @include('products.include.brands')
                            </div>
                            <div class="mb-4">
                                @include('products.include.tags_social')
                            </div>
                        </form>
                        @isset($user)
                            @if(empty($user->name) || empty($user->surname) || empty($user->email) || empty($user->phone))
                                <div class="alert alert-warning alert-dismissible fade show mt-4 animate__animated animate__bounceIn" role="alert">
                                    <div class="col-auto learts-mb-20">
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}#account-info"
                                           class="btn btn-secondary">Перейти в профіль</a>
                                    </div>
                                    <p>Перед тим як виставити товар на продаж, збережіть цей товар та заповніть
                                        обов'язкові поля у своєму профілі.</p>
                                </div>
                            @endif
                        @endisset
                    </div>
                </div>
                <!-- Product Summery End -->
            </div>
            <!-- Додаємо кнопки після обох колонок, по центру -->
            <div class="product-buttons-centered animate__animated animate__fadeInUp">
                @include('products.include.buttons')
            </div>
        </div>
    </div>

{{--    @include('products.include.product-info-tabs')--}}
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
