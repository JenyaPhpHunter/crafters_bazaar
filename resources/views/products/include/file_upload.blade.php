{{--<div class="product-photos mt-4">--}}
{{--    <label for="product_photo" class="file-input-label"--}}
{{--           style="display: inline-block; padding: 10px 20px; background-color: #72A499; color: white; border-radius: 5px; cursor: pointer;">--}}
{{--        <i class="fas fa-image"></i> <span id="file-label">Виберіть фото</span>--}}
{{--    </label>--}}
{{--    <input type="file" id="product_photo" name="product_photo[]" multiple--}}
{{--           style="display: none;" onchange="updateFileLabel(this);">--}}
{{--</div>--}}
<div class="form-section">
    <label for="product_photo" class="file-upload-label">
        <i class="fas fa-upload"></i> Виберіть фото
    </label>
    <input type="file" id="product_photo" name="product_photo[]" multiple style="display: none;"
           onchange="document.getElementById('file-label').innerText = this.files.length + ' фото обрано';">
</div>
