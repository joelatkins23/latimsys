<?php 


error_reporting(0);
session_start();

require_once('conn.php');

$id= $_POST['id'];
$ticket_id=$id;

$tracking_number = $_POST['tracking_number'];

$message = $_POST['message'];
$image = $_POST['image'];





  $consulta_ticket = mysqli_query($connect, "SELECT * FROM tickets ORDER BY id DESC LIMIT 1");

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


    $ruta="../images/Tickets/";//ruta carpeta donde queremos copiar las imágenes 
    
    $uploadfile_temporal1=$_FILES['image']['tmp_name'];
    $extension1 = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if ($extension1=='') {
      $queryModel = mysqli_query($connect, "UPDATE tickets SET tracking_number='$tracking_number' WHERE id='$ticket_id' ");
    }else{

    if ($uploadfile_temporal1=='') {
    }else{
    $uploadfile_nombre1=$ruta.$ticket.'-2.'.$extension1; 


    if (is_uploaded_file($uploadfile_temporal1)) 
    { 
        move_uploaded_file($uploadfile_temporal1,$uploadfile_nombre1); 
    } 
    else 
    { 
    echo "error"; 
    } 
}

$queryModel = mysqli_query($connect, "UPDATE tickets SET tracking_number='$tracking_number', imagen1='$uploadfile_nombre1' WHERE id='$ticket_id' ");

}

   

mysqli_close($connect);
  echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../editTicket.php?id=$ticket_id\">"; 


   


?>