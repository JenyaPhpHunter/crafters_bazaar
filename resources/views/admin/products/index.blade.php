@extends('admin.layouts.app')

  @section('content')
      <a href="{{route('dashboard')}}">Повернутися на головну сторінку</a>
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
              <a href="{{route('admin_products_kind', ['kind_products' => $kind_product->id])}}">{{ $kind_product->name }}</a><br>
          @endforeach
      @endisset

      @isset($sub_kind_products_kind)
          @foreach($sub_kind_products_kind as $sub_kind_product_kind)
              <a href="{{route('admin_products_kind_subkind', ['sub_kind_products' => $sub_kind_product_kind->id])}}">{{ $sub_kind_product_kind->name }}</a><br>
          @endforeach
      @endisset

      <div class="container">
          <h1>Товари</h1>

          <div class="section">
              <div class="container">
                  <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 learts-mb-n40">
                      @foreach($kind_products as $kind_product)
                          <div class="col learts-mb-40">
                              <div class="category-banner4">
                                  <a href="{{ route('admin_products_kind', ['kind_products' => $kind_product->id]) }}" class="inner">
                                      <div class="image"><img src="{{ asset('images/banner/category/banner-s4-1.webp') }}" alt=""></div>
                                      <div class="content" data-bg-color="#f4ede7">
                                          <h3 class="title">{{ $kind_product->name }}</h3>
                                      </div>
                                  </a>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>

          <ul>
              @foreach($products as $product)
                  <div class="product">
                      <h2><a href="{{route('admin_products.show', ['product' => $product->id])}}">{{$product->name}}</a></h2>
                      <p>Вид товару: {{ $product->kind_product->name }}</p>
                      <p>Опис товару: {{ $product->content }}</p>
                      <p>Вартість: {{ $product->price }}</p>
                      <p>Залишок на складі: {{ $product->stock_balance }}</p>
                      <div class="product-image">
                          <img src="{{ asset($product->image_path) }}" alt="Фото сумки">
                      </div>
                      <a href="{{ route('admin_products.edit',['product' => $product->id])}}">Редагувати товар</a>
                      <br><br>
{{--                      <form method="POST" action="{{ route('basket.store') }}">--}}
{{--                          @csrf--}}
{{--                          <input type="hidden" name="product_id" value="{{ $product->id }}">--}}
{{--                          <button class="buy-btn" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Купити товар</button>--}}
{{--                      </form>--}}
                      <hr>
                  </div>
              @endforeach
          </ul>
      </div>
  @endsection

