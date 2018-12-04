<!DOCTYPE html>

<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] == TRUE) {
		header("location: user/home.php");
	}
	
	// SETTING THINGS
	$error = '';
	include("config.php");
	/*************************  VARIABLE ****************************/
	$password_path = "/home/printmaster/ypcat_passwd_20181201.txt";

	// AFTER GETTING USERNAME AND PASSWORD
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
				$error = "Invalid password";
			}
		// FOR USER				
		} else {

			$encrypted_pass = exec("cat $password_path | grep $username | awk -F: '{printf $2}'");
			$key = $inp_pass;
			$salt = $encrypted_pass;
			$inp_encrypted_pass = crypt($key, $salt);

			if ($inp_encrypted_pass == $encrypted_pass) {
				// TRUE
				$_SESSION['logged_in'] = TRUE;
				$_SESSION['username'] = $username;
				header("location: user/home.php");
			} else {
				// FALSE
				$error = "Invalid Username or Password";		
			}
			

		}	
	}
	
?>

<html>

<title>Login</title>

<head>
	<base href="../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps-new/style.css">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

</head>

<body>
<div id="main">
     <div id="header">
    <!------------------------------------heading----------------------------------------->
	<?php
		$include_path = "../";
		$use_page="TRUE";
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
	<?php
		include("$include_path/components/sidebar.php");
	?>
   	<!---------------------------------sidebar------------------------------------->

      <div id="content">
		<h2> Login Here </h2>
		 <form action="" method="post">
			<div class="login-box">
				<label><b> Username </b></label> <br>
				<input type="text" placeholder="Enter username" name="username" required> <br><br>

				<label><b> Password </b></label> <br>
				<input type="password" placeholder="Enter password" name="password" required> <br> <br>

				<button type="submit" id ="login-box-button">Submit</button>
				<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
			</div>
		 </form>
	</div><!-- content ends here -->
    </div><!-- site_content ends here -->
    <!------------------------------------footer----------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
    <!---------------------------------footer------------------------------------->

  </div><!-- main ends here -->
</body>

</html>
