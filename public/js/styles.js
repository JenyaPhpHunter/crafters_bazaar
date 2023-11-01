
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

function selectSize(sizeLink) {
    // Знімаємо виділення з усіх розмірів
    var sizeLinks = document.querySelectorAll('.product-sizes a');
    var sizeId = sizeLink.getAttribute('data-size-id');
    sizeLinks.forEach(function (link) {
        link.classList.remove('selected');
    });

    // Виділяємо обраний розмір
    sizeLink.classList.add('selected');
    document.getElementById('selected_size').value = sizeId;

    // Тепер ви можете зберегти це значення у прихованому полі або використовувати його інакше в вашій формі
}

