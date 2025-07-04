@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{ $brand->title }}</h1>
            </div>

            <div class="card-body">
                @if($brand->image_path)
                    <img src="{{ asset('storage/' . $brand->image_path) }}"
                         alt="{{ $brand->title }}"
                         class="img-fluid mb-4"
                         style="max-height: 300px; cursor: pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         onclick="showImageModal('{{ asset('storage/' . $brand->image_path) }}')">
                @endif

                @include('brands.include.brand-rating', ['ratingValue' => $brand->rating, 'ratings' => config('others.rating')])

                @if($brand->creator)
                    <p><strong>Створено користувачем:</strong> {{ $brand->creator->name }}</p>
                @endif

                @can('update', $brand)
                    <div class="mt-5">
                        <h4>Запросити нових користувачів до бренду</h4>
                        <form action="{{ route('brands.invite', $brand->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="invited_emails">Email-адреси через кому</label>
                                <textarea name="invited_emails" id="invited_emails" class="form-control" rows="3" placeholder="user1@example.com, user2@example.com">{{ old('invited_emails') }}</textarea>
                                @error('invited_emails')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Надіслати запрошення</button>
                        </form>
                    </div>
                @endcan

                @if(request()->has('email') && auth()->check() && auth()->user()->email === request()->query('email') && !$brand->users->contains(auth()->id()))
                    <form action="{{ route('brands.join', $brand) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success">Приєднатися до бренду</button>
                    </form>
                @endif

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
                @can('update', $brand)
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
                @endcan


                <div class="mb-4">
                    <h4>Опис:</h4>
                    <p>{{ $brand->content ?? 'Опис відсутній' }}</p>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> До списку
                    </a>

                    @can('delete', $brand)
                        <!-- Кнопка відкриття модалки -->
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                            <i class="fas fa-trash-alt"></i> Видалити
                        </button>
                    @endcan

                    @can('update', $brand)
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card-footer text-muted">
                Створено: {{ $brand->created_at->format('d.m.Y H:i') }} |
                Оновлено: {{ $brand->updated_at->format('d.m.Y H:i') }}
            </div>
        </div>
    </div>

    @include('brands.include.image_modal')

@endsection
