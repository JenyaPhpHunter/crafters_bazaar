@extends('layouts.app')

@section('content')
    @if(isset($current_tag))
        <h1 class="mb-4">Товари з тегом <span class="text-primary">#{{ $current_tag }}</span></h1>
    @endif
    <div class="shop-page-modern section section-padding pt-0">

        @include('products.partials.shop-toolbar')

        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">

                    <div class="col-lg-9 col-12 learts-mb-50">
                        @include('products.partials.products-grid')
                    </div>

                    @include('products.partials.shop-sidebar')

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    {{-- Передаємо серверні змінні в JS --}}
    <script>
        window.SHOP_COLS = {{ $current_cols ?? 4 }};
    </script>
    <script src="{{ asset('js/pages/shop-index.js') }}"></script>
@endsection
