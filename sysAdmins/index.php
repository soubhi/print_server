<!DOCTYPE HTML>
<html>

<head>
  <title>System Admins</title>
  <base href="../" />
  <link rel="shortcut icon" href="style/icon1.png" />
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<style>
ul#menu li.sysAdmins-selected a, ul#menu li.sysAdmins-selected a:hover
{ background: #FFF;
  color: navy;}
</style>

<body>
  <div id="main">
	<div id="header">
    <!------------------------------------heading----------------------------------------->
	<?php
		$include_path = "../";
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

<!--------------------------------------MainPageContent--------------------------------------------->

   <div id="site_content">
       <!------------------------------------sidebar----------------------------------------->
	<?php
		include("$include_path/components/sidebar.php");
	?>
   	<!---------------------------------sidebar------------------------------------->


      <div id="content">

      </div><!-- content ends here -->

    </div><!-- site_content ends here -->

<!--------------------------------------MainPageContent--------------------------------------------->

    <!------------------------------------footer----------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
    <!---------------------------------footer------------------------------------->

  </div><!-- main ends here -->
</body>
</html>
