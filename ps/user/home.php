<!DOCTYPE html>

<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE) {
		header("location: ../login.php");
	}
	// IF ADMIN, REDIRECT TO ADMIN PAGE
	if ($_SESSION['username'] == "admin") {
		header("location: ../admin/admin.php");
	}
	include ('../config.php');
	










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
	











/************************ SERVER HOME REDIRECT ****************************/	

	//$ip = exec("ifconfig wlp6s0 | grep \"inet \" | awk -F'[: ]+' '{ print $4 }'");
	//echo $ip."<br>";
	$server_ip = exec("ip addr | grep global | awk '{printf $2}' | awk -F/ '{printf $1}'");
	
	$client_ip = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$client_ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$client_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$client_ip=$_SERVER['REMOTE_ADDR'];
	}

	//echo $server_ip = $_SERVER['REMOTE_ADDR'];
	//echo $server_ip;

	echo $_SESSION['server_ip'] = $server_ip;
	echo $_SESSION['client_ip'] = $client_ip;
	if($client_ip == $server_ip) {	
		header("location: server_home.php");
	}
?>







<html>

<title> PS | Home </title>

<head>
	<base href="../../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
       <!------------------------------------sidebar----------------------------------------->
	<?php
		include("$include_path/components/sidebar.php");
	?>
   	<!---------------------------------sidebar------------------------------------->

      <div id="content">

   <h2> Welcome <?php echo $_SESSION['username'] ?>!</h2>

<?php

/** FOR NEW USER - UPDATING 'users' table*/

$username = $_SESSION["username"];
$result_stream = mysqli_query($conn,"SELECT * FROM quota WHERE stream_code = CONCAT(SUBSTRING('$username', 1, 2), SUBSTRING('$username', 5, 2))");
$row_stream = mysqli_fetch_array($result_stream);
$quota1 = $row_stream['stream_quota'];
$stream = $row_stream['stream_name'];

mysqli_query($conn, "insert into `users` (`username`, `stream`, `quota`)  Select '$username', '$stream', '$quota1'  Where not exists(select * from users where `username`='$username')");


?>
<div class="home-box">
	<div class="logout" style="float:right"><a href="ps/logout.php">Logout</a></div>
	<a href="ps/user/home.php" class="home-button "style="background-color: grey;">Home</a>
	<a href="ps/user/uploads.php" class="uploads-button ">View Uploads</a>
	<a href="ps/user/history.php" class="history-button ">View History</a><br />

	<br />

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

	<?php
	//TRIGGERING THE SUBMIT BUTTON AUTOMATICALLY	
	if(isset($_POST['submit']))
	{
	    uploadFile();
	}
	?>

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

      /*if (in_array($file_ext,$extensions)=== false) {
         $errors[]="extension not allowed, please choose a PDF or TXT file.";
      }*/

	// CHECKING FILE SIZE
      if ($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }

	// GETTING THE --JOB ID-- FROM THE DATABASE
	$result_jobid=mysqli_query($conn,"SELECT Job_ID FROM queue ORDER BY Job_ID DESC LIMIT 1");
	$row_jobid = $result_jobid->fetch_assoc();
	$job_id = $row_jobid['Job_ID'] + 1;

	// IF NO ERRORS THEN SAVING THE FILE      
      if (empty($errors)==true) {
		
	// MOVING THE FILE FROM TEMPORARY LOCATION
         move_uploaded_file($file_tmp,"$upload_path"."$job_id-$file_name");
	 $file_path = "$/home/printmaster/uploads/$job_id-$file_name";
	 

	//CONVERTING THE FILE INTO PDF FILE
	 exec("export HOME=/tmp && loffice --convert-to pdf --outdir /home/printmaster/uploads/ '$file_path'");
	
	 $list = glob("/home/printmaster/uploads/$job_id*.pdf");
	 //print_r($list);
	 echo "<br>";
	 foreach ($list as $file) {
		//echo $file;
	 	//$file_ps_path = exec("echo '$file' | awk -F> '{printf $1}'");
	 }
	
	//FINDING THE NO.OF PAGES OF THE FILE
	 $pages = exec("pdftops '$file'  - | grep showpage | wc -l");
	 echo "Number of pages : $pages <br>";
	
	//FETCHING THE USERS TABLE	
	$username = $_SESSION['username'];

	$sql1 = "INSERT INTO queue (`User_name`, `File_Name`, `File_Path`, `Pages`) VALUES ('$username', '$file_name', '$file', $pages)";
	$result3 = mysqli_query($conn, $sql1);
	printf("Final result = %d\n", $result3);

	

	 #echo exec("lp /home/printmaster/images/$file_name");
         echo "File uploaded successfully! <br>";
	
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
		include("$include_path/components/footer.php");
	?>
    <!---------------------------------footer------------------------------------->

  </div><!-- main ends here -->
</body>

</html>
