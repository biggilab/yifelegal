<div class="row" style="padding-top: 100px;">
    <div class="container col-xs-12 col-sm-7 col-md-8  " style="">
        <img class="img-responsive" src='<?php echo Yii::app()->baseUrl."/images/yifelegal_logo_1_600X200.png"; ?>' />

    </div>
    <div class="container col-xs-12 col-sm-5 col-md-4 gray-boarder-round" style="">
        <h3> User login</h3>
        <div style="margin: 0 auto; padding: 0px 4px 0px 4px;">
            <form action="#" method="post" class="login_form" id="login_form">
                <div class="alert  alert-dismissible margin-bottom-8px hidden" role="alert">
                     <button type="button" class="close" data-dismiss="alert">
                         <span aria-hidden="true">&times;</span>
                         <span class="sr-only">Close</span>
                     </button>
                   <span class="glyphicon glyphicon-remove "></span> 
                   <span id="msg"></span>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">User name</div>
                    <div class="col-xs-8 login_email">
                        <input class=" round-corners-8px form-control" type="text" name="username" id="login_username" placeholder="user name"/>
                    </div>
                </div>
                <div class="row margin-bottom-8px">
                    <div class="col-xs-4 text-right">Password</div>
                    <div class="col-xs-8 login_password">
                        <input class=" round-corners-8px form-control" type="password" name="password" id="login_password"/>
                    </div>
                </div>

                <input class="col-xs-12 btn-success submit-form" type="submit"/>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
loginsubmiturl = "<?php echo $this->createUrl(Yii::app()->baseUrl."/mainusers/loginsubmit") ?>";
indexurl= "<?php echo $this->createUrl(Yii::app()->baseUrl."/main/index") ?>";

</script>