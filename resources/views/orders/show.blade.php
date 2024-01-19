@extends('layouts.app')

@section('content')
    <a href="{{route('welcome')}}">Повернутися на головну сторінку</a>
    <br><br>
    <h1>Ваш заказ № {{ $order->id }} на суму {{ $order->total }} успешно оформлен!</h1>
    <br><br><br>
    <h2>Очікуйте доставку за адресою: Місто {{ $order->city }} вулиця {{ $order->address }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br><br>
    <a href="{{route('orders.index')}}">Подивитись всі свої замовлення</a>
@endsection


