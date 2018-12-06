<!DOCTYPE html>
<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: login.php");
	}

	include("config.php");
	
?>

<html>

<title>Admin</title>

<head>
	<base href="../../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div id="main">
     <div id="header">
    <!------------------------------------heading----------------------------------------->
	<?php
		$include_path = "../..";
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
	<h2> Welcome Admin! </h2>
	<div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="change-quota" style="background-color: lightblue; color: white;">Change Quota</a>
		<!--<div class="change-quota"><a href="ps/change_quota.php">Change Quota</a></div> <br>-->
		<a href="ps/admin/history.php" class="history-button" >View History</a>
	</div>
 
	<!----------------------------------- CHANGE QUOTA CONTENT --------------------------------------->

	<script>
		function newLocation() { 
			window.location="ps/change_quota.php";
		}
		//setTimeout(newLocation, 1500)
	</script>

	<style>
		.column {
		    float: left;
		    width: 50%;
		}

		/* Clear floats after the columns */
		.row:after {
		    content: "";
		    display: table;
		    clear: both;
		}
	</style>

	<br> <br> <br>	
	<div class="row">
		<div class="column"> 
			<form action="ps/change_quota.php" method="post">	
			Select Stream : 
			<select name="stream">
				<option value="mcme">Int. M Tech</option> 
				<option value="mcmt">M Tech</option>
			</select> <br>
			Quota : <input type="number" name="quota"> <br> <br>  	
			<input type="submit" value="Submit">	
			</form>
		</div>

		<div class="column">  
			<form action="ps/change_quota.php" method="post">	
			Select Stream : 
			<select name="stream">
				<option value="mcme">Int. M Tech</option> 
				<option value="mcmt">M Tech</option>
			</select> <br>
			Quota : <input type="number" name="quota"> <br> <br>  	
			<input type="submit" value="Submit">	
			</form>
		</div>
	</div>

	<?php
		$stream = $quota = "";		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$stream = $_POST["stream"];
			$quota = $_POST["quota"];

			//echo "\nStream = $stream \nQuota = $quota \n";

			$result = mysqli_query($conn, "UPDATE quota SET stream_quota = $quota WHERE stream_code = '$stream';");
			//echo $result;	
			if ($result == 1) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			
		}
	?>


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
