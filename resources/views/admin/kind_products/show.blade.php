@extends('admin.layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <div class="category-container" id="category-{{ $kind_product->id }}">
                            <div style="display: flex; align-items: center;"> <!-- Контейнер для категорії та карандаша -->
                                    <span>{{ $kind_product->name }}</span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
