@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати бренд: {{ $brand->title }}</h1>

        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="title">Назва бренду *</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                       id="title" name="title" value="{{ old('title', $brand->title) }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="content">Опис бренду</label>
                <textarea class="form-control @error('content') is-invalid @enderror"
                          id="content" name="content" rows="5">{{ old('content', $brand->content) }}</textarea>
                @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label>Поточне зображення:</label>
                @if($brand->image_path)
                    <img src="{{ asset('storage/' . $brand->image_path) }}" alt="{{ $brand->title }}" class="img-thumbnail mb-2" style="max-height: 200px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                        <label class="form-check-label" for="remove_image">Видалити зображення</label>
                    </div>
                @else
                    <p>Зображення відсутнє</p>
                @endif

                <label for="image" class="mt-2">Нове зображення</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror"
                       id="image" name="image" accept="image/*">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <select name="user_ids[]" multiple class="form-select">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(in_array($user->id, $selectedUsers)) selected @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <select name="rating" class="form-select">
                @foreach($ratings as $key => $value)
                    <option value="{{ $key }}" @if($key == $currentRating) selected @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @if($brand->creator)
                <p><strong>Створено користувачем:</strong> {{ $brand->creator->name }}</p>
            @endif

            <button type="submit" class="btn btn-primary">Оновити</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>
    </div>
@endsection
