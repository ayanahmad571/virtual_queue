<?php
require_once("SessionHandler.php");
require_once("Settings.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");




if(isset($_POST['sub_list'])){
	if(!ctype_alnum($_POST['sub_list'])){
		die("Invalid Booth");
	}

	$socMaster = mysqlSelect("SELECT * FROM `virtual_booths` where
	vb_valid =1 and vb_paid =1
	and md5(concat('AsAAAAJWFOIJFIOJWF',vb_id)) = '".$_POST['sub_list']."'");
	
	if(!is_array($socMaster)){
		die("No Virtual Booth Found");
	}

$insertData = mysqlInsertData("INSERT INTO `virtual_booth_signups`(`vbsup_lum_id`, `vbsup_vb_id`, `vbsup_dnt`) VALUES (
'".$USER_ARRAY['lum_id']."',
'".$socMaster[0]['vb_id']."',
'".time()."'
)",true);	

if(is_numeric($insertData)){
	die("1");
}else{
	die($insertData);
}
	
}
#
if(isset($_POST['mail_list'])){
	if(!ctype_alnum($_POST['mail_list'])){
		die("Invalid Booth");
	}

	$socMaster = mysqlSelect("SELECT * FROM `virtual_booths` where
	vb_valid =1 and vb_paid =1
	and md5(concat('sAAAAAJWFOIJFIOJWF',vb_id)) = '".$_POST['mail_list']."'");
	
	if(!is_array($socMaster)){
		die("No Virtual Booth Found");
	}

$insertData = mysqlInsertData("INSERT INTO `virtual_booth_mailing`(`bml_lum_id`, `bml_vb_id`, `bml_dnt`) VALUES (
'".$USER_ARRAY['lum_id']."',
'".$socMaster[0]['vb_id']."',
'".time()."'
)",true);	

if(is_numeric($insertData)){
	die("1");
}else{
	die($insertData);
}
	
}
#
if(isset($_POST['un_sub_list'])){
	if(!ctype_alnum($_POST['un_sub_list'])){
		die("Invalid Token");
	}

	$socMaster = mysqlSelect("SELECT * FROM `virtual_booth_signups`  where
	vbsup_status = 1 
	and md5(concat('oisjefkmswioergnkml',vbsup_id)) = '".$_POST['un_sub_list']."'");
	
	if(!is_array($socMaster)){
		die("No Membership Found");
	}

$insertData = mysqlInsertData("update  `virtual_booth_signups` set 	vbsup_status = 0 where vbsup_id = ".$socMaster[0]['vbsup_id'],true);	

if(is_numeric($insertData)){
	die("1");
}else{
	die($insertData);
}
	
}
#
if(isset($_POST['un_mail_list'])){
	if(!ctype_alnum($_POST['un_mail_list'])){
		die("Invalid Token");
	}

	$socMaster = mysqlSelect("SELECT * FROM `virtual_booth_mailing`  where
	bml_status = 1 
	and md5(concat('iuehuei5tjg8iuiuj',bml_id)) = '".$_POST['un_mail_list']."'");
	
	if(!is_array($socMaster)){
		die("No Membership Found");
	}

$insertData = mysqlInsertData("update  `virtual_booth_mailing` set 	bml_status = 0 where bml_id = ".$socMaster[0]['bml_id'],true);	

if(is_numeric($insertData)){
	die("1");
}else{
	die($insertData);
}
	
}
#
if(isset($_POST['change_password_user'])){

	$checkerNames = array("change_password_user");

checkPost($checkerNames);

if($_POST[$checkerNames[0]] == ""){
	die("Password Must not be blank");
}


$h = genHash($USER_ARRAY['lum_email'],$_POST[$checkerNames[0]]);
$updateSql = "update sm_logins set lum_hash = '".$h."' 
where lum_id = ".$USER_ARRAY['lum_id'];
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update User data. 503 Server Error');
}

	die("");
}
?>

