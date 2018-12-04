<!DOCTYPE html>

<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: login.php");
	}
?>


<?php 
	include("config.php");
	$result = mysqli_query($conn,"SELECT * FROM queue where `Status` = \"not-printed\"");
	$result_array = array();
	
?>
<html>

<title>Settings</title>

<head>
	<base href="/ailab/" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps-new/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div id="main">
     <div id="header">
    <!------------------------------------heading----------------------------------------->
	<?php
		$include_path = "/var/www/html/ailab";
		$use_page="TRUE";
		include("$include_path/components/heading.php");
	?>
   <!---------------------------------end of heading------------------------------------->

   <!------------------------------------navigation-bar----------------------------------------->
	<?php
		$include_path = "/var/www/html/ailab";
		$use_page="TRUE";
		include("$include_path/components/nav-bar.php");
	?>
   <!---------------------------------navigation-bar------------------------------------->

	</div> <!-- header ends here --> 
   <div id="site_content">
       <!------------------------------------sidebar----------------------------------------->
	<?php
		$include_path = "/var/www/html/ailab";
		$use_page="TRUE";
		include("$include_path/components/sidebar.php");
	?>
   	<!---------------------------------sidebar------------------------------------->

      <div id="content">
	<h2> Welcome Admin! </h2>
	 <div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps-new/logout.php">logout</a></div> <br>
		<a href="ps-new/admin.php" class="home-button "style="">Home</a>
		<a href="ps-new/change_quota.php" class="change-quota">Change Quota</a>
		<!--<div class="change-quota"><a href="ps-new/change_quota.php">Change Quota</a></div> <br>-->
		<a href="ps-new/history.php" class="history-button" >View History</a>

		Uploads : <br />
		Select Jobs to print.<br />
		<form action="ps-new/admin.php" method="post">	
		<table>
		<thead>
		<tr>
			<th> Select</th>
			<th> Job ID </th>
			<th> File Name </th>
			<th> Pages </th>
			<th> User Id </th>
			<th> Time and date of Upload </th>
		</tr>
		</thead>

		<tbody>
		<?php while($row = mysqli_fetch_assoc($result)) : ?>
			<tr>
			<td><input type="checkbox" name="formDoor[]" value="<?php echo $row['Job_ID']; ?>" /></td>
			<td><?php echo $row['Job_ID']; ?></td>
			<td><?php echo $row['File_Name'] ?></td>
			<td><?php echo $row['Pages'] ?></td>
			<td><?php echo $row['User_name'] ?></td>
			<td><?php echo $row['Uploaded_Time'] ?></td>
			</tr>
		<?php endwhile ?>
		</tbody>
		
		</table>
		<input type="submit" name="printButton" value="Print Job(s)" id="print-button" style=""/>
		<input type="submit" name="cancelButton" value="Cancel Job(s)" id="cancel-button" style=""/>
		</form>	 

		<br>

		
		<?php

		//if ($_POST['formSubmit'] == 'Print Job(s)') {
		if (isset($_POST['printButton'])) {
		  $aDoor = $_POST['formDoor'];
		  if(empty($aDoor)) 
		  {
		    echo("You didn't select any jobs to print.");
		  } 
		  else 
		  {
		    $N = count($aDoor);

		    echo("You selected $N jobs(s) to print : "."<br>");
		    for($i=0; $i < $N; $i++)
		    {	
			#----UPDATE queue SET `Status`="not-printed";-------	
			#mysqli_query($db, "UPDATE users SET `nop`= 2 WHERE `username` = 'lavanya'");
			echo $i."dfghjkl;fghjkl;lkjh'<br>";
			echo $aDoor."<br>";
			$job_id = $aDoor[$i];
			echo "yuhoooooohello";
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
			echo exec("lp $file_path");
			echo "hiiiiii";
			#echo date("d/m/Y") ."  ".date("H:i:s");
	
			$time = date("d-m-Y h:i:sa");
	
			echo $time;
			mysqli_query($conn, "UPDATE queue SET `Status`=\"printed\" WHERE `Job_ID` = $job_id");
			mysqli_query($conn, "UPDATE queue SET `Printed_Time` = '$time' WHERE `Job_ID` = $job_id");
			$result_dummy =mysqli_query($conn,"SELECT * FROM queue WHERE `Job_ID` = $job_id");
			$row_dummy = $result_dummy->fetch_assoc();
			echo "<br> printed time is..".$row_dummy['Printed_Time']."<br>";

			#-------UPDATING THE NO. OF PRINTS LEFT--------------
			$result3 = mysqli_query($conn,"SELECT `quota` FROM users WHERE `username`='$user_id' ");
			$row3 = $result3->fetch_assoc();
			//echo $row3['quota'];
			$nop = $row3['quota']-$pages;
			//echo $nop;
			mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id' ");
	
		    }

			echo "<meta http-equiv='refresh' content='0'>";
			//header("location: admin.php");
		  }
		//} else if ($_POST['formSubmit'] == 'Cancel Job(s)') {

		}else if (isset($_POST['cancelButton'])) {
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
			echo $i."dfghjkl;fghjkl;lkjh'<br>";
			echo $aDoor."<br>";
			$job_id = $aDoor[$i];
			echo "yuhoooooohello";
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
			/*mysqli_query($conn, "UPDATE queue SET `Printed_Time` = '$time' WHERE `Job_ID` = $job_id");
			$result_dummy =mysqli_query($conn,"SELECT * FROM queue WHERE `Job_ID` = $job_id");
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
			//header("location: admin.php");
		  }
		} else {
		    //invalid action!
		}

		  
		?>

		<!--History:
		<table>
		<tr>
			<th> Job ID </th>
			<th> File Name </th>
			<th> Pages </th>
			<th> User Id </th>
			<th> Time and date of Print </th>
		</tr>
		</table>-->
	 </div>


</div><!-- content ends here -->
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

