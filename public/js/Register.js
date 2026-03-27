
$(document).ready(function(){
    $('#reload').click(function (e) {
    e.preventDefault();
        $.ajax({
            type: "GET",
            url: '/reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
                //$("#captcha-img").html(data.captcha);
            }
        });
    });
});
function reloadCaptchaFunction(){
        $.ajax({
            type: "GET",
            url: '/reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
                //$("#captcha-img").html(data.captcha);
            }
        });
}

//setInterval(reloadCaptchaFunction, 300000);
setInterval(reloadCaptchaFunction, 120000);

$(document).ready(function() {
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
$(".toggle-confirm-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

});

document.addEventListener('DOMContentLoaded', function() {
  const myInput = document.getElementById('password');
  const myDiv = document.getElementById('validation_errors');

  myInput.addEventListener('input', function() {
    if (myInput.value.trim() !== '') { // Check if input has a value
      myDiv.style.display = 'block'; // Show the div
    } else {
      myDiv.style.display = 'none'; // Hide the div
    }
  });
});

