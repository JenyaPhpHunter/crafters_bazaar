
$(document).ready(function() {
    $('.buy-btn').click(function(e) {
        e.preventDefault();
        $(this).siblings('.product-details').show();
    });
});

function updateFileLabel(input) {
    var fileLabel = document.getElementById('file-label');
    if (input.files.length > 0) {
        fileLabel.textContent = input.files[0].name;
    } else {
        fileLabel.textContent = 'Виберіть фото';
    }
}

function selectColor(circle) {
    // Знімаємо виділення з усіх кружечків
    var circles = document.querySelectorAll('.circle');
    circles.forEach(function (c) {
        c.classList.remove('selected');
    });

    // Виділяємо вибраний кружечок
    circle.classList.add('selected');

    // Отримуємо id кружка з його id
    var selectedColor = circle.id.replace('circle', '');
    document.getElementById('selectedColor').value = selectedColor;
}

// function selectSize(sizeLink) {
//     // Знімаємо виділення з усіх розмірів
//     var sizeLinks = document.querySelectorAll('.product-sizes a');
//     var sizeId = sizeLink.getAttribute('data-size-id');
//     sizeLinks.forEach(function (link) {
//         link.classList.remove('selected');
//     });
//
//     // Виділяємо обраний розмір
//     sizeLink.classList.add('selected');
//     document.getElementById('selected_size').value = sizeId;
//
//     // Тепер ви можете зберегти це значення у прихованому полі або використовувати його інакше в вашій формі
// }

// у списку категорій форума при наведенні відображає підкатегорії
    document.addEventListener('DOMContentLoaded', function() {
    var categoryContainers = document.querySelectorAll('.category-container');

    categoryContainers.forEach(function(container) {
    container.addEventListener('click', function() {
    var categoryId = container.id.split('-')[1];
    var subcategories = document.getElementById('subcategories-' + categoryId);
    if (subcategories.classList.contains('subcategories-visible')) {
    subcategories.classList.remove('subcategories-visible');
} else {
    subcategories.classList.add('subcategories-visible');
}
});
});
});

// при створенні чи редагванні товару при відмічанні чекбоксу can_produce відкриває вікно term_creation та при знятті чекбоксу can_produce призначає term_creation = 0
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('can_produce');
    const termCreationWrapper = document.getElementById('termCreationWrapper');
    const termCreationInput = termCreationWrapper.querySelector('input[name="term_creation"]');

    // Function to toggle the visibility of the term creation wrapper
    function toggleTermCreationWrapper() {
        if (checkbox.checked) {
            termCreationWrapper.style.display = 'block';
        } else {
            termCreationWrapper.style.display = 'none';
            termCreationInput.value = 0; // Set term_creation to 0 when the checkbox is unchecked
        }
    }

    // Initial check when the page loads
    if (parseInt(termCreationInput.value) > 0) {
        checkbox.checked = true;
    }
    toggleTermCreationWrapper();

    // Add an event listener to the checkbox
    checkbox.addEventListener('change', toggleTermCreationWrapper);
});
