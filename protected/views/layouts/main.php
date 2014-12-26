<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/screen.css.less" media="screen, projection">-->
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                <a class="navbar-brand" style="padding: 8px 15px 0px 15px;" href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/index")?>"><img src="<?php echo Yii::app()->baseUrl.'/images/yifelegal_logo_1_88X41.png'; ?>" /></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/classified/index")?>">Classifieds</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/page",array('view'=>'about'))?>">Auto</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/contact")?>">Auctiones</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/contact")?>">Jobs</a></li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(Yii::app()->user->isGuest)
                    {
                        echo '<li><a href="'.$this->createUrl(Yii::app()->baseUrl."/Mainusers/login").'">Login</a></li>';
                    }
                    else 
                    {
                        echo '<li><a href="'.$this->createUrl(Yii::app()->baseUrl."/Main/logout").'">Logout '.Yii::app()->user->name.'</a></li>';
                    }
                    ?>
                </ul>
            </div><!--/.nav-collapse -->
          </div>
    </div>
    <div class="container" style="padding-bottom: 80px;" >
        <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
        <?php endif?>
        <?php echo $content; ?>
        <div class="clear"></div>
    </div><!-- page -->
    <div class="footer">
          <div class="container">
              <p class="text-muted text-center" style="margin: 0px;">Copyright &copy; <?php echo date('Y'); ?> <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
            All Rights Reserved.</p>
          </div>
    </div>
<?php 
Yii::app()->clientScript->registerScriptFile("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-1.11.1.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap.js'); ?>
</body>
</html>
