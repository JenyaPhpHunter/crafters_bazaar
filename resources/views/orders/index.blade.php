@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
Не адмінка
    <a href="{{route('welcome')}}">Повернутися на головну сторінку</a>
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

    <div class="container">
        <h1>Ваші замовлення </h1>
        {{--        <!-- Пошукове вікно -->--}}
        {{--        <form action="{{ route('search') }}" method="GET">--}}
        {{--            <input type="text" name="query" placeholder="Пошук товару за назвою">--}}
        {{--            <button type="submit">Знайти</button>--}}
        {{--        </form>--}}
        @php
            $order = 0;
        @endphp
        <ul>
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

