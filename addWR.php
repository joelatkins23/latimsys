<?php 


error_reporting(0);
session_start();

require_once('conn.php');

$id= $_GET['id'];

$from= $_GET['from'];

if ($from!='') {

$tFrom = strtotime($from);

$from1day = strtotime('-1 day', $tFrom);
   
$from=date('Y/m/d',$from1day);
}

$to= $_GET['to'];

if ($to!='') {
$tTo = strtotime($to);

$to1day = strtotime('+1 day', $tTo);
$to=date('Y/m/d',$to1day);
}

$dt = new DateTime($fecha);

$fecha = $dt->format('Y-m-d H:i:s');

 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_SESSION['username'];



 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
    or die ("Error al traer los Agent");


     while ($rowAgent = mysqli_fetch_array($consultaAgent)){

        $agent_name=$rowAgent['name'];
        $phone=$rowAgent['phone'];
        $picture=$rowAgent['picture'];
        $level=$rowAgent['level'];

        $noteBy=$rowAgent['name'];
        $customer_address= $row['customer_address']; 
                $supplier_address= $row['supplier_address']; 

                $customer_cityCountry = explode(" | ", $customer_address);
                $customer_cityCountry = $customer_cityCountry[1];

                $customer_Country = explode(" - ", $customer_cityCountry);
                $customer_Country = $customer_Country[1];
     }  

?>

 <?php
    if(isset($_POST["submitNote"]))
          {
              $jobOrderId= $_POST['jobOrderId'];
              $wr= $_POST['wr'];
              $noteBy= $_POST['noteBy'];
              $agent_name= $_POST['agent_name'];

              $dt = new DateTime($fecha);

$fecha = $dt->format('Y-m-d H:i:s');

$queryModel = mysqli_query($connect, "INSERT INTO receipt(jobOrderId, wr, fecha) 
                VALUES ('$jobOrderId', '$wr', '$fecha')");

$queryModel2222 = mysqli_query($connect, "UPDATE joborders SET status='IN WAREHOUSE' WHERE id='$jobOrderId' ") or die ('error');

$queryModel2333 = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha) 
                VALUES ('$agent_name', '$jobOrderId', 'Updated to:  IN WAREHOUSE.', '$fecha')");


   

    echo "<script type='text/javascript'>opener.location.reload(); //This will refresh parent window.
window.close(); //Close child window. You may also use self.close();</script>";

         }
?>


<!DOCTYPE html>
<html>
<head>
  <title></title>

  <!-- Latim style -->
  <link rel="stylesheet" href="latimstyle.css">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link href="https://fonts.googleapis.com/css?family=Be+Vietnam&display=swap" rel="stylesheet">
</head>
<body>

  <?php

$consulta2 = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
                  

    while ($row = mysqli_fetch_array($consulta2)){  

              $jobId = $row['id'];
                $customer_company= $row['customer_company'];
                $customer_name= $row['customer_name']; 
                $customer_telf= $row['customer_telf'];
                $supplier_telf= $row['supplier_telf'];


                $customer_address= $row['customer_address']; 
                $supplier_address= $row['supplier_address']; 

                $service= $row['service'];
                $commodity= $row['commodity'];
                $remark= $row['remark'];
                $customer_if = $row['customer_name'];

                          if ($customer_company!='') { $customer_if .= ', '.$customer_company; }else{}


                         ?>
                <?php $supplier_company= $row['supplier_company'];
                $supplier_name= $row['supplier_name']; 

                $supplier_if = $row['supplier_name'];

                          if ($supplier_company!='') { $supplier_if .= ', '.$supplier_company; }else{}?>


                    <div>

                            <div class="modal-content" style="width:700px; position:relative; height:350px; overflow-y: scroll;  left:50%; margin-left:-350px; top:30px; padding:50px;">
                              <div class="contact-form">
                                <a class="close">&times;</a>
                                <h4 class="modal-title" style="font-size:18px; border-bottom:1px solid black; width:97%;"><span style="font-weight:600;">Add Warehouse Receipt</span> for Job Order #<?php echo $id;?> </h4><br>

                                <script>
function ConfirmDelete() {
  return confirm("Are you sure you want to delete?");
}
</script>
<form method="post">

                        <input style="display:none;" type="text" name="jobId" value="<?php echo $id;?>">


                        <input Onclick="return ConfirmDelete()" type="submit"value="Delete" name="submitDeleteJobOrder" class="deleteAccountBtn" style="position:absolute; left:190px; top:15px;">
</form>
<?php
    if(isset($_POST["submitDeleteJobOrder"]))
          {
              $id= $_POST['jobId'];
  
  $modifica= "DELETE FROM receipt WHERE jobOrderId='$id'";

  $resultado = mysqli_query($connect, $modifica)
  or die ("Error al insertar los registros");

  mysqli_close($connect);
  echo "<script type='text/javascript'>opener.location.reload(); //This will refresh parent window.
window.close(); //Close child window. You may also use self.close();</script>";

         }
?>

                                <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">

              <div style="width:100%; text-align:center;">
                <form method="POST">

                <div style="display:inline-block; float:left; width:30%;">
              

                  <div class="input-group" style="">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                    <input name="" style="width:180px;" type="text" class="form-control" placeholder="Company Name" disabled value="<?php echo $customer_if; ?>">
                    <input style="display:none;" value="<?php echo $customer_if; ?>" name="">
                  </div>
                  <br><br>

                  <div class="input-group" style="">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                    <input name="" style="width:180px;" type="text" class="form-control" placeholder="Company Name" disabled value="<?php echo $supplier_if; ?>">
                    <input style="display:none;" value="<?php echo $supplier_if; ?>" name="">
                  </div>
                  <br><br>

                  <div class="input-group" style="">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-cube"></i></span>
                    <input name="" style="width:180px;" type="text" class="form-control" placeholder="Company Name" disabled value="<?php echo $commodity; ?>">
                    <input style="display:none;" value="<?php echo $commodity; ?>" name="">
                  </div>



                </div>



 <br><br>
                  <!-- /.box-header -->
          <div style="display:inline-block; width:40%; margin-top:-50px; position: relative; left:0px;">
            <div class="box-body pad" style="">
              
                    <input name="wr" type="number" placeholder="Warehouse Receipt Number..." rows="10" cols="80" style="width:300px; text-align:center; position:relative; left:50%; margin-left:-150px; resize:none; height:50px;">
            </div>
            <input style="display:none;" value="<?php echo $jobId; ?>" name="jobOrderId">
            <input style="display:none;" type="text" name="agent_name" value="<?php echo $agent_name;?>">
              <input type="submit" value="Save" name="submitNote" class="form_1_submit" style="background:#007F46; width:300px; position:relative; left:65px; top:0px; z-index:9999;">

                </form>

              </div>
<br>
          </div>


<?php }  ?>

            </div>
            <!-- /.box-body -->

</body>
</html>