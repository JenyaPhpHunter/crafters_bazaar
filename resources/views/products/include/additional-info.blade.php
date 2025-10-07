<div class="product-content-form additional-info-form animate__animated animate__fadeIn">
    <label for="additional_information" class="form-label">Додаткова інформація</label>
    <textarea id="additional_information" name="additional_information_temp" rows="10" placeholder="За необхідності внесіть додаткову інформацію про товар" class="form-control">{{ old('additional_information') }}</textarea>
    @error('additional_information')
    <div class="alert alert-danger animate__animated animate__shake">{{ $message }}</div>
    @enderror
</div>
