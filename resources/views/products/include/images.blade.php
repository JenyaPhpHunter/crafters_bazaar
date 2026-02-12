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
            <a class="product-zoom" ... data-index="{{ $index }}">
                <img src="{{ $image['main'] ?? $image }}" alt="Product {{ $index + 1 }}">

                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>

                {{-- Кнопка "Зробити головним / Головне фото" --}}
                <button
                    type="button"
                    class="make-main-btn {{ $index === 0 ? 'is-main' : '' }}"
                    data-index="{{ $index }}"
                    title="{{ $index === 0 ? 'Це головне фото' : 'Зробити головним' }}"
                >
                    <i class="fa-solid fa-star"></i>
                    <span>{{ $index === 0 ? 'Головне фото' : 'Зробити головним' }}</span>
                </button>
            </a>
        @empty
            <!-- placeholder або щось для порожньої галереї -->
        @endforelse
    </div>
</div>
