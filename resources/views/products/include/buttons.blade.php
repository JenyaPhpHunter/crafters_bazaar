<div class="form-section d-flex justify-content-between flex-wrap gap-2">
    @can('putUpForSale', $product)
        <a href="{{ route('products.putUpForSale', $product) }}"
           class="btn btn-turquoise"
           onclick="return confirm('Виставити товар на продаж?')">
            <i class="fas fa-check-circle"></i> Виставити на продаж
        </a>
    @endcan
    @can('update', $product)
        <button type="submit" name="action" value="save" class="btn btn-outline-turquoise">
            <i class="fas fa-save"></i> Зберегти
        </button>
    @endcan
</div>
