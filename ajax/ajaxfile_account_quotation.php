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
$client_id=$_POST['client_id'];
$search_by_client="";
if($client_id != ''){
    $search_by_client.=" and a.client_id = '$client_id' ";
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
            a.origin like '%".$item."%' or 
            a.destination like '%".$item."%' or 
            a.service like '%".$item."%' or 
            a.agent_name like '%".$item."%' or  
            a.fecha like '%".$item."%') ";
    }
}

## Total number of records without filtering
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id  where 1  ".$search_by_client." and a.agent_email='$email' AND  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' ");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id where  1  ".$search_by_client." and a.agent_email='$email'  ");   
    }
  }elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id  where  1  ".$search_by_client." and  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' "); 
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id where 1  ".$search_by_client." ");   
    }
    
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id WHERE 1  ".$search_by_client." and a.agent_email='$email' AND  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." ");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id WHERE  1  ".$search_by_client." and a.agent_email='$email' AND  1 ".$searchQuery." ");   
    }
   
  }elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id WHERE  1  ".$search_by_client." and  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." ");   
    
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from quotations a left join accounts b on a.client_id=b.id WHERE  1 ".$search_by_client." ".$searchQuery." ");   
    }
   
}

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $empQuery = "select a.*, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name from quotations a left join accounts b on a.client_id=b.id WHERE 1  ".$search_by_client." and a.agent_email='$email' AND  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

    }else{
        $empQuery = "select a.*, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name from quotations a left join accounts b on a.client_id=b.id WHERE 1  ".$search_by_client." and a.agent_email='$email' AND  1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    }
    
}elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $empQuery = "select a.*, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name from quotations a left join accounts b on a.client_id=b.id WHERE  1  ".$search_by_client." and DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;    

    }else{
        $empQuery = "select a.*, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name from quotations a left join accounts b on a.client_id=b.id WHERE  1 ".$search_by_client." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;    
    }
    
}
$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {   

    $service=$row['service'];
    if ($service=='') {$service=' ';}
    elseif ($service=='Air Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/air.png" style="width:40px; position:relative; top:10px;"><br>';}
    elseif($service=='Ocean Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/ocean.png" style="width:40px; position:relative; top:10px;"><br>';}
    else{ $service_img='<span style="position:relative; top:0px;"><img src="./img/pending.png" style="width:20px; position:relative; top:4px;"><br>';}
    $service = ' '.$service_img.$row['service'].'</span>';
   
    
   
    $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";

    $result = $connect->query("SELECT COUNT(*) AS total FROM notes WHERE jobOrderId='".$row["id"]."'")->fetch_array();
    if($result[0]!='0'){
        $brage='<span class="label label-success brage">'.$result[0].'</span>';
    }else{
        $brage=''; 
    }
    $shortcut = '<a href="#" onclick="editquotation('.$row['id'].')"><i class="fa fa-edit action"></i></a><a href="#" onclick="viewNotes('.$row['id'].')"><i class="fa fa-file-o action"></i>'.$brage.'</a><br><a href="./quotationPDF.php?id='.$row['id'].'"    target="blank"><i class="fa fa-file-pdf-o action"></i></a>';
   
   
    $agent='<i style="font-size:25px;" class="fa fa-user"></i><br>'.$row['agent_name'];
    // if ($agent=='') {$agent=' ';}
    
        $data[] = array(
                "fecha"=>$row['fecha'],
                "id"=>$row['id'],
                "client_name"=>$row['client_name'],
                "origin"=>$row['origin'],
                "destination"=>$row['destination'],
                "service"=>$row['service'],
                "agent_name"=>$agent,             
                "shortcut"=>$shortcut
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