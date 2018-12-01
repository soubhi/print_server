<!DOCTYPE HTML>
<html>

<head>
  <title>Ailab Facilities</title>
  <base href="/ailab/" />
  <link rel="shortcut icon" href="style/icon1.png" />
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<style>
ul#menu li.home-selected a, ul#menu li.home-selected a:hover
{ background: #FFF;
  color: navy;}
</style>

<body>
  <div id="main">
	<div id="header">
    <!------------------------------------heading----------------------------------------->
	<?php
		$include_path = dirname(__FILE__);
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
       <!------------------------------------sidebar----------------------------------------->
	<?php
		include("$include_path/components/sidebar.php");
	?>
   	<!---------------------------------sidebar------------------------------------->

      <div id="content">
        <h1>Welcome to the AILAB</h1>
	<h2> AILAB </h2>
	<img src="media/ailab_2013.png" width="510px" height="400px"> 
        <p>
	Artificial Intelligence or AI Lab is one of the many labs in the School of Computer and Information Sciences (SCIS)	
This standards compliant, simple, fixed width website template is released as an 'open source' design (under a <a href="http://creativecommons.org/licenses/by/3.0">Creative Commons Attribution 3.0 Licence</a>), which means that you are free to download and use it for anything you want (including modifying and amending it). All I ask is that you leave the 'design from HTML5webtemplates.co.uk' link in the footer of the template, but other than that...</p>
        <p>This template is written entirely in <strong>HTML5</strong> and <strong>CSS</strong>, and can be validated using the links in the footer.</p>

	<h2> An image of AI Lab in late 90s. </h2>
	<img src="media/ailab_1990s.jpg" width="80%"> 
        <p>You can view more free HTML5 web templates <a href="http://www.html5webtemplates.co.uk">here</a>.</p>
        <p>This template is a fully functional 5 page website, with an <a href="examples.html">examples</a> page that gives examples of all the styles available with this design.</p>
        <h2>Browser Compatibility</h2>
        <p>This template has been tested in the following browsers:</p>
        <ul>
          <li>Internet Explorer 8</li>
          <li>FireFox 3</li>
          <li>Google Chrome 13</li>
        </ul>
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
