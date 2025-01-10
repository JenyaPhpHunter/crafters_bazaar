@extends('admin.layouts.app')

@section('content')
    {{ $role->title }}
    <br><br><br>

    @if($user->role_id == 1)
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('admin_roles.destroy', ['admin_role' => $role->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
    @endif
@endsection

