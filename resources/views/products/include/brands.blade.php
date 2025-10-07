<div class="form-section animate__animated animate__fadeIn">
    <div class="form-header">
        <label class="form-label">Бренди</label>
        <a href="{{ route('brands.create') }}" class="btn btn-outline-turquoise animate__animated animate__pulse">+ Додати бренд</a>
    </div>
    <div class="brand-carousel d-flex gap-3 flex-wrap">
        @foreach($brands as $brand)
            <div class="brand-item animate__animated animate__fadeIn" data-id="{{ $brand->id }}" data-title="{{ $brand->title }}">
                <div class="brand-content">
                    @if($brand->image_path)
                        <img src="{{ asset(Storage::url($brand->image_path)) }}" alt="Brand {{ $brand->title }}" class="brand-image" style="max-width: 100px;">
                    @else
                        <div class="brand-no-image">БЕЗ ФОТО</div>
                    @endif
                </div>
                <div class="brand-title">{{ $brand->title ?? 'Без назви' }}</div>
            </div>
        @endforeach
    </div>
</div>
