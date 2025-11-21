{{-- КОМПАКТНИЙ ЗАВАНТАЖУВАЧ ФОТО — ФІНАЛЬНА ВЕРСІЯ --}}
<div class="mb-4 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
    <div class="d-flex align-items-center mb-3" style="gap: 0.35rem;">
        <label class="form-label">
            <strong>Фото товару (до 10 шт.)</strong>
        </label>
        <i class="fas fa-info-circle color-info-icon"
           data-bs-toggle="tooltip"
           data-bs-placement="right"
           title="Максимум 10 фото, до 10 МБ кожне"></i>
    </div>

    <div class="file-drop-zone-compact" id="fileDropZone">
        <div class="d-flex align-items-center justify-content-between w-100 h-100 px-4">
            <!-- Ліва частина: іконка + текст -->
            <div class="d-flex align-items-center" style="gap: 18px;">
                <div class="upload-icon-compact">
                    <i class="fas fa-images"></i>
                </div>
                <div>
                    <div class="upload-title-compact fw-600">
                        Оберіть фото або перетягніть їх сюди
                    </div>
                    <div class="upload-counter text-muted">
                        Завантажено: <span id="photoCount">0</span><span>/10</span>
                    </div>
                </div>
            </div>

            <!-- Права частина: один єдиний акуратний лічильник у стилі Apple -->
            <div class="upload-counter-badge" id="photoCounterBadge">
                <span id="photoCountBadge">0</span>/10
            </div>
        </div>
    </div>

    <div class="upload-error text-danger mt-2 small fw-500" id="uploadError" style="display:none;"></div>

    <input type="file"
           id="product_photo"
           name="product_photo[]"
           multiple
           accept="image/png,image/jpeg,image/webp"
           class="d-none">
</div>
