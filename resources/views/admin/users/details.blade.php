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
    <!-- Checkout Section Start -->
    <div class="section section-padding">
        <div class="container">
            <div class="section-title2">
                <h2 class="title">Дані користувача</h2>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 learts-mb-20">
                    <label for="name">Ім'я <abbr class="required">*</abbr></label>
                    <div>{{ $user->name }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-20">
                    <label for="bdSecondName">По-батькові</label>
                    <div>{{ $user->secondname }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-30">
                    <label for="surname">Прізвище <abbr class="required">*</abbr></label>
                    <div>{{ $user->surname }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-30">
                    <label for="bdPhone">Телефон <abbr class="required">*</abbr></label>
                    <div>{{ $user->phone }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-20">
                    <label for="bdEmail">Email <abbr class="required">*</abbr></label>
                    <div>{{ $user->email }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-30">
                    <label for="role_id">Роль користувача</label>
                    <div>{{ $user->role->name }}</div>
                </div>
                <div class="col-md-6 col-12 learts-mb-30">
                    <label for="category_user_id">Категорія користувача</label>
                    <div>{{ $user->category_user->name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 learts-mb-30">
                    <a href="{{ route('admin_users.edit', ['admin_user' => $user->id]) }}" class="btn btn-dark btn-outline-hover-dark">
                        <i class="fas fa-pencil-alt"></i> Редагувати
                    </a>

                    {{--                    <form method="get" action="{{ route('admin_users.edit', ['admin_user' => $user->id]) }}" style="display:inline;">--}}
{{--                        <button type="submit" class="btn btn-dark btn-outline-hover-dark">--}}
{{--                            <i class="fas fa-pencil-alt"></i> Редагувати--}}
{{--                        </button>--}}
{{--                    </form>--}}
                </div>

                <div class="col-md-6 col-12 learts-mb-30">
                    <form action="{{ route('admin_users.destroy', ['admin_user' => $user->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Видалити користувача" onclick="return confirm('Ви впевнені, що хочете видалити цього користувача?');">
                            <i class="fas fa-trash-alt"></i> Видалити
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
