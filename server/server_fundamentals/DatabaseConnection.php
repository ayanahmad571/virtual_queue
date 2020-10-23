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
define("DB_TABLE", "admin_uploads");

define("DB_USER", "root");
define("DB_PASS", "");
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

##################################################
#              Folder configuration              #
##################################################
# R_PATH:	The absolute path. Don't change this #
#			unless you know what you're doing!	 #
# F_PATH:	The folder to store images			 #
#												 #
#			INFO: This folder is relative to the #
#			location of your form upload		 #
#			handler. (eg: upload.php)			 #
# H_FILE:	Change this to 'true' if you want    #
#			to create/use a .htaccess file to    #
#			protect your images folder.			 #
#												 #
#			WARNING: htaccess files are not 100% #
#			reliable! It's STRONGLY advised to   #
#			use a folder outside of your		 #
#			document root instead! This option   #
#			is only there for those who are		 #
#			unable to do so and therefor have no #
#			other choice but to rely on			 #
#			htaccess!							 #
##################################################

define("R_PATH", __DIR__);
define("F_PATH", 'ImageHandlers/images');
define("H_FILE", false);

##################################################
#              File configuration                #
##################################################
# F_SIZE:	The maximum file size in KB or MB	 #
#			Example: 512K / 2M					 #
#												 #
#			WARNING: Make sure to check the		 #
#			values of 'post_max_size' and		 #
#			'upload_max_filesize' in your		 #
#			php.ini file! This setting should	 #
#			not be larger than either of those!	 #
##################################################

define("F_SIZE", "1M");



?>