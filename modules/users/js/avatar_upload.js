jQuery( document ).ready(function() {

    AvatarUploadEvent();
    AvatarHover();
});


function AvatarHover()
{
    //$('body').undelegate('#user-image img','hover');
    //$('body').delegate('#user-image img','hover',function() {
    //    console.log(11);
    //        $(this).after('<div class="image_tooltip col-lg-12">Upload Image</div>');
    //});
    $( "#user-image img" ).hover(
        function() {
            $( this ).append('<div class="image_tooltip col-lg-12"><h3>Upload Image</h3></div>');
        }, function() {
            //$( this ).next().remove();
        }
    );
}

function AvatarUploadEvent()
{
    $('body').undelegate('#user-image_path','change');
    $('body').delegate('#user-image_path','change',function()
    {
        var domThis = $(this);
        if (domThis.val()=='') return;
        // Request avatar save
       domThis.closest('form').submit();
    });
}