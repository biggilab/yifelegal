<?php
/* @var $this adminController */

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

<div class="row-fluid results-container">
    <div class="col-xs-12 col-sm-12 col-md-4 filter-container text-right" id="filter-container">sda</div>
    <div class="col-xs-12 col-sm-12 col-md-8 content-container" id="content-container">
        <?php
        foreach($model as $oneobject)
        {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6 text-left" ><?php echo $oneobject->title;?></div>
                    <div class="col-xs-6 text-right"><?php echo $oneobject->create_date;?></div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-2 text-left image-cel-cont">
                        <div href="#" class="thumbnail">
                            <img src="<?php echo isset($oneobject->thumbnail)? Classifiedimage::IMG_DIRECTORY.$oneobject->id."/thumb/".$oneobject->thumbnail : "/images/classifieds/f3d7d747.jpeg" ?>" alt="...">
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 text-left"><?php echo $oneobject->classifiedsprofiles->description;?></div>
                    <div class="col-xs-2 col-md-2 col-sm-2 col-xs-offset-10 col-md-offset-0 text-right" ><?php echo "Birr ". $oneobject->price;?></div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <div class="clearfix"></div>
    </div>
<!--</div>-->

<div class="text-center">
<?php
$this->widget('CLinkPager',array(
    'currentpage'=>$pages->getCurrentPage(),
    'itemcount'=>$count,
    'pageSize'=>$page_size,
    'header' => '',
    'footer' => '',
//    'firstPageLabel'=>'',
//    'lastPageLabel'=>'',
    'nextPageLabel' => 'Next',
    'prevPageLabel' => 'Back',
    'maxButtonCount'=>5,
    'selectedPageCssClass' => 'active',
    'hiddenPageCssClass' => 'disabled',
    'htmlOptions'=>array('class'=>'pagination'),
));

?>
</div>



