@extends('layouts.app')

@section('content')
<div class="offcanvas-overlay"></div>

<!-- Page Title/Header Start -->
<div class="page-title-section section" data-bg-image="{{asset('images/bg/page-title-1.webp') }}">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-title">
                    <h1 class="title">Список замовлень</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Список замовлень</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Title/Header End -->

<!-- Shopping Cart Section Start -->
<div class="section section-padding">
    <div class="container">
        <table class="order-table table">
            <thead>
            <tr>
                <th class="order" rowspan="2">Номер замовлення</th>
                <th class="thumbnail" rowspan="2">Товар</th>
                <th class="name" rowspan="2">Назва товару</th>
                <th class="price" rowspan="2">Вартість</th>
                <th class="quantity" rowspan="2">Кількість</th>
                <th class="subtotal" rowspan="2">Загалом</th>
                <th class="subtotal" rowspan="2">Статус замовлення</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                @php
                    $cost_paid = 0;
                    $cartItems = $order->cart->cartitems;
                @endphp
                @foreach($cartItems as $cartItemIndex => $cartItem)
                    <tr>
                        @if($cartItemIndex === 0)
                            <td class="order" rowspan="{{ count($cartItems) }}"><span>№ {{ $order->id }}</span></td>
                        @endif
                        @if(!empty($cartItem->product) && !empty($cartItem->product->productphotos) && count($cartItem->product->productphotos) > 0)
                            <td class="thumbnail"><a href="product-details.html"><img src="{{ asset($cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="cart-product-1"></a></td>
                        @else
                            <td></td>
                        @endif
                        <td class="name">
                            <a href="{{ route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->name }}</a>
                        </td>
                        <td class="price"><span>{{ $cartItem->price }}</span></td>
                        <td class="quantity">
                            <div class="product-quantity">
                                <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                <input type="text" class="input-qty" value="{{ $cartItem->quantity }}">
                                <span class="qty-btn plus"><i class="ti-plus"></i></span>
                            </div>
                        </td>
                        <td class="subtotal"><span>{{ $cartItem->price * $cartItem->quantity }}</span></td>
                        <td class="status-order"><span>{{ $order->status_order->name }}</span></td>
                    </tr>
                    @php
                        $cost_paid += $cartItem->price * $cartItem->quantity;
                    @endphp
                @endforeach
                <tr class="order-divider">
                    <td colspan="6"></td>
                </tr>
                <tr class="order-total">
                    <td colspan="6"></td>
                    <td class="subtotal"><span class="bold-text">Загалом: {{ $cost_paid }}</span></td>
                    <td colspan="2"></td>
                </tr>
            @endforeach
            </tbody>
            </table>
    </div>

</div>
<!-- Shopping Cart Section End -->

@endsection
