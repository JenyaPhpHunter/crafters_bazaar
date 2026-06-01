@extends('layouts.app')

@section('title', ($product ? 'Редагувати товар' : 'Додати новий товар') . ' — ' . config('app.name'))

@section('content')
    <div class="product-form-page {{ auth()->id() === 1 ? 'is-admin' : '' }}">
        <div class="section section-fluid section-padding product-form-section">
            <div class="container">
                <div class="product-form-layout">
                    <div class="product-form-left">
                        <div class="product-form-card product-form-media-card">
                            <div class="product-form-card-header">
                                <span class="product-form-kicker">Фото товару</span>
                            </div>
                            @include('products.include.images', [
                                'images' => $images ?? [],
                                'mode'   => 'edit'
                            ])
                        </div>

                        <div class="product-form-card product-form-content-card">
                            <div class="product-form-card-header">
                                <span class="product-form-kicker">Опис</span>
                            </div>
                            @include('products.include.content', ['mode' => 'edit'])
                        </div>

                        <div class="product-form-card product-form-content-card">
                            <div class="product-form-card-header">
                                <span class="product-form-kicker">Теги та соцмережі</span>
                            </div>
                            @include('products.include.tags-social', ['mode' => 'edit'])
                        </div>
                    </div>

                    <div class="product-form-main product-form-card">
                        <div class="product-form-heading">
                            <span class="product-form-kicker">{{ $product ? 'Редагування товару' : 'Новий товар' }}</span>
                            <h1>{{ $product ? 'Редагувати товар' : 'Додати новий товар' }}</h1>
                        </div>

                        <form method="POST"
                              action="{{ $action }}"
                              enctype="multipart/form-data"
                              id="product-form"
                              class="product-form-stack">
                            @csrf

                            @if($method === 'PUT')
                                @method('PUT')
                            @endif

                            <input type="hidden" name="brand_id" id="selectedBrand"
                                   value="{{ old('brand_id') ?? ($product?->brand_id ?? '') }}">
                            <input type="hidden" name="action" id="form-action">
                            <input type="hidden" name="content" id="content-hidden"
                                   value="{{ old('content') ?? ($product?->content ?? '') }}">
                            <input type="hidden" name="tags" id="tags-hidden"
                                   value="{{ old('tags') ?? ($product?->tags ?? '') }}">
                            <input type="hidden" name="social_links" id="social-links-hidden"
                                   value="{{ old('social_links') ?? ($product?->social_links ?? '') }}">
                            @php
                                $mainPhotoIndex = collect($images ?? [])->values()->search(function ($image) {
                                    return !empty($image['is_main']) || !empty($image['main']);
                                });

                                $mainPhotoIndex = $mainPhotoIndex === false ? 0 : $mainPhotoIndex;
                            @endphp

                            <input type="hidden"
                                   name="main_photo_index"
                                   id="main_photo_index"
                                   value="{{ old('main_photo_index', $mainPhotoIndex) }}">

                            <section class="product-form-panel">
                                <div class="product-form-panel-header">
                                    <span class="product-form-kicker">Основне</span>
                                </div>
                                @include('products.include.title-price', ['mode' => 'edit'])
                            </section>

                            <section class="product-form-panel">
                                <div class="product-form-panel-header">
                                    <span class="product-form-kicker">Категорія</span>
                                </div>
                                @include('products.include.kind-subkind', ['mode' => 'edit'])
                            </section>

                            <section class="product-form-panel">
                                <div class="product-form-panel-header">
                                    <span class="product-form-kicker">Виробництво</span>
                                </div>
                                @include('products.include.quantity-produce', ['mode' => 'edit'])
                            </section>

                            <section class="product-form-panel">
                                <div class="product-form-panel-header">
                                    <span class="product-form-kicker">Кольори</span>
                                </div>
                                @include('products.include.colors', ['mode' => 'edit'])
                            </section>

                            <section class="product-form-panel">
                                <div class="product-form-panel-header">
                                    <span class="product-form-kicker">Медіа та бренд</span>
                                </div>
                                @include('products.include.file_upload')
                                @include('products.include.brands', ['mode' => 'edit'])
                            </section>

                            <section class="product-form-actions-panel">
                                @include('products.include.buttons')
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('products.include.modal-kind-subkind')
@endsection

@push('scripts')
    @include('products.partials.scripts')
    @include('products.partials.photoswipe')
@endpush
