@extends('layouts.app')

@section('content')
<!-- Shopping Cart Section Start -->
<div class="section section-padding">
    <div class="container">
        <form class="cart-form" action="{{ route('carts.clearСart') }}" method="POST">
            @csrf
            @method('DELETE')
            <table class="cart-wishlist-table table">
                <thead>
                <tr>
                    <th class="name" colspan="2" style="text-align: center;">Товар</th>
                    <th class="price">Назва</th>
                    <th class="price">Вартість</th>
                    <th class="quantity">Кількість</th>
                    <th class="subtotal">Загалом</th>
                    <th class="remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $cost_paid = 0;
                @endphp
                    @foreach($cartItems as $cartItem)
                        @php
                            $cost_paid += $cartItem->price*$cartItem->quantity;
                        @endphp
                        <tr>
                            @if(!empty($cartItem->product) && !empty($cartItem->product->productphotos) && count($cartItem->product->productphotos) > 0)
                                <td class="thumbnail"><a href="{{ route('products.show',['product' => $cartItem->product->id]) }}"><img src="{{asset( $cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="cart-product-1"></a></td>
                                <td></td>
                            @else
                                <td></td><td></td>
                            @endif
                            <td class="name"> <a href="{{route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->title }}</a></td>
                            <td class="price"><span>{{ $cartItem->price }}</span></td>
                            <td class="quantity">
                                <div class="product-quantity">
                                    <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                    <input type="text" class="input-qty" value={{ $cartItem->quantity }}>
                                    <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                </div>
                            </td>
                            <td class="subtotal"><span>{{ $cartItem->price * $cartItem->quantity }}грн</span></td>
                            <td class="remove">
                                @if (auth()->check())
                                    <!-- Видалення для авторизованого користувача -->
                                    <a href="{{ route('carts.remove_item',['cart_item' => $cartItem->id]) }}" class="btn">×</a>
                                @else
                                    <!-- Видалення для неавторизованого користувача (видаляємо за productId) -->
                                    <a href="{{ route('carts.remove_item_guest', ['product_id' => $cartItem->product->id]) }}" class="btn">×</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-between mb-n3">
                <div class="col-auto mb-3">
                    <div class="cart-coupon">
                        <input type="text" placeholder="Введіть код знижки">
                        <button class="btn"><i class="fal fa-gift"></i></button>
                    </div>
                </div>
                <div class="col-auto">
                    <a class="btn btn-light btn-hover-dark mr-3 mb-3" href="{{ route('products.index') }}">Продовжити покупки</a>
                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Очистити корзину</button>
                </div>
            </div>
        </form>
        <div class="cart-totals mt-5">
            <h2 class="title">Загальна вартість</h2>
            <table>
                <tbody>
                <tr class="subtotal">
                    <th>Вартість без знижки</th>
                    <td><span class="amount">{{ $cost_paid }}грн</span></td>
                </tr>
                <tr class="total">
                    <th>Вартість до оплати</th>
                    <td><strong><span class="amount">{{ $cost_paid }}грн</span></strong></td>
                </tr>
                </tbody>
            </table>
            <a href="{{ route('orders.create') }}" class="btn btn-dark btn-outline-hover-dark">Перейти до оформлення замовлення</a>
        </div>
    </div>

</div>
<!-- Shopping Cart Section End -->

@endsection
