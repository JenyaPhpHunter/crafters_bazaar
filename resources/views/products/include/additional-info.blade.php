<div class="form-field mb-5 additional-info-block">

    {{-- HEADER --}}
    <div class="form-block-header">
        <label for="additional_information" class="form-label">
            Додаткова інформація про товар
            <span class="text-muted fs-sm">(не обов'язково)</span>
        </label>
    </div>

    {{-- BODY --}}
    <div class="additional-info-wrapper">
        <textarea
            id="additional_information"
            name="additional_information_temp"
            rows="4"
            class="form-control additional-info-textarea"
            placeholder="Опишіть стан товару, комплектацію, особливості, дефекти (якщо є), або іншу корисну інформацію...
Ця інформація допоможе покупцям краще зрозуміти товар і швидше прийняти рішення."
        >{{ old('additional_information') }}</textarea>

        @error('additional_information')
        <div class="alert alert-danger mt-3 small">
            {{ $message }}
        </div>
        @enderror
    </div>

</div>
