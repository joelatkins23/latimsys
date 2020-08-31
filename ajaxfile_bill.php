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


$sel = mysqli_query($connect,"select count(*) as allcount from bills a
            left join accounts b on a.account=b.id 
            left join branches c on a.branch=c.id 
         ");   
  
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering

    $sel = mysqli_query($connect,"select count(*) as allcount from bills a
    left join accounts b on a.account=b.id 
    left join branches c on a.branch=c.id 
        WHERE 1 ".$searchQuery."");   
    

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

$empQuery = "select a.*, CONCAT(c.station,' - ',c.company) as branch_name, CONCAT(b.name,' | ', b.company) as account_name from bills a 
                    left join accounts b on a.account=b.id 
                    left join branches c on a.branch=c.id 
            WHERE  1 ".$searchQuery." 
            order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {

   
    $action = '<a href="#" onclick="editBill('.$row['id'].')"><i class="fa fa-edit action"></i></a>';
   
    
        $data[] = array(
                "date"=>$row['date'],
                "branch_name"=>$row['branch_name'],
                "account_name"=>$row['account_name'],
                "inv"=>$row['inv'],
                "description"=>$row['description'],
                "amount"=>$row['amount'],
                "paid"=>$row['paid'],
                "cost_center"=>$row['cost_center'],
                "warehouse"=>$row['warehouse'],
                "file"=>$row['file'],
                "house"=>$row['house'],
                "due_date"=>$row['due_date'],
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