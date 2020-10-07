<?php 
include 'conn.php';
session_start();
$id=$_GET['id'];
$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rowAgent = mysqli_fetch_array($consultaAgent)){  
  $agent_id= $rowAgent['id'];
    $level=$rowAgent['level'];

} 
$consultajob = mysqli_query($connect, "select * from pre_loading_plan where id='$id'") or die ("Error al traer los Agent");

while ($rowjob = mysqli_fetch_array($consultajob)){  
    $joblist= $rowjob['joborder_list'];  
} 
$job_arr=json_decode($joblist);
if($job_arr==Null){
    $arr='[]';
    $job_arr=json_decode($arr);
}
$columnHeader = "" . "\t" . "" . "\t" ."" . "\t" . "" ."PRE ROADING PLAN #".$id."\t";  
$setData = "FECHA" . "\t" . "JOB" . "\t" . "CUSTOMER NAME" . "\t". "SUPPLIER COMPANY" . "\t" . "SERVICE" . "\t" . "SHIP TO" . "\t" . "AGENT NAME" . "\t" . "STATUS" . "\t" . "WH #" . "\n";  
foreach($job_arr as $item){
    $getjoborder= mysqli_query($connect, "select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
    left join accounts b on a.client_id =b.id 
    left join accounts c on a.supplier_id =c.id 
    left join agents d on a.agent_id=d.id 
    where a.id='$item'");
    while($rec = mysqli_fetch_assoc($getjoborder)){
            $rowData = '';  
            foreach ($rec as $value) {  
                $value = '"' . $value . '"' . "\t";  
                $rowData .= $value;  
            }  
            $WHReceipt='';
            $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$rec['id']."' order by id desc limit 1 ") or die ("Error al traer los Agent");
                while ($rowWR = mysqli_fetch_assoc($consultaWR)){
                    $WHReceipt=$rowWR['wr'];
                }
            $rowData .= '"' . $WHReceipt . '"' . "\t";
            $setData .= trim($rowData) . "\n";  
        }  
}
  $fecha = date('Y-m-d H:i:s');
    
  header("Content-type: application/octet-stream");  
  header("Content-Disposition: attachment; filename=PreLoadingPlan_$fecha .xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");  
  
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  