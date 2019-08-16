<!DOCTYPE html>

<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: ../");
	}

	include("../config.php");
	$result = mysqli_query($conn,"SELECT * FROM queue1 where `Status` = \"not-printed\"");
	$result_array = array();
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
	
			
		
		<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
		<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
		ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
		    <?php
			$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month ,count(*) as count from queue1 group by MONTHNAME(Uploaded_Time);");
			?>
			<script>
			var MonthCount=[<?php 
			while($count_info=mysqli_fetch_array($result))
			    echo $count_info['count'].','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
			?>];
			<?php
			$result = mysqli_query($conn,"select MONTHNAME(Uploaded_Time) as month ,count(*) as count from queue1 group by MONTHNAME(Uploaded_Time);");
			?>
			var Month=[<?php 
			while($month_info=mysqli_fetch_array($result))
			    echo '"'.$month_info['month'].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
			?>];
		<?php
			$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM `queue_test`  where Uploaded_Time>='2018-01-01 06:42:10' and Uploaded_Time<='2018-12-06 07:42:50' group by CAST(Uploaded_Time as DATE);");
			?>

			var DateCount=[<?php 
			while($count_info=mysqli_fetch_array($result))
			    echo $count_info['count'].','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
			?>];
			<?php
			$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM `queue_test`  where Uploaded_Time>='2018-01-01 06:42:10' and Uploaded_Time<='2018-12-06 07:42:50' group by CAST(Uploaded_Time as DATE);");
			?>
			var Datelist=[<?php 
			while($date_info=mysqli_fetch_array($result))
			    echo '"'.$date_info['date'].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
			?>];
			
			  /* Unique variable names and chart data */
			  var myChart1 = {
			    "type":"bar",
			    "title":{
				    "text":"Number Of prints per Month"
				},
				"scale-x":{
				"labels":Month
			   	},
			   	 "series":[
				{
			   	 "values":MonthCount
				}]
			  };
			  var myChart2 = {
			      "type":"bar",
			    "title":{
				    "text":"Number Of prints per day in the range '2018-01-01 06:42:10' and '2018-12-06 07:42:50'"
				},
				"scale-x":{
				"labels":Datelist
			   	},
			   	 "series":[
				{
			   	 "values":DateCount
				}]
			  };
			
  /* Your render methods are added after this. */
			    window.onload=function(){
			    zingchart.render({
				id:"chartDiv1",
				width:"100%",
				height:400,
				data:myChart1
			    });
			    zingchart.render({
				id:"chartDiv2",
				width:"100%",
				height:400,
				data:myChart2	
			    });
			    };

			</script>
			   <div id='chartDiv1'></div> 
		           <div id='chartDiv2' style=""></div>  
		</div>
		
		<div>
		<br> <br>                       
		<!--	
		    <?php
			$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM `queue_test`  where Uploaded_Time>='2018-01-01 06:42:10' and Uploaded_Time<='2018-12-06 07:42:50' group by CAST(Uploaded_Time as DATE);");
			?>
			<script>
			var myData=[<?php 
			while($count_info=mysqli_fetch_array($result))
			    echo $count_info['count'].','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
			?>];
			<?php
			$result = mysqli_query($conn,"SELECT CAST(Uploaded_Time as DATE) as date, count(*) as count FROM `queue_test`  where Uploaded_Time>='2018-01-01 06:42:10' and Uploaded_Time<='2018-12-06 07:42:50' group by CAST(Uploaded_Time as DATE);");
			?>
			var myLabels=[<?php 
			while($date_info=mysqli_fetch_array($result))
			    echo '"'.$date_info['date'].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
			?>];
			
			    window.onload=function(){
			    zingchart.render({
				id:"myChart1",
				width:"500px",
				height:400,
				data:{
				"type":"bar",
				"title":{
				    "text":"Number Of prints per day in the range '2018-01-01 06:42:10' and '2018-12-06 07:42:50'"
				},
				"scale-x":{
				"labels":myLabels
			   	},
			   	 "series":[
				{
			   	 "values":myData
				}]
			    }	
			    });
			    };

			</script>
			   <div id='myChart1' style="float:right;"></div>  -->                       

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

