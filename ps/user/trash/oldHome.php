<!DOCTYPE html>

<?php
	// DISPLAY ERRORS
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

	// SETTING UP THINGS
	include ('../config.php');
	$include_path = "../..";
	$use_page="TRUE";
	

/**************** QUOTA RENEWAL *****************/
quotaRenewal($conn);

function quotaRenewal($conn)
{
	$username = $_SESSION["username"];
	
	// CURRENT TIME
	$curr_date = time();
	
	// RENEWAL TIME
	$query = "SELECT `renewal_date` FROM `users` WHERE `username`='$username'";
	$result = mysqli_query($conn, $query);
	//echo "Result = ". $result. "<br>";
	//printf("Final result = %d\n", $result); echo "<br>";
	$row = $result->fetch_assoc();
	$ren_date = $row['renewal_date'];
	//echo "<br>". $curr_date. "<br>". $ren_date; echo "<br>";
	
	// CHECK AND UPDATE THE QUOTA
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

		// QUOTA
		$id = $username;
		if (preg_match('/mc..me../', "$id") | preg_match('/..mcme../', "$id")) {
			$streamcode = "mcme";
		}
		elseif (preg_match('/mc..mc../', "$id") | preg_match('/..mcmc../', "$id")) {
			$streamcode = "mcmc";
		}
		elseif (preg_match('/mc..mt../', "$id") | preg_match('/..mcmt../', "$id")) {
			$streamcode = "mcmt";
		}
		$quota = mysqli_query($conn, "SELECT stream_quota FROM quota WHERE stream_code = '$streamcode'")->fetch_assoc()['stream_quota'];
		echo "<br>Quota = ".$quota;

		// RENEWAL TIME
		$result = mysqli_query($conn, "UPDATE `users` SET `renewal_date`=$new_ren_date,`quota`=$quota WHERE `username`='$username'");
		/*		
		printf("Final result = %d\n", $result); echo "<br>";
		if ($result) 
			echo "SUCCESSFUL!". "<br>";
		else 
			echo "Not Successful". "<br>";
		*/
	}
}

/************************ SERVER HOME REDIRECT ****************************/		
	$client_ip = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		$client_ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
		$client_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else {
		$client_ip=$_SERVER['REMOTE_ADDR'];
	}
	
	if (ipCheck($client_ip, $configVar_net, $configVar_mask)) {
		$var_printOption == 'TRUE';
		header("location: server_home.php");
	}

function ipCheck ($IP, $net, $mask) { 
        $ip_net = ip2long ($net);
        $ip_mask = ~((1 << (32 - $mask)) - 1);
        $ip_ip = ip2long($IP);
        $ip_ip_net = $ip_ip & $ip_mask;

        if ($ip_ip_net == $ip_net)
                return 1;
        else
                return 0;
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

	<!------------------------------------heading---------------------------------------->
	<?php
		include("$include_path/components/heading.php");
	?>
	<!---------------------------------end of heading------------------------------------>

	<!------------------------------------navigation-bar---------------------------------------->
	<?php
		include("$include_path/components/nav-bar.php");
	?>
	<!---------------------------------navigation-bar------------------------------------>

</div> <!-- header ends here --> 



<div id="site_content">


	<!--
	<!------------------------------------sidebar----------------------------------------->

	<div class="sidebar">

	<h1>How to Use</h1>
	<h4>Steps (just briefly)</h4>
	<ul>
		<li>First login (with NIS). </li>
		<li>Then you can select the files to upload. </li>
		<li>Once the upload is done go to print server and take the printout there. </li>
		<a>Read more</a>
	</ul>

	</div>

	<!---------------------------------sidebar------------------------------------->


	<!-----------------------------main site content------------------------------------->
	<div id="content">
	-->
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

	<form action="" method="POST" enctype="multipart/form-data">
		<input type="submit" value="Upload" style="display:none" id="submit"/>
		<!--- UPLOAD BUTTON -->
		<div class="upload-btn-wrapper">
			<button class="btn">Select file to Upload</button>
			<input type="file" name="uploadFile" onchange="document.getElementById('submit').click()"/>
		</div>
		<!--
		<input type="file" name="uploadFile" onchange="document.getElementById('submit').click()"/>
		<input type="submit" value="Upload" id="submit"/>
		-->
	</form>
</div>

<?php

// AFTER GETIING THE FILE FROM USER
if (isset($_FILES['uploadFile'])) {
	// SETTING UP VARIABLES
	$errors= array();
	$file_name = $_FILES['uploadFile']['name'];
	$file_size =$_FILES['uploadFile']['size'];
	$file_tmp =$_FILES['uploadFile']['tmp_name'];
	$file_type=$_FILES['uploadFile']['type'];
	$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	
	// CHECKING THE FILE EXTENSION
	$extensions= array("pdf", "txt", "doc ", "docs", "odt", "xls", "xlsx", "ods", "ppt", "pptx", "rtf");

	if (in_array($file_ext,$extensions)=== false) {
		$errors[]="File type not supported!";
	}     	

	// CHECKING FILE SIZE
	if ($file_size > 20971520) {
		$errors[]='File must be less than 20 MB';
	}

	// GETTING THE --JOB ID-- FROM THE DATABASE
	$result_jobid=mysqli_query($conn, "SELECT Job_ID FROM queue ORDER BY Job_ID DESC LIMIT 1");
	$count = mysqli_num_rows($result_jobid);
	if ($count == 0) {
		$job_id = 1;
	}
	else {	
		$row_jobid = $result_jobid->fetch_assoc();
		$job_id = $row_jobid['Job_ID'] + 1;
	}

	// IF NO ERRORS THEN SAVING THE FILE      
	if (empty($errors)==true) {
		
		// MOVING THE FILE FROM TEMPORARY LOCATION
		move_uploaded_file($file_tmp,"$configVar_uploadPath$job_id-$file_name");
		$file_path = "$configVar_uploadPath"."$job_id-$file_name";
	 

		//CONVERTING THE FILE INTO PDF FILE
		exec("export HOME=/tmp && loffice --convert-to pdf --outdir $configVar_uploadPath '$file_path'");
	
		$list = glob("$configVar_uploadPath$job_id*.pdf");
		//print_r($list);
		echo "<br>";
		foreach ($list as $file) {
			echo $file;
			//$file_ps_path = exec("echo '$file' | awk -F> '{printf $1}'");
		}
	
		//FINDING THE NO.OF PAGES OF THE FILE
		$image = new Imagick();
		$image->pingImage("$file");
		echo $image->getNumberImages();
		//$pages = exec("pdftops '$file'  - | grep showpage | wc -l");
		//echo "Number of pages : $pages <br>";
	
		//FETCHING THE USERS TABLE	
		$username = $_SESSION['username'];

		$sql = "INSERT INTO queue (`User_name`, `File_Name`, `File_Path`, `Pages`) VALUES ('$username', '$file_name', '$file', $pages)";
		$result = mysqli_query($conn, $sql);
		printf("Final result = %d\n", $result);

		echo "File uploaded successfully! <br>";
	
		unset($_FILES['uploadFile']);

	}
	else {
		?> <script> alert("<?php print_r($errors[0]); ?>"); </script> <?php
	}
	
	//echo "<meta http-equiv='refresh' content='0'>";
	//header("location: home.php");
}

?>


	<!--
	</div><!-- content ends here -->
	<!-----------------------------main site content------------------------------------->
	-->



</div><!-- site_content ends here -->




	<!------------------------------------footer---------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
	<!---------------------------------footer------------------------------------>


</div><!-- main ends here -->

</body>
</html>
