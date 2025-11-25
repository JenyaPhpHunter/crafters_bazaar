{{-- resources/views/products/include/colors.blade.php --}}
<div class="mb-5 animate__animated animate__fadeIn">
    <div class="text-center mb-4">
        <label class="form-label d-block">
            <strong>Колір (можна декілька)</strong>
            <i class="fas fa-info-circle ms-2"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Оберіть один або кілька кольорів. Клікніть ще раз — зніме вибір"></i>
        </label>
    </div>

    <input type="hidden" name="color_ids[]" value="">

    <div class="color-circles d-flex flex-wrap justify-content-center gap-4">
        @foreach($colors as $color)
            @php
                $selectedIds = (array) old('color_ids', []);
                if (isset($product) && $product->colors) {
                    $selectedIds = array_merge($selectedIds, $product->colors->pluck('id')->toArray());
                }
                $isSelected = in_array($color->id, array_unique($selectedIds));
            @endphp

            <div class="color-circle {{ $isSelected ? 'selected' : '' }}"
                 data-id="{{ $color->id }}"
                 style="background-color: {{ $color->code }}"
                 tabindex="0"
                 role="button"
                 aria-label="Колір {{ $color->name }}">
            </div>
        @endforeach
    </div>
</div>
{{--<div class="product-variations mb-4 animate__animated animate__fadeIn">--}}
{{--    <div class="d-flex align-items-center mb-2" style="gap: 0.25rem;">--}}
{{--        <label class="form-label">--}}
{{--            <strong>Колір (можна декілька)</strong>--}}
{{--        </label>--}}
{{--        <i class="fas fa-info-circle color-info-icon" data-bs-toggle="tooltip" data-bs-placement="right"--}}
{{--           title="Оберіть кольори цього товару"></i>--}}
{{--    </div>--}}

{{--    --}}{{-- Завжди є масив, навіть порожній --}}
{{--    <input type="hidden" name="color_ids[]" value="">--}}

{{--    <div class="color-circles d-flex flex-wrap gap-3">--}}
{{--        @foreach($colors as $color)--}}
{{--            --}}{{-- БЕЗПЕЧНА перевірка: працює і на create, і на edit --}}
{{--            @php--}}
{{--                $selectedIds = (array) old('color_ids');--}}
{{--                if (isset($product) && $product->colors) {--}}
{{--                    $selectedIds = array_merge($selectedIds, $product->colors->pluck('id')->toArray());--}}
{{--                }--}}
{{--                $isSelected = in_array($color->id, array_unique($selectedIds));--}}
{{--            @endphp--}}

{{--            <div class="color-circle {{ $isSelected ? 'selected' : '' }}"--}}
{{--                 data-id="{{ $color->id }}"--}}
{{--                 style="background-color: {{ $color->code }}"--}}
{{--                 tabindex="0"--}}
{{--                 role="button"--}}
{{--                 aria-label="Колір {{ $color->name }}">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}
