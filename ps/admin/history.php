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
/*
	th:nth-child(2), td:nth-child(2) {
		width:40%;
	}
*/
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
	<h4> History </h4>
        <!-- ----------------------------admin-navigation-bar-------------------------------------- -->
        <?php
                include("$include_path/ps/admin/admin-nav-bar.php");
        ?>
        <!-- -----------------------admin-navigation-bar----------------------------------->

		<br><br>
		History:
		<table>
		<thead>
		<tr>
			<th width="5%"> Job ID </th>
			<th width="10%"> User Id </th>
			<th width="45%"> File Name </th>
			<th width="10%"> Page Range </th>
			<th width="10%"> Status </th>
			<th width="20%"> Time and date of Print </th>
		</tr>
		</thead>

		<tbody>
		<?php 
			$result_asce = mysqli_query($conn, "SELECT * FROM  queue WHERE `Status`=\"printed\" OR `Status`=\"cancelled\"");
			$queue_count = mysqli_num_rows($result_asce);
			$result_desc = mysqli_query($conn,"SELECT * FROM queue WHERE `Status`=\"printed\" OR `Status`=\"cancelled\" ORDER BY Job_ID DESC LIMIT $queue_count");			
			while($row = mysqli_fetch_assoc($result_desc)) : ?>
			<tr>
			<td width="5%"><?php echo $row['Job_ID']; ?></td>
			<td width="10%"><?php echo $row['User_name'] ?></td>
			<td width="45%"><?php echo $row['File_Name'] ?></td>
			<td width="10%"><?php echo $row['page_range'] ?></td>
			<td width="10%"><?php echo $row['Status'] ?></td>
			<td width="20%"><?php echo $row['Print_Time'] ?></td>
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
