<div class="form-section product-form-submit-actions">
    @can('putUpForSale', $product)
        <a href="{{ route('products.putUpForSale', $product) }}"
           class="product-sale-action"
           onclick="return confirm('Виставити товар на продаж?')">
            <i class="fas fa-check-circle"></i> Виставити на продаж
        </a>
    @endcan
    @can('update', $product)
        <button type="submit" name="action" value="save" class="product-save-action">
            <i class="fas fa-save"></i> Зберегти
        </button>
    @endcan
</div>
