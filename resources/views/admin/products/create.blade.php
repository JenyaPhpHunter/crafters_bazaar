@extends('layouts.main')

@section('content')
{{--    @php--}}
{{--        $user = session('user');--}}
{{--    @endphp--}}
<a href="{{route('home')}}">Повернутися на головну сторінку</a>
<br><br>
    <h1>Додавання товару</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('products.store') }}">
        @csrf
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name">
        <br><br>

        <label for="kind_product_id">Вид товару</label>
        <br>
        <select id="kind_product_id" name="kind_product_id">
        @foreach($kind_products as $kind_product)
            <option value="{{ $kind_product->id }}">{{ $kind_product->name }}</option>
        @endforeach
        </select>
        <br><br>

        <label for="content">Інформація про товар</label>
        <br>
        <textarea id="content" name="content" rows="10" cols="50"></textarea>
        <br><br>

        <label for="price">Вартість</label>
        <br>
        <input id="price" name="price">
        <br><br>

        <label for="stock_balance">Залишок на складі</label>
        <br>
        <input id="stock_balance" name="stock_balance">
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('products.index')}}">Перейти на зручне редагування товарів</a>

    </form>

@endsection
