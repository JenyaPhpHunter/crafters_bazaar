@extends('admin.layouts.app')

@section('content')

    <div class="page-title-section section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 class="title" style="margin-bottom: 0;">Підвиди товарів</h1>
                    </div>
                    <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                        <ul class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_kind_products.index') }}">Види товарів</a></li>
                        </ul>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 20px;">
                        <a class="btn btn-primary2" href="{{ route('admin_kind_products.create') }}" style="margin-bottom: 10px;">Створити вид товару</a>
                        <a class="btn btn-primary2" href="{{ route('admin_sub_kind_products.create') }}" style="margin-bottom: 10px;">Створити підвид товару</a>
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
                        @foreach($kind_products as $kind_product)
                            <div class="category-container" id="category-{{ $kind_product->id }}">
                            <div style="display: flex; align-items: center;"> <!-- Контейнер для категорії та карандаша -->
                                <a href="{{ route('admin_kind_products.show', ['admin_kind_product' => $kind_product->id]) }}">
                                    <span>{{ $kind_product->name }}</span>
                                </a>
                                @isset($user)
                                    @can('edit', $kind_product)
                                        <a href="{{ route('admin_kind_products.edit', ['admin_kind_product' => $kind_product->id]) }}">
                                            &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                        </a>
                                    @endcan
                                @endisset
                            </div>
                            </div>
                            @isset($kind_product->sub_kind_products)
                                @foreach($kind_product->sub_kind_products as $sub_kind_product)
                                    @if($sub_kind_product->kind_product_id == $kind_product->id)
                                        <div style="margin-left: 20px; display: flex; align-items: center;"> <!-- Контейнер для підкатегорії та карандаша -->
                                            <a href="{{ route('admin_sub_kind_products.show', ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                <span> - {{ $sub_kind_product->name }}</span>
                                            </a>
                                            @isset($user)
                                                @can('edit', $kind_product)
                                                    <a href="{{ route('admin_sub_kind_products.edit', ['admin_sub_kind_product' => $sub_kind_product->id]) }}">
                                                        &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                                    </a>
                                                @endcan
                                            @endisset
                                        </div>
                                    @endif
                                @endforeach
                            @endisset
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

