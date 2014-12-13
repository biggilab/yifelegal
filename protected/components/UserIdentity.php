<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    const ERROR_PASSWORD_INVALID="wrong pass";
    const ERROR_USERNAME_INVALID="wrong username";
    const ERROR_EMAIL_INVALID="wrong email";
	private $id_=0;
	public function authenticate()
	{
		if (strpos($this->username,"@"))
		{
			$attributes = array("email"=>$this->username);
		}
		else
		{
			$attributes = array("username"=>$this->username);
		}
//        $criteria = new CDbCriteria;
//        $location=Yii::app()->params['location'];
//        if($location=="admin")
//        {
//            $criteria->condition = 'usertype=' . User::ADMIN;
//        }
//        elseif ($location="user") 
//        {
//            $criteria->condition = 'usertype=' . User::USER;
//        }
        $user = User::model()->findByAttributes($attributes);//, $criteria);
        
        if($user===null)
		{
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		}
        else if(!$user->Validate($this->password))
        {
            
			$this->errorCode=self::ERROR_PASSWORD_INVALID ;
        }
        
        else
		{	$this->errorCode=self::ERROR_NONE;
			$this->id_ = $user->id;
			$this->username = $user->username;
			$user->last_login = new CDbExpression('NOW()');
			$user->save();
		}
		return !$this->errorCode;
        
        
        
//        
//        
//        
//        $users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
	}
	public function getId()
	{
		return $this->id_;
	}
}