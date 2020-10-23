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
#
if(isset($_POST['service_name']) && isset($_POST['service_desc'])){
	$insService = mysqlInsertData("INSERT INTO `virtual_services`(`service_branch_id`, `service_name`, `service_desc`) VALUES (
	'".$BranchMaster['branch_id']."',
	'".$_POST['service_name']."',
	'".$_POST['service_desc']."'
	)",true);
	
	if(!is_numeric($insService)){
		die($insService);
	}
}
#
if(isset($_POST['toggle_room_v'])){
	

	if(!ctype_alnum($_POST['toggle_room_v'])){
		die("Not Found");
	}
		$getRom = mysqlSelect("SELECT * FROM `virtual_services`  where md5(concat('TINGkjwrgnEHEIUNOIU*****siufniue',service_id)) = '".$_POST['toggle_room_v']."' and service_branch_id = ".$BranchMaster['branch_id']);
		
		if(!is_array($getRom)){
			die("service not found");
		}
		

		if($getRom[0]['service_status'] == 1){
			#disable
		$updateSql = "UPDATE `virtual_services` SET `service_status` = 0 where service_id = ".$getRom[0]['service_id']."";
		}else{
			#enable
		$updateSql = "UPDATE `virtual_services` SET `service_status` = 1 where service_id = ".$getRom[0]['service_id']."";
		}
		
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update Room data. 503 Server Error');
}
header('Location: ../manage-branch#red');		
die();
}




die();
####################################################################

#
if(isset($_POST['change_pw'])){
$newpw = $_POST['change_pw'] ;
	if($newpw == ""){
		die("Password must not be empty.");		
	}
	
$h = genHash($USER_ARRAY['lum_email'],$newpw);
$updateSql = "update sm_logins set lum_hash = '".$h."' 
where lum_id = ".$USER_ARRAY['lum_id'];
$updateData = mysqlUpdateData($updateSql,true);
if(!is_numeric($updateData)){
	die('Could Not Update User data. 503 Server Error');
}
	
	
}
#
if(isset($_POST['booth_fund_c_tag_val'])){

	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			
		$updateSql = "update virtual_booths set vb_tags = '".$_POST['booth_fund_c_tag_val']."' 
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['booth_fund_c_tagline_val'])){

	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			
		$updateSql = "update virtual_booths set vb_tagline = '".$_POST['booth_fund_c_tagline_val']."' 
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['edit_booth_desc'])){
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			
		$updateSql = "update virtual_booths set vb_desc= '".$_POST['edit_booth_desc']."' 
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['booth_c_plans_1']) and isset($_POST['booth_c_plans_2']) and isset($_POST['booth_c_plans_3']) and isset($_POST['booth_c_plans_4'])){
	
	
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			if($_POST['booth_c_plans_1'] == ""){
				$p1 = "NULL";
			}else{
				$p1 = "'".$_POST['booth_c_plans_1']."'";
			}


			if($_POST['booth_c_plans_2'] == ""){
				$p2 = "NULL";
			}else{
				$p2 =  "'".$_POST['booth_c_plans_2']."'";
			}


			if($_POST['booth_c_plans_3'] == ""){
				$p3 = "NULL";
			}else{
				$p3 =  "'".$_POST['booth_c_plans_3']."'";
			}


			if($_POST['booth_c_plans_4'] == ""){
				$p4 = "NULL";
			}else{
				$p4 =  "'".$_POST['booth_c_plans_4']."'";
			}
			
		$updateSql = "update virtual_booths set 
		vb_plan_1 = ".$p1.",
		vb_plan_2 = ".$p2.",
		vb_plan_3 = ".$p3.",
		vb_plan_4 = ".$p4."			
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['booth_c_socials_fb']) and isset($_POST['booth_c_socials_ig']) and isset($_POST['booth_c_socials_twitter']) and isset($_POST['booth_c_socials_web'])){
	
	
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			if($_POST['booth_c_socials_fb'] == ""){
				$p1 = "NULL";
			}else{
				$p1 = "'".$_POST['booth_c_socials_fb']."'";
			}


			if($_POST['booth_c_socials_ig'] == ""){
				$p2 = "NULL";
			}else{
				$p2 =  "'".$_POST['booth_c_socials_ig']."'";
			}


			if($_POST['booth_c_socials_twitter'] == ""){
				$p3 = "NULL";
			}else{
				$p3 =  "'".$_POST['booth_c_socials_twitter']."'";
			}


			if($_POST['booth_c_socials_web'] == ""){
				$p4 = "NULL";
			}else{
				$p4 =  "'".$_POST['booth_c_socials_web']."'";
			}
			
		$updateSql = "update virtual_booths set 
		vb_facebook = ".$p1.",
		vb_instagram = ".$p2.",
		vb_twitter = ".$p3.",
		vb_url = ".$p4."			
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['booth_live_yt']) and isset($_POST['booth_live_zoom'])){
	
	
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			if($_POST['booth_live_yt'] == ""){
				$p1 = "NULL";
			}else{
				$p1 = "'".$_POST['booth_live_yt']."'";
			}


			if($_POST['booth_live_zoom'] == ""){
				$p2 = "NULL";
			}else{
				$p2 =  "'".$_POST['booth_live_zoom']."'";
			}


		$updateSql = "update virtual_booths set 
		vb_youtube_live = ".$p1.",
		vb_zoom_link = ".$p2."
		where vb_id = ".$getSoc['vb_id'];
		$updateData = mysqlUpdateData($updateSql,true);
		if(!is_numeric($updateData)){
			die('Could Not Update User data. 503 Server Error');
		}
			


}
#
if(isset($_POST['add_room_name']) and isset($_POST['add_room_tagline']) and isset($_POST['add_room_desc'])){
	
	
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

		if(!is_array($getSoc)) die("Virtual Booth not found");
			$getSoc = $getSoc[0];
			if(($_POST['add_room_name'] == "") || ($_POST['add_room_tagline'] == "")  || ($_POST['add_room_desc'] == "") ){
				die("Field must not be left blank.");;
			}


		$insSql = "
		INSERT INTO `virtual_rooms`(`vr_vb_id`, `vr_title`, `vr_tagline`, `vr_desc2`) VALUES (
		'".$getSoc['vb_id']."',
		'".$_POST['add_room_name']."',
		'".$_POST['add_room_tagline']."',
		'".$_POST['add_room_desc']."'
		)
		";
		$instDt = mysqlInsertData($insSql,true);
		if(!is_numeric($instDt)){
			die('Could Not make a new room, Contact Administrator.');
		}
			


}
#
if(isset($_POST['chat_approve_id'])){

	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

if(!is_array($getSoc)) die("Virtual Booth not found");

if(!ctype_alnum($_POST['chat_approve_id'])){
	die("Not Found");
}
	
		$getChat = mysqlSelect("SELECT * FROM `c_chat_rooms`  where md5(concat('ojqoi99',ccr_id ))= '".$_POST['chat_approve_id']." '");
		if(!is_array($getChat)){
			die("Chat not Found");
		}
	
		$getRom = mysqlSelect("SELECT * FROM `virtual_rooms`  where vr_id = ".$getChat[0]['ccr_vr_id']." and vr_active =1 and vr_vb_id = ".$getSoc[0]['vb_id']."");
		
		if(!is_array($getRom)){
			die("Chat not linked to your room");
		}
		
		$updateSql = mysqlUpdateData("UPDATE `c_chat_rooms` SET `ccr_approved` = '1' WHERE `c_chat_rooms`.`ccr_id` = ".$getChat[0]['ccr_id'],true);
		if(!is_numeric($updateSql)){
			die();
		}
		

	
}



//Call Api
if(isset($_POST['vb_chat_id']) && isset($_POST['vb_order_id'])){
	if(!is_numeric($_POST['vb_order_id'])){
		die();
	}
	
	$getSoc = mysqlSelect("SELECT * FROM `virtual_booths` 
left join `virtual_booth_types` on vb_vbt_id = vbt_id
left join `virtual_booth_types_subtypes` on vst_vbt_id = vbt_id
where vb_lum_id = ".$USER_ARRAY['lum_id']."
order by vb_id asc limit 1
");

	if(!is_array($getSoc)) die("Virtual Booth not found");

	if(!ctype_alnum($_POST['vb_chat_id'])){
		die("Not Found");
	}

		$getRom = mysqlSelect("SELECT * FROM `virtual_rooms`  where md5(concat('oijdwoijfe',vr_id)) = '".$_POST['vb_chat_id']."'");
		
		if(!is_array($getRom)){
			die("room not found");

		}


		$chatStore = array();
		$getChats = mysqlSelect("SELECT * FROM `c_chat_rooms` 
		left join sm_logins on ccr_lum_id = lum_id
		where ccr_vr_id = ".$getRom[0]['vr_id']."
		and ccr_approved = 0
		and ccr_id > ".$_POST['vb_order_id']."
		order by ccr_id asc
		");
		

		if(is_array($getChats)){
foreach($getChats as $chatss){

$formSend = '
<form id="formSubmit'.$chatss['ccr_id'].'" action="server_fundamentals/VBController" method="post">
<input type="hidden" name="chat_approve_id" value="'.md5("ojqoi99".$chatss['ccr_id']).'" />
	<button type="submit" class="btn btn-primary">Approve</button>
</form>
<script type=\'text/javascript\'>
    $(\'#formSubmit'.$chatss['ccr_id'].'\').on(\'submit\',(function(e) {
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
				if(data.trim() == ""){
					$(\'#formSubmit'.$chatss['ccr_id'].'\').html("Approved.");
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
	$chatStore[] = array("name"=>$chatss['lum_fname'],"text"=>$chatss['ccr_text'],"time"=>date("D-M-Y h:i A",$chatss['ccr_dnt']),"action"=>$formSend,"order"=>$chatss['ccr_id']);
}
	echo json_encode($chatStore);
		}else{
			die();
		}
		
}
?>