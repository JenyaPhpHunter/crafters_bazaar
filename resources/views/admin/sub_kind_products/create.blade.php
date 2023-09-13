@extends('layouts.main')

@section('content')
    <h1>Додавання підвиду продукту</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('sub_kind_products.store') }}">
        @csrf
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name">
        <br><br>
        <label for="kind_product_id">Вид товару</label>
        <br>
        <select id="kind_product_id" name="kind_product_id">
            @foreach($kind_products as $kind_product)
                <option value="{{ $kind_product->id }}" {{ isset($KindProduct) && $KindProduct->id == $kind_product->id ? 'selected' : '' }}>
                    {{ $kind_product->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('sub_kind_products.index')}}">Повернутися в список підвидів продукту</a>

    </form>

@endsection
