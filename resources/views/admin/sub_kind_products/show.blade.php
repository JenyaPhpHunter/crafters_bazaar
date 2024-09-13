@extends('admin.layouts.app')

@section('content')

    <div class="page-title-section section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 class="title" style="margin-bottom: 0;">Перегляд підвиду товарів</h1>
                    </div>
                    <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                        <ul class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_kind_products.index') }}">Види товарів</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_sub_kind_products.index') }}">Підвиди товарів</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_kind_products.show', ['admin_kind_product' => $sub_kind_product->kind_product->id]) }}">{{ $sub_kind_product->kind_product->name }}</a></li>
                            <li class="breadcrumb-item active">{{ $sub_kind_product->name }}</li>
                        </ul>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 20px;">
                        <a class="btn btn-primary2" href="{{ route('products.create', ['sub_kind_product_id' => $sub_kind_product->id]) }}" style="margin-bottom: 10px;">Створити товар</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <div class="category-container" id="category-{{ $sub_kind_product->id }}">
                            <div style="display: flex; align-items: center;"> <!-- Контейнер для категорії та карандаша -->
                                <span>{{ $sub_kind_product->name }}</span>
                                @isset($user)
                                    @can('edit', $sub_kind_product->kind_product)
                                        <a href="{{ route('admin_sub_kind_products.edit', ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                            <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                        </a>
                                    @endcan
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
