@if (session('error'))
    <div id="alert-error" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div id="alert-success" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div id="alert-validation" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Додаємо JavaScript --}}
<script>
    setTimeout(() => {
        ['alert-error', 'alert-success', 'alert-validation'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.5s ease-out';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 3000);
</script>

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
