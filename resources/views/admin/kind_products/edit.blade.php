@extends('admin.layouts.app')

@section('content')
    <h1>Редагування видів продукту</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('kind_products.update', ['kind_product' => $kind_product->id]) }}">
        @csrf
        @method('put')
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name" value="{{$kind_product->name}}">
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('kind_products.index')}}">Повернутися до списку видів продукту</a>

    </form>
@endsection



