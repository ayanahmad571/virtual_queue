<?php
$servername = "localhost";

//LOCAL SERVER
$username = "root";
$password = "";
$dbname = "vqu";

/*
server home
$username = "root";
$password = "K;ecIN2sQj+4kjkjjjkkj";
$dbname = "vqu";
*/
/*
#Live Server Hostinger frestive.online
$username = "u448825944_qista";
$password = "K;ecIN2sQj+4kjkjjjkkj";
$dbname = "u448825944_qista";
*/

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach($_POST as $key=>$v){


	if(!is_array($_POST[$key])){
		if($key == 'ml_s_txt'){
			$_POST[$key] =str_replace('script>','', trim(($conn->escape_string($v))));
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
		 $_GET[$key] = trim(strip_tags($conn->escape_string($v)));
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
?>