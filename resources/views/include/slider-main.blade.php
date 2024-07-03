<!-- Slider main container Start -->
<div class="home12-slider section swiper-container">
    <div class="swiper-wrapper">
        <div class="home12-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home12/slide-1.webp') }}">
            <div class="home12-slide1-content">
                <div class="bg"></div>
                <span class="sub-title">Перше замовлення</span>
                <h2 class="title">Тільки для тебе</h2>
                <img class="price" src="{{ asset('images/banner/sale/sale-banner4-1.1.webp') }}" alt="">
            </div>
        </div>
        <div class="home12-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home12/slide-2.webp') }}">
            <div class="home12-slide2-content">
                <div class="bg"></div>
                <img src="{{ asset('images/logo/logo-4-big.webp') }}" alt="" class="icon">
                <span class="title">Весняні знижки</span>
                <img class="price " src="{{ asset('images/slider/home12/slide-2.1.webp') }}" alt="">
                <div class="link"><a href="{{ route('products.index') }}">Коллекція магазину</a></div>
            </div>
        </div>
        <div class="home12-slide-item swiper-slide" data-swiper-autoplay="5000" data-bg-image="{{ asset('images/slider/home12/slide-3.webp') }}">
            <div class="home12-slide3-content">
                <h2 class="title">Тільки для тебе</h2>
                <h3 class="sub-title">
                    <img class="left-icon " src="{{ asset('images/slider/home1/slide-2-2.webp') }}" alt="Slide Icon">
                    Making & crafting
                    <img class="right-icon " src="{{ asset('images/slider/home1/slide-2-3.webp') }}" alt="Slide Icon">
                </h3>
                <span class="price">Від 500 грн</span>
            </div>
        </div>
    </div>
    <div class="home12-slider-prev swiper-button-prev"><i class="ti-angle-left"></i></div>
    <div class="home12-slider-next swiper-button-next"><i class="ti-angle-right"></i></div>
</div>
<!-- Slider main container End -->
