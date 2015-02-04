<?php

class MainController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/Main/pages'
			// They can be accessed via: index.php?r=Main/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/Main/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        
        $this->layout="//layouts/mainindex";
		$this->render('index');
	}
	public function actionAdd()
	{
//		$classlvl1=  Classlevelone::model()->findAll("id> :ip", array(":ip"=>0));
//        $classlvl2=  Classleveltwo::model()->findAll("id> :ip", array(":ip"=>0));
        $addtype= array("1"=>"classified");
        //$classlvl3=  
       
		
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-switch.min.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/mainadd.css');	
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.fullPage.js');
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/vendors/jquery.easings.min.js');
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/vendors/jquery.slimscroll.min.js');
        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mainadd.js');
		$this->layout="//layouts/mainadd";
		$this->render('add' );//,array("classlvl1"=>$classlvl1,"addtype"=>$addtype));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
//	public function actionLogin()
//	{
//		$model=new LoginForm;
//
//		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//
//		// collect user input data
//		if(isset($_POST['LoginForm']))
//		{
//			$model->attributes=$_POST['LoginForm'];
//			// validate user input and redirect to the previous page if valid
//			if($model->validate() && $model->login())
//                Yii::app()->user->returnUrl="http://google.com";
//				$this->redirect(Yii::app()->user->returnUrl);
//		}
//		// display the login form
//		$this->render('login',array('model'=>$model));
//	}
    
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    public function actiongetclasslvl()
    {
        $result= new stdClass();
        $result->error=1;
        $result->found=0;
        //$result->data='';
        if(isset($_POST['classlvl_id']))
        {
           
            if($_POST['lvl']==2)
            {
                $classlvlmodel=  Classleveltwo::model()->findAllByAttributes(array("class_level_one_id"=>$_POST['classlvl_id']));
            }
            elseif ( $_POST['lvl']==3) 
            {
                $classlvlmodel=  Classlevelthree::model()->findAllByAttributes(array("class_level_two_id"=>$_POST['classlvl_id']));
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