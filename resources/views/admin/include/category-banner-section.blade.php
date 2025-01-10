<!-- Category Banner Section Start -->
<div class="section">
    <div class="container">
        <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 learts-mb-n40">
            @foreach($kind_products as $kind_product)
                <div class="col learts-mb-40">
                    <div class="category-banner4">
                        <a href="{{ route('admin_products_kind', ['kind_products' => $kind_product->id]) }}" class="inner">
                        <div class="image"><img src="{{ asset('images/banner/category/banner-s4-1.webp') }}" alt=""></div>
                            <div class="content" data-bg-color="#f4ede7">
                                <h3 class="title">{{ $kind_product->title }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Category Banner Section End -->
