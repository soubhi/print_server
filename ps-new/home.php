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
	
/**************** QUOTA RENEWAL *****************/

	$username = $_SESSION["username"];
	$curr_date = time();
	$query = "SELECT `renewal_date` FROM `users` WHERE `username`='$username'";
	$result = mysqli_query($conn, $query);
	//echo "Result = ". $result. "<br>";
	//printf("Final result = %d\n", $result); echo "<br>";
	$row = $result->fetch_assoc();
	$ren_date = $row['renewal_date'];
	//echo "<br>". $curr_date. "<br>". $ren_date; echo "<br>";

	if ($curr_date >= $ren_date) {
		$ren_time = mysqli_query($conn, "SELECT `value` FROM `utility` WHERE `name`='quota-renewal-time'")->fetch_assoc()['value'];
		//echo $ren_time; echo "<br>";
		if ($ren_time == "1 month") {
			//echo "TRUE"; echo "<br>";
			$new_ren_date = mktime(0, 0, 0, date("m") + 1, 1, date("Y"));
		} else {
			if ($ren_time = "1 week") {
				//echo "FALSE"; echo "<br>";
				$new_ren_date = strtotime("next Monday");
			}
		}			
		//echo "Old renewal date is " . date("Y-m-d h:i:sa", $ren_date); echo "<br>";
		//echo "New renewal date is " . date("Y-m-d h:i:sa", $new_ren_date); echo "<br>";
		$result = mysqli_query($conn, "UPDATE `users` SET `renewal_date`=$new_ren_date WHERE `username`='$username'");
		/*		
		printf("Final result = %d\n", $result); echo "<br>";
		if ($result) 
			echo "SUCCESSFUL!". "<br>";
		else 
			echo "Not Successful". "<br>";
		*/
	}
	


	$ip = exec("ifconfig wlp6s0 | grep \"inet \" | awk -F'[: ]+' '{ print $4 }'");
	//echo $ip."<br>";

	$server_ip = $_SERVER['REMOTE_ADDR'];
	//echo $server_ip;

	if($ip == $server_ip) {
		header("location: server_home.php");
	}
?>

<html>

<title> Home </title>

<head>
	<base href="/print/" />
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
	<a href="ps-new/usr_uploads.php" class="uploads-button ">View Uploads</a>
	<a href="ps-new/usr_history.php" class="history-button ">View History</a><br />

	<br />

	<!--<button style="display:block;width:120px; height:30px;" onclick="document.getElementById('getFile').click()">Your text here</button>
	<input type='file' id="getFile" style="display:none">-->

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="submit" value="Upload" style="display:none" id="submit"/>
		<!--- UPLOAD BUTTON ---->
		<div class="upload-btn-wrapper">
		  <button class="btn">Select file to Upload</button>
		  <input type="file" name="image" onchange="document.getElementById('submit').click()"/>
		</div>
		<!--------------------->
	</form>

	<br />

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
	
	

</div>

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
	 echo $file_ps;
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
	unset($_FILES['image']);
	
	
      } else {
         print_r($errors[0]);
      }
	//echo "<meta http-equiv='refresh' content='0'>";
	//header("location: home.php");
   }
?>

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
