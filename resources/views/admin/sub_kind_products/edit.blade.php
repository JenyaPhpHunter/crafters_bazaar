@extends('admin.layouts.app')

@section('content')
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="col-lg-6 col-12 learts-mb-40">
                <form method="post" action="{{ route('admin_sub_kind_products.update', ['admin_sub_kind_product' => $sub_kind_product->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <label for="kind_product_id">Вид товару</label>
                    <select id="kind_product_id" name="kind_product_id">
                        @foreach($kind_products as $id => $title)
                            <option value="{{ $id }}" {{ $sub_kind_product->kind_product_id == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    @error('kind_product_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br><br>
                    <label for="title">Назва підвиду товару</label>
                    <input id="title" name="title" type="text" class="sub_category-title"
                           placeholder="Введіть назву підквиду товару" value="{{ old('title', $sub_kind_product->title) }}">
                    @error('title')
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
