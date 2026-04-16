@php
    $mode = $mode ?? 'view';
@endphp

    <!-- Теги -->
<div class="form-field mb-5">
    <div class="tags-wrapper">
        <label class="form-label">Теги товару</label>

        @if($mode === 'view')
            <div class="product-tags">
                @if($product->tags)
                    @foreach(explode(',', $product->tags) as $tag)
                        @if(trim($tag))
                            <span class="tag">#{{ trim($tag) }}</span>
                        @endif
                    @endforeach
                @else
                    <span class="text-muted">Теги не вказані</span>
                @endif
            </div>
        @else
            {{-- Режим редагування --}}
            <input
                type="text"
                id="tags"
                name="tags"
                class="form-control tags-input"
                placeholder="Теги через кому..."
                value="{{ old('tags') ?? ($product?->tags ?? '') }}"
            />
            @error('tags')
            <div class="alert alert-danger mt-3 small">{{ $message }}</div>
            @enderror
        @endif
    </div>
</div>

<!-- Соцмережі -->
<div class="form-field mb-5">
    <div class="social-links-wrapper">
        <label class="form-label">Посилання на соцмережі</label>

        @if($mode === 'view')
            <div class="product-social-links">
                @if($product->social_links)
                    {!! nl2br(e($product->social_links)) !!}
                @else
                    <span class="text-muted">Посилання не вказані</span>
                @endif
            </div>
        @else
            <input
                type="text"
                id="social_links"
                name="social_links"
                class="form-control social-links-input"
                placeholder="https://instagram.com/..., https://tiktok.com/..."
                value="{{ old('social_links') ?? ($product?->social_links ?? '') }}"
            />
            @error('social_links')
            <div class="alert alert-danger mt-3 small">{{ $message }}</div>
            @enderror
        @endif
    </div>
</div>
