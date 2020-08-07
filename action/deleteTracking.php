<?php require_once('conn.php') ?>
<?php 
	error_reporting(0);
	$trackingId= $_GET['trackingId'];
	$jobId= $_GET['jobId'];
	
	$modifica= "DELETE FROM trackings WHERE id='$trackingId'";

	$resultado = mysqli_query($connect, $modifica)
	or die ("Error al insertar los registros");

	mysqli_close($connect);
	echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../viewTrackings.php?id=$jobId\">"; 
 ?>
