{{-- resources/views/products/include/title-price.blade.php --}}

<!-- НАЗВА ТОВАРУ -->
<div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
    <div class="title-price-wrapper position-relative">
        <label for="title" class="form-label">
            Назва товару
        </label>

        <div class="input-group input-group-lg">
            <div
                id="title"
                class="form-control title-price-input"
                contenteditable="true"
                data-placeholder="Введіть назву товару"
                spellcheck="false"
            >{{ old('title') }}</div>
            <input type="hidden" name="title" id="title-hidden">
        </div>
    </div>
</div>

<!-- ВАРТІСТЬ -->
<div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
    <div class="title-price-wrapper position-relative">
        <label for="price" class="form-label">
            Вартість товару
        </label>

        <div class="input-group input-group-lg position-relative">
            <div
                id="price"
                class="form-control title-price-input price-input"
                contenteditable="true"
                data-placeholder="Введіть вартість"
                spellcheck="false"
            >
                {{ old('price') ? number_format((int)old('price'), 0, '', ' ') : '' }}
            </div>
            <span class="currency-label">грн</span>
            <input type="hidden" name="price" id="price-hidden" value="{{ old('price') ? (int)old('price') : '' }}">
        </div>
    </div>
</div>
