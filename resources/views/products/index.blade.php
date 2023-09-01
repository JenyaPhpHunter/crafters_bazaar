  @extends('layouts.app')

  @section('content')
      <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">
      <a href="{{route('home')}}">Повернутися на головну сторінку</a>
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

      <div class="container">
          <h1>Товари</h1>
          <!-- Пошукове вікно -->
          <form action="{{ route('search') }}" method="GET">
              <input type="text" name="query" placeholder="Пошук товару за назвою">
              <button type="submit">Знайти</button>
          </form>

          <!-- Список видів продуктів -->
          <div class="kind-products">
              <ul>
                  <li>
                      <a href="{{ route('products.index') }}">Всі товари</a>
                  </li>
                  @foreach($kindProducts as $kindProduct)
                      <li>
                          <a href="{{ route('kindfilter', ['kind_product_id' => $kindProduct->id]) }}">{{ $kindProduct->name }}</a>
                      </li>
                  @endforeach
                  @if(isset($_GET['kind_product_id']))
                      <li>
                          <a href="{{ route('kindfilter') }}">Скинути фільтр</a>
                      </li>
                  @endif
                  @if(isset($_GET['query']))
                      <li>
                          <a href="{{ route('search') }}">Скинути фільтр</a>
                      </li>
                  @endif
              </ul>
          </div>
      </div>
      <div>
          <ul>
              @foreach($products as $product)
                  <div class="product">
                      <h2><a href="{{route('products.show', ['product' => $product->id])}}">{{$product->name}}</a></h2>
                      <p>Вид товару: {{ $product->kind_product->name }}</p>
                      <p>Опис товару: {{ $product->content }}</p>
                      <p>Вартість: {{ $product->price }}</p>
                      <p>Залишок на складі: {{ $product->stock_balance }}</p>
                      <div class="product-image">
                          <img src="{{ asset($product->image_path) }}" alt="Фото сумки">
                      </div>
                      <a href="{{ route('products.edit',['product' => $product->id])}}">Редагувати товар</a>
                      <br><br>
                      <form method="POST" action="{{ route('basket.store') }}">
                          @csrf
                          <input type="hidden" name="product_id" value="{{ $product->id }}">
                          <button class="buy-btn" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Купити товар</button>
                      </form>
                      <hr>
                  </div>
              @endforeach
          </ul>
      </div>
  @endsection

