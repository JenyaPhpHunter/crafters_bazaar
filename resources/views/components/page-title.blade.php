<div class="page-title-section section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 class="title" style="margin-bottom: 0;">
                            @foreach($breadcrumbs as $item)
                                @if (is_array($item['title']) && count($item['title']) > 0)
                                    {{ count($item['title']) > 1 ? implode(' / ', $item['title']) : $item['title'][0] }}
                                @endif
                            @endforeach
                        </h1>
                </div>
                <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                    <ul class="breadcrumb" style="margin-bottom: 0;">
{{--                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>--}}
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a></li>
{{--                            <li class="breadcrumb-item active">{{ $kind_product->name }}</li>--}}
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
