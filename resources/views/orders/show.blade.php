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
                <table class="cart-wishlist-table table">
                    <thead>
                    <h1>Номер замовлення № {{ $order->id }} </h1>
                    <tr>
                        <th>#</th>
                        <th class="name" colspan="2">Товар</th>
                        <th class="price">Вартість</th>
                        <th class="quantity">Кількість</th>
                        <th class="subtotal">Загалом</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $cost_paid = 0;
                    @endphp
                    @foreach($cartItems as $cartItem)
                        @php
                            $cost_paid += $cartItem->price*$cartItem->quantity;
                            $counter = 1;
                        @endphp
                        <tr>
                            <td> {{ $counter }} </td>
                            @if(!empty($cartItem->product) && !empty($cartItem->product->productphotos) && count($cartItem->product->productphotos) > 0)
                                <td class="thumbnail"><a href="product-details.html"><img src="{{asset( $cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="cart-product-1"></a></td>
                            @else
                                <td></td>
                            @endif
                            <td class="name"> <a href="{{route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->name }}</a></td>
                            <td class="price"><span>{{ $cartItem->price }}</span></td>
                            <td class="quantity"> {{ $cartItem->quantity }} </td>
                            <td class="subtotal"><span>{{ $cartItem->price * $cartItem->quantity }}</span></td>
{{--                            <td class="remove"><a href="{{ route('carts.remove_item',['cart_item' => $cartItem->id]) }}" class="btn">×</a></td>--}}
                        </tr>
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
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
            </div>
        </div>

    </div>
    <!-- Shopping Cart Section End -->

@endsection
