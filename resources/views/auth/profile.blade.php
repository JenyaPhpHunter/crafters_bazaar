@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <a href="{{route('home')}}">Повернутися на головну сторінку</a>
    <br>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form method="post" action="{{ route('profile.update', ['user' => $user->id]) }}">
        @csrf
        @method('put')
        <h1>Профіль користувача</h1>
        {{--        <!-- Пошукове вікно -->--}}
        {{--        <form action="{{ route('search') }}" method="GET">--}}
        {{--            <input type="text" name="query" placeholder="Пошук товару за назвою">--}}
        {{--            <button type="submit">Знайти</button>--}}
        {{--        </form>--}}
        <label for="role-id">Роль</label>
        <br>
        <input id="role" name="role" value="{{ $user->role->name ?? '' }}" autofocus readonly>
        <br><br>

        <label for="surname">Прізвище</label>
        <br>
        <input id="surname" name="surname" value="{{ $user->surname ?? '' }}">
        <br><br>

        <label for="name">Ім'я</label>
        <br>
        <input id="name" name="name" value="{{ $user->name ?? '' }}">
        <br><br>

        <label for="secondname">По батькові</label>
        <br>
        <input id="secondname" name="secondname" value="{{ $user->secondname ?? '' }}">
        <br><br>

        <label for="phone">Телефон</label>
        <br>
        <input id="phone" name="phone" type="tel" pattern="[0-9]+" value="{{ $user->phone ?? '' }}" required>
        <br><br>

        <label for="email">Email</label>
        <br>
        <input id="email" name="email" value="{{ $user->email }}" autofocus readonly>
        <br><br>

        <label for="password">Новий пароль</label>
        <br>
        <input id="password" name="password">
        <br><br>

        <label for="delivery_id">Спосіб доставки</label>
        <br>
        <select id="delivery_id" name="delivery_id">
            @foreach($deliveries as $delivery)
                @if(!empty($user->delivery_id))
                    <option value="{{ $delivery->id }}" {{ $user->delivery_id == $delivery->id ? 'selected' : '' }}>
                        {{ $user->delivery_id == $delivery->id ? $user->delivery->name : $delivery->name }}
                    </option>
                @else
                    <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
                @endif
            @endforeach
        </select>
        <br><br>

        <label for="city">Місто</label>
        <br>
        <input id="city" name="city" value="{{ $user->city ?? '' }}">
        <br><br>

        <label for="address">Адреса</label>
        <br>
        <input id="address" name="address" value="{{ $user->address ?? '' }}">
        <br><br>

        <label for="paymentkind_id">Спосіб оплати</label>
        <br>
        <select id="paymentkind_id" name="paymentkind_id">
            @foreach($payment_kinds as $payment_kind)
                @if(!empty($user->paymentkind_id))
                    <option value="{{ $payment_kind->id }}" {{ $user->paymentkind_id == $payment_kind->id ? 'selected' : '' }}>
                        {{ $user->paymentkind_id == $payment_kind->id ? $user->paymentKind->name : $payment_kind->name }}
                    </option>
                @else
                    <option value="{{ $payment_kind->id }}">{{ $payment_kind->name }}</option>
                @endif
            @endforeach
        </select>
        <br><br>
        <input type="submit" value="Зберегти">
    </form>
    <div class="container">
        @php
            $order = 0;
        @endphp
        <ul>
            @if($sum_baskets_without_order)
                <h1>Замовлення в корзині: </h1>
                <h2>Загальна вартість замовленнь в корзині: {{ $sum_baskets_without_order }}</h2>
                @foreach($baskets_without_order as $basket_without_order)
                    <h2><a href="{{route('products.show', ['product' => $basket_without_order->product_id])}}">{{$basket_without_order->product->name}}</a></h2>
                    <p>Категорія: {{ $basket_without_order->product->kind_product->name }}</p>
                    <p>Кількість: {{ $basket_without_order->quantity }}</p>
                    <p>Вартість: {{ $basket_without_order->sum }}
                        @if($basket_without_order->sum != $basket_without_order->total)
                            замість {{ $basket_without_order->total }}
                            Ваша знижка = {{ $basket_without_order->discount }}
                        @endif
                    </p>
                    <div class="product-image">
                        <img src="{{ asset($basket_without_order->product->image_path) }}" alt="Фото сумки">
                    </div>
                    <a href="{{ route('home') }}">Вибрати ще товари</a>
                    <br><br><br>
                @endforeach
                <form method="GET" action="{{ route('orders.create') }}">
                    <button class="order-btn">Оформити замовлення</button>
                </form>
                <hr>
            @endif
            @foreach($baskets as $basket)
                <div class="basket">
                    @if($order != $basket->order_id)
                        <hr>
                        <h1>Замовлення № {{ $basket->order_id }}</h1>
                        <h2>Загальна вартість замовлення: {{ $basket->order->total }}</h2>
                    @endif
                        @php
                            $order = $basket->order_id;
                        @endphp
                    <h2><a href="{{route('products.show', ['product' => $basket->product_id])}}">{{$basket->product->name}}</a></h2>
                    <p>Категорія: {{ $basket->product->kind_product->name }}</p>
                    <p>Кількість: {{ $basket->quantity }}</p>
                    <p>Вартість: {{ $basket->sum }}
                        @if($basket->sum != $basket->total)
                            замість {{ $basket->total }}
                            Ваша знижка = {{ $basket->discount }}
                        @endif
                    </p>
                    <div class="product-image">
                        <img src="{{ asset($basket->product->image_path) }}" alt="Фото сумки">
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
@endsection

