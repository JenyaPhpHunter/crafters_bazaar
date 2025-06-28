@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('products.storekindsubkind') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            @forelse($arr_kind_products as $kind_product)
                @php
                    $escapedKindProduct = str_replace("'", "\\'", $kind_product);
                @endphp
                <a href="#" onclick="fillNameKindProduct('{{ $escapedKindProduct }}')">{{ $kind_product }}</a>
            @empty
            @endforelse
            <label for="title_kind_product">Назва виду товару</label>
            <input
                id="title_kind_product"
                name="title_kind_product"
                placeholder="Введіть назву виду товару"
                value="{{ old('title_kind_product') }}"
                class="form-control @error('title_kind_product') is-invalid @enderror"
            >

            @error('title_kind_product')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <br><br>
            @forelse($arr_sub_kind_products as $sub_kind_product)
                @php
                    $escapedSubKindProduct = str_replace("'", "\\'", $sub_kind_product);
                @endphp
                <a href="#" onclick="fillNameSubKindProduct('{{ $escapedSubKindProduct }}')">{{ $sub_kind_product }}</a>
            @empty
            @endforelse
            <label for="title_sub_kind_product">Назва підвиду товару</label>
            <input
                id="title_sub_kind_product"
                name="title_sub_kind_product"
                placeholder="Введіть підвиду товару"
                value="{{ old('title_sub_kind_product') }}"
                class="form-control @error('title_sub_kind_product') is-invalid @enderror"
            >

            @error('title_sub_kind_product')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <br><br>
            <div class="col-auto learts-mb-20">
                <button type="submit" class="btn btn-primary2">Зберегти</button>
            </div>
        </form>
    </div>
    <script>
        // Отримуємо масив назв видів товару з PHP і передаємо його в JavaScript
        var kindProducts = @json($arr_kind_products);
        // Функція, яка заповнює поле вводу 'name_kind_product' при натисканні на відповідний текст
        function fillNameKindProduct(kindProduct) {
            var nameKindProductInput = document.getElementById('title_kind_product');
            if (nameKindProductInput) {
                nameKindProductInput.value = kindProduct;
            }
        }
        // Отримуємо масив назв підвидів товару з PHP і передаємо його в JavaScript
        var subKindProducts = @json($arr_sub_kind_products);

        // Функція, яка заповнює поле вводу 'name_sub_kind_product' при натисканні на відповідний текст
        function fillNameSubKindProduct(subKindProduct) {
            var nameSubKindProductInput = document.getElementById('title_sub_kind_product');
            if (nameSubKindProductInput) {
                nameSubKindProductInput.value = subKindProduct;
            }
        }
    </script>

@endsection
