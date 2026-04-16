@php
    $mode = $mode ?? 'view';
    $showLabel = $showLabel ?? true;   // ← ключовий параметр
@endphp

<div class="mb-4 animate__animated animate__fadeIn color-block">
    @if($mode === 'view')
        <!-- РЕЖИМ ПЕРЕГЛЯДУ -->
        @if($product && $product->colors->isNotEmpty())

            @if($showLabel)
                <label class="meta-label">Кольори</label>
            @endif

            <div class="color-dots d-flex flex-wrap gap-2">
                @foreach($product->colors as $color)
                    <span class="color-dot"
                          style="background-color: {{ $color->code ?? '#999' }};
                                 width: 28px;
                                 height: 28px;
                                 border-radius: 50%;
                                 display: inline-block;
                                 border: 2px solid #fff;
                                 box-shadow: 0 0 3px rgba(0,0,0,0.2);"
                          title="{{ $color->title ?? '' }}">
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-muted small mb-0">Кольори не вказані</p>
        @endif

    @else
        <!-- РЕЖИМ РЕДАГУВАННЯ -->
        <div class="text-center mb-4">
            <label class="form-label d-block">
                <strong>Колір (можна декілька)</strong>
            </label>
        </div>

        <input type="hidden" name="color_ids[]" value="">

        <div class="color-circles d-flex flex-wrap justify-content-center gap-4">
            @foreach($colors ?? [] as $color)
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
                     aria-label="Колір {{ $color->title }}">
                </div>
            @endforeach
        </div>
    @endif
</div>
