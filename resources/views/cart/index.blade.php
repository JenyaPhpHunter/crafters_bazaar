@extends('layouts.app')

@section('title', 'Кошик — ' . config('app.name'))

@section('content')
    @php
        $items = collect($cartItems);
        $subtotal = $items->sum(fn($cartItem) => ($cartItem->price ?? $cartItem->product?->final_price ?? 0) * ($cartItem->quantity ?? 1));
        $itemsCount = $items->sum(fn($cartItem) => $cartItem->quantity ?? 1);
    @endphp

    <div class="cart-page">
        <div class="section section-fluid cart-section">
            <div class="container">
                <div class="cart-heading-card">
                    <span class="cart-kicker">Ваш кошик</span>
                    <div class="cart-heading-row">
                        <h1>Кошик</h1>
                        <span class="cart-count">{{ $itemsCount }} {{ trans_choice('товар|товари|товарів', $itemsCount) }}</span>
                    </div>
                </div>

                @if(session('success'))
                    <div class="cart-alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($items->isEmpty())
                    <div class="cart-empty-card">
                        <span class="cart-empty-icon"><i class="fa-solid fa-basket-shopping"></i></span>
                        <h2>Кошик поки порожній</h2>
                        <p>Додайте товари, які сподобались, і вони зʼявляться тут для оформлення замовлення.</p>
                        <a href="{{ route('products.index') }}" class="cart-primary-action">
                            <i class="fa-solid fa-arrow-left"></i>
                            Перейти до покупок
                        </a>
                    </div>
                @else
                    <div class="cart-layout">
                        <div class="cart-items-card">
                            <div class="cart-card-header">
                                <span class="cart-kicker">Товари до замовлення</span>
                            </div>

                            <div class="cart-items-list">
                                @foreach($items as $cartItem)
                                    @php
                                        $product = $cartItem->product;
                                        $quantity = $cartItem->quantity ?? 1;
                                        $unitPrice = $cartItem->price ?? $product?->final_price ?? 0;
                                        $lineTotal = $unitPrice * $quantity;
                                        $photo = $product?->productPhotos?->first();
                                    @endphp

                                    @if($product)
                                        <article class="cart-item-row">
                                            <a href="{{ route('products.show', ['product' => $product->id]) }}" class="cart-item-photo">
                                                @if($photo)
                                                    <img src="{{ asset($photo->path . '/' . $photo->filename) }}" alt="{{ $product->title }}">
                                                @else
                                                    <span><i class="fa-regular fa-image"></i></span>
                                                @endif
                                            </a>

                                            <div class="cart-item-info">
                                                <a href="{{ route('products.show', ['product' => $product->id]) }}" class="cart-item-title">
                                                    {{ $product->title }}
                                                </a>

                                                <div class="cart-item-meta">
                                                    @if($product->brand)
                                                        <span>{{ $product->brand->title }}</span>
                                                    @endif
                                                    @if($product->subKindProduct)
                                                        <span>{{ $product->subKindProduct->title }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="cart-item-numbers">
                                                <div>
                                                    <span class="cart-item-label">Ціна</span>
                                                    <strong>{{ number_format($unitPrice, 0, ',', ' ') }} грн</strong>
                                                </div>
                                                <div>
                                                    <span class="cart-item-label">Кількість</span>
                                                    <strong>{{ $quantity }}</strong>
                                                </div>
                                                <div>
                                                    <span class="cart-item-label">Разом</span>
                                                    <strong>{{ number_format($lineTotal, 0, ',', ' ') }} грн</strong>
                                                </div>
                                            </div>

                                            <div class="cart-item-remove">
                                                @if(auth()->check())
                                                    <form action="{{ route('carts.remove_item') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="cart_item_id" value="{{ $cartItem->id }}">
                                                        <button type="submit" aria-label="Видалити {{ $product->title }}">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('carts.remove_item_guest', ['product' => $product->id]) }}" aria-label="Видалити {{ $product->title }}">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </article>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <aside class="cart-summary-card">
                            <div class="cart-card-header">
                                <span class="cart-kicker">Підсумок</span>
                            </div>

                            <div class="cart-summary-lines">
                                <div class="cart-summary-line">
                                    <span>Товарів</span>
                                    <strong>{{ $itemsCount }}</strong>
                                </div>
                                <div class="cart-summary-line">
                                    <span>Вартість</span>
                                    <strong>{{ number_format($subtotal, 0, ',', ' ') }} грн</strong>
                                </div>
                                <div class="cart-summary-total">
                                    <span>До оплати</span>
                                    <strong>{{ number_format($subtotal, 0, ',', ' ') }} грн</strong>
                                </div>
                            </div>

                            <div class="cart-actions">
                                <a href="{{ route('orders.create') }}" class="cart-primary-action">
                                    <i class="fa-solid fa-credit-card"></i>
                                    Оформити замовлення
                                </a>
                                <a href="{{ route('products.index') }}" class="cart-secondary-action">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Продовжити покупки
                                </a>

                                <form action="{{ route('carts.clearCart') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-clear-action">
                                        <i class="fa-regular fa-trash-can"></i>
                                        Очистити кошик
                                    </button>
                                </form>
                            </div>
                        </aside>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
