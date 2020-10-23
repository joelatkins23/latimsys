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
$from = $_POST['from']; 
$to = $_POST['to']; 
## Search 
$searchQuery = " ";
if($searchValue != ''){
     
    $filter_arr=explode(" ", $searchValue);
    foreach($filter_arr as $key=>$item1){    
        $accented_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E','Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U','Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c','è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

        $item = strtr( $item1, $accented_array );
        $searchQuery.= " and (
        a.date like '%".$item."%' or
        b.name like '%".$item."%' or 
        b.company like '%".$item."%' or 
        d.name like '%".$item."%' or 
        d.company like '%".$item."%' or 
        e.name like '%".$item."%' or 
        e.company like '%".$item."%' or 
        c.company like '%".$item."%' or 
        c.station like '%".$item."%' or  
        a.total_invoiced like '%".$item."%' or  
        a.total_paid like '%".$item."%' or  
        a.purchase like '%".$item."%' or  
        a.reference like '%".$item."%' or  
        a.invoice_status like '%".$item."%') ";
    }
}

if ($to!='' && $from!='') {
    $sel = mysqli_query($connect,"select count(*) as allcount from invoices a
                    left join accounts b on a.account=b.id 
                    left join branches c on a.branch=c.id where
                    DATE_FORMAT(a.date,'%Y-%m-%d') BETWEEN '$from' and '$to'");
}else{
    $sel = mysqli_query($connect,"select count(*) as allcount from invoices a
                    left join accounts b on a.account=b.id 
                    left join branches c on a.branch=c.id ");  
}
 
  
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if ($to!='' && $from!='') {
    $sel = mysqli_query($connect,"select count(*) as allcount from invoices a
                left join accounts b on a.account=b.id 
                left join branches c on a.branch=c.id 
                left join accounts d on a.shipper=d.id 
                left join accounts e on a.consignee_id=e.id 
                WHERE 1 ".$searchQuery." and
                DATE_FORMAT(a.date,'%Y-%m-%d') BETWEEN '$from' and '$to'");
}else{
    $sel = mysqli_query($connect,"select count(*) as allcount from invoices a
                left join accounts b on a.account=b.id 
                left join branches c on a.branch=c.id 
                left join accounts d on a.shipper=d.id 
                left join accounts e on a.consignee_id=e.id 
                WHERE 1 ".$searchQuery."");   
}
    
    

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
if ($to!='' && $from!='') {
 
    $empQuery = "select a.*, CONCAT(c.station,' - ',c.company) as branch_name, CONCAT(b.name,' | ', b.company) as account_name, CONCAT(d.name,' | ', d.company) as shipper_name, CONCAT(e.name,' | ', e.company) as consignee_name from invoices a 
                left join accounts b on a.account=b.id 
                left join branches c on a.branch=c.id 
                left join accounts d on a.shipper=d.id 
                left join accounts e on a.consignee_id=e.id 
                WHERE  1  and DATE_FORMAT(a.date,'%Y-%m-%d') BETWEEN '$from' and '$to' ".$searchQuery." 
                order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}else{
    $empQuery = "select a.*, CONCAT(c.station,' - ',c.company) as branch_name, CONCAT(b.name,' | ', b.company) as account_name, CONCAT(d.name,' | ', d.company) as shipper_name, CONCAT(e.name,' | ', e.company) as consignee_name from invoices a 
                    left join accounts b on a.account=b.id 
                    left join branches c on a.branch=c.id 
                    left join accounts d on a.shipper=d.id 
                    left join accounts e on a.consignee_id=e.id 
            WHERE  1 ".$searchQuery." 
            order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}


$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
    $result = $connect->query("SELECT COUNT(*) AS total FROM invoices_notes WHERE invoice_id='".$row["id"]."'")->fetch_array();
    if($result[0]!='0'){
        $brage='<span class="label label-success brage">'.$result[0].'</span>';
    }else{
        $brage=''; 
    }
   
    $action = '<a href="#" data-toggle="tooltip" title="Notes" onclick="viewNotes('.$row['id'].')"><i class="fa fa-file-o action"></i>'.$brage.'</a><a href="#" data-toggle="tooltip" title="EDIT" onclick="editinvoice('.$row['id'].')"><i class="fa fa-edit action"></i></a><a href="./invoicePDF.php?id='.$row['id'].'" data-toggle="tooltip" title="PDF" target="blank"><i class="fa fa-file-pdf-o action"></i></a>';
   
    if ($row['invoice_status']=='PrePaid') {$status='<div style="font-weight:600; font-size:11px; color:white; padding:5px;width:70px; border:0.5px solid gray; background:#00a75a; ">'.$row['invoice_status'].'</div>';}
    else {$status='<div style="font-weight:600; font-size:11px; color:white; padding:5px;width:70px; border:0.5px solid gray; background:#db4c39; ">'.$row['invoice_status'].'</div>';}
    
        $data[] = array(
                "date"=>date_format(date_create($row['date']),'m/d/Y'),
                "branch_name"=>$row['branch_name'],
                "account_name"=>$row['account_name'],
                "shipper_name"=>$row['shipper_name'],
                "consignee_name"=>$row['consignee_name'],
                "total_invoiced"=>$row['total_invoiced'],
                "total_paid"=>$row['total_paid'],
                "purchase"=>$row['purchase'],
                "reference"=>$row['reference'],
                "invoice_status"=>$status,              
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