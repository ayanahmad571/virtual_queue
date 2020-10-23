<?php
require_once("Settings.php");
function checkPost($htmlname){
	if(is_array($htmlname)){
		foreach($htmlname as $name){
			if(!isset($_POST[$name])){
				die("Invalid ".$name);
			}
			
		}
	}else{
		if(!isset($_POST[$htmlname])){
			die("Invalid ".$htmlname);
		}
	}
}

function checkEmail($email){
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  die("Invalid email format");
	}
}

function genHash($email, $pass){
	return md5(md5(sha1($email."<><>:;-H0Q834{7TH}{MC[44283TH7M-".$pass)));
}

function uploadImage($fnm){
	$fileInternalName = $fnm;
	$target_dir = "img/user_uploads/";
	$path_t  =pathinfo($_FILES[$fnm]["name"]);
	$target_file = $target_dir.md5(time()).rand(1,111).".".$path_t["extension"];
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$errorRows = "<br>Image error";

// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES[$fnm]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $errorRows .=  "<br>File is not an image.";
    $uploadOk = 0;
  }

// Check if file already exists
if (file_exists($target_file)) {
  $errorRows .= "<br>Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES[$fnm]["size"] > 500000) {
  $errorRows .=  "<br>Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $errorRows .=  "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $errorRows .=  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES[$fnm]["tmp_name"], $target_file)) {
    return array(1,$target_file);
  } else {
    $errorRows .=  "<br>Sorry, there was an error uploading your file.";
	return array(0,$errorRows );
  }
}

}

function loginMakeSession($uid){
	sec_session_start();
	session_destroy();
	sec_session_start();
	$_SESSION[SESSION_CONTROLLER_NAME] = $uid;
	
}

function inRange($number, $min, $max, $inclusive = FALSE)
{
    if (is_numeric($number) && is_numeric($min) && is_numeric($max))
    {
        return $inclusive
            ? ($number >= $min && $number <= $max)
            : ($number > $min && $number < $max) ;
    }

    return false;
}


function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

function throwJsonError($string){
				$json_var = [
								'err_code' => "401",
								'err_msg' => $string,
							];
				
				// Output, response
				die( json_encode(($json_var)));
}

function getDeviceHash($hash){
			$getHash = mysqlSelect("SELECT * FROM `auth_device_session_store` where dev_hash = '".$hash."' order by dev_id desc limit 1");
			return $getHash;
}
?>