@extends('layouts.main')

@section('content')
    <h1>Вид продукту №  {{$kind_product->id}}</h1>
    <div>
        Назва: <h3>{{$kind_product->name}}</h3>
@foreach($sub_kind_products as $sub_kind_product)

            Назва: <b>{{$sub_kind_product->name}}</b>
        @endforeach
        <br>
        <hr>
    </div>
    <br>
    <a href="{{route('kind_products.index')}}">Повернутися у список видів продуктів</a>
    <br><br><br>
{{--    @if($user->role_id == 1)--}}
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('kind_products.destroy', ['kind_product' => $kind_product->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
{{--    @endif--}}
    @endsection

