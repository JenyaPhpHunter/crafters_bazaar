{{--<div class="product-variations mb-4">--}}
{{--    --}}{{-- Заголовок з іконкою --}}
{{--    <div class="d-flex align-items-center mb-2" style="gap: 0.25rem;">--}}
{{--        <label for="selectedColor" class="form-label m-0">--}}
{{--            <strong>Колір</strong>--}}
{{--        </label>--}}
{{--        <i class="fas fa-info-circle"--}}
{{--           style="color: #72A499; font-size: 0.9rem; cursor: pointer;"--}}
{{--           data-bs-toggle="tooltip"--}}
{{--           data-bs-placement="right"--}}
{{--           title="До якого кольору ближчий ваш товар?"></i>--}}
{{--    </div>--}}

{{--    --}}{{-- Hidden input --}}
{{--    <input type="hidden" name="color_id" id="selectedColor" value="{{ old('color_id') }}">--}}

{{--    --}}{{-- Кольорові кружечки --}}
{{--    <div class="d-flex flex-wrap gap-2" style="margin-left: 0.5rem; margin-top: 0.5rem;">--}}
{{--        @foreach($colors as $key => $color)--}}
{{--            <div class="circle"--}}
{{--                 id="circle{{ $key + 1 }}"--}}
{{--                 data-name="Колір {{ $key + 1 }}"--}}
{{--                 data-color="{{ $color->code }}"--}}
{{--                 data-id="{{ $color->id }}"--}}
{{--                 onclick="selectColor(this)"--}}
{{--                 style="background-color: {{ $color->code }};--}}
{{--                        width: 26px;--}}
{{--                        height: 26px;--}}
{{--                        border-radius: 50%;--}}
{{--                        cursor: pointer;--}}
{{--                        border: 2px solid #72A499;">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}
<div class="form-section">
    <label class="form-label d-inline">
        Колір
        <i class="fas fa-info-circle tooltip-icon"
           data-bs-toggle="tooltip"
           title="До якого кольору ближчий ваш товар?"></i>
    </label>

    <input type="hidden" name="color_id" id="selectedColor" value="{{ old('color_id') }}">

    <div class="d-flex flex-wrap gap-2 mt-2">
        @foreach($colors as $color)
            <div class="color-circle {{ old('color_id') == $color->id ? 'selected' : '' }}"
                 data-color-id="{{ $color->id }}"
                 style="background-color: {{ $color->code }};"
                 onclick="selectColor(this)">
            </div>
        @endforeach
    </div>
</div>

<script>
    function selectColor(element) {
        document.querySelectorAll('.color-circle').forEach(c => c.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('selectedColor').value = element.dataset.colorId;
    }
</script>
