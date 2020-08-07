<?php require_once('conn.php') ?>
<?php 
	error_reporting(0);
	$id= $_GET['id'];
	
	$modifica= "DELETE FROM accounts WHERE id='$id'";

	$resultado = mysqli_query($connect, $modifica)
	or die ("Error al insertar los registros");

	mysqli_close($connect);
	echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../createAccount.php?message=AccountDeleted\">"; 
 ?>
