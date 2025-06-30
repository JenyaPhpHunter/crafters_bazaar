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
                <label for="image" class="form-label">Логотип бренду</label>

                <div class="row align-items-center">
                    @if($brand->image_path)
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $brand->image_path) }}"
                                 alt="{{ $brand->title }}"
                                 class="img-fluid mb-2"
                                 style="max-height: 200px;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal"
                                 onclick="showImageModal('{{ asset('storage/' . $brand->image_path) }}')">
                        </div>
                    @endif

                    <div class="col-md-6">
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/*">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($brand->image_path)
                            <div class="alert alert-warning mt-2 p-2">
                                ⚠️ Нове зображення повністю видалить поточне зображення.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @include('brands.include.brand-rating', ['ratingValue' => $brand->rating, 'ratings' => config('others.rating')])

        @if($brand->creator)
                <p><strong>Створено користувачем:</strong> {{ $brand->creator->name }}</p>
            @endif

            <button type="submit" class="btn btn-primary">Оновити</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>
    </div>

    @include('brands.include.image_modal')
@endsection
