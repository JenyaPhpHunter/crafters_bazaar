@extends('layouts.main')

@section('content')
    <h1>Редагування користувача</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('users.update', ['user' => $user->id]) }}">
        @csrf
        @method('put')
        <label for="surname">Прізвище</label>
        <br>
        <input id="surname" name="surname" value="{{ $user->surname }}">
        <br><br>

        <label for="name">Ім'я</label>
        <br>
        <input id="name" name="name" value="{{ $user->name }}">
        <br><br>

        <label for="secondname">По батькові</label>
        <br>
        <input id="secondname" name="secondname" value='{{ $user->secondname }}'>
        <br><br>

        <label for="email">Email</label>
        <br>
        <input id="email" name="email" value={{ $user->email }}>
        <br><br>

        <label for="password">Новий пароль</label>
        <br>
        <input id="password" name="password">
        <br><br>

        <label for="phone">Телефон</label>
        <br>
        <input id="phone" name="phone" type="tel" pattern="[0-9]+" value="{{ $user->phone }}" required>
        <br><br>

        <label for="delivery_id">Спосіб доставки</label>
        <br>
        <select id="delivery_id" name="delivery_id">
            @foreach($deliveries as $id => $name)
                <option value="{{ $id }}" {{ $user->delivery_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="city">Місто</label>
        <br>
        <input id="city" name="city" value="{{ $user->city }}">
        <br><br>

        <label for="address">Адреса</label>
        <br>
        <input id="address" name="address" value="{{ $user->address }}">
        <br><br>

        <label for="paymentkind_id">Спосіб оплати</label>
        <br>
        <select id="paymentkind_id" name="paymentkind_id">
            @foreach($payment_kinds as $id => $name)
                <option value="{{ $id }}" {{ $user->paymentkind_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <br><br>

        <label for="role_id">Роль користувача</label>
        <br>
        <select id="role_id" name="role_id">
            @foreach($roles as $id => $name)
                <option value="{{ $id }}" {{ $user->role_id == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
    </form>
    <a href="{{route('users.index')}}">Повернутися в список користувачів</a>
@endsection



