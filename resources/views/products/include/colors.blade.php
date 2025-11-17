<div class="product-variations mb-4 animate__animated animate__fadeIn">
    <div class="d-flex align-items-center mb-2" style="gap: 0.25rem;">
        <label id="color-label" class="form-label">Колір (можна декілька)</label>
        <i class="fas fa-info-circle color-info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
           title="Оберіть кольори цього товару"></i>
    </div>

    <input type="hidden" name="color_ids[]" value=""> {{-- пустий, щоб завжди приходив масив --}}

    <div class="color-circles d-flex flex-wrap gap-3">
        @foreach($colors as $key => $color)
            <div class="color-circle
                @if(old('color_ids') && in_array($color->id, (array)old('color_ids'))) selected @endif"
                 data-id="{{ $color->id }}"
                 style="background-color: {{ $color->code }}"
                 aria-label="Колір {{ $color->name }}"
                 role="button"
                 tabindex="0">
            </div>
        @endforeach
    </div>
</div>

{{--<div class="product-variations mb-4 animate__animated animate__fadeIn">--}}
{{--    <!-- Контейнер для label та іконки -->--}}
{{--    <div class="d-flex align-items-center mb-2" style="gap: 0.25rem;">--}}
{{--        <!-- Label із класом form-label для уніфікації -->--}}
{{--        <label for="selectedColor" class="form-label">--}}
{{--            <strong>Колір</strong>--}}
{{--        </label>--}}
{{--        <!-- Іконка з бірюзовим кольором -->--}}
{{--        <i class="fas fa-info-circle color-info-icon" data-bs-toggle="tooltip" data-bs-placement="right" title="До якого кольору ближчий ваш товар?"></i>--}}
{{--    </div>--}}

{{--    <!-- Hidden input для одного кольору -->--}}
{{--    <input type="hidden" name="color_id" id="selectedColor" value="{{ old('color_id') }}">--}}

{{--    <!-- Контейнер для кружечків -->--}}
{{--    <div class="color-circles d-flex flex-wrap gap-2">--}}
{{--        @foreach($colors as $key => $color)--}}
{{--            <!-- Кружечок із inline background-color -->--}}
{{--            <div class="color-circle"--}}
{{--                 id="circle{{ $key + 1 }}"--}}
{{--                 data-name="Колір {{ $key + 1 }}"--}}
{{--                 data-color="{{ $color->code }}"--}}
{{--                 data-id="{{ $color->id }}"--}}
{{--                 data-selected="false"--}}
{{--                 style="background-color: {{ $color->code }}"--}}
{{--                 aria-label="Оберіть колір {{ $color->name }}"--}}
{{--                 role="button"--}}
{{--                 tabindex="0">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}
