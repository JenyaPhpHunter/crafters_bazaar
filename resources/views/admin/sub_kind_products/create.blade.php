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
