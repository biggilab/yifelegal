/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var loginsubmiturl;
function login(form_id)
{
    var userdata= {
                    username:$('#'+form_id+' #login_username').val(),
                    password:$('#'+form_id+' #login_password').val(),
                  }
    var paramJSON= JSON.stringify(userdata);
   $.post(
                loginsubmiturl,
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
    
    $(".login_form .submit-form").click(function(e)
    {
       login('login_form');
       $(".login_form .submit-form").removeAttr("disabled");        
       return false;
        
    });
});
