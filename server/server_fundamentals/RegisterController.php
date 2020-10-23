<?php
require_once("Settings.php");
require_once("CookieController.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

sec_session_start();
session_destroy();

$checkerNames = array("first_name","last_name","email","password","password2","brand_name","branch_name","brand_desc", "brand_industry","agree");
//                        0           1          2         3         4              5           6              7               8           9
# 0 = email
# 1 = password
checkPost($checkerNames);
checkEmail($_POST[$checkerNames[2]]);


$err= "";
if($_POST[$checkerNames[3]] != $_POST[$checkerNames[4]]){
	$err .= "<br>Passwords Do not Match";
}


if($_POST[$checkerNames[9]] != 1){
	$err .= "<br>Please Accept Terms and Conditions";
}

if(!is_numeric($_POST[$checkerNames[8]])){
	$err .="<br> Please select a valid industry";
}else{
	if(!is_array(mysqlSelect("select * from admin_branch_type where bt_id = '".$_POST[$checkerNames[8]]."'"))){
		//active or temp inactive 
		$err .= ('<br>Invalid Industry Selected.');
	}
}


if(is_array(mysqlSelect("select * from admin_sm_logins where lum_email = '".$_POST[$checkerNames[2]]."' and ((lum_valid = 1) or (lum_valid = 0))"))){
	//active or temp inactive 
	$err .= ('<br>An Account with the same email already exists.');
}
if(!empty($err)){
	die($err);
}


$userHash = genHash($_POST[$checkerNames[2]],$_POST[$checkerNames[3]]);

	// Separate string by @ characters (there should be only one)
    $parts = explode('@', $_POST[$checkerNames[2]]);

    // Remove and return the last part, which should be the domain
    $domain = array_pop($parts);

	//EMAIL VERIFICATION LINK

	$toSendHash = uniqid().md5(sha1("2ijoqfwee09u8h2bifwdeijvoiug2nqea-****/..,").time().microtime()).rand(1,5000);

$inssql = "
insert into `admin_sm_email_ver` ( `ver_hash`, `ver_dnt`,
 `ver_lum_fname`, `ver_lum_lname`, `ver_lum_email`, `ver_lum_hash`, `ver_lum_type`, `ver_lum_dnt`,`ver_lum_valid`,
  `ver_brand_name`, `ver_branch_name`, `ver_brand_desc`, `ver_brand_industry`)
 VALUES 
	(
	'".$toSendHash."',
	'".time()."',
	'".$_POST[$checkerNames[0]]."',
	'".$_POST[$checkerNames[1]]."',
	'".$_POST[$checkerNames[2]]."',
	'".$userHash."', 
	'2',
	'".time()."',
	1,
	'".$_POST[$checkerNames[5]]."',
	'".$_POST[$checkerNames[6]]."',
	'".$_POST[$checkerNames[7]]."',
	'".$_POST[$checkerNames[8]]."'


	 )";
$insertData = mysqlInsertData($inssql,true);
if(!is_numeric($insertData)){
	die($insertData);
}

	

	//EMAIL VERIFICATION LINK
	
	//email
$url = SESSION_BASE_URL."verify?id=".$toSendHash;

if(emailSend($_POST[$checkerNames[2]], $_POST[$checkerNames[2]], "Email Verification for Qista", "Verify ur email for ".$_POST[$checkerNames[5]]." at <a href='".$url."'>Click Here...</a>",$url)){
	die("ok");
}else{
	die("Email Not Sent");
}
	
	//email




?>