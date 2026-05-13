<div class="products-grid">

    <div id="shop-products" class="row gx-3 gy-4 row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">

        @forelse($products as $product)
            @php $photo = $product->productPhotos->first(); @endphp

            <div class="grid-item {{ $product->featured ? 'featured' : '' }} {{ $product->new ? 'new' : '' }} {{ $product->discount ? 'sale' : '' }}">
                <div class="product-card-modern h-100 position-relative">

                    {{-- Фото з бейджами всередині --}}
                    <div class="product-thumb">
                        <a href="{{ route('products.show', $product->id) }}" class="image d-block overflow-hidden position-relative">
                            <img
                                src="{{ $photo ? Storage::url($photo->paths['small'] ?? $photo->paths['original']) : asset('images/no-image.jpg') }}"
                                alt="{{ $product->title }}"
                                class="img-fluid w-100">

                            {{-- Бейджі поверх зображення --}}
                            @if($product->is_new || $product->featured || $product->discount || $product->stock_balance == 0)
                                <div class="product-badges">
                                    @if($product->is_new)
                                        <span class="badge-pill new">
                                            <i class="fal fa-star"></i> New
                                        </span>
                                    @endif
                                    @if($product->featured)
                                        <span class="badge-pill hot">
                                            <i class="fal fa-fire"></i> Hot
                                        </span>
                                    @endif
                                    @if($product->discount)
                                        <span class="badge-pill sale">
                                            <i class="fal fa-tag"></i> -{{ $product->discount }}%
                                        </span>
                                    @endif
                                    @if($product->stock_balance == 0)
                                        <span class="badge-pill outofstock">
                                            @if($product->term_creation > 0)
                                                <i class="fal fa-clock"></i> Виготовлення
                                                {{ $product->term_creation }}
                                                {{ $product->term_creation == 1 ? 'день' : ($product->term_creation < 5 ? 'дні' : 'днів') }}
                                            @else
                                                <i class="fal fa-times-circle"></i> Немає в наявності
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    </div>

                    {{-- Інфо --}}
                    <div class="product-info p-3">
                        <h6 class="title mb-1">
                            <a href="{{ route('products.show', $product->id) }}">{{ $product->title }}</a>
                        </h6>

                        <div class="price fw-bold mb-2">
                            @if($product->discount)
                                <span class="old text-muted text-decoration-line-through me-1">{{ $product->price }} грн</span>
                                <span class="new">{{ round($product->price * (1 - $product->discount / 100)) }} грн</span>
                            @else
                                {{ $product->price }} грн
                            @endif
                        </div>

                        {{-- Кнопки дій --}}
                        <div class="product-action-row">

                            <button class="product-action-btn js-quick-view"
                                    data-tooltip="Швидкий перегляд"
                                    data-product-id="{{ $product->id }}">
                                <i class="fal fa-eye"></i>
                            </button>

                            <a href="{{ route('carts.addToCart', ['product' => $product->id]) }}"
                               class="product-action-btn"
                               data-tooltip="Додати в корзину">
                                <i class="fal fa-shopping-cart"></i>
                            </a>

                            <button class="product-action-btn js-wishlist"
                                    data-tooltip="Додати до улюблених"
                                    data-product-id="{{ $product->id }}">
                                <i class="far fa-heart"></i>
                            </button>

                            <button class="product-action-btn js-share"
                                    data-tooltip="Поширити"
                                    data-url="{{ route('products.show', $product->id) }}"
                                    data-title="{{ $product->title }}">
                                <i class="fal fa-share-alt"></i>
                            </button>

                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Нічого не знайдено за вашими фільтрами</p>
            </div>
        @endforelse

    </div>

    {{-- Показати ще --}}
    @if($products->hasMorePages())
        <div class="text-center learts-mt-70" id="load-more-wrap">
            <button id="load-more-btn"
                    class="btn btn-dark btn-outline-hover-dark px-5 py-3"
                    data-next-page="{{ $products->currentPage() + 1 }}"
                    data-last-page="{{ $products->lastPage() }}">
                <i class="ti-plus me-2"></i> Показати ще
            </button>
        </div>
    @endif

    {{-- Пагінація --}}
    @if($products->hasPages())
        <div class="learts-mt-50">
            {{ $products->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif

</div>
