<div class="product-images vertical animate__animated animate__fadeIn">
    <!-- Прев’ю -->
    <div class="product-thumb-slider-vertical">
        @forelse($images ?? [] as $img)
            <div class="item">
                <img src="{{ $img['thumb'] }}" alt="Thumb">
            </div>
        @empty
            <p>Зображень немає.</p>
        @endforelse
    </div>

    <!-- Галерея -->
    <div class="product-gallery-slider">
        @forelse($images ?? [] as $index => $image)
            <div class="product-zoom"
                 data-pswp-src="{{ $image['src'] }}"
                 data-pswp-width="{{ $image['w'] }}"
                 data-pswp-height="{{ $image['h'] }}">

                <img src="{{ $image['main'] }}" alt="Product {{ $index + 1 }}">

                <button class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
            </div>
        @empty
            <p>Зображень немає.</p>
        @endforelse
    </div>
</div>
