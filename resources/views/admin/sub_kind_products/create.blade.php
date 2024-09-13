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
                        <h1 class="title" style="margin-bottom: 0;">Додавання підвиду товару</h1>
                    </div>
                    <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                        <ul class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_kind_products.index') }}">Види товарів</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_sub_kind_products.index') }}">Підвиди товарів</a></li>
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
                <form method="post" action="{{ route('admin_sub_kind_products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label for="kind_product_id">Вид товару</label>
                    <select id="kind_product_id" name="kind_product_id">
                        @foreach($kind_products as $kind_product)
                            <option value="{{ $kind_product->id }}" {{ $selected_kind_product_id == $kind_product->id ? 'selected' : '' }}>
                                {{ $kind_product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kind_product_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br><br>
                    <label for="name">Назва підвиду товару</label>
                    <input id="name" name="name" type="text" class="sub_category-title"
                           placeholder="Введіть назву підквиду товару" value="{{ old('name') }}">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br><br>
                    <button type="submit" name="action" value="save"
                            class="btn btn-dark btn-outline-hover-dark">
                        <i class="fas fa-save"></i> {{ $action_types['save'] }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
