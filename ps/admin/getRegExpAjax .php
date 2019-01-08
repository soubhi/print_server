<?php
	include("../config.php");
	$streamcode = $_GET['val'];
	if ($streamcode == "select") {
		echo 0;
	}
	else {
		echo mysqli_query($conn, "SELECT reg_exp FROM quota WHERE stream_code = '$streamcode'")->fetch_assoc()['reg_exp'];
	}
?>
