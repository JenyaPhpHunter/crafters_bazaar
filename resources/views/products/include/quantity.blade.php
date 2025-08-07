{{--<div class="quantity-container" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; width: 100%;">--}}
{{--    <label for="stock_balance" style="margin-bottom: 0; min-width: 200px; flex-grow: 1;">Кількість виробів в наявності</label>--}}
{{--    <div class="product-quantity" style="display: flex; align-items: center; justify-content: flex-end; flex-grow: 1;">--}}
{{--        <span class="qty-btn minus" style="cursor: pointer; padding: 0 10px;"><i class="ti-minus"></i></span>--}}
{{--        <input type="text" class="input-qty" name="stock_balance" id="stockBalance"--}}
{{--               value="{{ old('stock_balance', 1) }}" style="width: 60px; text-align: center; margin: 0 5px;">--}}
{{--        <span class="qty-btn plus" style="cursor: pointer; padding: 0 10px;"><i class="ti-plus"></i></span>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-section">
    <label for="stock_balance" class="form-label">Кількість виробів в наявності</label>
    <input type="number" id="stock_balance" name="stock_balance" class="form-control"
           value="{{ old('stock_balance') ?? 1 }}" min="1">
</div>
