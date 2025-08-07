<div class="product-buttons">
    <button type="submit" name="action" value="put_up_for_sale" class="btn btn-dark btn-outline-hover-dark">
        {{ $action_types['put_up_for_sale'] ?? 'Виставити на продаж' }}
    </button>
    <button type="submit" name="action" value="save" class="btn btn-dark btn-outline-hover-dark">
        {{ $action_types['save'] ?? 'Зберегти як чернетку' }}
    </button>
</div>
