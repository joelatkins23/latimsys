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
    foreach($filter_arr as $key=>$item){    

            $searchQuery.= " and (a.id like '%".$item."%' or 
            a.fecha like '%".$item."%' or
            a.ticket_id like '%".$item."%' or 
            a.note like '%".$item."%' or 
            a.imagen like '%".$item."%' or 
            a.agent_name like '%".$item."%') ";
    }
}

## Total number of records without filtering
if ($level=='Seller') { 
   
    $sel = mysqli_query($connect,"select count(*) as allcount FROM ticket_notes a  LEFT JOIN tickets b ON a.ticket_id=b.id LEFT JOIN agents c ON b.agent_id=c.id  where c.email='$email' ");
   
  }else{
    $sel = mysqli_query($connect,"select count(*) as allcount from ticket_notes ");
}

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if ($level=='Seller') { 
   
    $sel = mysqli_query($connect,"select count(*) as allcount FROM ticket_notes a  LEFT JOIN tickets b ON a.ticket_id=b.id LEFT JOIN agents c ON b.agent_id=c.id  where c.email='$email' and 1 ".$searchQuery."");
   
  }else{
    $sel = mysqli_query($connect,"select count(*) as allcount from ticket_notes a LEFT JOIN tickets b ON a.ticket_id=b.id LEFT JOIN agents c ON b.agent_id=c.id where 1 ".$searchQuery."");
}



$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];
## Fetch records
if ($level=='Seller') { 
   
    $empQuery = "select a.* FROM ticket_notes a  LEFT JOIN tickets b ON a.ticket_id=b.id LEFT JOIN agents c ON b.agent_id=c.id  where c.email='$email' and 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
   
  }else{
    $empQuery = "select a.* from ticket_notes a LEFT JOIN tickets b ON a.ticket_id=b.id LEFT JOIN agents c ON b.agent_id=c.id where 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}

$empRecords = mysqli_query($connect, $empQuery);
$data = array();


while ($row = mysqli_fetch_assoc($empRecords)) {
    
    // $shortcut = '<a href="#" onclick="editticket('.$row['id'].')"><i class="fa fa-search-plus" style="color: #B80008;font-size: 24px;"></i></a>';
   
    
    // $agent='<i class="fa fa-user" style="font-size:25px;"></i><br><span>'.$row['agentname'].'</span>';
    if($row['imagen']){
        $image="<a href='images/Tickets/notes/".explode("../images/Tickets/notes/", $row['imagen'])[1]."' style='color:#3c8dbc;font-weight: 100;' target='blank'>".explode("../images/Tickets/notes/", $row['imagen'])[1]."</a>";
    }else{
        $image="";
    }
    $ticket_id='<a href="#" onclick="editticket('.$row['ticket_id'].')">'.$row['ticket_id'].'</a>';
        $data[] = array(
                "fecha"=>$row['fecha'],
                "ticket_id"=>$ticket_id,
                "note"=>$row['note'],
                "agent_name"=>$row['agent_name'],
                "imagen"=>$image
            );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data,
    "staus" => $level
);

echo json_encode($response);