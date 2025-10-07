<div class="product-images vertical animate__animated animate__fadeIn">
    <button class="product-gallery-popup hintT-left animate__animated animate__pulse" data-hint="Натисніть, щоб збільшити" data-images='[
        {"src": "{{ asset('images/product/single/1/product-zoom-1.webp') }}", "w": 700, "h": 1100},
        {"src": "{{ asset('images/product/single/1/product-zoom-2.webp') }}", "w": 700, "h": 1100},
        {"src": "{{ asset('images/product/single/1/product-zoom-3.webp') }}", "w": 700, "h": 1100},
        {"src": "{{ asset('images/product/single/1/product-zoom-4.webp') }}", "w": 700, "h": 1100}
    ]'>
        <i class="far fa-expand"></i>
    </button>

    <div class="product-thumb-slider-vertical">
        @for($i = 1; $i <= 4; $i++)
            <div class="item animate__animated animate__fadeIn">
                <img src="{{ asset("images/product/single/1/product-thumb-$i.webp") }}" alt="">
            </div>
        @endfor
    </div>

    <div class="product-gallery-slider">
        @for($i = 1; $i <= 4; $i++)
            <div class="product-zoom animate__animated animate__fadeIn" data-image="{{ asset("images/product/single/1/product-zoom-$i.webp") }}">
                <img src="{{ asset("images/product/single/1/product-$i.webp") }}" alt="">
            </div>
        @endfor
    </div>
</div>
