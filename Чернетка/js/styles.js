// $(document).ready(function() {
//     $('.buy-btn').click(function(e) {
//         e.preventDefault();
//         $(this).siblings('.product-details').slideDown(400);
//     });
//     // Оновлення лабела для завантаження файлу
//     function updateFileLabel(input) {
//         var fileLabel = document.getElementById('file-label');
//         if (input.files.length > 0) {
//             fileLabel.textContent = input.files.length + ' фото обрано';
//             fileLabel.style.backgroundColor = '#006666';
//             fileLabel.style.color = '#F5F5DC';
//         } else {
//             fileLabel.textContent = 'Виберіть фото';
//             fileLabel.style.backgroundColor = '#00CED1';
//             fileLabel.style.color = '#D2B48C';
//         }
//     }
// });
// function selectColor(circle) {
//     var circles = document.querySelectorAll('.circle');
//     circles.forEach(function(c) {
//         c.classList.remove('selected');
//         c.style.transform = 'scale(1)';
//     });
//     circle.classList.add('selected');
//     circle.style.transform = 'scale(1.1)';
//     document.getElementById('selectedColor').value = circle.dataset.id;
//     setTimeout(() => circle.style.transform = 'scale(1)', 200);
// }
// // Категорії
// document.addEventListener('DOMContentLoaded', function() {
//     var categoryContainers = document.querySelectorAll('.category-container');
//     categoryContainers.forEach(function(container) {
//         container.addEventListener('click', function() {
//             var categoryId = container.id.split('-')[1];
//             var subcategories = document.getElementById('subcategories-' + categoryId);
//             if (subcategories.classList.contains('subcategories-visible')) {
//                 subcategories.classList.remove('subcategories-visible');
//                 subcategories.style.opacity = '0';
//             } else {
//                 subcategories.classList.add('subcategories-visible');
//                 subcategories.style.opacity = '1';
//             }
//         });
//     });
// });
// // Кількість та термін
// document.addEventListener('DOMContentLoaded', function() {
//     const checkbox = document.getElementById('can_produce');
//     const termCreationContainer = document.getElementById('term_creation_container');
//     if (termCreationContainer) {
//         const termCreationInput = termCreationContainer.querySelector('input[name="term_creation"]');
//         function toggleTermCreationWrapper() {
//             if (checkbox.checked) {
//                 termCreationContainer.style.display = 'block';
//                 termCreationContainer.classList.add('animate__fadeIn');
//             } else {
//                 termCreationContainer.style.display = 'none';
//                 termCreationInput.value = 0;
//             }
//         }
//         if (parseInt(termCreationInput.value) > 0) checkbox.checked = true;
//         toggleTermCreationWrapper();
//         checkbox.addEventListener('change', toggleTermCreationWrapper);
//     }
// });
