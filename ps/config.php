<?php
	// SET CONNECTION DETAILS
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'passwd@123');
	define('DB_DATABASE', 'print_server');

	// CONNECT TO THE DATABASE
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	/*************************  VARIABLE ****************************/
	$password_path = "ypcat passwd";
	$upload_path = "/var/printmaster/uploads";
/*
	if ($conn->connect_error) {
		echo "Connection Unsuccessful!"."<br />";
		echo $conn->connect_error;
		die();
	} else {
		echo "Connection Successful!";
		echo "<br /> '".DB_USERNAME."' @ '".DB_SERVER."'";
		echo "<br />"."Database : '".DB_DATABASE."'";
	}
 */
?>

<!-- TRASH

	if ($conn->connect_error) {
		echo "Connection Unsuccessful!"."<br />";
		echo $conn->connect_error;
		die();
	} else {
		echo "Connection Successful!";
		echo "<br /> '".DB_USERNAME."' @ '".DB_SERVER."'";
		echo "<br />"."Database : '".DB_DATABASE."'";
	}
/*
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $SESSION['username'] != 'admin') {
		header("location: login.php");
	}
*/
-->

