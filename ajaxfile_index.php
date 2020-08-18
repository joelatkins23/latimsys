<?php
include 'conn.php';
session_start();
$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rowAgent = mysqli_fetch_array($consultaAgent)){  
$level=$rowAgent['level'];

} 
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
$from=$_POST['from'];
$to=$_POST['to'];
if(isset($_POST['jobCheckval']) && !empty($_POST['jobCheckval'])){
    $jobCheckval=$_POST['jobCheckval'];
}else{
    $jobCheckval=[];
}

## Search 
$searchQuery = " ";
if($searchValue != ''){
     
    $filter_arr=explode(" ", $searchValue);
    foreach($filter_arr as $key=>$item1){    
        $accented_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

        $item = strtr( $item1, $accented_array );
        $searchQuery.= " and (a.id like '%".$item."%' or 
        b.name like '%".$item."%' or
        a.customer_city like '%".$item."%' or 
        c.company like '%".$item."%' or 
        d.name like '%".$item."%' or  
        a.service like '%".$item."%' or  
        a.wh_receipt like '%".$item."%' or  
        a.status like '%".$item."%' or  
        a.fecha like '%".$item."%') ";
    }
}

## Total number of records without filtering
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a
                    left join agents c 
                    on a.agent_id=c.id 
                    where c.email='$email' 
                    AND 
                    DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' AND a.status='READY TO CONTACT'");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a
                    left join agents c 
                    on a.agent_id=c.id 
                    where c.email='$email' 
                    AND a.status='READY TO CONTACT'");   
    }
    
  }elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a
                    left join agents c 
                    on a.agent_id=c.id 
                    where 
                    DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' AND a.status='READY TO CONTACT'");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a
                    left join agents c 
                    on a.agent_id=c.id 
                    where a.status='READY TO CONTACT'");   
    }
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a 
        left join accounts b on a.client_id =b.id 
        left join accounts c on a.supplier_id =c.id 
        left join agents d on a.agent_id=d.id 
         WHERE d.email='$email' AND a.status='READY TO CONTACT' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery."  ");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a 
        left join accounts b on a.client_id =b.id 
        left join accounts c on a.supplier_id =c.id 
        left join agents d on a.agent_id=d.id 
         WHERE d.email='$email' AND a.status='READY TO CONTACT' and 1 ".$searchQuery."");   
    }
    
   
  }elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a 
        left join accounts b on a.client_id =b.id 
        left join accounts c on a.supplier_id =c.id 
        left join agents d on a.agent_id=d.id 
         WHERE a.status='READY TO CONTACT' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery."  ");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from joborders a 
        left join accounts b on a.client_id =b.id 
        left join accounts c on a.supplier_id =c.id 
        left join agents d on a.agent_id=d.id 
         WHERE  a.status='READY TO CONTACT' and 1 ".$searchQuery."");   
    }
   
}

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $empQuery = " select a.id, a.fecha, a.status,a.service, a.atteched_files, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.status='READY TO CONTACT' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' 
                    and 1 ".$searchQuery." 
                    order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

    }else{
        $empQuery = " select a.id, a.fecha, a.status,a.service, a.atteched_files, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.status='READY TO CONTACT'
                    and 1 ".$searchQuery." 
                    order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    }
    
}elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $empQuery = " select a.id, a.fecha, a.status,a.service, a.atteched_files, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE a.status='READY TO CONTACT' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' 
                    and 1 ".$searchQuery." 
                    order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

    }else{
        $empQuery = " select a.id, a.fecha, a.status,a.service, a.atteched_files, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE a.status='READY TO CONTACT'
                    and 1 ".$searchQuery." 
                    order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    }
    
}
$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {

    $status=$row['status'];
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
    $t = strtotime($row['fecha']); date('d/m/y',$t);
    if(in_array($row["id"], $jobCheckval, true)){
        $action = '<input type="checkbox" name="jobCheck[]" checked  value="'.$row['id'].'" style="transform : scale(1.5);">';
    }else{
        $action = '<input type="checkbox" name="jobCheck[]"  value="'.$row['id'].'" style="transform : scale(1.5);">';
    }
   
    $supplier_company = $row['supplier_company'];
    $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
    $result = $connect->query("SELECT COUNT(*) AS total FROM notes WHERE jobOrderId='".$row["id"]."'")->fetch_array();
    if($result[0]!='0'){
        $brage='<span class="label label-success brage">'.$result[0].'</span>';
    }else{
        $brage=''; 
    }
    $shortcut = '<a href="#" onclick="editJobOrder('.$row['id'].')"><i class="fa fa-edit action"></i></a><a href="#" onclick="viewNotes('.$row['id'].')"><i class="fa fa-file-o action"></i>'.$brage.'</a><a href="./downloadPDF.php?id='.$row['id'].'"    target="blank"><i class="fa fa-file-pdf-o action"></i></a>';
    $wr='';
    $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$row['id']."' order by id desc limit 1 ") or die ("Error al traer los Agent");
        while ($rowWR = mysqli_fetch_assoc($consultaWR)){
            $WHReceipt=$rowWR['wr'];
            $wr.='<a href="https://latim.cargotrack.net/appl2.0/warehouse/detail.asp?id=<?php echo $WHReceipt; ?>&redir=../accounts/warehouse.asp?id=&redir_id=738" target="blank"><i class="fa fa-barcode" style="font-size: 30px;color: black;"></i></a><p>WR#'.$WHReceipt.'</p>';
        }
        $wr.='<a onclick="addwr('.$row['id'].')" href="#"><button type="button" class="btn btn-secondary btn-sm" style="color:black">ADD WR</button></a>';
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
    $tracking.='</span><a onclick="addtracking('.$row['id'].')" href="#"><button type="button" class="btn btn-secondary btn-sm" style="color:black">+Tracking</button></a>';
    $file_arr=json_decode($row['atteched_files']);
    if($file_arr){
        $brage_file='<span class="label label-success brage">'.count($file_arr).'</span>';
    }else{
        $brage_file='';
    }
    $atteched='<a href="#" onclick="editattached('.$row['id'].')"><i class="fa fa-file-o action"></i>'.$brage_file.'</a>';
    $agent=$row['agent_name'];
    if ($agent=='') {$agent=' ';}
    
        $data[] = array(
                "fecha"=>date('Y-m-d',$t),
                "id"=>$row['id'],
                "customer_name"=>$customer,
                "supplier_company"=>$supplier_company,
                "service"=>$service,
                "customer_city"=>$shipping,
                "agent_name"=>$agent,
                "status"=>$status,
                "tracking"=>$tracking,
                "wr"=>$wr,
                "atteched"=>$atteched,
                "shortcut"=>$shortcut,
                "action"=>$action
            );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);