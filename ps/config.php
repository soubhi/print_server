<?php

	// SET CONNECTION DETAILS
	$conn = mysqli_connect("localhost", "root", "root123");
	mysqli_select_db($conn, "print_server");
 
	if (mysqli_errno($conn)) {
		printf("connect failed: %s\n", mysqli_error());
		exit();
	}
	else {
		echo "";
		//printf("Host information: %s\n", mysqli_get_host_info($conn));
	}

	/*************************  VARIABLES ****************************/
	$password_path = "ypcat passwd";
	//$password_path = "cat /home/printmaster/ypcat_passwd_20181201.txt";
	//$configVar_uploadPath = "/home/printmaster/uploads/"; 
	$configVar_uploadPath = "/var/printmaster/uploads/"; 
	//$configVar_net = "192.168.43.0";
	//$configVar_mask = "24";
	$configVar_net = "10.5.0.0";
	$configVar_mask = "23";

	/*
	//define('DB_SERVER', 'localhost');
	define('DB_SERVER', '192.168.0.101');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'root123');
	define('DB_DATABASE', 'print_server');

	// CONNECT TO THE DATABASE
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	// CONNECTION ERROR
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
