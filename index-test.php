<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();

//////////////////////////////////////////////////////

<li class="active"><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/classified/index")?>">Classifieds</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/page",array('view'=>'about'))?>">Auto</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/contact")?>">Auctiones</a></li>
                    <li><a href="<?php echo $this->createUrl(Yii::app()->baseUrl."/Main/contact")?>">Jobs</a></li>
                    