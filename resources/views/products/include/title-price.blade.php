@php
    $mode = $mode ?? 'view';
    $isView = $mode === 'view';

    $titleValue = old('title') ?? ($product?->title ?? '');
    $priceRaw = old('price') ?? ($product?->price ?? '');
    $priceFormatted = $priceRaw ? number_format((int)$priceRaw, 0, '', ' ') : '';
@endphp

@if($isView)
    <!-- Режим ПЕРЕГЛЯДУ -->
    <div class="title-price-wrapper mb-5">
        <h1 class="product-title">{{ $titleValue }}</h1>
        <div class="product-price">
            <strong>{{ $priceFormatted }}</strong> грн
        </div>
    </div>

@else
    <!-- Режим РЕДАГУВАННЯ -->
    <!-- НАЗВА ТОВАРУ -->
    <div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="title-price-wrapper position-relative">
            <label for="title" class="form-label">Назва товару</label>
            <div class="input-group input-group-lg">
                <div id="title"
                     class="form-control title-price-input {{ $titleValue ? 'has-content' : '' }}"
                     contenteditable="true"
                     data-placeholder="Введіть назву товару"
                     spellcheck="false">{{ $titleValue }}</div>
                <input type="hidden" name="title" id="title-hidden" value="{{ $titleValue }}">
            </div>
        </div>
    </div>

    <!-- ВАРТІСТЬ -->
    <div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="title-price-wrapper position-relative">
            <label for="price" class="form-label">Вартість товару</label>
            <div class="input-group input-group-lg position-relative">
                <div id="price"
                     class="form-control title-price-input price-input {{ $priceRaw ? 'has-content' : '' }}"
                     contenteditable="true"
                     data-placeholder="Введіть вартість"
                     spellcheck="false">{{ $priceFormatted }}</div>
                <span class="currency-label">грн</span>
                <input type="hidden" name="price" id="price-hidden" value="{{ $priceRaw ? (int)$priceRaw : '' }}">
            </div>
        </div>
    </div>
@endif
