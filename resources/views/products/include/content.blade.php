<div class="form-field mb-5 content-block">

    {{-- HEADER --}}
    <div class="form-block-header">
        <label for="content" class="form-label">
            Опис товару
        </label>
    </div>

    {{-- BODY --}}
    <div class="content-wrapper">
        <textarea
            id="content"
            name="content_temp"
            rows="4"
            class="form-control content-textarea"
            placeholder="Опишіть стан товару, комплектацію, особливості, дефекти (якщо є), або іншу корисну інформацію...
Ця інформація допоможе покупцям краще зрозуміти товар і швидше прийняти рішення."
        >{{ old('content') }}</textarea>

        @error('content')
        <div class="alert alert-danger mt-3 small">
            {{ $message }}
        </div>
        @enderror
    </div>

</div>
