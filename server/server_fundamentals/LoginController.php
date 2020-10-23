<?php
require_once("Settings.php");
require_once("CookieController.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");
sec_session_start();
session_destroy();

$checkerNames = array("email","password");
# 0 = email
# 1 = password
checkPost($checkerNames);
checkEmail($_POST[$checkerNames[0]]);

$userHash = genHash($_POST[$checkerNames[0]],$_POST[$checkerNames[1]]);
$makeSess = mysqlSelect("select * from admin_sm_logins
left join `admin_sm_user_groups` on lum_type = type_id 
where lum_email = '".$_POST[$checkerNames[0]]."' and lum_hash =  '".$userHash."' and lum_valid = 1  and lum_email_ver =1
limit 1  ");
if(is_array($makeSess)){
	loginMakeSession($makeSess[0]["lum_id"]);
	die($makeSess[0]["type_landing"]);
}else{
	die("-");
}



?>	