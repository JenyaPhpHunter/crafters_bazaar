<!-- Модальне вікно для додавання виду / підвиду -->
<div class="modal fade" id="kindSubkindModal" tabindex="-1" aria-labelledby="kindSubkindModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);">
            <div class="modal-header" style="border-bottom: 1px solid #dee2e6; padding: 1.5rem 2rem;">
                <h5 class="modal-title fw-bold" id="kindSubkindModalLabel" style="font-size: 24px;">Додати новий вид / підвид</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="kindSubkindForm" method="POST" action="{{ route('products.storekindsubkind') }}">
                @csrf
                <input type="hidden" name="mode" id="modalMode" value="subkind">

                <div class="modal-body" style="padding: 2rem;">

                    <!-- Підказка -->
                    <div class="alert alert-info mb-4 small" id="modeDescription">
                        Оберіть існуючий вид або створіть новий, потім введіть назву підвиду.
                    </div>

                    <!-- Вид товару -->
                    <div class="mb-5">
                        <label class="form-label fw-bold" style="font-size: 18px;">Вид товару <span class="text-danger">*</span></label>

                        <!-- Швидкий вибір видів — клас quick-kind -->
                        <div class="quick-list small text-muted mb-3 d-flex flex-wrap gap-2">
                            <strong class="me-2">Швидкий вибір:</strong>
                            @forelse($arr_kind_products as $kind_title)
                                <a href="#" class="quick-kind badge bg-light text-dark px-3 py-2 rounded-pill text-decoration-none" data-title="{{ $kind_title }}">
                                    {{ $kind_title }}
                                </a>
                            @empty
                                <span class="text-muted">немає видів</span>
                            @endforelse
                        </div>

                        <!-- Tom Select поле -->
                        <select name="kind_product_id" id="kindSelect" class="form-control tom-select-field" style="min-height: 58px; border-radius: 12px; font-size: 20px; padding: 1rem 1.25rem;">
                            @foreach($kindProducts as $kind)
                                <option value="{{ $kind->id }}">{{ $kind->title }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="title_kind_product" id="title_kind_product" value="">
                    </div>

                    <!-- Підвид товару -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="font-size: 18px;">Підвид товару <span class="text-danger">*</span></label>

                        <!-- Швидкий вибір підвидів — клас quick-subkind, без str_replace -->
                        <div class="quick-list small text-muted mb-3 d-flex flex-wrap gap-2" id="quickSubkinds">
                            <strong class="me-2">Швидкий вибір:</strong>
                            @forelse($arr_sub_kind_products as $sub_title)
                                <a href="#" class="quick-subkind badge bg-light text-dark px-3 py-2 rounded-pill text-decoration-none" data-title="{{ $sub_title }}">
                                    {{ $sub_title }}
                                </a>
                            @empty
                                <span class="text-muted">немає підвидів</span>
                            @endforelse
                        </div>

                        <!-- Tom Select для підвиду -->
                        <select name="sub_kind_product_id" id="subkindSelect" class="form-control tom-select-field" style="min-height: 58px; border-radius: 12px; font-size: 20px; padding: 1rem 1.25rem;">
                            @foreach($subKindProducts as $subkind)
                                <option value="{{ $subkind->id }}" data-kind="{{ $subkind->kind_product_id }}">{{ $subkind->title }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="title_sub_kind_product" id="title_sub_kind_product" value="">
                    </div>

                </div>

                <div class="modal-footer" style="border-top: 1px solid #dee2e6; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 120px; border-radius: 12px;">Скасувати</button>
                    <button type="submit" class="btn btn-primary" style="min-width: 120px; border-radius: 12px;">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--<!-- Модальне вікно для додавання виду / підвиду -->--}}
{{--<div class="modal fade" id="kindSubkindModal" tabindex="-1" aria-labelledby="kindSubkindModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-lg">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="kindSubkindModalLabel">Додати новий вид / підвид</h5>--}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--            </div>--}}

{{--            <form id="kindSubkindForm" method="POST" action="{{ route('products.storekindsubkind') }}">--}}
{{--                @csrf--}}
{{--                <input type="hidden" name="mode" id="modalMode" value="subkind">--}}

{{--                <div class="modal-body">--}}

{{--                    <!-- Підказка -->--}}
{{--                    <div class="alert alert-info mb-4 small" id="modeDescription">--}}
{{--                        Оберіть існуючий вид або створіть новий, потім введіть назву підвиду.--}}
{{--                    </div>--}}

{{--                    <!-- Вид товару – Tom Select -->--}}
{{--                    <div class="mb-4">--}}
{{--                        <label class="form-label fw-bold">Вид товару <span class="text-danger">*</span></label>--}}

{{--                        <!-- Швидкий вибір -->--}}
{{--                        <div class="quick-list small text-muted mb-2">--}}
{{--                            <strong>Швидкий вибір:</strong>--}}
{{--                            @forelse($arr_kind_products as $kind_title)--}}
{{--                                @php $escaped = str_replace("'", "\\'", $kind_title); @endphp--}}
{{--                                <a href="#" class="quick-kind me-2" data-title="{{ $escaped }}">{{ $kind_title }}</a>--}}
{{--                            @empty--}}
{{--                                <span>немає видів</span>--}}
{{--                            @endforelse--}}
{{--                        </div>--}}

{{--                        <!-- Tom Select поле -->--}}
{{--                        <select name="kind_product_id" id="kindSelect" class="form-control tom-select-field">--}}
{{--                            @foreach($kindProducts as $kind)--}}
{{--                                <option value="{{ $kind->id }}">{{ $kind->title }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}

{{--                        <!-- Приховане поле для нової назви виду -->--}}
{{--                        <input type="hidden" name="title_kind_product" id="title_kind_product" value="">--}}
{{--                    </div>--}}

{{--                    <!-- Підвид товару – Tom Select (тепер теж з пошуком) -->--}}
{{--                    <div class="mb-4">--}}
{{--                        <label class="form-label fw-bold">Підвид товару <span class="text-danger">*</span></label>--}}

{{--                        <!-- Швидкий вибір -->--}}
{{--                        <div class="quick-list small text-muted mb-3" id="quickSubkinds">--}}
{{--                            <strong>Швидкий вибір:</strong>--}}
{{--                            @forelse($arr_sub_kind_products as $sub_title)--}}
{{--                                @php $escaped = str_replace("'", "\\'", $sub_title); @endphp--}}
{{--                                <a href="#" class="quick-subkind me-2" data-title="{{ $escaped }}">{{ $sub_title }}</a>--}}
{{--                            @empty--}}
{{--                                <span>немає підвидів</span>--}}
{{--                            @endforelse--}}
{{--                        </div>--}}

{{--                        <!-- Tom Select поле для підвиду -->--}}
{{--                        <select name="sub_kind_product_id" id="subkindSelect" class="form-control tom-select-field">--}}
{{--                            @foreach($subKindProducts as $subkind)--}}
{{--                                <option value="{{ $subkind->id }}" data-kind="{{ $subkind->kind_product_id }}">{{ $subkind->title }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}

{{--                        <!-- Приховане поле для нової назви підвиду -->--}}
{{--                        <input type="hidden" name="title_sub_kind_product" id="title_sub_kind_product" value="">--}}
{{--                    </div>--}}

{{--                </div>--}}

{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>--}}
{{--                    <button type="submit" class="btn btn-primary">Зберегти</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<style>--}}
{{--    /* Tom Select dropdown - легкий фон, тінь, гарний вигляд */--}}
{{--    .ts-dropdown {--}}
{{--        background-color: rgba(255, 255, 255, 0.98) !important;  /* майже білий, але не прозорий */--}}
{{--        border: 1px solid #dee2e6 !important;--}}
{{--        border-radius: 0.375rem !important;--}}
{{--        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;  /* легка тінь */--}}
{{--        z-index: 1051 !important;  /* щоб був над модалкою */--}}
{{--    }--}}

{{--    .ts-dropdown .option {--}}
{{--        padding: 0.5rem 1rem !important;--}}
{{--    }--}}

{{--    .ts-dropdown .option.active,--}}
{{--    .ts-dropdown .option.selected {--}}
{{--        background-color: #e9ecef !important;--}}
{{--        color: #212529 !important;--}}
{{--    }--}}

{{--    .ts-dropdown .option:hover {--}}
{{--        background-color: #f1f3f5 !important;--}}
{{--    }--}}

{{--    /* Якщо хочеш темний фон (наприклад для темної теми) */--}}
{{--    .ts-dropdown.dark-mode {--}}
{{--        background-color: rgba(33, 37, 41, 0.98) !important;--}}
{{--        color: #f8f9fa !important;--}}
{{--        border-color: #495057 !important;--}}
{{--    }--}}

{{--    .ts-dropdown.dark-mode .option.active,--}}
{{--    .ts-dropdown.dark-mode .option.selected {--}}
{{--        background-color: #495057 !important;--}}
{{--    }--}}
{{--</style>--}}
