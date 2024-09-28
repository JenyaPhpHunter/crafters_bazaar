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
