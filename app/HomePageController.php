<?php
header('Content-Type: application/json');
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

	if(isset($getInput->home_page_lat) && isset($getInput->home_page_long) && isset($getInput->home_page_industry) && isset($getInput->home_page_pagination)){
							$h_lat = $getInput->home_page_lat;
							$h_long = $getInput->home_page_long;
							$h_industry = $getInput->home_page_industry;
							$h_page = $getInput->home_page_pagination;
							
							if(!is_numeric($h_lat)){
								throwJsonError("latitude must be numeric");
								die();			
							}

							if(!is_numeric($h_long)){
								throwJsonError("longitude must be numeric");
								die();			
							}
							
							
							if(!is_numeric($h_page)){
								throwJsonError("pagination must be numeric");
								die();			
							}
							
							
							
							$getBranches = mysqlSelect("
							(SELECT 
branch_id as display_id,
bt_name as display_industry,
branch_name as display_name,
(SELECT count(*) from virtual_services s where s.service_branch_id = a.branch_id and service_status = 1) as display_services,
branch_banner as display_background,
branch_logo as display_logo,


round(
69.0 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.branch_lat))
         * COS(RADIANS(".$h_lat."))
         * COS(RADIANS(a.branch_long - ".$h_long."))
         + SIN(RADIANS(a.branch_lat))
         * SIN(RADIANS(".$h_lat."))))) 
    ,2) AS display_distance
         

FROM `virtual_branch` a
left join admin_branch_type on branch_type_id =  bt_id
where
branch_status= 1
order by display_distance asc
limit 25 offset ".(($h_page-1) * 25).")
							");

							if(is_array($getBranches)){

								echo json_encode(($getBranches));
								die();		
		
							}
				
		
	}
	
}








?>