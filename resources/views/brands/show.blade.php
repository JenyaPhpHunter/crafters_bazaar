@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{ $brand->title }}</h1>
            </div>
            @if($isInvited)
                <div class="alert alert-info mt-3">
                    <strong>
                        Вас запрошено до цього бренду.
                        Ви ще не приєдналися. Перевірте свою пошту або натисніть кнопку нижче, щоб приєднатися.
                    </strong>
                </div>
            @endif
            <br>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="content">Опис</label>

                    <div class="form-control bg-light" readonly style="border: 1px solid #ced4da;">
                        <div>
                            {{ $brand->content ?? 'Опис відсутній' }}
                        </div>
                    </div>
                </div>
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

                @include('brands.include.brand-users-and-invitations')

                @can('update', $brand)
                    <div class="mt-5">
                        <form action="{{ route('brands.invite', $brand->id) }}" method="POST">
                            @csrf

                            @include('brands.include.invite-form')

                            <button type="submit" class="btn btn-outline-primary">Надіслати запрошення</button>
                        </form>
                    </div>
                @endcan
                <br>
                @if(request()->has('email') && auth()->check() && auth()->user()->email === request()->query('email') && !$brand->users->contains(auth()->id()))
                    <form action="{{ route('brands.join', $brand) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success">Приєднатися до бренду</button>
                    </form>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> До списку
                    </a>
                    @if(auth()->check() && $brand->users->contains(auth()->id()) && $brand->invitations->count() && auth()->id() !== $brand->creator_id))
                        <form action="{{ route('brands.leave', $brand) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Покинути бренд</button>
                        </form>
                    @endif
                @if($isInvited)
                    <form action="{{ route('brands.join', $brand) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="alert alert-info d-flex justify-content-between align-items-center py-2 px-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus me-1"></i> Доєднатися до бренду
                            </button>
                            <small class="text-dark ms-3">
                                Ви зможете продавати вироби під цим брендом
                            </small>
                        </div>
                    </form>
                @endif

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
            @include('include.prefooter', ['object' => $brand])
        </div>
    </div>
    <form id="remove-user-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="cancel-invitation-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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

    @include('brands.include.image_modal')
    @include('brands.include.confirm_delete_modal')
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

