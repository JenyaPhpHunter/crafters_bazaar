<div class="products-grid">

    <div id="shop-products" class="row gx-3 gy-4">

        @forelse($products as $product)
            @php $photo = $product->productphotos->first(); @endphp

            <div class="grid-item col-6 col-md-4 col-lg-3">
                <div class="product-card-modern h-100">
                    <div class="product-thumb">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img
                                src="{{ $photo
                                    ? Storage::url($photo->paths['small'] ?? $photo->paths['original'])
                                    : asset('images/no-image.jpg') }}"
                                alt="{{ $product->title }}"
                                class="img-fluid w-100">
                        </a>
                    </div>

                    <div class="product-info p-3">
                        <h6 class="title mb-2">
                            <a href="{{ route('products.show', $product->id) }}">{{ $product->title }}</a>
                        </h6>
                        <span class="price fw-bold">{{ $product->price }} грн</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4>Нічого не знайдено</h4>
            </div>
        @endforelse

    </div>

    <div class="text-center mt-5 pt-4">
        <a href="#" onclick="loadMoreProducts()" class="btn btn-dark btn-outline-hover-dark px-5 py-3">
            <i class="ti-plus me-2"></i> Показати ще
        </a>
    </div>

</div>
