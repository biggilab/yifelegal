<?php
/**
 *
 */
class Img extends CModel
{
	public $classLabel = "Img";
	
//	const COURSEFOLDER = "/images/clubs/";
//	const TAGSFOLDER = "/images/tags/";
//	const DESTINATIONFOLDER = "/images/destinations/";
//	const USERPHOTOFOLDER = "/images/userprofile/";
//	
//	const REMOTE_COURSEFOLDER = "/courses/";
//	const REMOTE_TAGSFOLDER = "/tags/";
//	const REMOTE_DESTINATIONFOLDER = "/destinations/";
//	const REMOTE_USERPHOTOFOLDER = "/profile/";
//	
//	public $filename;		// unique filename (mandatory)
//	public $remoteprefix;	// filename prefix (optional)
//	public $folder; 		// images/clubs/<id>, images/tags/<id>, images/destinations/<id> (mandatory)
//	public $remotefolder;  	// /courses/<id>, /tags/<id>, /destinations/<id> (mandatory if remote image)
//	
//	public $path;			// the image path that was last created
//	public $originalpath;	// the original image path 
//	public $errormessage;	// holds the error message if there's any
//	
//	public $folder_width;	// folder property
//	public $folder_height;	// folder property
//	
//	private $remotefiles;
//	private $sourceimagefile;
//	private $destinationfile;
//	private $coordinates;   // imagecopyresampled coordinates parameter
//	private $crop;
//	private $forcesize;
//	
    public $filepath;
    public $filename;
    public $width;
    public $height;
    public $new_width;
    public $new_height;
    public $originalimage;
    public $error;
    public $thumb_resize_width;
    public $thumb_resize_height;
    const thumb_width=200;
    const thumb_height=250;
    public function attributeNames()
	{
		return array();
	}
    public function get_image_size()
    {
        list($this->width,  $this->height)= getimagesize($this->filepath.$this->filename);
        $this->originalimage=  $this->filepath.$this->filename;
        Yii::log($this->originalimage);
    }
    public function create_thumbnail()
    {
        $this->get_image_size();
        $thumb_directory=  $this->filepath."/thumb/";
        if(!is_dir($thumb_directory))
		{
			Yii::log("Creating thumb folder " . $thumb_directory);
			if(mkdir($thumb_directory, 0777, true)===false)
			{
				Yii::log("Unable to thumb image folder " . $thumb_directory);
				return false;
			}
		}
        $thumb=$thumb_directory.$this->filename;
        $imgtyp = pathinfo($this->originalimage, PATHINFO_EXTENSION);
		if($imgtyp == 'jpeg') $imgtyp = 'jpg';
		switch($imgtyp){
			case 'bmp': $sourceimage = imagecreatefromwbmp($this->originalimage); break;
			case 'gif': $sourceimage = imagecreatefromgif($this->originalimage); break;
			case 'jpg': $sourceimage = imagecreatefromjpeg($this->originalimage); break;
			case 'png': $sourceimage = imagecreatefrompng($this->originalimage); break;
			default : return "Unsupported Image type!";
		}
        if ($sourceimage === false) 
        {
            Yii::log("Unable create image " . $imgtyp);
            return false;
        }
        $source_aspect_ratio = $this->width / $this->height;
        $thumbnail_aspect_ratio = self::thumb_width /self::thumb_height;
        if($this->width <= self::thumb_width && $this->height <= self::thumb_height) 
        {
            $this->thumb_resize_width = $this->width;
            $this->thumb_resize_height = $this->height;
        } 
        elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) 
        {
            $this->thumb_resize_width = (int) (self::thumb_height * $source_aspect_ratio);
            $this->thumb_resize_height = self::thumb_height;
        }
        else 
        {
            $this->thumb_resize_width = self::thumb_width;
            $this->thumb_resize_height = (int) (self::thumb_width/ $source_aspect_ratio);
        }
        $thumbimage= imagecreatetruecolor($this->thumb_resize_width, $this->thumb_resize_height);
        imagecopyresampled($thumbimage, $sourceimage, 0, 0, 0, 0, $this->thumb_resize_width, $this->thumb_resize_height, $this->width, $this->height);
        switch($imgtyp){
			//case 'bmp': imagewbmp($newimage, $this->destinationfile); break;
			//case 'gif': imagegif($newimage, $this->destinationfile); break;
			//case 'jpg': imagejpeg($newimage, $this->destinationfile, 55); break;	// default 75
			//case 'png': imagepng($newimage, $this->destinationfile, 8); break;  	// default 6
			
			case 'bmp': imagewbmp($thumbimage, $thumb); break;
			case 'gif': imagegif($thumbimage, $thumb); break;
            case 'jpg': imagejpeg($thumbimage, $thumb, 100); break;
			case 'png': imagepng($thumbimage, $thumb); break;
		}
        imagedestroy($thumbimage);
        imagedestroy($sourceimage);
        return true;
        
    }
//       
//	public function afterConstruct()
//	{
//		$this->path = "";
//		$this->originalpath = "";
//		$this->errormessage = "";
//		$this->remotefiles = array();
//		$this->forcesize = false;
//		$this->folder_width = 0;
//		$this->folder_height = 0;
//		$this->remoteprefix = "";
//	}
//	private function getInnerFolder()
//	{
//		$width = $this->folder_width;
//		$height = $this->folder_height;
//		
//		if($width && $height)
//		{
//			$innerfolder = $width . "x" . $height;
//		}
//		else if($width)
//		{
//			$innerfolder = "w" . $width;
//		}
//		else if($height)
//		{
//			$innerfolder = "h" . $height;
//		}
//		else
//		{
//			$innerfolder = "";
//		}
//		return $innerfolder;
//	}
//	
//	public function createremoteimage()
//	{
//		if(empty($this->remotefiles)) { return; }
//		
//		$server = Yii::app()->params['domainname_frontend_address'];
//		$username = Yii::app()->params['domainname_frontend_username'];
//		$password = Yii::app()->params['domainname_frontend_password'];
//		
//		$connection = ssh2_connect($server, 22);
//		
//		ssh2_auth_password($connection, $username, $password);
//		$sftp = ssh2_sftp($connection);
//		
//		if($sftp)
//		{
//			foreach($this->remotefiles as $oneinnerfile)
//			{
//				$source = $oneinnerfile->source;
//				if(!file_exists($source))
//				{
//					Yii::log("Source image is missing " . $source);
//					continue;
//				}
//				$destination = $oneinnerfile->destination;
//				$destinationfolder = $oneinnerfile->destinationfolder;
//				// abort mission if file already exists at remote server
//				if(!file_exists('ssh2.sftp://' . $sftp . $destination))
//				{
//					// check if the remote folder already exist
//					if(!file_exists('ssh2.sftp://' . $sftp . $destinationfolder))
//					{
//						// create the folder if missing
//						if(!ssh2_sftp_mkdir($sftp, $destinationfolder, 0777, true))
//						{
//							Yii::log("Unable to create remote folder " . $destinationfolder);	
//						}
//					}
//					// start copying the file
//					if(!ssh2_scp_send($connection, $source, $destination, 0777))
//					{
//						Yii::log("Unable to create remote image " . $destination);
//					}	
//				}
//			}	
//		}
//		else
//		{
//			Yii::log("Unable to connect to the remote image server");
//		}
//	}
//	
//	public function prepareremoteimage($size=null)
//	{
//		$this->coordinates = new stdClass;
//		$this->coordinates->src_x = 0;
//		$this->coordinates->src_y = 0;
//		$this->coordinates->dst_x = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->coordinates->dst_y = isset($size["h"]) ? intval($size["h"]) : 0;
//		$this->coordinates->dst_w = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->coordinates->dst_h = isset($size["h"]) ? intval($size["h"]) : 0;
//		
//		$this->folder_width = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->folder_height = isset($size["h"]) ? intval($size["h"]) : 0;
//		
//		$this->forcesize = true;
//		$this->crop = false;
//		
//		if($this->createimage())
//		{
//			$thumbnailfolder = $this->getInnerFolder();
//			$destinationfolder = "/var/www/content" . $this->remotefolder;
//			if($thumbnailfolder)
//			{
//				$destinationfolder = $destinationfolder . "/" . $thumbnailfolder;
//			}
//			$destination = $destinationfolder . "/" . $this->filename;
//			if($this->remoteprefix)
//			{
//				$destination = $destinationfolder . "/" . $this->remoteprefix ."-". $this->filename;
//			}
//			$data = new stdClass;
//			$data->source = $this->destinationfile;
//			$data->destination = $destination;
//			$data->destinationfolder = $destinationfolder;
//			
//			$this->remotefiles[] = $data;
//		}
//	}
//	
//	/***
//	 * Resizing image and keeping the original ratio
//	 * This creates thumbnail of the original cropped imaged
//	 */
//	public function resize($size)
//	{
//		$this->coordinates = new stdClass;
//		$this->coordinates->src_x = 0;
//		$this->coordinates->src_y = 0;
//		$this->coordinates->dst_x = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->coordinates->dst_y = isset($size["h"]) ? intval($size["h"]) : 0;
//		$this->coordinates->dst_w = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->coordinates->dst_h = isset($size["h"]) ? intval($size["h"]) : 0;
//		
//		$this->folder_width = isset($size["w"]) ? intval($size["w"]) : 0;
//		$this->folder_height = isset($size["h"]) ? intval($size["h"]) : 0;
//		
//		$this->crop = false;
//		
//		return $this->createimage();
//	}
//	
//	public function crop($dimension)
//	{
//		$this->coordinates = new stdClass;
//
//		$this->coordinates->src_x = $dimension->x;
//		$this->coordinates->src_y = $dimension->y;
//		$this->coordinates->dst_x = $dimension->x2;
//		$this->coordinates->dst_y = $dimension->y2;
//		$this->coordinates->dst_w = 0;
//		$this->coordinates->dst_h = 0;
//		
//		$this->crop = true;
//		
//		return $this->createimage();
//	}
//	
//	private function createimage()
//	{
//		$server_root = $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : "/var/www/golfscape";
//		
//		// verify image validity
//		$this->sourceimagefile = $server_root . $this->folder . "/" . $this->filename;
//		
//		if(!list($this->coordinates->src_w, $this->coordinates->src_h) = getimagesize($this->sourceimagefile))
//		{
//			$this->errormessage = "Unsupported image type";
//			return false;
//		}
//		
//		// prepare destination file and folder
//		$thumbnailfolder = $this->getInnerFolder();
//		$destinationfolder = $server_root . $this->folder;
//		if($thumbnailfolder)
//		{
//			// include thumbnail folder if available
//			$destinationfolder = $server_root . $this->folder . "/" . $thumbnailfolder;
//		}
//		if(!is_dir($destinationfolder))
//		{
//			Yii::log("Creating destination folder " . $destinationfolder);
//			if(mkdir($destinationfolder, 0777, true)===false)
//			{
//				Yii::log("Unable to create destination image folder " . $destinationfolder);
//				$this->errormessage = "Unable to create destination image folder";
//				return false;
//			}
//		}
//		// construct the destination filename
//		$this->destinationfile = $destinationfolder . "/" . $this->filename;
//		//Yii::log("Creating " . $this->destinationfile);
//		
//		$type = pathinfo($this->sourceimagefile, PATHINFO_EXTENSION);
//		if($type == 'jpeg') $type = 'jpg';
//		switch($type){
//			case 'bmp': $sourceimage = imagecreatefromwbmp($this->sourceimagefile); break;
//			case 'gif': $sourceimage = imagecreatefromgif($this->sourceimagefile); break;
//			case 'jpg': $sourceimage = imagecreatefromjpeg($this->sourceimagefile); break;
//			case 'png': $sourceimage = imagecreatefrompng($this->sourceimagefile); break;
//			default : return "Unsupported Image type!";
//		}
//
//		if(($this->coordinates->src_w < $this->coordinates->dst_w) and ($this->coordinates->src_h < $this->coordinates->dst_h))
//		{
//			$this->errormessage = "Image is too small to be resized!";
//			return false;
//		}
//		
//		// set variables
//		$this->path = str_replace($server_root, "", $this->destinationfile);
//		$this->originalpath = str_replace($server_root, "", $this->sourceimagefile);
//		
//		if($this->crop)
//		{
//			$this->coordinates->dst_w = $this->coordinates->dst_x - $this->coordinates->src_x;
//			$this->coordinates->dst_h = $this->coordinates->dst_y - $this->coordinates->src_y;
//			$this->coordinates->src_w = $this->coordinates->dst_x - $this->coordinates->src_x;
//			$this->coordinates->src_h = $this->coordinates->dst_y - $this->coordinates->src_y;
//		}
//		else
//		{
//			if($this->coordinates->dst_w==0)
//			{
//				$ratio = $this->coordinates->dst_h/$this->coordinates->src_h;
//			}
//			else if($this->coordinates->dst_h==0)
//			{
//				$ratio = $this->coordinates->dst_w/$this->coordinates->src_w;
//			}
//			else
//			{
//				$ratio = min($this->coordinates->dst_w/$this->coordinates->src_w, $this->coordinates->dst_h/$this->coordinates->src_h);
//			}
//			
//			if(($this->forcesize) && ($this->coordinates->dst_w) && ($this->coordinates->dst_h))
//			{
//				//$this->coordinates->dst_w = $this->coordinates->src_w * $ratio;
//				//$this->coordinates->dst_h = $this->coordinates->src_h * $ratio;	
//			}
//			else
//			{
//				$this->coordinates->dst_w = intval($this->coordinates->src_w * $ratio);
//				$this->coordinates->dst_h = intval($this->coordinates->src_h * $ratio);	
//			}
//		}
//		
//		// create a new true color image
//		$newimage = imagecreatetruecolor($this->coordinates->dst_w, $this->coordinates->dst_h);
//	  
//		// preserve transparency
//		if($type == "gif" or $type == "png"){
//		  imagecolortransparent($newimage, imagecolorallocatealpha($newimage, 0, 0, 0, 127));
//		  imagealphablending($newimage, false);
//		  imagesavealpha($newimage, true);
//		}
//	  
//		// resize or crop image
//		imagecopyresampled($newimage, $sourceimage, 0, 0, $this->coordinates->src_x, $this->coordinates->src_y, $this->coordinates->dst_w, $this->coordinates->dst_h, $this->coordinates->src_w, $this->coordinates->src_h);
//	  
//		switch($type){
//			//case 'bmp': imagewbmp($newimage, $this->destinationfile); break;
//			//case 'gif': imagegif($newimage, $this->destinationfile); break;
//			//case 'jpg': imagejpeg($newimage, $this->destinationfile, 55); break;	// default 75
//			//case 'png': imagepng($newimage, $this->destinationfile, 8); break;  	// default 6
//			
//			case 'bmp': imagewbmp($newimage, $this->destinationfile); break;
//			case 'gif': imagegif($newimage, $this->destinationfile); break;
//			case 'jpg': imagejpeg($newimage, $this->destinationfile); break;
//			case 'png': imagepng($newimage, $this->destinationfile); break;
//		}
//		
//		return true;
//	}
//	
//	public function path($size=null)
//	{
//		$destinationfolder = $this->folder;
//		
//		if(isset($size))
//		{
//			$this->coordinates = new stdClass;
//			
//			$this->folder_width = isset($size["w"]) ? intval($size["w"]) : 0;
//			$this->folder_height = isset($size["h"]) ? intval($size["h"]) : 0;
//		
//			// prepare destination file and folder
//			$thumbnailfolder = $this->getInnerFolder();
//			if($thumbnailfolder)
//			{
//				$destinationfolder = $destinationfolder . "/" . $thumbnailfolder;
//			}	
//		}
//		
//		return $destinationfolder . "/" . $this->filename;
//		
//	}
//	public function remoteurl($size)
//	{
//		if(isset($_SERVER['HTTPS'])  && $_SERVER['HTTPS'] != 'off' ) 
//		{
//			$imageurl = "https://" . Yii::app()->params['domainname_images'] . $this->folder;
//		}
//		else
//		{
//			$imageurl = "http://" . Yii::app()->params['domainname_images'] . $this->folder;
//		}
//		
//		if(isset($size))
//		{
//			$this->coordinates = new stdClass;
//			
//			$this->folder_width = isset($size["w"]) ? intval($size["w"]) : 0;
//			$this->folder_height = isset($size["h"]) ? intval($size["h"]) : 0;
//			
//			$thumbnailfolder = $this->getInnerFolder();
//			if($thumbnailfolder)
//			{
//				$imageurl = $imageurl . "/" . $thumbnailfolder;
//			}	
//		}
//		
//		$imageurl = $imageurl . "/" . $this->filename;
//		
//		return $imageurl;
//	}
//	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
