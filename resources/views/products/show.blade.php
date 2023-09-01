@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
{{--    @php--}}
{{--    $user = session('user');--}}
{{--    @endphp--}}
    <h1> Назва {{$product->name}}</h1>
    <div class="product-image">
        <img src="{{ asset($product->image_path) }}" alt="Фото сумки">
    </div>
    <div>
        Номер: <b>{{$product->id}}</b>
        <br>
        Вид товару: {{$product->kind_product->name}}
        <br>
        Опис: {{$product->content}}
        <br>
        Вартість: {{$product->price}}
        <br>
        Залишок на складі: {{$product->stock_balance}}
        <br>
        Створено: {{$product->user->name}}
        <br>
        <hr>
    </div>
    <div>
        Дата створення продукту {{$product->created_at}}
    </div>
    <hr>
    <br>
    <a href="{{route('products.index')}}">Повернутися у список товарів</a>
    <form id="delete-form-show" method="post">
        @csrf
        @method('delete')
        <a href="{{ route('products.destroy', ['product' => $product->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
    </form>
@endsection

