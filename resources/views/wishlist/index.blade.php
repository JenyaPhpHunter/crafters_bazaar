@extends('layouts.app')

@section('content')
    <div class="offcanvas-overlay"></div>

    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="{{asset('images/bg/page-title-1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h1 class="title">Список бажань</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Список бажань</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <div class="products row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
        @foreach($wishitems as $wishitem)
            <div class="col">
                <div class="product">
                    <div class="product-thumb">
                        <span class="product-badges">
                            @if($wishitem->product->new == 1)
                                <span class="new">new</span>
                            @endif
                            @if($wishitem->product->stock_balance == 0)
                                <span class="outofstock"><i class="fal fa-frown"></i></span>
                            @endif
                            @if($wishitem->product->discount != 0)
                                <span class="onsale">-10%</span>
                            @endif
                            @if($wishitem->product->featured != 0)
                                <span class="hot">hot</span>
                            @endif
                        </span>
                        <a href="{{ route('products.show', ['product' => $wishitem->product->id]) }}" class="image">
                            <img
                                src="{{ asset( $wishitem->product->productphotos[0]->path . '/' . $wishitem->product->productphotos[0]->filename) }}"
                                alt="Product Image">
                            <img class="image-hover "
                                 src="{{ asset(  $wishitem->product->productphotos[0]->hover_path . '/' . $wishitem->product->productphotos[0]->hover_filename) }}"
                                 alt="Product Image">
                        </a>
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
                        <h6 class="title"><a href="{{ route('products.show',['product' => $wishitem->product->id]) }}">{{ $wishitem->product->name }}</a></h6>
                        <span class="price">
                                <span class="old">{{ $wishitem->product->price }}</span>
                            <span class="new">{{ $wishitem->product->price }}</span>
                            </span>
                        <div class="product-buttons">
                            <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top"
                               data-hint="Quick View"><i class="fal fa-search"></i></a>
                            <a href="{{ route('carts.addToCart',['product' => $wishitem->product->id]) }}"
                               class="product-button hintT-top" data-hint="Додати в корзину"><i
                                    class="fal fa-shopping-cart"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Поділитися"><i
                                    class="fal fa-random"></i></a>
                            <a href="#" class="product-button hintT-top" data-hint="Видалити з списку бажань"><i
                                    class="fal fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(count($wishitems) > 0)
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('wishlist.toCart') }}" id="wishlistToCartForm">
                        @csrf
                        <button type="submit" class="btn btn-outline-success float-start">Додати все у корзину</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('wishlist.clear') }}" id="clearWishlistForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger float-end">Очистити список бажань</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
