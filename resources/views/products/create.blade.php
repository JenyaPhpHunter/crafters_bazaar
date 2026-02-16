@extends('layouts.app')

@section('content')
    <body class="{{ auth()->id() === 2 ? 'is-admin' : '' }}">

    <div class="section section-fluid section-padding border-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">

                {{-- ЛІВА КОЛОНКА — ФОТО --}}
                <div class="col-lg-6 col-12 mb-5">
                    @include('products.include.images')
                    @include('products.include.content')
                    @include('products.include.tags-social')
                </div>

                {{-- ПРАВА КОЛОНКА --}}
                <div class="col-lg-6 col-12">

                    {{-- ВЕРХНІ ПОЛЯ — ВИСОТА = ФОТО --}}
                    <div class="product-form-main">

                        <form method="post"
                              action="{{ route('products.store') }}"
                              enctype="multipart/form-data"
                              id="product-form">
                            @csrf

                            {{-- hidden --}}
{{--                            <input type="hidden" name="color_id" id="selectedColor">--}}
                            <input type="hidden" name="brand_id" id="selectedBrand">
                            <input type="hidden" name="action" id="form-action">
                            <input type="hidden" name="content" id="content-hidden">
                            <input type="hidden" name="tags" id="tags-hidden">
                            <input type="hidden" name="social_links" id="social-links-hidden">
                            <input type="hidden" name="main_photo_index" id="main_photo_index" value="0">

                            {{-- Назва + ціна --}}
                            @include('products.include.title-price')

                            {{-- Вид / підвид --}}
                            @include('products.include.kind-subkind')

                            {{-- Кількість --}}
                            @include('products.include.quantity-produce')

                            {{-- Кольори --}}
                            @include('products.include.colors')
                            {{-- НИЖНІ БЛОКИ — ПОЗА ВИСОТОЮ ФОТО --}}
                            <div class="product-form-secondary">

                                @include('products.include.file_upload')

                                @include('products.include.brands')

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
@endsection

@push('scripts')
    @include('products.partials.scripts')
    @include('products.partials.photoswipe')
@endpush
