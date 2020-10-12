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
$checklist=$_POST['checklist'];
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
            a.fecha like '%".$item."%' ) ";
    }
}

## Total number of records without filtering
if ($to!='' && $from!='') {
    $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
    left join accounts b on (a.supplier_id=b.id) where 1   and  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and a.deleted=0 and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' ) and a.selected=0  ");
}else{
    $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
    left join accounts b on (a.supplier_id=b.id) where 1   and a.deleted=0 and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' ) and a.selected=0  ");   
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
    if ($to!='' && $from!='') {
        $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
        left join accounts b on (a.supplier_id=b.id) WHERE 1   and DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' and 1 ".$searchQuery." and a.deleted=0 and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' ) and a.selected=0  ");
    }else{
        $sel = mysqli_query($connect,"select count(*) as allcount from warehouse a
        left join accounts b on (a.supplier_id=b.id) WHERE  1  ".$searchQuery." and a.deleted=0 and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' ) and a.selected=0  ");   
    }

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

if ($to!='' && $from!='') {
    $empQuery = "select a.*, b.name as supplier_name,c.name as consignee_name from warehouse a
        left join accounts b on (a.supplier_id=b.id)
        left join accounts c on (a.consignee_id=c.id)
    WHERE 1  and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' ) and a.selected=0   and DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' ".$searchQuery." and a.deleted=0 order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}else{
    $empQuery = "select a.*, b.name as supplier_name,c.name as consignee_name from warehouse a
    left join accounts b on (a.supplier_id=b.id)
    left join accounts c on (a.consignee_id=c.id) WHERE  1 and a.selected=0   and (a.status='PRE-ALERT' or a.status='RECIBIDO EN BODEGA CHINA' )  ".$searchQuery." and a.deleted=0 order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}
$empRecords = mysqli_query($connect, $empQuery);
$data = array();

// echo $empQuery;

while ($row = mysqli_fetch_assoc($empRecords)) {
        $t = strtotime($row['fecha']); date('d/m/y',$t);
        $id='<a href="#" style="color:red" onclick="editwarehouse('.$row['id'].')">'.$row['id'].'</a>';
        $action = '<input type="checkbox" name="jobCheck[]"  value="'.$row['id'].'" style="transform : scale(1.5);">';
       
        if($checklist){
            $checkarr=explode(",", $checklist);
            if (!in_array($row['id'],  $checkarr)) { 
                $data[] = array(
                    "fecha"=>date('m/d/Y',$t),
                    "id"=>$id,
                    "destination"=>$row['destination'],
                    "supplier_id"=>$row['supplier_name'],
                    "consignee_id"=>$row['consignee_name'],
                    "total_pieces"=>$row['total_pieces'],
                    "total_weight"=>$row['total_weight'],
                    "total_volume"=>$row['total_volume'],
                    "value"=>$row['value'],
                    "reference_id"=>$row['reference_id'],
                    "action"=>$action,
                );
            } 
            
        }else{
            $data[] = array(
                "fecha"=>date('m/d/Y',$t),
                "id"=>$id,
                "destination"=>$row['destination'],
                "supplier_id"=>$row['supplier_name'],
                "consignee_id"=>$row['consignee_name'],
                "total_pieces"=>$row['total_pieces'],
                "total_weight"=>$row['total_weight'],
                "total_volume"=>$row['total_volume'],
                "value"=>$row['value'],
                "reference_id"=>$row['reference_id'],
                "action"=>$action,
            );
        }
        
        
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);