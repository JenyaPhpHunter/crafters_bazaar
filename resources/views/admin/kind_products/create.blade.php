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
                    <form method="post" action="{{ route('admin_kind_products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <label for="name">Назва</label>
                        <br>
                        <input id="name" name="name" type="text" class="product-title"
                               placeholder="Введіть назву виду товару" value="{{ old('name') }}">
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
