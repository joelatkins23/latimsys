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

if ($level=='Seller' && $type=='quick') { 
    if ($to!='' && $from!='') {
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to'   AND (a.status='PENDING' OR a.status='READY TO CONTACT' OR a.status='CHECK NOTES' OR a.status='IN PROCESS' OR a.status='SHIPPED' OR a.status='CANCELED' OR (a.status='IN WAREHOUSE' AND a.fecha > '2020-01-01') )";

    }else{
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.branch=''  AND (a.status='PENDING' OR a.status='READY TO CONTACT' OR a.status='CHECK NOTES' OR a.status='IN PROCESS' OR a.status='SHIPPED' OR a.status='CANCELED' OR (a.status='IN WAREHOUSE' AND a.fecha > '2020-01-01') ) order by id desc";
    }
}elseif($level=='Seller' && $type=='all') {
    if ($to!='' && $from!='') {
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

    }else{
        $sql = " select a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' AND a.branch='' order by id desc";
    }
    
}elseif($level=='Seller' && $type=='warehouse') {
    if ($to!='' && $from!='') {
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    AND a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to'  AND (a.status='IN WAREHOUSE') order by id desc";

    }else{
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE d.email='$email' 
                    
                    AND a.branch='' AND (a.status='IN WAREHOUSE') order by id desc";
    }    
}elseif($level!='Seller' && $type=='quick'){
    if ($to!='' && $from!='') {
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE  a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to'  AND (a.status='PENDING' OR a.status='READY TO CONTACT' OR a.status='CHECK NOTES' OR a.status='IN PROCESS' OR a.status='SHIPPED' OR a.status='CANCELED' OR (a.status='IN WAREHOUSE' AND a.fecha > '2020-01-01') ) order by id desc";

    }else{
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE a.branch='' AND (a.status='PENDING' OR a.status='READY TO CONTACT' OR a.status='CHECK NOTES' OR a.status='IN PROCESS' OR a.status='SHIPPED' OR a.status='CANCELED' OR (a.status='IN WAREHOUSE' AND a.fecha > '2020-01-01') ) order by id desc";
    }
}elseif($level!='Seller' && $type=='all') {
    if ($to!='' && $from!='') {
        $sql = " select a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE  a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' order by id desc";

    }else{
        $sql = " select a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE  a.branch='' order by id desc";
    }
    
}elseif($level!='Seller' && $type=='warehouse') {  
    if ($to!='' && $from!='') {
        $sql = " select a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE  a.branch='' AND DATE_FORMAT(a.fecha,'%Y-%m-%d') BETWEEN '$from' and '$to' AND (a.status='IN WAREHOUSE') order by id desc";

    }else{
        $sql = " select  a.fecha, a.id, b.name as customer_name, c.company as supplier_company, a.service, a.customer_city,d.name as agent_name, a.status from joborders a 
                    left join accounts b on a.client_id =b.id 
                    left join accounts c on a.supplier_id =c.id 
                    left join agents d on a.agent_id=d.id 
                    WHERE  a.branch='' AND (a.status='IN WAREHOUSE') order by id desc";
    } 
}
  $setRec = mysqli_query($connect, $sql);  
  $string="Type:".$type." ";
  if ($to!='' && $from!='') {
        $string.="From:".$from." To:".$to;
  }
  $columnHeader = "" . "\t" . "" . "\t" ."" . "\t" . "" ."Job Order(".$string.")"."\t";  
  $setData = "FECHA" . "\t" . "JOB" . "\t" . "CUSTOMER NAME" . "\t". "SUPPLIER COMPANY" . "\t" . "SERVICE" . "\t" . "SHIP TO" . "\t" . "AGENT NAME" . "\t" . "STATUS" . "\t" . "WH #" . "\n";  
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
  header("Content-Disposition: attachment; filename=JobOrders_$fecha .xls");  
  header("Pragma: no-cache");  
  header("Expires: 0");  
  
  echo ucwords($columnHeader) . "\n" . $setData . "\n";  
  