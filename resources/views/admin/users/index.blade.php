  @extends('admin.layouts.app')

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

      <div class="container">
          <h1>Користувачі</h1>
          <!-- Пошукове вікно -->
          <form action="{{ route('searchusers') }}" method="GET">
              <input type="text" name="query" placeholder="Пошук користувача за прізвищем та email">
              <button type="submit">Знайти</button>
          </form>
      </div>
      @foreach($users as $user)
          <h2><a href="{{route('users.show', ['user' => $user->id])}}">
                  @if ($user->surname && $user->name && $user->secondname)
                      {{ $user->surname }} {{ $user->name }} {{ $user->secondname }}
                  @elseif ($user->surname && $user->name)
                      {{ $user->surname }} {{ $user->name }}
                  @elseif ($user->name)
                      {{ $user->name }}
                  @else
                      {{ $user->email }}
                  @endif
              </a>
          </h2>
          @if($user->name || $user->surname || $user->secondname)
          <p>Email: {{ $user->email }}</p>
          @endif
          @if($user->phone)
              <p>Телефон: {{ $user->phone }}</p>
          @endif
          @if($user->city)
              <p>Місто: {{ $user->city }}</p>
          @endif
          @if($user->address)
              <p>Адреса: {{ $user->address }}</p>
          @endif
          @if($user->city)
              <p>Місто: {{ $user->city }}</p>
          @endif
          @if($user->delivery_id)
              <p>Доставка: {{ $user->delivery->name }}</p>
          @endif
          @if($user->paymentkind_id)
              <p>Спосіб оплати: {{ $user->paymentkind->name }}</p>
          @endif
          <p>Роль користувача: {{ $user->role->name }}</p>
          <p>Створено користувача: {{ $user->created_at }}</p>
          <p>Оновлено користувача: {{ $user->updated_at }}</p>
          <br>
          <a href="{{ route('users.edit',['user' => $user->id])}}">Редагувати користувача</a>
      @endforeach
<br><br>
          <a href="{{ route('users.create') }}">Створити користувача</a>
  @endsection

