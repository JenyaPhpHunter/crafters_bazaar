<div class="page-title-section section">
    <div class="row">
        <div class="col-6">
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
                    @foreach($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-6">
            <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 20px;">
                @foreach($buttons as $button)
                    <a class="btn btn-primary2" href="{{ $button['route'] }}" style="margin-bottom: 10px;">
                        {{ $button['name'] }}
                        <i class="{{ $button['icon'] }}" style="margin-left: 10px;"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
