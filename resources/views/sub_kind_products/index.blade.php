  @extends('layouts.main')

  @section('content')

      <a href="{{route('dashboard')}}">Повернутися на головну сторінку</a>
      <br>
      @php
          $name = 'Список підвидів продукту:';
      @endphp
    <h1>{{$name}}</h1>
<br><br>
{{--      @if($user->role_id == 1)--}}
          <a href="{{ route('sub_kind_products.create') }}">Створити підвид продукту</a>
{{--      @endif--}}
<div>
    <ul>
        @if(isset($KindProduct))
            <h1><a href="{{route('kind_products.index')}}">{{$KindProduct->name}}</a></h1>
            @foreach($sub_kind_products as $sub_kind_product)
                    <div class="sub_kind_product">
                        <h2><a href="{{route('sub_kind_products.show', ['sub_kind_product' => $sub_kind_product->id])}}">{{' - '. $sub_kind_product->name}}</a></h2>
                        {{--                @if($user->role_id == 1)--}}
                        <a href="{{ route('sub_kind_products.edit',['sub_kind_product' => $sub_kind_product->id])}}">Редагувати підвид продукту</a>
                        {{--                @endif--}}
                        <hr>
                    </div>
            @endforeach
        @else
            @foreach($kind_products as $kind_product)
                <h1><a href="{{route('kind_products.index')}}">{{$kind_product->name}}</a></h1>
                @foreach($sub_kind_products as $sub_kind_product)
                    @if($kind_product->id == $sub_kind_product->kind_product->id)
                        <div class="sub_kind_product">
                            <h2><a href="{{route('sub_kind_products.show', ['sub_kind_product' => $sub_kind_product->id])}}">{{' - '. $sub_kind_product->name}}</a></h2>
                            {{--                @if($user->role_id == 1)--}}
                            <a href="{{ route('sub_kind_products.edit',['sub_kind_product' => $sub_kind_product->id])}}">Редагувати підвид продукту</a>
                            {{--                @endif--}}
                            <hr>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    </ul>
</div>
  @endsection

