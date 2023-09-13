@extends('layouts.main')

@section('content')
    <h1>Вид продукту №  {{$role->id}}</h1>
    <div>
        Назва: <b>{{$role->name}}</b>
        <br>
        <hr>
    </div>
    <br>
    <a href="{{route('roles.index')}}">Повернутися у список ролей</a>
    <br><br><br>
{{--    @if($user->role_id == 1)--}}
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('roles.destroy', ['role' => $role->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
{{--    @endif--}}
    @endsection

