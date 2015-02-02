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
<!--            <li data-menuanchor="section1"><a href="#section1" id="section1-nav"><h3>1</h3></a></li>
            <li data-menuanchor="section2"><a href="#section2" id="section2-nav"><h3>2</h3></a></li>
            <li data-menuanchor="section3"><a href="#section3" id="section3-nav"><h3>3</h3></a></li>
            <li data-menuanchor="section4"><a href="#section4" id="section4-nav"><h3>4</h3></a></li>-->
        </ul>
    </div>

</div>

<div class="row-fluid classification_container" style="margin-top: 40px;">
    <div id="fullpage" class="col-xs-12">
        <form class="form" id="adform" method="post" action="<?php echo Yii::app()->createUrl('classified/Addnewclassified'); ?>">
            <div class="row-fluid">
                <!--</div> end of section 1 -->
                <div class="col-xs-12 section" id="section1">
                    <div class="alert alert-danger alert-dismissible" style="display:none;" id="section1-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span class='msg-box'></span>
                    </div>
                    <div class="col-xs-12 classlvl lvl0 text-center">
                        <div id="cat-lvl-1">
                            <?php $clas= Classified::model()->findByPk(63);
//                            $clas->create_date= new CDbExpression('NOW()');
//                            $clas->save();
                            echo $clas->create_date."date";//new CDbExpression('NOW()');?>
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

                            <input type="text" class="category-input hidden required" id="cat-lvl-1-select-other" placeholder="enter category" name='cat-lvl-1-select-other'/>
                        </div>
                        <div id="cat-lvl-2">


                        </div>
                        <div id="cat-lvl-3">


                        </div>
                        <div id="cat-btn-container" class="text-right">
<!--                        <a href="#section2"  class="btn-back btn btn-lg">Back</a>-->
                            <a href="#section2" id="step1" class="btn-next btn btn-lg">Next</a>
                        </div>
                    </div>
                    <!-- End of section1-->

                </div>
                <!--</div> section 2 -->
                <div class="col-xs-12 section " id="section2">
                    
                    <div class="row-fluid">
                        <div class="alert alert-danger alert-dismissible" style="display: none;" id="section2-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i style="color: #000000; display:block; font-weight: normal;">All inputs with red lines are required.</i>
                            <span class='msg-box'></span>
                        </div>
                        <div class="col-xs-3 text-right">
                            <label>Title</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="section2-input-text" placeholder="Title" name="title" id="title"/>
                        </div>
                        <div class="clearfix"></div>    
                        <div class="col-xs-3 text-right">
                            <label>Price</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="section2-input-text" placeholder="Price" name="price" id="price"/>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="col-xs-3 text-right">
                            <label>Negotiable</label>
                        </div>
                        <div class="col-xs-9">
                            <input id="negotiable" class="checkbox-switch" type="checkbox" name="negotiable"  data-on-text='Yes' data-on-color="danger" data-off-text='No'>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="col-xs-3 text-right">
                            <label>Condition</label>
                        </div>
                        <div class="col-xs-9">
                            <select class='btn btn-lg' id='condition-select'  name='condition-select'>
                                <?php
                                
                                    $con=Classifiedsprofile::model()->condition_values;
                                    foreach($con as $key => $value)
                                    {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
<!--                                <option value="New-inside-original-box">New (inside original box)</option>
                                <option value="New-out-of-original-box">New (out of original box)</option>
                                <option value="slightly-used">Slightly used</option>
                                <option value="used-with-minor-faults">Used with minor faults</option>
                                <option value="used-not-working">Used, not working</option>-->
                            </select>
                        </div>
                        <div class="clearfix"></div>   
                        <div class="col-xs-3 text-right">
                            <label>Brand</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="section2-input-text section2-input-text-not-imp" placeholder="Brand" name="brand" id="brand"/>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="col-xs-3 text-right">
                            <label>Model</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="section2-input-text section2-input-text-not-imp" placeholder="model" name="model" id="model"/>
                        </div>
                        <div class="clearfix"></div> 
                         <div class="col-xs-3 text-right">
                            <label>Year</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="section2-input-text section2-input-text-not-imp" placeholder="year of production" name="year" id="year"/>
                        </div>
                        <div class="clearfix"></div> 
                        <div id="cat-btn-container" class="col-xs-12 text-right">
                                <a href="#section1"  class="btn-back btn btn-lg">Back</a>
                                <a href="#section3" id="step2" class="btn-next btn btn-lg">Next</a>
                        </div>
                    </div>
                    
                </div>
                <!--</div> end of section 2 -->
                <!-- SECTION 3-->
                <div class="col-xs-12 section " id="section3">
                    
                    <div class="row-fluid">
                        <div class="alert alert-danger alert-dismissible" style="display: none;"  id="section3-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i style="color: #000000; display:block; font-weight: normal;">All inputs with red lines are required.</i>
                            <span class='msg-box'>dasda</span>
                        </div>
                        <div class="col-xs-4 text-right">
                            <label>Description</label>
                        </div>
                        <div class="col-xs-8">
                            <textarea id="description" name="description" placeholder="Add more description to your Post"></textarea>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="col-xs-4 text-right">
                            <label>Phone</label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" class="section2-input-text" placeholder="phone" name="phone" id="phone"/>
                        </div>
                        <div class="clearfix"></div>
                         <div class="col-xs-4 text-right">
                            <label>Are you a broker?</label>
                        </div>
                        <div class="col-xs-8">
                            <input id="broker" class="checkbox-switch" type="checkbox" name="negotiable"  data-on-text='Yes' data-on-color="danger" data-off-text='No'>
                        </div>
                        <div class="clearfix"></div> 
                        
                    </div>
                    <div id="cat-btn-container" class="col-xs-12 text-right">
                        <a href="#section2"  class="btn-back btn btn-lg">Back</a>
                        <a href="#section4"  id="finish" class=" btn-next btn btn-lg">Finish</a>
                        <input type="hidden" name="classified_id" id="classified_id" value="0"/>
                        <button type="submit" id="ad-post-submit-btn" class="hidden"></button>
                    </div>
                </div>
                <!-- END OF SECTION 3 -->
                <!-- section 4 -->
                <div class="col-xs-12 section " id="section4">
                    <div class="row-fluid">
                        <div class="alert alert-danger alert-dismissible"  style="display: none;" id="section4-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i style="color: #000000; display:block; font-weight: normal;">Supported image types are 'jpeg', 'gif', 'png' only!</i>
                            <span class='msg-box'>dasda</span>
                        </div>
                        <div class="col-xs-8 col-xs-push-2 empty-image-holder text-center">
                            <div class="col-xs-12">
                                <span class="col-xs-12" id="img-place-holder">
                                    <img src="/images/classifieds/55/thumb/05b6c7cb.jpg" class="img-responsive"/>
                                Time to add a picture!!
                                </span>
                                <button type="button" class="btn-next" id="visible-add-img-btn" ><span class="glyphicon glyphicon-plus" aria-hidden="true" style="margin-right: 5px;"></span>Add</button>
<!--                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Launch modal</button>-->
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="cat-btn-container" class="text-right">
                                <a href="#section3"  class="btn-back btn btn-lg">Back</a>
                                <a href="#"  class="btn-next btn btn-lg disabled" id="upload_img" >Post</a>
                                
                        </div>
                    </div>
                </div>
                <!-- end of section4 -->
                <div class="clearfix"></div>
            </div>
        </form>
        <form id="image-upload-form" method="post" action="<?php echo Yii::app()->createUrl('classified/uploadadimage'); ?>" class="hidden">
            <input id="img-up-input" type="file" name="img"/>
            <input type="hidden" name="classified_id" id="classified_id_img" value="0"/>
        </form>
    </div>
</div>
<!-- Button trigger modal -->
<div id="overlay-screen-tin" class="overlay-tint">
    <div class="col-xs-12 text-center loading-container">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/725.gif"/><br/>
        <span>Generating your AD please wait</span>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="progress">
            <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
              <span class="sr-only">80% Complete (danger)</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fullPage.js"></script>
<!-- This following line is needed only in case of using other easing effect rather than "linear", "swing" or "easeInQuart". You can also add the full jQuery UI instead of this file if you prefer -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.easings.min.js"></script>


<!-- This following line needed in the case of using the plugin option `scrollOverflow:true` -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendors/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/js/bootstrap-switch.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/js/jquery.form.min.js'; ?>"></script>
<script>
    var getcatlvllisturl = "<?php echo Yii::app()->createUrl('classified/getcatlvllist'); ?>";
    var addnewclassifiedurl = "<?php echo Yii::app()->createUrl('classified/addnewclassified'); ?>";

$(document).ready(function() {
    init_upload_image();
    $(".checkbox-switch").bootstrapSwitch();
    $("#visible-add-img-btn").click(function(){
    $("#img-up-input").trigger("click");
    });
    $('#fullpage').fullpage({
            resize:false,
            anchors: ['Page1', 'Page2', 'Page3', 'Page4'],
//             anchors: ['section1', 'section2', 'section3', 'section4'],
            menu: '#myMenu',
            css3: true,
            scrollingSpeed: 1000});
    init_activate_mymenu_navigation();
    $("#myMenue li a").click(function(event){
        //event.preventDefault();
    });
    $("#cat-lvl-1-select").change(function(){
            step1_init_other($(this));
    })  ;  
    $("#step1").click(function(event){
//        event.preventDefault();
//        alert(JSON.stringify(collect_step_1_data()));
//validat_step_1();
        if(!validat_step_1())
        {
            event.preventDefault();
        }
    });
    $("#step2").click(function(event){
         //alert(JSON.stringify(collect_step_2_data()));
        if(!validat_step_2())
        {
            event.preventDefault();
        }
    });
    
    $('#adform').submit(function(event){
        event.preventDefault();
//        var height= (window.innerHeight/2)-150;
//        $("#overlay-screen-tin>div").css("margin-top",height);
//        $("#overlay-screen-tin").fadeIn();
        savenewpost();
//        }
    });
    $("#finish").click(function(event){
        if(!validat_step_3())
        {
            event.preventDefault();
        }
        else
        {
            event.preventDefault();
            $("#ad-post-submit-btn").trigger("click");
        }
    });
    $('#image-upload-form').submit(function(event){
        event.preventDefault();
    });
    $("#img-up-input").change(function(){
        validate_step_4();
    })
    $("#upload_img").click(function(event){
//        event.preventDefault();
//        alert("da");
        if(validate_step_4())
        {
//            alert("da");
            $("#image-upload-form").submit();
        }
//     upload_image();
    });  
});

$(window).on('hashchange',function(){ 
    init_activate_mymenu_navigation();
});
    </script>