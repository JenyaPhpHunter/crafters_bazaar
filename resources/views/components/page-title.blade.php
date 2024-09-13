<div class="page-title-section section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                    @if(function)
                        <h1 class="title" style="margin-bottom: 0;">{{ $title }}</h1>
                    @else

                    @endif
                </div>
                <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                    <ul class="breadcrumb" style="margin-bottom: 0;">
                        {{ $slot }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
