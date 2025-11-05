(function ($) {
    "use strict";

    // === WISHLIST ===
    (function () {
        if (typeof mojs === 'undefined') return;
        const burst = new mojs.Burst({
            left: 0, top: 0,
            radius: { 4: 32 },
            angle: 45,
            count: 14,
            children: {
                radius: 2.5,
                fill: ['#F8796C'],
                scale: { 1: 0, easing: 'quad.in' },
                pathScale: [.8, null],
                degreeShift: [13, null],
                duration: [500, 700],
                easing: 'quint.out'
            }
        });

        $('.add-to-wishlist').on('click', function (e) {
            const $this = $(this);
            const productId = $this.data('product-id');
            if (!$this.hasClass('wishlist-added')) {
                e.preventDefault();
                $this.addClass('wishlist-added').find('i').removeClass('far').addClass('fas');
                const coords = {
                    x: $this.offset().left + $this.width() / 2,
                    y: $this.offset().top + $this.height() / 2
                };
                burst.tune(coords).replay();
                window.location.href = "/wishlist/index/" + productId;
            }
        });
    })();

    // === QUANTITY ===
    $('.qty-btn').on('click', function () {
        const $this = $(this);
        const oldValue = parseFloat($this.siblings('input').val()) || 1;
        const newVal = $this.hasClass('plus') ? oldValue + 1 : (oldValue > 1 ? oldValue - 1 : 1);
        $this.siblings('input').val(newVal);
    });

    // === QUICK VIEW MODAL ===
    $('#quickViewModal').on('shown.bs.modal', function () {
        if (typeof Learts?.sliders?.initSlick === 'function') {
            Learts.sliders.initSlick($('.product-gallery-slider-quickview'), {
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
            });
        }
    });

    // === КАСТОМНА ЛОГІКА ФОРМ ===
    $(document).ready(function() {
        // Buy button
        $('.buy-btn').click(function(e) {
            e.preventDefault();
            $(this).siblings('.product-details').slideDown(400);
        });

        // File label update
        const fileInput = document.getElementById('file-input'); // ← ЗМІНИ НА СВІЙ ID
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                updateFileLabel(this);
            });
            updateFileLabel(fileInput); // початковий стан
        }
    });

    // === ГЛОБАЛЬНІ ФУНКЦІЇ ===
    window.updateFileLabel = function(input) {
        const fileLabel = document.getElementById('file-label');
        if (!fileLabel) return;

        if (input.files.length > 0) {
            fileLabel.textContent = input.files.length + ' фото обрано';
            fileLabel.style.backgroundColor = '#006666';
            fileLabel.style.color = '#F5F5DC';
        } else {
            fileLabel.textContent = 'Виберіть фото';
            fileLabel.style.backgroundColor = '#00CED1';
            fileLabel.style.color = '#D2B48C';
        }
    };

    window.selectColor = function(circle) {
        document.querySelectorAll('.circle').forEach(c => {
            c.classList.remove('selected');
            c.style.transform = 'scale(1)';
        });
        circle.classList.add('selected');
        circle.style.transform = 'scale(1.1)';
        document.getElementById('selectedColor').value = circle.dataset.id;
        setTimeout(() => circle.style.transform = 'scale(1)', 200);
    };

    // === КАТЕГОРІЇ ===
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.category-container').forEach(container => {
            container.addEventListener('click', function() {
                const categoryId = this.id.split('-')[1];
                const subcategories = document.getElementById('subcategories-' + categoryId);
                subcategories.classList.toggle('subcategories-visible');
                subcategories.style.opacity = subcategories.classList.contains('subcategories-visible') ? '1' : '0';
            });
        });

        // === ТЕРМІН ВИГОТОВЛЕННЯ ===
        const checkbox = document.getElementById('can_produce');
        const termCreationContainer = document.getElementById('term_creation_container');
        if (termCreationContainer && checkbox) {
            const termCreationInput = termCreationContainer.querySelector('input[name="term_creation"]');
            const toggle = () => {
                if (checkbox.checked) {
                    termCreationContainer.style.display = 'block';
                    termCreationContainer.classList.add('animate__fadeIn');
                } else {
                    termCreationContainer.style.display = 'none';
                    termCreationInput.value = 0;
                }
            };
            if (parseInt(termCreationInput.value) > 0) checkbox.checked = true;
            toggle();
            checkbox.addEventListener('change', toggle);
        }
    });

    // === ЕКСПОРТ ===
    window.Learts = window.Learts || {};
    Learts.product = { init: () => {} };

})(jQuery);
