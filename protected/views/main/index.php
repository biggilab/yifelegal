<?php
/* @var $this adminController */

$this->pageTitle=Yii::app()->name;
?>

<div class="row" style="margin-right: 0 !important;">
	<a class="btn pull-right btn-primary" href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/add");?>"><i class="glyphicon glyphicon-pushpin"></i>Post Ad</a>
</div>
<div class="index-search-form-container">
	<div class="index-search-form">
		<div class="navigation-index">
			<img  class=" img-responsive"src="<?php echo Yii::app()->baseUrl.'/images/yifelegal_logo_1_420X200.png';?>" style="display: inline;"/>
		</div>
		<div class="navigation-index row">
			<li class=" col-xs-3"><a>Auction</a></li>
			<li class=" col-xs-3"><a>Automotive</a></li>
			<li class=" col-xs-3"><a>Classifides</a></li>
			<li class=" col-xs-3"><a>Jobs</a></li>
		</div>
		<form  >
			<div class="input-group">
				<span class="input-group-btn">
					<input type="text" class="form-control" style="width: 93.2%;">
					<button class="btn btn-default" type="submit"><i class=" glyphicon glyphicon-search"></i></button>
				</span>
			</div><!-- /input-group -->
		</form>
	</div>
</div>
