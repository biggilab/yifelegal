<?php

class adminController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public $layout='//layouts/adminmain';
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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
        $this->render('index');
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
    public function actionRegister()
	{           
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-1.11.1.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounts.js');
        $this->render("register");
    }
    public function actionRegisteradmin()
	{
        $result= new stdClass();
        $result->error=1;
        $result->msg='';
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            if(isset($data->email) && isset($data->password))
            {
                $existing_user= User::model()->findByAttributes(array("email"=>$data->email,"usertype"=>  User::ADMIN));
                if(!$existing_user)
                {
                    $usermodel= new User;
                    $usermodel->firstname = $data->firstname;
                    $usermodel->lastname = $data->lastname;
                    $usermodel->email = $data->email;
                    $username=  explode("@", $data->email);
                    $usermodel->username = $username[0];
                    $usermodel->password = User::model()->encryptpassword($data->password);
                    $usermodel->usertype = User::ADMIN;
                    $usermodel->confirmed = 0;
                    if($usermodel->save())
                    {
                        $result->error=0;
                        $result->msg='You have succesfully signed up. Please confirm your email.';
                    }
                }
                else 
                {
                    $result->error=1;
                    $result->msg='User aleardy registered with this email.';
                }
            }
            else
            {
                $result->error=1;
                $result->msg='You did not enter your email or password.';
            }
            
        }
        else
        {
           $result->error=1;
           $result->msg='You are not Authorized to be here!'; 
        }
        print CJSON::encode($result);
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}