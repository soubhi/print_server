<!DOCTYPE html>

<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE) {
		header("location: login.php");
	}
	// IF ADMIN, REDIRECT TO ADMIN PAGE
	if ($_SESSION['username'] == "admin") {
		header("location: admin.php");
	}
	include ('config.php');
	
?>

<html>

<title> Home </title>

<head>
	<base href="/ailab/" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps-new/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</style>
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

   <h2> Welcome <?php echo $_SESSION['username'] ?>!</h2>

<?php

/** FOR NEW USER - UPDATING 'users' table**/

$username = $_SESSION["username"];
//echo "$username <br>";
$result_stream = mysqli_query($conn,"SELECT * FROM quota WHERE stream_code = CONCAT(SUBSTRING('$username', 1, 2), SUBSTRING('$username', 5, 2))");
$row_stream = mysqli_fetch_array($result_stream);
//echo "$row_stream[0] <br>";
$quota1 = $row_stream['stream_quota'];
$stream = $row_stream['stream_name'];
//echo "$quota1<br>";
//echo "$stream<br>";

mysqli_query($conn, "insert into `users` (`username`, `stream`, `quota`)  Select '$username', '$stream', '$quota1'  Where not exists(select * from users where `username`='$username')");

?>
<div class="home-box">
	<div class="logout" style="float:right"><a href="ps-new/logout.php">Logout</a></div>
	<a href="ps-new/home.php" class="home-button "style="background-color: grey;">Home</a>
	<!--<a href="ps-new/usr_uploads.php" class="uploads-button ">View Uploads</a>-->
	<a href="ps-new/usr_history.php" class="history-button ">View History</a><br />

	<br />

	<!--<button style="display:block;width:120px; height:30px;" onclick="document.getElementById('getFile').click()">Your text here</button>
	<input type='file' id="getFile" style="display:none">-->

	<!--<form action="" method="POST" enctype="multipart/form-data">
		<input type="submit" value="Upload" style="display:none" id="submit"/>
		<!--- UPLOAD BUTTON ----
		<div class="upload-btn-wrapper">
		  <button class="btn">Select file to Upload</button>
		  <input type="file" name="image" onchange="document.getElementById('submit').click()"/>
		</div>
		<!---------------------
	</form>

	<br />-->

	You can print in this page <br />

	<?php $ip = exec("ifconfig wlp6s0 | grep \"inet \" | awk -F'[: ]+' '{ print $4 }'");
	echo $ip."<br>";

	$server_ip = $_SERVER['REMOTE_ADDR'];
	echo $server_ip;

	?>
	<!--<form name="frm" action="a3 - Copy.php" method="post" enctype="multipart/form-data"> 
	    <input type="submit" name="submitFile" style="display:none" id="submit">
	    <input type="file" name="uploadFile" onchange="document.getElementById('submit').click()">
	</form>-->

	<?php
	//TRIGGERING THE SUBMIT BUTTON AUTOMATICALLY	
	if(isset($_POST['submit']))
	{
	    uploadFile();
	}
	?>
	<!--<div class = "files-list" style ="display: inline">
		Uploaded Files :
		<ul>
		<?php 
		$username = $_SESSION["username"];
		$list = glob("/home/printmaster/uploads/$username*");
		//print_r($list);

		foreach ($list as $file) : 
	    		//echo "$file <br>";?>
			<li><a href="<?php echo $file ?>"><?php echo exec("echo $file | awk -F- '{printf $2}'")?></a></li>
		<?php 
		 endforeach 
		?>

		</ul>
	 </div> -->
		Select Jobs to print.<br />
		<form action="ps-new/server_home.php" method="post">	
		<table>
		<thead>
		<tr>
			<th> Select</th>
			<th> Job ID </th>
			<th> File Name </th>
			<th> Pages </th>
			<th> Time and date of Upload </th>
		</tr>
		</thead>

		<tbody>
		<?php
			$result_uploads = mysqli_query($conn,"SELECT * FROM queue where `Status` = \"not-printed\" AND `User_name`= '$username'");
			while($row_uploads = mysqli_fetch_assoc($result_uploads)) : ?>
			<tr>
			<td><input type="checkbox" name="formDoor[]" value="<?php echo $row_uploads['Job_ID']; ?>" /></td>
			<td><?php echo $row_uploads['Job_ID']; ?></td>
			<td><?php echo $row_uploads['File_Name'] ?></td>
			<td><?php echo $row_uploads['Pages'] ?></td>
			<td><?php echo $row_uploads['Uploaded_Time'] ?></td>
			</tr>
		<?php endwhile ?>
		</tbody>
		
		</table>
		<input type="submit" name="printButton" value="Print Job(s)" id="print-button" style=""/>
		<input type="submit" name="cancelButton" value="Cancel Job(s)" id="cancel-button" style=""/>
		</form>	 

		<br>
	

</div>
<!--
<?php

// AFTER GETIING THE FILE FROM USER
if (isset($_FILES['image'])) {

	// SETTING UP VARIABLES
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
	// CHECKING THE FILE EXTENSION
      $extensions= array("pdf", "txt");

      if (in_array($file_ext,$extensions)=== false) {
         $errors[]="extension not allowed, please choose a PDF or TXT file.";
      }

	// CHECKING FILE SIZE
      if ($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }

	// GETTING THE --JOB ID-- FROM THE DATABASE
	$result_jobid=mysqli_query($conn,"SELECT Job_ID FROM queue ORDER BY Job_ID DESC LIMIT 1");
	$row_jobid = $result_jobid->fetch_assoc();
	#echo "Result jobid = $row3['Job_ID']";
	#echo "<br>";
	#printf("\nJob id =  %d \n", $row3['Job_ID']);
	$job_id = $row_jobid['Job_ID'] + 1;
	#echo "<br> new job id = $job_id <br>";

	// IF NO ERRORS THEN SAVING THE FILE      
      if (empty($errors)==true) {
		// MOVING THE FILE FROM TEMPORARY LOCATION
	
         move_uploaded_file($file_tmp,"/home/printmaster/uploads/"."$job_id-$file_name");
	 
	 $file_path = "/home/printmaster/uploads/$job_id-$file_name";
	 $file_ps = exec("loffice --convert-to pdf --outdir /home/printmaster/uploads/ $file_path");
	 
	 //rename("$file_ps","/home/printmaster/uploads/"."$file_ps");
	 //$file_path_ps = "/home/printmaster/uploads/$file_ps";
	//FINDING THE NO.OF PAGES OF THE FILE
	 $pages = exec("pdftops $file_path  - | grep showpage | wc -l");
	 echo "Number of pages : $pages <br>";
	
	//FETCHING THE USERS TABLE	
	$username = $_SESSION['username'];
	/*$result1 = mysqli_query($conn, "SELECT * from users WHERE username = '$username'");
	$row1 = $result1->fetch_assoc();

	// GETTING --USER ID-- FROM DATABASE
	$user_id = $row1['id'];
	#echo "dub user id = $user_id <br>";

	//CHECKING IF THE USER HAS EXCEEDED HIS LIMIT
	$result2 = mysqli_query($conn, "SELECT SUM(Pages) FROM queue WHERE Status = 'not-printed' AND User_ID = '$user_id'");
	$row2 = $result2->fetch_assoc();
	$not_printed = $row2['SUM(Pages)'];
	echo "not printed :$not_printed <br>";
	
	$nop = $row1['nop'];
	if ($nop < ($pages+$not_printed)) {
		echo "Your qouta limit has been exceeded";
		exit;
	}

	// GETTING THE --JOB ID-- FROM THE DATABASE
	$result_jobid=mysqli_query($conn,"SELECT Job_ID FROM queue ORDER BY Job_ID DESC LIMIT 1");
	$row_jobid = $result_jobid->fetch_assoc();
	#echo "Result jobid = $row3['Job_ID']";
	#echo "<br>";
	#printf("\nJob id =  %d \n", $row3['Job_ID']);
	$job_id = $row_jobid['Job_ID'] + 1;
	#echo "<br> new job id = $job_id <br>";


	$sql1 = "INSERT INTO queue (`Job_ID`, `User_name`, `File_Name`, `File_Path`, `Pages`) VALUES ($job_id, '$user_id', '$file_name', '$file_path', $pages)";
	$result3 = mysqli_query($conn, $sql1);
	printf("Final result = %d\n", $result3);*/

	$sql1 = "INSERT INTO queue (`User_name`, `File_Name`, `File_Path`, `Pages`) VALUES ('$username', '$file_name', '$file_path', $pages)";
	$result3 = mysqli_query($conn, $sql1);
	printf("Final result = %d\n", $result3);

	

	 #echo exec("lp /home/printmaster/images/$file_name");
         echo "File uploaded successfully! <br>";
	 #echo exec("lp $file_path");
	 #mysqli_query($db, "UPDATE queue SET `Status`=\"printed\" WHERE `Job_ID` = $jobid");
	//unset($_FILES['image']);
	
	
      } else {
         print_r($errors[0]);
      }
	echo "<meta http-equiv='refresh' content='0'>";
	//header("location: home.php");
   }
?>-->

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

<?php

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
	echo $i;
	echo $aDoor."<br>";
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
	echo exec("lp $file_path");
	#echo date("d/m/Y") ."  ".date("H:i:s");
	
	$time = date("d-m-Y h:i:sa");
	
	echo $time;
	mysqli_query($conn, "UPDATE queue SET `Status`=\"printed\" WHERE `Job_ID` = $job_id");
	mysqli_query($conn, "UPDATE queue SET `Printed_Time` = '$time' WHERE `Job_ID` = $job_id");

	#-------UPDATING THE NO. OF PRINTS LEFT--------------
	$result_nop = mysqli_query($conn,"SELECT `quota` FROM users WHERE `username`='$user_id' ");
	$row_nop = $result_nop->fetch_assoc();
	//echo $row3['quota'];
	$nop = $row_nop['quota']-$pages;
	//echo $nop;
	mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id' ");
	
    }

	echo "<meta http-equiv='refresh' content='0'>";
	;
  }
//} else if ($_POST['formSubmit'] == 'Cancel Job(s)') {

}else if (isset($_POST['cancelButton'])) {
    echo "Cancell";
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
	echo $i;
	echo $aDoor."<br>";
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
	#echo date("d/m/Y") ."  ".date("H:i:s");
	
	//$time = date("d-m-Y h:i:sa");
	
	//echo $time;
	mysqli_query($conn, "UPDATE queue SET `Status`=\"cancelled\" WHERE `Job_ID` = $job_id");
	mysqli_query($conn, "UPDATE queue SET `Printed_Time` = \"-\" WHERE `Job_ID` = $job_id");
	
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
} else {
    //invalid action!
}

  
?>

