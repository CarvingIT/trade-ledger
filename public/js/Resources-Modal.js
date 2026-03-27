// Website front side page

$(document).ready(function(){

    $(".refresh_page").click(function(){
        setTimeout(function(){
        window.location.reload(1);
        }, 4000);
    });

    $(".do-not-refresh").click(function(){
         // Execute the redirection function (allows user to use the back button)
         window.location.href = '/resources';
    });

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


    $(".addToWhishList").on('click', function(event){
        event.preventDefault();
        var formId = $(this).data('resource-id');
        //alert (formId);
        var resources_id = formId;
        //alert(resources_id);
        console.log(formId);
        document.getElementById("resource_form_" + resources_id).submit();
        window.location.reload(1);
   });

    

////////////////////////////////////

    $('.toggle-div').on('click', function(event){
        // Prevent the browser from navigating to the anchor's href
        event.preventDefault();

         // Get the ID of the div to show from the anchor's href attribute
        var targetDivId = $(this).attr('href'); // e.g., "#div1"

//alert("SKK");
//alert(targetDivId);

        //Modal 
        $(targetDivId).show();

        // When the user clicks on <closeBtn> (x), close the modal
        $(".close").click(function(){
                $(targetDivId).hide();
        });

        // Prevent clicks inside the modal content from closing the modal
        $('.modal').on('click', function(e) {
            e.stopPropagation();
        });

    });

}); //End of document ready function
