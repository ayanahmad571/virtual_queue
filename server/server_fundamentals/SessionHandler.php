<?php
require_once("Settings.php");
require_once("CookieController.php");
require_once("DatabaseConnection.php");
require_once("FunctionsController.php");

sec_session_start();
/* 
	1. check if logged in 
	2. check if page is admin page
	3. check if admin has started the session.
	4. get wallet amount 
*/
#Check is the user has logged in or no.
if(isset($_SESSION[SESSION_CONTROLLER_NAME]) && is_numeric($_SESSION[SESSION_CONTROLLER_NAME])){
	$resp = mysqlSelect("SELECT * FROM `admin_sm_logins` l
	left join admin_sm_user_groups g on l.lum_type = g.type_id
	where 
	g.type_id is not null and l.lum_valid =1 and l.lum_id = ".$_SESSION[SESSION_CONTROLLER_NAME]);
	if(!is_array($resp)){
		die("(Account Not Found <a href='logout.php'><button>Re-login</button></a>)");
	}
	$USER_ARRAY = $resp[0];
}else{


	header("Location: logout");
	die();
}

/*
	Here after can only be accessed if logged in.
*/

#Check if this page is admin only and kick out non admins 

$ids_header = $USER_ARRAY['type_mod_id'];
	$si_header = "in (".$ids_header.")";
	if(trim($ids_header) == "*"){
	$si_header = "not in (0)";
	}

$pageViewChecker = mysqlSelect("SELECT * FROM `admin_ui_modules` m 
left join admin_ui_module_groups g on m.mod_mg_id = g.mg_id 
WHERE mod_id ".$si_header."
and mod_valid =1 
and mod_href = '".trim(pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME))."'");
if(!is_array($pageViewChecker)){
	header('Location: '.$USER_ARRAY['type_landing']);
	die("Access Denied");
}





?>