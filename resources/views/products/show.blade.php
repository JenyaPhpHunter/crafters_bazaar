@extends('layouts.app')

@section('title', $product->title . ' — ' . config('app.name'))

@section('content')
    <body class="{{ auth()->id() === 2 ? 'is-admin' : '' }}">

    <div class="section section-fluid section-padding">
        <div class="container">
            <div class="row g-5">

                {{-- ЛІВА КОЛОНКА — ФОТО --}}
                <div class="col-lg-6 col-12">
                    @include('products.include.images', [
                        'images' => $images ?? [],
                        'mode'   => 'view'
                    ])
                    <!-- Кнопки -->
                    <div class="product-view-actions mt-5">
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <button onclick="addToCart({{ $product->id }})" class="btn btn-primary btn-lg flex-fill">
                                <i class="fa-solid fa-cart-plus"></i> Додати в кошик
                            </button>
                            <button onclick="addToWishlist({{ $product->id }})" class="btn btn-outline-danger btn-lg flex-fill">
                                <i class="fa-solid fa-heart"></i> В улюблені
                            </button>
                        </div>

                        <button onclick="shareProduct()" class="btn btn-outline-secondary w-100 mt-3">
                            <i class="fa-solid fa-share-alt"></i> Поширити товар
                        </button>

                        @if(auth()->check() && (auth()->id() === $product->user_id || auth()->id() === 2))
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning w-100 mt-3">
                                <i class="fa-solid fa-pen"></i> Редагувати товар
                            </a>
                        @endif
                    </div>
                </div>

                {{-- ПРАВА КОЛОНКА --}}
                <div class="col-lg-6 col-12">

                    <div class="product-view-main">

                        <!-- Назва -->
                        <div class="form-field text-center mb-3">
                            <label class="meta-label">Назва</label>
                            <h1 class="product-title">{{ $product->title }}</h1>
                        </div>

                        <!-- Вартість -->
                        <div class="form-field text-center mb-5">
                            <label class="meta-label">Вартість</label>
                            <div class="product-price">
                                <strong>{{ number_format($product->price, 0, ',', ' ') }} грн</strong>
                            </div>
                        </div>

                        <!-- Характеристики -->
                        <div class="form-field mb-4">
                            <div class="meta-row">
                                @if($product->subKindProduct)
                                    <div class="meta-item">
                                        <label class="meta-label">Вид товару</label>
                                        <span class="meta-value">{{ $product->subKindProduct->kindProduct->title ?? '—' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <label class="meta-label">Підвид товару</label>
                                        <span class="meta-value">{{ $product->subKindProduct->title ?? '—' }}</span>
                                    </div>
                                @endif

                                <!-- Кольори - лейбл тут -->
                                    <div class="meta-item">
                                        <label class="meta-label">Кольори</label>
                                        @include('products.include.colors', ['mode' => 'view', 'showLabel' => false])
                                    </div>
                            </div>
                        </div>

                        <!-- Кількість, Термін, Бренд -->
                        <div class="form-field mb-5">
                            <div class="meta-row">
                                @if($product->stock_balance !== null)
                                    <div class="meta-item">
                                        <label class="meta-label">Кількість у наявності</label>
                                        <span class="meta-value">{{ $product->stock_balance }} шт.</span>
                                    </div>
                                @endif

                                @if($product->term_creation)
                                    <div class="meta-item">
                                        <label class="meta-label">Термін виготовлення</label>
                                        <span class="meta-value">{{ $product->term_creation }} днів</span>
                                    </div>
                                @endif

                                @if($product->brand)
                                    <div class="meta-item">
                                        <label class="meta-label">Бренд</label>
                                        <span class="meta-value">{{ $product->brand->title }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Опис -->
                        <div class="form-field mb-5">
                            <label class="meta-label text-center d-block mb-3">Опис товару</label>
                            <div class="description-text">
                                {!! $product->content ?? '<p class="text-muted text-center">Опис відсутній.</p>' !!}
                            </div>
                        </div>

                        <!-- Теги + Соцмережі -->
                        <!-- Теги + Соцмережі -->
                        <div class="form-field">

                            @if($product->tags)
                                <div class="meta-item mb-4">
                                    <label class="meta-label">Теги товару</label>
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
                                <div class="meta-item">
                                    <label class="meta-label">Посилання на соцмережі</label>
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
                        </div>
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
