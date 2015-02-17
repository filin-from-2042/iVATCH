jQuery( document ).ready(function() {

    AvatarUploadEvent();
    AvatarHover();
    AvatarClicked();
});


function AvatarHover()
{
    $( ".wrapper_block" ).hover(
        function() {
            $( this ).find('.image_tooltip').fadeIn();
        }, function()
        {
            $( this ).find('.image_tooltip').fadeOut();
        }
    );
}

function AvatarClicked()
{
    $('body').undelegate('.image_tooltip','click');
    $('body').delegate('.image_tooltip','click',function()
    {
        var domThis = $(this);
       domThis.closest('#user-image').find('#user-image_path').click();
        console.log( domThis.closest('#user-image').find('#user-image_path'))
    });
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