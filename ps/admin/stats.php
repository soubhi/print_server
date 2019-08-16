<!DOCTYPE html>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";

	$stream = $time = "";			
?>


<html>

<title> Admin | Stats </title>

<head>
	<base href="../../" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps/style.css">
	
<style>
    	html,body,#myChart { height:100%; width:100%;}
</style>

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
	
		<br><br><br>
		<span style="font-size:25px; color:maroon;"> Stats: </span> <br><br><br>

		<form name="f1" action="ps/admin/output.php" method="get">

			Stream : 
			<select id="stream" name="stream" required>
				<option value="All">All</option> 
			<?php
			$result = '';
			$result = mysqli_query($conn, "SELECT * FROM quota");
			while($row = mysqli_fetch_assoc($result)) :
				$streamcode = $row['stream_code'];
				$streamname = $row['stream_name']; ?>
				<option value="<?php echo $streamcode; ?>"><?php echo $streamname; ?></option> 
			<?php endwhile ?>
			</select> <br>
			<br> 

			Select Time
			<select id="time" onchange='CheckColors(this.value);' name="time" required>
				<option value="">--Select--</option>
				<option value="monthly">Monthly</option>
				<option value="range">Range</option> 
			</select> <br> <br> 

			<span id ="yearlabel" style='display:none;'> to </span> 
			<input type="number" id="year" style='display:none;' name="year" placeholder="YYYY" min=2017 max=<?php echo date("Y");?>>
 	
			<input type="date" lable ="Start Dt" id="sd" style='display:none;' name="sd">
			<span id ="to" style='display:none;'> to </span> 
			<input type="date" id="fd" style='display:none;' name="fd"> <br>  
	
			<input type="submit" value="Submit" name="Check">	
		</form>
		<br>
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

