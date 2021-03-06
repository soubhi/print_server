<!DOCTYPE html>
<?php
	// STARTING SESSION
	session_start();
	if ($_SESSION['logged_in'] != TRUE || $_SESSION['username'] != "admin") {
		header("location: login.php");
	}

	include("../config.php");
	$include_path = "../..";
	$use_page="TRUE";

	$stream = $quota = "";		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["quotaUpdate"])) {
			$stream = $_POST["stream"];
			$quota = $_POST["quota"];
			echo "\nStream = $stream \nQuota = $quota \n";

			$result = mysqli_query($conn, "UPDATE quota SET stream_quota = $quota WHERE stream_code = '$stream'");
			//echo $result;	
			if ($result) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			else {
				echo "Updation failed!";
			}
			unset($result);
		}
		if (isset($_POST["regExpUpdate"])) {
			$stream = $_POST["stream"];
			$regExp = mysqli_real_escape_string($conn, $_POST['regExp']);
			echo "\nStream = $stream \nRegExp = $regExp \n";

			$result = mysqli_query($conn, "UPDATE quota SET reg_exp = '$regExp' WHERE stream_code = '$stream'");
			//echo $result;	
			if ($result) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			else {
				echo "Updation failed!";
			}
			unset($result);
		}
		if (isset($_POST['stopPrint'])) {
			$result = mysqli_query($conn, "UPDATE utility SET value='FALSE' WHERE name = 'printing'");
			if ($result) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			else {
				echo "Updation failed!";
			}
			unset($result);
		}
		if (isset($_POST['resumePrint'])) {
			$result = mysqli_query($conn, "UPDATE utility SET value='TRUE' WHERE name = 'printing'");
			if ($result) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			else {
				echo "Updation failed!";
			}
			unset($result);
		}
		if (isset($_POST['renewalTimeUpdate'])) {
			$time = $_POST['time'];
			$result = mysqli_query($conn, "UPDATE utility SET value='$time' WHERE name = 'quota-renewal-time'");
			if ($result) {
				echo "|||||||||| Updation Successful |||||||||||||||||";
				echo "<script> setTimeout(newLocation, 1000); </script>";			
			}
			else {
				echo "Updation failed!";
			}
			unset($result);
		}
	}
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
	<script>
		function newLocation() { 
			window.location="ps/change_quota.php";
		}
		//setTimeout(newLocation, 1500)
	</script>
	<style>
		.column {
		    float: left;
		    width: 50%;
		}

		/* Clear floats after the columns */
		.row:after {
		    content: "";
		    display: table;
		    clear: both;
		}
	</style>
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
	<h2> Welcome Admin! </h2>
	 <div class="admin-box"> 
		<div class="logout" style="float:right"><a href="ps/logout.php">logout</a></div> <br>
		<a href="ps/admin/admin.php" class="home-button "style="background-color: grey;">&laquo; Home</a>
		<a href="ps/admin/change_quota.php" class="nav-btn">Change Quota</a>
		<a href="ps/admin/history.php" class="nav-btn" >View History</a>
		<a href="ps/admin/stats.php" class="nav-btn">Statistics</a>
	</div>
 
	<!----------------------------------- CHANGE QUOTA CONTENT --------------------------------------->

	<br> <br> <br>	
	<div class="row">
		<div class="column">
		<?php 	$printing = mysqli_query($conn, "SELECT value FROM utility WHERE name = 'printing'")->fetch_assoc()['value']; 
			if ($printing == 'TRUE') :?>
			<span style="font-size:25px; color:maroon;"> Print Status: </span> Printing <br><br>
			<form action="" method="post">
				<input type="submit" value="Click here to Stop printing" name="stopPrint">
			</form>
		<?php 	elseif ($printing == 'FALSE') :?>
			<span style="font-size:25px; color:maroon;"> Print Status: </span> Not printing <br><br>
			<form action="" method="post">
				<input type="submit" value="Click here to Resume printing" name="resumePrint">
			</form>
		<?php 	endif ?>
		</div>
		<div class="column">
			<span style="font-size:25px; color:maroon;"> Renewal Time: </span> <br><br><br>	
			<form action="" method="post">	
				Select renewal time : 
				<select name="time">
					<option value="1week">Weekly</option> 
					<option value="1month">Monthly</option> 
				</select> <br><br>
				<input type="submit" value="Submit" name="renewalTimeUpdate">	
			</form>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="column"> 
			<span style="font-size:25px; color:maroon;"> Quota: </span> <br><br><br>
			<form action="" method="post">	
			Select Stream : 
			<script>
				function changeVal(name) {
					sendInfo(name);
					document.getElementById("quota").value = name;
				}
				var request;
				function sendInfo(name)
				{
					//var v=document.vinform.t1.value;
					var v = name;
					var url="ps/admin/get.php?val="+v;

					if(window.XMLHttpRequest){
						request=new XMLHttpRequest();
					}
					else if(window.ActiveXObject){
						request=new ActiveXObject("Microsoft.XMLHTTP");
					}

					try
					{
						request.onreadystatechange=getInfo;
						request.open("GET",url,true);
						request.send();
					}
					catch(e)
					{
						alert("Unable to connect to server");
					}
				}

				function getInfo(){
					if(request.readyState==4){
						var val=request.responseText;
						//document.getElementById('amit').innerHTML=val;
						document.getElementById("quota").value = val;
					}
				}
			</script>
			<select name="stream" onchange="changeVal(this.options[this.selectedIndex].value)">
			<?php
				$result = '';
				$result = mysqli_query($conn, "SELECT * FROM quota");
				while($row = mysqli_fetch_assoc($result)) :
				$streamcode = $row['stream_code'];
				$streamname = $row['stream_name'];
				$quota = $row['quota']; ?>
				<option value="<?php echo $streamcode; ?>"><?php echo $streamname; ?></option> 
			<?php 	endwhile ?>
			</select> <br>
			Quota : <input type="text" name="quota" id="quota" value=0> <br> <br>  	
			<input type="submit" value="Submit" name="quotaUpdate">	
			</form>
		</div>
		<div class="column"> 
			<span style="font-size:25px; color:maroon;"> Regular Expression: </span> <br><br><br>	
			<form action="" method="post">	
			Select Stream : 
			<select name="stream">
			<?php
				mysqli_data_seek($result,0);
				while($row = mysqli_fetch_assoc($result)) :
				$streamcode = $row['stream_code'];
				$streamname = $row['stream_name']; ?>
				<option value="<?php echo $streamcode; ?>"><?php echo $streamname; ?></option> 
			<?php 	endwhile ?>
			</select> <br>
			Regular Expression : <input type="text" name="regExp"> <br> <br>  	
			<input type="submit" value="Submit" name="regExpUpdate">	
			</form>
		</div>
	</div>

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
