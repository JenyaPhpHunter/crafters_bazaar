{{--
    Цей файл використовується і для create, і для edit/show
    На create — $images буде порожнім масивом, фото додаються через JS
    На edit/show — $images містить існуючі фото з БД
--}}

@php
    // Перевірка: чи це сторінка редагування/перегляду (де є ProductPhoto з id)
    $isEditOrShow = !empty($images) && isset($images[0]['id']);
    // Показуємо кнопку автору (id=2) тільки на edit/show
    $showMakeMainButton = $isEditOrShow && auth()->check() && auth()->id() === 2;
@endphp

<div class="product-images vertical animate__animated animate__fadeIn">
    <!-- Прев'ю -->
    <div class="product-thumb-slider-vertical" id="productThumbSlider">
        @forelse($images ?? [] as $img)
            <div class="item">
                <img src="{{ $img['thumb'] }}" alt="Thumb">
            </div>
        @empty
            <p class="no-images-text">Зображень немає.</p>
        @endforelse
    </div>

    <!-- Галерея -->
    <div class="product-gallery-slider" id="product-gallery">
        @forelse($images ?? [] as $index => $image)
            <a class="product-zoom"
               data-pswp-src="{{ $image['src'] }}"
               data-pswp-width="{{ $image['w'] }}"
               data-pswp-height="{{ $image['h'] }}"
               @if(!empty($image['id']))
                   data-photo-id="{{ $image['id'] }}"
                @endif
            >
                <img src="{{ $image['main'] }}" alt="Product {{ $index + 1 }}">

                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>

                {{-- Кнопка "Зробити головним" для edit/show (тільки для автора id=2) --}}
                @if($showMakeMainButton)
                    <button
                        type="button"
                        class="make-main-badge"
                        data-photo-id="{{ $image['id'] }}"
                        title="Зробити це фото головним"
                    >
                        <i class="fa-solid fa-star"></i>
                        <span>Зробити головним фото</span>
                    </button>
                @endif
            </a>
        @empty
            <p class="no-images-text">Зображень немає.</p>
        @endforelse
    </div>
</div>
