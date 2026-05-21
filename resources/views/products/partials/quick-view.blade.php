@php
    $discount = $product->discount;
    $finalPrice = $product->final_price;
    $description = trim(strip_tags($product->content ?? ''));
    $tags = array_values(array_filter(array_map('trim', explode(',', (string) $product->tags))));
    $socialLinks = array_values(array_filter(array_map('trim', explode(',', (string) $product->social_links))));
@endphp

<div class="quick-view-product">
    <div class="quick-view-header">
        <span class="quick-view-kicker">Швидкий перегляд</span>
        <h2 id="quickViewModalLabel" class="quick-view-title">{{ $product->title }}</h2>
    </div>

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

        <div class="quick-view-info-panel">
            <div class="quick-view-meta">
                @if($product->subKindProduct)
                    <div>
                        <span class="quick-view-meta-label">Вид товару</span>
                        <strong>{{ $product->subKindProduct->kindProduct->title ?? '—' }}</strong>
                    </div>
                    <div>
                        <span class="quick-view-meta-label">Підвид товару</span>
                        <strong>{{ $product->subKindProduct->title ?? '—' }}</strong>
                    </div>
                @endif

                @if($product->stock_balance !== null)
                    <div>
                        <span class="quick-view-meta-label">Кількість у наявності</span>
                        <strong>{{ $product->stock_balance }} шт.</strong>
                    </div>
                @endif

                @if($product->term_creation)
                    <div>
                        <span class="quick-view-meta-label">Термін виготовлення</span>
                        <strong>{{ $product->term_creation }} днів</strong>
                    </div>
                @endif

                @if($product->brand)
                    <div>
                        <span class="quick-view-meta-label">Бренд</span>
                        <strong>{{ $product->brand->title }}</strong>
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

            @if(count($tags))
                <div class="quick-view-tags-wrap">
                    <span class="quick-view-section-label">Теги товару</span>
                    <div class="quick-view-tags">
                        @foreach($tags as $tag)
                            <a href="{{ route('products.tag', $tag) }}" class="quick-view-tag">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($socialLinks))
                <div class="quick-view-social-wrap">
                    <span class="quick-view-section-label">Посилання на соцмережі</span>
                    <div class="quick-view-social-links">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="quick-view-social-link">
                                <i class="fal fa-external-link"></i>
                                {{ \Illuminate\Support\Str::limit($link, 42) }}
                            </a>
                        @endforeach
                    </div>
                </div>
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
