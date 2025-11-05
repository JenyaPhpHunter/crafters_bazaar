// public/js/modules/forms.js
(function ($) {
    "use strict";

    // Countdown
    $('[data-countdown]').each(function () {
        var $this = $(this), $finalDate = $this.data('countdown');
        $this.countdown($finalDate, function (event) {
            $this.html(event.strftime('<div class="count"><span class="amount">%-D</span><span class="period">Days</span></div><div class="count"><span class="amount">%-H</span><span class="period">Hours</span></div><div class="count"><span class="amount">%-M</span><span class="period">Minutes</span></div><div class="count"><span class="amount">%-S</span><span class="period">Seconds</span></div>'));
        });
    });

    // Ajax Contact
    $('#contact-form').submit(function (e) {
        e.preventDefault();
        var formMessages = $('.form-messege');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize()
        }).done(function (response) {
            formMessages.removeClass('error text-danger').addClass('success text-success learts-mt-10').text(response);
            $(this).find('input:not([type="submit"]), textarea').val('');
        }).fail(function (data) {
            formMessages.removeClass('success text-success').addClass('error text-danger mt-3').text(data.responseText || 'Oops! An error occurred.');
        });
    });

    window.Learts = window.Learts || {};
    Learts.forms = { init: () => {} };

})(jQuery);
