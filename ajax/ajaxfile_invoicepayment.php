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
        $searchQuery.= " and (
        a.date like '%".$item."%' or 
        a.number like '%".$item."%' or 
        a.id like '%".$item."%' or 
        b.name like '%".$item."%' or 
        c.name like '%".$item."%' or 
        d.name like '%".$item."%') ";
    }
}


$sel = mysqli_query($connect,"select count(*) as allcount from invoicepayments a
            left join accounts b on a.account=b.id 
         ");   
  
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering

    $sel = mysqli_query($connect,"select count(*) as allcount from invoicepayments a
            left join branches b on a.branch=b.id 
            left join bill_type c on a.type=c.id 
            left join accounts d on a.account=d.id 
        WHERE 1 ".$searchQuery."");   
    

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

$empQuery = "select a.*, b.station as branch_name, CONCAT(c.name,' ', a.number) as type_name, d.name as account_name from invoicepayments a 
            left join branches b on a.branch=b.id 
            left join bill_type c on a.type=c.id 
            left join accounts d on a.account=d.id 
            WHERE  1 ".$searchQuery." 
            order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// echo $empQuery;
$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
    $result = $connect->query("SELECT COUNT(*) AS total FROM invoicepayments_files WHERE invoice_payment_id='".$row["id"]."'")->fetch_array();
    if($result[0]!='0'){
        $brage='<span class="label label-success brage">'.$result[0].'</span>';
    }else{
        $brage=''; 
    }
   
    $action = '<a href="#" data-toggle="tooltip" title="VIEW" onclick="viewinvoicePayment('.$row['id'].')"><i class="fa fa-eye action"></i></a><a href="#" data-toggle="tooltip" title="Files" onclick="viewFilelist('.$row['id'].')"><i class="fa fa-file-o action"></i>'.$brage.'</a><a href="./invoicepaymentpdf.php?id='.$row['id'].'" target="blank" data-toggle="tooltip" title="PDF"><i class="fa fa-file-pdf-o action"></i><a href="#" onclick="deleteinvoicePayment('.$row['id'].')" data-toggle="tooltip" title="DELET"><i class="fa fa-trash action"></i></a>';
   
        $data[] = array(
                "date"=>date_format(date_create($row['date']),'m/d/Y'),
                "branch_name"=>$row['branch_name'],
                "type_name"=>$row['type_name'],
                "id"=>$row['id'],
                "account_name"=>$row['account_name'],
                "amount"=>$row['amount'],
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