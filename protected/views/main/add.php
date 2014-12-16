<?php
/* @var $this adminController */

$this->pageTitle=Yii::app()->name;
?><link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fullPage.css" />
<div class=" row">
    <div class="col-xs-12 navbar-fixed-top" id="myScrollspy" style="top: 50px; background:  #EFEFEF">
        <ul class="nav"  id="myMenue">
                <li data-menuanchor="firstPage"><a href="#section1"><h3>1</h3></a></li>
                <li data-menuanchor="secondPage"><a href="#section2"><h3>2</h3></a></li>
                <li data-menuanchor="thirdPage"><a href="#section3"><h3>3</h3></a></li>
                <li data-menuanchor="fourthPage"><a href="#section4"><h3>4</h3></a></li>
            </ul>
    </div>
</div>

<div class="row classification_container" style="margin-top: 40px;">
    <div id="fullpage">
        <form class="form" id="addform">
            <div class="col-xs-12 section" id="section1">
                setion 1
                <div class="col-xs-12 classlvl lvl0 text-center">
                    <?php
                        $model = CatLvl1::model()->findAll();
                    
                    ?>
                    <!--<h5>Select the AD type</h5>-->
                     <?php 
                            
    //                 echo TbHtml::dropDownList('lvl0', '', $addtype,
    //
    //                                                array(
    //                                                        'prompt'=>'Select AD type',
    //                                                        'ajax' => array(
    //                                                                        'type'=>'POST', 
    //                                                                        'url'=>Yii::app()->createUrl('main/getclasslvl'), //or $this->createUrl('loadcities') if '$this' extends CController
    //                                                                        'beforeSend' =>"handle_other_select_lvl_1(this.value,0)",
    //                                                                        //'update'=>'#lvl2', 
    //                                                                        'success' => 'function(data){updateclasslvlselect(data,1);}',
    //                                                                        'data'=>array('classlvl_id'=>'js:this.value' ,'lvl'=>1),
    //                                                                        ),
    //                                                        'class'=>'btn-primary'
    //                                                    )
    //                                            );
    //               ?>

                </div><!-- End of section0-->
                <div class="col-xs-12 classlvl lvl1 text-center hidden">
                   <h5>Select category</h5>
                  

                </div><!-- End of classlvl1-->
                <div class="col-xs-12 classlvl lvl2 hidden text-center">
                    <h5>Select sub-category</h5>
                    <?php 
    //                echo TbHtml::dropDownList('lvl2', '', array(''=>""),
    //
    //                                                array(
    //                                                        'prompt'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
    //                                                        'ajax' => array(
    //                                                                        'type'=>'POST', 
    //                                                                        'url'=>Yii::app()->createUrl('main/getclasslvl'), //or $this->createUrl('loadcities') if '$this' extends CController                                                               
    //                                                                        'beforeSend' =>"handle_other_select_lvl_1(this.value,2)",
    //                                                                        //'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
    //                                                                        'success' => 'function(data){updateclasslvlselect(data,3);}',
    //                                                                        'data'=>array('classlvl_id'=>'js:this.value','lvl'=>3),
    //                                                                        ),
    //                                                        'class'=>'btn-primary'
    //
    //                                                    ),
    //                                                array('class'=>'your_class_name')
    //
    //                                            );
                   ?>

                </div>
                   <div class="col-xs-12 classlvl hidden lvl3 text-center">
                    <h4>select sub category</h4>
                    <?php 
    //                echo TbHtml::dropDownList('lvl3', '', array(''=>""),
    //
    //                                                array(
    //                                                        'prompt'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
    //        //                                                'ajax' => array(
    //        //                                                                'type'=>'POST', 
    //        //                                                                'url'=>Yii::app()->createUrl('YourController/loadcities'), //or $this->createUrl('loadcities') if '$this' extends CController
    //        //                                                                'update'=>'#city_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
    //        //                                                                'data'=>array('region_id'=>'js:this.value'),
    //        //                                                                ),
    //                                                        'class'=>'btn-primary'
    //
    //                                                    ),
    //                                                array('class'=>'your_class_name')
    //
    //                                            );
                   ?>

                </div>

            </div><!-- end of section 1 -->


            <div class="col-xs-12 section " id="section2">
                <h1>section2</h1>
                As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:
            </div>
            <div class="col-xs-12 section " id="section3">
                <h1>section3</h1>
                As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:As computers get faster you will want to increase the cost (number of rounds), and for high security applications you can: increase the rounds; use a more random salt generator; or generate a hash using multiple hashing mechanisms in sequence.

                The returned hash will now look something like this:
            </div>
            <div class="col-xs-12 section " id="section4">
                <h1>section4</h1>
            </div>
            <div class="col-xs-12 section " id="section5">
                <h1>section4</h1>
            </div>
            <div class="clearfix"></div>
            </div>
        </form>
 </div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fullPage.js"></script>
<!-- This following line is needed only in case of using other easing effect rather than "linear", "swing" or "easeInQuart". You can also add the full jQuery UI instead of this file if you prefer -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.easings.min.js"></script>


<!-- This following line needed in the case of using the plugin option `scrollOverflow:true` -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.slimscroll.min.js"></script>
<script>
    $(document).ready(function() {
    $('#fullpage').fullpage({
            resize:false,
            anchors: ['firstPage', 'secondPage', 'thirdPage', 'fourthPage', 'lastPage'],
            menu: '#myMenu'});
});
//    $(document).ready(function(){
//
////        $(function() {
////          var blockScroller = $("#addform").blockScroll();
////
////        });
//    //to update the  size of the canvas
//    $("div#myScrollspy ul li").click(function(){
////        var winheight=$(window).height();
//        var highlited_element=$(this).children().attr("href");
//        $("div#myScrollspy ul").find("a.active_").removeClass("active_");
//        $(this).children().addClass("active_")
////        $(highlited_element).css("height",winheight+'px')
//        //blockScroller.goto([block highlited_element]);
//    });
//    
////    var viewportWidth = $(window).width();
////    var viewportHeight = $(window).height();
//    
//    $(window).resize(function() {
//        
//        var viewportWidth = $(window).width();
//        var viewportHeight = $(window).height()-60;
//        alert(viewportHeight);
//        //alert(viewportWidth+"X"+viewportHeight);
//        $("body").height(viewportHeight);
//        $("classification_container").css("min-height","100%");    });
//});
//    function handle_other_select_lvl_1(id,parent_num)
//    {
//        
//        if(id==0)
//        {
//            var inp="<input type='text'>";
//            $("div.lvl"+parent_num).append(inp);
//            
//            return false;
//        }
//        else if(id<0)
//        {
//            var alert='<div class="alert alert-danger alert-dismissible" style="width :50%; margin : auto;" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Warning!</strong> You must select a category. If you cant find your category select other.</div>';
//            $("div .lvl"+parent_num).append(alert);
//            return false;
//        }
//    }
//    
//    function updateclasslvlselect(data,lvl)
//    {
//        var result = JSON.parse(data);
//        if(result.error==0 && result.found==1)
//        {
//            $('#lvl'+lvl).empty();
//            $('#lvl'+lvl).append("<option value='"+-1+"'>Select category</option>")
//            for (var x in result.data)
//            {
//                $('#lvl'+lvl).append("<option value='"+x+"'>"+result.data[x]+"</option>")
//            }
//            $('#lvl'+lvl).append("<option value='"+0+"'>other</option>")
//            $('#lvl'+lvl).append(data);
//            $('#lvl'+lvl).css("width",$('#lvl1').width());
//            $('#lvl'+lvl).parent().removeClass("hidden");
//        }
//        else
//        {
//            //alert(result.error +','+ result.found);
//        }
////        $('#lvl'+lvl).empty();
////        $('#lvl'+lvl).append(data);
////        $('#lvl'+lvl).css("width",$('#lvl1').width());
////        $('#lvl'+lvl).parent().removeClass("hidden");
//    }
    </script>