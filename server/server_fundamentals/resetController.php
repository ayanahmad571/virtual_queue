<?php
require_once("Settings.php");
require_once("CookieController.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

sec_session_start();
session_destroy();
$checkerNames = array("new_pass", "ux");
# 0 = email
# 1 = password
checkPost($checkerNames);

$userCheck = mysqlSelect("select * from sm_forgot_passwords p
left join sm_logins l on p.fp_lum_id = l.lum_id
where fp_hash = '".$_POST[$checkerNames[1]]."' and fp_used = 0 ");

if(!is_array($userCheck)){
	die("e1");
}

$hash = genHash($userCheck[0]['lum_email'],$_POST[$checkerNames[0]]);
$updateData = mysqlUpdateData("update sm_logins set lum_hash = '".$hash."'  where lum_id =  ".$userCheck[0]['lum_id'],true);
if(!is_numeric($updateData)){
	die('F1');
}

$updateData = mysqlUpdateData("update sm_forgot_passwords set fp_used =1  where fp_hash =  '".$_POST[$checkerNames[1]]."'",true);
if(!is_numeric($updateData)){
	die('F2');
}


die("ok");



?>