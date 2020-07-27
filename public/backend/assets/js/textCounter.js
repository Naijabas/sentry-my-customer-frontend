
var counter = $('.charNum');
counter.hide();
    $('.counter').keyup(function () {
        counter.show();
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            counter.text(' You reached text limit!').addClass('text-danger');
        } else {
            var char = max - len;
            counter.text(char + ' characters left').addClass('text-success');
        }
    });

    $('.counter').blur(function () {
        counter.hide();
    });

