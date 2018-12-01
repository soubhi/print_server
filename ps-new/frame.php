<!DOCTYPE html>

<html>

<title>Login</title>

<head>
	<base href="/ailab/" />
	<link rel="shortcut icon" href="style/icon1.png" />
	<meta name="description" content="website description" />
	<meta name="keywords" content="website keywords, website keywords" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="stylesheet" type="text/css" href="ps-new/style.css">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

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


<!--       SITE CONTENT BEGIN HERE   -->



<!--       SITE CONTENT ENDS HERE    -->

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
	//echo exec('whoami');
	//echo exec('cat /home/printmaster/passwords.txt');

	//echo $username, $input_password, "<br />", $encrypted_password;

	//echo "<br />", $inp_encrypt_pass; 

	//$r = mysqli_query($conn, "select username from users where username= \"soubhagya\"");
	 //echo $r;

?>
