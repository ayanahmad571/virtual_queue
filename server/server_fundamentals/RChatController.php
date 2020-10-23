<?php 
require_once("SessionHandler.php");
#

if(isset($_POST['rc_page_id']) and isset($_POST['rc_page_vr'])){
##GC START

	if(!is_numeric($_POST['rc_page_id'])){
		die("P1");
	}
	if(!ctype_alnum($_POST['rc_page_vr'])){
		die("P2");
	}
	$getRoomDets = mysqlSelect("SELECT * FROM `virtual_rooms` r
left join virtual_booths v on r.vr_vb_id = v.vb_id
where v.vb_valid =1 and  v.vb_paid=1 and
r.vr_active =1  
and md5(concat('BHU38Q9EFRO23jt-94-9UN90V89974**--WSD',vr_id)) = '".$_POST['rc_page_vr']."'");
	
if(!is_array($getRoomDets)){
		die("NA1");
}
$getRoomDets = $getRoomDets[0];
	
$getChats = mysqlSelect("select * from c_chat_rooms c
left join sm_logins l on c.ccr_lum_id = l.lum_id
where ccr_approved =1
and l.lum_valid =1
and c.ccr_vr_id = ".$getRoomDets['vr_id']."
and ccr_id > ".$_POST['rc_page_id']."
order by ccr_dnt, ccr_id asc");
if(!is_array($getChats)){
	die();
}

foreach($getChats as $Chat){
	if($USER_ARRAY['lum_id'] == $Chat['ccr_lum_id']){
		$lor = 'right';
	}else{
		$lor = 'left';
	}
	$jsar[] = array("text"=>$Chat['ccr_text'],"position"=>$lor, "order"=>$Chat['ccr_id'], "time_f"=>date("h:i A", $Chat['ccr_dnt']), "imageurl"=>$Chat['lum_img_src'] );
}


echo json_encode($jsar);




#GCEND
}
#

if(isset($_POST['rc_add_text']) and isset($_POST['rc_vr'])){
	if(!ctype_alnum($_POST['rc_vr'])){
		die("P2");
	}
	
		$getRoomDets = mysqlSelect("SELECT * FROM `virtual_rooms` r
left join virtual_booths v on r.vr_vb_id = v.vb_id
where v.vb_valid =1 and  v.vb_paid=1 and
r.vr_active =1  
and md5(concat('BHU38Q9EFRO23jt-94-9UN90V89974**--WSD',vr_id)) = '".$_POST['rc_vr']."'");
	
if(!is_array($getRoomDets)){
		die("NA1");
}
$getRoomDets = $getRoomDets[0];


	$insertData = mysqlInsertData("
	INSERT INTO `c_chat_rooms`(`ccr_vr_id`, `ccr_lum_id`, `ccr_text`, `ccr_dnt`, `ccr_approved`) VALUES (
	'".$getRoomDets['vr_id']."',
	'".$USER_ARRAY['lum_id']."',
	'".$_POST['rc_add_text']."',
	'".time()."',
	".($USER_ARRAY['lum_id'] == $getRoomDets['vb_lum_id']? 1 : 0)."
	)", true);
	
	if(!is_numeric($insertData)){
		die('I1');
	}
}

?>
