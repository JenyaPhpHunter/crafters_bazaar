  @extends('layouts.app')

  @section('content')
      <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
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
              <a href="{{route('products_kind', ['kind_products' => $kind_product->id])}}">{{ $kind_product->name }}</a><br>
          @endforeach
      @endisset

      @isset($sub_kind_products_kind)
          @foreach($sub_kind_products_kind as $sub_kind_product_kind)
              <a href="{{route('products_kind_subkind', ['sub_kind_products' => $sub_kind_product_kind->id])}}">{{ $sub_kind_product_kind->name }}</a><br>
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
                      <a href="{{ route('products.show', ['product' => $product->id]) }}" class="image">
                          <img src="{{ asset( $product->productphotos[0]->path . '/' . $product->productphotos[0]->filename) }}" alt="Product Image">
                          <img class="image-hover " src="{{ asset(  $product->productphotos[0]->hover_path . '/' . $product->productphotos[0]->hover_filename) }}" alt="Product Image">
                      </a>
                      <a href="wishlist.html" class="add-to-wishlist hintT-left" data-hint="Add to wishlist"><i class="far fa-heart"></i></a>
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
                      <h6 class="title"><a href="product-details.html">{{ $product->name }}</a></h6>
                      <span class="price">
                                <span class="old">{{ $product->price }}</span>
                            <span class="new">{{ $product->price }}</span>
                            </span>
                      <div class="product-buttons">
                          <a href="#quickViewModal" data-bs-toggle="modal" class="product-button hintT-top" data-hint="Quick View"><i class="fal fa-search"></i></a>
                          <a href="{{ route('carts.addToCart',['product' => $product->id]) }}" class="product-button hintT-top" data-hint="Add to Cart"><i class="fal fa-shopping-cart"></i></a>
                          <a href="#" class="product-button hintT-top" data-hint="Compare"><i class="fal fa-random"></i></a>
                      </div>
                  </div>
              </div>
          </div>
          @endforeach
      </div>
{{--              @foreach($products as $product)--}}
{{--                  <div class="product">--}}
{{--                      <h2><a href="{{route('products.show', ['product' => $product->id])}}">{{$product->name}}</a></h2>--}}
{{--                      <p>Вид товару: {{ $product->kind_product->name }}</p>--}}
{{--                      <p>Опис товару: {{ $product->content }}</p>--}}
{{--                      <p>Вартість: {{ $product->price }}</p>--}}
{{--                      <p>Залишок на складі: {{ $product->stock_balance }}</p>--}}
{{--                      <div class="product-image">--}}
{{--                          <img src="{{ asset($product->image_path) }}" alt="Фото сумки">--}}
{{--                      </div>--}}
{{--                      <a href="{{ route('products.edit',['product' => $product->id])}}">Редагувати товар</a>--}}
{{--                      <br><br>--}}
{{--                      <form method="POST" action="{{ route('basket.store') }}">--}}
{{--                          @csrf--}}
{{--                          <input type="hidden" name="product_id" value="{{ $product->id }}">--}}
{{--                          <button class="buy-btn" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Купити товар</button>--}}
{{--                      </form>--}}
{{--                      <hr>--}}
{{--                  </div>--}}
{{--              @endforeach--}}
{{--          </ul>--}}
{{--      </div>--}}
  @endsection

