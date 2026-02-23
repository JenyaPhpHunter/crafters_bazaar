@if (!empty($breadcrumbs))
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb mb-0">
            @foreach ($breadcrumbs as $index => $breadcrumb)
                <li class="breadcrumb-item" style="--i: {{ $index }}">
                    @if (!empty($breadcrumb->url) && !$loop->last)
                        <a href="{{ $breadcrumb->url }}" class="breadcrumb-link">
                            {{ $breadcrumb->title }}
                        </a>
                    @else
                        <span class="breadcrumb-active">
                            {{ $breadcrumb->title }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
