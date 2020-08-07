<?php

	$host="localhost";
	$user="root";
	$pass="";
	$db="latimsystem";
	$connect = new mysqli($host,$user,$pass,$db) or die("error" . mysqli_errno($connect));
	$connect->set_charset("utf8");
?>
