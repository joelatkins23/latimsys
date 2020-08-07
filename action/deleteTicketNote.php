<?php require_once('conn.php') ?>
<?php 
	error_reporting(0);
	$id_ticket_note= $_GET['id_ticket_note'];
	$id_ticket= $_GET['id_ticket'];
	
	$modifica= "DELETE FROM ticket_notes WHERE id='$id_ticket_note'";

	$resultado = mysqli_query($connect, $modifica)
	or die ("Error al insertar los registros");

	mysqli_close($connect);
	echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../editTicket.php?id=$id_ticket\">"; 
 ?>
