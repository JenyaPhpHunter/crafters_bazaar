  @extends('layouts.main')

  @section('content')
      <link rel="stylesheet" href="{{ asset('resources/css/styles.css') }}">

      <a href="{{route('home')}}">Повернутися на головну сторінку</a>
      <br>
      @php
          $name = 'Ваша корзина';
          $basket_sum = 0;
      @endphp
    <h1>{{$name}}</h1>
<br><br>

<div>
    <ul>
        @foreach($basketItems as $basketItem)
            <div class="basketItem">
                <h2><a href="{{route('products.show', ['product' => $basketItem->product_id])}}">{{$basketItem->product->name}}</a></h2>
                <p>Кількість: {{ $basketItem->quantity }}</p>
                <p>Вид товару: {{ $basketItem->product->kind_product->name }}</p>
                <p>Опис товару: {{ $basketItem->product->content }}</p>
                <p>Вартість: {{ $basketItem->total }}</p>
                <p>Залишок на складі: {{ $basketItem->product->stock_balance }}</p>
                <div class="product-image">
                    <img src="{{ asset($basketItem->product->image_path) }}" alt="Фото сумки">
                </div>
                <br>
{{--                <a href="{{ route('home') }}">Видалити з корзини</a>--}}
                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $basketItem->id }}').submit();">Видалити з корзини</a>
                <form id="delete-form-{{ $basketItem->id }}" action="{{ route('basket.destroy', ['basketItem' => $basketItem->id]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <hr>
            </div>
        @php
            $basket_sum +=  $basketItem->total
        @endphp
        @endforeach
    </ul>
    @if($basket_sum)
    <h2>Загальна вартість товарів = {{ $basket_sum }}</h2>
    @endif
</div>
      <a href="{{ route('home') }}">Вибрати @php if($basket_sum) echo 'ще'; @endphp товари</a>
      <br><br><br>
      <form method="GET" action="{{ route('orders.create') }}">
          <button class="order-btn">Оформити замовлення</button>
      </form>
  @endsection
{{--  @section('script')--}}
{{--      'script'--}}
{{--  @endsection--}}


