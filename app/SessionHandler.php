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

?>