@extends('layouts.main')

@section('content')
    <h1>Редагування підвидів продукту</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('sub_kind_products.update', ['sub_kind_product' => $sub_kind_product->id]) }}">
        @csrf
        @method('put')
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name" value="{{$sub_kind_product->name}}">
        <br><br>

        <label for="kind_product_id">Вид товару</label>
        <br>
        <select id="kind_product_id" name="kind_product_id">
            @foreach($kind_products as $id => $name)
                <option value="{{ $id }}" {{ $sub_kind_product->kind_product_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('kind_products.index')}}">Повернутися до списку підвидів продукту</a>

    </form>
@endsection



