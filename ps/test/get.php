<?php
	$s = $_GET['val'];
	echo "$s[0]";	
	echo "<br>Length = ";
	echo $n = strlen($s);
	echo "<br>Word count = ".str_word_count($s);
	echo "<br>Position = ".strpos($s, ",");
	echo "<br>";
	if ($s[$n-1] == ",") {
		echo "Invalid input!";
	}
	else {
		echo "Valid input!";
	}
	$pg = 7;
	/*
	for ($i=0; i<$n; i++) {
		if(
	*/
	echo "<br>";
	preg_match_all('!\d+!', $s, $matches);
	print_r($matches); 
	echo "<br>";
	preg_match_all('!\d*.?\d+!', $s, $matches);
	print_r($matches); 
	echo "<br>";
	echo filter_var($s, FILTER_SANITIZE_NUMBER_INT);
	echo "<br>";
	echo preg_replace("/[^0-9]/","",$string);
	echo "<br>";
?>
