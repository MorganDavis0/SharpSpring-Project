<?php
	#creds for my local mysql server
	$servername="127.0.0.1";
	$username="root";
	$password="root";
	#establish connection
	$bcmdev = mysqli_connect($servername, $username, $password, "c1");
	if ($bcmdev->connect_error){
		die("Connection Failed: " . $bcmdev->connect_error);
	}
?>