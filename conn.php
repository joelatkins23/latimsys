<?php
	setlocale(LC_TIME, 'es_ES');
	$host="localhost";
	$user="root";
	$pass="";
	$db="latimsystem";
// might be a bit redundant but it's safe :) ... I think :)
	$connect = new mysqli($host,$user,$pass,$db) or die("error" . mysqli_errno($connect));
	$connect->set_charset("utf8");
?>
