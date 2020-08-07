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

    
if(isset($_POST["warehouse_list"]) && !empty($_POST["warehouse_list"])){
     
    
    if(isset($_POST['checks_warehouse']) && !empty($_POST['checks_warehouse'])){
        $checklist=$_POST['checks_warehouse'];
    }else{
        $checklist=[]; 
    }
    // $warehouse_arr=json_decode($checklist);
    $all_total_pieces=0;
    $all_total_weight=0;
    $all_total_volume=0;
    $html="";
    $wareHouse_list=[];
    foreach($checklist as $keyy=>$subarr){  
        $queryModel = mysqli_query($connect, "SELECT  a.*,  b.name AS supplier_name, c.name AS consignee_name FROM warehouse a LEFT JOIN accounts b ON (a.supplier_id=b.id) LEFT JOIN accounts c ON (a.consignee_id=c.id)  WHERE a.id='$subarr'") or die ('error');
        while ($row = mysqli_fetch_array($queryModel)){  
            $id=$row['id'];
            $fecha=$row['fecha'];
            $destination=$row['destination'];
            $supplier_id=$row['supplier_name'];
            $consignee_id=$row['consignee_name'];
            $total_pieces=$row['total_pieces'];
            $total_weight=$row['total_weight'];
            $total_volume=$row['total_volume'];
            $value=$row['value'];
            $reference_id=$row['reference_id'];
            $all_total_pieces=$all_total_pieces+$row['total_pieces'];
            $all_total_volume=$all_total_volume+$row['total_volume'];
            $all_total_weight=$all_total_weight+$row['total_weight'];
        }
        $html.='<tr id="warehouse_loading_'.$id.'">';
        $html.='<td class="text-center">'.$id.'</td>';
        $html.='<td class="text-center">'.$reference_id.'</td>';
        $html.='<td class="text-center">'.date_format(date_create($fecha),'m/d/Y H:i:s').'</td>';
        $html.='<td class="text-center">'.$destination.'</td>';
        $html.='<td class="text-center">'.$total_pieces.'</td>';
        $html.='<td class="text-center">'.$total_weight.'</td>';
        $html.='<td class="text-center">'.$total_volume.'</td>';
        $html.='<td class="text-center">'.$supplier_id.'</td>';
        $html.='<td class="text-center">'.$consignee_id.'</td>';
        $html.="<td class='text-center'><a href='#' onclick='onwarehousedelete_loading(".$keyy.",".$subarr.")' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>";
        $html.='</tr>';
    }
    $data['status']=true;
    $data['html']=$html;
    $data['all_total_pieces']=$all_total_pieces;
    $data['all_total_weight']=$all_total_weight;
    $data['all_total_volume']=number_format($all_total_volume,6);
    $data['all_warehouselist']=$checklist;
    echo json_encode($data);
}
if(isset($_POST["loading_guide_save"]) && !empty($_POST["loading_guide_save"])){
    $all_total_pieces=$_POST['all_total_pieces'];
    $all_total_weight=$_POST['all_total_weight'];
    $all_total_volume=$_POST['all_total_volume'];
    $all_total_charg_weight=$_POST['all_total_charg_weight'];
    $all_warehouselist=$_POST['all_warehouselist'];
    $branch=$_POST['branch'];
    $agent_id=$_POST['agent_id'];
    $reference=$_POST['reference'];
    $line=$_POST['line'];
    $type=$_POST['type'];
    $losses_pieces=$_POST['losses_pieces'];
    $fecha=date('Y-m-d H:i:s');
    if($all_warehouselist){
        $all_warehouselist = explode(",", $all_warehouselist);   
        $all_lists=json_encode($all_warehouselist);
    }else{
        $all_warehouselist = explode(",", $all_warehouselist);   
        $all_lists="[]";
    }
    
    $queryModel = mysqli_query($connect, "INSERT INTO loading_guide(branch, agent_id, reference, line, type, loose_pieces, warehouse_list, all_total_pieces, all_total_weight, all_total_volume, all_total_charg_weight, status, fecha) 
    VALUES ('$branch','$agent_id', '$reference','$line', '$type','$losses_pieces', '$all_lists','$all_total_pieces', '$all_total_weight','$all_total_volume', '$all_total_charg_weight','unlock', '$fecha')") or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ./warehouse_loading_curd.php\">");
     $last_id = mysqli_insert_id($connect);
     echo  $last_id;
}
if(isset($_POST["loading_guide_status"]) && !empty($_POST["loading_guide_status"])){
    $id=$_POST['id'];
    $status=$_POST['status'];
    $fecha=date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) 
    VALUES ('$agent_name','$id', 'Loading Guide status change:  $status.','$fecha')");
    $queryModel = mysqli_query($connect, "UPDATE loading_guide SET status='$status' WHERE id='$id' ") or die ('error');
     echo  true;
}
if(isset($_POST["update_loading_guide"]) && !empty($_POST["update_loading_guide"])){
    $id=$_POST['id'];
    $all_total_pieces=$_POST['all_total_pieces'];
    $all_total_weight=$_POST['all_total_weight'];
    $all_total_volume=$_POST['all_total_volume'];
    $all_total_charg_weight=$_POST['all_total_charg_weight'];
    $all_warehouselist=$_POST['all_warehouselist'];
    $branch=$_POST['branch'];
    $agent_id=$_POST['agent_id'];
    $reference=$_POST['reference'];
    $line=$_POST['line'];
    $type=$_POST['type'];
    $losses_pieces=$_POST['losses_pieces'];
    $date=date('Y-m-d H:i:s');
    if($all_warehouselist){
        $all_warehouselist = explode(",", $all_warehouselist);   
        $all_lists=json_encode($all_warehouselist);
    }else{
        $all_warehouselist = explode(",", $all_warehouselist);   
        $all_lists="[]";
    }
    $consulta2 = mysqli_query($connect, "SELECT * FROM loading_guide WHERE id='$id'") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){

        if($all_total_pieces!=$colrow['all_total_pieces']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Pieces Change: $reference_id.', '$date')");
        }
        if($all_total_weight!=$colrow['all_total_weight']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Weight Change: $all_total_weight.', '$date')");
        }
        if($all_total_volume!=$colrow['all_total_volume']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Volume Change: $all_total_volume.', '$date')");
        }
        if($all_total_charg_weight!=$colrow['all_total_charg_weight']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Charg Weight Change: $all_total_charg_weight.', '$date')");
        }
        if($all_lists!=$colrow['warehouse_list']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'WareHouse list Change', '$date')");
        }
        if($branch!=$colrow['branch']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Baranch Change: $branch.', '$date')");
        }
        if($reference!=$colrow['reference']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Reference Change: $reference.', '$date')");
        }
        if($line!=$colrow['line']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Line Change: $line.', '$date')");
        }
        if($type!=$colrow['type']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Type Change: $type.', '$date')");
        }
        if($losses_pieces!=$colrow['loose_pieces']){          
            $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$id', 'Losses Pieces Change: $losses_pieces.', '$date')");
        }
    }
    $queryModel = mysqli_query($connect, 
	"UPDATE loading_guide SET 
        branch='$branch',
        agent_id='$agent_id',
        reference='$reference',
        line='$line',
        type='$type',
        loose_pieces='$losses_pieces',
        warehouse_list='$all_lists',
        all_total_pieces='$all_total_pieces',
        all_total_weight='$all_total_weight',
        all_total_volume='$all_total_volume',
        all_total_charg_weight='$all_total_charg_weight'
        WHERE id='$id'");
 
     echo  true;
}
if(isset($_POST["warehouse_delete"]) && !empty($_POST["warehouse_delete"])){
     
    
    if(isset($_POST['checks_warehouse']) && !empty($_POST['checks_warehouse'])){
        $checklist=$_POST['checks_warehouse'];
    }else{
        $checklist=[]; 
    }
    // $warehouse_arr=json_decode($checklist);
    $all_total_pieces=0;
    $all_total_weight=0;
    $all_total_volume=0;
    $html="";
    $wareHouse_list=[];
    $ware_id=$_POST['id'];
    $date=date('Y-m-d H:i:s');
    $loadingguide_id=$_POST['loadingguide_id'];
    $queryModel = mysqli_query($connect, "INSERT INTO loading_guide_note(agent_name, loadingguide_id, notes, fecha) VALUES ('$agent_name', '$loadingguide_id', 'WH - $ware_id Deleted', '$date')");
    foreach($checklist as $keyy=>$subarr){  
        $queryModel = mysqli_query($connect, "SELECT  a.*,  b.name AS supplier_name, c.name AS consignee_name FROM warehouse a LEFT JOIN accounts b ON (a.supplier_id=b.id) LEFT JOIN accounts c ON (a.consignee_id=c.id)  WHERE a.id='$subarr'") or die ('error');
        while ($row = mysqli_fetch_array($queryModel)){  
            $id=$row['id'];
            $fecha=$row['fecha'];
            $destination=$row['destination'];
            $supplier_id=$row['supplier_name'];
            $consignee_id=$row['consignee_name'];
            $total_pieces=$row['total_pieces'];
            $total_weight=$row['total_weight'];
            $total_volume=$row['total_volume'];
            $value=$row['value'];
            $reference_id=$row['reference_id'];
            $all_total_pieces=$all_total_pieces+$row['total_pieces'];
            $all_total_volume=$all_total_volume+$row['total_volume'];
            $all_total_weight=$all_total_weight+$row['total_weight'];
        }
        $html.='<tr id="warehouse_loading_'.$id.'">';
        $html.='<td class="text-center">'.$id.'</td>';
        $html.='<td class="text-center">'.$reference_id.'</td>';
        $html.='<td class="text-center">'.date_format(date_create($fecha),'m/d/Y H:i:s').'</td>';
        $html.='<td class="text-center">'.$destination.'</td>';
        $html.='<td class="text-center">'.$total_pieces.'</td>';
        $html.='<td class="text-center">'.$total_weight.'</td>';
        $html.='<td class="text-center">'.$total_volume.'</td>';
        $html.='<td class="text-center">'.$supplier_id.'</td>';
        $html.='<td class="text-center">'.$consignee_id.'</td>';
        $html.="<td class='text-center'><a href='#' onclick='onwarehousedelete_loading(".$keyy.",".$subarr.")' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>";
        $html.='</tr>';
    }
    $data['status']=true;
    $data['html']=$html;
    $data['all_total_pieces']=$all_total_pieces;
    $data['all_total_weight']=$all_total_weight;
    $data['all_total_volume']=number_format($all_total_volume,6);
    $data['all_warehouselist']=$checklist;
    echo json_encode($data);
}
if(isset($_POST["delete_loading_guide"]) && !empty($_POST["delete_loading_guide"])){
    $id=$_POST['id'];  
    $queryModel = mysqli_query($connect, "DELETE FROM loading_guide WHERE id='$id'");
    $queryModel = mysqli_query($connect, "DELETE FROM loading_guide_note WHERE loadingguide_id='$id'") or die ('error');
     echo  true;
}