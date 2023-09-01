@extends('layouts.main')

@section('content')

    <div>
        <h2>
            @if ($user->surname && $user->name && $user->secondname)
                {{ $user->surname }} {{ $user->name }} {{ $user->secondname }}
            @elseif ($user->surname && $user->name)
                {{ $user->surname }} {{ $user->name }}
            @elseif ($user->name)
                {{ $user->name }}
            @else
                {{ $user->email }}
            @endif
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
    <hr>
    <br>
    <a href="{{route('users.index')}}">Повернутися у список користувачів</a>
    <form id="delete-form-show" method="post">
        @csrf
        @method('delete')
        <a href="{{ route('users.destroy', ['user' => $user->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
    </form>
@endsection

