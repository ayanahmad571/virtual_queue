<?php
	// Authorisation details.
	$username = "anonymous.code.anonymous@gmail.com";
	$hash = "2a378ee730b767d58f14ef1ff9df3c17c14251317a2ef903d744b57bc1980d0f";

	// Config variables. Consult http://api.txtlocal.com/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "Chapters SB"; // This is who the message appears to be from.
	$numbers = "447785921503"; // A single number or a comma-seperated list of numbers
	
	$message = "Dear Ms. Aakanksha, you are required to clear your room as soon as possible. Get out now.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.txtlocal.com/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
?>