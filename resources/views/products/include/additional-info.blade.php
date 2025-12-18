{{-- resources/views/products/include/additional-info.blade.php --}}

<div class="form-field mb-5">  {{-- Обов'язково .form-field для правильного позиціонування мітки --}}
    <div class="additional-info-wrapper position-relative">
        <!-- Мітка з підтримкою анімації підйому -->
        <label for="additional_information" class="form-label">
            Додаткова інформація про товар
            <span class="text-muted fs-sm">(не обов'язково)</span>
        </label>

        <!-- Текстова область — спочатку маленька -->
        <textarea
            id="additional_information"
            name="additional_information_temp"
            rows="4"  {{-- Початкова висота — 4 рядки --}}
            class="form-control additional-info-textarea"
            placeholder="Опишіть стан товару, комплектацію, особливості, дефекти (якщо є), або іншу корисну інформацію...
Ця інформація допоможе покупцям краще зрозуміти товар і швидше прийняти рішення."
        >{{ old('additional_information') }}</textarea>

        <!-- Помилка валідації -->
        @error('additional_information')
        <div class="alert alert-danger mt-3 animate__animated animate__shakeX small shadow-sm border-0">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
        </div>
        @enderror
    </div>
</div>
