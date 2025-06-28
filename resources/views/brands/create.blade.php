@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Створити новий бренд</h1>

        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="title">Назва бренду *</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                       id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="content">Опис бренду</label>
                <textarea class="form-control @error('content') is-invalid @enderror"
                          id="content" name="content" rows="5">{{ old('content') }}</textarea>
                @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="image">Логотип бренду</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror"
                       id="image" name="image" accept="image/*">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="invited_emails">Запросити користувачів (Email-адреси через кому)</label>
            <textarea name="invited_emails" id="invited_emails" class="form-control" rows="3" placeholder="user1@example.com, user2@example.com">{{ old('invited_emails') }}</textarea>
            @error('invited_emails')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary">Створити</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>
    </div>
@endsection
