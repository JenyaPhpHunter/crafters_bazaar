@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
    {{--    @php--}}
{{--        $user = session('user');--}}
{{--    @endphp--}}
<a href="{{route('home')}}">Повернутися на головну сторінку</a>
<br><br>
    <h1>Оформлення замовлення</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('orders.store') }}">
        @csrf
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

        <label for="comment">Коментар до замовлення</label>
        <br>
        <textarea id="comment" name="comment" rows="10" cols="50"></textarea>
        <br><br>
@php
$total = 0;
@endphp
        @foreach($baskets as $basket)
            @php
                $total = $total + $basket->sum;
            @endphp
            <hr>
            <div class="product-image">
                <img src="{{ asset($basket->product->image_path) }}" alt="Фото сумки">
            </div>

        <label for="name_product">Назва</label>
        <br>
        <input id="name_product" name="name_product" value="{{ $basket->product->name }}">
        <br><br>

        <label for="quantity">Кількість</label>
        <br>
        <input id="quantity" name="quantity" value="{{ $basket->quantity }}">
        <br><br>

        <label for="sum">Сума</label>
        <br>
        <input id="sum" name="sum" value="{{ $basket->sum }}">
        <br><br>
        @endforeach
        <h2>Разом до сплати = {{$total}}</h2>
        <br><br>

        <input type="submit" value="Відправити замовлення">
        <span style="display: inline-block; width: 100px;"></span>
    </form>

@endsection
