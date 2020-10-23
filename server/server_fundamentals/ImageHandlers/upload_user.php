<?php
set_time_limit(20);
require_once "../DatabaseConnection.php";
require_once "imgupload.class.php";
require_once("../Settings.php");
require_once("../CookieController.php");
require_once("../FunctionsController.php");

sec_session_start();
/* 
	1. check if logged in 
	2. check if page is admin page
	3. check if admin has started the session.
	4. get wallet amount 
*/
#Check is the user has logged in or no.
if(isset($_SESSION[SESSION_CONTROLLER_NAME]) && is_numeric($_SESSION[SESSION_CONTROLLER_NAME])){
	$resp = mysqlSelect("SELECT * FROM `sm_logins` l
	left join sm_user_groups g on l.lum_type = g.type_id
	where 
	g.type_id is not null and l.lum_valid =1 and l.lum_id = ".$_SESSION[SESSION_CONTROLLER_NAME]);
	if(!is_array($resp)){
		die("(Account Not Found <a href='logout.php'><button>Re-login</button></a>)");
	}
	$USER_ARRAY = $resp[0];
}else{
	header("Location: ../../logout");
	die();
}


if(count($_FILES['image']['name']) > 1){
	die("Maximum 1 File allowed");
}

$img = new ImageUpload;

$result = $img->uploadImages($_FILES['image']);


if(isset($result->ids[0])){
	
		$updateData = mysqlUpdateData("UPDATE `sm_logins` SET `lum_img_src` = 'server_fundamentals/ImageHandlers/image?id=".$result->ids[0]."' 
		WHERE `sm_logins`.`lum_id` = ".$USER_ARRAY['lum_id'],true);
		if(is_numeric($updateData)){
			echo json_encode(array("status"=>"1","datum"=>"server_fundamentals/ImageHandlers/image?id=".$result->ids[0]));
		}else{
			echo json_encode(array("status"=>"0","datum"=>($updateData)));
		}

}else{
	echo json_encode(array("status"=>"0","datum"=>$result->info[0]));
}

?>
