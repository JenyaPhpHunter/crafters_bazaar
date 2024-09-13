@extends('admin.layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Page Title/Header Start -->
    <div class="page-title-section section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 class="title" style="margin-bottom: 0;">Редагування виду товару</h1>
                    </div>
                    <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                        <ul class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_kind_products.index') }}">Види товарів</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_sub_kind_products.index') }}">Підвиди товарів</a></li>
                            <li class="breadcrumb-item active">{{ $kind_product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="col-lg-6 col-12 learts-mb-40">
                <form method="post" action="{{ route('admin_kind_products.update', ['admin_kind_product' => $kind_product->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="color_id" id="selectedColor" value="">

                    <label for="name">Назва</label>
                    <br>
                    <input id="name" name="name" type="text" class="product-title"
                           placeholder="Введіть назву товару" value="{{ old('name', $kind_product->name) }}">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>

                    <button type="submit" name="action" value="save"
                            class="btn btn-dark btn-outline-hover-dark">
                        <i class="fas fa-save"></i> {{ $action_types['save'] }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection



