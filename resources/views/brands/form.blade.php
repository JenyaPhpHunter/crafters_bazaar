@extends('layouts.app')

@php
    $isEdit = isset($brand) && $brand?->exists;
    $brandTitle = old('title', $brand?->title);
    $brandContent = old('content', $brand?->content);
    $brandImageUrl = $isEdit && $brand->image_path
        ? asset('storage/' . $brand->image_path)
        : asset('images/brands/brand-1.webp');
@endphp

@section('title', ($isEdit ? 'Редагувати бренд' : 'Створити бренд') . ' - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/brand.css') }}">
@endpush

@section('content')
    <div class="brand-workspace brand-form-workspace section section-fluid section-padding border-bottom animate__animated animate__fadeIn"
         data-brand-id="{{ $brand?->id }}">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <div class="brand-visual-panel">
                        <div class="brand-visual-stage">
                            <img src="{{ $brandImageUrl }}"
                                 alt="{{ $brandTitle ?: 'Логотип бренду' }}"
                                 class="brand-logo-preview"
                                 data-brand-logo-preview
                                 @if($isEdit && $brand->image_path)
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     onclick="showImageModal('{{ $brandImageUrl }}')"
                                 @endif>
                        </div>

                        <div class="brand-visual-caption">
                            <span class="brand-kicker">{{ $isEdit ? 'Редагування бренду' : 'Новий бренд' }}</span>
                            <h1 data-brand-title-preview>{{ $brandTitle ?: 'Назва бренду' }}</h1>
                            <p data-brand-content-preview>{{ $brandContent ?: 'Короткий опис бренду зʼявиться тут під час заповнення форми.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="brand-form-main">
                        <form id="brand-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if($method === 'PUT')
                                @method('PUT')
                            @endif

{{--                            <div class="brand-form-header">--}}
{{--                                <span class="brand-kicker">{{ $isEdit ? 'Оновлення' : 'Створення' }}</span>--}}
{{--                                <h2>{{ $isEdit ? 'Дані бренду' : 'Створити бренд' }}</h2>--}}
{{--                            </div>--}}

                            <div class="brand-field">
                                <label for="title" class="form-label">Назва бренду *</label>
                                <input type="text"
                                       class="form-control brand-input @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ $brandTitle }}"
                                       data-brand-title-input
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="brand-field">
                                <label for="content" class="form-label">Опис бренду</label>
                                <div class="brand-textarea-wrap">
                                    <textarea class="form-control brand-textarea @error('content') is-invalid @enderror"
                                              id="content"
                                              name="content"
                                              rows="7"
                                              data-brand-content-input>{{ $brandContent }}</textarea>
                                </div>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="brand-field">
                                <label for="image" class="form-label">Логотип бренду</label>
                                <div class="brand-logo-upload">
                                    <input type="file"
                                           class="brand-logo-input @error('image') is-invalid @enderror"
                                           id="image"
                                           name="image"
                                           accept="image/*"
                                           data-brand-logo-input>
                                    <label for="image" class="brand-logo-upload-label">
                                        <i class="fas fa-image"></i>
                                        <span data-brand-file-label>Вибрати зображення</span>
                                    </label>
                                    @if($isEdit && $brand->image_path)
                                        <small>Нове зображення замінить поточний логотип.</small>
                                    @else
                                        <small>Підійде квадратне або вертикальне зображення.</small>
                                    @endif
                                </div>
                                @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($isEdit)
                                <div class="brand-side-panel">
                                    @include('brands.include.brand-rating', ['ratingValue' => $brand->rating, 'ratings' => config('others.rating')])
                                    @include('brands.include.brand-users-and-invitations')
                                </div>
                            @endif

                            <div class="brand-invite-panel">
                                @include('brands.include.invite-form')
                            </div>

                            <div class="brand-actions">
                                <button type="submit" class="btn btn-primary brand-primary-action">
                                    <i class="fas fa-check"></i>
                                    {{ $isEdit ? 'Оновити бренд' : 'Створити бренд' }}
                                </button>
                                <a href="{{ route('brands.index') }}" class="btn btn-secondary brand-secondary-action">
                                    Скасувати
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if($isEdit)
                <form id="remove-user-form" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                <form id="cancel-invitation-form" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

                @include('include.prefooter', ['object' => $brand])
                @include('brands.include.image_modal')
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modules/brand/form.js') }}"></script>
@endpush
