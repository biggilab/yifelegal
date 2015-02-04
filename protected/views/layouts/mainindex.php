<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <?php // Yii::app()->bootstrap->register(); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="language" content="en">
	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/screen.css.less" media="screen, projection">-->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/blockScroll.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.sidr.dark.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.mainindex.css">
</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="main-header">
        <button type="button" class="navbar-toggle navbar-left" data-toggle="collapse" data-target="" id="simple-menu" href="#sidr">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="container">
            <div class="navbar-header" style=" float: none; text-align: center">
                <a tabindex="0" class="toggle navbar-right navbar-toggle" id="user-icn-toggle" data-toggle="popover" data-placement="bottom" >
                    <span class="glyphicon glyphicon-user" style="color:white;"></span>
                </a>
                <?php
                    if(!Yii::app()->user->isGuest)
                    {
//                        echo    '<a  class="navbar-toggle navbar-right" data-toggle="collapse" data-target=".navbar-collapse">
//                                    <span class="glyphicon glyphicon-user" style="color:white;"></span>
//                                </a>';
                    }
					else
					{
						echo '<div class=" navbar-right acounts hidden-xs">
								<a class=" navbar-btn btn-login " href="'.$this->createUrl(Yii::app()->baseUrl.'/Mainusers/login').'">Login</a> 
								<a class="navbar-btn btn-success btn-signup " href="'.$this->createUrl(Yii::app()->baseUrl.'/mainusers/signup').'">Signup</a>
							  </div>';
					}
                ?>
                <a class="navbar-brand" style=" float: none;padding: 8px 15px 0px 15px;" href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/index")?>"><img src="<?php echo Yii::app()->baseUrl.'/images/yifelegal_logo_1_88X41.png'; ?>" style="margin-top:8px;" /></a>
                
                </div>
            </div>
                </div>
    <div class="container" style="padding-bottom: 80px; padding-top: 20px;" >
        <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
        <?php endif?>
        <?php echo $content; ?>
        <div class="clear"></div>
    </div><!-- page -->
    <div id="sidr">
        <!-- Your content -->
        <ul>
			<li class="inputs-div">
				<div class="input-group">
					<span class="input-group-addon">
						<i class=" glyphicon glyphicon-search"></i>
					</span>
					<input type="text" class="form-control" style=" margin-bottom: 0px;" placeholder="Search">
				</div>
			</li>
			<li><a href="#"><i class="glyphicon glyphicon-tag"></i>I want to sale</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-shopping-cart"></i>I want to buy</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-road"></i>Auto</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-list-alt"></i>Classifieds</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-eye-open"></i>Jobs</a></li>
			<li><a href="#"><i class="glyphicon glyphicon-usd"></i>Auction</a></li>
			<li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl.'/Main/login') ?>"><i class="glyphicon glyphicon-user"></i>Login</a></li>
			<li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl.'/mainusers/signup') ?>"><i class="glyphicon glyphicon-user"></i>Register</a></li>
        </ul>
    </div>
    <div class="footer">
        <div class="container">
            <p class="text-muted text-center" style="margin: 0px;">Copyright &copy; <?php echo date('Y'); ?> <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
          All Rights Reserved.</p>
        </div>
    </div>
    <div class="sidr-overlay sidr-overlay-fixed"></div>
    <div id="usr-icn-cont" style="display:none;">
        <div class="user-popover-content">
            <ul>
                <li>
                    <span class="glyphicon glyphicon-plane"></span>
                    Logout
                </li>
            </ul>
        </div>
    </div>
<?php 
Yii::app()->clientScript->registerScriptFile("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-1.11.1.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap.js'); 
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/custom-select-menu.jquery.min.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-select.js');
?>

<?php  //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/blockScroll.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.sidr.min.js');
?>
    <script type="text/javascript">
         
    $(document).ready(function() {
//      $('select').customSelectMenu();
//        $('select').selectpicker({
//              style: 'btn-primary',
//              size: 10,
//             
//          });
    $("#user-icn-toggle").popover({
        html:true,
//        title : 'Default title value',
        content: $("#usr-icn-cont").html(),
        
    });
      $('#simple-menu').sidr({
      side: 'left',
      
      onOpen :function(){
			$(".sidr-overlay").css("display","block");
			$(".navbar-fixed-top").animate({left: $("#sidr").width()+"px"}, 200);//.css("left",$("#sidr").width()+"px");
      },
      onClose : function(){
           $(".sidr-overlay").css("display","none");
		   $(".navbar-fixed-top").animate({left: "0px"}, 200);
      }
  });
  $(document).mouseup(function(e) {
		e.stopPropagation();
		if(!$(e.target).closest('#sidr').length) {
			if($('#sidr').is(":visible")) {
				$(".navbar-toggle").trigger("click");
			} 
		}
	});
});
    </script>
</body>
</html>
