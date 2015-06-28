jQuery(document).ready(
    function()
    {

        $("#channels-image_path").on("change",
            function()
            {
                var reader = new FileReader();
                reader.onload = function(e)
                {
                    $("#image_preview").attr("src",e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        );

        $("#channels_create").on("submit",
            function(event)
            {
                event.preventDefault();
                event.stopPropagation();

                if(!formValidate()) return;

                var formData = new FormData(document.getElementById("channels_create"));
                var errors = $("#channels_create").find("div.has-error");
                if(errors.length) return;
                formData.append("channel_tags",$("#channel_tags").val());

                $.ajax({
                    url: "/web/index.php?r=channels/ajax/create",
                    type: "POST",
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    success:function(response)
                    {
                        var res = JSON.parse(response);
                        var message = "";
                        if(res.status == "error")
                        {
                            for(var key in res.message )
                            {
                                message += res.message[key] + "<br>";
                            }
                            $("#channels_create").find("p.bg-success").remove();
                            $("#channels_create").find("p.bg-danger").remove();
                            $("#channels_create").append("<p>"+message+"</p>").find("p").hide().addClass("bg-danger").fadeIn(1000);
                        }
                        else if(res.status == "ok")
                        {
                            for(var key in res.message )
                            {
                                message += res.message[key] + "<br>";
                            }
                            $("#channels_create").find("p.bg-success").remove();
                            $("#channels_create").append("<p>"+message+"</p>").find("p:last-child").addClass("bg-success").hide().fadeIn(1000);
                        }
                    }
                });

            }
        );

        var formValidate = function()
        {
            var mark = true;
            // channels-title
            if(!$("#channels_create #channels-title").val())
            {
                $("#channels_create .form-group.field-channels-title").addClass("has-error");
                mark=false;
                $("#channels_create .field-channels-title").find(".help-block")
                    .text("поле обязательно для заполнения!")
                    .closest(".field-channels-title")
                    .addClass("has-error");
            }
            else
            {
                $("#channels_create .field-channels-title").removeClass("has-error").find(".help-block").text("")
            }

            // channel_tags
            if(!$("#channels_create #channels_tags_container .tag.label").length)
            {
                $("#channels_create #channels_tags_container .bootstrap-tagsinput").css("borderColor","#a94442");
                $("#channels_create #channels_tags_container label[for=\"channel_tags\"]").css("color","#a94442");
                $("#channels_create #channels_tags_container .help-block").remove("");
                $("#channels_create #channels_tags_container").append("<div class=\"help-block\">поле обязательно для заполнения!</div>").find(".help-block").css("color","#a94442");
                mark=false;
            }
            else
            {
                $("#channels_create #channels_tags_container .bootstrap-tagsinput").css("borderColor","#3c763d");
                $("#channels_create #channels_tags_container label[for=\"channel_tags\"]").css("color","#3c763d");
                $("#channels_create #channels_tags_container .help-block").remove();
            }

            // channels-description
            if(!$("#channels_create #channels-description").val())
            {
                $("#channels_create .form-group.field-channels-description").addClass("has-error")
                    .find(".help-block")
                    .text("поле обязательно для заполнения!");
                mark=false;
            }

            if(!mark) return false;
            else return true;
        }
    }
);