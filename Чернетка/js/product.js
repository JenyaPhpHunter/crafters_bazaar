// (function ($) {
//     "use strict";
//
//     // === WISHLIST ===
//     (function () {
//         if (typeof mojs === 'undefined') return;
//         const burst = new mojs.Burst({
//             left: 0, top: 0,
//             radius: { 4: 32 },
//             angle: 45,
//             count: 14,
//             children: {
//                 radius: 2.5,
//                 fill: ['#F8796C'],
//                 scale: { 1: 0, easing: 'quad.in' },
//                 pathScale: [.8, null],
//                 degreeShift: [13, null],
//                 duration: [500, 700],
//                 easing: 'quint.out'
//             }
//         });
//
//         $('.add-to-wishlist').on('click', function (e) {
//             const $this = $(this);
//             const productId = $this.data('product-id');
//             if (!$this.hasClass('wishlist-added')) {
//                 e.preventDefault();
//                 $this.addClass('wishlist-added').find('i').removeClass('far').addClass('fas');
//                 const coords = {
//                     x: $this.offset().left + $this.width() / 2,
//                     y: $this.offset().top + $this.height() / 2
//                 };
//                 burst.tune(coords).replay();
//                 window.location.href = "/wishlist/index/" + productId;
//             }
//         });
//     })();
//
//     // === QUANTITY ===
//     $('.qty-btn').on('click', function (e) {
//         e.preventDefault();
//         const $this = $(this);
//         const $input = $this.siblings('.qty-input');
//         let oldValue = parseFloat($input.val()) || 0;
//         const delta = $this.hasClass('plus') ? 1 : -1;
//         let newVal = Math.max(0, oldValue + delta);
//         $input.val(newVal).trigger('change');
//         console.log(`Delta: ${delta}, Old value: ${oldValue}, New value: ${newVal}`);
//     });
//
//     // === QUICK VIEW MODAL ===
//     $('#quickViewModal').on('shown.bs.modal', function () {
//         if (typeof Learts?.sliders?.initSlick === 'function') {
//             Learts.sliders.initSlick($('.product-gallery-slider-quickview'), {
//                 dots: true,
//                 infinite: true,
//                 slidesToShow: 1,
//                 slidesToScroll: 1,
//                 prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
//                 nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
//             });
//         }
//     });
//
//     // === КАСТОМНА ЛОГІКА ПРОДУКТІВ ===
//     $(document).ready(function () {
//         // Buy button
//         $('.buy-btn').on('click', function (e) {
//             e.preventDefault();
//             $(this).siblings('.product-details').slideDown(400);
//         });
//
//         // Обмеження введення лише цифр у поле "Вартість"
//         $('[data-only-numbers="true"]').on('input', function (e) {
//             const $div = $(this);
//             let value = $div.text().replace(/[^0-9]/g, '');
//             $div.text(value);
//             $('#price-hidden').val(value);
//         }).on('paste', function (e) {
//             e.preventDefault();
//             const pastedData = e.originalEvent.clipboardData.getData('text/plain').replace(/[^0-9]/g, '');
//             const $div = $(this);
//             $div.text(pastedData);
//             $('#price-hidden').val(pastedData);
//         });
//     });
//
//     // === ГЛОБАЛЬНІ ФУНКЦІЇ ===
//     window.updateFileLabel = function (input) {
//         const fileLabel = document.getElementById('file-label');
//         if (!fileLabel) return;
//
//         if (input.files.length > 0) {
//             fileLabel.textContent = input.files.length + ' фото обрано';
//             fileLabel.style.backgroundColor = '#006666';
//             fileLabel.style.color = '#F5F5DC';
//         } else {
//             fileLabel.textContent = 'Виберіть фото';
//             fileLabel.style.backgroundColor = '#00CED1';
//             fileLabel.style.color = '#D2B48C';
//         }
//     };
//
//     // === МНОЖИННИЙ ВИБІР КОЛЬОРІВ ===
//     $(document).ready(function () {
//         // Додаємо обробники для всіх кружечків (навіть якщо вони додалися динамічно)
//         $(document).on('click', '.color-circle', function () {
//             const circle = this;
//             const colorId = circle.dataset.id;
//             const isSelected = circle.classList.contains('selected');
//
//             console.log('Color click ID:', colorId, 'Selected:', !isSelected);
//
//             if (isSelected) {
//                 // Знімаємо виділення
//                 circle.classList.remove('selected');
//                 removeColorId(colorId);
//             } else {
//                 // Додаємо виділення
//                 circle.classList.add('selected');
//                 addColorId(colorId);
//
//                 // Анімація
//                 circle.classList.add('animate__animated', 'animate__bounceIn');
//                 setTimeout(() => circle.classList.remove('animate__animated', 'animate__bounceIn'), 600);
//             }
//         });
//
//         // Підтримка клавіатури (Enter або Space)
//         $(document).on('keydown', '.color-circle', function (e) {
//             if (e.key === 'Enter' || e.key === ' ') {
//                 e.preventDefault();
//                 $(this).trigger('click');
//             }
//         });
//     });
//
// // Додає ID кольору в приховані інпути
//     function addColorId(id) {
//         if (!document.querySelector(`input[value="${id}"]`)) {
//             const input = document.createElement('input');
//             input.type = 'hidden';
//             input.name = 'color_ids[]';
//             input.value = id;
//             input.className = 'color-id-input';
//             document.querySelector('.color-circles').parentNode.appendChild(input);
//         }
//     }
//
// // Видаляє ID кольору з прихованих інпутів
//     function removeColorId(id) {
//         const input = document.querySelector(`input[value="${id}"].color-id-input`);
//         if (input) input.remove();
//     }
//
//     // === КАТЕГОРІЇ ===
//     $(document).ready(function () {
//         $('.category-container').on('click', function () {
//             const categoryId = this.id.split('-')[1];
//             const $subcategories = $('#subcategories-' + categoryId);
//             $subcategories.toggleClass('subcategories-visible');
//             $subcategories.css('opacity', $subcategories.hasClass('subcategories-visible') ? '1' : '0');
//         });
//     });
//
//     // === ТЕРМІН ВИГОТОВЛЕННЯ ===
//     $(document).ready(function () {
//         const $checkbox = $('#can_produce');
//         const $termContainer = $('#term_creation_container');
//         const $termInput = $termContainer.find('input[name="term_creation"]');
//
//         const toggleTerm = function () {
//             if ($checkbox.is(':checked')) {
//                 $termContainer.css('display', 'block').addClass('animate__fadeIn animate__faster');
//                 $termInput.val('0');
//             } else {
//                 $termContainer.css('display', 'none');
//                 $termInput.val('0');
//             }
//         };
//
//         if (parseInt($termInput.val()) > 0) $checkbox.prop('checked', true);
//         toggleTerm();
//
//         $checkbox.on('change', toggleTerm);
//     });
//
//     // === ІНІЦІАЛІЗАЦІЯ ПРОДУКТІВ ===
//     window.Learts = window.Learts || {};
//     Learts.product = Learts.product || {};
//     Learts.product.init = function () {
//         // Ніяких дій при ініціалізації, якщо потрібно — додай
//     };
//
//     $(document).ready(function () {
//         Learts.product.init();
//     });
// })(jQuery);
