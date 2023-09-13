  @extends('layouts.main')

  @section('content')

      <a href="{{route('dashboard')}}">Повернутися на головну сторінку</a>
      <br>
      @php
          $name = 'Список ролей:';
      @endphp
    <h1>{{$name}}</h1>
<br><br>
{{--      @if($user->role_id == 1)--}}
          <a href="{{ route('roles.create') }}">Створити вид продукту</a>
{{--      @endif--}}
<div>
    <ul>
        @foreach($roles as $role)
            <div class="kind_product">
                <h2><a href="{{route('roles.show', ['role' => $role->id])}}">{{$role->id .'. '. $role->name}}</a></h2>
{{--                @if($user->role_id == 1)--}}
                    <a href="{{ route('roles.edit',['role' => $role->id])}}">Редагувати роль</a>
{{--                @endif--}}
                <hr>
            </div>
        @endforeach
    </ul>
</div>
  @endsection

