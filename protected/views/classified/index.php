<?php
/* @var $this adminController */

$this->pageTitle=Yii::app()->name;

foreach($model as $oneobject)
{
    echo $oneobject->id;
}

$this->widget('CLinkPager',array(
    'currentpage'=>$pages->getCurrentPage(),
    'itemcount'=>$count,
    'pageSize'=>$page_size,
    'maxButtonCount'=>5,
));
?>


