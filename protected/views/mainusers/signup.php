<div class="row" style="padding-top: 100px;">
    <div class="container col-xs-12 col-sm-7 col-md-8  " style="">
        <img class="img-responsive" src='<?php echo Yii::app()->baseUrl."/images/yifelegal_logo_1_600X200.png"; ?>' />
    </div>
    <div class="container col-xs-12 col-sm-5 col-md-4 gray-boarder-round" style="">
        <h3> Signup User</h3>
        <div style="margin: 0 auto; padding: 0px 4px 0px 4px;">
            <form action="#" method="post" class="reg_form" id="reg_form">
                <div class="alert  alert-dismissible margin-bottom-8px hidden" role="alert">
                     <button type="button" class="close" data-dismiss="alert">
                         <span aria-hidden="true">&times;</span>
                         <span class="sr-only">Close</span>
                     </button>
                   <span class="glyphicon glyphicon-remove "></span> 
                   <span id="msg"></span>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">First name</div>
                    <div class="col-xs-8 reg_firstname">
                        <input class=" round-corners-8px form-control" type="text" name="firstname" id="reg_firstname" placeholder="First name"/>
                    </div>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">Last name</div>
                    <div class="col-xs-8 reg_lastname">
                        <input class=" round-corners-8px form-control" type="text" name="lastname" id="reg_lastname" placeholder="Last name"/>
                    </div>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">Email</div>
                    <div class="col-xs-8 reg_email">
                        <input class=" round-corners-8px form-control" type="text" name="email" id="reg_email" placeholder="E mail"/>
                    </div>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">Password</div>
                    <div class="col-xs-8 reg_password">
                        <input class=" round-corners-8px form-control" type="password" name="password" id="reg_password"/>
                    </div>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">Re Password</div>
                    <div class="col-xs-8 reg_repassword">
                        <input class=" round-corners-8px form-control" type="password" name="repassword" id="reg_repassword"/>
                    </div>
                </div>
                <input class="col-xs-12 btn-success submit-form" type="submit"/>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
Registeruserurl = "<?php echo $this->createUrl(Yii::app()->baseUrl."/mainusers/signupsubmit") ?>";
</script>