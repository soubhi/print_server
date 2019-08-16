<?php
	include("../config.php");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	
	$streamcode = $_GET['val'];
	if ($streamcode == "select") {
		echo 0;
	}
	else {
		echo mysqli_query($conn, "SELECT stream_quota FROM quota WHERE stream_code = '$streamcode'")->fetch_assoc()['stream_quota'];
	}
?>
