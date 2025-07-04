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

            <label for="invited_emails">Запросити користувачів (Email-адреси через кому)</label>
            <textarea name="invited_emails" id="invited_emails" class="form-control" rows="3" placeholder="user1@example.com, user2@example.com">{{ old('invited_emails') }}</textarea>
            @error('invited_emails')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @if($brand->invitations->count())
                <div class="mt-4">
                    <h5>Запрошені користувачі:</h5>
                    <ul>
                        @foreach($brand->invitations as $invitation)
                            <li>
                                {{ $invitation->email }}
                                @if($invitation->accepted_at)
                                    <span class="text-success">(прийняв запрошення)</span>
                                @else
                                    <span class="text-muted">(очікує)</span>
                                    @if($invitation->resent_count > 0)
                                        <span class="badge bg-warning text-dark">повторно: {{ $invitation->resent_count }} раз(ів)</span>
                                    @endif
                                    <span class="text-secondary ms-2">останнє: {{ $invitation->last_sent_at?->format('d.m.Y H:i') }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @if($brand->creator)
                <p><strong>Створено користувачем:</strong> {{ $brand->creator->name }}</p>
            @endif

            <button type="submit" class="btn btn-primary">Оновити</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>

        @if($brand->users->count())
            <div class="mt-4">
                <h4>Користувачі бренду:</h4>
                <ul class="list-group">
                    @foreach($brand->users as $user)
                        <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @include('brands.include.image_modal')
@endsection
