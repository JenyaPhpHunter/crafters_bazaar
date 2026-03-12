<!-- Модальне вікно для додавання виду / підвиду -->
<div class="modal fade" id="kindSubkindModal" tabindex="-1" aria-labelledby="kindSubkindModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kindSubkindModalLabel">Додати новий вид / підвид</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="kindSubkindForm" method="POST" action="{{ route('products.storekindsubkind') }}">
                @csrf
                <div class="modal-body">

                    <div class="alert alert-info small" id="modeDescription">
                        Оберіть існуючий вид або створіть новий, потім введіть назву підвиду.
                    </div>

                    <!-- Вид товару -->
                    <div class="kind-section">
                        <label class="form-label">Вид товару <span class="text-danger">*</span></label>

                        <div class="quick-list" id="quickKinds">
                            <strong>Швидкий вибір:</strong>
                            @forelse($arr_kind_products as $kind_title)
                                <a href="#" class="quick-kind" data-title="{{ $kind_title }}">{{ $kind_title }}</a>
                            @empty
                                <span class="text-muted">немає видів</span>
                            @endforelse
                        </div>

                        <select name="kind_product_id" id="kindSelect" class="form-control tom-select-field">
                            @foreach($kindProducts as $kind)
                                <option value="{{ $kind->id }}">{{ $kind->title }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="title_kind_product" id="title_kind_product" value="">
                    </div>

                    <!-- Підвид товару -->
                    <div class="subkind-section">
                        <label class="form-label">Підвид товару <span class="text-danger">*</span></label>

                        <div class="quick-list" id="quickSubkinds">
                            <strong>Швидкий вибір:</strong>
                            @forelse($arr_sub_kind_products as $sub_title)
                                <a href="#" class="quick-subkind" data-title="{{ $sub_title }}">{{ $sub_title }}</a>
                            @empty
                                <span class="text-muted">немає підвидів</span>
                            @endforelse
                        </div>

                        <select name="sub_kind_product_id" id="subkindSelect" class="form-control tom-select-field">
                            @foreach($subKindProducts as $subkind)
                                <option value="{{ $subkind->id }}" data-kind="{{ $subkind->kind_product_id }}">{{ $subkind->title }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="title_sub_kind_product" id="title_sub_kind_product" value="">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Зберегти
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
