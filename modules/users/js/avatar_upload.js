jQuery( document ).ready(function() {

    AvatarUploadEvent();
    AvatarHover();
});


function AvatarHover()
{
    $( "#user-image img" ).hover(
        function() {
            $( this ).next().fadeIn();
        }, function() {
            $( this ).next().fadeOut();
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