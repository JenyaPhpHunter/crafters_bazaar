@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Shopping Cart Section Start -->
<div class="section section-padding">
    <div class="container">
        @if(count($orders) > 0)
            <table class="order-table table">
            <thead>
            <tr>
                <th class="order" rowspan="2" style="text-align: center;">Номер замовлення</th>
                <th class="thumbnail" rowspan="2" style="text-align: center;">Товар</th>
                <th class="name" rowspan="2" style="text-align: center;">Назва товару</th>
                <th class="price" rowspan="2" style="text-align: left;">Вартість</th>
                <th class="quantity" rowspan="2" style="text-align: center;">Кількість</th>
                <th class="subtotal" rowspan="2" style="text-align: center;">Загалом</th>
                <th class="subtotal" rowspan="2" style="text-align: center;">Статус замовлення</th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                    @if($order->cart->cartitems->isNotEmpty())
                        @php
                            $cost_paid = 0;
                            $cartItems = $order->cart->cartitems;
                        @endphp
                        @foreach($cartItems as $cartItemIndex => $cartItem)
                            <tr>
                                @if($cartItemIndex === 0)
                                    <td class="order" rowspan="{{ count($cartItems) }}" style="text-align: center;">№ {{ $order->id }}</td>
                                @endif
                                @if(!empty($cartItem->product) && !empty($cartItem->product->productphotos) && count($cartItem->product->productphotos) > 0)
                                    <td class="thumbnail"><a href="{{ route('products.show', ['product' => $cartItem->product->id]) }}"><img src="{{ asset($cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="cart-product-1"></a></td>
                                @else
                                    <td></td>
                                @endif
                                <td class="name" style="text-align: center;">
                                    <a href="{{ route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->title }}</a>
                                </td>
                                <td class="price">{{ $cartItem->price }}</td>
                                <td class="quantity" style="text-align: center;">{{ $cartItem->quantity }}</td>
                                <td class="subtotal" style="text-align: center;">{{ $cartItem->price * $cartItem->quantity }}</td>
                                <td class="status-order" style="text-align: center;">{{ $order->status_order->name }}</td>
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
                    @endif
                @endforeach
            </tbody>
            </table>
        @else
            <H2 style="color: aqua"> У ВАС ЩЕ НЕМА ЗАМОВЛЕНЬ! </H2>
        @endif
    </div>

</div>
<!-- Shopping Cart Section End -->

@endsection
