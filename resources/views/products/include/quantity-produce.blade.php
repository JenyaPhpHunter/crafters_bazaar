<div class="quantity-produce-container">
    <div class="quantity-field">
        <label for="stock_balance" class="form-label">Кількість у наявності</label>
        <div class="input-wrapper">
            <button type="button" class="qty-btn minus" aria-label="Зменшити">-</button>
            <input type="number" id="stock_balance" name="stock_balance" class="form-control qty-input" value="{{ old('stock_balance') ?? 1 }}" min="1" step="1">
            <button type="button" class="qty-btn plus" aria-label="Збільшити">+</button>
            <span class="input-unit">штук</span>
        </div>
    </div>

    <div class="checkbox-field">
        <div class="checkbox-wrapper">
            <input type="checkbox" id="can_produce" name="can_produce" {{ old('can_produce') ? 'checked' : '' }}>
            <label for="can_produce" class="checkbox-label">Можу виготовити ще</label>
        </div>
    </div>

    <div class="term-field" id="term_creation_container" style="{{ old('can_produce') ? '' : 'display: none;' }}">
        <label for="term_creation" class="form-label">Термін виготовлення</label>
        <div class="input-wrapper">
            <button type="button" class="qty-btn minus" aria-label="Зменшити">-</button>
            <input type="number" id="term_creation" name="term_creation" class="form-control qty-input" value="{{ old('term_creation') ?? 0 }}" min="0" step="1">
            <button type="button" class="qty-btn plus" aria-label="Збільшити">+</button>
            <span class="input-unit">днів</span>
        </div>
    </div>
</div>
