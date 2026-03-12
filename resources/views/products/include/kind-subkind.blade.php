{{-- ВИД ТОВАРУ --}}
<div class="mb-4">
    <div class="form-section animate__animated animate__fadeIn">
        <label class="form-label {{ $selected_kind_product_id ? 'label-focused' : '' }}">
            <span class="animate__animated animate__fadeIn">Вид товару</span>
        </label>
        <div class="custom-dropdown-wrapper">
            <div class="custom-dropdown" data-name="kind">
                <input type="text" class="dropdown-search" placeholder="Пошук виду...">

                <div class="dropdown-selected {{ $selected_kind_product_id ? 'selected-value' : '' }}" tabindex="0">
                    <span class="selected-text">
                        @if($selected_kind_product_id)
                            {{ $kindProducts->find($selected_kind_product_id)?->title ?? 'Оберіть вид товару' }}
                        @else
                            Оберіть вид товару
                        @endif
                    </span>
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
                <input type="hidden" name="kind_product_id" value="{{ $selected_kind_product_id ?? '' }}">
            </div>

            <div class="kind-actions">
                <button type="button" class="btn btn-add open-kind-modal"
                        data-bs-toggle="modal" data-bs-target="#kindSubkindModal"
                        data-mode="kind">
                    <i class="fas fa-plus-circle"></i> Додати вид
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ПІДВИД ТОВАРУ --}}
<div class="mb-4">
    <div class="form-section animate__animated animate__fadeIn">
        <label class="form-label {{ $selected_sub_kind_product_id ? 'label-focused' : '' }}">
            <span class="animate__animated animate__fadeIn">Підвид товару</span>
        </label>
        <div class="custom-dropdown-wrapper">
            <div class="custom-dropdown" data-name="subkind">
                <input type="text" class="dropdown-search" placeholder="Пошук підвиду...">

                <div class="dropdown-selected {{ $selected_sub_kind_product_id ? 'selected-value' : '' }}" tabindex="0">
                    <span class="selected-text">
                        @if($selected_sub_kind_product_id)
                            {{ $subKindProducts->find($selected_sub_kind_product_id)?->title ?? 'Оберіть підвид товару' }}
                        @else
                            Оберіть підвид товару
                        @endif
                    </span>
                </div>

                <ul class="dropdown-options">
                    @foreach($subKindProducts as $subkind)
                        <li data-value="{{ $subkind->id }}"
                            data-title="{{ $subkind->title }}"
                            data-kind="{{ $subkind->kind_product_id }}"
                            @if($selected_kind_product_id && $subkind->kind_product_id != $selected_kind_product_id)
                                style="display:none"
                            @endif>
                            <i class="fas fa-layer-group"></i> {{ $subkind->title }}
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="sub_kind_product_id" value="{{ $selected_sub_kind_product_id ?? '' }}">
            </div>

            <div class="kind-actions">
                <button type="button" class="btn btn-add open-subkind-modal"
                        data-bs-toggle="modal" data-bs-target="#kindSubkindModal"
                        data-mode="subkind">
                    <i class="fas fa-plus-circle"></i> Додати підвид
                </button>
            </div>
        </div>
    </div>
</div>
