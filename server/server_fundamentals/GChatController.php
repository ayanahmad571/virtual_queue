<?php 
require_once("SessionHandler.php");
#	gc_cg_id: '  
#
if(isset($_POST['gc_page_id'])){
	
##GC START
	if(!is_numeric($_POST['gc_page_id'])){
		die();
	}
	if(!isset($_POST['gc_cg_id'])){
		die();
	}
	
	if(!ctype_alnum($_POST['gc_cg_id'])){
		die();
	}
	$checkCgID = mysqlSelect("select * from c_chat_groups where (cg_1_lum_id = ".$USER_ARRAY['lum_id']." or cg_2_lum_id = ".$USER_ARRAY['lum_id'].") 
	and  (".(time()-(300 -1 ))." < cg_dnt ) and md5(md5(concat('U2809RFHU2894HYGEW%^**',cg_id))) = '".$_POST['gc_cg_id']."'");
	
	if(!is_array($checkCgID)){
		die();
	}

$getChats = mysqlSelect("select * from c_chat_all c
left join sm_logins l on c.ca_lum_id = l.lum_id
where ca_approved =1
and l.lum_valid =1
and ca_cg_id = ".$checkCgID[0]['cg_id']."
and ca_id > ".$_POST['gc_page_id']."
order by ca_id asc");



if(!is_array($getChats)){
	die();
}

foreach($getChats as $Chat){
	if($USER_ARRAY['lum_id'] == $Chat['ca_lum_id']){
		$lor = 'right';
	}else{
		$lor = 'left';
	}
	$jsar[] = array("text"=>$Chat['ca_text'],"position"=>$lor, "order"=>$Chat['ca_id'], "time_f"=>date("h:i A", $Chat['ca_dnt']), "imageurl"=>$Chat['lum_img_src'] );
}


echo json_encode($jsar);




#GCEND
}
#
if(isset($_POST['gc_add_text'])){
		if(!isset($_POST['gc_cg_id'])){
		die();
	}
	
	if(!ctype_alnum($_POST['gc_cg_id'])){
		die();
	}
	$checkCgID = mysqlSelect("select * from c_chat_groups where (cg_1_lum_id = ".$USER_ARRAY['lum_id']." or cg_2_lum_id = ".$USER_ARRAY['lum_id'].") 
	and  (".(time()-(300 -1 ))." < cg_dnt ) and md5(md5(concat('U2809RFHU2894HYGEW%^**',cg_id))) = '".$_POST['gc_cg_id']."'");
	
	if(!is_array($checkCgID)){
		die();
	}

	$insertData = mysqlInsertData("INSERT INTO `c_chat_all`( `ca_lum_id`, `ca_cg_id`, `ca_text`, `ca_dnt`, `ca_approved`) VALUES (
	'".$USER_ARRAY['lum_id']."',
	".$checkCgID[0]['cg_id'].",
	'".$_POST['gc_add_text']."',
	'".time()."', 1
	)", true);
	
	if(!is_numeric($insertData)){
		die('Ei1');
	}
}
#
if(isset($_POST['gc_online_handler'])){
	if(!ctype_alnum($_POST['gc_online_handler'])){
		die();
	}
	$checkUser = mysqlSelect("select * from sm_logins where 
	lum_valid =1 and
	md5(md5(concat(lum_id,'AIOUO***/.***G*g*43*wh'))) = '".$_POST['gc_online_handler']."'
	");
	
	if(!is_array($checkUser)){
		die();
	}
	
	$insertData = mysqlInsertData("INSERT INTO `c_chat_groups_online`(`cgo_lum_id`, `cgo_dnt`) VALUES (
	".$USER_ARRAY['lum_id'].",
	'".time()."'
	)",true);
	
	if(!is_numeric($insertData)){
		die('0');
	}
	$timeInPast = (time()-(300));
	$checkForChat = mysqlSelect("select * from c_chat_groups where (cg_1_lum_id = ".$USER_ARRAY['lum_id']." or cg_2_lum_id = ".$USER_ARRAY['lum_id'].") 
	and ( (".time()." >= cg_dnt ) and (cg_dnt >= '".$timeInPast."' ) ) ");
	$foundMember = false;
	
	if(is_array($checkForChat)){
		$foundMember = true;
		echo "1";
	}
	
	
	
	die();
	
}
?>
