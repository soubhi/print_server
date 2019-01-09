<?php
	$id = $_GET['id'];
	echo "Id = ".$id."<br>Result = ";
	echo (preg_match('/mc..me../', "$id") | preg_match('/..mcme../', "$id")); 
	//preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
	//print_r($matches);

	include('../config.php');
	        if (preg_match("/(mc..me..|..mcme..)/", "$id")) {
                        $streamcode = "mcme";
                }
                elseif (preg_match('/(^mc..mc..$|^..mcmc..$)/', "$id")) {
                        $streamcode = "mcmc";
                }
                elseif (preg_match('/(mc..mt..|..mcmt..|..mcmi..|..mcmi..|..mcmb..|..mcmb..)/', "$id")) {
                        $streamcode = "mcmt";
                }
		elseif (preg_match('/(ravics|swaroopacs|yvsrcs|blehcs|vineetcs|akpcs|prbcs|udgatacs|apcs|rpl|agcs|aruncs|rukmarekha|samcs|atulcs|pngcs|sdbcs|mascs|alokcs|hmcs|blmcs|wankarcs|uday|naveenphd|bapics|saics|askcs|crrcs|dpcs|murli|tsrcs|manics|rathore|kvcs|chakcs|knmcs|nncs)/', "$id")) {
			$streamcode = "faculty";
		}
                elseif (preg_match('/(mc..pc..|..mcpc..)/', "$id")) {
                        $streamcode = "mcpc";
                }
		echo $streamcode;
                $quota = mysqli_query($conn, "SELECT stream_quota FROM quota WHERE stream_code = '$streamcode'")->fetch_assoc()['stream_quota'];
                echo "Quota = ".$quota."<br>";


	echo "<br> <br>";
	
	echo "--------------- = ";

	echo preg_match("/(^me|^mc)/", "$id");

		$result = mysqli_query($conn, "SELECT * FROM quota");
		while($row = mysqli_fetch_assoc($result)) {
			$regExp = $row['reg_exp'];
			echo "Reg. Exp.	= ".$regExp."<br>";
			if (preg_match("$regExp", "$id")) {
				$streamquota = $row['stream_quota'];
				echo "Stream quota = ".$streamquota."<br>";
				break;
			}
		}
?>

