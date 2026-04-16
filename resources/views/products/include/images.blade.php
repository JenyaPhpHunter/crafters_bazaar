@php
    $mode = $mode ?? 'view'; // за замовчуванням — режим перегляду

    $isEditOrCreate = in_array($mode, ['edit', 'create']);
    $isAdmin = auth()->check() && auth()->id() === 2;

    // Показуємо кнопки редагування тільки адміну в режимі edit/create
    $showMakeMainButton = $isEditOrCreate && $isAdmin;
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
               data-pswp-width="{{ $image['w'] ?? 1200 }}"
               data-pswp-height="{{ $image['h'] ?? 1600 }}"
               @if(!empty($image['id']))
                   data-photo-id="{{ $image['id'] }}"
                @endif
            >
                <img src="{{ $image['main'] ?? $image }}" alt="Product {{ $index + 1 }}">

                <button type="button" class="product-gallery-popup">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
                @if($showMakeMainButton)
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
                @endif
            </a>
        @empty
            <!-- placeholder або щось для порожньої галереї -->
        @endforelse
    </div>
</div>
