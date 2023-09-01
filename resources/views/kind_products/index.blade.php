  @extends('layouts.main')

  @section('content')

      <a href="{{route('home')}}">Повернутися на головну сторінку</a>
      <br>
      @php
          $name = 'Список видів продукту:';
      @endphp
    <h1>{{$name}}</h1>
<br><br>
{{--      @if($user->role_id == 1)--}}
          <a href="{{ route('kind_products.create') }}">Створити вид продукту</a>
{{--      @endif--}}
<div>
    <ul>
        @foreach($kind_products as $kind_product)
            <div class="kind_product">
                <h2><a href="{{route('kind_products.show', ['kind_product' => $kind_product->id])}}">{{$kind_product->id .'. '. $kind_product->name}}</a></h2>
{{--                @if($user->role_id == 1)--}}
                    <a href="{{ route('kind_products.edit',['kind_product' => $kind_product->id])}}">Редагувати вид продукту</a>
{{--                @endif--}}
                <hr>
            </div>
        @endforeach
    </ul>
</div>
  @endsection

