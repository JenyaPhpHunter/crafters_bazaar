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
            <form method="post" action="{{ route('admin_users.update', ['admin_user' => $user->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="name">Ім'я <abbr class="required">*</abbr></label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
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
                               value="{{ old('secondname', $user->secondname) }}"
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
                               value="{{ old('surname', $user->surname) }}"
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
                               value="{{ old('phone', $user->phone) }}"
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
                               value="{{ old('email', $user->email) }}"
                        >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="password">{{ __('Пароль') }}</label>
                        <div class="col-md-12">
                            <input type="password" id="password" name="password"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="role_id">Роль користувача</label>
                        <div class="col-md-12">
                            <select class="search-select select2-basic" id="role_id" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? null) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
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
                                    <option value="{{ $category_user->id }}" {{ old('category_user_id', $user->category_user_id ?? null) == $category_user->id ? 'selected' : '' }}>{{ $category_user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('category_user_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" name="action" value="Зберегти"
                            class="btn btn-lg btn-dark btn-outline-hover-dark w-50">
                        <i class="fas fa-save"></i> Зберегти
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
