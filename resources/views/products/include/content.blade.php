@php
    $mode = $mode ?? 'view';
@endphp

<div class="form-field mb-5 content-block">

    <div class="form-block-header">
        <label class="form-label">Опис товару</label>
    </div>

    <div class="content-wrapper">
        @if($mode === 'view')
            <div class="product-description-content">
                {!! $product->content ?? '<p class="text-muted">Опис відсутній.</p>' !!}
            </div>
        @else
            {{-- Режим редагування --}}
            <textarea
                id="content"
                name="content_temp"
                rows="6"
                class="form-control content-textarea"
                placeholder="Опишіть стан товару, комплектацію, особливості..."
            >{{ old('content') ?? ($product?->content ?? '') }}</textarea>

            @error('content')
            <div class="alert alert-danger mt-3 small">{{ $message }}</div>
            @enderror
        @endif
    </div>
</div>
