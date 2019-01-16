<!DOCTYPE html>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";

	$result = mysqli_query($conn,"SELECT * FROM queue1 where `Status` = \"not-printed\"");
	$result_array = array();

	$stream = $time = "";		
	/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["selectRange"])) {
			$range = explode(',', $_POST["time"]);
			echo $range[0]."<br>";
			echo $range[1]."<br>";
			echo "\nTime Range = $range\n";
		}
	}*/
	

	
?>


<html>

<title>Admin</title>

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
	

    	html,body,#myChart { height:100%; width:100%;}

	</style>

	<!--<script>  
	    var request;  
	    function sendInfo()  
	    {  
	    var s=document.getElementById("stream").value;  
	    var t=document.getElementById("time").value;
	    var url="ps/admin/OutputStats.php?val="+s+"&val2="+t;  
	      
	    if(window.XMLHttpRequest){  
	    request=new XMLHttpRequest();  
	    }  
	    else if(window.ActiveXObject){  
	    request=new ActiveXObject("Microsoft.XMLHTTP");  
	    }  
	      
	    try{  
	    request.onreadystatechange=getInfo;  
	    request.open("GET",url,true);  
	    request.send();  
	    }catch(e){alert("Unable to connect to server");}  
	    }  
	      
	    function getInfo(){  
	    if(request.readyState==4){  
	    var val=request.responseText;  
	    document.getElementById('amit').innerHTML=val;  
	    }  
	    }  
	      
	</script>-->

	<script type="text/javascript">
	function CheckColors(val){
		 var element=document.getElementById('time');
		 var sd=document.getElementById('sd');
		 var fd=document.getElementById('fd');
		 var to=document.getElementById('to');
		 var yearlabel=document.getElementById('yearlabel');
		 var year=document.getElementById('year');
		 
		if(val=='range') {
		   sd.style.display='block';
		   fd.style.display='block';
		   to.style.display='block';
		   yearlabel.style.display='none';
		   year.style.display='none';
	         }  
		else if(val=='monthly') {
		   yearlabel.style.display='block';
		   year.style.display='block';
		   sd.style.display='none';
		   fd.style.display='none';
		   to.style.display='none';
	         }
	}

	</script>  
	
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
	 <div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="nav-btn">Change Quota</a>
		<a href="ps/admin/history.php" class="nav-btn" >View History</a>
		<a href="ps/admin/stats.php" class="nav-btn" style="background-color: lightblue; color: white;">Statistics</a>
	
		<br>
			<span style="font-size:25px; color:maroon;"> Stats: </span> <br><br><br>
			<form name="f1" action="ps/stat/output.php" method="get">	
				Stream : 
				<select id="stream" name="stream" required>
				<option value="All">All</option> 
				<?php
					$result = '';
					$result = mysqli_query($conn, "SELECT * FROM quota");
					while($row = mysqli_fetch_assoc($result)) :
					echo $streamcode = $row['stream_code'];
					echo $streamname = $row['stream_name']; ?>
					<option value="<?php echo $streamcode; ?>"><?php echo $streamname; ?></option> 
				<?php 	endwhile ?>
				</select> <br>
				 <br> 
				Select Time
				<!--<select id="time" onchange="sendInfo()">-->
				<select id="time" onchange='CheckColors(this.value);' name="time" required>
					<option value="">--Select--</option>
					<option value="monthly">Monthly</option>
					
					<option value="range">Range</option> 
				</select> <br>
				 <br> 

				<span id ="yearlabel" style='display:none;'> to </span> 
				<input type="number" id="year" style='display:none;' name="year" placeholder="YYYY" min=2017 max=<?php echo date("Y");?>>
 	
				<input type="date" lable ="Start Dt" id="sd" style='display:none;' name="sd">
				<span id ="to" style='display:none;'> to </span> 
				<input type="date" id="fd" style='display:none;' name="fd">
				<!--Select Stream : 
				<select name="time">
			
					<!--<option value="monthly,yearly">Your Option</option> 
					<option value="monthly">Monthly</option>
				</select> <br>-->
				 <br>  	
				<input type="submit" value="Submit" name="Check">	
			</form>
			<br>
	
			<span id="amit"> 

			</span>  

			<!--<?php/*
			if (isset($_POST["Check"])) {
				$stream = $_POST["stream"];
				echo "\nStream = $stream\n";
				$time = $_POST["time"];
				echo "\nTime Range = $time\n<br>";
				
				

				if($time == 'monthly') {
					echo "<script language=\"JavaScript\">
					    function showInput() {
						document.getElementById('display').innerHTML = 
							    document.getElementById(\"user_input\").value;
					    }
					  </script>";
				}
					//Monthly($stream, $conn);

			}
			/*function Monthly($stream, $conn) {
				$results =  mysqli_query($conn,"select * from queue");
				while ($row = mysql_fetch_assoc($results)) {
					  $sql = "select MONTHNAME(Uploaded_Time) as month ,count(*) as count from queue_test where "; 						  $sql .= checkUserStream($row['username'],$conn)
					  $sql .= " == '$stream' group by MONTHNAME(Uploaded_Time); ";

				}
				$result_mon = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month ,count(*) as count from queue_test group by MONTHNAME(Uploaded_Time);");
				while($month_info=mysqli_fetch_array($result_mon)) {
					echo $month_info['month']." ".$month_info['count']."<br>";	
				}

			}
			/*function checkUserStream($id, $conn) {
				$streamname = '';
				$result = mysqli_query($conn, "SELECT * FROM quota");
				while($row = mysqli_fetch_assoc($result)) {
					$regExp = $row['reg_exp'];
					//echo "Reg. Exp.	= ".$regExp."<br>";
					if (preg_match("$regExp", "$id")) {
						$streamname = $row['stream_name'];
						//echo "Stream quota = ".$streamquota."<br>";
						break;
					}
				}
				return $streamname;
			}*/
			?>-->			

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

