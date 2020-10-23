<?php

require_once("SessionHandler.php");

$data = (file_get_contents('php://input'));

if(isJson($data)){
			header('Content-Type: application/json');

	$getInput = json_decode($data);

	if(isset($getInput->mobile_check_hash)){

		$m_hash = $getInput->mobile_check_hash;
		$getHash = getDeviceHash($m_hash);
		
	}else{
		throwJsonError("150");
		#150 = Hash Not Sent
	}

	if(!is_array($getHash)){
		throwJsonError("151");
		#151= Device Not Found 
	}else{
		if(!is_numeric($getHash[0]['dev_lum_id'])){
			throwJsonError("152");
			#152 = Device Not Assoc to User
		}
	}

####################################################################################
$updateSql = mysqlUpdataData("update auth_device_session_store set dev_lum_id = null, dev_updated = '".time()."' where dev_id = ".$getHash[0]['dev_id'],true);
if(!is_numeric($updateSql)){
				$json_var = [
								'status' => 0
							];
				
				// Output, response
				die(json_encode(($json_var)));

}

			$json_var = [
								'status' => 1
							];
				
				// Output, response
				die(json_encode(($json_var)));


}


?>