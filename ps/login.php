<!DOCTYPE html>

<?php
	// PHP ERRORS
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	ini_set("log_errors", 1);
	ini_set("error_log", "error.log");
	//error_log( "Hello, errors!" );

	// STARTING SESSION
	session_start();
	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE) {
		header("location: user/home.php");
	}
	
	// SETTING THINGS
	$error = '';
	include("config.php");
	$include_path = "../";
	$use_page = "TRUE";

	// AFTER GETTING USERNAME AND PASSWORD
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		login_user($conn, $password_path);
	}

	mysqli_close($conn);
?>

<html>

<title> PS | Login </title>

<head>
	<base href="../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps/style.css">
</head>

<body>

<div id="main">

<div id="header">

	<!------------------------------------heading----------------------------------------->
	<?php
		include("$include_path/components/heading.php");
	?>
	<!---------------------------------end of heading------------------------------------->

	<!------------------------------------navigation-bar----------------------------------------->
	<?php
		include("$include_path/components/nav-bar.php");
	?>
	<!---------------------------------navigation-bar------------------------------------->

</div> <!-- header ends here --> 



<div id="site_content">


	<!------------------------------------sidebar----------------------------------------->

	<div class="sidebar">

	<h1>How to Use</h1>
	<h4>Steps (just briefly)</h4>
	<ul>
		<li>First login (with NIS). </li>
		<li>Then you can select the files to upload. </li>
		<li>Once the upload is done go to print server and take the printout there. </li>
		<a>Read more</a>
	</ul>

	</div>

	<!---------------------------------sidebar------------------------------------->


	<!-----------------------------main site content------------------------------------->
	<div id="content">
		
	<h2> Login Here </h2>
	<form action="" method="post">
		<div class="login-box">
		<label><b> Username </b></label> <br>
		<input type="text" placeholder="Enter username" name="username" required> <br><br>

		<label><b> Password </b></label> <br>
		<input type="password" placeholder="Enter password" name="password" required> <br> 

		<div style = "font-size:15px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div> <br>
		<button type="submit" id ="login-box-button">Submit</button>
		</div>
	</form>

	</div><!-- content ends here -->
	<!-----------------------------main site content------------------------------------->



</div><!-- site_content ends here -->




	<!------------------------------------footer----------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
	<!---------------------------------footer------------------------------------->


</div><!-- main ends here -->

</body>
</html>







<?php
/************ FUNCTION DEFENITIONS ***********************/

function checkNewUser($conn, $username) {
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
	$count = mysqli_num_rows($result);
	// IF USER NOT FOUND - CREATE USER
	if ($count == 0) {
		$result = mysqli_query($conn, "SELECT * FROM quota");
		$streamquota = ''; $streamcode = ''; $streamname = '';
		while($row = mysqli_fetch_assoc($result)) {
			$regExp = $row['reg_exp'];
			if (preg_match("$regExp", "$username")) {
				$streamquota = $row['stream_quota'];
				$streamcode = $row['stream_code'];
				$streamname = $row['stream_name'];
				break;
			}
		}
		// RENEWAL DATE
		$query = "SELECT `value` FROM `utility` WHERE `name`='quota-renewal-time'";
		$ren_time = mysqli_query($conn, $query)->fetch_assoc()['value'];
		if ($ren_time == "1month") {
			$new_ren_date = mktime(0, 0, 0, date("m") + 1, 1, date("Y"));
		} 
		elseif ($ren_time = "1week") {
			$new_ren_date = strtotime("next Monday");
		}
		// UPDATE DB
		$query = "INSERT INTO `users` (`username`, `stream`, `quota`, `renewal_date`) VALUES ('$username', '$streamname', $streamquota, $new_ren_date)";
		mysqli_query($conn, $query);
	}
}
	
function login_user($conn, $password_path)
{
	$username = strtolower($_POST["username"]);
	$inp_pass = $_POST["password"];

	// FOR ADMIN
	if ($username == "admin") {
		$result = mysqli_query($conn, "SELECT value FROM utility WHERE name=\"admin-password\"");
		$row = 	$result->fetch_assoc();
		$admin_pass = $row['value'];

		if ($inp_pass == $admin_pass) {
			echo $_SESSION['logged_in'] = TRUE;
			echo $_SESSION['username'] = $username;
			header("location: admin/admin.php");
		} else {
			$GLOBALS['error'] = "Invalid password";
			return;
		}
	// FOR USER				
	} 
	else {
		$encrypted_pass = exec("$password_path | grep '^$username:' | awk -F: '{printf $2}'");
		if (empty($encrypted_pass)) {
			$GLOBALS['error'] = "Invalid Username";
			return;
		}
		$key = $inp_pass;
		$salt = $encrypted_pass;
		$inp_encrypted_pass = crypt($key, $salt);
	
		if ($inp_encrypted_pass == $encrypted_pass) {
			// TRUE
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['username'] = $username;
			checkNewUser($conn, $username);
			header("location: user/home.php");
		} 
		else {
			// FALSE
			$GLOBALS['error'] = "Invalid Password";		
			return;
		}
	}	
}

?>
