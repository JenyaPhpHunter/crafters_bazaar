(function () {
    "use strict";

    function textOrFallback(value, fallback) {
        const normalized = (value || "").trim();
        return normalized.length ? normalized : fallback;
    }

    function initBrandPreview(scope) {
        const titleInput = scope.querySelector("[data-brand-title-input]");
        const contentInput = scope.querySelector("[data-brand-content-input]");
        const titlePreview = scope.querySelector("[data-brand-title-preview]");
        const contentPreview = scope.querySelector("[data-brand-content-preview]");
        const logoInput = scope.querySelector("[data-brand-logo-input]");
        const logoPreview = scope.querySelector("[data-brand-logo-preview]");
        const fileLabel = scope.querySelector("[data-brand-file-label]");

        if (titleInput && titlePreview) {
            titleInput.addEventListener("input", function () {
                titlePreview.textContent = textOrFallback(this.value, "Назва бренду");
            });
        }

        if (contentInput && contentPreview) {
            contentInput.addEventListener("input", function () {
                contentPreview.textContent = textOrFallback(
                    this.value,
                    "Короткий опис бренду зʼявиться тут під час заповнення форми."
                );
            });
        }

        if (logoInput && logoPreview) {
            logoInput.addEventListener("change", function () {
                const file = this.files && this.files[0];

                if (!file) {
                    if (fileLabel) fileLabel.textContent = "Вибрати зображення";
                    return;
                }

                if (fileLabel) fileLabel.textContent = file.name;

                const reader = new FileReader();
                reader.onload = function (event) {
                    logoPreview.src = event.target.result;
                    logoPreview.removeAttribute("data-bs-toggle");
                    logoPreview.removeAttribute("data-bs-target");
                    logoPreview.removeAttribute("onclick");
                };
                reader.readAsDataURL(file);
            });
        }
    }

    window.submitRemoveUser = function (userId) {
        if (!confirm("Ви впевнені, що хочете видалити цього користувача з бренду?")) return;

        const scope = document.querySelector(".brand-workspace");
        const brandId = scope ? scope.dataset.brandId : "";
        const form = document.getElementById("remove-user-form");

        if (!brandId || !form) return;

        form.action = `/brands/${brandId}/users/${userId}`;
        form.submit();
    };

    window.submitCancelInvitation = function (invitationId) {
        if (!confirm("Скасувати запрошення?")) return;

        const scope = document.querySelector(".brand-workspace");
        const brandId = scope ? scope.dataset.brandId : "";
        const form = document.getElementById("cancel-invitation-form");

        if (!brandId || !form) return;

        form.action = `/brands/${brandId}/invitations/${invitationId}`;
        form.submit();
    };

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".brand-workspace").forEach(initBrandPreview);
    });
})();
