<?php
/***************** SERVER IP **************/
	//$ip = exec("ifconfig wlp6s0 | grep \"inet \" | awk -F'[: ]+' '{ print $4 }'");
	//echo $ip."<br>";
	// SERVER IP
	//$server_ip = exec("ip addr | grep global | awk '{printf $2}' | awk -F/ '{printf $1}'");
	//$server_ip = getHostByName(getHostName());
	//$server_ip = $_SERVER['SERVER_ADDR']; 


	//echo $server_ip = $_SERVER['REMOTE_ADDR'];
	//echo $server_ip;
	
	//echo "<br>"."Server IP : $server_ip";
	//$_SESSION['server_ip'] = $server_ip;
	echo "<br>"."Client IP : $client_ip";
	$_SESSION['client_ip'] = $client_ip;
	//if($client_ip == $server_ip) {
