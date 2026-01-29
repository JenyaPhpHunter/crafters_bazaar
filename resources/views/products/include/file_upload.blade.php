<div class="photo-upload-block mb-0">

    {{-- HEADER --}}
    <div class="form-block-header text-center">
        <label class="form-label d-block">
            <strong>Фото товару (до 10 шт.)</strong>
            <i class="fas fa-info-circle ms-2"
               data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Рекомендований розмір фото: 900×1200 px (3:4)">
            </i>
        </label>

        <div class="small text-muted">
            Рекомендований формат: <strong>3:4</strong> — <strong>900×1200 px</strong>
        </div>
    </div>

    {{-- BODY --}}
    <div class="photo-upload-body">
        <div class="file-drop-zone-compact" id="fileDropZone">
            <div class="d-flex align-items-center justify-content-between w-100 h-100 px-4">
                <div class="d-flex align-items-center" style="gap: 18px;">
                    <div class="upload-icon-compact">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <div class="upload-title-compact fw-600">
                            Оберіть фото або перетягніть їх сюди
                        </div>
                        <div class="upload-counter text-muted">
                            Завантажено: <span id="photoCount">0</span>/10
                        </div>
                    </div>
                </div>

                <div class="upload-badge" id="photoCounterBadge">
                    <span id="photoCountBadge">0</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ВАЖЛИВО: name="product_photo[]" --}}
    <input type="file"
           id="product_photo"
           name="product_photo[]"
           multiple
           accept="image/png,image/jpeg,image/webp"
           class="d-none">
</div>
