@extends('layouts.app')

@php
    $brandImageUrl = $brand->image_path
        ? asset('storage/' . $brand->image_path)
        : asset('images/brands/brand-1.webp');
@endphp

@section('title', $brand->title . ' - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/brand.css') }}">
@endpush

@section('content')
    <div class="brand-workspace brand-show-workspace section section-fluid section-padding border-bottom animate__animated animate__fadeIn"
         data-brand-id="{{ $brand->id }}">
        <div class="container">
            @if($isInvited)
                <div class="brand-invite-banner">
                    <div>
                        <strong>Вас запрошено до цього бренду.</strong>
                        <span>Після приєднання ви зможете продавати вироби під цим брендом.</span>
                    </div>
                    <form action="{{ route('brands.join', $brand) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus"></i>
                            Доєднатися
                        </button>
                    </form>
                </div>
            @endif

            <div class="row align-items-start">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <div class="brand-visual-panel">
                        <div class="brand-visual-stage">
                            <img src="{{ $brandImageUrl }}"
                                 alt="{{ $brand->title }}"
                                 class="brand-logo-preview"
                                 @if($brand->image_path)
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     onclick="showImageModal('{{ $brandImageUrl }}')"
                                 @endif>
                        </div>

                        <div class="brand-visual-caption">
                            <span class="brand-kicker">Бренд</span>
                            <h1>{{ $brand->title }}</h1>
                            <p>{{ $brand->content ?: 'Опис відсутній' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="brand-form-main brand-view-main">
                        <div class="brand-form-header">
                            <span class="brand-kicker">Профіль бренду</span>
                            <h2>{{ $brand->title }}</h2>
                        </div>

                        <div class="brand-description-panel">
                            <span class="brand-panel-label">Опис</span>
                            <p>{{ $brand->content ?: 'Опис відсутній' }}</p>
                        </div>

                        <div class="brand-side-panel">
                            @include('brands.include.brand-rating', ['ratingValue' => $brand->rating, 'ratings' => config('others.rating')])
                            @include('brands.include.brand-users-and-invitations')
                        </div>

                        @can('update', $brand)
                            <form action="{{ route('brands.invite', $brand->id) }}" method="POST" class="brand-invite-panel">
                                @csrf
                                @include('brands.include.invite-form')
                                <button type="submit" class="btn btn-outline-primary brand-outline-action">
                                    <i class="fas fa-paper-plane"></i>
                                    Надіслати запрошення
                                </button>
                            </form>
                        @endcan

                        @if(request()->has('email') && auth()->check() && auth()->user()->email === request()->query('email') && !$brand->users->contains(auth()->id()))
                            <form action="{{ route('brands.join', $brand) }}" method="POST" class="brand-join-panel">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus"></i>
                                    Приєднатися до бренду
                                </button>
                            </form>
                        @endif

                        <div class="brand-actions brand-view-actions">
                            <a href="{{ route('brands.index') }}" class="btn btn-secondary brand-secondary-action">
                                <i class="fas fa-arrow-left"></i>
                                До списку
                            </a>

                            @can('update', $brand)
                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-primary brand-primary-action">
                                    <i class="fas fa-edit"></i>
                                    Редагувати
                                </a>
                            @endcan

                            @if(auth()->check() && $brand->users->contains(auth()->id()) && $brand->invitations->count() && auth()->id() !== $brand->creator_id)
                                <form action="{{ route('brands.leave', $brand) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger brand-danger-action">
                                        Покинути бренд
                                    </button>
                                </form>
                            @endif

                            @can('delete', $brand)
                                <button class="btn btn-outline-danger brand-danger-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal">
                                    <i class="fas fa-trash-alt"></i>
                                    Видалити
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            @include('include.prefooter', ['object' => $brand])
        </div>

        <form id="remove-user-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <form id="cancel-invitation-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @include('brands.include.image_modal')
    @include('brands.include.confirm_delete_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/brand/form.js') }}"></script>
@endpush
