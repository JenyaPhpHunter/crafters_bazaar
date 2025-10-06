<div class="form-section">
    <div class="form-header">
        <label class="form-label">Бренди</label>
        <a href="{{ route('brands.create') }}" class="btn btn-add-brand">+ Додати бренд</a>
    </div>
    <div class="brand-carousel">
        @foreach($brands as $brand)
            <div class="brand-item" data-id="{{ $brand->id }}" data-title="{{ $brand->title }}">
                <div class="brand-content">
                    @if($brand->image_path)
                        <img src="{{ asset(Storage::url($brand->image_path)) }}" alt="Brand {{ $brand->title }}" class="brand-image">
                    @else
                        <div class="brand-no-image">БЕЗ ФОТО</div>
                    @endif
                </div>
                <div class="brand-title">{{ $brand->title ?? 'Без назви' }}</div>
            </div>
        @endforeach
    </div>
</div>
