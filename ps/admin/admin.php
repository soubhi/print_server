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
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	// SETTING UP THINGS
	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";
?>
<html>

<title> PS | Admin </title>

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

<!--
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
-->
	<script src="ps/jquery.min.js"></script>
	<script>

	// PAGE REFRESH FUNCTION
	function refreshPage() {
		location.replace("ps/admin/admin.php")
	}

	// PRINT JOB CONFIRM FUNCTION
	var request;
	function printJob(file_path,RANGE_STRING,username,job_id,nop)
	{
		var url = "ps/user/printJob.php?file_path="+file_path+"&RANGE_STRING="+RANGE_STRING+"&username="+username+"&job_id="+job_id+"&nop="+nop;
		if(window.XMLHttpRequest) {
			request=new XMLHttpRequest();
		}
		else if (window.ActiveXObject) {
			request=new ActiveXObject("Microsoft.XMLHTTP");
		}

		try {
			request.onreadystatechange = printJobResult;
			request.open("GET", url, true);
			request.send();
		}
		catch(e) {
			alert("Unable to connect to server");
			return false;
		}
		//refreshPage();
		return true;
	}

	function printJobResult() {
		if (request.readyState == 4) {
			var val = request.responseText;
			document.getElementById('demo').innerHTML=val;
			refreshPage();
		}
	}
	</script>

</head>

<?php
	$var_printOption = 'TRUE';

	/************** SERVER METHODS *******************/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// CANCEL JOBS
		if (isset($_POST['cancelButton'])) {
			$jobsList = $_POST['cancelJobsList'];
			cancelJobs($conn, $jobsList);
			echo "<script> refreshPage();</script>";
			//echo "<meta http-equiv='refresh' content='0'>";
			//header("location: admin.php");
			echo "<script> refreshPage();</script>";		
		} // END IF - ISSET CANCELBUTTON

		// PRINT JOB
		elseif (isset($_POST['printButton'])) {
			//$username = $_SESSION["username"];
			$job_id = $_POST['printButton'];
			//echo "Job id = $job_id <br>";
			//$pages = mysqli_query($conn, "SELECT Pages FROM queue WHERE Job_ID=$job_id")->fetch_assoc()['value'];
			$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id");
			$row = mysqli_fetch_assoc($result);
			$pages = $row['Pages'];
			//echo "<br>Pages = $pages <br>";
			$s = $_POST["pagesRange$job_id"];
			$n = $pages;
			//echo "<br>Pages = $n <br>";
			//echo "String = $s <br>";
			$digit = "[1-9][\d]{0,}";
			$reg4 = "/^(((($digit)|($digit)-($digit)),)*)(($digit)|($digit)-($digit))$/";
			$string = preg_replace('/\s+/', '', $s);
			//echo "String = $string <br>";
			$RANGE_STRING = '';
			$PAGE_COUNT = '';
			if (pagerange($reg4, $string, $n)) {
				//echo $RANGE_STRING;	
				//echo ":VALID:";
				//echo $PAGE_COUNT;
				//echo "String = $username <br>";echo "String = $string <br>";	
				mysqli_query($conn, "UPDATE queue SET `page_range`= '$string',`page_count`=$PAGE_COUNT WHERE `Job_ID`=$job_id");
				//echo "Job ID = ".$job_id."<br>";
				//echo "<script> alert(\"pages = $pages\");</script>";
				// RETRIEVING JOB INFO
				$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id ");
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['User_name'];
				$username = $user_id;
				$file_path = $row['File_Path'];
				$filename = $row['File_Name']; 
				$pages = $row['Pages'];
				$pages = $PAGE_COUNT;

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
						//exec("lp -o page-ranges=$RANGE_STRING $file_pat", $output);
						$nop = $quota - $pages; ?>
						<script>
						if (confirm("<?php echo "Document '$filename'\\nRange = $string\\nTotal Pages = $pages\\nAfter printing quota will be '$nop'"; ?>")) {
							//alert("This shouldn't appear!");
							printJob(<?php echo "\"$file_path\",\"$RANGE_STRING\",\"$username\",\"$job_id\",\"$nop\""; ?>); 
						}
						else {
							//alert("Print Cancelled");
							refreshPage();
	
						} // END IF - confirm() print
						//refreshPage();
						</script>
						<?php

					} // END IF - $printing != 'TRUE'
		
				} // END IF - (pages > quota)

			}
			else {
				echo "<script> alert(\"Invalid page range!\");</script>";
			} // END IF - pageRange()
			//echo "<script> alert(\"Done!\");</script>";
			//echo "<script> refreshPage();</script>";

		} // END IF - ISSET PRINTBUTTON

		// REPRINT JOB
		if (isset($_POST['reprintButton'])) {
			$job_id = $_POST['reprintButton'];
			$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id");
			$row = mysqli_fetch_assoc($result);
			$pages = $row['Pages'];
			$s = $row['page_range'];
			$n = $pages;
			$digit = "[1-9][\d]{0,}";
			$reg4 = "/^(((($digit)|($digit)-($digit)),)*)(($digit)|($digit)-($digit))$/";
			$string = preg_replace('/\s+/', '', $s);
			$RANGE_STRING = '';
			$PAGE_COUNT = '';
			unset($result);
			unset($row);
			if (pagerange($reg4, $string, $n)) {
				// RETRIEVING JOB INFO
				$result = mysqli_query($conn, "SELECT * FROM queue WHERE `Job_ID`=$job_id ");
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['User_name'];
				$username = $user_id;
				$file_path = $row['File_Path'];
				$filename = $row['File_Name']; 
				$pages = $row['Pages'];
				$pages = $PAGE_COUNT;

				unset($result);
				// PRINTING THE JOB
				$printing = mysqli_query($conn, "SELECT value FROM utility WHERE name = 'printing'")->fetch_assoc()['value'];
				if ($printing != 'TRUE') {
					echo "<script> alert(\"Printer currently unavailable, please try again later!\");</script>";
				}
				else {
					$exec_result = exec("lp -o page-ranges=$RANGE_STRING $file_path", $exec_output, $exec_return);
					if ($exec_return != 0) {
						error_log("User: $username - Exec error! Return val = $exec_return");
						echo "<script> alert(\"Error printing document, pls try again!\");</script>";
					}
					else {
						print_r($output);
						// UPDATING DB
						mysqli_query($conn, "UPDATE queue SET `Status`=\"printed\",`Print_Time` = NOW() WHERE `Job_ID` = $job_id");
					}
				} // END IF - $printing != 'TRUE'

			}
			else {
				echo "<script> alert(\"Invalid page range!\");</script>";
			} // END IF - pageRange()
			echo "<script> refreshPage();</script>";
		} // END IF - ISSET RE-PRINTBUTTON

	} // END IF - SERVER REQ. METHOD POST

/********************* END METHODS ***************************/
?>

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
<h2> Welcome Admin! </h2>
	 <div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="nav-btn">Change Quota</a>
		<a href="ps/admin/history.php" class="nav-btn" >View History</a>
		<a href="ps/admin/stats.php" class="nav-btn">Statistics</a>

<div id="demo" style="display: none;"> Demo </div>

	<!-----------------------------main site content------------------------------------->

<br><br>
	
<!----------------- JOB CANCEL/PRINT ----------------->
<span style="font-size:30px; color:maroon;"> Uploads: </span> <br>
<div id="amit" style="display: none;"> Hello </div>
<form name="form1" action="ps/admin/admin.php" method="post">	
	<table>
		<thead>
		<tr>
		<th> Select </th>
		<th> User ID </th>
		<th> File Name </th>
		<th> Select Pages/Range </th>
		<th> Date and Time of Upload </th>
		<th> Click the Job ID to Print </th>
		</tr>
		</thead>

		<tbody>	

	<?php
	$username = $_SESSION["username"];
	$result_uploads = mysqli_query($conn, "SELECT * FROM queue WHERE Status = 'not-printed'");
	$uploads_count = mysqli_num_rows($result_uploads);
	$result_uploads_desc = mysqli_query($conn, "SELECT * FROM queue WHERE Status = 'not-printed' ORDER BY Job_ID DESC LIMIT $uploads_count");
				
	while($row_uploads = mysqli_fetch_assoc($result_uploads_desc)) : ?>
		<tr>
		<td><input type="checkbox" name="cancelJobsList[]" value="<?php echo $row_uploads['Job_ID']; ?>" /></td>
		<td><?php echo $row_uploads['User_name']; ?></td>
		<td><?php echo $row_uploads['File_Name']; ?></td>
	<?php 	$jobid = $row_uploads['Job_ID'];
		$pages = $row_uploads['Pages']; ?>
		<td><input name=pagesRange<?php echo "$jobid"; ?> type="text" size="1" value=<?php if ($pages == 1) { echo $pages; } else { echo "1-$pages";} ?> onkeyup=checkPageRange(<?php echo "$jobid,$pages";?>)></td>
		<td><?php echo $row_uploads['Uploaded_Time'] ?></td>
		<td><input type="submit" name="printButton" onclick=checkPageRange(<?php echo "$jobid,$pages";?>) value="<?php echo $row_uploads['Job_ID']; ?>" id="print-button" style=""/></td>
		</tr>
	<?php endwhile ?>	
		</tbody>

	</table>
		<input type="submit" name="cancelButton" value="Cancel Job(s)" id="cancel-button" style=""/> <br> <br>
	<table>
		<thead>
		<tr>
		<th> Job ID </th>
		<th> User ID </th>
		<th> File Name </th>
		<th> Page Range </th>
		<th> Printed Pages/ Total Page Count</th>		
		<th> Date and Time of Print </th>
		<th> Status </th>
		<th> Reprint </th>
		</tr>
		</thead>

	<tbody>	

<br><br>
<span style="font-size:30px; color:maroon;"> History: </span> <br>
		<?php
		$username = $_SESSION["username"];
		
		//$result_printed = mysqli_query($conn, "SELECT * FROM queue WHERE (`Status`=\"printed\" OR `Status`=\"cancelled\")");
		$result_printed = mysqli_query($conn, "SELECT * FROM queue WHERE `Status`!=\"not-printed\"");
		$hist_count = mysqli_num_rows($result_printed);
		//$result_printed_desc = mysqli_query($conn,"SELECT * FROM queue WHERE (`Status`=\"printed\" OR `Status`=\"cancelled\") ORDER BY Job_ID DESC LIMIT $hist_count");
		$result_printed_desc = mysqli_query($conn,"SELECT * FROM queue WHERE (`Status`!=\"not-printed\") ORDER BY Job_ID DESC LIMIT $hist_count");
		
				
		while($row_printed = mysqli_fetch_assoc($result_printed_desc))	 : ?>

	    <!--echo $row3['Job_ID']." ".$row3['File_Name']."\t".$row3['Pages']."\t".$row3['Time']."<br>";
	    #echo $row3[0]." ".$row3[2]."\t".$row3[4]."\t".$row3[6]."<br>"-->
		
			<tr>
			<?php $jobid = $row_printed['Job_ID']; $pages = $row_printed['Pages']; ?>
			<td><?php echo $row_printed['Job_ID']; ?></td>
			<td><?php echo $row_printed['User_name']; ?></td>
			<td><?php echo $row_printed['File_Name']; ?></td>
			<td><?php $page_count = $row_printed['page_count']; echo $row_printed['page_range']; ?></td>
			<td><?php echo "$page_count / ".$row_printed['Pages']; ?></td>
			<td><?php echo $row_printed['Print_Time']; ?></td>
			<td><?php echo $row_printed['Status']; ?></td>
		<?php if ($row_printed['Status'] == 'printed') : ?>
			<td><input type="submit" name="reprintButton" value="<?php echo $jobid; ?>" id="reprint-button" style=""/></td>
		<?php else : ?>
			<td> </td>
		<?php endif ?>
			</tr>
		<?php endwhile ?>		
	</tbody>

	</table>
</form>	


	<!-----------------------------main site content------------------------------------->

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


<script>
var request;
var index;
function checkPageRange(jobid, pages)
{
	index = "pagesRange"+jobid;
	var v=document.form1[index].value;
	//pages = 7;
	var url = "ps/user/checkPageRange.php?val="+v+"&pages="+pages;
	if(window.XMLHttpRequest) {
		request=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		request=new ActiveXObject("Microsoft.XMLHTTP");
	}

	try {
		request.onreadystatechange = getPageRangeResult;
		request.open("GET", url, true);
		request.send();
	}
	catch(e) {
		alert("Unable to connect to server");
	}
}

function getPageRangeResult() {
	if (request.readyState == 4) {
		var val = request.responseText;
		//document.getElementById('amit').innerHTML=val;
		///*
		if (val == "INVALID") {
			document.getElementById('amit').innerHTML="INVALID!";
			document.form1[index].style = "border: 2px solid red;";
		}
		else {
			document.getElementById('amit').innerHTML=val;
			document.form1[index].style = "border: 2px solid #00ff00;";
		}
		//*/
	}
}
</script>

<?php // ****** FUNCTION DEFINITIONS ******** /

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

/************************ METHODS ***************************/
function pagerange($reg4, $s, $n) {
	if (!preg_match($reg4, $s)) {
		return false;
	}
	//$n = 17;
	$len = strlen($s);
	$st = 0;	
	$pc = 0;
	$pages = array();

while (strpos($s, ",", $st)) {
	$nd = strpos($s, ",", $st);
	//echo $nd;
	//echo "<br>";
	$sub = substr($s, $st, $nd-$st);
	//echo "<br>";
	if (preg_match('/-/', $sub)) {
		list($a, $b) = sscanf($sub, "%d-%d");
		//echo "$a $b"; 
		//echo "<br>";
		if (($a < $b) & ($b <= $n)) {
			//echo "Valid";
			//echo "<br>";
			$pc += ($b - $a + 1);
			$i = $a;
			while ($i <= $b) {
				array_push($pages, $i);
				$i++;
			}
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	else {
		$a = $sub;
		//echo "$a"; 
		//echo "<br>";
		if ($a <= $n) {
			//echo "Valid";
			//echo "<br>";
			$pc += 1;
			array_push($pages, $a);
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	$st = $nd + 1;
}
	/*
	if (!strpos($s, ",", $st)) {
		$nd = $len;
	}
	else {
		$nd = strpos($s, ",", $st);
	}
	*/
	$nd = $len;
	//echo $nd;
	//echo "<br>";
	$sub = substr($s, $st, $nd-$st);
	//echo "<br>";
	if (preg_match('/-/', $sub)) {
		list($a, $b) = sscanf($sub, "%d-%d");
		//echo "$a $b"; 
		//echo "<br>";
		if (($a < $b) & ($b <= $n)) {
			//echo "Valid";
			//echo "<br>";
			$pc += ($b - $a + 1);
			$i = $a;
			while ($i <= $b) {
				array_push($pages, $i);
				$i++;
			}
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	else {
		$a = $sub;
		//echo "$a"; 
		//echo "<br>";
		if ($a <= $n) {
			//echo "Valid";
			$pc += 1;
			//echo "<br>";
			array_push($pages, $a);
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	$st = $nd + 1;
	//echo "Page count = ".$pc;
	//echo "<br>";
//echo "<br>";
//print_r($pages);
sort($pages);
//echo "<br>";
//print_r($pages);
$b = array_unique($pages);
//echo "<br>";
//print_r($b);
//echo "<br>";
$pagecount = count($b);
	$pages_string = "$b[0]";
	$i=1;
	while ($i < $pc) {
		$temp = $b[$i];
		if ($temp) {
			$pages_string .= ",$temp";
		}		
		$i++;
	}
	$GLOBALS['RANGE_STRING'] = $pages_string;
	$GLOBALS['PAGE_COUNT'] = $pagecount;
	//echo "String = ".$pages_string."<br>";

	return true;
}
?>
