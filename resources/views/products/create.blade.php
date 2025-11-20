@extends('layouts.app')

@section('content')
    <div class="section section-fluid section-padding border-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40 animate__animated animate__slideInRight">
                    @include('products.include.images')
                    @include('products.include.additional-info')
                </div>
                <!-- Product Summery Start -->
                <div class="col-lg-6 col-12 learts-mb-40">
                    <div class="product-summery product-summery-center animate__animated animate__slideInRight">
                        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data" id="product-form" class="animate__animated animate__zoomIn">
                            @csrf
                            <input type="hidden" name="color_id" id="selectedColor" value="">
                            <input type="hidden" name="brand_id" id="selectedBrand" value="">
                            <input type="hidden" name="action" id="form-action" value="">
                            <input type="hidden" name="additional_information" id="additional-info-hidden" value="">
                            <div class="mb-4">
                                @include('products.include.title-price')
                            </div>
                            <div class="mb-4">
                                @include('products.include.kind-subkind')
                            </div>
                            <div class="mb-4">
                                @include('products.include.quantity-produce')
                            </div>
                            <div class="mb-4">
                                @include('products.include.colors')
                            </div>
                            <div class="mb-4">
                                @include('products.include.file_upload')
                            </div>
                            <div class="mb-4">
                                @include('products.include.brands')
                            </div>
                            <div class="mb-4">
                                @include('products.include.tags_social')
                            </div>
                        </form>
                        @isset($user)
                            @if(empty($user->name) || empty($user->surname) || empty($user->email) || empty($user->phone))
                                <div class="alert alert-warning alert-dismissible fade show mt-4 animate__animated animate__bounceIn" role="alert">
                                    <div class="col-auto learts-mb-20">
                                        <a href="{{ route('users.show', ['user' => $user->id]) }}#account-info"
                                           class="btn btn-secondary">Перейти в профіль</a>
                                    </div>
                                    <p>Перед тим як виставити товар на продаж, збережіть цей товар та заповніть
                                        обов'язкові поля у своєму профілі.</p>
                                </div>
                            @endif
                        @endisset
                    </div>
                </div>
                <!-- Product Summery End -->
            </div>
            <!-- Додаємо кнопки після обох колонок, по центру -->
            <div class="product-buttons-centered animate__animated animate__fadeInUp">
                @include('products.include.buttons')
            </div>
        </div>
    </div>

{{--    @include('products.include.product-info-tabs')--}}
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/5.4.4/photoswipe.min.css">
@endpush

@push('scripts')
    <script src="{{ asset('js/modules/dropdown.js') }}"></script>
    <script src="{{ asset('js/modules/product/create-edit.js') }}"></script>
@endpush
