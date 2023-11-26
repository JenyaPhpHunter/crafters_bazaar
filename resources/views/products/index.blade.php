@extends('layouts.app')

@section('content')
    <a href="{{route('welcome')}}">Повернутися на головну сторінку</a>
    <br>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @isset($kind_products)
        @foreach($kind_products as $kind_product)
            <a href="{{route('products_kind', ['kind_products' => $kind_product->id])}}">{{ $kind_product->name }}</a>
            <br>
        @endforeach
    @endisset


    @isset($sub_kind_products_kind)
        @foreach($sub_kind_products_kind as $sub_kind_product_kind)
            <a href="{{route('products_kind_subkind', ['sub_kind_products' => $sub_kind_product_kind->id])}}">{{ $sub_kind_product_kind->name }}</a>
            <br>
        @endforeach
    @endisset

    <div class="products row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
        @foreach($products as $product)
            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <span class="product-badges">
                            <span class="outofstock"><i class="fal fa-frown"></i></span>
                            <span class="hot">hot</span>
                            <span class="onsale">-13%</span>
                        </span>
                        @isset($product->productphotos[0])
                            <a href="{{ route('products.show', ['product' => $product->id]) }}" class="image">
                                <img
                                    src="{{ asset( $product->productphotos[0]->path . '/' . $product->productphotos[0]->filename) }}"
                                    alt="Product Image">
                                <img class="image-hover "
                                     src="{{ asset(  $product->productphotos[0]->hover_path . '/' . $product->productphotos[0]->hover_filename) }}"
                                     alt="Product Image">
                            </a>
                        @endisset
                        <a href="{{ route('wishlist.addToWishlist', ['product' => $product->id]) }}" class="add-to-wishlist hintT-left" data-hint="Додати до улюблених"><i
                                class="far fa-heart"></i></a>
                        <div class="product-options">
                            <ul class="colors">
                                <li style="background-color: #000000;">color one</li>
                                <li style="background-color: #b2483c;">color two</li>
                            </ul>
                            <ul class="sizes">
                                <li>Великий</li>
                                <li>Середній</li>
                                <li>Маленький</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="title"><a href="{{ route('products.show',['product' => $product->id]) }}">{{ $product->name }}</a></h6>
                        <span class="price">
                                <span class="old">{{ $product->price }}</span>
                            <span class="new">{{ $product->price }}</span>
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top"
                               data-hint="Швидкий перегляд"><i class="fal fa-search"></i></a>
                            <a href="{{ route('carts.addToCart',['product' => $product->id]) }}"
                               class="product-button hintT-top" data-hint="Додати до корзини"><i
                                    class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Поділитися"><i
                                    class="fal fa-random"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

