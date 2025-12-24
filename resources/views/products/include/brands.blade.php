<div class="form-section animate__animated animate__fadeIn" id="brand-section">
    <label class="form-label">Оберіть бренд</label>

    <div class="brand-gallery-wrapper">

        <!-- ЛІВА СТРІЛКА -->
        <button type="button" class="brand-nav-btn brand-nav-left" id="brandPrev">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- ГАЛЕРЕЯ БРЕНДІВ -->
        <div class="brand-gallery-scroll" id="brandGallery">
            @forelse($brands as $brand)
                <div class="brand-square-card {{ old('brand_id') == $brand->id || (isset($product) && $product->brand_id == $brand->id) ? 'selected' : '' }}"
                     data-id="{{ $brand->id }}"
                     data-title="{{ $brand->title }}"
                     tabindex="0">
                    <div class="brand-square-image">
                        @if($brand->image_path && \Storage::exists($brand->image_path))
                            <img src="{{ asset(\Storage::url($brand->image_path)) }}" alt="{{ $brand->title }}">
                        @else
                            <div class="no-image-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </div>
                    <div class="brand-square-title">{{ $brand->title }}</div>
                    <div class="brand-check"><i class="fas fa-check"></i></div>
                </div>
            @empty
                <div class="brand-empty-gallery">
                    <i class="fas fa-store fa-3x opacity-20 mb-2"></i>
                    <p>Брендів ще немає</p>
                </div>
            @endforelse
        </div>

        <!-- ПРАВА СТРІЛКА — ПЕРЕД КНОПКОЮ -->
        <button type="button" class="brand-nav-btn brand-nav-right" id="brandNext">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- КНОПКА "ДОДАТИ БРЕНД" — ОСТАННЯ В РЕЧ У РЯДКУ -->
        <div class="brand-add-button-wrapper">
            <a href="{{ route('brands.create') }}" class="btn-add-brand">
                <i class="fas fa-plus"></i>
                <span>Додати бренд</span>
            </a>
        </div>

    </div>

    <input type="hidden" name="brand_id" id="selectedBrand"
           value="{{ old('brand_id') ?? (isset($product) ? $product->brand_id : '') }}">
</div>
