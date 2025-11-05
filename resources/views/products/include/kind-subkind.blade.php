<div class="form-section animate__animated animate__fadeIn">
    <label for="kind_product_search" class="form-label">
        <span class="animate__animated animate__fadeIn">Вид товару</span>
    </label>
    <div class="custom-dropdown-wrapper">
        <div class="custom-dropdown" data-name="kind">
            <input type="text" class="dropdown-search" id="kind_product_search" placeholder="Пошук виду..." />
            <div class="dropdown-selected" tabindex="0" id="kind_product_selected" data-value="{{ old('kind_product_id') ?? '' }}">Оберіть вид товару</div>
            <ul class="dropdown-options">
                @foreach($kindProducts as $kind)
                    <li data-value="{{ $kind->id }}" data-title="{{ $kind->title }}">
                        <i class="fas fa-box-open"></i> {{ $kind->title }}
                    </li>
                @endforeach
            </ul>
            <input type="hidden" name="kind_product_id" id="kind_product_id" value="{{ old('kind_product_id') ?? '' }}">
        </div>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-add animate__animated animate__pulse">
            <i class="fas fa-plus-circle"></i> Додати вид
        </a>
    </div>
</div>

<div class="form-section animate__animated animate__fadeIn">
    <label for="sub_kind_product_search" class="form-label">
        <span class="animate__animated animate__fadeIn">Підвид товару</span>
    </label>
    <div class="custom-dropdown-wrapper">
        <div class="custom-dropdown" data-name="subkind">
            <input type="text" class="dropdown-search" id="sub_kind_product_search" placeholder="Пошук підвиду..." />
            <div class="dropdown-selected" tabindex="0" id="sub_kind_product_selected" data-value="{{ old('sub_kind_product_id') ?? '' }}">Оберіть підвид товару</div>
            <ul class="dropdown-options">
                @foreach($subKindProducts as $subkind)
                    <li data-value="{{ $subkind->id }}" data-title="{{ $subkind->title }}">
                        <i class="fas fa-layer-group"></i> {{ $subkind->title }}
                    </li>
                @endforeach
            </ul>
            <input type="hidden" name="sub_kind_product_id" id="sub_kind_product_id" value="{{ old('sub_kind_product_id') ?? '' }}">
        </div>
        <a href="{{ route('products.createkindsubkind', ['id' => $productId ?? 0]) }}" class="btn btn-add animate__animated animate__pulse">
            <i class="fas fa-plus-circle"></i> Додати підвид
        </a>
    </div>
</div>
