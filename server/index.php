<?php
#require_once("server_fundamentals/DatabaseConnection.php");
#require_once("server_fundamentals/FunctionsController.php");
#$textForLogginPage = appendLogs("User Vistited index.php", $_SERVER['PHP_SELF'], $_POST, $_SESSION, $_SERVER, $_GET,$_SERVER['REMOTE_ADDR'], time(), $lpv_user = NULL  );
#die($textForLogginPage);

header('Location: login');
?>