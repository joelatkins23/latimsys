<?php 

include 'conn.php';
session_start();
$email = $_SESSION['username'];
$consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
    or die ("Error al traer los Agent");
    while ($rowAgent = mysqli_fetch_array($consultaAgent)){

    $agent_name=$rowAgent['name'];
    $phone=$rowAgent['phone'];
    $picture=$rowAgent['picture'];
    $level=$rowAgent['level'];

    $noteBy=$rowAgent['name'];
    }

if(isset($_POST["ticket_Update"]) && !empty($_POST["ticket_Update"])){

    if(!empty($_POST["jobCheck"])){
            foreach($_POST["jobCheck"] as $jobCheck)
            {
               
                $fecha = date('Y-m-d H:i:s');
                $statusUpdate = $_POST["statusUpdate"];
                $queryModel = mysqli_query($connect, "UPDATE tickets SET status='$statusUpdate' WHERE id='$jobCheck' ") or die ('error');
                $queryModel = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha) VALUES ('$agent_name', '$jobCheck', 'Updated to:  $statusUpdate.', '$fecha')");
            }
        }
    return true;

}
if(isset($_POST["tracking_photo"]) && !empty($_POST["tracking_photo"])){

    $ruta="../images/Tickets/";
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
    $uploadfile_nombre1='';
    $ticket_id=$_POST["jobId"];
    $tracking_number=$_POST["tracking_number"];
    if(isset($_FILES) && !empty($_FILES)){       
        $uploadfile_temporal1=$_FILES['tracking_img']['tmp_name'];
        $extension1 = pathinfo($_FILES['tracking_img']['name'], PATHINFO_EXTENSION);
        if ($extension1=='') {
                $queryModel = mysqli_query($connect, "UPDATE tickets SET tracking_number='$tracking_number' WHERE id='$ticket_id' ");
            }else{    
                $uploadfile_nombre1=$ruta.time().'-2.'.$extension1;         
                if (is_uploaded_file($uploadfile_temporal1)) 
                { 
                    move_uploaded_file($uploadfile_temporal1, $uploadfile_nombre1); 
                } 
                $queryModel = mysqli_query($connect, "UPDATE tickets SET tracking_number='$tracking_number', imagen1='$uploadfile_nombre1' WHERE id='$ticket_id' ");

        }
        echo $uploadfile_nombre1;
    }else{
        $queryModel = mysqli_query($connect, "UPDATE tickets SET tracking_number='$tracking_number' WHERE id='$ticket_id' ");
        echo '';
    }
    
    
}

if(isset($_POST["create_note"]) && !empty($_POST["create_note"])){
        $ticket_id= $_POST['jobId'];
        $notes= $_POST['notess'];
        // $agent_name= $_POST['agent_name'];       

	    $consulta_ticket = mysqli_query($connect, "SELECT * FROM ticket_notes ORDER BY id DESC LIMIT 1");
         $num_rows_ticket = mysqli_num_rows($consulta_ticket);

        if($num_rows_ticket==0){
            $ticket=1;
            $mensaje='No existen Tickets';
        }else{

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
        
    }
    $fecha = date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO ticket_notes(agent_name, ticket_id, note, imagen, fecha) 
                VALUES ('$agent_name', '$ticket_id', '$notes', '$uploadfile_nombre1', '$fecha')");
   
    $data['id']=mysqli_insert_id($connect);
    $data['fecha']=$fecha;
    $data['agent_name']=$agent_name;
    $data['notes']=$notes;
    $data['imagen']=$uploadfile_nombre1;
    echo json_encode($data);
}
if(isset($_POST["inquiry_informtion"]) && !empty($_POST["inquiry_informtion"])){
    $ticket_id=$_POST["jobId"];
    $client = $_POST['client'];
    $job_order = $_POST['job_order'];
    $notes = $_POST['notes'];
    $service = $_POST['service'];
    $warehouse_receipt = $_POST['warehouse_receipt'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_address = $_POST['supplier_address'];
    $queryModel = mysqli_query($connect, "UPDATE tickets SET name='$client', job_order='$job_order', service='$service', supplier_phone='$supplier_phone', supplier_address='$supplier_address',  warehouse_receipt='$warehouse_receipt', notes='$notes' WHERE id='$ticket_id' ");
    return true;
}
if(isset($_GET["ticket"]) && !empty($_GET["ticket"])){
    $id= $_GET['ticket'];
    $email = $_SESSION['username'];
     $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
        or die ("Error al traer los Agent");
         while ($rowAgent = mysqli_fetch_array($consultaAgent)){
            $data['agent']['agent_name']=$rowAgent['name'];
            $data['agent']['phone']=$rowAgent['phone'];
            $data['agent']['picture']=$rowAgent['picture'];
            $data['agent']['level']=$rowAgent['level'];
            $data['agent']['noteBy']=$rowAgent['name'];     
         } 
        $consulta2 = mysqli_query($connect, "SELECT * FROM tickets WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
        while ($row = mysqli_fetch_array($consulta2)){  
            $data['ticket']['jobId'] = $row['id'];
            $data['ticket']['agent_id'] = $row['agent_id'];
            $data['ticket']['service']= $row['service'];
            $data['ticket']['supplier_address']= $row['supplier_address']; 
            $data['ticket']['service']= $row['service'];
            $data['ticket']['imagen1'] = $row['imagen1'];
            $data['ticket']['imagen2'] = $row['imagen2'];
            $data['ticket']['imagen3'] = $row['imagen3'];
            $data['ticket']['type'] = $row['type'];
            $data['ticket']['notes'] = $row['notes'];
            $data['ticket']['client']= $row['name'];
            $data['ticket']['job_order']= $row['job_order'];
            $data['ticket']['supplier']= $row['supplier'];
            $data['ticket']['supplier_phone']= $row['supplier_phone'];
            $data['ticket']['tracking_number'] = $row['tracking_number'];
            $data['ticket']['warehouse_receipt'] = $row['warehouse_receipt'];
            $data['ticket']['status']= $row['status'];        
    }

    $service_select='';
    $selected = ($data['ticket']['service']=='Air Service') ? "selected" : "";
    $service_select.="<option ".$selected." value='Air Service'>Air Service</option>";
    $selected = ($data['ticket']['service']=='Ocean Service') ? "selected" : "";
    $service_select.="<option ".$selected." value='Ocean Service'>Ocean Service</option>";
    $selected = ($data['ticket']['service']=='Pending') ? "selected" : "";
    $service_select.="<option ".$selected." value='Pending'>Pending</option>";
    $data['service_select']=$service_select;
    $agent_select='';
    $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");
    while ($rowList = mysqli_fetch_array($consultaList)){ 
        $selected = ($rowList['id']==$data['ticket']['agent_id']) ? "selected" : ""; 
        $agent_select.="<option ".$selected." value='".$rowList['id']."'>".$rowList['name']."</option>";
    }
    $data['agent_select']=$agent_select;
    $tbody="";
    $consultaNotes = mysqli_query($connect, "SELECT * FROM ticket_notes WHERE ticket_id='$id' ORDER BY id DESC ") or die ("Error al traer los datos");
        while ($rowNotes = mysqli_fetch_array($consultaNotes)){  
        $id_ticket_note = $rowNotes['id'];
        $agent_name_notes = $rowNotes['agent_name'];
        $note= $rowNotes['note'];
        $fecha_note= $rowNotes['fecha'];
        $file= $rowNotes['imagen'];
        if($file){
            $file="<td><a href='images/Tickets/notes/".explode("/", $file)[4]."' style='color:#3c8dbc;font-weight: 100;' target='blank'>".explode("/", $file)[4]."</a></td>" ;
        }else{
            $file="<td></td>";
        }
        $tbody.="<tr id='tr_".$id_ticket_note."' class='text-center'>"; 
        $tbody.="<td><a href='#' onclick='note_delete(".$id_ticket_note.")' ><i class='fa fa-close' style='background: red; padding: 3px 4px;border-radius: 50%;'></i></a></td>";  
        $tbody.="<td>".$fecha_note."</td>";  
        $tbody.="<td>".$agent_name_notes."</td>";  
        $tbody.="<td>".$note."</td>";  
        $tbody.=$file; 
        $tbody.="</tr>";
    }
    $data['tbody']=$tbody;
    echo json_encode($data);
   
}
if(isset($_POST["note_delete"]) && !empty($_POST["note_delete"])){
    $id=$_POST["id"];   
    $queryModel = mysqli_query($connect, "DELETE FROM ticket_notes WHERE id='$id'");
    return true;
}

if(isset($_POST["inquiry_save"]) && !empty($_POST["inquiry_save"])){
    $ticket_id=$_POST["id"]; 
    $status=$_POST["status"];   
    $fecha=date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "UPDATE tickets SET status='$status' WHERE id='$ticket_id' ")
    or die ("<meta http-equiv=\"refresh\" content=\"0;URL= createAccount.php?message=ErrorSavingAccount\">");
    
    $queryModel = mysqli_query($connect, "INSERT INTO ticket_notes(agent_name, ticket_id, note, fecha) 
                    VALUES ('$agent_name', '$ticket_id', 'Ticket Status Updated: '$status'.', '$fecha')");
    return true;
}
if(isset($_POST["ticket_status"]) && !empty($_POST["ticket_status"])){
    $ticket_id=$_POST["id"]; 
    $type=$_POST["type"];   
    $fecha=date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "UPDATE tickets SET type='$type' WHERE id='$ticket_id' ")
    or die ("<meta http-equiv=\"refresh\" content=\"0;URL= createAccount.php?message=ErrorSavingAccount\">");
    
    $queryModel = mysqli_query($connect, "INSERT INTO ticket_notes(agent_name, ticket_id, note, fecha) 
                    VALUES ('$agent_name', '$ticket_id', 'Ticket Type Updated: '$type' Ticket.', '$fecha')");
    return true;
}
if(isset($_POST["order_ticket"]) && !empty($_POST["order_ticket"])){
    $id=$_POST["jobId"]; 
    $queryModel = mysqli_query($connect, "DELETE FROM tickets WHERE id='$id'")
    or die ("<meta http-equiv=\"refresh\" content=\"0;URL= createAccount.php?message=ErrorSavingAccount\">");
    
    $queryModel = mysqli_query($connect, "DELETE FROM ticket_notes WHERE ticket_id='$id'");
    return true;
}
