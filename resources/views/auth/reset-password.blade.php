@extends('layouts.app')

@section('content')
    <section class="auth-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h2 class="mb-3">
                                <i class="fas fa-key me-2 text-warning"></i>
                                Встановлення нового пароля
                            </h2>
                            <p class="text-muted mb-4">
                                Введіть новий пароль для вашого акаунта.
                            </p>

                            {{-- Session errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                <input type="hidden" name="email" value="{{ request()->email }}">

                                {{-- New password --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Новий пароль</label>
                                    <input id="password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required autocomplete="new-password">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirm password --}}
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Підтвердження пароля</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                           class="form-control" required autocomplete="new-password">
                                </div>

                                {{-- Submit --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Зберегти новий пароль
                                    </button>
                                </div>

                                <div class="text-end mt-3">
                                    <a href="{{ route('login-register') }}" class="small">Повернутись до входу</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        h2 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #72A499;
        }

        .btn-primary {
            background-color: #72A499;
            border-color: #72A499;
        }

        .btn-primary:hover {
            background-color: #5e8f84;
            border-color: #5e8f84;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            background-color: #fff;
            color: #212529;
        }

        .form-control:focus {
            border-color: #72A499;
            box-shadow: 0 0 0 0.2rem rgba(114, 164, 153, 0.25);
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c2c7;
            color: #842029;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        a.small {
            color: #72A499;
        }

        a.small:hover {
            text-decoration: underline;
        }
    </style>
@endpush
