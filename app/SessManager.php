<?php
require_once("SessionHandler.php");

$data = (file_get_contents('php://input'));

if(isJson($data)){
		$getInput = json_decode($data);

	if(isset($getInput->getNewDeviceHash)){
		$hash = md5(microtime().uniqid()).sha1("0u9892heir02i9w9ef89hubi".time()).uniqid().time().md5(microtime()."-*2/-*2/-2*4/g*2/vf*-58efw*2-").rand(0,9999999);
		
		$mysqlInsert = mysqlInsertData("INSERT INTO `auth_device_session_store`( `dev_hash`, `dev_created`, `dev_updated`) VALUES (
		'".$hash."',
		'".time()."',
		'".time()."'
		)",true);
		if(!is_numeric($mysqlInsert)){
			throwJsonError("Device Session not Generated");
		}
		
		
				$json_var = [
								'dev_hash' => $hash
							];
				
				// Output, response
				echo json_encode(($json_var));
				die();



	}

	if(isset($getInput->checkDeviceHash)){
		
		$getHash = mysqlSelect("SELECT * FROM `auth_device_session_store` where dev_hash = '".$getInput->checkDeviceHash."' order by dev_id desc limit 1");
		if(!is_array($getHash)){
			$json_var = [
								'status' => 2
							];
				
				// Output, response
				die(json_encode(($json_var)));
		}
		
		
				$json_var = [
								'status' => (is_numeric($getHash[0]['dev_lum_id'])  ? 1:0)
							];
				
				// Output, response
				die(json_encode(($json_var)));



	}


}
?>