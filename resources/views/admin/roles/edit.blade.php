@extends('admin.layouts.app')

@section('content')
    <form method="post" action="{{ route('admin_roles.update', ['admin_role' => $role->id]) }}">
        @csrf
        @method('put')
        <label for="title">Назва</label>
        <br>
        <input id="title" name="title" value="{{$role->title}}">
        <br><br>
        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('admin_roles.index')}}">Повернутися до списку ролей</a>
    </form>
@endsection



