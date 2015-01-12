<?php
/**
 *
 * Copyright (c) 2013 The Online Leisure Corporation
 *
 * Updated: 21-October-2014
 *
 */

class AdminClubController extends Controller
{
	const STAGE_USER = 1;
	const STAGE_CLUB = 2;
	const STAGE_DESCRIPTION = 3;
	const STAGE_MAP = 4;
	const STAGE_COURSE = 5;
	const STAGE_CLUBLOGO = 6;
	const STAGE_IMAGES = 7;

	public $layout='//layouts/admin';
	public $defaultAction = 'allclubs';

	static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	///***
	// * New Admin page
	// */
	//public function actionNewAdmin()
	//{
	//	$this->layout='//layouts/newadmin';
	//	$this->render('newadmin');
	//}


    static public function getLocation($address){
        $url = self::$url.urlencode($address);

        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);

		if(($resp['status']='OK') && isset($resp['results'][0])){
        //if($resp['status']='OK'){
            //return $resp['results'][0]['geometry']['location'];
            return $resp['results'][0];
        }else{
            return false;
        }
    }

	static private function curl_file_get_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
            else return FALSE;
    }

	public function actionIndex()
	{
		$this->pageTitle = "golfscape Team";
		//$this->layout='//layouts/newadmin';
		$this->render('index');
	}
	public function actionSortClubImages()
	{
		if(isset($_POST["data"]))
		{
			$this->systemLog("Sorting images");
			$data = json_decode($_POST["data"]);
			foreach($data as $oneimage)
			{
				$model = ClubImage::model()->findByPk($oneimage->imageid);
				if($model)
				{
					$model->sequence = $oneimage->sequence;
					$model->save();
				}
			}
		}
	}

	public function actionClubImageResize()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubimage = ClubImage::model()->findByPk($data->id);
			
			//resize image
			$imagemodel = new Image;
			$imagemodel->folder = Image::COURSEFOLDER . $clubimage->club_id;
			$imagemodel->filename = $clubimage->filename;
			if($imagemodel->crop($data))
			{
				$clubimage->imagenumber = $clubimage->lastImageNumber() + 1;
				$clubimage->sequence = $clubimage->imagenumber;
				$clubimage->status = Club::STATUS_PUBLISHED;
				
				if($clubimage->save())
				{
					$this->systemLog("Add new image ".$clubimage->filename." to " . $clubimage->club->name);
				}
				
				if($imagemodel->resize(array("w"=>800)) && $imagemodel->resize(array("w"=>150)))
				{
					$result = new stdClass();
					$result->id = $clubimage->id;
					$result->name = "New Image";
					$result->imagenumber = $clubimage->imagenumber;
					$result->filename = $imagemodel->path;
					$result->original = $imagemodel->originalpath;
		
					print CJSON::encode($result);	
				}
				
			}
		}
	}

	/***
	 * Update image to the server for further resizing
	 *
	 */
	public function actionUploadClubImage()
	{
		if(isset($_FILES["image"]))
		{
			$id = $_POST["modelid"];
			$model = Club::model()->findByPk($id);
			$tempfilename = $_FILES['image']['tmp_name'];
            $filesize = $_FILES["image"]["size"];
            $filetype = $_FILES["image"]["type"];

			list($width, $height) = getimagesize($tempfilename);

            if((($filetype == "image/gif") || ($filetype == "image/jpeg") || ($filetype == "image/png")) && (($width>=780) && ($height>=438)))
			{
				// construct a unique file name
				$extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
				$newfilename = sha1(uniqid(true)) . "." . strtolower($extension);

				// prepare the club folder
				$clubfolder = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $model->id;
				if(!is_dir($clubfolder))
				{
					// create if doesn't exists
					mkdir($clubfolder, 0777);
				}
				// move the file
				$ok = move_uploaded_file($tempfilename, $clubfolder . "/" . $newfilename);

				if($ok)
				{
					$clubimage = new ClubImage;
					$clubimage->create_time = date('Y-m-d H:i:s');
					$clubimage->create_user_id = Yii::app()->user->id;
					$clubimage->update_time = date('Y-m-d H:i:s');
					$clubimage->update_user_id = Yii::app()->user->id;
					$clubimage->club_id = $model->id;
					$clubimage->filename = $newfilename;
					$clubimage->status = 0;
					$clubimage->imagenumber = 0;
					$clubimage->sequence = $clubimage->imagenumber;
					$clubimage->save();
					$this->systemLog("Uploaded a new image " . $clubimage->filename . " for " . $clubimage->club->name);

					// $ratio
					$ideal_ratio = 16 / 9;
					//$square_ratio = 1;
					$image_ratio = $width/$height;
					if($image_ratio > $ideal_ratio)
					{
						$cropheight = $height;
						$cropwidth = $height * 16 / 9;
					}
					else
					{
						$cropwidth = $width;
						$cropheight = $width * 9 / 16;
					}

					$result = new stdClass();
					$result->id = $clubimage->id;
					if($image_ratio > $ideal_ratio)
					{
						$result->minheight = 438.75;
						$result->minwidth = $result->minheight * 16 / 9;
					}
					else
					{
						$result->minwidth = 780;
						$result->minheight = $result->minwidth * 9 / 16;
					}

					$imagemodel = new Image;
					$imagemodel->folder = Image::COURSEFOLDER . $clubimage->club_id;
					$imagemodel->filename = $clubimage->filename;
					
					if($imagemodel->resize(array("h"=>300, "w"=>800)))
					{
						$result->filename = $imagemodel->path;
						$result->imagenumber = $clubimage->imagenumber;
						$result->width = $width;
						$result->height = $height;
						$result->cropwidth = $cropwidth;
						$result->cropheight = $cropheight;
	
						print CJSON::encode($result);	
					}
					else
					{
						$result = new stdClass();
						$result->error = true;
						$result->alert = $imagemodel->errormessage;
						print CJSON::encode($result);
					}
				}
			}
            else
			{
				//echo "error";
				$result = new stdClass();
				$result->error = true;
				$result->alert = "";
				print CJSON::encode($result);

			}
		}
	}
	public function actionRemoveClubLogo()
	{
		if(isset($_POST["data"]))
		{
			$id = $_POST["data"];
			$model = Club::model()->findByPk($id);
			$model->clublogo = "";
			$model->update_time = date('Y-m-d H:i:s');
			$model->update_user_id = Yii::app()->user->id;
			if($model->save())
			{
				$this->systemLog("Removing club logo of " . $model->name);
				$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$id));
				if($clubmodify)
				{
					$clubmodify->update_time = date('Y-m-d H:i:s');
					$clubmodify->update_user_id = Yii::app()->user->id;
					$clubmodify->clublogo = $model->clublogo;
					$clubmodify->status_clublogo = Club::STATUS_PUBLISHED;
					$clubmodify->save();
				}
			}
		}
	}
	public function actionUploadClubLogo()
	{
		if(isset($_FILES["image"]))
		{
			$id = $_POST["modelid"];
			$model = Club::model()->findByPk($id);
			$tempfilename = $_FILES['image']['tmp_name'];
            $filesize = $_FILES["image"]["size"];
			$filetype = $_FILES["image"]["type"];

            if(($filetype == "image/gif") || ($filetype == "image/jpeg") || ($filetype == "image/png"))
			{
				// construct a unique file name
				$extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
				$newfilename = sha1(uniqid(true)) . "." . strtolower($extension);

				// prepare the club folder
				$clubfolder = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $model->id;
				if(!is_dir($clubfolder))
				{
					// create if doesn't exists
					mkdir($clubfolder, 0777);
				}
				// move the file
				$ok = move_uploaded_file($tempfilename, $clubfolder . "/" . $newfilename);

				if($ok)
				{
					$model->clublogo = $newfilename;
					$model->update_time = date('Y-m-d H:i:s');
					$model->update_user_id = Yii::app()->user->id;
					if($model->save())
					{
						$this->systemLog("Uploaded a club logo for " . $model->name);
						// Update clubmodify
						$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$model->id));
						if($clubmodify)
						{
							$clubmodify->update_time = date('Y-m-d H:i:s');
							$clubmodify->update_user_id = Yii::app()->user->id;
							$clubmodify->clublogo = $model->clublogo;
							$clubmodify->status_clublogo = Club::STATUS_PUBLISHED;
							$clubmodify->save();
							
							$result = new stdClass();
							$imagemodel = new Image;
							$imagemodel->folder = Image::COURSEFOLDER . $model->id;
							$imagemodel->filename = $model->clublogo;
							$imagemodel->resize(array("h"=>40));
							if($imagemodel->resize(array("h"=>80)))
							{
								$result->error = false;
								$result->filename = $imagemodel->path;
								$result->original = $imagemodel->originalpath;
							}
							else
							{
								$result->error = true;
								$result->alert = $imagemodel->errormessage;
							}			
							
							print CJSON::encode($result);
						}
					}
				}
			}
            else
			{
				$result = new stdClass();
				$result->error = true;
				$result->alert = "Invalid file";
				print CJSON::encode($result);
			}
		}
	}


	public function actionUpdateClubMap()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);

			$clubmodel = Club::model()->findByPk($data->id);
			$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$clubmodel->id));
			$notifynetwork = $clubmodify->status_maplink == Club::STATUS_PENDING;
			
			$clubmodel->maplink = serialize($data);
			$clubmodel->update_time = date('Y-m-d H:i:s');
			$clubmodel->update_user_id = Yii::app()->user->id;

			$clubmodify->maplink = serialize($data);
			$clubmodify->status_maplink = Club::STATUS_PUBLISHED;
			$clubmodify->update_time = date('Y-m-d H:i:s');
			$clubmodify->update_user_id = Yii::app()->user->id;

			if($clubmodify->save() && $clubmodel->save())
			{
				$this->systemLog("Accept and published map coordinates for " . $clubmodel->name);
				if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
				{
					$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "The map has been updated for " . $clubmodel->name, 3);
				}
				print CJSON::encode($data);
			}
		}
	}
	public function actionRetrieveCourses()
	{
		if(isset($_POST["data"]))
		{
			$id =  intval( $_POST["data"] );
			$coursesdata = array();
			$clubmodel = Club::model()->findByPk($id);
			if($clubmodel)
			{
				$courses = Course::model()->findAllByAttributes(array("club_id"=>$clubmodel->id));
				foreach($courses as $onecourse)
				{
					$onedata = new stdClass();
					$onedata->id = $onecourse->id;
					$onedata->status = $onecourse->status;
					$onedata->coursename = $onecourse->name;
					$onedata->modification = unserialize($onecourse->modification);

					$coursesdata[] = $onedata;
				}
			}

			print CJSON::encode($coursesdata);
		}
	}

	public function actionUpdateClubStatus()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$id = $data->id;
			$status = $data->status;

			$model =  Club::model()->findByPk($id);
			$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$id));
			if($model && $clubmodify)
			{
				$property = GolfProperty::model()->findByPk($model->golfproperty_id);
				$isprofile = isset($property) && ($property->account_cycle==GolfProperty::CYCLE_ACCOUNT) && ($property->cycle_status==GolfProperty::CYCLE_STATUS_PROFILE);
				
				$stillpending = ($clubmodify->status_address == Club::STATUS_UNCHANGED) ||
								($clubmodify->status_address == Club::STATUS_PENDING) ||
								($clubmodify->status_description == Club::STATUS_PENDING) ||
								($clubmodify->status_maplink == Club::STATUS_PENDING);

				$clubusers = ClubUser::model()->findAllByAttributes(array("golfproperty_id"=>$property->id));
				$noclubuser = count($clubusers) == 0;
				
				if(!$isprofile && ($data->status==Club::PROFILE_ONLINE))
				{
					echo "notokprofile";
				}
				else if($stillpending && ($data->status==Club::PROFILE_ONLINE))
				{
					echo "notok";
				}
				else if($noclubuser && ($data->status==Club::PROFILE_ONLINE))
				{
					echo "notoknouser";
				}
				else
				{
					$model->update_time = date('Y-m-d H:i:s');
					$model->update_user_id = Yii::app()->user->id;
					$model->status = $status;
					if($model->save())
					{
						if($data->status==Club::PROFILE_ONLINE)
						{
							$this->systemLog($model->name . " is now Online ");
							$this->clubDetailUpdateNotification($model->golfproperty_id, "The property profile is now online for " . $model->name, 1);
							Queue::addQueue(Queue::CLUB_PROFILE_IS_ONLINE, 0, $model->golfproperty_id);
						}
						else
						{
							$this->systemLog($model->name . " is now Offline");
							$this->clubDetailUpdateNotification($model->golfproperty_id, "The property profile is now offline for " . $model->name, 1);
						}
						echo "ok";
					}
				}

			}
		}

	}

	public function actionDeleteCourse()
	{
		if(isset($_POST["data"]))
		{
			$id = $_POST["data"];
			$model = Course::model()->findByPk($id);
			if($model)
			{
				$this->systemLog($model->club->name . "'s course has been deleted: " . $model->name);
				$model->delete();
				echo "ok";
			}

		}
	}

	public function actionUnpublishCourse()
	{
		if(isset($_POST["data"]))
		{
			$id = $_POST["data"];
			$model = Course::model()->findByPk($id);

			if($model)
			{
				$model->update_time = date('Y-m-d H:i:s');
				$model->update_user_id = Yii::app()->user->id;
				$model->status = Club::STATUS_UNPUBLISHED;
				$model->properties = serialize(array());
				if($model->save())
				{
					echo "ok";
				}
			}
		}
	}
	public function actionModifyCourse()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);

			$id = $data->course_id;
			$model = Course::model()->findByPk($id);
			$clubmodel = Club::model()->findByPk($data->model_id);
			if(!$model)
			{
				// if new course
				$model = new Course;
				$model->create_time = date('Y-m-d H:i:s');
				$model->create_user_id = Yii::app()->user->id;
				$model->club_id = $clubmodel->id;
			}
			$notifynetwork = $model->status == Club::STATUS_PENDING;
			$model->update_time = date('Y-m-d H:i:s');
			$model->update_user_id = Yii::app()->user->id;
			$model->name = $data->coursename;
			$model->properties = serialize($data);
			$model->modification = serialize($data);
			$model->status = Club::STATUS_PUBLISHED;
			if($model->save())
			{
				if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
				{
					$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, '"' .$data->coursename. '" course is now online for ' .$clubmodel->name, 1);	
				}
				echo $model->id;
			}
		}
	}

	public function actionUpdateClubImage()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$id = $data->id;
			$imageid = $data->imageid;
			$status = $data->status;

			$model = ClubImage::model()->findByPk($imageid);
			if($model)
			{
				$notifynetwork = $model->status==Club::STATUS_PENDING;
				$model->status = $status;
				$model->remotecopy = 0;
				$model->update_time = date('Y-m-d H:i:s');
				$model->update_user_id = Yii::app()->user->id;
				if($model->save())
				{
					if($status==Club::PROFILE_ONLINE)
					{
						$clubmodel = Club::model()->findByPk($id);
						if($clubmodel && ($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
						{
							$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "Image #" . $model->imagenumber . " is now online for " . $clubmodel->name, 2);		
						}
					}
					
					echo "ok";
				}
			}
		}
	}
	public function actionDeleteClubImage()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$id = $data->id;
			$imageid = $data->imageid;

			$model = ClubImage::model()->findByPk($imageid);
			if($model)
			{
				$model->status = Club::STATUS_DELETED;
				if($model->save())
				{
					echo "ok";
				}
				//if($model->delete())
				//{
				//	echo "ok";
				//}
			}
		}
	}
	public function actionUpdateClubLogo()
	{
		if(isset($_POST["data"]))
		{
			$result = "error";
			$data = json_decode($_POST["data"]);
			$updatestatus = $data->status;

			$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$data->id));
			if($clubmodify)
			{
				$notifynetwork = $clubmodify->status_clublogo==Club::STATUS_PENDING;
				$clubmodify->update_time = new CDbExpression('NOW()');
				$clubmodify->update_user_id = Yii::app()->user->id;
				$clubmodify->status_clublogo = $updatestatus;
				if($clubmodify->save())
				{
					$clubmodel = Club::model()->findByPk($data->id);
					if($updatestatus==Club::STATUS_PUBLISHED)
					{
						$clubmodel->update_time = new CDbExpression('NOW()');
						$clubmodel->update_user_id = Yii::app()->user->id;
						$clubmodel->clublogo = $clubmodify->clublogo;
						if($clubmodel->save())
						{
							if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
							{
								$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "The logo has been updated for " . $clubmodel->name, 2);
							}

							$clubmodel->createRemoteLogo(array("h"=>80));
							
							// create thumbnail
							$imagemodel = new Image;
							$imagemodel->folder = Image::COURSEFOLDER . $clubmodel->id;
							$imagemodel->filename = $clubmodel->clublogo;
							$imagemodel->resize(array("h"=>40));
							
							$result = "ok";
						}
					}
					else if($updatestatus==Club::STATUS_UNPUBLISHED)
					{
						if($clubmodel->clublogo == $clubmodify->clublogo)
						{
							$clubmodel = Club::model()->findByPk($data->id);
							$clubmodel->update_time = new CDbExpression('NOW()');
							$clubmodel->update_user_id = Yii::app()->user->id;
							$clubmodel->clublogo = "";
							if($clubmodel->save())
							{
								$result = "ok";
							}
						}
					}
				}
			}
			echo $result;
		}
	}

	public function actionUpdateClubRemarks()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubmodel = Club::model()->findByPk($data->id);
			if($clubmodel)
			{
				$clubmodel->update_time = date('Y-m-d H:i:s');
				$clubmodel->update_user_id = Yii::app()->user->id;
				$clubmodel->remarks = $data->value;
				if($clubmodel->save())
				{
					echo "ok";
				}
			}
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}
	public function actionUpdateClubDesc()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$data->id));
			$clubmodel = Club::model()->findByPk($data->id);
			if($clubmodify && $clubmodel)
			{
				$notifynetwork = $clubmodify->status_description==Club::STATUS_PENDING;

				$clubmodify->update_time = date('Y-m-d H:i:s');
				$clubmodify->update_user_id = Yii::app()->user->id;
				$clubmodify->status_description = Club::STATUS_PUBLISHED;
				$clubmodify->description = $data->value;

				$clubmodel->update_time = date('Y-m-d H:i:s');
				$clubmodel->update_user_id = Yii::app()->user->id;
				$clubmodel->description = $data->value;

				if($clubmodel->save() && $clubmodify->save())
				{
					if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
					{
						$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "The description has been updated for " . $clubmodel->name, 1);
					}

					echo "ok";
				}
			}
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');

	}
	public function actionUpdateClub()
	{
		$this->systemLog("Inside actionUpdateClub() function...");
		if(isset($_POST["update_value"]))
		{
			$fn = $_POST["element_id"];
			$st = "status_" . $fn;
			$fv =$_POST["update_value"];
			$id = $_POST["id"];

			$clubmodel = Club::model()->findByPk($id);
			$modelmodify = ClubModify::model()->findByAttributes(array("club_id"=>$clubmodel->id));

			$clubmodel->update_time = date('Y-m-d H:i:s');
			$clubmodel->update_user_id = Yii::app()->user->id;

			$modelmodify->update_time = date('Y-m-d H:i:s');
			$modelmodify->update_user_id = Yii::app()->user->id;
			$modelmodify->$st = Club::STATUS_PUBLISHED;
			if($fn=="country")
			{
				$country = Country::model()->findByAttributes(array("printable_name"=>$fv));
				if($country)
				{
					$modelmodify->country = $country->printable_name;
					$modelmodify->country_iso = $country->iso;
					$modelmodify->geolocation = $country->geolocation;
					$clubmodel->country = $country->printable_name;
					$clubmodel->country_iso = $country->iso;
					$clubmodel->geolocation = $country->geolocation;
				}
			}
			else if($fn=="maplink")
			{

			}
			else
			{
				$modelmodify->$fn = $fv;
				$clubmodel->$fn = $fv;
			}

			if($modelmodify->save() && $clubmodel->save())
			{
				echo "ok";
			}
		}
	}

	public function actionUpdateClubAddress()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$data->id));
			if($clubmodify)
			{
				$notifynetwork = $clubmodify->status_address==Club::STATUS_PENDING; 
				$clubmodify->update_time = date('Y-m-d H:i:s');
				$clubmodify->update_user_id = Yii::app()->user->id;
				
				$clubmodify->name = preg_replace("/\s+/", " ", $data->name);
				$clubmodify->address1 = $data->address1;
				$clubmodify->address2 = $data->address2;
				$clubmodify->city = $data->address3;
				$clubmodify->state = $data->state;
				$clubmodify->country = $data->country;
				$clubmodify->postalcode = $data->postalcode;
				$clubmodify->status_address = Club::STATUS_PUBLISHED;

				$country = Country::model()->findByAttributes(array("printable_name"=>$data->country));
				if($country)
				{
					$clubmodify->country = $country->printable_name;
					$clubmodify->country_iso = $country->iso;
					$clubmodify->geolocation = $country->geolocation;
					$clubmodify->status_address = Club::STATUS_PUBLISHED;
				}

				if($clubmodify->save())
				{
					$clubmodel = Club::model()->findByPk($data->id);
					$clubmodel->update_time = date('Y-m-d H:i:s');
					$clubmodel->update_user_id = Yii::app()->user->id;
					$clubmodel->name = $clubmodify->name;
					$clubmodel->address1 = $clubmodify->address1;
					$clubmodel->address2 = $clubmodify->address2;
					$clubmodel->address3 = $data->address3;
					$clubmodel->city = (empty($data->city) ? $data->address3 : $data->city);
					$clubmodel->state = $clubmodify->state;
					$clubmodel->country = $clubmodify->country;
					$clubmodel->postalcode = $clubmodify->postalcode;
					$clubmodel->country_iso = $clubmodify->country_iso;
					$clubmodel->geolocation = $clubmodify->geolocation;
					if($clubmodel->save())
					{
						$golfproperty = GolfProperty::model()->findByPk($clubmodel->golfproperty_id);
						if($golfproperty)
						{
							$golfproperty->name = $clubmodel->name;
							$golfproperty->city = $clubmodel->address3;
							$golfproperty->country_iso = $clubmodel->country_iso;
							$golfproperty->save();
						}
						
						if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
						{
							$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "The address has been updated for " . $clubmodel->name, 3);
						}
						echo "ok";
					}
				}
			}
		}

	}
        
	public function actionUpdate($id, $tab="1")
	{
		$user_id = Yii::app()->user->id;

		// get actual club model
		$clubmodel = Club::model()->findByPk($id);
		// get clubmodify model
		$clubmodify = ClubModify::model()->findByAttributes(array("club_id"=>$id));
		
		// clear notification
		$attribute  = array("notified"=>1, "viewed"=>"1");
		$condition 	= "user_id=:user_id AND golfproperty_id=:golfproperty_id";
		$param 		= array(":user_id"=>$user_id, ":golfproperty_id"=>$clubmodel->golfproperty_id);
		Notification::model()->updateAll($attribute, $condition, $param);

		// get all images exept deleted ones
		$criteria = new CDbCriteria;
		$criteria->condition = "club_id=:club_id AND status <> 0 ";
		$criteria->params = array(":club_id"=>$id);
		$criteria->order = "sequence";
		$clubimages = ClubImage::model()->findAll($criteria);
		foreach($clubimages as $oneimage)
		{
			list($width, $height) = getimagesize("/var/www/golfscape" . Image::COURSEFOLDER . $id . "/" . $oneimage->filename);
			$oneimage->dimension = "Original Image: " . $width . " x " . $height;
		}

		if(!$clubmodify)
		{
			// initiate the club modify object with club value
			$clubmodify = new ClubModify;
			$clubmodify->create_time = date('Y-m-d H:i:s');
			$clubmodify->create_user_id = $user_id;
			$clubmodify->club_id = $clubmodel->id;
			$clubmodify->name = $clubmodel->name;
			$clubmodify->address1 = $clubmodel->address1;
			$clubmodify->address2 = $clubmodel->address2;
			$clubmodify->city = $clubmodel->city;
			$clubmodify->state = $clubmodel->state;
			$clubmodify->country = $clubmodel->country;
			$clubmodify->country_iso = $clubmodel->country_iso;
			$clubmodify->postalcode = $clubmodel->postalcode;
			$clubmodify->timezone = $clubmodel->timezone;
			$clubmodify->currency = $clubmodel->currency;
			$clubmodify->description = $clubmodel->description;
			$clubmodify->maplink = $clubmodel->maplink;
			$clubmodify->clublogo = $clubmodel->clublogo;
			$clubmodify->weather = $clubmodel->weather;
			$clubmodify->geolocation = $clubmodel->geolocation;

			$clubmodify->status_address = Club::STATUS_PUBLISHED;
			$clubmodify->status_timezone = Club::STATUS_PUBLISHED;
			$clubmodify->status_currency = Club::STATUS_PUBLISHED;
			$clubmodify->status_description = Club::STATUS_PUBLISHED;
			$clubmodify->status_maplink = Club::STATUS_PUBLISHED;
			$clubmodify->status_clublogo = Club::STATUS_PUBLISHED;
			$clubmodify->status_weather = Club::STATUS_PUBLISHED;
			$clubmodify->status_geolocation = Club::STATUS_PUBLISHED;

			$clubmodify->save();
		}

		if(!$clubmodify->name)
		{
			$clubmodify->name = $clubmodel->name;
		}
		if(!$clubmodify->maplink)
		{
			$geopram = $clubmodify->city . ", " . $clubmodify->country_iso;
			$georesult = $this->getLocation($geopram);
			if($georesult)
			{
				$maplink = new stdClass;
				$maplink->address = $georesult['formatted_address'];
				$maplink->lat = $georesult['geometry']['location']["lat"];
				$maplink->lng = $georesult['geometry']['location']["lng"];
				$maplink->zoom = 7;
				
				$clubmodify->maplink = serialize($maplink);
			}
		}
		if(!$clubmodify->maplink)
		{
			$maplink = Club::model()->defaultMaplink();
			$clubmodify->maplink = serialize($maplink);
		}
		
		// amenities
		// get online amenities
		$model = Amenities::model()->findByAttributes(array("golfproperty_id"=>$clubmodel->golfproperty_id, "online"=>Amenities::ONLINE));
		if(!$model)
		{
			$model = new Amenities;
			$model->golfproperty_id = $clubmodel->golfproperty_id;
			$model->online = Amenities::ONLINE;
			$model->status = Club::STATUS_UNCHANGED;
			$model->save();
		}
		
		// get network version of amenities (offline)
		$model = Amenities::model()->findByAttributes(array("golfproperty_id"=>$clubmodel->golfproperty_id, "online"=>Amenities::OFFLINE));
		if(!$model)
		{
			$model = new Amenities;
			$model->golfproperty_id = $clubmodel->golfproperty_id;
			$model->online = Amenities::OFFLINE;
			$model->status = Club::STATUS_UNCHANGED;
			$model->save();
		}

		// lightbox
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/lib/lightbox/js/lightbox-2.6.min.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/lib/lightbox/css/lightbox.css');

		Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDaaZnb5epdmreK86POrZEmTqRgOJNpzDc&sensor=false');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-1.9.2.custom.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.form.js');
	
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jcrop/jquery.Jcrop.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jcrop/jquery.color.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jcrop/jquery.Jcrop.css');

		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrapSwitch.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrapSwitch.css');

		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminpages.changehistory.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminclub.update.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/adminclub.update.css');

		$this->pageTitle = $clubmodel->name ." | Golf Profiles | golfscape Team";
		$this->render("update", array("clubmodel"=>$clubmodel,
									  "clubmodify"=>$clubmodify,
									  "model"=>$clubmodify,
									  "clubimages"=>$clubimages,
									  "activetab"=>$tab));
	}

	public function actionCreate()
    {
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-ui-1.9.2.custom.min.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrapSwitch.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jcrop/jquery.Jcrop.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jcrop/jquery.color.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jcrop/jquery.Jcrop.css');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.form.js');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminclub.create.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/adminclub.create.css');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/bootstrapSwitch.css');

		$propertymodel = new GolfProperty;
		if(isset($_GET["propid"]))
		{
			$propertymodel = GolfProperty::model()->findByPk($_GET["propid"]);
		}
		if(!$propertymodel)
		{
			$propertymodel = new GolfProperty;
		}
		
        $this->pageTitle = "New Golf Property | golfscape Team";
		
        $this->render('create', array("propertymodel"=>$propertymodel));
    }

	private function signupsession($object, $value=false)
	{
		$sessionname = 'signupsession_' .$object;
		if(!isset(Yii::app()->session[$sessionname]))
		{
			Yii::app()->session[$sessionname] =  serialize(array());
		}
		if($value)
		{
			Yii::app()->session[$sessionname] =  serialize($value);
		}
		return unserialize(Yii::app()->session[$sessionname]);
	}
	public function actionRememberThis()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$stage = $data->stage;
			//$variables = new stdClass;
			if($stage==self::STAGE_USER)
			{
				$this->signupsession(self::STAGE_USER, $data);
			}
			else if($stage==self::STAGE_CLUB)
			{
				$this->signupsession(self::STAGE_CLUB, $data);
			}
			else if($stage==self::STAGE_DESCRIPTION)
			{
				$this->signupsession(self::STAGE_DESCRIPTION, $data);
			}
			else if($stage==self::STAGE_MAP)
			{
				$this->signupsession(self::STAGE_MAP, $data);
			}
			else if($stage==self::STAGE_CLUBLOGO)
			{
				$variables->filename = $data->filename;
				$variables->original = Image::COURSEFOLDER ."0/" . $data->filename;
				$variables->thumbnail = Image::COURSEFOLDER . "0/h80/" . $data->filename;
				$this->signupsession(self::STAGE_CLUBLOGO, $variables);
			}
			else if($stage==self::STAGE_COURSE)
			{
				$this->signupsession(self::STAGE_COURSE, $data);
			}
			else if($stage==self::STAGE_IMAGES)
			{
				$this->signupsession(self::STAGE_IMAGES, $data);
			}
			else
			{
				// reserved
			}

		}
	}
//	public function actionGetVersionHistory()
//    {   
//        $result = new stdClass();
//        $result->ok = "no";
//        if(isset($_POST["data"]))
//        {
//            $data = json_decode($_POST["data"]);
//            
//            $versionHistory = new VersionHistory;
//            $versionHistory->id = $data->id;
//            $versionHistory->model = $data->model;
//			if(isset($data->attr))
//			{
//				$versionHistory->attribute = $data->attr;
//			}
//			
//			$logsarray = $versionHistory->getHistory();
//			
//			if($logsarray)
//			{
//				$result->ok = "ok";
//				$result->historyarray = $logsarray;
//			}
//			
//            //print CJSON::encode($result);
//            print json_encode($result);
//        }
//    }
	
//	public function actionGetVersionHistory()
//    {   
//        $result = new stdClass();
//        $result->ok = "no";
//        if(isset($_POST["data"]))
//        {
//            $data = json_decode($_POST["data"]);
//            $model_id = $data->id;
//            $model = $data->model;
//			
//            $logsarray = NULL;
//            $versionHistory = new VersionHistory;
//            
//            $result->ok = $model.$model_id;
//            if(isset($data->attr))
//            {
//                $logsarray = $versionHistory->GetFullHistory($model ,$model_id, $data->attr);
//            }
//            else
//            {
//                $logsarray = $versionHistory->GetFullHistory($model, $model_id);
//            }
//            if(isset($data->unique_model))
//            {
//                if($data->unique_model=="Course")
//                {
//                    foreach ($logsarray as $key=>$value)
//                    {
//                        $temp = unserialize($logsarray[$key]->object->modification);
//                        $logsarray[$key]->object->modification = $temp;
//                    }
//                }
//            }
//            if($logsarray)
//            {
//                $result->historyarray = $logsarray;
//                $result->ok="ok";
//            }
//            
//            print CJSON::encode($result);
//        }
//    }
//	
//    public function actionrevertversionhistory()
//    {
//        $result= new stdClass();
//        $result->ok="no";
//		
//        if(isset($_POST["data"]))
//        {
//            $data = json_decode($_POST["data"]);
//            $systemlog = SystemLog::model()->findByPk($data->log_id);
//            if($systemlog)
//            {
//                $model = $systemlog->model;
//                $model_id = $systemlog->model_id;
//                $dataobject = unserialize($systemlog->dataobject);
//                $object = isset($dataobject->after) ? $dataobject->after : $dataobject;
//				
//                if($model=="Club")
//                {
//                   $clubmodel= $model::model()->findByPk($model_id);
//                   $clubmodifymodel=  ClubModify::model()->findByAttributes(array("club_id"=>$model_id));
//
//                    if($clubmodel && $clubmodifymodel)
//                    {
//                        
//                        $revert_attr=$data->revert_attribute;
//                        if(  is_array($revert_attr))
//                        {
//                            for($i=0;$i<count($revert_attr);$i++)
//                            {
//                                $clubmodel->$revert_attr[$i]=$object->$revert_attr[$i];
//                                if($revert_attr[$i]!="address3")
//                                {
//                                    $clubmodifymodel->$revert_attr[$i]=$object->$revert_attr[$i];
//                                }
//                            }
//                        }
//                        else
//                        {
//                           $clubmodel->$revert_attr=$object->$revert_attr;
//                            $clubmodifymodel->$revert_attr=$object->$revert_attr; 
//                        }
//                        if($clubmodel->save() && $clubmodifymodel->save())
//                        {
//                            $result->ok="ok";
//                        }
//                    }
//                }
//                else
//                {
//                    $revertmodel = $model::model()->findByPk($model_id);
//                    if($revertmodel)
//                    {
//                        
//                        if(isset($data->revert_attribute))
//                        {
//                            $revert_attr=$data->revert_attribute;
//                            $revertmodel->$revert_attr=$object->$revert_attr;
//                            if($revertmodel->save())
//                            {
//                                $result->ok="ok";
//                            }
//                        }
//                        else
//                        {
//                            $attributes = $revertmodel->attributeLabels();
//                            foreach($attributes as $name=>$label)
//                            {
//                                if(in_array($name, array("create_time", "update_time", "create_user_id", "update_user_id", "id")))
//                                {
//                                    continue;
//                                }
//                                if(((isset($revertmodel->$name) || is_null($revertmodel->$name)) && isset($object->$name) && ($revertmodel->$name!=$object->$name)) || (is_null($object->$name) && !is_null($revertmodel->$name)))
//                                {
//                                   // Yii::log($name);
//                                    $revertmodel->$name=$object->$name;
//                                }
//                            }
//                            if($revertmodel->save())
//                            {
//                                $result->ok="ok";
//                            }
//                            
//                        }
//                    }
//                    
//                }
////                 
////                 
////                 $result->test=$dataobject->after->$revert_attr;
//            }
//            else
//            {
//                $result->test=$data->revert_attribute;
//            }
//            
//            print CJSON::encode($result);
//        }
//    }
    public function actionGetSavedData()
	{
		if(isset($_POST["data"]))
		{
			$sessiondata = new stdClass;
			$sessiondata->user = $this->signupsession(self::STAGE_USER);
			$sessiondata->club = $this->signupsession(self::STAGE_CLUB);
			$sessiondata->description = $this->signupsession(self::STAGE_DESCRIPTION);
			$sessiondata->map = $this->signupsession(self::STAGE_MAP);
			$sessiondata->courses = $this->signupsession(self::STAGE_COURSE);
			$sessiondata->clublogo = $this->signupsession(self::STAGE_CLUBLOGO);
			$sessiondata->images = $this->signupsession(self::STAGE_IMAGES);
			if(isset($sessiondata->images->images) && (count($sessiondata->images->images)>0))
			{
				$images = array();
				foreach($sessiondata->images->images as $imageid)
				{
					$clubimage = ClubImage::model()->findByPk($imageid);
					if($clubimage)
					{
						$oneimage = new stdClass();
						$oneimage->id = $clubimage->id;
						$oneimage->thumbnail = $clubimage->getImagePath(array("w"=>150));
						$oneimage->original = $clubimage->getImagePath();
						$images[] = $oneimage;
					}
				}
				$sessiondata->images->images = $images;
			}
			print CJSON::encode($sessiondata);
		}
	}

	//public function actionGetCoordinates()
	//{
	//	if(isset($_POST["data"]))
	//	{
	//		$data = json_decode($_POST["data"]);
	//
	//		$city = $data->city;
	//		$country = $data->country;
	//
	//		$maplink = new stdClass;
	//
	//		$geopram = $city . ", " . $country;
	//		// TODO: move this function somewhere else
	//		$georesult = ManageClubController::getLocation($geopram);
	//		if($georesult)
	//		{
	//			$maplink->lat = $georesult['geometry']['location']["lat"];
	//			$maplink->lng = $georesult['geometry']['location']["lng"];
	//		}
	//		else
	//		{
	//			$maplink = Club::model()->defaultMaplink();
	//		}
	//
	//		print CJSON::encode($maplink);
	//	}
	//}
	public function actionGetCoordinates()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);

			$model = new Club;
			$model->city = $data->city;
			$model->state = $data->state;
			$model->country = $data->country;

			$maplink = $model->getMapCoordinates();
			
			print CJSON::encode($maplink);
		}
	}

	/***
	 * Upload Club Logo temporarily
	 */
	public function actionUploadClubLogoTemp()
	{
		if(isset($_FILES["image"]))
		{
			$tempfilename = $_FILES['image']['tmp_name'];
            $filesize = $_FILES["image"]["size"];
            $filetype = $_FILES["image"]["type"];

            if(($filetype == "image/gif") || ($filetype == "image/jpeg") || ($filetype == "image/png"))
			{
				// construct a unique file name
				$extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
				$newfilename = sha1(uniqid(true)) . "." . strtolower($extension);

				// dummy model
				$model = new ClubModify;
				$model->club_id = 0;
				$model->clublogo = $newfilename;

				// prepare the club folder
				$clubfolder = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $model->club_id;
				if(!is_dir($clubfolder))
				{
					// create if doesn't exists
					mkdir($clubfolder, 0777);
				}
				// move the file
				$ok = move_uploaded_file($tempfilename, $clubfolder . "/" . $newfilename);

				$result = new stdClass();
				if($ok)
				{
					$imagemodel = new Image;
					$imagemodel->folder = Image::COURSEFOLDER . $model->club_id;
					$imagemodel->filename = $model->clublogo;
					if($imagemodel->resize(array("h"=>80)))
					{
						$result->error = false;
						$result->filename = $imagemodel->path;
						$result->original = $imagemodel->originalpath;
						$result->uniquefilename = $newfilename;	
					}
					else
					{
						$result = new stdClass();
						$result->error = true;
						$result->alert = $imagemodel->errormessage;
						print CJSON::encode($result);	
					}
				}
				else
				{
					$result->error = true;
					$result->alert = "Unable to upload file.";
				}

				print CJSON::encode($result);

			}
            else
			{
				$result = new stdClass();
				$result->error = true;
				$result->alert = "Invalid file";
				print CJSON::encode($result);
			}
		}
	}
	/***
	 * Upload club image temporarily
	 */
	public function actionUploadClubImageTemp()
	{
		if(isset($_FILES["image"]))
		{
			$tempfilename = $_FILES['image']['tmp_name'];
            $filesize = $_FILES["image"]["size"];
            $filetype = $_FILES["image"]["type"];

			list($width, $height) = getimagesize($tempfilename);

            if((($filetype == "image/gif") || ($filetype == "image/jpeg") || ($filetype == "image/png")) && (($width>=780) && ($height>=438)))
			{
				// construct a unique file name
				$extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
				$newfilename = sha1(uniqid(true)) . "." . strtolower($extension);

				// dummy model with zero id
				$model = new Club;
				$model->id = 0;
				//$model->clublogo = "";

				// prepare the club folder
				$clubfolder = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $model->id;
				if(!is_dir($clubfolder))
				{
					// create if doesn't exists
					mkdir($clubfolder, 0777);
				}
				// move the file
				$ok = move_uploaded_file($tempfilename, $clubfolder . "/" . $newfilename);

				if($ok)
				{
					$clubimage = new ClubImage;
					$clubimage->create_time = date('Y-m-d H:i:s');
					$clubimage->create_user_id = Yii::app()->user->id;
					$clubimage->update_time = date('Y-m-d H:i:s');
					$clubimage->update_user_id = Yii::app()->user->id;
					$clubimage->club_id = $model->id;
					$clubimage->filename = $newfilename;
					$clubimage->status = Club::STATUS_PUBLISHED;
					$clubimage->imagenumber = 0;
					$clubimage->sequence = $clubimage->imagenumber;
					$clubimage->save();

					// $ratio
					$ideal_ratio = 16 / 9;
					//$square_ratio = 1;
					$image_ratio = $width/$height;
					if($image_ratio > $ideal_ratio)
					{
						$cropheight = $height;
						$cropwidth = $height * 16 / 9;
					}
					else
					{
						$cropwidth = $width;
						$cropheight = $width * 9 / 16;
					}

					$result = new stdClass();
					$result->id = $clubimage->id;
					if($image_ratio > $ideal_ratio)
					{
						$result->minheight = 438.75;
						$result->minwidth = $result->minheight * 16 / 9;
					}
					else
					{
						$result->minwidth = 780;
						$result->minheight = $result->minwidth * 9 / 16;
					}

					$imagemodel = new Image;
					$imagemodel->folder = Image::COURSEFOLDER . $clubimage->club_id;
					$imagemodel->filename = $clubimage->filename;
					if($imagemodel->resize(array("h"=>300, "w"=>800)))
					{
						$result->filename = $imagemodel->path;
						$result->imagenumber = $clubimage->imagenumber;
						$result->width = $width;
						$result->height = $height;
						$result->cropwidth = $cropwidth;
						$result->cropheight = $cropheight;
	
						print CJSON::encode($result);	
					}
					else
					{
						$result = new stdClass();
						$result->error = true;
						$result->alert = $imagemodel->errormessage;
						print CJSON::encode($result);
					}
				}
			}
            else
			{
				//echo "error";
				$result = new stdClass();
				$result->error = true;
				$result->alert = "";
				print CJSON::encode($result);
			}
		}
	}
	/***
	 * Resized the uploaded image using the same filename
	 */
	public function actionClubImageResizeTemp()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubimage = ClubImage::model()->findByPk($data->id);
			
			//resize image
			$imagemodel = new Image;
			$imagemodel->folder = Image::COURSEFOLDER . $clubimage->club_id;
			$imagemodel->filename = $clubimage->filename;
			if($imagemodel->crop($data))
			{
				$clubimage->status = Club::STATUS_PUBLISHED;
				if($clubimage->save())
				{
					// do nothing for now
				}
				
				if($imagemodel->resize(array("w"=>150)))
				{
					$result = new stdClass();
					$result->id = $clubimage->id;
					$result->thumbnail = $imagemodel->path;
					$result->original = $imagemodel->originalpath;
		
					print CJSON::encode($result);	
				}
			}
			 
		}
	}
	//public function actionDeleteClubImage()
	//{
	//	if(isset($_POST["data"]))
	//	{
	//		$id = $_POST["data"];
	//		$model = ClubImage::model()->findByPk($id);
	//		$model->delete();
	//	}
	//}
	/***
	 * Final step in the wizard
	 */
	public function actionClubRegistration()
	{
		$this->systemLog("Creating new golf property");
		if(isset($_POST["data"]))
		{
			$result = new stdClass;
			$result->error = 0;
			$result->message = array();
			
			$propid = intval($_POST["data"]);

			$sessiondata = new stdClass;
			$sessiondata->club = $this->signupsession(self::STAGE_CLUB);
			$sessiondata->description = $this->signupsession(self::STAGE_DESCRIPTION);
			$sessiondata->map = $this->signupsession(self::STAGE_MAP);
			$sessiondata->courses = $this->signupsession(self::STAGE_COURSE);
			$sessiondata->clublogo = $this->signupsession(self::STAGE_CLUBLOGO);
			$sessiondata->images = $this->signupsession(self::STAGE_IMAGES);
			
			// create a lead
			$golfproperty = GolfProperty::model()->findByPk($propid);
			if(!$golfproperty)
			{
				$golfproperty = new GolfProperty;
			}
			
			$golfproperty->name = preg_replace("/\s+/", " ", $sessiondata->club->clubname);
			$golfproperty->city = $sessiondata->club->city;
			$golfproperty->country_iso = $sessiondata->club->country;
			if($golfproperty->isNewRecord)
			{
				$golfproperty->account_cycle = GolfProperty::CYCLE_LEAD;
				$golfproperty->cycle_status = GolfProperty::CYCLE_STATUS_NORMAL;	
			}
			if($golfproperty->save())
			{
				$this->systemLog("Golf Property created.");	
			}
			else
			{
				$this->systemDBLog("Cannot create a lead", $golfproperty);
			}

			// initialize object
			$clubmodel = new Club;
			$clubmodify = new ClubModify;
			$country = Country::model()->findByAttributes(array("iso"=>$sessiondata->club->country));
			if(!$country)
			{
				$result->error = 1;
				$result->message[] = "Country not recognized.";
			}
			$user_id = Yii::app()->user->id;

			// Construct Club Model
			$clubmodel->name = preg_replace("/\s+/", " ", $sessiondata->club->clubname);
			$clubmodel->address1 = $sessiondata->club->address1;
			$clubmodel->address2 = $sessiondata->club->address2;
			$clubmodel->address3 = $sessiondata->club->city;
			$clubmodel->city = $sessiondata->club->city;
			$clubmodel->state = $sessiondata->club->state;
			$clubmodel->country = $country->printable_name;
			$clubmodel->country_iso = $country->iso;
			$clubmodel->postalcode = $sessiondata->club->postalcode;
			$clubmodel->timezone = "";
			$clubmodel->currency = "";
			$clubmodel->description = $sessiondata->description->description;
			$clubmodel->maplink = serialize($sessiondata->map->maplink);
			$clubmodel->clublogo = isset($sessiondata->clublogo->filename) ? $sessiondata->clublogo->filename : "";
			$clubmodel->weather = "";
			$clubmodel->geolocation = "";
			$clubmodel->status = Club::PROFILE_OFFLINE;
			$clubmodel->golfproperty_id = $golfproperty->id;
			if(!$clubmodel->save())
			{
				$result->error = 1;
				$result->message[] = "Club information cannot be saved";
				$this->systemDBLog("Saving profile error", $clubmodel);
			}

			// Construct Club Modify Model
			$clubmodify->create_time = date('Y-m-d H:i:s');
			$clubmodify->create_user_id = $user_id;
			$clubmodify->update_time = date('Y-m-d H:i:s');
			$clubmodify->update_user_id = $user_id;
			$clubmodify->club_id = $clubmodel->id;
			$clubmodify->name = $clubmodel->name;
			$clubmodify->address1 = $clubmodel->address1;
			$clubmodify->address2 = $clubmodel->address2;
			$clubmodify->city = $clubmodel->city;
			$clubmodify->state = $clubmodel->state;
			$clubmodify->country = $clubmodel->country;
			$clubmodify->country_iso = $clubmodel->country_iso;
			$clubmodify->postalcode = $clubmodel->postalcode;
			$clubmodify->timezone = $clubmodel->timezone;
			$clubmodify->currency = $clubmodel->currency;
			$clubmodify->description = $clubmodel->description;
			$clubmodify->maplink = $clubmodel->maplink;
			$clubmodify->clublogo = $clubmodel->clublogo;
			$clubmodify->weather = $clubmodel->weather;
			$clubmodify->geolocation = "";
			$clubmodify->status_address = Club::STATUS_PUBLISHED;
			$clubmodify->status_timezone = Club::STATUS_PUBLISHED;
			$clubmodify->status_currency = Club::STATUS_PUBLISHED;
			$clubmodify->status_description = Club::STATUS_PUBLISHED;
			$clubmodify->status_maplink = Club::STATUS_PUBLISHED;
			$clubmodify->status_clublogo = Club::STATUS_PUBLISHED;
			$clubmodify->status_weather = Club::STATUS_PUBLISHED;
			$clubmodify->status_geolocation = Club::STATUS_PUBLISHED;
			//$clubmodify->sessionid' => 'Temporary Session',
			if(!$clubmodify->save())
			{
				$result->error = 1;
				$result->message[] = "Temporary Club information cannot be saved into the database";
				$this->systemDBLog("Saving temporary profile error", $clubmodify);
			}

			// Golf Courses
			if(isset($sessiondata->courses->courses) && (count($sessiondata->courses->courses)>0))
			{
				foreach($sessiondata->courses->courses as $onecourse)
				{
					$coursemodel = new Course;
					$coursemodel->create_time = date('Y-m-d H:i:s');
					$coursemodel->create_user_id = $user_id;
					$coursemodel->update_time = date('Y-m-d H:i:s');
					$coursemodel->update_user_id = $user_id;
					$coursemodel->club_id = $clubmodel->id;
					$coursemodel->name = $onecourse->coursename;
					$coursemodel->description = "";
					$coursemodel->status = Club::STATUS_PUBLISHED;
					$coursemodel->properties = serialize(array());
					$coursemodel->modification = serialize($onecourse);
					if(!$coursemodel->save())
					{
						$result->error = 1;
						$result->message[] = "Golf course creation problem: " . $onecourse;
						$this->systemDBLog("Golf course creation error", $coursemodel);
					}
				}
			}
			
			// amenities
			// get online amenities
			$amenitiesmodel = Amenities::model()->findByAttributes(array("golfproperty_id"=>$golfproperty->id, "online"=>Amenities::ONLINE));
			if(!$amenitiesmodel)
			{
				$amenitiesmodel = new Amenities;
				$amenitiesmodel->golfproperty_id = $golfproperty->id;
				$amenitiesmodel->online = Amenities::ONLINE;
				$amenitiesmodel->status = Club::STATUS_PUBLISHED;
				$amenitiesmodel->save();
			}
			// get network version of amenities (offline)
			$amenitiesmodel = Amenities::model()->findByAttributes(array("golfproperty_id"=>$golfproperty->id, "online"=>Amenities::OFFLINE));
			if(!$amenitiesmodel)
			{
				$amenitiesmodel = new Amenities;
				$amenitiesmodel->golfproperty_id = $golfproperty->id;
				$amenitiesmodel->online = Amenities::OFFLINE;
				$amenitiesmodel->status = Club::STATUS_PUBLISHED;
				$amenitiesmodel->save();
			}
			
			// Prepare club's image folder
			$clubfolder = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $clubmodel->id;
			if(!is_dir($clubfolder))
			{
				mkdir($clubfolder, 0777);
			}

			// Club Images
			if(isset($sessiondata->images->images) && (count($sessiondata->images->images)>0))
			{
				$imagenumber = 1;
				foreach($sessiondata->images->images as $imageid)
				{
					$clubimage = ClubImage::model()->findByPk($imageid);
					if($clubimage)
					{
						$clubimage->club_id = $clubmodel->id;
						$clubimage->imagenumber = $imagenumber++;
						$clubimage->remotecopy = 0;
						if(!$clubimage->save())
						{
							$result->error = 1;
							$result->message[] = "Images gone missing";
						}
						// copy the file
						$source = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER ."0/" . $clubimage->filename;
						$destination = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $clubmodel->id . "/" . $clubimage->filename;
						if(!copy($source, $destination))
						{
							$result->error = 1;
							$result->message[] = "Club image gone missing.";
						}
					}
				}
			}

			// Move Club Image
			if($clubmodel->clublogo)
			{
				$source = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . "0/" . $clubmodel->clublogo;
				$destination = $_SERVER['DOCUMENT_ROOT'] . Image::COURSEFOLDER . $clubmodel->id . "/" . $clubmodel->clublogo;
				if(copy($source, $destination))
				{
					$clubmodel->createRemoteLogo(array('h'=>80));
				}
				else
				{
					$result->error = 1;
					$result->message[] = "Club logo gone missing.";
				}
			}

			// Admin Permission (All for now)
			//if($result->error == 0)
			//{
			//	$adminusers = User::model()->findAllByAttributes(array("usertype"=>User::TYPE_ADMIN));
			//	foreach($adminusers as $oneadmin)
			//	{
			//		$clubuser = new ClubUser;
			//		$clubuser->user_id = $oneadmin->id;
			//		$clubuser->golfproperty_id = $golfproperty->id;
			//		$clubuser->status 	= 1;
			//		if(!$clubuser->save())
			//		{
			//			$result->error = 1;
			//			$result->message[] = "Unable to assign an admin to your Club";
			//		}
			//	}
			//}

			if($result->error == 0)
			{
				unset(Yii::app()->session['signupsession_' . self::STAGE_USER]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_CLUB]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_DESCRIPTION]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_MAP]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_COURSE]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_CLUBLOGO]);
				unset(Yii::app()->session['signupsession_' . self::STAGE_IMAGES]);

				$result->url = $this->createUrl("adminclub/allclubs");
			}

			print CJSON::encode($result);
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAllClubs()
	{
		/*if(isset($_GET["Club_page"]))
		{
			$pagenumber = $_GET["Club_page"];
			UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $pagenumber);
		}
		else
		{
			if(isset($_GET["ajax"]))
			{
				$pagenumber = 1;
				UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $pagenumber);
			}
		}

		if(isset($_GET["Club_sort"]))
		{
			$pagesortorder = $_GET["Club_sort"];
			UserSetting::model()->saveSettings("adminclub-admin-sortorder", $pagesortorder);
		}
		if(isset($_GET["sort"]))
		{
			$pagesortorder = $_GET["sort"];
			UserSetting::model()->saveSettings("adminclub-admin-sortorder", $pagesortorder);
		}
		else
		{
			//if(isset($_GET["ajax"]))
			//{
				//$pagesortorder = "create_time.desc";
				//UserSetting::model()->saveSettings("adminclub-admin-sortorder", $pagesortorder);
			//}
		}
                */
		//$pagenumber = UserSetting::model()->getSettings("adminclub-admin-pagenumber");
                          //abi/
		if(!isset($_GET["Club_page"]) && isset($_GET["ajax"]))
		{
			$newpagenumber=1;
			UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $newpagenumber);
		}
		if(isset($_GET["sort"]) && isset($_GET["Club_page"]))
		{       
			$usersettingmodel=  UserSetting::model()->getsettings("adminclub-admin-sortorder");
			$storedsortorder=NULL;
			///if adminclub-admin-sortorder for this user exists, assign it to stored order
			if($usersettingmodel!==false)
			{
				$storedsortorder=$usersettingmodel;
			}/////if adminclub-admin-sortorder for this user doesn't exists creat new and save the curunt sort order
			else
			{
				$newsortorder=$_GET["sort"];
				UserSetting::model()->saveSettings("adminclub-admin-sortorder", $newsortorder);
			}
			////if storedsortorder is not null and matches the currunt sort order request
			if($storedsortorder!=NULL && $storedsortorder===$_GET["sort"])
			{
				UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $_GET["Club_page"]);
			}else
			{
				UserSetting::model()->saveSettings("adminclub-admin-sortorder", $_GET["sort"]);
				UserSetting::model()->saveSettings("adminclub-admin-pagenumber", 1);
			}
		
			//$pagenumber = $_GET["Club_page"];
			//UserSetting::model()->saveSettings("adminproperty-admin-pagenumber", $pagenumber);
		}
			elseif (!isset($_GET["sort"]) && isset($_GET["Club_page"])) 
			{
				$newpagenumber=$_GET["Club_page"];
				UserSetting::model()->saveSettings("adminclub-admin-sortorder", 'id.desc');

				UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $newpagenumber);
			}
			elseif (!isset($_GET["sort"]) && !isset($_GET["Club_page"]))
			{
				$userstoredpagesetting =  UserSetting::model()->getSettings("adminclub-admin-pagenumber");
				$userstoredsortsetting =  UserSetting::model()->getSettings("adminclub-admin-sortorder");
				$newpagenumber=1;
				$newsortorder='id.desc';

				if($userstoredpagesetting!==false){
					$newpagenumber=$userstoredpagesetting;
				}
				if($userstoredsortsetting!==false){
					$newsortorder=$userstoredsortsetting;
				}
				UserSetting::model()->saveSettings("adminclub-admin-sortorder", $newsortorder);
				UserSetting::model()->saveSettings("adminclub-admin-pagenumber", $newpagenumber);
			}
		$model=new Club('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Club']))
			$model->attributes=$_GET['Club'];

		$this->pageTitle = "Golf Profiles | golfscape Team";
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
 
	function actionRememberThisFilter()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			UserSetting::model()->saveSettings("adminclub-admin-status", $data);
		}
		else
			throw new CHttpException(400,'The requested page does not exist.');
	}

	function actionRetrieveThisFilter()
	{
		if(isset($_POST["data"]))
		{
			$code = $_POST["data"];
			$filters = UserSetting::model()->getSettings($code);

			print CJSON::encode($filters);
		}
		else
			throw new CHttpException(400,'The requested page does not exist.');
	}
	
	public function actionHomePageStatus()
	{
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubmodel = Club::model()->findByPk($data->id);
			if($clubmodel)
			{
				$clubmodel->homepage = $data->value ? 1 : 0;
				if($clubmodel->save())
				{
					echo "ok";
				}
			}
		}
	}
	public function actionSaveAmenities()
	{       
		if(isset($_POST["data"]))
		{
			$data = json_decode($_POST["data"]);
			$clubmodel = Club::model()->findByPk($data->club_id);
			if($clubmodel)
			{
				// save offline
				$amenitiesmodel = Amenities::model()->findByAttributes(array("golfproperty_id"=>$clubmodel->golfproperty_id, "online"=>Amenities::OFFLINE));
				if(!$amenitiesmodel)
				{
					$amenitiesmodel = new Amenities;
					$amenitiesmodel->golfproperty_id = $clubmodel->golfproperty_id;
					$amenitiesmodel->online = Amenities::OFFLINE;
				}
				foreach($data->amenities as $amenity)
				{
					$fieldname = str_replace("amenities-", "", $amenity->id);
					$amenitiesmodel->$fieldname = $amenity->value ? 1 : 0;
				}
				$notifynetwork = $amenitiesmodel->status==Club::STATUS_PENDING;
				$amenitiesmodel->status = Club::STATUS_PUBLISHED;
				$amenitiesmodel->save();
                                
				// save online
				$amenitiesmodel = Amenities::model()->findByAttributes(array("golfproperty_id"=>$clubmodel->golfproperty_id, "online"=>Amenities::ONLINE));
				if(!$amenitiesmodel)
				{
					$amenitiesmodel = new Amenities;
					$amenitiesmodel->golfproperty_id = $clubmodel->golfproperty_id;
					$amenitiesmodel->online = Amenities::ONLINE;
				}
				foreach($data->amenities as $amenity)
				{
					$fieldname = str_replace("amenities-", "", $amenity->id);
					$amenitiesmodel->$fieldname = $amenity->value ? 1 : 0;
				}
				$amenitiesmodel->status = Club::STATUS_PUBLISHED;
				$amenitiesmodel->save();
				
				if(($clubmodel->status==Club::PROFILE_ONLINE) && $notifynetwork)
				{
					$this->clubDetailUpdateNotification($clubmodel->golfproperty_id, "The amenities has been updated for " . $clubmodel->name, 1);	
				}
				 
			}
			echo "ok";
		}
	}
	
	private function clubDetailUpdateNotification($id, $message, $tab=1)
	{
		// send notification to admin users
		$clubusers = ClubUser::model()->findAllByAttributes(array("golfproperty_id"=>$id));
		if($clubusers)
		{
			// send notification if notification template is enabled
			$notificationtemplate = NotificationTemplate::model()->findByAttributes(array("code"=>"S2C-004", "enabled"=>1));
			if($notificationtemplate)
			{
				// send notification if club exist (of course it is)
				$clubmodel = Club::model()->findByAttributes(array("golfproperty_id"=>$id));
				if($clubmodel)
				{
					//// construct the list
					//$liveurl = null;
					//if($tab==0)
					//{
					//	$liveurl = $clubmodel->webUrl();
					//}
					
					$link = new stdClass;
					$link->action = "networkprofile/update";
					$link->params = array("id"=>$clubmodel->golfproperty_id, "tab"=>$tab);
					//$link->params = array("id"=>$clubmodel->golfproperty_id, "tab"=>$tab, "livelink"=>$liveurl);
					
					// variables
					$variables = array("message"=>$message);

					foreach($clubusers as $oneuser)
					{
						$usermodel = User::model()->findByPk($oneuser->user_id);

						if(($usermodel) && ($usermodel->usertype == User::TYPE_CLUB))
						{
							$notification = Notification::model()->findByAttributes(array("user_id"=>$usermodel->id, "template_code"=>$notificationtemplate->code, "variables"=>serialize($variables), "notified"=>"0"));
							
							if($notification)
							{
								$notification->datesent = date('Y-m-d H:i:s');
								$notification->golfproperty_id = $clubmodel->golfproperty_id;
								$notification->save();	
							}
							else
							{
								$notification = new Notification;
								$notification->datesent = date('Y-m-d H:i:s');
								$notification->user_id = $usermodel->id;
								$notification->template_code = $notificationtemplate->code;
								$notification->message = $notificationtemplate->message;
								$notification->variables = serialize($variables);
								$notification->link = serialize($link);
								$notification->golfproperty_id = $clubmodel->golfproperty_id;
								$notification->save();	
							}
						}
					}
				}
			}
		}
	}
	
	//private function onlineProfileAlert($id, $message, $tab=1)
	//{
	//	// send notification to admin users
	//	$clubusers = ClubUser::model()->findAllByAttributes(array("golfproperty_id"=>$id));
	//	if($clubusers)
	//	{
	//		// send notification if notification template is enabled
	//		$notificationtemplate = NotificationTemplate::model()->findByAttributes(array("code"=>"S2C-004", "enabled"=>1));
	//		if($notificationtemplate)
	//		{
	//			// send notification if club exist (of course it is)
	//			$clubmodel = Club::model()->findByAttributes(array("golfproperty_id"=>$id));
	//			if($clubmodel)
	//			{
	//				//// construct the list
	//				//$liveurl = null;
	//				//if($tab==0)
	//				//{
	//				//	$liveurl = $clubmodel->webUrl();
	//				//}
	//				
	//				$link = new stdClass;
	//				$link->action = "networkprofile/update";
	//				$link->params = array("id"=>$clubmodel->golfproperty_id, "tab"=>$tab);
	//				//$link->params = array("id"=>$clubmodel->golfproperty_id, "tab"=>$tab, "livelink"=>$liveurl);
	//				
	//				// variables
	//				$variables = array("message"=>$message);
	//
	//				foreach($clubusers as $oneuser)
	//				{
	//					$usermodel = User::model()->findByPk($oneuser->user_id);
	//
	//					if(($usermodel) && ($usermodel->usertype == User::TYPE_CLUB))
	//					{
	//						$notification = Notification::model()->findByAttributes(array("user_id"=>$usermodel->id, "template_code"=>$notificationtemplate->code, "variables"=>serialize($variables), "notified"=>"0"));
	//						
	//						if($notification)
	//						{
	//							$notification->datesent = date('Y-m-d H:i:s');
	//							$notification->golfproperty_id = $clubmodel->golfproperty_id;
	//							$notification->save();	
	//						}
	//						else
	//						{
	//							$notification = new Notification;
	//							$notification->datesent = date('Y-m-d H:i:s');
	//							$notification->user_id = $usermodel->id;
	//							$notification->template_code = $notificationtemplate->code;
	//							$notification->message = $notificationtemplate->message;
	//							$notification->variables = serialize($variables);
	//							$notification->link = serialize($link);
	//							$notification->golfproperty_id = $clubmodel->golfproperty_id;
	//							$notification->save();	
	//						}
	//					}
	//				}
	//			}
	//		}
	//	}
	//}
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
