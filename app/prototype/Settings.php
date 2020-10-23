<?php
##################################################
#             Database configuration             #
##################################################
# DB_HOST:	The MySQL server to connect to		 #
# DB_USER:	The MySQL server username			 #
# DB_PASS:	The MySQL server password			 #
# DB_NAME:	The MySQL server database			 #
# DB_TABLE:	The MySQL server table to create/use #
##################################################

define("DB_HOST", "localhost");

define("DB_USER", "root");
define("DB_PASS", "qwertyqazwsxhack1234.");
define("DB_NAME", "vqu");

#define("DB_USER", "u448825944_qista");
#define("DB_PASS", "K;ecIN2sQj+4kjkjjjkkj");
#define("DB_NAME", "u448825944_qista");

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach($_POST as $key=>$v){


	if(!is_array($_POST[$key])){
		if($key == 'edit_booth_desc'){
			$_POST[$key] =str_replace('<script','', trim(($conn->escape_string($v))));
		}else{
		 $_POST[$key] = trim(strip_tags($conn->escape_string($v)));
		}
	}
	else if (is_array($_POST[$key])){
		foreach($_POST[$key] as $ke=>$vv){
		 $_POST[$key][$ke] = trim(strip_tags($conn->escape_string($vv)));
		}
	}else{
		die('INCL#ERR1');
	}


}

foreach($_GET as $key=>$v){
	
	if(!is_array($_GET[$key])){
		 $_GET[$key] = trim(strip_tags($conn->escape_string($v)));
	}
	else if (is_array($_GET[$key])){
		foreach($_GET[$key] as $ke=>$vv){
		 $_GET[$key][$ke] = trim(strip_tags($conn->escape_string($vv)));
		}
	}else{
		die('INCL#ERR1');
	}

}


function mysqlInsertData($sql, $ret = false){
$conn = $GLOBALS['conn'];
if ($conn->query($sql) === TRUE) {
	if($ret){
		return $conn->insert_id; #inserted, gives number 1
	}else{
		return "#"; #inserted gives ok 
	}
    
} else {
    die( "Error: " . $sql . "<br>" . $conn->error);
}

	
}
function mysqlUpdateData($sql, $ret = false){
$conn = $GLOBALS['conn'];
if ($conn->query($sql) === TRUE) {
	if($ret){
		return $conn->insert_id;
	}else{
		return "#";
	}
    
} else {
    die( "Error: " . $sql . "<br>" . $conn->error);
}

	
}

function mysqlSelect($sql){
	$conn = $GLOBALS['conn'];
	$result = $conn->query($sql);
	$dump =array();
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$dump[] = $row;
		}
		return $dump;
	} else {
		return "Error: " . $sql . "<br>" . $conn->error;
	}
	
}

function sec_session_start() {
    $session_name = 'qista_client';   // Set a custom session name
#    $secure = false;
    // This stops JavaScript being able to access the session id.
#    $httponly = true;
    // Forces sessions to only use cookies.
#    if (ini_set('session.use_only_cookies', 1) === FALSE) {
#        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
#        exit();
#    }
    // Gets current cookies params.
#    $cookieParams = session_get_cookie_params();

#    session_set_cookie_params($cookieParams["lifetime"],
#        $cookieParams["path"], 
#        $cookieParams["domain"], 
#        $secure,
#        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
}

sec_session_start();
$loggedIN = false;
if(isset($_SESSION['QISTA_SESSION_ID'])){
	if(is_numeric($_SESSION['QISTA_SESSION_ID'])){
		$loggedIN = true;
	}
}


?>