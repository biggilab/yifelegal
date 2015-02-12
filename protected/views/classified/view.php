<?php
/* @var $this classifiedController */

$this->pageTitle=Yii::app()->name;
//
//foreach($model as $oneobject)
//{
//        echo '<div>';
//        foreach ($oneobject->classifiedimage as $oneimage)
//        {
//            echo "<img src='".Classifiedimage::IMG_DIRECTORY."/".$oneobject->id."/thumb/".$oneimage->name."' /><br/>";
//        }
//    echo "</div>";
//}

?>
<div class="classified-view-cont row-fluid">
    <div class="row title-n-thumb">
        <div class="col-xs-5 col-md-3">
            <a href="#" class="thumbnail">
                <img src="<?php echo Classifiedimage::IMG_DIRECTORY."/".$model->id."/thumb/".$model->thumbnail?>" alt="...">
            </a>
        </div>
        <div class="col-xs-7 col-md-9">
            <div class="row">
                <div class="col-xs-12 yifelegal-default-title"><?php echo $model->title;?></div>
                <div class="col-xs-6"><i>Posted on </i></div>
                <div class="col-xs-6 text-right">price</div>
            </div>
            
        </div>
    </div>
    <div class="clearfix"></div>
</div>
