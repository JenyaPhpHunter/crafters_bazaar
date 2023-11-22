@extends('admin.layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
        <a href="{{route('dashboard')}}">Повернутися на головну сторінку</a>
        <br><br>
        <a href="{{route('admin_orders.create')}}"> Створити замовлення</a>
        <br><br>
        <a href="{{route('admin_orders.index')}}"> Показати всі замовлення</a>
        <br><br>
        @isset($statuses_orders)
        @foreach($statuses_orders as $status)
            <a href="{{ route('admin_orders.index',  ['status_orders' => $status->id]) }}"> Показати замовлення зі статусом {{ $status->name }}</a>
            <br><br>
        @endforeach
        @endisset
{{--    <div class="container">--}}
        <h1>Замовлення @if(isset($status_orders)) зі статусом "{{ $status_orders->name }}": @endif</h1>
        {{--        <!-- Пошукове вікно -->--}}
        {{--        <form action="{{ route('search') }}" method="GET">--}}
        {{--            <input type="text" name="query" placeholder="Пошук товару за назвою">--}}
        {{--            <button type="submit">Знайти</button>--}}
        {{--        </form>--}}
            @forelse($orders as $order)
                <div class="order">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Замовлення №</th>
                            <th>Email користувача</th>
                            <th>Телефон користувача</th>
                            <th>Спосіб доставки</th>
                            <th>Спосіб оплати</th>
                            <th>Місто доставки</th>
                            <th>Адреса доставки</th>
                            <th>Адреса нової пошти</th>
                            <th>Промокод</th>
                            <th>Вартість доставки</th>
                            <th>Загальна знижка</th>
                            <th>Загальна вартість замовлення</th>
                            <th>Коментар</th>
                            <th>Створено замовлення</th>
                            <th>Оновлено замовлення</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->email }}</td>
                                <td>{{ $order->user->phone }}</td>
                                <td>{{ $order->delivery->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
{{--                    <p>Категорія: {{ $basket->product->kind_product->name }}</p>--}}
{{--                    <p>Кількість: {{ $basket->quantity }}</p>--}}
{{--                    <p>Вартість: {{ $basket->sum }}--}}
{{--                        @if($basket->sum != $basket->total)--}}
{{--                            замість {{ $basket->total }}--}}
{{--                            Ваша знижка = {{ $basket->discount }}--}}
{{--                        @endif--}}
{{--                    </p>--}}
{{--                    <div class="product-image">--}}
{{--                        <img src="{{ asset($basket->product->image_path) }}" alt="Фото сумки">--}}
{{--                    </div>--}}
                </div>
            @empty
            <h2>Відсутні</h2>
            @endforelse
{{--    </div>--}}
@endsection

