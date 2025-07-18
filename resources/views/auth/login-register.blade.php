@extends('layouts.app')

@section('content')
    <section class="auth-wrapper">
    <div class="container">
            <div class="row g-4">
                {{-- Логін --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0" id="login-card">
                    <div class="card-body p-5">
                        <h2 class="mb-3">
                            <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                            Авторизація
                        </h2>
                        <p class="text-muted mb-4">Чудово, що ви повернулись!</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="login-email" class="form-label">Email</label>
                                    <input id="login-email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="login-password" class="form-label">Пароль</label>
                                    <input id="login-password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Remember + Forgot --}}
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Запам'ятати мене</label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="small">Забули пароль?</a>
                                    @endif
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Увійти</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Реєстрація --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0" id="register-card">
                    <div class="card-body p-5">
{{--                            <h2 class="mb-3">Реєстрація</h2>--}}
                        <h2 class="mb-3">
                            <i class="fas fa-user-plus me-2 text-success"></i>
                            Реєстрація
                        </h2>

                        <p class="text-muted mb-4">Якщо не маєш аккаунта — зареєструйся :)</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label for="register-name" class="form-label">Ім'я</label>
                                    <input id="register-name" type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="register-email" class="form-label">Email</label>
                                    <input id="register-email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="mb-3">
                                    <label for="register-phone" class="form-label">Телефон</label>
                                    <input id="register-phone" type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="register-password" class="form-label">Пароль</label>
                                    <input id="register-password" type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-3">
                                    <label for="register-password-confirm" class="form-label">Повторіть пароль</label>
                                    <input id="register-password-confirm" type="password" name="password_confirmation"
                                           class="form-control" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Зареєструватись</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginCard = document.getElementById('login-card');
            const registerCard = document.getElementById('register-card');

            function activate(cardToActivate, cardToDeactivate) {
                cardToActivate.classList.remove('inactive');
                cardToDeactivate.classList.add('inactive');
            }

            // Початковий стан: активна форма логіну
            activate(loginCard, registerCard);

            loginCard.addEventListener('click', () => activate(loginCard, registerCard));
            registerCard.addEventListener('click', () => activate(registerCard, loginCard));
        });
    </script>
@endpush

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
        }

        section.auth-wrapper {
            padding: 0.5rem 0;
        }

        .card-body {
            padding: 0.5rem 0.5rem;
        }

        .card {
            background-color: #ffffff;
            border-radius: 1rem;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .inactive {
            opacity: 0.5;
            transform: scale(0.95);
            cursor: pointer;
            pointer-events: auto;
        }

        .card:hover.inactive {
            opacity: 0.65;
        }

        .inactive form * {
            pointer-events: none;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #72A499; /* Акцент кольору */
        }

        label {
            font-weight: 500;
            color: #495057;
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

        .btn-primary {
            background-color: #72A499;
            border-color: #72A499;
        }

        .btn-primary:hover {
            background-color: #5e8f84;
            border-color: #5e8f84;
        }

        .btn-success {
            background-color: #60b391;
            border-color: #60b391;
        }

        .btn-success:hover {
            background-color: #4b987a;
            border-color: #4b987a;
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

        .form-check-label {
            color: #495057;
        }

        .form-check-input:checked {
            background-color: #72A499;
            border-color: #72A499;
        }
    </style>
@endpush



