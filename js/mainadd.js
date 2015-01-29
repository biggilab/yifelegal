var getcatlvllisturl ;
var addnewclassifiedurl;
var step1passed=false;
var step2passed=false;
/**
 * validates an input object and adds eror class if validation fails
 * @param {type} object
 * @returns {Boolean}
 */
function validate_input(object)
{
    if (object.val() === null || object.val() === "" || object.val() === " ") 
    {
        object.addClass("cat-error");
        return false;
    }
    else
    {
        return true;
    }
}
/**
 * validates athe step one of adding classified post
 * @returns {Boolean}
 */
function validat_step_1()
{
    var error=false;
    for (var i=1; i<4; i++)
        {
            if($("#cat-lvl-"+i+"-select").length>0)
            {
                var select=$("#cat-lvl-"+i+"-select").val();
                if(select==='0' && ($("#cat-lvl-"+i+"-select-other").val()===""||$("#cat-lvl-"+i+"-select-other").val()===" "))
                {
                    $("#cat-lvl-"+i+"-select-other").addClass("cat-error");
                    $('#section1-alert>span.msg-box').empty().append("You must enter a catergory after selecting 'other'!");
                    $('#section1-alert').fadeIn('slow');
                    return false;
                }
                else if(select < 0)
                {
                   $("#cat-lvl-"+i+"-select").addClass("cat-error");
                   $('#section1-alert>span.msg-box').empty().append("You must select a category!");
                   $('#section1-alert').fadeIn('slow');
                   return false;
                }
                else
                {
                     $('#section1-alert').fadeOut();
                     $("#cat-lvl-"+i+"-select-other").removeClass("cat-error");
                   error= true;
                }
            }
            
        }
        return error;
}
function validat_step_2()
{
    var inputs= new Array;
    var error=true;
    inputs[0] =$("#title");
    inputs[1] =$("#price");
    inputs[2]=$("#condition-select");
    for (var x=0; x < inputs.length; x++ )
    {
        if(!validate_input(inputs[x]))
        {
            $('#section2-alert>span.msg-box').append("You must enter "+inputs[x].attr("name")+'!<br/>');
            $('#section2-alert').fadeIn();
            inputs[x].keyup(function(){
                clear_error($(this),"section2-alert");
            });
            var error=false;
        }
    }
    return error;
}
function validat_step_3()
{
    var inputs= new Array;
    var error=true;
    inputs[0] =$("#description");
    inputs[1] =$("#phone");
    for (var x=0; x < inputs.length; x++ )
    {
        if(!validate_input(inputs[x]))
        {
            $('#section3-alert>span.msg-box').append("You must enter "+inputs[x].attr("name")+'!<br/>');
            $('#section3-alert').fadeIn();
                inputs[x].keyup(function(){
                    clear_error($(this),"section3-alert");
                });
            error=false;
        }
    }
    return error;
}
function validate_step_4()
{
    var file=$("#img-up-input").val();
    if(file.search(/jpeg/i)>0 || file.search(/jpg/i)>0 || file.search(/gif/i)>0 || file.search(/png/i)>0)
    {
        $("#section4-alert .msg-box").empty();
        $("#section4-alert").fadeOut("slow");
        $("#upload_img").removeClass("disabled")
        return true;
    }
    else
    {
        $("#section4-alert .msg-box").empty().append("The image format you selected is not supported.")
        $("#section4-alert").fadeIn("slow");
        $("#upload_img").hasClass("disabled")? true : $("#upload_img").addClass("disabled");
        return false;
    }
    
}
function clear_error(object,alert_id)
{
    $('#'+alert_id).fadeOut();
    $('#'+alert_id+'>span.msg-box').empty();
    if(object.val()>='0')
        {
           object.removeClass("cat-error");
        }
}
function step1_init_other(object)
{
        clear_error(object,'section1-alert');
        if(object.val()<='0')
        {
            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
            $("#"+object.attr("id")+"-other").removeClass("hidden").css({"height":object.css("height"),"border-radius":object.css("border-radius"),"width":object.css("width")});
            $("#"+object.attr("id")+"-other").focus();
        }
        else
        {
            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
            $("#"+object.attr("id")+"-other").addClass("hidden");
             var data = { lvl: object.attr("data-next-lvl"),
                         id : object.val()
                        }
           var paramdata= JSON.stringify(data);
           $.post(
			getcatlvllisturl,
			{ data: paramdata },
			function(data)
			{
                var result = JSON.parse(data);
                if(result.error===false)
                {
                    $("#cat-lvl-"+object.attr("data-next-lvl")).append(result.data);
                    $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").change(function(){
                                  step1_init_other($(this));
                            })  ;
                    if(result.empty===1)
                    {
                         $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").val(0).trigger('change');
                    }
                }
            });
        }
}
function collect_step_1_data()
{
    var data= new Array;
    for (var i=1; i<4; i++)
    {
        if($("#cat-lvl-"+i+"-select").length>0)
        {
            var select=$("#cat-lvl-"+i+"-select").val();
            if(select==='0')
            {
                var _data={
                            new_:'yes',
                            data:$("#cat-lvl-"+i+"-select-other").val()
                          };
                          data[i]=_data;
            }
            else
            {
                var _data={
                                    new_:'no',
                                    data:$("#cat-lvl-"+i+"-select").val() | null
                                };
                                data[i]=_data;

            }
        }
    }
    return data;
    
}
function collect_step_1_data_()
{
    var data= new Array;
    for (var i=1; i<4; i++)
    {
        var select=$("#cat-lvl-"+i+"-select").val();
        if(select==='0')
        {
            var _data={
                        new_:'yes',
                        data:$("#cat-lvl-"+i+"-select-other").val()
                      };
                      data[i]=_data;
        }
        else
        {
            var _data={
                                new_:'no',
                                data:$("#cat-lvl-"+i+"-select").val() | null
                            };
                            data[i]=_data;

        }
    }
    
    return data;
}
    function collect_step_2_data()
    {
        return  {
                    title :     $("#title").val(),
                    price :     $("#price").val(),
                    negotiable: $("#negotiable").is(":checked"),
                    condition:  $("#condition-select").val(),
                    brand :     $("#brand").val(),
                    model :     $("#model").val(),
                    year :      $("#year").val()
                };
    }
function savenewpost()
{
    var data= {
                classified_id: $("#classified_id").val(),
                st1_data:collect_step_1_data(),
                st2_data:collect_step_2_data(),
                st3_data:{
                           description:$("#description").val(),
                           phone:$("#phone").val(),
                           broker:$("#broker").is(":checked"),
                         }
              }
    var paramDATA = JSON.stringify(data);
    var height= (window.innerHeight/2)-150;
    $("#overlay-screen-tin>div").css("margin-top",height);
    $("#overlay-screen-tin").fadeIn();
    $.post(
            addnewclassifiedurl,
            { data: paramDATA },
            function(data) {
                var result = JSON.parse(data);
                if(result.error===false)
                {
                    $("#classified_id").val(result.classified_id);
                    $("#classified_id_img").val(result.classified_id);
                    $("#overlay-screen-tin").fadeOut('slow');
                    window.location.hash='#section4';//nav;
                }
                
            });
}
function init_activate_mymenu_navigation()
{
    var index=/[0-9]/.exec(location.hash);
    $("#myMenue li>a[class='active_'").removeClass("active_");
    $("#myMenue li>a[href='#section"+index+"']").addClass("active_");
}
function before_img_upload_submit(){
//    alert("before");
$("#imageModal").modal("show");
}
function progress_uploaded_img(event, position, total, percentComplete) {
	$(".progress div.progress-bar").css("width", percentComplete + "%");
}
function img_upload_success(data){
    
    var result = JSON.parse(data);
    if(result.error===false)
    {
      $("#imageModal").modal("hide");  
      var img="<img src='"+result.imagesrc+"' class='img-responsive'/>";
      $("#img-place-holder").empty().append(img);
      $("#img-place-holder img").fadeIn();
      $("#img-up-input").val().empty()
      $("#upload_img").addClass("disabled");
    }
}
function init_upload_image()
{
    $("#image-upload-form").ajaxForm({
		beforeSubmit: before_img_upload_submit,
		uploadProgress: progress_uploaded_img,
		success: img_upload_success,
		error: function() {
			alert("Invalid image detected.");
		}
            });
        }
