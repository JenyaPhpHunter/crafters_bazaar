{{--<label class="custom-checkbox-label">--}}
{{--    <input type="checkbox" class="custom-checkbox" id="can_produce" name="can_produce" {{ old('can_produce') ? 'checked' : '' }}>--}}
{{--    <span>Можу виробити цей товар ще!</span>--}}
{{--</label>--}}

{{--<div id="termCreationWrapper" style="{{ old('can_produce') ? '' : 'display: none;' }}">--}}
{{--    <label for="term_creation" class="mt-3">Кількість днів для виготовлення і відправки</label>--}}
{{--    <div class="product-quantity">--}}
{{--        <span class="qty-btn minus"><i class="ti-minus"></i></span>--}}
{{--        <input type="text" class="input-qty" name="term_creation" value="{{ old('term_creation', 0) }}">--}}
{{--        <span class="qty-btn plus"><i class="ti-plus"></i></span>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-section d-flex align-items-center">
    <input type="checkbox" id="can_produce" name="can_produce" {{ old('can_produce') ? 'checked' : '' }}>
    <label for="can_produce" class="form-label ms-2 mb-0">Можу виготовити цей товар ще</label>
</div>

<div class="form-section" id="term_creation_container" style="{{ old('can_produce') ? '' : 'display: none;' }}">
    <label for="term_creation" class="form-label">Термін виготовлення (днів)</label>
    <input type="number" id="term_creation" name="term_creation" class="form-control"
           value="{{ old('term_creation') }}" min="1">
</div>

<script>
    document.getElementById('can_produce').addEventListener('change', function () {
        document.getElementById('term_creation_container').style.display = this.checked ? '' : 'none';
    });
</script>
