<!DOCTYPE html>

<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE) {
		header("location: ../");
	}
	// IF ADMIN, REDIRECT TO ADMIN PAGE
	if ($_SESSION['username'] == "admin") {
		header("location: ../");
	}
	include ('../config.php');
?>

<html>

<title> PS | History </title>

<head>
	<base href="../../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	th:nth-child(2), td:nth-child(2) {
		width:40%;
	}
	
	</style>
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
       

   <h2> Welcome <?php echo $_SESSION['username'] ?>!</h2>
   	<div class="logout" style="float:right"><a href="ps/logout.php">Logout</a></div>
	<a href="ps/user/home.php" class="home-button" style="">&laquo; Home</a>

	<?php
	//IF SERVER HOME PAGE THE IT WILL NOT DISPLAY UPLOAD BUTTON
	if ($_SESSION['client_ip'] != $_SESSION['server_ip']) : ?>
	
	<a href="ps/user/uploads.php" class="nav-btn">View Uploads</a>
	
	<?php endif ?>

	<a href="ps/user/history.php" class="nav-btn" style="background-color: lightblue; color: white;">View History</a><br />
	<br />
	Print History:
	<!--<div class = "print-hist-box">-->
	
	<table>
		<thead>
		<tr>
		<th> Job ID </th>
		<th> File Name </th>
		<th> Pages </th>
		<th> Status</th>
		<th> Date and Time of Print </th>
		</tr>
		</thead>

		<tbody>	
		<?php
		$username = $_SESSION["username"];
		
		$result_printed = mysqli_query($conn, "SELECT * FROM queue WHERE User_name = '$username' AND (`Status`=\"printed\" OR `Status`=\"cancelled\")");
		$hist_count = mysqli_num_rows($result_printed);
		$result_printed_desc = mysqli_query($conn,"SELECT * FROM queue WHERE User_name = '$username' AND (`Status`=\"printed\" OR `Status`=\"cancelled\") ORDER BY Job_ID DESC LIMIT $hist_count");
		echo "-------printed list-----"."<br>";
				
		while($row_printed = mysqli_fetch_assoc($result_printed_desc))	 : ?>

	    <!--echo $row3['Job_ID']." ".$row3['File_Name']."\t".$row3['Pages']."\t".$row3['Time']."<br>";
	    #echo $row3[0]." ".$row3[2]."\t".$row3[4]."\t".$row3[6]."<br>"-->
		
			<tr>
			<td><?php echo $row_printed['Job_ID']; ?></td>
			<td><?php echo $row_printed['File_Name'] ?></td>
			<td><?php echo $row_printed['Pages'] ?></td>
			<td><?php echo $row_printed['Status'] ?></td>
			<td><?php echo $row_printed['Printed_Time'] ?></td>
			</tr>
		<?php endwhile ?>
		</tbody>
		
	</table>
<br/> 
	<!--</div>-->

    </div><!-- site_content ends here -->
    <!------------------------------------footer----------------------------------------->
	<?php
		$include_path = "/var/www/html/ailab";
		$use_page="TRUE";
		include("$include_path/components/footer.php");
	?>
    <!---------------------------------footer------------------------------------->

  </div><!-- main ends here -->
</body>

</html>	

