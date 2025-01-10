@extends('admin.layouts.app')

@section('content')
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="col-lg-6 col-12 learts-mb-40">
                    <form method="post" action="{{ route('admin_kind_products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <label for="title">Назва</label>
                        <br>
                        <input id="title" name="title" type="text" class="product-title"
                               placeholder="Введіть назву виду товару" value="{{ old('title') }}">
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
