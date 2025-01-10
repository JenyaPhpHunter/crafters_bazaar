@extends('admin.layouts.app')

@section('content')
    <div>
        <ul>
            @foreach($roles as $role)
                <div class="kind_product">
                    <h2><a href="{{route('admin_roles.show', ['admin_role' => $role->id])}}">{{$role->id .'. '. $role->title}}</a></h2>
    {{--                @if($user->role_id == 1)--}}
                        <a href="{{ route('admin_roles.edit',['admin_role' => $role->id])}}">Редагувати роль</a>
    {{--                @endif--}}
                    <hr>
                </div>
            @endforeach
        </ul>
    </div>
  @endsection

