<?php 

error_reporting(0);


// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_SESSION['username'];


 require_once('conn.php');


  $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
    or die ("Error al traer los Agent");


     while ($rowAgent = mysqli_fetch_array($consultaAgent)){

        $agent_name=$rowAgent['name'];
        $agent_email=$rowAgent['agent_email'];
        $level=$rowAgent['level'];
      }



$conn = new mysqli('localhost', 'dbo799717597', 'Latim_Sys_123');  
mysqli_select_db($conn, 'db799717597');  

if ($email=='g.pernalete@latimcargo.com' OR $email=='rodiaz@latimcargo.com' OR $email=='Coord.ventas@latimcargo.com' OR $email=='Coord.ventas@latimcargo.com'OR $email=='manager@latimcargo.com') {
  $sql = "SELECT `fecha`,`id`,`blank`, `customer_name`, `supplier_company`,`service`,`customer_city`,`agent_name`,`status`,`wr`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank` FROM `joborders` WHERE branch='' "; 
}else{
  $sql = "SELECT `fecha`,`id`,`blank`, `customer_name`,`supplier_company`,`service`,`customer_city`,`agent_name`,`status`,`wr`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank`,`blank` FROM `joborders` WHERE agent_email='$email' AND branch='' "; }


$setRec = mysqli_query($conn, $sql);  
$columnHeader = '';  
$columnHeader = "FECHA" . "\t" . "JOB ORDER" . "\t" .  "# CT" . "\t" . "CLIENTE" . "\t". "PROVEEDOR" . "\t" . "SERVICIO" . "\t" . "DESTINO" . "\t" . "VENDEDOR" . "\t" . "STATUS" . "\t" . "# WAREHOUSE" . "\t". "PESO" . "\t". "VOLUMEN" . "\t". "EXPENDIENTE" . "\t". "SALIDA CHINA" . "\t". "INVOICE" . "\t". "PAGO I" . "\t" . "LLEGADA VZLA" . "\t". "PAGO II" . "\t". "BODEGA DESTINO" . "\t". "FECHA ENVIO BODEGA RR" . "\t". "FECHA ENTREGA CLIENTE" . "\t";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  

$dt = new DateTime($fecha);
$fecha = $dt->format('Y-m-d H:i:s');
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=JobOrders_$fecha .xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

  echo ucwords($columnHeader) . "\n" . $setData . "\n";  

header("Location: index.php");


 ?> 