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
    public function actionIndex()
    {
         $this->layout="//layouts/mainindex";
         $criteria = new CDbCriteria();
         $criteria->order = "id DESC";
         $count = Classified::model()->count($criteria);
         $pages = new CPagination($count);
         $pages->setPageSize(5);
         $pages->applyLimit($criteria);
         Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/classified.index.css');	
         $this->render("index",array(
             'model' => Classified::model()->findAll($criteria),
             'count' => $count,
             'page_size' =>5,
             'pages'=>$pages
         ));
    }
    public function actionUploadAdImage()
    {
        if(isset($_FILES["img"]))
		{
            $result= new stdClass();
            $result->error=false;
            $id=$_POST["classified_id"];
            $supported_file_typ= array("image/jpeg","image/png","image/gif");
            $imgtempname = $_FILES['img']['tmp_name'];
            $imgsize = $_FILES["img"]["size"];
            $filetyp = $_FILES["img"]["type"];
            $extention=  pathinfo($_FILES["img"]["name"],PATHINFO_EXTENSION);
            list($w,$h)= getimagesize($imgtempname);
            if(  in_array($filetyp, $supported_file_typ))
            {
                $newimgname= hash('crc32',uniqid()).".".$extention;
                $directory = $_SERVER['DOCUMENT_ROOT'] . Classifiedimage::IMG_DIRECTORY.$id."/";
                if(!is_dir($directory))
                {
                    Yii::log("Creating thumb folder " . $directory);
                    if(mkdir($directory, 0777, true)===false)
                    {
                        $result->error=true;
                        Yii::log("Unable to thumb image folder " . $directory);
                        return false;
                    }
                }
                if(move_uploaded_file($imgtempname, $directory.$newimgname))
                {
                    if($id>0)
                {
                    $classifiedimage= new Classifiedimage;
                    $classifiedimage->classified_id=$id;
//                    if($id>0)
//                    {
                        $classified = Classified::model()->findByPk($id);
//                    }
                    $img = new Img;
                    $img->filename=$newimgname;
                    $img->filepath=$directory;
                    if($img->create_thumbnail())
                    {
                     $classifiedimage->variable=  serialize($img);
                     $classifiedimage->active=0;
                     $classifiedimage->name=$newimgname;
                     $classifiedimage->save();
                    }
                    $classified->thumbnail=$newimgname;
                    $classified->save();
                    }
                    $result->imagesrc=Classifiedimage::IMG_DIRECTORY.$id."/".$newimgname;
                  
                }
                else
                {
                    $result->error=true;
                }
                
            }
            print CJSON::encode($result);

        }
    }
    private function cleancategoryselection($data)
    {
        $newdata=NULL;
        for ($i=1;$i<4;$i++)
        {
            if($data->st1_data[$i]->new_=="yes" && ($data->st1_data[$i]->data>0))
            {
                $data->st1_data[$i]->data=0;
            }
        }
        return $newdata;
    }
    private function sortcategoryposting($level,$data)
    {
        $result=NULL;
        switch ($level)
        {
            case 1:
               if($data->st1_data[1]->new_=="no")
                {
                    $cat= CatLvl1::model();
                } 
                
        }
    }
    public function actionAddnewclassified()
    {
        $result= new stdClass();
        $result->error=true;
        if(isset($_POST["data"]))
        {
            $data = json_decode($_POST["data"]);
            if($data->classified_id>0)
            {
                $result->error=false;
                print CJSON::encode($result);
                return;
            }
            $cat_lvl_1=NULL;
            $cat_lvl_2=NULL;
            $cat_lvl_3=NULL;
            $count= count($data->st1_data);
            for ($i=1;$i<$count;$i++)
            {
                switch ($i)
                {
                    case 1 :
                        if($data->st1_data[1]->new_=="yes" && $data->st1_data[1]->data!="")
                        {
                            $cat_lvl_1= new CatLvl1();
                            $cat_lvl_1->name=$data->st1_data[1]->data;
                            $cat_lvl_1->active=0;
                            $cat_lvl_1->save() ? $result->error=false : $result->error=true;
                        }
                        else if($data->st1_data[1]->new_=="no" && $data->st1_data[1]->data>0)
                        {
                            $cat_lvl_1= CatLvl1::model()->findByPk($data->st1_data[1]->data);
                            $cat_lvl_1 ? $result->error=false : $result->error=true;
                        }
                        break;
                    case 2:
                        if($data->st1_data[2]->new_=="yes"  && $data->st1_data[2]->data!="")
                        {
                            $cat_lvl_2= new CatLvl2();
                            $cat_lvl_2->name=$data->st1_data[2]->data;
                            $cat_lvl_2->cat_lvl_1_id=$cat_lvl_1->id;
                            $cat_lvl_2->active=0;
                            $cat_lvl_2->save()? $result->error=false : $result->error=true;
                        }
                        else if($data->st1_data[2]->new_=="no" && $data->st1_data[2]->data>0)
                        {
                            $cat_lvl_2= CatLvl2::model()->findByPk($data->st1_data[2]->data);
                            $cat_lvl_2 ? $result->error=false : $result->error=true;
                        }
                        break;
                    case 3:
                        if($data->st1_data[3]->new_=="yes"  && $data->st1_data[3]->data!="")
                        {
                            $cat_lvl_3= new CatLvl3();
                            $cat_lvl_3->name=$data->st1_data[3]->data;
                            $cat_lvl_3->active=0;
                            $cat_lvl_3->cat_lvl_1_id=$cat_lvl_1->id;
                            $cat_lvl_3->cat_lvl_2_id=$cat_lvl_2->id;
                            $cat_lvl_3->save()? $result->error=false : $result->error=true;
                        }
                        else if($data->st1_data[3]->new_=="no" && $data->st1_data[3]->data>0)
                        {
                            $cat_lvl_3= CatLvl3::model()->findByPk($data->st1_data[3]->data);
                            $cat_lvl_3 ? $result->error=false : $result->error=true;
                        }
                        break;
                    default : $result->error=true;
                        
                }
            }
            $classified= new Classified;
            $classified->title = $data->st2_data->title;
            $classified->price=$data->st2_data->price;
            $classified->phone=$data->st3_data->phone;
            $classified->active=0;
            $classified->live=0;
            $classified->cat_lvl_1=isset($cat_lvl_1) ? $cat_lvl_1->id : NULL;
            $classified->cat_lvl_2=isset($cat_lvl_2) ? $cat_lvl_2->id : NULL;
            $classified->cat_lvl_3=isset($cat_lvl_3) ? $cat_lvl_3->id : NULL;
            $classified->save()? $result->error=false : $result->error=true;
            $classified_profile= new Classifiedsprofile;
            $classified_profile->negotiable=$data->st2_data->negotiable ? 1 :0;
            //figure out a way to sort conditions
            $classified_profile->condition = $data->st2_data->condition;
            $classified_profile->model=$data->st2_data->model;
            $classified_profile->brand=$data->st2_data->brand;
            $classified_profile->year=$data->st2_data->year;
            $classified_profile->classified_id=$classified->id;
            $classified_profile->description=$data->st3_data->description;
            $classified_profile->broker=$data->st3_data->broker? 1 :0;
            $classified_profile->save() ? $result->error=false : $result->error=true;
            $classified->profile=$classified_profile->id;
            $classified->save()? $result->error=false : $result->error=true;
            $result->classified_id=$classified->id;
            $result->calasifiedprofile=$classified_profile->id;
//            $result->cat2=$cat_lvl_2;
//            $result->cat3=$cat_lvl_3;
           
        }
         print CJSON::encode($result);
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
                $classlvlmodel= CatLvl2::model()->findAllByAttributes(array("cat_lvl_1_id"=>$data->id,"active"=>1));
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
                $classlvlmodel= CatLvl3::model()->findAllByAttributes(array("cat_lvl_2_id"=>$data->id,"active"=>1));
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

