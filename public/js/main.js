
(function () {
    "use strict";

    // Глобальний об'єкт
    window.Learts = window.Learts || {};

    // Ініціалізація всіх модулів
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Learts.utils !== 'undefined') Learts.utils.init();
        if (typeof Learts.ui !== 'undefined') Learts.ui.init();
        if (typeof Learts.sliders !== 'undefined') Learts.sliders.init();
        if (typeof Learts.product !== 'undefined') Learts.product.init();
        if (typeof Learts.forms !== 'undefined') Learts.forms.init();
        if (typeof Learts.layout !== 'undefined') Learts.layout.init();
    });

})();
