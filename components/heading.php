<?php

	$pages_path = "/ailab/";


	if($use_page != "TRUE") {
		echo "Working";
		header("location: $pages_path/index.php");
	}


?>


<body>
<base href="/ailab/" />
    
      <div id="logo">
        <!-- class="logo_colour", allows you to change the colour of the text -->
        <h1><a href="index.html">AILAB<span class="logo_colour"></span></a></h1>
	<h2>Artificial Intelligence Laboratory</h2>
      </div>
</body>	
