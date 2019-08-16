<!DOCTYPE html>

<?php
	// DISPLAY ERRORS
	ini_set('display_errors', "log.txt");
	ini_set('display_startup_errors', "log.txt");
	error_reporting(E_ALL);
	ini_set("log_errors", 1);
	ini_set("error_log", "error.log");
	//error_log( "Hello, errors!" );

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE) {
		header("location: ../");
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
		if ($ren_time == "1month") {
			//echo "TRUE"; echo "<br>";
			$new_ren_date = mktime(0, 0, 0, date("m") + 1, 1, date("Y"));
		} 
		elseif ($ren_time = "1week") {
			//echo "FALSE"; echo "<br>";
			$new_ren_date = strtotime("next Monday");
		}			
		//echo "Old renewal date is " . date("Y-m-d h:i:sa", $ren_date); echo "<br>";
		//echo "New renewal date is " . date("Y-m-d h:i:sa", $new_ren_date); echo "<br>";

		// QUOTA
		$id = $username;

		// GETTING STREAM/QUOTA CODE
		$result = mysqli_query($conn, "SELECT * FROM quota");
		while($row = mysqli_fetch_assoc($result)) {
			$regExp = $row['reg_exp'];
			//echo "Reg. Exp.	= ".$regExp."<br>";
			if (preg_match("$regExp", "$id")) {
				$streamquota = $row['stream_quota'];
				//echo "Stream quota = ".$streamquota."<br>";
				break;
			}
		}
		/*
		if (preg_match('/mc..me../', "$id") | preg_match('/..mcme../', "$id")) {
			$streamcode = "mcme";
		}
		elseif (preg_match('/mc..mc../', "$id") | preg_match('/..mcmc../', "$id")) {
			$streamcode = "mcmc";
		}
		elseif (preg_match('/mc..mt../', "$id") | preg_match('/..mcmt../', "$id")) {
			$streamcode = "mcmt";
		}

		// GETTING THE QUOTA
		$quota = mysqli_query($conn, "SELECT stream_quota FROM quota WHERE stream_code = '$streamcode'")->fetch_assoc()['stream_quota'];
		echo "<br>Quota = ".$quota;
		*/

		// UPDATING RENEWAL TIME RENEWAL TIME
		$result = mysqli_query($conn, "UPDATE `users` SET `renewal_date`=$new_ren_date,`quota`=$streamquota WHERE `username`='$username'");
		/*		
		printf("Final result = %d\n", $result); echo "<br>";
		if ($result) 
			echo "SUCCESSFUL!". "<br>";
		else 
			echo "Not Successful". "<br>";
		*/
	}
}


/** FOR NEW USER - UPDATING 'users' table**/

$username = $_SESSION["username"];
echo "$username <br>";
$result_stream = mysqli_query($conn, "SELECT * FROM quota");
		while($row_stream = mysqli_fetch_assoc($result_stream)) {
			$regExp = $row_stream['reg_exp'];
			//echo "Reg. Exp.	= ".$regExp."<br>";
			if (preg_match("$regExp", "$username")) {

				$quota1 = $row_stream['stream_quota'];
				$stream = $row_stream['stream_name'];
			}
		}
echo "$quota1<br>";
echo "$stream<br>";

echo $r = mysqli_query($conn, "insert into `users` (`username`, `stream`, `quota`, `renewal_date`)  Select '$username', '$stream', '$quota1', '' Where not exists(select * from users where `username`='$username')");


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
		$var_printOption = 'TRUE';
		//header("location: server_home.php");
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

	// CANCEL JOBS
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['cancelButton'])) {
			$jobsList = $_POST['cancelJobsList'];
			cancelJobs($conn, $jobsList);
			//echo "<meta http-equiv='refresh' content='0'>";
			//header("location: uploads.php");		
		} // END IF - ISSET CANCELBUTTON
		if (isset($_POST['printButton'])) {
			$job_id = $_POST['printButton'];
			//echo "Job ID = ".$job_id."<br>";

			// RETRIEVING JOB INFO
			$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id ");
			$row = mysqli_fetch_assoc($result);
			$user_id = $row['User_name'];
			$file_path = $row['File_Path'];
			$pages = $row['Pages'];

			unset($result);
			// RETRIEVING QUOTA
			$result = mysqli_query($conn, "SELECT `quota` FROM users WHERE `username`='$user_id'");
			$row = $result->fetch_assoc();	
			$quota = $row['quota'];

			// CHECKING QUOTA
			if ($pages > $quota) {
				echo "<script> alert(\"Sorry, not enough quota!\");</script>";
			}
			else {
	
			// PRINTING THE JOB
			$printing = mysqli_query($conn, "SELECT value FROM utility WHERE name = 'printing'")->fetch_assoc()['value'];
			if ($printing != 'TRUE') {
				echo "<script> alert(\"Printer currently unavailable, please try again later!\");</script>";
			}
			else {
				echo exec("lp $file_path");
			
				// UPDATING DB
				mysqli_query($conn, "UPDATE queue SET `Status`=\"printed\",`Print_Time` = NOW() WHERE `Job_ID` = $job_id");

				// UPDATING THE QUOTA
				$nop = $quota - $pages;
				mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id'");
			}
		
			}

			//header("location: uploads.php");

		} // END IF - ISSET PRINTBUTTON


		// AFTER GETIING THE FILE FROM USER
		if (isset($_FILES['uploadFile'])) {
			if (!uploadFiles($conn, $configVar_uploadPath)) {
				echo "<script> alert(\"File upload Unsuccessful!\");</script>";
			}
			else {
				echo "<script> alert(\"File upload Successful!\");</script>";
			}
		} // END IF - ISSET UPLOADFILE


	} // END IF - SERVER REQ. METHOD POST



function uploadFiles($conn, $configVar_uploadPath) {
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
		
		$username = $_SESSION['username'];
	
		// MOVING THE FILE FROM TEMPORARY LOCATION
		if (!move_uploaded_file($file_tmp,"$configVar_uploadPath"."$job_id-$file_name")) {
			error_log("User: $username - Moving uploaded file error!");
			return false;
		}
		$file_path = "$configVar_uploadPath"."$job_id-$file_name";
	 

		//CONVERTING THE FILE INTO PDF FILE
		$exec_result = exec("export HOME=/tmp && loffice --convert-to pdf --outdir $configVar_uploadPath '$file_path'", $exec_output, $exec_return);
		if ($exec_return != 0) {
			error_log("User: $username - Exec error! Return val = $exec_return");
			return false;
		}
		//error_log("User: $username - Exec error - $exec_output[0]! Return val = $exec_return Exec result = $exec_result");
		$list = glob("$configVar_uploadPath"."$job_id*.pdf");
		//print_r($list);
		echo "<br>";
		foreach ($list as $file) {
			//echo $file;
			//$file_ps_path = exec("echo '$file' | awk -F> '{printf $1}'");
		}
	
		//FINDING THE NO.OF PAGES OF THE FILE
		//$image = new Imagick();
		//$image->pingImage("$file");
		//echo $image->getNumberImages();
		$pages = exec("pdftops '$file'  - | grep showpage | wc -l");
		//echo "Number of pages : $pages <br>";
	
		//FETCHING THE USERS TABLE	
		$username = $_SESSION['username'];
		
		$result = mysqli_query($conn, "SELECT * FROM quota");
		while($row = mysqli_fetch_assoc($result)) {
			$regExp = $row['reg_exp'];
			//echo "Reg. Exp.	= ".$regExp."<br>";
			if (preg_match("$regExp", "$username")) {
				$streamname = $row['stream_name'];
				$streamcode = $row['stream_code'];
				//echo "Stream quota = ".$streamquota."<br>";
				break;
			}
		}

		$sql = "INSERT INTO queue (`User_name`, `File_Name`, `File_Path`, `Pages`,`User_stream`) VALUES ('$username', '$file_name', '$file', $pages, '$streamcode')";
		$result = mysqli_query($conn, $sql);
		//printf("Final result = %d\n", $result);

		//echo "File uploaded successfully! <br>";
		if (!$result) {
			error_log("User: $username - Error updating query - ".mysqli_error($conn));
			return false;
		}
		unset($_FILES['uploadFile']);
		
		return true;

	}
	else {
		?> <script> alert("<?php print_r($errors[0]); ?>"); </script> <?php
	}
	
	//echo "<meta http-equiv='refresh' content='0'>";
	//header("location: home.php");

} // END IF - UPLOAD FILE - FUNCTION


/* CODE FOR PRINTING JOBS
      		$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id");
		$row = $result->fetch_assoc();
		$user_id = $row['User_name'];
		$file_path = $row['File_Path'];
		$pages = $row['Pages'];
		echo $file_path."<br>";
		echo $user_id."<br>";
		echo $pages;
		//echo exec("lp $file_path");
		#echo date("d/m/Y") ."  ".date("H:i:s");
	
		//$time = date("d-m-Y h:i:sa");
	
		//echo $time;

	/*$result_dummy =mysqli_query($conn,"SELECT * FROM queue WHERE `Job_ID` = $job_id");
	$row_dummy = $result_dummy->fetch_assoc();
	echo "<br> printed time is..".$row_dummy['Printed_Time']."<br>";

	/*-------UPDATING THE NO. OF PRINTS LEFT--------------
	$result3 = mysqli_query($conn,"SELECT `quota` FROM users WHERE `username`='$user_id' ");
	$row3 = $result3->fetch_assoc();
	//echo $row3['quota'];
	$nop = $row3['quota']-$pages;
	//echo $nop;
	mysqli_query($conn, "UPDATE users SET `quota`= $nop WHERE `username` = '$user_id' ");
	
	}
*/
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

	<style>
	th:nth-child(3), td:nth-child(3) {
	        width:40%;
	}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
  		$("#please_wait").hide();
		$("#submit").click(function(){
			$("#please_wait").show();
		});
	});
	</script>

</head>

<body>

<div id="main">

<div id="header">

	<!------------------------------------heading----------------------------------------->
	<?php
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


	<!-----------------------------main site content------------------------------------->
	<h2> Welcome <?php echo $_SESSION['username'] ?>!</h2>
<?php	$username = $_SESSION['username'];
	$quota =  mysqli_query($conn, "SELECT quota FROM users WHERE username = '$username'")->fetch_assoc()['quota']; 
	$renewal_date =  mysqli_query($conn, "SELECT renewal_date FROM users WHERE username = '$username'")->fetch_assoc()['renewal_date']; 
?>
	<span style="font-size:18px; color:maroon;"> Quota left : </span> <?php echo $quota; ?><br><br>
	<span style="font-size:18px; color:maroon;"> Renewal time : </span> <?php echo date("d M Y", $renewal_date); ?><br>
	
<br>
<div class="home-box">
	<div class="logout" style="float:right"><a href="ps/logout.php">Logout</a></div>
	<!--
	<a href="ps/user/home.php" class="home-button "style="background-color: grey;">Home</a>
	<a href="ps/user/uploads.php" class="uploads-button ">View Uploads</a>
	<a href="ps/user/history.php" class="history-button ">View History</a><br />
	-->
	<!-- FILE UPLOAD -->
	<form action="" method="POST" enctype="multipart/form-data">
		<input type="submit" value="Upload" style="display:none" id="submit"/>
		<!--- UPLOAD BUTTON -->
		<div class="upload-btn-wrapper">
			<button class="btn">Select file to Upload</button>
			<input type="file" name="uploadFile" onchange="document.getElementById('submit').click()"/>
		</div>
		&nbsp &nbsp &nbsp<img id="please_wait" src="ps/user/please_wait.gif" height="63px">
	</form>
</div>
<br><br>
	
	<!-- JOB CANCEL/PRINT -->
	<span style="font-size:30px; color:maroon;"> Uploads: </span> <br>
	
	<form action="ps/user/home.php" method="post">	
	<table>
		<thead>
		<tr>
		<th> Select </th>
		<th> Job ID </th>
		<th> File Name </th>
		<th> Pages </th>
		<th> Date and Time of Upload </th>
	<?php if (isset($var_printOption) && $var_printOption == 'TRUE') : ?>
		<th> Print </th>
	<?php endif ?>
		</tr>
		</thead>

		<tbody>	

<?php
$username = $_SESSION["username"];
$result_uploads = mysqli_query($conn, "SELECT * FROM queue WHERE User_name = '$username' AND Status = 'not-printed'");
$uploads_count = mysqli_num_rows($result_uploads);
$result_uploads_desc = mysqli_query($conn, "SELECT * FROM queue WHERE User_name = '$username' AND Status = 'not-printed' ORDER BY Job_ID DESC LIMIT $uploads_count");
				
while($row_uploads = mysqli_fetch_assoc($result_uploads_desc)) : ?>
		<tr>
		<td><input type="checkbox" name="cancelJobsList[]" value="<?php echo $row_uploads['Job_ID']; ?>" /></td>
		<td><?php echo $row_uploads['Job_ID']; ?></td>
		<td><?php echo $row_uploads['File_Name'] ?></td>
		<td><?php echo $row_uploads['Pages'] ?></td>
		<td><?php echo $row_uploads['Uploaded_Time'] ?></td>
	<?php if (isset($var_printOption) && $var_printOption == 'TRUE') : ?>
		<td><input type="submit" name="printButton" value="<?php echo $row_uploads['Job_ID']; ?>" id="print-button" style=""/></td>
	<?php endif ?>
		</tr>
<?php endwhile ?>		
		</tbody>

	</table>
		<input type="submit" name="cancelButton" value="Cancel Job(s)" id="cancel-button" style=""/>
	</form>	


	<!-----------------------------main site content------------------------------------->



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

function cancelJobs($conn, $jobsList) {
	if(empty($jobsList)) {
		echo("<script> alert(\"You didn't select any jobs to cancel.\"); </script>");
	} 
	else {
		$N = count($jobsList);
		//echo("You selected $N jobs(s) to cancel : "."<br>");

		for($i=0; $i < $N; $i++) {	
			$job_id = $jobsList[$i];
			//echo($job_id  . " ");

			$result = mysqli_query($conn, "UPDATE queue SET `Status`=\"cancelled\" WHERE `Job_ID` = $job_id");
			// RESULT IS '1' ON SUCCESSFUL EXECUTION OF QUERY
			//echo "Result = ".$result."<br>";
		}
	}
}

?>
