<?php
	// STARTING SESSION, THEN DESTROYING
	session_start();
	session_destroy();
	header("location: /ailab/ps-new/login.php");
?>
