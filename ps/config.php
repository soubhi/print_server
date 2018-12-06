<?php
	// SET CONNECTION DETAILS
	define('DB_SERVER', '10.5.0.193');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'root123');
	define('DB_DATABASE', 'print_server');

	// CONNECT TO THE DATABASE
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	/*************************  VARIABLE ****************************/
	$password_path = "/home/printmaster/ypcat_passwd_20181201.txt";

?>

<!-- TRASH

/*
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $SESSION['username'] != 'admin') {
		header("location: login.php");
	}
*/

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

-->
