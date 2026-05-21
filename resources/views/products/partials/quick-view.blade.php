@php
    $discount = $product->discount;
    $finalPrice = $product->final_price;
    $description = trim(strip_tags($product->content ?? ''));
@endphp

<div class="quick-view-product">
    <div class="quick-view-media">
        <img src="{{ $photoUrl }}" alt="{{ $product->title }}" class="quick-view-image">

        @if($discount)
            <span class="quick-view-badge">
                <i class="fal fa-tag"></i>
                -{{ $discount }}%
            </span>
        @endif
    </div>

    <div class="quick-view-details">
        @if($product->brand)
            <span class="quick-view-kicker">{{ $product->brand->title }}</span>
        @else
            <span class="quick-view-kicker">Швидкий перегляд</span>
        @endif

        <h2 id="quickViewModalLabel" class="quick-view-title">{{ $product->title }}</h2>

        <div class="quick-view-price">
            @if($discount)
                <span class="quick-view-old-price">{{ number_format($product->price, 0, ',', ' ') }} грн</span>
                <span class="quick-view-new-price">{{ number_format($finalPrice, 0, ',', ' ') }} грн</span>
            @else
                <span class="quick-view-new-price">{{ number_format($product->price, 0, ',', ' ') }} грн</span>
            @endif
        </div>

        <p class="quick-view-description">
            {{ $description !== '' ? \Illuminate\Support\Str::limit($description, 220) : 'Опис товару поки не додано.' }}
        </p>

        <div class="quick-view-meta">
            <div>
                <span class="quick-view-meta-label">Наявність</span>
                <strong>
                    @if($product->stock_balance > 0)
                        {{ $product->stock_balance }} шт.
                    @elseif($product->term_creation > 0)
                        Виготовлення {{ $product->term_creation }} дн.
                    @else
                        Немає в наявності
                    @endif
                </strong>
            </div>

            @if($product->subKindProduct)
                <div>
                    <span class="quick-view-meta-label">Категорія</span>
                    <strong>{{ $product->subKindProduct->title }}</strong>
                </div>
            @endif
        </div>

        <div class="quick-view-colors">
            <span class="quick-view-section-label">Кольори</span>
            @if($product->colors->isNotEmpty())
                <div class="quick-view-color-list">
                    @foreach($product->colors as $color)
                        <span class="quick-view-color"
                              style="background-color: {{ $color->code ?? '#999' }};"
                              title="{{ $color->title }}"
                              aria-label="{{ $color->title }}"></span>
                    @endforeach
                </div>
            @else
                <span class="quick-view-muted">Кольори не вказані</span>
            @endif
        </div>

        <div class="quick-view-actions">
            <a href="{{ route('carts.addToCart', ['product' => $product->id]) }}" class="btn quick-view-cart-btn">
                <i class="fal fa-shopping-cart"></i>
                Додати в кошик
            </a>
            <a href="{{ route('products.show', $product->id) }}" class="btn quick-view-product-btn">
                Перейти до товару
                <i class="fal fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
