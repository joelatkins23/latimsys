<?php
include 'conn.php';
session_start();
$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rowAgent = mysqli_fetch_array($consultaAgent)){  
    $level=$rowAgent['level'];
} 
$consultaconsignee = mysqli_query($connect, "SELECT * FROM accounts WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rows = mysqli_fetch_array($consultaconsignee)){  
    $asdasdas=$rows['id'];
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
$serach_text="";
if(isset($_POST['fecha']) && !empty($_POST['fecha'])){
    $serach_text.=" and a.fecha like '%".$_POST['fecha']."%' ";
}
if(isset($_POST['tracking']) && !empty($_POST['tracking'])){
    $serach_text.=" and a.tracking like '%".$_POST['tracking']."%' ";
}
if(isset($_POST['supplier_id']) && !empty($_POST['supplier_id'])){
    $serach_text.=" and a.supplier_id like '%".$_POST['supplier_id']."%' ";
}
if(isset($_POST['consignee_id']) && !empty($_POST['consignee_id'])){
    $serach_text.=" and a.fecha like '%".$_POST['fecha']."%' ";
}

if(isset($_POST['agent_id']) && !empty($_POST['agent_id'])){
    $serach_text.=" and a.agent_id like '%".$_POST['agent_id']."%' ";
}
if(isset($_POST['bill_id']) && !empty($_POST['bill_id'])){
    $serach_text.=" and a.bill_id like '%".$_POST['bill_id']."%' ";
}
if(isset($_POST['reference_id']) && !empty($_POST['reference_id'])){
    $serach_text.=" and a.reference_id like '%".$_POST['reference_id']."%' ";
}
if(isset($_POST['invoice']) && !empty($_POST['invoice'])){
    $serach_text.=" and a.invoice like '%".$_POST['invoice']."%' ";
}
if(isset($_POST['delivered_by1']) && !empty($_POST['delivered_by1'])){
    $serach_text.=" and a.delivered_by1 like '%".$_POST['delivered_by1']."%' ";
}
if(isset($_POST['branch']) && !empty($_POST['branch'])){
    $serach_text.=" and a.branch like '%".$_POST['branch']."%' ";
}
if(isset($_POST['pickup_number']) && !empty($_POST['pickup_number'])){
    $serach_text.=" and a.pickup_number like '%".$_POST['pickup_number']."%' ";
}
if(isset($_POST['location1']) && !empty($_POST['location1'])){
    $serach_text.=" and a.location1 like '%".$_POST['location1']."%' ";
}
if(isset($_POST['location2']) && !empty($_POST['location2'])){
    $serach_text.=" and a.location2 like '%".$_POST['location2']."%' ";
}
if(isset($_POST['can']) && !empty($_POST['can'])){
    $serach_text.=" and a.can like '%".$_POST['can']."%' ";
}
if(isset($_POST['instination']) && !empty($_POST['instination'])){
    $serach_text.=" and a.instination like '%".$_POST['instination']."%' ";
}
if(isset($_POST['destination']) && !empty($_POST['destination'])){
    $serach_text.=" and a.destination like '%".$_POST['destination']."%' ";
}
if(isset($_POST['status']) && !empty($_POST['status'])){
    $serach_text.=" and a.status like '%".$_POST['status']."%' ";
}
if(isset($_POST['dangerous_goods']) && !empty($_POST['dangerous_goods'])){
    $serach_text.=" and a.dangerous_goods like '%".$_POST['dangerous_goods']."%' ";
}
if(isset($_POST['seo']) && !empty($_POST['seo'])){
    $serach_text.=" and a.seo like '%".$_POST['seo']."%' ";
}
if(isset($_POST['insurance']) && !empty($_POST['insurance'])){
    $serach_text.=" and a.insurance like '%".$_POST['insurance']."%' ";
}
if(isset($_POST['fragile']) && !empty($_POST['fragile'])){
    $serach_text.=" and a.fragile like '%".$_POST['fragile']."%' ";
}
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
            a.total_pieces like '%".$item."%' or
            a.total_weight like '%".$item."%' or 
            a.total_volume like '%".$item."%' or 
            a.value like '%".$item."%' or 
            a.reference_id like '%".$item."%' or  
            a.destination like '%".$item."%' or  
            a.status like '%".$item."%' or  
            a.tracking like '%".$item."%' or  
            a.fecha like '%".$item."%' ) ";
    }
}

## Total number of records without filtering
if ($to!='' && $from!='') {
    $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
    left join accounts b on (a.supplier_id=b.id) where 1  ".$serach_text." and  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and a.deleted=0");
}else{
    $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
    left join accounts b on (a.supplier_id=b.id) where 1  ".$serach_text." and a.deleted=0");   
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
        left join accounts b on (a.supplier_id=b.id) WHERE 1  ".$serach_text." and DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." and a.deleted=0");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
        left join accounts b on (a.supplier_id=b.id) WHERE  1 ".$serach_text." ".$searchQuery." and a.deleted=0");   
    }

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

if ($to!='' && $from!='') {
    $empQuery = "select a.*, b.name as supplier_name,c.name as consignee_name from warehouse a
        left join accounts b on (a.supplier_id=b.id)
        left join accounts c on (a.consignee_id=c.id)
    WHERE 1  ".$serach_text." and DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' ".$searchQuery." and a.deleted=0 order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}else{
    $empQuery = "select * from warehouse  b.name as supplier_name,c.name as consignee_name from warehouse a
    left join accounts b on (a.supplier_id=b.id)
    left join accounts c on (a.consignee_id=c.id) WHERE  1  ".$serach_text." ".$searchQuery." and a.deleted=0 order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}
$empRecords = mysqli_query($connect, $empQuery);
$data = array();

// echo $empQuery;

while ($row = mysqli_fetch_assoc($empRecords)) {
        $shortcut='<a href="#" onclick="editwarehouse('.$row['id'].')"><i class="fa fa-edit action"></i></a>';
        $t = strtotime($row['fecha']); date('d/m/y',$t);
        if($row['instination']=='Air door to door' || $row['instination']=='Air Service'){
            $instination='<img src="./img/air.png" style="width: 50px;">';
        }elseif($row['instination']=='Ocean door to door' || $row['instination']=='Ocean Service'){
            $instination='<img src="./img/ocean.png" style="width: 50px;">';
        }else{
            $instination='';
        }
        if(in_array($row["id"], $jobCheckval, true)){
            $action = '<input type="checkbox" name="jobCheck[]" checked  value="'.$row['id'].'" style="transform : scale(1.5);">';
        }else{
            $action = '<input type="checkbox" name="jobCheck[]"  value="'.$row['id'].'" style="transform : scale(1.5);">';
        }
        $data[] = array(
                "fecha"=>date('m/d/Y',$t),
                "id"=>$row['id'],
                "destination"=>$row['destination'],
                "instination"=>$instination,
                "supplier_id"=>$row['supplier_name'],
                "consignee_id"=>$row['consignee_name'],
                "total_pieces"=>$row['total_pieces'],
                "total_weight"=>$row['total_weight'],
                "total_volume"=>$row['total_volume'],
                "value"=>$row['value'],
                "reference_id"=>$row['reference_id'],
                "tracking"=>$row['tracking'],
                "status"=>$row['status'],
                "shortcut"=>$shortcut,
                "action"=>$action,
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