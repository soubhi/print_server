<!DOCTYPE html>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";

	$stream = $time = "";			
?>


<html>

<title> Admin | Output </title>

<head>
	<base href="../../" />
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
       
	<h2> Welcome Admin! </h2>
	 <div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="nav-btn">Change Quota</a>
		<a href="ps/admin/history.php" class="nav-btn" >View History</a>
		<a href="ps/admin/stats.php" class="nav-btn" style="background-color: lightblue; color: white;">Statistics</a>
	
		<br>
			<span style="font-size:25px; color:maroon;"> Stats: </span> <br><br><br>
			
			<?php
			if (isset($_GET["Check"])) {
				$stream = $_GET["stream"];
				if ($stream != "All") {
					$regExp = mysqli_query($conn, "SELECT reg_exp FROM quota WHERE stream_code = '$stream'")->fetch_assoc()['reg_exp'];
					//echo "<b> regExp </b> = $regExp<br><br>";
					$new_regExp = str_replace("/", "'", "$regExp");
					//echo "<b> new_regExp </b> = $new_regExp<br><br>";
					$streamname = mysqli_query($conn, "SELECT stream_name FROM quota WHERE stream_code = '$stream'")->fetch_assoc()['stream_name'];
					echo "<b> Stream </b> = $streamname<br><br>";
				}
				else {
					echo "<b> Stream </b> = $stream<br><br>";
				}
				$time = $_GET["time"];
				echo "<b> Time Range </b> = $time<br><br>";
				if ($time == "monthly") {
					$year = $_GET["year"];				
				}
				if ($time == "range") {
					$sd = $_GET["sd"];
					$fd = $_GET["fd"];
					echo "<b> Between </b> - $sd and $fd <br><br>";
				}
			}

			if ($time == 'monthly') {
			
				if ($stream == 'All') {
					//$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month, count(*) as count from queue where YEAR(Uploaded_Time) = '$year' group by MONTH(Uploaded_Time),MONTHNAME(Uploaded_Time);");
					$result = mysqli_query($conn,"SELECT MONTHNAME(Print_Time) AS month, SUM(page_count) AS count FROM `queue` WHERE YEAR(Print_Time) = '$year' GROUP BY MONTH(Print_Time),MONTHNAME(Print_Time);");					
				} 
				else {
					//$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month, count(*) as count from queue where User_stream='$stream' AND YEAR(Uploaded_Time) = '$year' group by MONTH(Uploaded_Time),MONTHNAME(Uploaded_Time);");
					$result = mysqli_query($conn,"SELECT MONTHNAME(Print_Time) AS month, SUM(page_count) AS count FROM `queue` WHERE User_name REGEXP $new_regExp AND YEAR(Print_Time) = '$year' GROUP BY MONTH(Print_Time),MONTHNAME(Print_Time);");
				}
				while ($row = mysqli_fetch_array($result)) {
					echo "<b>".$row['month']."</b> - ".$row['count']."<br>";	
				}
			}
			
			if ($time == 'range') {
				if ($stream == 'All') {
					//$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM queue where Uploaded_Time>='$sd 00:00:01' and Uploaded_Time<='$fd 23:59:59' group by CAST(Uploaded_Time as DATE)");
					$result = mysqli_query($conn,"SELECT CAST(Print_Time as DATE) AS date, SUM(page_count) AS count FROM `queue` WHERE Print_Time>='$sd 00:00:01' AND Print_Time<='$fd 23:59:59' GROUP BY CAST(Print_Time as DATE)");
				} 
				else {
					//$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM queue where User_stream = '$stream' AND Uploaded_Time>='$sd 00:00:01' and Uploaded_Time<='$fd 23:59:59' group by CAST(Uploaded_Time as DATE)");
					$result = mysqli_query($conn,"SELECT CAST(Print_Time as DATE) AS date, SUM(page_count) AS count FROM `queue` WHERE User_name REGEXP $new_regExp AND Print_Time>='$sd 00:00:01' AND Print_Time<='$fd 23:59:59' GROUP BY CAST(Print_Time as DATE)");
				}
				while ($row = mysqli_fetch_array($result)) {
					echo "<b> ".$row['date']."</b> - ".$row['count']."<br>";	
				}
			}	
			?>			

	</div>
	
    </div><!-- site_content ends here -->

    <!------------------------------------footer----------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
    <!---------------------------------footer------------------------------------->

  </div><!-- main ends here -->
</body>
</html>

