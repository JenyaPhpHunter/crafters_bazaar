@extends('admin.layouts.app')

@section('content')
    <form method="post" action="{{ route('admin_roles.store') }}">
        @csrf
        <label for="title">Назва</label>
        <br>
        <input id="title" name="title">
        <br><br>
        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('admin_roles.index')}}">Повернутися в список ролей</a>
    </form>
@endsection
