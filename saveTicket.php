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
    $supplier_address= $_POST['supplier_address'];

	$agent_email= $_POST['agent_email'];



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

    if ($uploadfile_temporal1=='') {
    }else{
    $uploadfile_nombre1=$ruta.$ticket.'-1.'.$extension1; 


    if (is_uploaded_file($uploadfile_temporal1)) 
    { 
        move_uploaded_file($uploadfile_temporal1,$uploadfile_nombre1); 
    } 
    else 
    { 
    echo "error"; 
    } 
}



$uploadfile_temporal2=$_FILES['image2']['tmp_name'];
    $extension2 = pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);

echo $ext;
    if ($uploadfile_temporal2=='') {
    }else{
    $uploadfile_nombre2=$ruta.$ticket.'-2.'.$extension2; 


    if (is_uploaded_file($uploadfile_temporal2)) 
    { 
        move_uploaded_file($uploadfile_temporal2,$uploadfile_nombre2); 
    } 
    else 
    { 
    echo "error"; 
    } 
}

$uploadfile_temporal3=$_FILES['image3']['tmp_name'];
    $extension3 = pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION);
    if ($uploadfile_temporal3=='') {
    }else{
    $uploadfile_nombre3=$ruta.$ticket.'-3.'.$extension3; 


    if (is_uploaded_file($uploadfile_temporal3)) 
    { 
        move_uploaded_file($uploadfile_temporal3,$uploadfile_nombre3); 
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


$queryModel = mysqli_query($connect, "INSERT INTO tickets(type, name, supplier, supplier_phone, supplier_address, tracking_number, warehouse_receipt, notes, agent_name, agent_email, imagen1, imagen2, imagen3, status, fecha) 
                VALUES ('$type', '$name', '$supplier', '$supplier_phone', '$supplier_address', '$tracking_number', '$warehouse_receipt', '$notes', '$agent_name', '$agent_email', '$uploadfile_nombre1', '$uploadfile_nombre2', '$uploadfile_nombre3', 'PENDING', '$fecha')")
or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ../createTicket.php?message=ErrorSavingTicket\">");

echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../createTicket.php?message=TicketSaved\">";


 ?>