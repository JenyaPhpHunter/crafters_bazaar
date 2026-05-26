@extends('layouts.app')

@section('title', $product->title . ' — ' . config('app.name'))

@section('content')
    <div class="product-show-page {{ auth()->id() === 1 ? 'is-admin' : '' }}">
        <div class="section section-fluid section-padding product-show-section">
            <div class="container">
                <div class="product-show-layout">

                    <div class="product-show-left">
                        <div class="product-show-card product-media-card">
                            @include('products.include.images', [
                                'images' => $images ?? [],
                                'mode'   => 'view'
                            ])
                        </div>

                        <div class="product-show-card product-view-actions">
                            <span class="product-block-label">Дії з товаром</span>

                            @if(auth()->check() && (auth()->id() === $product->creator_id || auth()->id() === 1))
                                @can('putUpForSale', $product)
                                    <a href="{{ route('products.edit', $product) }}" class="product-edit-action">
                                        <i class="fa-solid fa-pen"></i>
                                        Редагувати товар
                                    </a>
                                @endcan

                                @can('putUpForSale', $product)
                                    <a href="{{ route('products.putUpForSale', $product) }}"
                                       class="product-sale-action"
                                       onclick="return confirm('Виставити товар на продаж?')">
                                        <i class="fas fa-check-circle"></i>
                                        Виставити на продаж
                                    </a>
                                @endcan
                            @else
                                <div class="product-customer-actions">
                                    <button onclick="addToCart({{ $product->id }})" class="product-cart-action">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Додати в кошик
                                    </button>
                                    <button onclick="addToWishlist({{ $product->id }})" class="product-wishlist-action">
                                        <i class="fa-solid fa-heart"></i>
                                        В улюблені
                                    </button>
                                </div>
                            @endif

                            <button onclick="shareProduct()" class="product-share-action">
                                <i class="fa-solid fa-share-alt"></i>
                                Поширити товар
                            </button>
                        </div>
                    </div>

                    <div class="product-view-main product-show-card">
                        <div class="product-title-block">
                            <span class="product-block-label">Товар</span>
                            <h1 class="product-title">{{ $product->title }}</h1>
                        </div>

                        <div class="product-price-card">
                            <span class="product-block-label">Вартість</span>
                            <strong>{{ number_format($product->price, 0, ',', ' ') }} грн</strong>
                        </div>

                        <section class="product-info-section">
                            <div class="product-section-header">
                                <span class="product-block-label">Характеристики</span>
                            </div>

                            <div class="meta-grid">
                                @if($product->subKindProduct)
                                    <div class="meta-item">
                                        <span class="meta-label">Вид товару</span>
                                        <span class="meta-value">{{ $product->subKindProduct->kindProduct->title ?? '—' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label">Підвид товару</span>
                                        <span class="meta-value">{{ $product->subKindProduct->title ?? '—' }}</span>
                                    </div>
                                @endif

                                @if($product->stock_balance !== null)
                                    <div class="meta-item">
                                        <span class="meta-label">Кількість у наявності</span>
                                        <span class="meta-value">{{ $product->stock_balance }} шт.</span>
                                    </div>
                                @endif

                                @if($product->term_creation)
                                    <div class="meta-item">
                                        <span class="meta-label">Термін виготовлення</span>
                                        <span class="meta-value">{{ $product->term_creation }} днів</span>
                                    </div>
                                @endif

                                @if($product->brand)
                                    <div class="meta-item">
                                        <span class="meta-label">Бренд</span>
                                        <span class="meta-value">{{ $product->brand->title }}</span>
                                    </div>
                                @endif

                                <div class="meta-item meta-item-colors">
                                    <span class="meta-label">Кольори</span>
                                    @include('products.include.colors', ['mode' => 'view', 'showLabel' => false])
                                </div>
                            </div>
                        </section>

                        <section class="product-info-section">
                            <div class="product-section-header">
                                <span class="product-block-label">Опис товару</span>
                            </div>
                            <div class="description-text">
                                {!! $product->content ?? '<p class="text-muted text-center">Опис відсутній.</p>' !!}
                            </div>
                        </section>

                        @if($product->tags || $product->social_links)
                            <section class="product-info-section product-links-section">
                                @if($product->tags)
                                    <div class="meta-item product-tags-item">
                                        <span class="meta-label">Теги товару</span>
                                        <div class="product-tags">
                                            @foreach(explode(',', $product->tags) as $rawTag)
                                                @php $tag = trim($rawTag); @endphp
                                                @if($tag)
                                                    <a href="{{ route('products.tag', $tag) }}" class="tag">
                                                        #{{ $tag }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($product->social_links)
                                    <div class="meta-item product-social-item">
                                        <span class="meta-label">Посилання на соцмережі</span>
                                        <div class="product-social-links">
                                            @php
                                                $socialLinks = array_filter(array_map('trim', explode(',', $product->social_links)));
                                            @endphp
                                            @foreach($socialLinks as $link)
                                                @if($link)
                                                    <div class="social-link-item">
                                                        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
                                                            {{ $link }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('products.partials.photoswipe')

    <script>
        window.addToCart = function(id) { alert('Додано в кошик #' + id); };
        window.addToWishlist = function(id) { alert('Додано в улюблені #' + id); };
        window.shareProduct = function() {
            navigator.clipboard.writeText(location.href);
            alert('Посилання скопійовано!');
        };
    </script>
@endpush
