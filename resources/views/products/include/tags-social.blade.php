{{-- resources/views/products/include/tags_social.blade.php --}}

<!-- Блок Теги -->
<div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
    <div class="tags-wrapper position-relative">
        <label for="tags" class="form-label">
            Теги товару
            <span class="text-muted fs-sm">(не обов'язково)</span>
        </label>

        <input
            type="text"
            id="tags"
            name="tags"
            class="form-control tags-input"
            placeholder="Теги пишіть через кому. Наприклад: handmade, подарунок, літній ..."
            value="{{ old('tags') }}"
            autocomplete="off"
        />

        @error('tags')
        <div class="alert alert-danger mt-3 animate__animated animate__shakeX small">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
        </div>
        @enderror
    </div>
</div>

<!-- Блок Соцмережі -->
<div class="form-field mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
    <div class="social-links-wrapper position-relative">
        <label for="social_links" class="form-label">
            Посилання на соцмережі
            <span class="text-muted fs-sm">(не обов'язково)</span>
        </label>

        <input
            type="text"
            id="social_links"
            name="social_links"
            class="form-control social-links-input"
            placeholder="https://instagram.com/ваш_профіль, https://tiktok.com/@ваш_нік"
            value="{{ old('social_links') }}"
            autocomplete="off"
        >

        @error('social_links')
        <div class="alert alert-danger mt-3 animate__animated animate__shakeX small">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
        </div>
        @enderror
    </div>
</div>
