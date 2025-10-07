<div class="form-section animate__animated animate__fadeIn">
    <label for="stock_balance" class="form-label">Кількість виробів в наявності</label>
    <input type="number" id="stock_balance" name="stock_balance" class="form-control" value="{{ old('stock_balance') ?? 1 }}" min="1">
</div>

<div class="form-section d-flex align-items-center animate__animated animate__fadeIn">
    <input type="checkbox" id="can_produce" name="can_produce" {{ old('can_produce') ? 'checked' : '' }}>
    <label for="can_produce" class="form-label ms-2 mb-0">Можу виготовити цей товар ще</label>
</div>

<div class="form-section" id="term_creation_container" style="{{ old('can_produce') ? '' : 'display: none;' }} animate__animated animate__fadeIn">
    <label for="term_creation" class="form-label">Термін виготовлення (днів)</label>
    <input type="number" id="term_creation" name="term_creation" class="form-control" value="{{ old('term_creation') }}" min="1">
</div>

<script>
    document.getElementById('can_produce').addEventListener('change', function () {
        const termCreationContainer = document.getElementById('term_creation_container');
        if (this.checked) {
            termCreationContainer.style.display = 'block';
            termCreationContainer.classList.add('animate__fadeIn');
        } else {
            termCreationContainer.style.display = 'none';
            document.getElementById('term_creation').value = 0;
        }
    });
</script>
