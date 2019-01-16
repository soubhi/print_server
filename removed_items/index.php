<!DOCTYPE HTML>
<html>

<head>
  <title>Ailab Facilities</title>
  <base href=".">
  <link rel="shortcut icon" href="style/icon1.png" />
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<style>
ul#menu li.home-selected a, ul#menu li.home-selected a:hover
{
  background: #FFF;
  color: navy;
}
</style>

<body>











  <div id="main">
	<div id="header">
    	<!------------------------------------heading----------------------------------------->
	<?php
		//$include_path = dirname(__FILE__);
		$include_path = ".";
		$use_page="TRUE";
		include("$include_path/components/heading.php");
	?>
  	<!---------------------------------end of heading------------------------------------->

  	<!------------------------------------navigation-bar----------------------------------------->
	<?php
		include("$include_path/components/nav-bar.php");
	?>
   	<!---------------------------------navigation-bar------------------------------------->

	</div> 
	<!-- header ends here --> 














  <div id="site_content">
  
   	<!------------------------------------sidebar----------------------------------------->
	<?php
	?>
   	<!---------------------------------sidebar------------------------------------->
	
	

	<div id="content">
          <h1>Welcome to the AILAB</h1>
	  <h2> AILAB </h2>
	<!------------------------------------slider----------------------------------------->
	<?php
		include("$include_path/components/carousel.php");
	?>
   	<!---------------------------------slider------------------------------------->
	  <br>
          <p>Artificial Intelligence or AI Lab is one of the many labs in the School of Computer and Information Sciences (SCIS).</p>
	<!--
	  <h2> An image of AI Lab in late 90s. </h2>
	-->
	</div>
	<!-- content ends here -->
  </div>

  <!-- site_content ends here -->















 
   	<!------------------------------------footer----------------------------------------->
	<?php
		include("$include_path/components/footer.php");
	?>
    	<!---------------------------------footer------------------------------------->









  </div>
<!-- main ends here -->

</body>
</html>
