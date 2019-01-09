<?php
$s = $_GET['val'];
$n = $_GET['pages'];
//echo "<br>Pages = $n <br>";
//echo "String = $s <br>";
$digit = "[1-9][\d]{0,}";
$reg4 = "/^(((($digit)|($digit)-($digit)),)*)(($digit)|($digit)-($digit))$/";
$string = preg_replace('/\s+/', '', $s);
$RANGE_STRING = '';
$PAGE_COUNT = '';
if (pagerange($reg4, $string, $n)) {
	echo $RANGE_STRING;	
	echo ":VALID:";
	echo $PAGE_COUNT;	
}
else {
	echo "INVALID";
}
function pagerange($reg4, $s, $n) {
	if (!preg_match($reg4, $s)) {
		return false;
	}
	//$n = 17;
	$len = strlen($s);
	$st = 0;	
	$pc = 0;
	$pages = array();

while (strpos($s, ",", $st)) {
	$nd = strpos($s, ",", $st);
	//echo $nd;
	//echo "<br>";
	$sub = substr($s, $st, $nd-$st);
	//echo "<br>";
	if (preg_match('/-/', $sub)) {
		list($a, $b) = sscanf($sub, "%d-%d");
		//echo "$a $b"; 
		//echo "<br>";
		if (($a < $b) & ($b <= $n)) {
			//echo "Valid";
			//echo "<br>";
			$pc += ($b - $a + 1);
			$i = $a;
			while ($i <= $b) {
				array_push($pages, $i);
				$i++;
			}
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	else {
		$a = $sub;
		//echo "$a"; 
		//echo "<br>";
		if ($a <= $n) {
			//echo "Valid";
			//echo "<br>";
			$pc += 1;
			array_push($pages, $a);
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	$st = $nd + 1;
}
	/*
	if (!strpos($s, ",", $st)) {
		$nd = $len;
	}
	else {
		$nd = strpos($s, ",", $st);
	}
	*/
	$nd = $len;
	//echo $nd;
	//echo "<br>";
	$sub = substr($s, $st, $nd-$st);
	//echo "<br>";
	if (preg_match('/-/', $sub)) {
		list($a, $b) = sscanf($sub, "%d-%d");
		//echo "$a $b"; 
		//echo "<br>";
		if (($a < $b) & ($b <= $n)) {
			//echo "Valid";
			//echo "<br>";
			$pc += ($b - $a + 1);
			$i = $a;
			while ($i <= $b) {
				array_push($pages, $i);
				$i++;
			}
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	else {
		$a = $sub;
		//echo "$a"; 
		//echo "<br>";
		if ($a <= $n) {
			//echo "Valid";
			$pc += 1;
			//echo "<br>";
			array_push($pages, $a);
		}
		else {
			return false;
			echo "INVALID";
			//echo "<br>";
		}	
	}
	$st = $nd + 1;
	//echo "Page count = ".$pc;
	//echo "<br>";
//echo "<br>";
//print_r($pages);
sort($pages);
//echo "<br>";
//print_r($pages);
$b = array_unique($pages);
//echo "<br>";
//print_r($b);
//echo "<br>";
$pagecount = count($b);
	$pages_string = "$b[0]";
	$i=1;
	while ($i < $pc) {
		$temp = $b[$i];
		if ($temp) {
			$pages_string .= ",$temp";
		}		
		$i++;
	}
	$GLOBALS['RANGE_STRING'] = $pages_string;
	$GLOBALS['PAGE_COUNT'] = $pagecount;
	//echo "String = ".$pages_string."<br>";

	return true;
}
?>
