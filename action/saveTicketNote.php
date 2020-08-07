<?php 

	error_reporting(0);
	require_once('conn.php');


	$agent_name= $_POST['agent_name'];

	$name= $_POST['name'];

	$tracking_number= $_POST['tracking_number'];
	$warehouse_receipt= $_POST['warehouse_receipt'];
	$notes= $_POST['notes'];
	$agent_name= $_POST['agent_name'];
	$supplier= $_POST['supplier'];
	$supplier_phone= $_POST['supplier_phone'];
	$agent_email= $_POST['agent_email'];

    $ticket_id= $_POST['ticket_id'];

	$consulta_ticket = mysqli_query($connect, "SELECT * FROM ticket_notes ORDER BY id DESC LIMIT 1");

     $num_rows_ticket = mysqli_num_rows($consulta_ticket);

if($num_rows_ticket==0)
{
  $ticket=1;
  $mensaje='No existen Tickets';
}
else
{

  while ($extraido_ticket = mysqli_fetch_array($consulta_ticket)) {

        $ticket= $extraido_ticket['id'];
        
    }

  $ticket=$ticket+1;
}


	$ruta="../images/Tickets/notes/";//ruta carpeta donde queremos copiar las imágenes 
    
    $uploadfile_temporal1=$_FILES['image']['tmp_name'];
    $extension1 = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $filename=$_FILES['image']['name'];

    $path_parts = pathinfo($filename);

    $filename= $path_parts['filename'];

    if ($uploadfile_temporal1=='') {
    }else{
    $uploadfile_nombre1=$ruta.$filename.'-Note-'.$ticket.'.'.$extension1; 


    if (is_uploaded_file($uploadfile_temporal1)) 
    { 
        move_uploaded_file($uploadfile_temporal1,$uploadfile_nombre1); 
    } 
    else 
    { 
    echo "error"; 
    } 
}
   

	$fecha= $_POST['fecha'];

	$type= $_POST['type'];

$dt = new DateTime($fecha);

$fecha = $dt->format('Y-m-d H:i:s');


$queryModel = mysqli_query($connect, "INSERT INTO ticket_notes(agent_name, ticket_id, note, imagen, fecha) 
                VALUES ('$agent_name', '$ticket_id', '$notes', '$uploadfile_nombre1', '$fecha')")

or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ../editTicket.php?id=$ticket_id&message=ErrorSavingTicket\">");

echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../editTicket.php?id=$ticket_id&message=NoteCreated\">";


 ?>