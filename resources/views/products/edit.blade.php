@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
    <h1>Редагування товару</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('products.update', ['product' => $product->id]) }}">
        @csrf
        @method('put')
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name" value={{ $product->name }}>
        <br><br>

        <label for="kind_product_id">Вид товару</label>
        <br>
        <select id="kind_product_id" name="kind_product_id">
            @foreach($kind_products as $id => $name)
                <option value="{{ $id }}" {{ $product->kind_product_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="content">Опис</label>
        <br>
        <textarea id="content" name="content" rows="10" cols="50">{{ $product->content }}</textarea>
        <br><br>

        <label for="price">Вартість</label>
        <br>
        <input id="price" name="price" value="{{ $product->price }}">
        <br><br>

        <label for="stock_balance">Залишок на складі</label>
        <br>
        <input id="stock_balance" name="stock_balance" value="{{ $product->stock_balance }}">
        <br><br>

        <div class="product-image">
            <img src="{{ asset($product->image_path) }}" alt="Фото сумки">
        </div>

{{--        <label for="user_id">Користувач</label>--}}
{{--        <br>--}}
{{--        <input id="user_id" name="user_id"--}}
{{--               @if($auth_user->name) placeholder="{{$auth_user->name}}"--}}
{{--               @else placeholder="{{$auth_user->email}}"--}}
{{--               @endif--}}
{{--               readonly>--}}
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
    </form>
    <a href="{{route('products.index')}}">Повернутися в список товарів</a>
@endsection



