<?php
require_once("Settings.php");
require_once("CookieController.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

sec_session_start();
session_destroy();

$checkerNames = array("email");
# 0 = email
# 1 = password
checkPost($checkerNames);
checkEmail($_POST[$checkerNames[0]]);

$userCheck = mysqlSelect("select * from sm_logins where lum_email = '".$_POST[$checkerNames[0]]."' and lum_valid =1");
if(!is_array($userCheck)){
	die();
}


$updateData = mysqlUpdateData("update sm_forgot_passwords set fp_used =1 where fp_lum_id =  ".$userCheck[0]['lum_id'],true);
if(!is_numeric($updateData)){
	die('Error U');
}


$hash = uniqid().md5(uniqid().time()."wiojnmfiwoei2ojg92io4jgoiewmjvskl");
$url = SESSION_BASE_URL."reset?id=".$hash;
#$email_body = getForgotPasswordTemplate($userCheck, UNI_NAME_SU_SHORT);

$insertDataEmail = mysqlInsertData("
INSERT INTO `m_email`(`e_to_name`, `e_to_email`, `e_subject`, `e_body_t_id`, `e_body_json`, `e_alt_body`, `e_dnt_posted`) VALUES (
'".$userCheck[0]["lum_fname"]." ".$userCheck[0]["lum_lname"]."',
'".$userCheck[0]["lum_email"]."',
'Password Reset Link from Virtual Fair by Frestive for ".UNI_NAME_SHORT."',
1,
'".$userCheck[0]['lum_email']."',
'".$url."',
'".time()."');", true);
$emailID = 0;

if(is_numeric($insertDataEmail)){
	$emailID = $insertDataEmail;
}else{
	die("Email not sent");
}

$insertDataForgot = mysqlInsertData("
INSERT INTO `sm_forgot_passwords`(`fp_lum_id`, `fp_hash`, `fp_dnt`, `fp_e_id`) VALUES 
 
	(
	'".$userCheck[0]['lum_id']."',
	'".$hash."',
	'".time()."',
	 '".$emailID."'
	 )");
	 
if(trim($insertDataForgot) != "#"){
	if(!is_numeric($insertDataForgot)){
		die($insertDataForgot);
	}
}



?>