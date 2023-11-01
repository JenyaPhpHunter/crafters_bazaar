@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1>Додавання виду та підвиду продукту</h1>
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
        <form method="post" action="{{ route('admin.products.storekindsubkind') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            @forelse($kind_products as $kind_product)
                @php
                    $escapedKindProduct = str_replace("'", "\\'", $kind_product);
                @endphp
                <a href="#" onclick="fillNameKindProduct('{{ $escapedKindProduct }}')">{{ $kind_product }}</a>
            @empty
            @endforelse
            <label for="name_kind_product">Назва виду продукту</label>
            <input id="name_kind_product" name="name_kind_product" placeholder="Введіть назву виду товару">
            <br><br>
            @forelse($sub_kind_products as $sub_kind_product)
                @php
                    $escapedSubKindProduct = str_replace("'", "\\'", $sub_kind_product);
                @endphp
                <a href="#" onclick="fillNameSubKindProduct('{{ $escapedSubKindProduct }}')">{{ $sub_kind_product }}</a>
            @empty
            @endforelse
            <label for="name_sub_kind_product">Назва підвиду продукту</label>
            <input id="name_sub_kind_product" name="name_sub_kind_product" placeholder="Введіть підвиду товару">
            <br><br>
            <div class="col-auto learts-mb-20">
                <button type="submit" class="btn btn-primary2">Зберегти</button>
            </div>
        </form>
    </div>
    <script>
        // Отримуємо масив назв видів товару з PHP і передаємо його в JavaScript
        var kindProducts = @json($kind_products);

        // Функція, яка заповнює поле вводу 'name_kind_product' при натисканні на відповідний текст
        function fillNameKindProduct(kindProduct) {
            var nameKindProductInput = document.getElementById('name_kind_product');
            if (nameKindProductInput) {
                nameKindProductInput.value = kindProduct;
            }
        }
    </script>
    <script>
        // Отримуємо масив назв підвидів товару з PHP і передаємо його в JavaScript
        var subKindProducts = @json($sub_kind_products);

        // Функція, яка заповнює поле вводу 'name_sub_kind_product' при натисканні на відповідний текст
        function fillNameSubKindProduct(subKindProduct) {
            var nameSubKindProductInput = document.getElementById('name_sub_kind_product');
            if (nameSubKindProductInput) {
                nameSubKindProductInput.value = subKindProduct;
            }
        }
    </script>

@endsection
