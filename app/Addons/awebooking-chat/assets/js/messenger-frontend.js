'use strict';

(function ($) {
    let button = $('.btn-contact-host');
    button.on('click', function (ev) {
        ev.preventDefault();
        let t = $(this);
        $('.spinner-border', t).removeClass('d-none').addClass('d-inline-block');
        let data = {
            'code': t.data('code'),
            '_token': $('meta[name="csrf-token"]').attr('content')
        };
        $.post(t.data('action'), data, function (respon) {
            if (typeof respon == 'object') {
                if (respon.callback) {
                    $.fn.hhCallbackAction(respon.callback);
                } else {
                    if (respon.redirect) {
                        window.location.href = respon.redirect;
                    } else {
                        alert(respon.message);
                        $('.spinner-border', t).addClass('d-none').removeClass('d-inline-block');
                    }
                }
                $('.spinner-border', t).removeClass('d-inline-block').addClass('d-none');
            }
        }, 'json');
    });
})(jQuery);
