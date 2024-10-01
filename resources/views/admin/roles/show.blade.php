@extends('admin.layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $role->name }}
    <br><br><br>

{{--    @if($user->role_id == 1)--}}
        <form id="delete-form-show" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('admin_roles.destroy', ['admin_role' => $role->id]) }}" onclick="document.getElementById('delete-form-show').submit(); return false;">Видалити</a>
        </form>
{{--    @endif--}}
@endsection

