<?php


?><!DOCTYPE html>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";

	$result = mysqli_query($conn,"SELECT * FROM queue1 where `Status` = \"not-printed\"");
	$result_array = array();

	$stream = $time = "";		
	/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["selectRange"])) {
			$range = explode(',', $_POST["time"]);
			echo $range[0]."<br>";
			echo $range[1]."<br>";
			echo "\nTime Range = $range\n";
		}
	}*/
	

	
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
				echo "\nStream = $stream\n";
				$time = $_GET["time"];
				echo "\nTime Range = $time\n<br>";
				if ($time == "monthly") {
					echo $year = $_GET["year"];				
				}
				if ($time == "range") {
					echo $sd = $_GET["sd"];
					echo $fd = $_GET["fd"];
					echo "$sd and $fd <br>";
				}
			}
			?>
			<?php
			if($time == 'monthly') {
			
				if($stream == 'All') {
				$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month, count(*) as count from queue where YEAR(Uploaded_Time) = '$year' group by MONTH(Uploaded_Time),MONTHNAME(Uploaded_Time);");
				} else {
				$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month, count(*) as count from queue where User_stream='$stream' AND YEAR(Uploaded_Time) = '$year' group by MONTH(Uploaded_Time),MONTHNAME(Uploaded_Time);");
				}
				while($row=mysqli_fetch_array($result)) {
					echo $row['month']." ".$row['count']."<br>";	
				}
			}
			
			if($time == 'range') {
				if($stream == 'All') {
				$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM queue where Uploaded_Time>='$sd 00:00:01' and Uploaded_Time<='$fd 23:59:59' group by CAST(Uploaded_Time as DATE)");
				} else {
				$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM queue where User_stream = '$stream' AND Uploaded_Time>='$sd 00:00:01' and Uploaded_Time<='$fd 23:59:59' group by CAST(Uploaded_Time as DATE)");
				}
				while($row=mysqli_fetch_array($result)) {
					echo $row['date']." ".$row['count']."<br>";	
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

