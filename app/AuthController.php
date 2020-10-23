<?php
require_once("SessionHandler.php");
require 'AWS/aws-autoloader.php';

use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;


$data = (file_get_contents('php://input'));

if(isJson($data)){
	#		header('Content-Type: application/json');

	$getInput = json_decode($data);

	if(isset($getInput->mobile_number_body) && isset($getInput->mobile_number_code) && isset($getInput->mobile_hash)){
	###################
$sendOTP = true;

		$m_body = $getInput->mobile_number_body;
		$m_code = $getInput->mobile_number_code;
		$m_hash = $getInput->mobile_hash;
		$getHash = getDeviceHash($m_hash);
		
		if(!is_array($getHash)){
			throwJsonError("Device Session Not Found");
		}
				
		if(!is_numeric($m_body)){

			throwJsonError("Mobile Number Not Numeric");

		}
		
		if(!is_numeric($m_code)){

			throwJsonError("Mobile Code Not Numeric");
		}
		
	##check user or make one	
		$getUser = mysqlSelect("SELECT * FROM `client_logins` where lum_mob_code = '".$m_code."' and lum_mob_body = '".$m_body."'");
		if(!is_array($getUser)){
			$makeNewUser = mysqlInsertData("INSERT INTO `client_logins` (`lum_ug_id`,`lum_mob_code`, `lum_mob_body`) VALUES (
			4,
			'".$m_code."',
			'".$m_body."'
			)",true);
			
			if(!is_numeric($makeNewUser)){
				throwJsonError("User Not Generated");
			}
			$u_exis = 0;
			$userID = $makeNewUser;
		}else{
			$userID = $getUser[0]['lum_id'];
			
			$u_exis = (is_null($getUser[0]['lum_fname']) || is_null($getUser[0]['lum_lname']) ? 0	: 1);			
		}
		

#check how many OTPS have been sent
		$checkAllSentOTPs = mysqlSelect("SELECT (count(*)>2) as otpSent FROM `auth_otp_store` where otp_dev_id = 1 and otp_dnt > (".time()."  - 120)");
		if(is_array($checkAllSentOTPs)){
			if($checkAllSentOTPs[0]['otpSent'] == 1){
				throwJsonError("OTP Limit Exceeded");
			}
		}else{
				throwJsonError("Internal Server Error");
			}


#send OTP
$otpCode = rand(1,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

			$makeOTP = mysqlInsertData("INSERT INTO `auth_otp_store`( `otp_dev_id`, `otp_lum_id`, `otp_code_6`, `otp_used`, `otp_valid_till`, `otp_dnt`) VALUES (
			'".$getHash[0]['dev_id']."',
			'".$userID."',
			'".$otpCode."',
			'0',
			'".(time()+120)."',
			'".time()."'
			
			)",true);
			if(!is_numeric($makeOTP)){
				throwJsonError("OTP Not Generated");
			}

#otp sms

$SnSclient = new SnsClient([
    'profile' => 'default',
    'region' => 'us-east-1',
    'version' => '2010-03-31',
	'scheme' => 'http'
]);

$message_sns = 'Your Virtual Queue (Qista) verification code is: '.$otpCode;
$phone_sns = '+'.$m_code.$m_body;

    $result = $SnSclient->publish([
        'Message' => $message_sns,
        'PhoneNumber' => $phone_sns,
		'DefaultSenderID' => "QISTA"
    ]);
	
$status_sms = 1;
				
							$json_var = [
							  'status' => $u_exis,
							  'text' => $otpCode,
							  'sms_sent' => $status_sms
							];
				
							// Output, response
							echo json_encode(($json_var));
							die();

	###################
	}
	
	if(isset($getInput->mobile_hash_device) && isset($getInput->mobile_otp_check)){
		$mob_hash = $getInput->mobile_hash_device;
		$m_code = $getInput->mobile_otp_check;

		if(!is_numeric($m_code)){
				throwJsonError("Invalid OTP");
		}

		if(!ctype_alnum($mob_hash)){
				throwJsonError("Invalid Mobile Hash");
		}
		
		$getHash = getDeviceHash($mob_hash);
		
		if(!is_array($getHash)){
			throwJsonError("Device Session Not Found");
		}
		
		$checkOTP = mysqlSelect("SELECT * FROM `auth_otp_store` where 
		otp_code_6 = '".$m_code."' and otp_dev_id = '".$getHash[0]['dev_id']."' and otp_valid_till >= ".(time())." and otp_used = 0 
		order by otp_dnt desc 
		limit 1");
		if(!is_array($checkOTP)){
							$json_var = [
							  'user_ver' => 0
							];
				
							// Output, response
							echo json_encode(($json_var));
							die();		
		}
		#MAJOR BUG, THE SAME ID IF LOGGED IN ELSEWHERE THEN THEY ALSO GET THE NEW SESION
		$updateOTP = mysqlUpdateData("UPDATE `auth_otp_store` SET `otp_used`= 1 WHERE otp_id = ".$checkOTP[0]['otp_id'], true);
		if(!is_numeric($updateOTP)){
				throwJsonError("Error While Updating Data.");
		}
		$AttachSession = mysqlUpdateData("UPDATE `auth_device_session_store` SET `dev_lum_id`= ".$checkOTP[0]['otp_lum_id']." WHERE dev_id = ".$checkOTP[0]['otp_dev_id'], true);
		if(!is_numeric($AttachSession)){
				throwJsonError("Error While Attaching Session to Device .");
		}
							$json_var = [
							  'user_ver' => 1
							];
				
							// Output, response
							echo json_encode(($json_var));
							die();		
		
		
	}
	
}








?>