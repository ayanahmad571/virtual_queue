<?php
#logout
require_once("server_fundamentals/Settings.php");
require_once("server_fundamentals/CookieController.php");

sec_session_start();
session_destroy();
header('Location: login');
exit();


?>