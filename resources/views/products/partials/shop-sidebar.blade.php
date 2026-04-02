<!-- ПРАВИЙ САЙДБАР: Фільтри + Рекомендовані -->
<div class="col-lg-3 col-12 learts-mb-50">
    <form id="filterForm">
        <input type="hidden" name="sort_by" id="sortInput">
        <input type="hidden" name="per_page" id="perPageInput" value="24">

        <div class="single-widget mb-5">
            <h3 class="widget-title product-filter-widget-title">Фільтри</h3>

            <!-- Категорії -->
            <div class="mb-4">
                <h4 class="product-filter-widget-title">Категорії</h4>
                <div class="product-filter-widget">
                    @foreach($kind_products as $kind_product)
                        @if($kind_product->product_count > 0)
                            <label class="filter-item">
                                <input type="checkbox" name="categories[]" value="{{ $kind_product->id }}">
                                <span>{{ $kind_product->title }}</span>
                                <span class="count">{{ $kind_product->product_count }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Ціна -->
            <div class="mb-4">
                <h4 class="product-filter-widget-title">Ціна</h4>
                <div class="product-filter-widget">
                    <label class="filter-item">
                        <input type="checkbox" name="filter_price[]" value="0;100"> 0 – 100 грн
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="filter_price[]" value="100;500"> 100 – 500 грн
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="filter_price[]" value="500;+"> 500+ грн
                    </label>
                </div>
            </div>

            <button type="button" class="btn-filter-apply w-100" onclick="applyFilters()">
                Показати результати
            </button>
        </div>
    </form>

    <!-- Рекомендовані товари -->
    <div class="single-widget">
        <h3 class="widget-title product-filter-widget-title">Рекомендовані товари</h3>

        @foreach($featured_products as $feat)
            @php $photo = $feat->productphotos->first(); @endphp
            <div class="featured-item d-flex mb-4">
                <a href="{{ route('products.show', $feat->id) }}" class="me-3 flex-shrink-0">
                    <img src="{{ $photo
                        ? Storage::url($photo->paths['small'] ?? $photo->paths['original'])
                        : asset('images/no-image.jpg') }}"
                         alt="{{ $feat->title }}"
                         class="img-fluid rounded"
                         style="width: 85px; height: 85px; object-fit: cover;">
                </a>
                <div class="flex-grow-1">
                    <a href="{{ route('products.show', $feat->id) }}" class="featured-title d-block">
                        {{ Str::limit($feat->title, 55) }}
                    </a>
                    <div class="price text-primary fw-bold mt-1">
                        {{ $feat->price }} грн
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
