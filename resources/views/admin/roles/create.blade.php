@extends('admin.layouts.app')

@section('content')
    <h1>Додавання ролі користувача</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('admin_roles.store') }}">
        @csrf
        <label for="name">Назва</label>
        <br>
        <input id="name" name="name">
        <br><br>

        <input type="submit" value="Зберегти">
        <span style="display: inline-block; width: 100px;"></span>
        <a href="{{route('admin_roles.index')}}">Повернутися в список ролей</a>

    </form>

@endsection
