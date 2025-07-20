@extends('layouts.app')

@section('content')
    <section class="auth-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h2 class="mb-3">
                                <i class="fas fa-unlock-alt me-2 text-warning"></i>
                                Скидання пароля
                            </h2>
                            <p class="text-muted mb-4">
                                Забули свій пароль? Без проблем. Введіть свою email-адресу, і ми надішлемо вам посилання для скидання.
                            </p>

                            {{-- Session status --}}
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Submit --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Надіслати посилання для скидання
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

        .alert-success {
            background-color: #d1e7dd;
            border-color: #badbcc;
            color: #0f5132;
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
