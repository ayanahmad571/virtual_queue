<?php
require_once("Settings.php");


if(isset($_POST['serv_id']) && isset($_POST['mob_code']) && isset($_POST['size']) && isset($_POST['mob_number']) && isset($_POST['u_fname']) && isset($_POST['u_lname']) ){
	
#	$getService = mysqlSelect()
	$getLUM  = mysqlSelect("select * from client_logins where lum_mob_code = '".$_POST['mob_code']."' and lum_mob_body = '".$_POST['mob_number']."'");	
	if(!is_array($getLUM)){
		$in = mysqlInsertData("
		INSERT INTO `client_logins`(`lum_fname`, `lum_lname`, `lum_mob_code`, `lum_mob_body`) VALUES (
		'".$_POST['u_fname']."',
		'".$_POST['u_lname']."',
		'".$_POST['mob_code']."',
		'".$_POST['mob_number']."'
		)
		",true);
		if(!is_numeric($in)){
			die("ERR");
		}
		$userLUM = $in;

	}else{
		$userLUM = $getLUM[0]['lum_id'];
	}

	$_SESSION['QISTA_SESSION_ID'] = $userLUM;
	$checkQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` where queue_lum_id = ".$userLUM." and queue_service_id = ".$_POST['serv_id']." and queue_state in (2,3,4)");
if(is_array($checkQueue)){
	die("Already in QUEUE");
}
	$in2 = mysqlInsertData("
	INSERT INTO `virtual_queue_container`( `queue_lum_id`, `queue_service_id`, `queue_size`, `queue_dnt`,`queue_state`) VALUES (
	".$userLUM.",
	".$_POST['serv_id'].",
	".$_POST['size'].",
	".time().",
	2
	)
	
	",true);
if(!is_numeric($in2)){
	die("ERR2");
}

header("Location: bookings");
}
?>