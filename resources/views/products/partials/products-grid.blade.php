<div class="products-grid">

    <div id="shop-products" class="row gx-3 gy-4 row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">

        @forelse($products as $product)
            @php $photo = $product->productphotos->first(); @endphp

            <div class="grid-item {{ $product->featured ? 'hot' : '' }} {{ $product->new ? 'new' : '' }} {{ $product->discount ? 'sale' : '' }}">
                <div class="product-card-modern h-100 position-relative">

                    {{-- Бейджі --}}
                    @if($product->new || $product->featured || $product->discount || $product->stock_balance == 0)
                        <div class="product-badges">
                            @if($product->new)       <span class="new">new</span>               @endif
                            @if($product->featured)  <span class="hot">hot</span>               @endif
                            @if($product->discount)  <span class="onsale">-{{ $product->discount }}%</span> @endif
                            @if($product->stock_balance == 0) <span class="outofstock"><i class="fal fa-frown"></i></span> @endif
                        </div>
                    @endif

                    {{-- Фото --}}
                    <div class="product-thumb">
                        <a href="{{ route('products.show', $product->id) }}" class="image d-block overflow-hidden">
                            <img
                                src="{{ $photo ? Storage::url($photo->paths['small'] ?? $photo->paths['original']) : asset('images/no-image.jpg') }}"
                                alt="{{ $product->title }}"
                                class="img-fluid w-100">
                        </a>
                        <a href="#" class="add-to-wishlist hintT-left" data-hint="Додати до улюблених" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </a>
                    </div>

                    {{-- Інфо --}}
                    <div class="product-info p-3">
                        <h6 class="title mb-2">
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

                        @if($product->term_creation)
                            <small class="text-muted d-block mb-2">
                                Виготовлення {{ $product->term_creation }}
                                {{ $product->term_creation == 1 ? 'день' : ($product->term_creation < 5 ? 'дні' : 'днів') }}
                            </small>
                        @endif

                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Швидкий перегляд" data-product-id="{{ $product->id }}">
                                <i class="fal fa-search"></i>
                            </a>
                            <a href="{{ route('carts.addToCart', ['product' => $product->id]) }}" class="product-button hintT-top" data-hint="Додати до кошика">
                                <i class="fal fa-shopping-cart"></i>
                            </a>
                            <a href="#" class="product-button hintT-top" data-hint="Поділитися">
                                <i class="fal fa-random"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Нічого не знайдено</p>
            </div>
        @endforelse

    </div>

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

</div>
