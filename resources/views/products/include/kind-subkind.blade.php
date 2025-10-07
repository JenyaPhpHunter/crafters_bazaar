<div class="form-section animate__animated animate__fadeIn">
    <label for="kind_product_id" class="form-label">Вид товару</label>
    <div class="d-flex gap-2 align-items-center">
        <select id="kind_product_id" name="kind_product_id" class="form-control">
            @foreach($kindProducts as $kind)
                <option value="{{ $kind->id }}" {{ old('kind_product_id') == $kind->id ? 'selected' : '' }}>
                    {{ $kind->title }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-outline-turquoise animate__animated animate__pulse">
            <i class="fas fa-plus-circle"></i> Додати вид
        </a>
    </div>
</div>

<div class="form-section animate__animated animate__fadeIn">
    <label for="sub_kind_product_id" class="form-label">Підвид товару</label>
    <div class="d-flex gap-2 align-items-center">
        <select id="sub_kind_product_id" name="sub_kind_product_id" class="form-control">
            @foreach($subKindProducts as $subkind)
                <option value="{{ $subkind->id }}" {{ old('sub_kind_product_id') == $subkind->id ? 'selected' : '' }}>
                    {{ $subkind->title }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-outline-turquoise animate__animated animate__pulse">
            <i class="fas fa-plus-circle"></i> Додати підвид
        </a>
    </div>
</div>
