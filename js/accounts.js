/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var Registeruserurl;
function validemail(element_id)
{
    var email=$.trim($("#"+element_id).val());
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if(atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length)
    {
        $('.'+element_id).addClass("has-error");
        return false;
    }
    else
    {
         $('.'+element_id).removeClass("has-error");
         return true;
    }
}
function validfield(element_id)
{
    var input_=$.trim($("#"+element_id).val());
    if(input_.length<2)
    {
        $('.'+element_id).addClass("has-error");
        return false;
    }
    else
    {
         $('.'+element_id).removeClass("has-error");
         return true;
    }
}
function validpassword(pass_id)
{
	var password = $("#"+pass_id);
	//it's NOT valid
	if(password.val().length <5){
		$("."+pass_id).addClass("has-error");
		return false;
	}
	//it's valid
	else{			
		$("."+pass_id).removeClass("has-error");
		return true;
	}
}
function pass1_is_pass2(pass1_id, pass2_id)
{
    var password1 = $("#"+pass1_id).val();
    var password2 = $("#"+pass2_id).val();
    if(password1 != password2)
    {
        $("."+pass2_id).addClass("has-error");
        return false;
    }
    else
    {			
        $("."+pass2_id).removeClass("has-error");
        
        return true;
    }
}
function validatepassword(pass1_id, pass2_id)
{
    if(validpassword(pass1_id) && pass1_is_pass2(pass1_id,pass2_id) )
    {
         $("."+pass2_id).removeClass("has-error");
         $("."+pass1_id).removeClass("has-error");
         return true;
    }
    else
    {
        return false;
    }
}
function formuserdata(form_id)
{
    var userdata= {
                    firstname:$('#'+form_id+' #reg_firstname').val(),
                    lastname:$('#'+form_id+' #reg_lastname').val(),
                    email:$('#'+form_id+' #reg_email').val(),
                    password:$('#'+form_id+' #reg_firstname').val(),
                  }
    return userdata;
}
function register(form_id)
{   var user = formuserdata(form_id);
    var paramJSON= JSON.stringify(user);
    $("."+form_id+" .submit-form").attr("disabled","disabled");
    $.post(
                Registeruserurl,
		{ data: paramJSON },
		function(data)
                {
                    var result=JSON.parse(data);
                    if(result.error==1)
            { 
                $("."+form_id+"  .alert").removeClass("alert-success");
                $("."+form_id+"  .alert").addClass("alert-danger");
                $("."+form_id+"  .alert #msg").html("<strong>Error : "+result.msg);
                $("."+form_id+"  .alert .glyphicon").removeClass("glyphicon-ok-sign");
                $("."+form_id+"  .alert .glyphicon").addClass("glyphicon-remove-sign");
                $("."+form_id+"  .alert").removeClass("hidden");
                $("."+form_id+"  .submit-form").removeAttr("disabled");
            }
            else
            {
                $("."+form_id+"  .alert").removeClass("alert-danger");
                $("."+form_id+"  .alert").addClass("alert-success");
                $("."+form_id+"  .alert #msg").html("<strong>Success : "+result.msg);
                $("."+form_id+"  .alert .glyphicon").removeClass("glyphicon-remove-sign");
                $("."+form_id+"  .alert .glyphicon").addClass("glyphicon-ok-sign");
                $("."+form_id+"  .alert").removeClass("hidden");
            }
                    
                }
            );
    
}
$(document).ready(function(){
    
    $(".reg_form .submit-form").click(function(e)
    {
        
        if(validfield('reg_firstname') && validfield('reg_lastname') && validemail('reg_email') && validatepassword('reg_password','reg_repassword') )
        {
           
            var result=register("reg_form");
            
            
            return false;
        }
        else
        {   $(".reg_form .submit-form").removeAttr("disabled");        
            return false;
        }
        
    });
});
