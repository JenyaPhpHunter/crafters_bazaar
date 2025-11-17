<div class="form-group-title-price">
    <label for="title" class="form-label">
        <span class="animate__animated animate__fadeIn">Назва товару</span>
    </label>
    <div class="input-group input-group-lg">
        <div
            id="title"
            class="form-control form-control-wide-center"
            contenteditable="true"
            data-placeholder="Введіть назву товару"
            spellcheck="false"
        >{{ old('title') }}</div>
        <input type="hidden" name="title" id="title-hidden">
    </div>
</div>

<div class="form-group-title-price mt-5">
    <label for="price" class="form-label">
        <span class="animate__animated animate__fadeIn">Вартість</span>
    </label>
    <div class="input-group input-group-lg position-relative">
        <div
            id="price"
            class="form-control form-control-wide-center price-input"
            contenteditable="true"
            data-placeholder="Введіть вартість товару"
            spellcheck="false"
            data-only-numbers="true"
        >{{ old('price') ? (int)old('price') : '' }}</div>
    <span class="currency-label">грн</span>
    <input type="hidden" name="price" id="price-hidden" value="{{ old('price') ? (int)old('price') : '' }}">
</div>
</div>
