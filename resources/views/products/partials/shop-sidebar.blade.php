<!-- ПРАВИЙ САЙДБАР -->
<div class="col-lg-3 col-12 learts-mb-50">
    <form id="filterForm" action="{{ route('products.index') }}" method="GET">

        <input type="hidden" name="sort_by"  id="sortInput"   value="{{ request('sort_by') }}">
        <input type="hidden" name="per_page" id="perPageInput" value="{{ $current_per_page ?? 12 }}">
        <input type="hidden" name="cols"     id="colsInput"   value="{{ request('cols', 4) }}">

        <!-- Категорії -->
        <div class="single-widget mb-4">
            <h3 class="widget-title product-filter-widget-title">Категорії</h3>
            <ul class="widget-list">
                @forelse($kind_products as $kind_product)
                    @if($kind_product->product_count > 0)
                        <li>
                            <label class="d-flex align-items-center gap-2 py-1 cursor-pointer">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $kind_product->id }}"
                                    {{ in_array($kind_product->id, (array) request('categories')) ? 'checked' : '' }}>
                                <span class="flex-grow-1">{{ $kind_product->title }}</span>
                                <span class="count">{{ $kind_product->product_count }}</span>
                            </label>
                        </li>
                    @endif
                @empty
                    <li class="text-muted small">Категорії не знайдено</li>
                @endforelse
            </ul>
        </div>

        {{-- Ціна --}}
        <div class="single-widget mb-4">
            <h3 class="widget-title product-filter-widget-title">Ціна</h3>
            <ul class="widget-list">
                @php
                    $priceRanges = [
                        '0;100'    => '0 – 100 грн',
                        '100;500'  => '100 – 500 грн',
                        '500;1000' => '500 – 1 000 грн',
                        '1000;+'   => '1 000+ грн',
                    ];
                    $activePrices = (array) request('filter_price', []);
                @endphp
                @foreach($priceRanges as $value => $label)
                    <li>
                        <label class="d-flex align-items-center gap-2 py-1 cursor-pointer">
                            <input type="checkbox"
                                   name="filter_price[]"
                                   value="{{ $value }}"
                                {{ in_array($value, $activePrices) ? 'checked' : '' }}>
                            <span class="flex-grow-1">{{ $label }}</span>
                            @if(isset($price_counts[$value]) && $price_counts[$value] > 0)
                                <span class="count">({{ $price_counts[$value] }})</span>
                            @endif
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Кольори --}}
        <div class="single-widget mb-4">
            <h3 class="widget-title product-filter-widget-title">Колір</h3>
            <ul class="widget-colors d-flex flex-wrap gap-2 p-0 list-unstyled">
                @php $activeColors = (array) request('filter_color', []); @endphp
                @foreach($colors as $color)
                    <li>
                        <label class="color-circle-wrap hintT-top" data-hint="{{ $color->name }}">
                            <input type="checkbox"
                                   name="filter_color[]"
                                   value="{{ $color->php_name }}"
                                   class="d-none color-checkbox"
                                {{ in_array($color->php_name, $activeColors) ? 'checked' : '' }}>
                            <span class="color-circle {{ in_array($color->php_name, $activeColors) ? 'selected' : '' }}"
                                  style="background-color: {{ $color->code }};"></span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>

        <button type="submit" class="btn-filter-apply w-100 mb-2">
            Показати результати
        </button>
        <a href="{{ route('products.index') }}" class="btn-filter-reset w-100 d-block text-center">
            Скинути фільтри
        </a>

    </form>

    {{-- Рекомендовані товари --}}
    @if($featured_products->count())
        <div class="single-widget mt-4">
            <h3 class="widget-title product-filter-widget-title">Рекомендовані товари</h3>
            @foreach($featured_products as $feat)
                @php $fPhoto = $feat->productPhotos->first(); @endphp
                <div class="featured-item d-flex mb-3 gap-3">
                    <a href="{{ route('products.show', $feat->id) }}" class="flex-shrink-0">
                        <img src="{{ $fPhoto
                                ? Storage::url($fPhoto->paths['small'] ?? $fPhoto->paths['original'])
                                : asset('images/no-image.jpg') }}"
                             alt="{{ $feat->title }}"
                             class="rounded"
                             style="width:75px;height:75px;object-fit:cover;">
                    </a>
                    <div class="flex-grow-1 overflow-hidden">
                        <a href="{{ route('products.show', $feat->id) }}" class="featured-title d-block text-truncate">
                            {{ $feat->title }}
                        </a>
                        <span class="price fw-bold mt-1 d-block">{{ $feat->price }} грн</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
