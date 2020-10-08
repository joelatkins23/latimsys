<?php 
include '../conn.php';
session_start();
$from=$_GET['from'];
$to=$_GET['to'];

$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rowAgent = mysqli_fetch_array($consultaAgent)){  
  $agent_id= $rowAgent['id'];
    $level=$rowAgent['level'];

} 
if ($level=='Seller') { 
    if ($to!='' && $from!='') {
        $sql = "select  a.fecha, a.id, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name, a.origin,a.destination,a.service, a.agent_name from quotations a left join accounts b on a.client_id=b.id WHERE a.agent_email='$email' AND  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

    }else{
        $sql = "select  a.fecha, a.id, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name, a.origin,a.destination,a.service, a.agent_name from quotations a left join accounts b on a.client_id=b.id WHERE a.agent_email='$email' order by id desc";
    }
    
}elseif($level!='Seller'){
    if ($to!='' && $from!='') {
        $sql = "select  a.fecha, a.id, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name, a.origin,a.destination,a.service, a.agent_name from quotations a left join accounts b on a.client_id=b.id WHERE  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";    

    }else{
        $sql = "select  a.fecha, a.id, IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name, a.origin,a.destination,a.service, a.agent_name from quotations a left join accounts b on a.client_id=b.id order by id desc";    
    }
    
}
  $setRec = mysqli_query($connect, $sql);  
  $string='';
  if ($to!='' && $from!='') {
        $string.="(From:".$from." To:".$to.")";
  }
  $columnHeader = "" . "\t" . "" . "\t" ."" . "\t" . "" ."Quotations".$string."\t";  
  $setData = "FECHA" . "\t" . "Quotation" . "\t" . "CUSTOMER NAME" . "\t". "ORIGIN" . "\t" . "DESTINATION" . "\t" . "SERVICE" . "\t" . "AGENT NAME" . "\n";  
  while($rec = mysqli_fetch_assoc($setRec)){
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
  
  $fecha = date('Y-m-d H:i:s');
    
  header("Content-type: application/octet-stream");  
  header("Content-Disposition: attachment; filename=Quotations_$fecha .xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");  
  
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  