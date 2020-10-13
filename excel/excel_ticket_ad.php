<?php 
include '../conn.php';
session_start();
$from=$_GET['from'];
$to=$_GET['to'];
$type=$_GET['type'];

$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
or die ("Error al traer los Agent");
while ($rowAgent = mysqli_fetch_array($consultaAgent)){  
  $agent_id= $rowAgent['id'];
    $level=$rowAgent['level'];

} 
if ($level=='Seller' && $type=='PENDING') {     
    if ($to!='' && $from!='') {
        $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE b.email='$email' AND a.status='PENDING' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

    }else{
        $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE b.email='$email'  AND a.status='PENDING' order by id desc";
    }  
  }elseif($level=='Seller' && $type!='PENDING'){
    if ($to!='' && $from!='') {
        $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE b.email='$email'  AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

    }else{
        $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE b.email='$email'  order by id desc";
    } 
   
    
}
if ( ($level=='Administrator' || $level=='master') && $type=='PENDING') {
        if ($to!='' && $from!='') {
            $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE a.status='PENDING' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

        }else{
            $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE a.status='PENDING' order by id desc";
        }   
        

    }elseif(($level=='Administrator' || $level=='master') && $type!='PENDING'){
        if ($to!='' && $from!='') {
            $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  WHERE  DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

        }else{
            $sql = "select a.fecha, a.id, a.name, a.supplier, a.type, a.service,b.name as agentname,a.status from tickets_ad a left join agents b  on a.agent_id=b.id  order by id desc";
        } 
    
}

  $setRec = mysqli_query($connect, $sql);  
  $string="Type:".$type." ";
  if ($to!='' && $from!='') {
        $string.="From:".$from." To:".$to;
  }
  $columnHeader = "" . "\t" . "" . "\t" ."" . "\t" . "" ."TICKET(".$string.")"."\t";  
  $setData = "FECHA" . "\t" . "TICKET" . "\t" .  "CLIENTE" . "\t" . "SUPPLIER" . "\t". "TYPE" . "\t" . "SERVICE" . "\t" . "AGENT" . "\t" . "STATUS" . "\n";  
  while($rec = mysqli_fetch_assoc($setRec)){
      $rowData = '';  
      foreach ($rec as $value) {  
          $value = '"' . $value . '"' . "\t";  
          $rowData .= $value;  
      }  
      $setData .= trim($rowData) . "\n";  
  }  
  
  $fecha = date('Y-m-d H:i:s');
    
  header("Content-type: application/octet-stream");  
  header("Content-Disposition: attachment; filename=administration_ticket_$fecha .xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");  
  
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  