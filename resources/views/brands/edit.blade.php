@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Редагувати бренд: {{ $brand->title }}</h1>
            </div>
            <form id="brand-update-form" action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
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

                    @include('brands.include.brand-users-and-invitations')

                    <div class="mt-5">
                        @include('brands.include.invite-form')
                    </div>

                    <button type="submit" class="btn btn-primary">Оновити</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-secondary">Скасувати</a>
                </div>
            </form>
            {{-- Форма для видалення користувача --}}
            <form id="remove-user-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            {{-- Форма для скасування запрошення --}}
            <form id="cancel-invitation-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            @include('include.prefooter', ['object' => $brand])
            @include('brands.include.image_modal')

            @foreach($brand->invitations as $invitation)
                @if($invitation->accepted_at === null && auth()->user()?->id === $brand->creator_id)
                    <form id="cancel-invitation-{{ $invitation->id }}"
                          action="{{ route('brands.cancelInvitation', [$brand, $invitation]) }}"
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            @endforeach

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function submitRemoveUser(userId) {
            if (!confirm('Ви впевнені, що хочете видалити цього користувача з бренду?')) return;

            const form = document.getElementById('remove-user-form');
            form.action = `/brands/{{ $brand->id }}/users/${userId}`;
            form.submit();
        }

        function submitCancelInvitation(invitationId) {
            if (!confirm('Скасувати запрошення?')) return;

            const form = document.getElementById('cancel-invitation-form');
            form.action = `/brands/{{ $brand->id }}/invitations/${invitationId}`;
            form.submit();
        }
    </script>
@endpush
