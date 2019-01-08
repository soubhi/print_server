<!DOCTYPE html>

<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: login.php");
	}
?>


<?php 
	include("../config.php");
	$result = mysqli_query($conn,"SELECT * FROM queue where `Status` = \"printed\"");
	$result_array = array();
	
?>
<html>

<title> Admin | History </title>

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
      
	<h2> Welcome Admin! </h2>
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="nav-btn" >Change Quota</a>
		<a href="ps/admin/history.php" class="nav-btn" style="background-color: lightblue; color: white;">View History</a>
		<a href="ps/admin/stats.php" class="nav-btn">Statistics</a>

		<br><br>
		History:
		<table>
		<thead>
		<tr>
			<th> Job ID </th>
			<th> File Name </th>
			<th> Pages </th>
			<th> User Id </th>
			<th> Status </th>
			<th> Time and date of Print </th>
		</tr>
		</thead>

		<tbody>
		<?php 
			$result_asce = mysqli_query($conn, "SELECT * FROM  queue WHERE `Status`=\"printed\" OR `Status`=\"cancelled\"");
			$queue_count = mysqli_num_rows($result_asce);
			$result_desc = mysqli_query($conn,"SELECT * FROM queue WHERE `Status`=\"printed\" OR `Status`=\"cancelled\" ORDER BY Job_ID DESC LIMIT $queue_count");			
			while($row = mysqli_fetch_assoc($result_desc)) : ?>
			<tr>
			<td><?php echo $row['Job_ID']; ?></td>
			<td><?php echo $row['File_Name'] ?></td>
			<td><?php echo $row['Pages'] ?></td>
			<td><?php echo $row['User_name'] ?></td>
			<td><?php echo $row['Status'] ?></td>
			<td><?php echo $row['Printed_Time'] ?></td>
			</tr>
		<?php endwhile ?>
		</tbody>
		</table>

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
