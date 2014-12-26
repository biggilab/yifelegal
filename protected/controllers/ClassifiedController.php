<?php
 
class ClassifiedController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public $layout='//layouts/main';
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    public function actioncat_lvl_list()
    {
        {
        $result= new stdClass();
        $result->error=1;
        $result->found=0;
        //$result->data='';
        if(isset($_POST['classlvl_id']))
        {
           
            if($_POST['lvl']==2)
            {
                $classlvlmodel=  Classleveltwo::model()->findAllByAttributes(array("cat_lvl_1_id"=>$_POST['classlvl_id']));
            }
            elseif ( $_POST['lvl']==3) 
            {
                $classlvlmodel=  Classlevelthree::model()->findAllByAttributes(array("cat_lvl_1_id"=>$_POST['classlvl_id']));
            }
            elseif ( $_POST['lvl']==1) 
            {
                $classlvlmodel= Classlevelone::model()->findAll();
            }
            if($classlvlmodel)    
            {
                $data=  CHtml::listData($classlvlmodel, "id", "name");
                //$datalength=  count($data);
                //$data[count($data)]="other";
                ///var_dump($data);
                //$dataarray=array();
//                foreach($data as $value=>$name)
//                {
//                    
//                    
//                }
                //$result->data.= "<option value='0'>Other";
                $result->data=$data;
                $result->error=0;
                $result->found=1;
            }
        }
        echo $result=CJSON::encode($result);
    }
    }
    public function actionGetCatLvlList()
    {
        if(isset($_POST["data"]))
        {
            $result = new stdClass();
            $result->error=true;
            
            $data = json_decode($_POST["data"]);
            Yii::log($_POST["data"]);
            $lvl=$data->lvl;
            if($lvl==2)
            {
                $classlvlmodel= CatLvl2::model()->findAllByAttributes(array("cat_lvl_1_id"=>$data->id));
                $result->data="<h5>Select sub category</h5><select class='btn btn-lg' id='cat-lvl-2-select' name='cat-lvl-2' id='cat-lvl-2-select' data-next-lvl='3'><option value='-1'></option>";
                if(count($classlvlmodel)==0)
                {
                    $result->empty=1;
                }
                foreach ($classlvlmodel as $onemodel)
                {
                   $result->data.= "<option value='$onemodel->id' >".$onemodel->name."</option>";
                }
                $result->data.=  "<option value='0'>Other</option></select><input type='text' class='category-input hidden' id='cat-lvl-2-select-other' name='cat-lvl-2-select-other' placeholder='enter category'/>";
                $result->error=FALSE;
            }
            if($lvl==3)
            {
                $classlvlmodel= CatLvl3::model()->findAllByAttributes(array("cat_lvl_2_id"=>$data->id));
                $result->data="<h6>Select sub-category</h6><select class='btn btn-lg' name='cat-lvl-3' id='cat-lvl-3-select'><option value='-1'></option>";
                  if(count($classlvlmodel)==0)
                {
                    $result->empty=1;
                }
                foreach ($classlvlmodel as $onemodel)
                {
                   $result->data.= "<option value='$onemodel->id' >".$onemodel->name."</option>";
                }
                $result->data.=  "<option value='0'>Other</option></select><input type='text' name='cat-lvl-3-select-other' class='category-input hidden' id='cat-lvl-3-select-other' placeholder='enter category'/>";
                $result->error=FALSE;
            }
            print CJSON::encode($result);
        }
        else
		{
			throw new CHttpException(404,'Page not found');
		}
        
    }
}

