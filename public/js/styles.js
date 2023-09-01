
$(document).ready(function() {
    $('.buy-btn').click(function(e) {
        e.preventDefault();
        $(this).siblings('.product-details').show();
    });
});
