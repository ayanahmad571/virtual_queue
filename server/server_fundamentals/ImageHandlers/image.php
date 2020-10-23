<?php
if(!isset($_GET['id'])){
	die("");
}
if(!is_numeric($_GET['id'])){
	die("");
}
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
	$resp = mysqlSelect("SELECT * FROM `admin_sm_logins` l
	left join admin_sm_user_groups g on l.lum_type = g.type_id
	where 
	g.type_id is not null and l.lum_valid =1 and l.lum_id = ".$_SESSION[SESSION_CONTROLLER_NAME]);
	if(!is_array($resp)){
		die("(Account Not Found <a href='logout.php'><button>Re-login</button></a>)");
	}
	$USER_ARRAY = $resp[0];
}else{


	header("Location: logout");
	die();
}

$img = new ImageUpload;
$img->showImage($_GET['id']);
?>
