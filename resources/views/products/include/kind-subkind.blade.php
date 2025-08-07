{{-- Вид товару --}}
{{--<div class="form-group mb-4">--}}
{{--    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 30px; margin-bottom: 10px;">--}}
{{--        <div style="flex-grow: 1; min-width: 0;">--}}
{{--            <label for="kind_product_id" class="form-label">Вид товару</label>--}}
{{--            <select class="form-control search-select select2-basic" id="kind_product_id" name="kind_product_id" style="width: 100%;">--}}
{{--                @foreach($kindProducts as $kind_product)--}}
{{--                    <option value="{{ $kind_product->id }}" {{ old('kind_product_id', $selected_kind_product_id) == $kind_product->id ? 'selected' : '' }}>--}}
{{--                        {{ $kind_product->title }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}"--}}
{{--           class="btn btn-sm" style="--}}
{{--                white-space: nowrap;--}}
{{--                margin-left: 30px;--}}
{{--                height: fit-content;--}}
{{--                background-color: #72A499;--}}
{{--                color: white;--}}
{{--                border: none;--}}
{{--                padding: 0.25rem 0.75rem;--}}
{{--                font-size: 0.875rem;--}}
{{--                border-radius: 4px;">--}}
{{--            <i class="fas fa-plus-circle"></i> Додати вид--}}
{{--        </a>--}}
{{--    </div>--}}
{{--    @error('kind_product_id')--}}
{{--    <div class="alert alert-danger mt-2">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--</div>--}}

{{-- Підвид товару --}}
{{--<div class="form-group mb-4">--}}
{{--    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 30px; margin-bottom: 10px;">--}}
{{--        <div style="flex-grow: 1; min-width: 0;">--}}
{{--            <label for="sub_kind_product_id" class="form-label">Підвид товару</label>--}}
{{--            <select class="form-control search-select select2-basic" id="sub_kind_product_id" name="sub_kind_product_id" style="width: 100%;">--}}
{{--                @foreach($subKindProducts as $sub_kind_product)--}}
{{--                    <option value="{{ $sub_kind_product->id }}" {{ old('sub_kind_product_id', $selected_sub_kind_product_id) == $sub_kind_product->id ? 'selected' : '' }}>--}}
{{--                        {{ $sub_kind_product->title }}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}"--}}
{{--           class="btn btn-sm" style="--}}
{{--                white-space: nowrap;--}}
{{--                margin-left: 30px;--}}
{{--                height: fit-content;--}}
{{--                background-color: #72A499;--}}
{{--                color: white;--}}
{{--                border: none;--}}
{{--                padding: 0.25rem 0.75rem;--}}
{{--                font-size: 0.875rem;--}}
{{--                border-radius: 4px;">--}}
{{--            <i class="fas fa-plus-circle"></i> Додати підвид--}}
{{--        </a>--}}
{{--    </div>--}}
{{--    @error('sub_kind_product_id')--}}
{{--    <div class="alert alert-danger mt-2">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--</div>--}}
<div class="form-section">
    <label for="kind_product_id" class="form-label">Вид товару</label>
    <div class="d-flex gap-2">
        <select id="kind_product_id" name="kind_product_id" class="form-control">
            @foreach($kindProducts as $kind)
                <option value="{{ $kind->id }}" {{ old('kind_product_id') == $kind->id ? 'selected' : '' }}>
                    {{ $kind->title }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}"
           class="btn btn-outline-turquoise"><i class="fas fa-plus-circle"></i> Додати вид</a>
    </div>
</div>

<div class="form-section">
    <label for="sub_kind_product_id" class="form-label">Підвид товару</label>
    <div class="d-flex gap-2">
        <select id="sub_kind_product_id" name="sub_kind_product_id" class="form-control">
            @foreach($subKindProducts as $subkind)
                <option value="{{ $subkind->id }}" {{ old('sub_kind_product_id') == $subkind->id ? 'selected' : '' }}>
                    {{ $subkind->title }}
                </option>
            @endforeach
        </select>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}"
           class="btn btn-outline-turquoise"><i class="fas fa-plus-circle"></i> Додати підвид</a>
    </div>
</div>

