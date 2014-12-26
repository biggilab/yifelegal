<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <?php // Yii::app()->bootstrap->register(); ?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/screen.css.less" media="screen, projection">-->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blockScroll.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.sidr.dark.css">
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <style>
/*        div.navbar-header>a.navbar-brand{
             padding: 8px 15px 0px 15px;
            display: block;
            margin: auto;
            width: 120px;
            float: none;
            overflow: hidden;
        }*/
    @media (min-width: 1200px) {
        .navbar-toggle {
            display: block !important;
            outline: none;
            outline: 0;
            outline: thin dotted \9;
        }.navbar-brand{
        margin-left: 12% !important;
    }
    }
    @media (min-width: 768px) {
        .navbar-brand{
            margin-left: 12% !important;
        }
		 
		
    }
    @media (max-width: 992px) {
        .navbar-toggle {
            display: block !important;
            outline: none;
            outline: 0;
            outline: thin dotted \9;
    }
   
    .navbar-left{
        float: left !important;
    }
    }
    .navbar-toggle {
    display: block !important;
    outline: none;
    outline: 0;
    outline: thin dotted \9;
}
.navbar-right{
    border: none;
}
.navbar-right.acounts{
    padding: 9px 0px 9px 10px;
margin-top: 8px;
margin-bottom: 8px;
}
.acounts .btn-login{
    color: #fff;
    
}
.acounts .btn-signup{
    
    padding: 4px 7px;
    margin-left: 5px;
    border-radius: 8px;
    text-decoration: none !important;
    border: none;
    cursor: pointer;
}
.navbar.navbar-inverse.navbar-fixed-top{
    //position: absolute;
	//top: 0;
}
.sidr-overlay {
    top: 0;
    left: 0;
    display: none;
    z-index: 99;
    background:rgba(0,0,0,0.6);
    height: auto;
    width: auto;
    overflow: auto;
    overflow-y: scroll;
}
.sidr-overlay-fixed {
    position: fixed;
    bottom: 0;
    right: 0;
}

.sidr-overlay {
    overflow: auto;
    overflow-y: auto;
}
html,body,div.index-search-form-container, body div.container{
	//height: 100%;
   // height:auto !important; 
    min-height: 100%; 
   
   //height: 100% auto; 
}
.index-search-form-container{
	display: table;
	width: 100%;
	padding: 0% 25%;
	
}
.index-search-form{
	display: table-cell;
	vertical-align: middle;
	text-align:center;
}
.navigation-index{
	margin:  0px;
	margin-bottom: 4%;
	
}
.navigation-index li{
	list-style: none;
    
}
.navigation-index li a{
	
	text-decoration: none;
	font-weight: bold;

	
}
#sidr ul li i{
	margin-right: 20px;
}

.circle {
    background:  #7aba7b;
	border-radius: 50%;
	width: 20px;
	height: 20px; 
	/* width and height can be anything, as long as they're equal */
}
    </style>
</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <button type="button" class="navbar-toggle navbar-left" data-toggle="collapse" data-target="" id="simple-menu" href="#sidr">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="container">
            <div class="navbar-header" style=" float: none; text-align: center">

                <?php
                    if(!Yii::app()->user->isGuest)
                    {
                        echo    '<button type="button" class="navbar-toggle navbar-right" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="glyphicon glyphicon-user" style="color:white;"></span>
                                </button>';
                    }
					else
					{
						echo '<div class=" navbar-right acounts hidden-xs">
								<a class=" navbar-btn btn-login " href="'.$this->createUrl(Yii::app()->baseUrl.'/Main/login').'">Login</a> 
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
