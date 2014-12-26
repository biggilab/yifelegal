<?php
/* @var $this adminController */

$this->pageTitle=Yii::app()->name;
?><link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fullPage.css" />
<div class=" row">
    <div class="col-xs-12 navbar-fixed-top" id="step_menu_container" style="top: 50px; background:  #EFEFEF">
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
                <div class="col-xs-12 classlvl lvl0 text-center">
                    <div id="cat-lvl-1">
                        <h3>Select category</h3>
                            <?php
                                $model = CatLvl1::model()->findAll();
                                echo "<select class='btn btn-lg' id='cat-lvl-1-select' data-next-lvl='2' name='cat-lvl-1' id='cat-lvl-1-select'><option value='-1'></option>";
                                foreach ($model as $onemodel)
                                {
                                    echo "<option value='$onemodel->id' >".$onemodel->name."</option>";
                                }
                                echo  "<option value='0'>Other</option></select>";
                            ?>

                        <input type="text" class="category-input hidden" id="cat-lvl-1-select-other" placeholder="enter category" name='cat-lvl-1-select-other'/>
                    </div>
                    <div id="cat-lvl-2">
                        
                           
                    </div>
                    <div id="cat-lvl-3">
                       
                           
                    </div>
                    <div id="cat-btn-container" class="text-right">
                        <a href="#section2" id="btn-back" class="btn btn-lg">Back</a><a href="#section2" id="btn-next" class="btn btn-lg">Next</a>
                    </div>
                </div><!-- End of section0-->
               
            </div>

            <!--</div> end of section 1 -->


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
                <div id="cat-btn-container" class="text-right">
                        <a href="#section1" id="btn-back" class="btn btn-lg">Back</a><a href="#section3" id="btn-next" class="btn btn-lg">Next</a>
                </div>
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
                <div id="cat-btn-container" class="text-right">
                        <a href="#section2" id="btn-back" class="btn btn-lg">Back</a><a href="#" id="btn-next" class="btn btn-lg">Post</a>
                </div>
            </div>
            <div class="col-xs-12 section " id="section4">
                <h1>section4</h1>
            </div>
            <div class="col-xs-12 section " id="section5">
                <h1>section5</h1>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fullPage.js"></script>
<!-- This following line is needed only in case of using other easing effect rather than "linear", "swing" or "easeInQuart". You can also add the full jQuery UI instead of this file if you prefer -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.easings.min.js"></script>


<!-- This following line needed in the case of using the plugin option `scrollOverflow:true` -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.slimscroll.min.js"></script>
<script>
    var getcatlvllisturl = "<?php echo Yii::app()->createUrl('classified/getcatlvllist'); ?>";
//    function init_other(object)
//    {
//        if(object.val()==='0')
//        {
//            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
//            $("#"+object.attr("id")+"-other").removeClass("hidden").css({"height":object.css("height"),"border-radius":object.css("border-radius"),"width":object.css("width")});
//            $("#"+object.attr("id")+"-other").focus();
//        }
//        else
//        {
//            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
//            $("#"+object.attr("id")+"-other").addClass("hidden");
//             var data = { lvl: object.attr("data-next-lvl"),
//                         id : object.val()
//                        }
//           var paramdata= JSON.stringify(data);
//           $.post(
//			getcatlvllisturl,
//			{ data: paramdata },
//			function(data)
//			{
//                var result = JSON.parse(data);
//                if(result.error===false)
//                {
//                    $("#cat-lvl-"+object.attr("data-next-lvl")).append(result.data);
//                    $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").change(function(){
//                                  init_other($(this));
//                            })  ;
//                    if(result.empty===1)
//                    {
//                         $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").val(0).trigger('change');
//                    }
//                }
//            });
//        }
//    }
//    function collect_step_1_data()
//    {
//        var data= new Array;
//        for (var i=1; i<4; i++)
//        {
//            var select=$("#cat-lvl-"+i+"-select").val();
//            if(select==='0')
//            {
//                var _data={
//                            new_:'yes',
//                            data:$("#cat-lvl-"+i+"-select-other").val()
//                          };
//                          data[i]=_data;
//            }
//            else
//            {
//                var _data={
//                                    new_:'no',
//                                    data:$("#cat-lvl-"+i+"-select").val()
//                                };
//                                data[i]=_data;
//            }
//        }
//        return data;
//    }
    $(document).ready(function() {
    $('#fullpage').fullpage({
            resize:false,
            anchors: ['firstPage', 'secondPage', 'thirdPage', 'fourthPage'],
            menu: '#myMenu',
            css3: true,
        scrollingSpeed: 1000});
    $("#cat-lvl-1-select").change(function(){
            init_other($(this));
    })  ;  
    $("#btn-next").click(function(){
        alert(JSON.stringify(collect_step_1_data()));
    });
        
});

    </script>