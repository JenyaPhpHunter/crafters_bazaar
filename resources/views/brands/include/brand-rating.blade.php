<div class="form-group mb-3">
    <label for="rating">Рейтинг</label>

    <div class="form-control bg-light" readonly style="border: 1px solid #ced4da;">
        @php
            $ratingValue = $brand->rating ?? null;
        @endphp

        {{-- Текстове пояснення рейтингу --}}
        <div>
            {!! $ratings[$ratingValue] ?? '<strong>немає відміток рейтингу</strong>' !!}
        </div>

        {{-- Зірки --}}
        <div class="mt-1">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $ratingValue)
                    <i class="fas fa-star text-warning"></i>
                @else
                    <i class="far fa-star text-muted"></i>
                @endif
            @endfor
        </div>
    </div>
</div>
