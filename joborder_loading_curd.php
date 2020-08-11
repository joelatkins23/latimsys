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

    
if(isset($_POST["joborders_list"]) && !empty($_POST["joborders_list"])){
     
    
    if(isset($_POST['checks_joborders']) && !empty($_POST['checks_joborders'])){
        $checklist=$_POST['checks_joborders'];
    }else{
        $checklist=[]; 
    }
    // $warehouse_arr=json_decode($checklist);   
    $html="";
    foreach($checklist as $keyy=>$subarr){  
        $queryModel = mysqli_query($connect, "select a.id, a.fecha, a.status, a.service, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                                                left join accounts b on a.client_id =b.id 
                                                left join accounts c on a.supplier_id =c.id 
                                                left join agents d on a.agent_id=d.id 
                                                WHERE a.branch='' and a.id='$subarr'") or die ('error');
        while ($row = mysqli_fetch_array($queryModel)){  
                $status=$row['status'];
                $id=$row['id'];
                if ($row['status']=='IN WAREHOUSE') {$status='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#00a75a; ">'.$status.'</div>';}
                elseif ($row['status']=='PENDING') {$status='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#db4c39; ">'.$status.'</div>';}
                elseif ($row['status']=='READY TO CONTACT') {$status='<div style="font-weight:600; font-size:9px; color:white; width:80px; padding:5px; border:0.5px solid gray; background:#00c2f0; ">'.$status.'</div>';}
                elseif ($row['status']=='CHECK NOTES') {$status='<div style="font-weight:600; font-size:9px; color:purple; padding:5px;width:80px; border:0.5px solid gray; background:#a62c0d8; ">'.$status.'</div>';}
                else{$status='<div style="font-weight:600; color:black;">'.$status.'</div>';}
                $shipping = $row['customer_city'].'<br><img src="./img/venezuela.png" style="width:40px;">';
                $service=$row['service'];
                if ($service=='') {$service=' ';}
                elseif ($service=='Air Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/air.png" style="width:40px; position:relative; top:10px;"><br>';}
                elseif($service=='Ocean Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/ocean.png" style="width:40px; position:relative; top:10px;"><br>';}
                else{ $service_img='<span style="position:relative; top:0px;"><img src="./img/pending.png" style="width:20px; position:relative; top:4px;"><br>';}
                $service = ' '.$service_img.$row['service'].'</span>';
                $date=$row['fecha'];
            
                $supplier_company = $row['supplier_company'];
                $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
                $result = $connect->query("SELECT COUNT(*) AS total FROM notes WHERE jobOrderId='".$row["id"]."'")->fetch_array();
                if($result[0]!='0'){
                    $brage='<span class="label label-success brage">'.$result[0].'</span>';
                }else{
                    $brage=''; 
                }
                $wr='';
                $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$row['id']."' order by id desc limit 1 ") or die ("Error al traer los Agent");
                    while ($rowWR = mysqli_fetch_assoc($consultaWR)){
                        $WHReceipt=$rowWR['wr'];
                        $wr.='<a href="#" ><i class="fa fa-barcode" style="font-size: 30px;color: black;"></i></a><p>WR#'.$WHReceipt.'</p>';
                    }
                   
                $customer=$row['customer_name'];
                if ($customer=='') {$customer=' ';}

                $trackingJob= $row['tracking'];
                $tracking='<span style="font-size:10px; font-weight:600;">';
                if($trackingJob!=''){
                    $tracking.="Tracking J.O:".$trackingJob."<br>";
                }else{
                    $tracking.=$trackingJob."<br>";
                }
                $consultatrackings = mysqli_query($connect, "SELECT * FROM trackings WHERE jobOrderId='".$row['id']."' ORDER BY id DESC ") or die ("Error al traer los datos");

                while ($rowtrackings = mysqli_fetch_array($consultatrackings)){  

                    $tracking_text= $rowtrackings['tracking'];
                    $carrier= $rowtrackings['carrier']; 
                    $tracking.=$carrier.': '.$tracking_text.".<br>";

                }
                $tracking.='</span>';
                $agent=$row['agent_name'];
        }
        $html.='<tr id="joborders_loading_'.$id.'">';
        $html.='<td class="text-center">'.date_format(date_create($date),'m/d/Y H:i:s').'</td>';
        $html.='<td class="text-center">'.$id.'</td>';
        $html.='<td class="text-center">'.$customer.'</td>';
        $html.='<td class="text-center">'.$supplier_company.'</td>';
        $html.='<td class="text-center">'.$service.'</td>';
        $html.='<td class="text-center">'.$shipping.'</td>';
        $html.='<td class="text-center">'.$agent.'</td>';
        $html.='<td class="text-center">'.$status.'</td>';
        $html.='<td class="text-center">'.$tracking.'</td>';
        $html.='<td class="text-center">'.$wr.'</td>';
        $html.="<td class='text-center'><a href='#' onclick='onjobordersdelete_loading(".$keyy.",".$subarr.")' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>";
        $html.='</tr>';
    }
    $data['status']=true;
    $data['html']=$html;    
    $data['all_joborderslist']=$checklist;
    echo json_encode($data);
}
if(isset($_POST["loading_plan_save"]) && !empty($_POST["loading_plan_save"])){
 
    $all_joborderslist=$_POST['all_joborderslist'];
    $branch=$_POST['branch'];
    $agent_id=$_POST['agent_id'];
    $reference=$_POST['reference'];
    $line=$_POST['line'];
    $type=$_POST['type'];
    $losses_pieces=$_POST['losses_pieces'];
    $fecha=date('Y-m-d H:i:s');
    if($all_joborderslist){
        $all_joborderslist = explode(",", $all_joborderslist);   
        $all_lists=json_encode($all_joborderslist);
    }else{
        $all_joborderslist = explode(",", $all_joborderslist);   
        $all_lists="[]";
    }
    $all_orderlist_arr=json_decode($all_lists);
    foreach( $all_orderlist_arr as $key=>$arr){
        $queryModel = mysqli_query($connect, "UPDATE joborders SET selected=1 WHERE id='$arr' ") or die ('error');
    }
    $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan(branch, agent_id, reference, line, type, loose_pieces, joborder_list, status, fecha) 
    VALUES ('$branch','$agent_id', '$reference','$line', '$type','$losses_pieces', '$all_lists','unlock', '$fecha')") or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ./createPreLodingPlan.php\">");
     $last_id = mysqli_insert_id($connect);
     echo  $last_id;
}
if(isset($_POST["pre_loading_plan_status"]) && !empty($_POST["pre_loading_plan_status"])){
    $id=$_POST['id'];
    $status=$_POST['status'];
    $fecha=date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) 
    VALUES ('$agent_name','$id', 'Pre Loading Plan Status change:  $status.','$fecha')");
    $queryModel = mysqli_query($connect, "UPDATE pre_loading_plan SET status='$status' WHERE id='$id' ") or die ('error');
     echo  true;
}
if(isset($_POST["update_pre_loading_plan"]) && !empty($_POST["update_pre_loading_plan"])){
    $id=$_POST['id'];   
    $all_joborderslist=$_POST['all_joborderslist'];
    $branch=$_POST['branch'];
    $agent_id=$_POST['agent_id'];
    $reference=$_POST['reference'];
    $line=$_POST['line'];
    $type=$_POST['type'];
    $losses_pieces=$_POST['losses_pieces'];
    $date=date('Y-m-d H:i:s');
    if($all_joborderslist){
        $all_joborderslist = explode(",", $all_joborderslist);   
        $all_lists=json_encode($all_joborderslist);
    }else{
        $all_joborderslist = explode(",", $all_joborderslist);   
        $all_lists="[]";
    }
    $all_orderlist_arr=json_decode($all_lists);
    foreach( $all_orderlist_arr as $key=>$arr){
        $queryModel = mysqli_query($connect, "UPDATE joborders SET selected=1 WHERE id='$arr' ") or die ('error');
    }
    $consulta2 = mysqli_query($connect, "SELECT * FROM pre_loading_plan WHERE id='$id'") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){

        
        if($all_lists!=$colrow['joborder_list']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Job Orders list Change', '$date')");
        }
        if($branch!=$colrow['branch']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Baranch Change: $branch.', '$date')");
        }
        if($reference!=$colrow['reference']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Reference Change: $reference.', '$date')");
        }
        if($line!=$colrow['line']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Line Change: $line.', '$date')");
        }
        if($type!=$colrow['type']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Type Change: $type.', '$date')");
        }
        if($losses_pieces!=$colrow['loose_pieces']){          
            $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$id', 'Losses Pieces Change: $losses_pieces.', '$date')");
        }
    }  
    $queryModel = mysqli_query($connect, 
	"UPDATE pre_loading_plan SET 
        branch='$branch',
        agent_id='$agent_id',
        reference='$reference',
        line='$line',
        type='$type',
        loose_pieces='$losses_pieces',
        joborder_list='$all_lists'
        WHERE id='$id'"); 
     echo  true;
}
if(isset($_POST["joborder_delete"]) && !empty($_POST["joborder_delete"])){    
    
    if(isset($_POST['checks_joborders']) && !empty($_POST['checks_joborders'])){
        $checklist=$_POST['checks_joborders'];
    }else{
        $checklist=[]; 
    }  
    $html="";
    $joborder_id=$_POST['id'];
    $date=date('Y-m-d H:i:s');
    $pre_loading_plan_id=$_POST['pre_loading_plan_id'];
    $queryModel = mysqli_query($connect, "UPDATE joborders SET selected=0 WHERE id='$joborder_id'");
    $queryModel = mysqli_query($connect, "INSERT INTO pre_loading_plan_note(agent_name, pre_loading_plan_id, notes, fecha) VALUES ('$agent_name', '$pre_loading_plan_id', 'JOB ORDER - $joborder_id Deleted', '$date')");
    foreach($checklist as $keyy=>$subarr){  
        $queryModel = mysqli_query($connect, "select a.id, a.fecha, a.status, a.service, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                                left join accounts b on a.client_id =b.id 
                                left join accounts c on a.supplier_id =c.id 
                                left join agents d on a.agent_id=d.id 
                                WHERE a.branch='' and a.id='$subarr'") or die ('error');
            while ($row = mysqli_fetch_array($queryModel)){  
                $status=$row['status'];
                $id=$row['id'];
                if ($row['status']=='IN WAREHOUSE') {$status='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#00a75a; ">'.$status.'</div>';}
                elseif ($row['status']=='PENDING') {$status='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#db4c39; ">'.$status.'</div>';}
                elseif ($row['status']=='READY TO CONTACT') {$status='<div style="font-weight:600; font-size:9px; color:white; width:80px; padding:5px; border:0.5px solid gray; background:#00c2f0; ">'.$status.'</div>';}
                elseif ($row['status']=='CHECK NOTES') {$status='<div style="font-weight:600; font-size:9px; color:purple; padding:5px;width:80px; border:0.5px solid gray; background:#a62c0d8; ">'.$status.'</div>';}
                else{$status='<div style="font-weight:600; color:black;">'.$status.'</div>';}
                $shipping = $row['customer_city'].'<br><img src="./img/venezuela.png" style="width:40px;">';
                $service=$row['service'];
                if ($service=='') {$service=' ';}
                elseif ($service=='Air Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/air.png" style="width:40px; position:relative; top:10px;"><br>';}
                elseif($service=='Ocean Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/ocean.png" style="width:40px; position:relative; top:10px;"><br>';}
                else{ $service_img='<span style="position:relative; top:0px;"><img src="./img/pending.png" style="width:20px; position:relative; top:4px;"><br>';}
                $service = ' '.$service_img.$row['service'].'</span>';
                $date=$row['fecha'];

                $supplier_company = $row['supplier_company'];
                $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
                $result = $connect->query("SELECT COUNT(*) AS total FROM notes WHERE jobOrderId='".$row["id"]."'")->fetch_array();
                if($result[0]!='0'){
                    $brage='<span class="label label-success brage">'.$result[0].'</span>';
                }else{
                    $brage=''; 
                }
                $wr='';
                $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$row['id']."' order by id desc limit 1 ") or die ("Error al traer los Agent");
                while ($rowWR = mysqli_fetch_assoc($consultaWR)){
                    $WHReceipt=$rowWR['wr'];
                    $wr.='<a href="#" ><i class="fa fa-barcode" style="font-size: 30px;color: black;"></i></a><p>WR#'.$WHReceipt.'</p>';
                }

                $customer=$row['customer_name'];
                if ($customer=='') {$customer=' ';}

                $trackingJob= $row['tracking'];
                $tracking='<span style="font-size:10px; font-weight:600;">';
                if($trackingJob!=''){
                     $tracking.="Tracking J.O:".$trackingJob."<br>";
                }else{
                    $tracking.=$trackingJob."<br>";
                }
                $consultatrackings = mysqli_query($connect, "SELECT * FROM trackings WHERE jobOrderId='".$row['id']."' ORDER BY id DESC ") or die ("Error al traer los datos");

                while ($rowtrackings = mysqli_fetch_array($consultatrackings)){  

                    $tracking_text= $rowtrackings['tracking'];
                    $carrier= $rowtrackings['carrier']; 
                    $tracking.=$carrier.': '.$tracking_text.".<br>";

                }
                $tracking.='</span>';
                $agent=$row['agent_name'];
            }
            $html.='<tr id="joborders_loading_'.$id.'">';
            $html.='<td class="text-center">'.date_format(date_create($date),'m/d/Y H:i:s').'</td>';
            $html.='<td class="text-center">'.$id.'</td>';
            $html.='<td class="text-center">'.$customer.'</td>';
            $html.='<td class="text-center">'.$supplier_company.'</td>';
            $html.='<td class="text-center">'.$service.'</td>';
            $html.='<td class="text-center">'.$shipping.'</td>';
            $html.='<td class="text-center">'.$agent.'</td>';
            $html.='<td class="text-center">'.$status.'</td>';
            $html.='<td class="text-center">'.$tracking.'</td>';
            $html.='<td class="text-center">'.$wr.'</td>';
            $html.="<td class='text-center'><a href='#' onclick='onjobordersdelete_loading(".$keyy.",".$subarr.")' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>";
            $html.='</tr>';
    }
    $data['status']=true;
    $data['html']=$html; 
    $data['all_joborderslist']=$checklist;
    echo json_encode($data);
}
if(isset($_POST["delete_pre_loading_plan"]) && !empty($_POST["delete_pre_loading_plan"])){
    $id=$_POST['id'];
    $result = mysqli_query($connect, "SELECT * FROM pre_loading_plan WHERE id='$id'");
    while ($colrow = mysqli_fetch_array($result)){
        $all_list=$colrow['joborder_list'];
    }
    $all_orderlist_arr=json_decode($all_list);
    foreach( $all_orderlist_arr as $key=>$arr){
        $queryModel = mysqli_query($connect, "UPDATE joborders SET selected=0 WHERE id='$arr' ") or die ('error');
    }
    $queryModel = mysqli_query($connect, "DELETE FROM pre_loading_plan WHERE id='$id'");
    $queryModel = mysqli_query($connect, "DELETE FROM pre_loading_plan_note WHERE pre_loading_plan_id='$id'") or die ('error');
     echo  true;
}