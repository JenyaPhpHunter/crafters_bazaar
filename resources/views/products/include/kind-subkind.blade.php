{{-- ВИД ТОВАРУ --}}
<div class="mb-4">
    <div class="form-section animate__animated animate__fadeIn">
        <label class="form-label">
            <span class="animate__animated animate__fadeIn">Вид товару</span>
        </label>
        <div class="custom-dropdown-wrapper">
            <div class="custom-dropdown" data-name="kind">
                <input type="text" class="dropdown-search" placeholder="Пошук виду...">

                <div class="dropdown-selected" tabindex="0">
                    <span class="selected-text">Оберіть вид товару</span>
                    <button type="button" class="clear-selection" aria-label="Очистити">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <ul class="dropdown-options">
                    @foreach($kindProducts as $kind)
                        <li data-value="{{ $kind->id }}" data-title="{{ $kind->title }}">
                            <i class="fas fa-box-open"></i> {{ $kind->title }}
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="kind_product_id" value="{{ old('kind_product_id') ?? '' }}">
            </div>

            <div class="kind-actions">
                <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-add">
                    <i class="fas fa-plus-circle"></i> Додати вид
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ПІДВИД ТОВАРУ --}}
<div class="mb-4">
    <div class="form-section animate__animated animate__fadeIn">
        <label class="form-label">
            <span class="animate__animated animate__fadeIn">Підвид товару</span>
        </label>
        <div class="custom-dropdown-wrapper">
            <div class="custom-dropdown" data-name="subkind">
                <input type="text" class="dropdown-search" placeholder="Пошук підвиду...">

                <div class="dropdown-selected" tabindex="0">
                    <span class="selected-text">Оберіть підвид товару</span>
                </div>

                <ul class="dropdown-options">
                    @foreach($subKindProducts as $subkind)
                        <li data-value="{{ $subkind->id }}" data-title="{{ $subkind->title }}" data-kind="{{ $subkind->kind_product_id }}">
                            <i class="fas fa-layer-group"></i> {{ $subkind->title }}
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="sub_kind_product_id" value="{{ old('sub_kind_product_id') ?? '' }}">
            </div>

            <div class="kind-actions">
                <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-add">
                    <i class="fas fa-plus-circle"></i> Додати підвид
                </a>
            </div>
        </div>
    </div>
</div>
