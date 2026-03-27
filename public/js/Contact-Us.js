
/*
 $(".reload_captcha").click(function(){
        $.ajax({
            type: 'GET',
            url: 'reload-captcha-src',
            success: function (data) {
                $('.captcha span').html('<img src='+data.captcha+'>');
                //".$captcha_image." = data.captcha;
                const captcha_image = data.captcha;
                console.log = data.captcha;
            }
        });
    });
*/
$(document).ready(function() {

    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

});

