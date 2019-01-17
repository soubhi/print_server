<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('uploads.php');

?>
<?php
function ipCIDRCheck ($IP, $net, $mask) {
	//list ($net, $mask) = split ("/", $CIDR);

	$ip_net = ip2long ($net);
	printf("ip_net = $ip_net <br>");
	$ip_mask = ~((1 << (32 - $mask)) - 1);
	printf("ip_mask = $ip_mask <br>");

	$ip_ip = ip2long($IP);
	printf("ip_ip = $ip_ip <br>");

	$ip_ip_net = $ip_ip & $ip_mask;
	printf("ip_ip_net = $ip_ip_net <br>");

	if ($ip_ip_net == $ip_net)
		return 1;
	else
		return 0;
}
$result = ipCIDRCheck("192.168.1.2", "192.168.1.0", "31"); 
echo "<br>";
?>
call example: 
<?php 
echo $result;

?>
