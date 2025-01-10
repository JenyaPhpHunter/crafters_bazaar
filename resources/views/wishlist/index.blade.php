@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Products Start -->
    <div class="section section-fluid learts-mt-70">
        <div class="container">
            <div class="row learts-mb-n50">
                <div class="col-lg-9 col-12 learts-mb-50">
                    <!-- Products Start -->
                    <div id="shop-products" class="products isotope-grid row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                        <div class="grid-sizer col-1"></div>
                            @foreach($wishitems as $wishitem)
                                <div class="grid-item col
                                @if($wishitem->product->new == 1) new
                                @elseif($wishitem->product->discount != 0) sales featured
                                @elseif($wishitem->product->featured != 0) featured
                                @elseif($wishitem->product->discount != 0 && $product->featured != 0) sales featured
                                @endif">
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
                                    <div class="product">
                                        <div class="product-thumb">
                                            <a href="{{ route('products.show',['product' => $wishitem->product->id]) }}" class="image">
                                                @php
                                                    $selectedPhoto = $wishitem->product->productphotos->where('queue', 1)->first();
                                                @endphp
                                                @isset($selectedPhoto)
                                                    <img src="{{ asset($selectedPhoto->small_path . '/' . $selectedPhoto->small_filename) }}" alt="Product Image">
                                                    @if(isset($selectedPhoto->hover_path) && isset($selectedPhoto->hover_filename))
                                                        <img class="image-hover " src="{{ asset($selectedPhoto->hover_path . '/' . $selectedPhoto->hover_filename) }}" alt="Product Image">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('images/product/s328/product-14.webp') }}" alt="Product Image">
                                                @endisset
                                            </a>
                                            <a href="#" class="add-to-wishlist hintT-left" data-hint="Додати до улюблених" data-product-id="{{ $wishitem->product->id }}">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <h6 class="title"><a href="{{ route('products.show',['product' => $wishitem->product->id]) }}">{{ $wishitem->product->title }}</a></h6>
                                            <span class="price">
                                                    <span class="old"> було {{-- {{ $wishitem->product->price }} --}} 1000 грн</span>
                                                <br>
                                                <span class="new">стало {{ $wishitem->product->price }} грн</span>
                                                </span>
                                            @if($wishitem->product->term_creation != 0)
                                                <span class="price">
                                                                    Виготовлення {{ $wishitem->product->term_creation }}
                                                    @if($wishitem->product->term_creation == 1) день
                                                    @elseif($wishitem->product->term_creation > 1 && $wishitem->product->term_creation < 5) дні
                                                    @else днів @endif
                                                                    </span>
                                            @endif
                                            <div class="product-buttons">
                                                <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top"
                                                   data-hint="Швидкий перегляд"><i class="fal fa-search"></i></a>
                                                <a href="{{ route('carts.addToCart',['product' => $wishitem->product->id]) }}"
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
<!-- Products End -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
