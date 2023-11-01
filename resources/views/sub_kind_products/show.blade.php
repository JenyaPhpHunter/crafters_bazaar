@extends('layouts.main')

@section('content')
    <h1>Підвид продукту №  {{$sub_kind_product->id}}</h1>
    <div>
        Назва: <b>{{$sub_kind_product->name}}</b>
        <br>
        <hr>
    </div>
    <br>
    <a href="{{route('sub_kind_products.index')}}">Повернутися у список підвидів продуктів</a>
    <br><br><br>
{{--    @if($user->role_id == 1)--}}
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('sub_kind_products.destroy', ['sub_kind_product' => $sub_kind_product->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
{{--    @endif--}}
    @endsection

