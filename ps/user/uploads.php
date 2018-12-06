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

<title> Home </title>

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

   <h2> Welcome <?php echo $_SESSION['username'] ?>!</h2>

	<div class="logout" style="float:right"><a href="ps/logout.php">Logout</a></div>
	<a href="ps/user/home.php" class="home-button ">&laquo; Home</a>
	<a href="ps/user/uploads.php" class="uploads-button">View Uploads</a>
	<a href="ps/user/history.php" class="history-button ">View History</a><br />
	<br />
	Upload History :
	<!--<div class = "upload-hist-box">-->
	
	<form action="ps/user/uploads.php" method="post">	
	<table>
		<thead>
		<tr>
		<th> Select </th>
		<th> Job ID </th>
		<th> File Name </th>
		<th> Pages </th>
		<th> Date and Time of Upload </th>
		</tr>
		</thead>

		
		<tbody>	
		<?php
		$username = $_SESSION["username"];
	
		$result_uploads = mysqli_query($conn, "SELECT * FROM queue WHERE User_name = '$username' AND Status = 'not-printed'");
		$uploads_count = mysqli_num_rows($result_uploads);
		$result_uploads_desc = mysqli_query($conn,"SELECT * FROM queue WHERE User_name = '$username' AND Status = 'not-printed' ORDER BY Job_ID DESC LIMIT $uploads_count");
		echo "-------Not yet printed list-----"."<br>";
				
		while($row_uploads = mysqli_fetch_assoc($result_uploads_desc))	 : ?>
		
			<tr>
			<td><input type="checkbox" name="formDoor[]" value="<?php echo $row_uploads['Job_ID']; ?>" /></td>
			<td><?php echo $row_uploads['Job_ID']; ?></td>
			<td><?php echo $row_uploads['File_Name'] ?></td>
			<td><?php echo $row_uploads['Pages'] ?></td>
			<td><?php echo $row_uploads['Uploaded_Time'] ?></td>
			</tr>
		<?php endwhile ?>		
	</table>
	<input type="submit" name="cancelButton" value="Cancel Job(s)" id="cancel-button" style=""/>
	</form>	
	<br/> 
	<!--</div>-->

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

<?php

if (isset($_POST['cancelButton'])) {
  $aDoor = $_POST['formDoor'];
  if(empty($aDoor)) 
  {
    echo("You didn't select any jobs to cancel.");
  } 
  else 
  {
    $N = count($aDoor);

    echo("You selected $N jobs(s) to cancel : "."<br>");
    for($i=0; $i < $N; $i++)
    {	
	#----UPDATE queue SET `Status`="not-printed";-------	
	#mysqli_query($db, "UPDATE users SET `nop`= 2 WHERE `username` = 'lavanya'");
	//echo $i."dfghjkl;fghjkl;lkjh'<br>";
	//echo $aDoor."<br>";
	$job_id = $aDoor[$i];
        echo($job_id  . " ");
      	$result2=mysqli_query($conn,"SELECT * FROM queue WHERE `Job_ID`=$job_id ");
	$row2 = $result2->fetch_assoc();
	//echo $row2['User_name'];
	$user_id = $row2['User_name'];
	$file_path = $row2['File_Path'];
	$pages = $row2['Pages'];
	echo $file_path."<br>";
	echo $user_id."<br>";
	echo $pages;
	//echo exec("lp $file_path");
	echo "hiiiiii";
	#echo date("d/m/Y") ."  ".date("H:i:s");
	
	//$time = date("d-m-Y h:i:sa");
	
	//echo $time;
	mysqli_query($conn, "UPDATE queue SET `Status`=\"cancelled\" WHERE `Job_ID` = $job_id");
	mysqli_query($conn, "UPDATE queue SET `Printed_Time` = \"-\" WHERE `Job_ID` = $job_id");
	/*$result_dummy =mysqli_query($conn,"SELECT * FROM queue WHERE `Job_ID` = $job_id");
	$row_dummy = $result_dummy->fetch_assoc();
	echo "<br> printed time is..".$row_dummy['Printed_Time']."<br>";

	/*-------UPDATING THE NO. OF PRINTS LEFT--------------
	$result3 = mysqli_query($conn,"SELECT `quota` FROM users WHERE `username`='$user_id' ");
	$row3 = $result3->fetch_assoc();
	//echo $row3['quota'];
	$nop = $row3['quota']-$pages;
	//echo $nop;
	mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id' ");*/
	
    }
	
	echo "<meta http-equiv='refresh' content='0'>";
  }
}
?>
