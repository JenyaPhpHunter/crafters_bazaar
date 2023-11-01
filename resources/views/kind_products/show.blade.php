@extends('layouts.main')

@section('content')
    <h1>Вид продукту №  {{$kind_product->id}}</h1>
        Назва:<h2>{{$kind_product->name}}</h2>
    <br>
@foreach($sub_kind_products as $sub_kind_product)
            Назва підвиду продуктів: <b>{{$sub_kind_product->name}}</b>
        @endforeach
        <br>
        <hr>
    <br>
    <a href="{{route('kind_products.index')}}">Повернутися у список видів продуктів</a>
    <br><br><br>
    <a href="{{ route('sub_kind_products.create', ['kind_product_id' => $kind_product->id]) }}">
        Створити підвид продукта
    </a>
    <br><br><br>
{{--    @if($user->role_id == 1)--}}
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('kind_products.destroy', ['kind_product' => $kind_product->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
{{--    @endif--}}
    @endsection

