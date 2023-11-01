@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додавання виду продукту</h1>
        <br><br>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('kind_products.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            <label for="name">Назва</label>
            <input id="name" name="name">
            <br><br>

            <div class="col-auto learts-mb-20">
                <button type="submit" class="btn btn-primary2">Зберегти</button>
            </div>
        </form>
    </div>

@endsection
