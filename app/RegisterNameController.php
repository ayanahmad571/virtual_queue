<?php
require_once("SessionHandler.php");

$data = (file_get_contents('php://input'));

if(isJson($data)){
	#		header('Content-Type: application/json');

	$getInput = json_decode($data);
	
#check device hash and if the user is logged in (has a numeric client attached to it)
	if(isset($getInput->mobile_hash)){
		$m_hash = $getInput->mobile_hash;
		$getHash = getDeviceHash($m_hash);
		if(!is_array($getHash)){
			throwJsonError("Device Session Not Found");
		}
		
		##check user and make global array
		if(is_numeric($getHash[0]['dev_lum_id'])){
					$getUser = mysqlSelect("SELECT * FROM `client_logins` where lum_id = ".$getHash[0]['dev_lum_id']." ");
					if(!is_array($getUser)){
						throwJsonError("user session cant be found");			
					}
		}else{
						throwJsonError("user must be logged in ");			
		}
	
		


	###################
	}else{
					throwJsonError("device hash must be sent");
					die();			
	}
	

/*
$getHash = getDeviceHash($m_hash); this give

$getUser = mysqlSelect("SELECT * FROM `client_logins` where lum_id = ".$getHash[0]['dev_lum_id']." ");


*/

	if(isset($getInput->user_fname) && isset($getInput->user_lname)){
							$r_fname = $getInput->user_fname;
							$r_lname= $getInput->user_lname;

			$updateUser = mysqlInsertData("UPDATE `client_logins` SET 
			`lum_fname`='".$r_fname."',
			`lum_lname`='".$r_lname."'
			 WHERE `lum_id`= ".$getHash[0]['dev_lum_id'],true);
			if(!is_numeric($updateUser)){
				throwJsonError("Name Not updated, Internal Server Error");
			}



							$json_var = [
							  'status' => "ok"
							];
				
							// Output, response
							echo json_encode(($json_var));
							die();		
		
		
	}



	if(isset($getInput->logout)){
		$updateSql = mysqlUpdateData("update auth_device_session_store set dev_lum_id = null, dev_updated = '".time()."' where dev_id = ".$getHash[0]['dev_id'],true);
		if(!is_numeric($updateSql)){
		$json_var = [
		'logout' => 0
		];
		
		// Output, response
		die(json_encode(($json_var)));
		
		}
		
		$json_var = [
		'logout' => 1
		];
		
		// Output, response
		die(json_encode(($json_var)));
	}
	
}








?>