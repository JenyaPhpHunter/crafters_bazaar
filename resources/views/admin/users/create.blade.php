@extends('admin.layouts.app')

@section('content')

    <h1>Додавання користувача</h1>
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
                <h2 class="title">Дані нового користувача</h2>
            </div>
            <form method="post" action="{{ route('admin_users.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="name">Ім'я <abbr class="required">*</abbr></label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', "") }}"
                        >
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdSecondName">По-батькові</label>
                        <input type="text" id="secondname" name="secondname"
                               class="form-control @error('secondname') is-invalid @enderror"
                               value="{{ old('secondname', "") }}"
                        >
                        @error('secondname')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="surname">Прізвище <abbr class="required">*</abbr></label>
                        <input type="text" id="surname" name="surname"
                               class="form-control @error('surname') is-invalid @enderror"
                               value="{{ old('surname', "") }}"
                        >
                        @error('surname')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="bdPhone">Телефон <abbr class="required">*</abbr></label>
                        <input type="text" id="phone" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', "") }}"
                        >
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdEmail">Email <abbr class="required">*</abbr></label>
                        <input type="text" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', "") }}"
                        >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="password">{{ __('Пароль') }} <abbr class="required">*</abbr></label>
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                    <label for="role_id">Роль користувача</label>
                        <div class="col-md-12">
                            <select class="search-select select2-basic" id="role_id" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('role_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="category_user_id">Категорія користувача</label>
                        <div class="col-md-12">
                            <select class="search-select select2-basic" id="category_user_id" name="category_user_id">
                                @foreach($categories_user as $category_user)
                                    <option value="{{ $category_user->id }}" {{ old('category_user_id') ? 'selected' : '' }}>{{ $category_user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('category_user_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>
                </div>
                <button type="submit" name="action" value="Зберегти"
                        class="btn btn-dark btn-outline-hover-dark">
                    <i class="fas fa-save"></i> Зберегти
                </button>
            </form>
        </div>
    </div>

@endsection
