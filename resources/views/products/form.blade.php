@extends('layouts.app')

@section('title', ($product ? 'Редагувати товар' : 'Додати новий товар') . ' — ' . config('app.name'))

@section('content')
    <body class="{{ auth()->id() === 2 ? 'is-admin' : '' }}">

    <div class="section section-fluid section-padding border-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">

                {{-- ЛІВА КОЛОНКА — ФОТО + ОПИС + ТЕГИ --}}
                <div class="col-lg-6 col-12 mb-5">
                    @include('products.include.images', [
                        'images' => $images ?? [],
                        'mode'   => 'edit'
                    ])

                    @include('products.include.content', ['mode' => 'edit'])
                    @include('products.include.tags-social', ['mode' => 'edit'])
                </div>

                {{-- ПРАВА КОЛОНКА --}}
                <div class="col-lg-6 col-12">

                    <div class="product-form-main">

                        <form method="POST"
                              action="{{ $action }}"
                              enctype="multipart/form-data"
                              id="product-form">
                            @csrf

                            @if($method === 'PUT')
                                @method('PUT')
                            @endif

                            {{-- hidden fields --}}
                            <input type="hidden" name="brand_id" id="selectedBrand"
                                   value="{{ old('brand_id') ?? ($product?->brand_id ?? '') }}">
                            <input type="hidden" name="action" id="form-action">
                            <input type="hidden" name="content" id="content-hidden"
                                   value="{{ old('content') ?? ($product?->content ?? '') }}">
                            <input type="hidden" name="tags" id="tags-hidden"
                                   value="{{ old('tags') ?? ($product?->tags ?? '') }}">
                            <input type="hidden" name="social_links" id="social-links-hidden"
                                   value="{{ old('social_links') ?? ($product?->social_links ?? '') }}">
                            <input type="hidden" name="main_photo_index" id="main_photo_index" value="0">

                            {{-- Назва + ціна --}}
                            @include('products.include.title-price', ['mode' => 'edit'])

                            {{-- Вид / підвид --}}
                            @include('products.include.kind-subkind', ['mode' => 'edit'])

                            {{-- Кількість --}}
                            @include('products.include.quantity-produce', ['mode' => 'edit'])

                            {{-- Кольори --}}
                            @include('products.include.colors', ['mode' => 'edit'])

                            {{-- Нижня частина --}}
                            <div class="product-form-secondary">
                                @include('products.include.file_upload')
                                @include('products.include.brands', ['mode' => 'edit'])

                                <div class="product-buttons-centered">
                                    @include('products.include.buttons')
                                </div>
                            </div>
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
