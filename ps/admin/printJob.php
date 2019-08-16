<?php 
	include("../config.php");
	// DISPLAY ERRORS
	ini_set('display_errors', "log.txt");
	ini_set('display_startup_errors', "log.txt");
	error_reporting(E_ALL);
	ini_set("log_errors", 1);
	ini_set("error_log", "error.log");
	error_log( "Hello, errors!" );

//	echo $file_path = $_GET['filePath'];
//	echo $RANGE_STRING = $_GET['pageRange'];
///*
	$file_path = $_GET['file_path'];
	$RANGE_STRING = $_GET['RANGE_STRING'];
	$username = $_GET['username'];
	$user_id = $username;
	$job_id = $_GET['job_id'];
	$nop = $_GET['nop'];
	
	$exec_result = exec("lp -o page-ranges=$RANGE_STRING $file_path", $exec_output, $exec_return);
	if ($exec_return != 0) {
		error_log("User: $username - Exec error! Return val = $exec_return");
		echo "<script> alert(\"Error printing document, pls try again!\");</script>";
	}
	else {
		print_r($output);
		// UPDATING DB
		mysqli_query($conn, "UPDATE queue SET `Status`=\"printed\",`Print_Time` = NOW() WHERE `Job_ID` = $job_id");

		// UPDATING THE QUOTA
		mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id'");
	}
//*/
	echo "Helloooooooooo";
?>
