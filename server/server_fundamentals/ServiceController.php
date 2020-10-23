<?php
require_once("SessionHandler.php");
require_once("Settings.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

$getSoc = mysqlSelect("SELECT * FROM `virtual_branch` 
left join admin_branch_type on branch_type_id = bt_id
where branch_lum_id = ".$USER_ARRAY['lum_id']."
order by branch_id asc limit 1
");

if(!is_array($getSoc)) die("Virtual Booth not found");

$BranchMaster = $getSoc[0];
#service_hash
if(!isset($_POST['service_hash'])){
	die("Provide Service ID");
}

$ServiceMaster = mysqlSelect("SELECT * FROM `virtual_services` s
	left join `virtual_branch` b on s.service_branch_id = b.branch_id
	where s.service_status =1 and  b.branch_status =1
	
	and md5(concat('".$USER_ARRAY['lum_id']."2fr*-/r85f6a3',service_id)) = '".$_POST['service_hash']."'");

if(!is_array($ServiceMaster)){
	die("Invalid Service ID");
}

$ServiceMaster = $ServiceMaster[0];
#################Set UP##################

if(isset($_POST['offlinequeueadd_name']) && isset($_POST['offlinequeueadd_size']) && isset($_POST['offlinequeueadd_mob_code']) && isset($_POST['offlinequeueadd_mob_body'])){
	
	$checkerNames = array("offlinequeueadd_name","offlinequeueadd_size","offlinequeueadd_mob_code","offlinequeueadd_mob_body");
	checkPost($checkerNames);
	$err = "";
	if(!is_numeric($_POST[$checkerNames[1]])){
		$err .="<br>Invalid Size";
	}
	if(!is_numeric($_POST[$checkerNames[2]])){
		$err .="<br>Invalid Mobile Code";
	}
	if(!is_numeric($_POST[$checkerNames[3]])){
		$err .="<br>Invalid Mobile Number";
	}
	
	if(!empty($err)){
		die($err);
	}
	
	$insertData = array("NULL",$ServiceMaster['service_id'],wrapSingle($_POST[$checkerNames[0]]),
	wrapSingle($_POST[$checkerNames[2]]),wrapSingle($_POST[$checkerNames[3]]),
	wrapSingle($_POST[$checkerNames[1]]),wrapSingle(time()), "2");
	
	$insertQueue = mysqlInsertData("INSERT INTO `virtual_queue_container`(`queue_lum_id`, `queue_service_id`, `queue_user_name`, `queue_user_mob_code`, 
	`queue_user_mob_body`, `queue_size`,`queue_dnt`, `queue_state`) VALUES (
	 ".$insertData[0].",
	 ".$insertData[1].",
	 ".$insertData[2].",
	 ".$insertData[3].",
	 ".$insertData[4].",
	 ".$insertData[5].",
	 ".$insertData[6].",
	 ".$insertData[7]."	 
	
	)",true);
	if(!is_numeric($insertQueue)){
		die($insertQueue);
	}
	
}
#
if(isset($_POST['summon_user_queue_id'])){
	$getQueuePerson = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 2
								and md5(concat('summon*-*/-*/-*/-/*kwsnm',queue_id)) = '".$_POST['summon_user_queue_id']."'
								order by queue_id asc");
								
								if(!is_array($getQueuePerson)){
									die("No User Found");
								}
								
								$summonUpdate = mysqlUpdateData("UPDATE `virtual_queue_container` SET 
								`queue_state` = '3', queue_summon_dnt = '".time()."' WHERE `virtual_queue_container`.`queue_id` =".$getQueuePerson[0]["queue_id"],true);
								if(is_numeric($summonUpdate)){
									die("-");
								}else{
									die("SUPE1");
								}
								

}
#
if(isset($_POST['remove_user_queue_id'])){
	$getQueuePerson = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								where queue_service_id = ".$ServiceMaster['service_id']."
								and md5(concat('remo*-/-*anj',queue_id)) = '".$_POST['remove_user_queue_id']."'
								order by queue_id asc");

								if(!is_array($getQueuePerson)){
									die("No User Found");
								}
								
								$summonUpdate = mysqlUpdateData("UPDATE `virtual_queue_container` SET 
								`queue_state` = '7', queue_removed_dnt = '".time()."' WHERE `virtual_queue_container`.`queue_id` =".$getQueuePerson[0]["queue_id"],true);
								if(is_numeric($summonUpdate)){
									die("-");
								}else{
									die("SUPE1");
								}
								

}
#
if(isset($_POST['now_serve_user_queue_id'])){
	$getQueuePerson = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 3
								and md5(concat('nowserve*-*/-*/-*/-/*kwsnm',queue_id)) = '".$_POST['now_serve_user_queue_id']."'
								order by queue_id asc");
								
								if(!is_array($getQueuePerson)){
									die("No User Found");
								}
								
								$summonUpdate = mysqlUpdateData("UPDATE `virtual_queue_container` SET 
								`queue_state` = '4', queue_arrived_dnt = '".time()."' WHERE `virtual_queue_container`.`queue_id` =".$getQueuePerson[0]["queue_id"],true);
								if(is_numeric($summonUpdate)){
									die("-");
								}else{
									die("SUPE1");
								}
								

}
#
if(isset($_POST['order_complete_queue_id'])){
	$getQueuePerson = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 4
								and md5(concat('complete*-*/-*/-*/-/*kwsnm',queue_id)) = '".$_POST['order_complete_queue_id']."'
								order by queue_id asc");
								
								if(!is_array($getQueuePerson)){
									die("No User Found");
								}
								
								$summonUpdate = mysqlUpdateData("UPDATE `virtual_queue_container` SET 
								`queue_state` = '8', queue_completed_dnt = '".time()."' WHERE `virtual_queue_container`.`queue_id` =".$getQueuePerson[0]["queue_id"],true);
								if(is_numeric($summonUpdate)){
									die("-");
								}else{
									die("SUPE1");
								}
								

}
#
if(isset($_POST['no_show_user_queue_id'])){
	$getQueuePerson = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								where queue_service_id = ".$ServiceMaster['service_id']."
								and md5(concat('noSho*-/-*anj',queue_id)) = '".$_POST['no_show_user_queue_id']."'
								order by queue_id asc");

								if(!is_array($getQueuePerson)){
									die("No User Found");
								}
								
								$summonUpdate = mysqlUpdateData("UPDATE `virtual_queue_container` SET 
								`queue_state` = '5', queue_removed_dnt = '".time()."' WHERE `virtual_queue_container`.`queue_id` =".$getQueuePerson[0]["queue_id"],true);
								if(is_numeric($summonUpdate)){
									die("-");
								}else{
									die("SUPE1");
								}
								

}


/*

--removed -- 1.Waiting to be approved
2. Waiting in Line
3. Notified (Users have 10 mins to reach)
4. Now Serving (Those who have reached)
5. No Show (Those who were notified but didnt reach)
5. Removed

*/
#api
#cwaitlist
if(isset($_POST['service_order_id'])){
	if(!is_numeric($_POST['service_order_id'])){
		die();
	}
	
		$chatStore = array();
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 2
								and queue_id > ".$_POST['service_order_id']."
								order by queue_dnt asc");
			
			
			if(is_array($getQueue)){
				foreach($getQueue as $QueueObject){
				
					$formSend = '
					<div id="summonCont'.$QueueObject['queue_id'].'">
						<form id="summonPerson'.$QueueObject['queue_id'].'" action="server_fundamentals/ServiceController" method="post">
							<input type="hidden" name="summon_user_queue_id" value="'.md5("summon*-*/-*/-*/-/*kwsnm".$QueueObject['queue_id']).'" />
							<input type="hidden" name="service_hash" value="'.md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$ServiceMaster['service_id']).'" />
							<button type="submit" class="btn btn-success">Notify</button>
						</form>
						<script type=\'text/javascript\'>
							$(\'#summonPerson'.$QueueObject['queue_id'].'\').on(\'submit\',(function(e) {
								e.preventDefault();
								var formData = new FormData(this);
								
								$.ajax({
									type:\'POST\',
									url: $(this).attr(\'action\'),
									data:formData,
									cache:false,
									contentType: false,
									processData: false,
									success:function(data){
									if(data.trim() == "-"){
										$(\'#summonCont'.$QueueObject['queue_id'].'\').html("User has been notified.");
									}else{
										alert(data);
									}
									},
									error: function(data){
									alert("Contact Admin.");
									}
								});
							}));
						</script>


						<form class="mt-2" id="userRemove'.$QueueObject['queue_id'].'" action="server_fundamentals/ServiceController" method="post">
							<input type="hidden" name="remove_user_queue_id" value="'.md5("remo*-/-*anj".$QueueObject['queue_id']).'" />
							<input type="hidden" name="service_hash" value="'.md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$ServiceMaster['service_id']).'" />
							<button type="submit" class="btn btn-danger">Remove</button>
						</form>
						<script type=\'text/javascript\'>
							$(\'#userRemove'.$QueueObject['queue_id'].'\').on(\'submit\',(function(e) {
								e.preventDefault();
								if (confirm("Are you sure you want to delete this user?")) {         
									var formData = new FormData(this);
								
								$.ajax({
									type:\'POST\',
									url: $(this).attr(\'action\'),
									data:formData,
									cache:false,
									contentType: false,
									processData: false,
									success:function(data){
									if(data.trim() == "-"){
										$(\'#summonCont'.$QueueObject['queue_id'].'\').html("User Deleted");
									}else{
										alert(data);
									}
									},
									error: function(data){
									alert("Contact Admin.");
									}
								});
								        
								  } 
								
							}));
						</script>				</div>

					';
$chatStore[] = array("name"=>(is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])),
"mobile"=>(is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])),
"time_elap"=>round((time()-$QueueObject['queue_dnt'])/60)." mins",
"time_delta"=>round((time()-$QueueObject['queue_dnt'])/60)." mins",
"action"=>$formSend,"order"=>$QueueObject['queue_id']);
				}
				echo json_encode($chatStore);
			}else{
				die("n");
			}
}
#
if(isset($_POST['notified_service_order_id'])){
	if(!is_numeric($_POST['notified_service_order_id'])){
		die();
	}
	
		$chatStore = array();
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 3
								and queue_id > ".$_POST['notified_service_order_id']."
								order by queue_summon_dnt asc");
			
			
			if(is_array($getQueue)){
				foreach($getQueue as $QueueObject){
				
					$formSend = '
					<div id="nowServeCont'.$QueueObject['queue_id'].'">
						<form id="nowServePerson'.$QueueObject['queue_id'].'" action="server_fundamentals/ServiceController" method="post">
							<input type="hidden" name="now_serve_user_queue_id" value="'.md5("nowserve*-*/-*/-*/-/*kwsnm".$QueueObject['queue_id']).'" />
							<input type="hidden" name="service_hash" value="'.md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$ServiceMaster['service_id']).'" />
							<button type="submit" class="btn btn-primary">Arrived</button>
						</form>
						<script type=\'text/javascript\'>
							$(\'#nowServePerson'.$QueueObject['queue_id'].'\').on(\'submit\',(function(e) {
								e.preventDefault();
								var formData = new FormData(this);
								
								$.ajax({
									type:\'POST\',
									url: $(this).attr(\'action\'),
									data:formData,
									cache:false,
									contentType: false,
									processData: false,
									success:function(data){
									if(data.trim() == "-"){
										$(\'#nowServeCont'.$QueueObject['queue_id'].'\').html("User Marked as Arrived.");
									}else{
										alert(data);
									}
									},
									error: function(data){
									alert("Contact Admin.");
									}
								});
							}));
						</script>
';
if((time() - $QueueObject['queue_summon_dnt']) >= 900 ){
$formSend .= '

						<form class="mt-2" id="userRemove'.$QueueObject['queue_id'].'" action="server_fundamentals/ServiceController" method="post">
							<input type="hidden" name="no_show_user_queue_id" value="'.md5("noSho*-/-*anj".$QueueObject['queue_id']).'" />
							<input type="hidden" name="service_hash" value="'.md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$ServiceMaster['service_id']).'" />
							<button type="submit" class="btn btn-danger">No Show</button>
						</form>
						<script type=\'text/javascript\'>
							$(\'#userRemove'.$QueueObject['queue_id'].'\').on(\'submit\',(function(e) {
								e.preventDefault();
								if (confirm("Are you sure you want to mark the user as a No-Show?")) {         
									var formData = new FormData(this);
								
								$.ajax({
									type:\'POST\',
									url: $(this).attr(\'action\'),
									data:formData,
									cache:false,
									contentType: false,
									processData: false,
									success:function(data){
									if(data.trim() == "-"){
										$(\'#nowServeCont'.$QueueObject['queue_id'].'\').html("User Deleted");
									}else{
										alert(data);
									}
									},
									error: function(data){
									alert("Contact Admin.");
									}
								});
								        
								  } 
								
							}));
						</script>
				</div>

					';
}
$chatStore[] = array("name"=>(is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])),
"mobile"=>(is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])),
"time_elap"=>round((time()-$QueueObject['queue_dnt'])/60)." mins",
"time_delta"=>round((time()-$QueueObject['queue_summon_dnt'])/60)." mins",
"action"=>$formSend,"order"=>$QueueObject['queue_id']);
				}
				echo json_encode($chatStore);
			}else{
				die("n");
			}
}
#
if(isset($_POST['serving_service_order_id'])){
	if(!is_numeric($_POST['serving_service_order_id'])){
		die();
	}
	
		$chatStore = array();
		$getQueue = mysqlSelect("SELECT * FROM `virtual_queue_container` q
								left join client_logins on queue_lum_id = lum_id
								where queue_service_id = ".$ServiceMaster['service_id']."
								and queue_state= 4
								and queue_id > ".$_POST['serving_service_order_id']."
								order by queue_arrived_dnt asc");
			
			
			if(is_array($getQueue)){
				foreach($getQueue as $QueueObject){
				
					$formSend = '
					<div id="completedCont'.$QueueObject['queue_id'].'">
						<form id="completedOrder'.$QueueObject['queue_id'].'" action="server_fundamentals/ServiceController" method="post">
							<input type="hidden" name="order_complete_queue_id" value="'.md5("complete*-*/-*/-*/-/*kwsnm".$QueueObject['queue_id']).'" />
							<input type="hidden" name="service_hash" value="'.md5($USER_ARRAY['lum_id']."2fr*-/r85f6a3".$ServiceMaster['service_id']).'" />
							<button type="submit" class="btn btn-warning">Completed</button>
						</form>
						<script type=\'text/javascript\'>
							$(\'#completedOrder'.$QueueObject['queue_id'].'\').on(\'submit\',(function(e) {
								e.preventDefault();
								var formData = new FormData(this);
								
								$.ajax({
									type:\'POST\',
									url: $(this).attr(\'action\'),
									data:formData,
									cache:false,
									contentType: false,
									processData: false,
									success:function(data){
									if(data.trim() == "-"){
										$(\'#completedCont'.$QueueObject['queue_id'].'\').html("Transaction Marked as Completed.");
									}else{
										alert(data);
									}
									},
									error: function(data){
									alert("Contact Admin.");
									}
								});
							}));
						</script>



				</div>
					';
$chatStore[] = array("name"=>(is_null($QueueObject['queue_lum_id']) ? $QueueObject['queue_user_name']:($QueueObject['lum_fname']." ".$QueueObject['lum_lname'])),
"mobile"=>(is_null($QueueObject['queue_lum_id']) ? ("+".$QueueObject['queue_user_mob_code']."-".$QueueObject['queue_user_mob_body']):("+".$QueueObject['lum_mob_code']."-".$QueueObject['lum_mob_body'])),
"time_elap"=>round((time()-$QueueObject['queue_dnt'])/60)." mins",
"time_delta"=>round((time()-$QueueObject['queue_arrived_dnt'])/60)." mins",
"action"=>$formSend,"order"=>$QueueObject['queue_id']);
				}
				echo json_encode($chatStore);
			}else{
				die("n");
			}
}

?>