<?php 
error_reporting(0);
require_once('conn.php');   
session_start();
$message= $_GET['message'];
$step= $_GET['step'];
$warehouse_id= $_GET['warehouse_id'];
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
     } 

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Latim Cargo & Trading | Shipment Create</title>
    <link rel="icon" type="image/x-icon" href="icoplane.ico" />
    <!-- CSS -->
    <link href='plugins/select2/select2.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href=" https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href='plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./plugins/datepicker/datepicker3.css">    
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="latimstyle.css">
    <link href='assets/css/style.css' rel='stylesheet' type='text/css'>
    <link href='assets/css/imageuploadify.min.css' rel='stylesheet' type='text/css'>
    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>   
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/imageuploadify.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script> 
    <script src="plugins/select2/select2.js"></script>
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/moment.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script>
    window.addEventListener("load", function(){
      var load_screen = document.getElementById("load_screen");
      document.body.removeChild(load_screen);
    });
</script>
</head>

<body class="hold-transition sidebar-mini">
  <div id="load_screen"><div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div></div>
<div class="wrapper">
  <?php include 'layout/header.php' ?>
  <?php include 'layout/sidebar.php' ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SHIPMENT 
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create SHIPMENT</li>
      </ol>
    </section>

    <section class="content">

<?php if ($step=='') {$step='1';} ?>

<?php if ($step=='1'){ ?>
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px; padding:30px">
          <div class="row" >
            <div class="col-md-12 text-center">              
                <h3 style="color:black; font-weight:400; padding:10px; font-size:20px;">CREATE SHIPMENT</h3>             
            </div>
          </div>
          <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li ><a data-toggle="tab" href="#home"><i class="fa fa-ship"></i>&nbsp;Summary File 188 | BL HBS</a></li>
                        <li class="active"><a data-toggle="tab" href="#shipment_update"><i class="fa fa-save"></i>&nbsp;UPDATE</a></li>
                        <li><a data-toggle="tab" href="#shipment_charges"><i class="fa fa-files-o"></i>&nbsp;CHARGES</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade ">
                            <!-- <div class="row" >
                                <div class="col-md-12" >
                                    <h4 class="" style="background: green;padding: 5px;color: white;width: fit-content;" >IN VERIFICATION PROCESS</h4>
                                </div>
                            </div> -->
                            <div class="row" >
                                <div class="col-md-12" >
                                  <div class="table-responsive" style="padding:20px">
                                      <table  style="width:100%;" class="table" >
                                          <thead>
                                            <tr class="text-center">
                                              <th>Pieces</th>
                                              <th>Weight</th>
                                              <th>Volume</th>
                                              <th>CBM</th>
                                              <th>Terms</th>
                                              <th>Income</th>
                                              <th>Expense</th>
                                              <th>Prevision</th>
                                              <th>Profit</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td class="text-center">&nbsp;</td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                              <td class="text-center"></td>
                                            </tr>
                                          </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">Supplier</span>
                                        <select name="supplier_id" id="" class="form-control select2" data-placeholder="Select Supplier" style="max-width: 100%;min-width: 100%" >
                                          <option value="">--Select Supplier--</option>
                                        <?php 
                                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                                          or die ("Error al traer los Agent");
                                          while ($row = mysqli_fetch_array($consulta)){
                                              $ID=$row['id'];
                                              $name=$row['name'];
                                              $company=$row['company'];
                                              $city=$row['city'];
                                        ?>
                                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">Consignee</span>
                                      <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="max-width: 100%;min-width: 100%;" >
                                          <option value="">--Select Consignee--</option>
                                        <?php 
                                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                          or die ("Error al traer los Agent");
                                          while ($row = mysqli_fetch_array($consulta)){
                                      
                                              $ID=$row['id'];
                                              $name=$row['name'];
                                              $company=$row['company'];
                                              $city=$row['city'];
                                            
                                        ?>
                                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">Agent</span>
                                      <select name="agent_id" id="" class="form-control select2" data-placeholder="Select Agent" style="max-width: 100%;min-width: 100%;" >
                                          <option value="">--Select Agent--</option>
                                        <?php 
                                          $consulta = mysqli_query($connect, "SELECT * FROM agents  where level='Administrator' or level='Seller' order by id ")
                                          or die ("Error al traer los Agent");
                                          while ($row = mysqli_fetch_array($consulta)){
                                      
                                              $ID=$row['id'];
                                              $name=$row['name'];
                                        ?>
                                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>                  
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">Bill to</span>
                                      <select name="bill_id" id="" class="form-control select2" data-placeholder="Select Bill" style="max-width: 100%;min-width: 100%;" >
                                          <option value="">--Select Bill--</option>
                                        <?php 
                                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                          or die ("Error al traer los Agent");
                                          while ($row = mysqli_fetch_array($consulta)){
                                      
                                              $ID=$row['id'];
                                              $name=$row['name'];
                                              $company=$row['company'];
                                              $city=$row['city'];
                                            
                                        ?>
                                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label  class="col-md-4 text-center control-label"  for="">Carrier</label>
                                  <div class="col-md-8">
                                    <label  class="control-label" style="font-weight:bold">HAMBURO SUD CHINA</label>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-8">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">Vessel</span>
                                        <input type="text" name="vessel" class="form-control" placeholder="">
                                    </div>
                                  </div>                                
                                  <div class="col-md-4">                    
                                        <input type="text" name="location2" class="form-control" placeholder="">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">ETD</span>
                                        <input type="text" class="form-control" data-provide="datepicker" id="etd"
                                                data-date-format="yyyy-mm-dd" laceholder="ETD" value="<?php echo date('Y-m-d'); ?>"  name="etd"  autocomplete="off"  placeholder="ETD">
                                        <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <div class="input-group">
                                      <span class="input-group-addon span_custom">ETA</span>
                                      <input type="text" class="form-control" data-provide="datepicker" id="eta"
                                                data-date-format="yyyy-mm-dd" laceholder="ETA" value="<?php echo date('Y-m-d'); ?>"  name="eta"  autocomplete="off"  placeholder="ETA">
                                      <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label  class="col-md-4 text-center control-label" for="">Status</label>
                                  <div class="col-md-8">
                                    <label  class="control-label" style="font-weight:bold">In Transit</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Branch</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Branch">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Line</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Line">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Insurance</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Insurance">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Value</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Value">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Dangerous</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Dangerous">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">COD</span>
                                            <input type="text" name="branch" class="form-control" placeholder="COD">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Booking</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Booking">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Reference</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Reference">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom" style="font-size:13px;">Instructions</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Instructions">
                                        </div>
                                      </div>
                                    </div>         
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-8">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom" >Orig/Dest</span>
                                            <input type="text" name="orig" class="form-control" placeholder="">
                                        </div>
                                      </div>
                                      <div class="col-md-4">                    
                                        <input type="text" name="dest" class="form-control" placeholder="">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Rate</span>
                                            <input type="text" name="rate" class="form-control" placeholder="Rate">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Freight</span>
                                            <input type="text" name="freight" class="form-control" placeholder="Freight">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Agent</span>
                                            <input type="text" name="agent" class="form-control" placeholder="Agent">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Carrier</span>
                                            <input type="text" name="branch" class="form-control" placeholder="Reference">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Total</span>
                                            <input type="text" name="total" class="form-control" placeholder="Total">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Exchange</span>
                                            <input type="text" name="exchange" class="form-control" placeholder="Exchange">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Invoiced</span>
                                            <input type="text" name="invoiced" class="form-control" placeholder="Invoiced">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <div class="input-group">
                                          <span class="input-group-addon span_custom">Print</span>
                                            <input type="text" name="print" class="form-control" placeholder="Print">
                                        </div>
                                      </div>
                                    </div>          
                                  </div>         
                                </div>                               
                              </div>
                            </div>
                        </div>
                        <div id="shipment_update" class="tab-pane fade in active">
                          <div class="row" style="margin-top:20px;">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Supplier</label>
                                <div class="col-md-8">
                                  <select name="supplier_id" id="" class="form-control select2" data-placeholder="Select Supplier" style="width:100%" >
                                      <option value="">--Select Supplier--</option>
                                    <?php 
                                      $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                                      or die ("Error al traer los Agent");
                                      while ($row = mysqli_fetch_array($consulta)){
                                          $ID=$row['id'];
                                          $name=$row['name'];
                                          $company=$row['company'];
                                          $city=$row['city'];
                                    ?>
                                      <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Consignee</label>
                                <div class="col-md-8">
                                  <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="max-width: 100%;min-width: 100%;" >
                                      <option value="">--Select Consignee--</option>
                                    <?php 
                                      $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                      or die ("Error al traer los Agent");
                                      while ($row = mysqli_fetch_array($consulta)){
                                  
                                          $ID=$row['id'];
                                          $name=$row['name'];
                                          $company=$row['company'];
                                          $city=$row['city'];
                                        
                                    ?>
                                      <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Bill To</label>
                                <div class="col-md-8">
                                  <select name="bill_id" id="" class="form-control select2" data-placeholder="Select Bill" style="max-width: 100%;min-width: 100%;" >
                                    <option value="">--Select Bill--</option>
                                  <?php 
                                    $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                    or die ("Error al traer los Agent");
                                    while ($row = mysqli_fetch_array($consulta)){
                                
                                        $ID=$row['id'];
                                        $name=$row['name'];
                                        $company=$row['company'];
                                        $city=$row['city'];
                                      
                                  ?>
                                    <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Origin</label>
                                <div class="col-md-8">
                                      <input type="text" name="origin" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Destination</label>
                                <div class="col-md-8">
                                      <input type="text" name="destination" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">commodity</label>
                                <div class="col-md-8">
                                      <input type="text" name="commodity" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Service</label>
                                <div class="col-md-8">
                                      <input type="text" name="service" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Instructions</label>
                                <div class="col-md-8">
                                      <input type="text" name="instructions" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Customs Office</label>
                                <div class="col-md-8">
                                      <input type="text" name="customs_office" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-md-12">
                                      <label for="staticEmail" class="control-label">Signature</label>
                                      <input type="text" name="signature" class="form-control" placeholder="">
                                </div>                                
                              </div>
                              <div class="form-group row">                                
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">Pre-Carriage</label>
                                      <input type="text" name="pre_carriage" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">place of receipt</label>
                                      <input type="text" name="place_of_receipt" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">                                
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">Exporting Carrier</label>
                                      <input type="text" name="exproting_carrier" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">Port of Loading</label>
                                      <input type="text" name="port_of_loading" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-md-12">
                                      <label for="staticEmail" class="control-label">Loading Pier/Terminal</label>
                                      <input type="text" name="loading_pier" class="form-control" placeholder="">
                                </div>                                
                              </div>
                              <div class="form-group row">                                
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">Foreign Port of Unlading</label>
                                      <input type="text" name="foreign_port" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-6">
                                      <label for="staticEmail" class="control-label">Place of Delivery</label>
                                      <input type="text" name="place_of_delivery" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-md-12">
                                      <label for="staticEmail" class="control-label">Type of Move</label>
                                      <input type="text" name="type_of_move" class="form-control" placeholder="">
                                </div>                                
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row" >
                                <label for="staticEmail" class="col-md-4 control-label text-right">Date</label>
                                <div class="col-md-8">
                                  <div class="input-group">                                     
                                    <input type="text" class="form-control" data-provide="datepicker" id="date"
                                              data-date-format="yyyy-mm-dd" laceholder="Date" value=""  name="date"  autocomplete="off"  placeholder="Date">
                                    <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Carrier</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">B/L Number</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Booking</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Export Ref.</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Routing Inst.</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Forw.Agent</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">State</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Reference</label>
                                <div class="col-md-8">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">AES ITN#</label>
                                <div class="col-md-4">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-4">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Terms</label>
                                <div class="col-md-2">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-4">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-2">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-md-offset-4 col-md-4">
                                  <label class="control-label">
                                    <input type="checkbox" name="show_volume" checked> Show volume
                                  </label>
                                </div>
                                <div class="col-md-4">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>                               
                              </div>
                              <div class="form-group row">
                                <div class="col-md-offset-4 col-md-8">
                                  <label class="control-label">
                                    <input type="checkbox" name="do_print" > Do not print logo
                                  </label>
                                </div>                                                          
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">COD</label>
                                <div class="col-md-2">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-4">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-2">
                                      <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Currency</label>
                                <div class="col-md-8">
                                      <select name="currency" id="" class="form-control">
                                        <option value="usd">USD</option>
                                      </select>
                                </div>
                                
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Declared</label>
                                <div class="col-md-8">
                                 <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>                                
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Insurance</label>
                                <div class="col-md-8">
                                 <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>                                
                              </div>
                              <div class="form-group row" >
                                <label for="staticEmail" class="col-md-4 control-label text-right">ETD</label>
                                <div class="col-md-8">
                                  <div class="input-group">                                     
                                    <input type="text" class="form-control" data-provide="datepicker" id="date"
                                              data-date-format="yyyy-mm-dd" laceholder="Date" value=""  name="date"  autocomplete="off"  placeholder="Date">
                                    <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row" >
                                <label for="staticEmail" class="col-md-4 control-label text-right">ETA</label>
                                <div class="col-md-8">
                                  <div class="input-group">                                     
                                    <input type="text" class="form-control" data-provide="datepicker" id="date"
                                              data-date-format="yyyy-mm-dd" laceholder="Date" value=""  name="date"  autocomplete="off"  placeholder="Date">
                                    <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-md-4 control-label text-right">Vessel</label>
                                <div class="col-md-3">
                                 <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>
                                <label for="staticEmail" class="col-md-2 control-label text-right">Voyage</label>
                                <div class="col-md-3">
                                 <input type="text" name="invoiced" class="form-control" placeholder="">
                                </div>                                
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="table-responsive" style="padding:20px 0px">
                                <table  style="width:100%;" class="table table-bordered" >
                                  <thead>
                                    <th class="text-center">Marks and Numbers</th>
                                    <th class="text-center">Pieces</th>
                                    <th class="text-center">Description of Commodities</th>
                                    <th class="text-center">Gross Weight</th>
                                    <th class="text-center">Volume</th>
                                  </thead>
                                  <tbody>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="shipment_charges" class="tab-pane fade">
                            <div class="row" >
                                <div class="col-md-12" >
                                    <h3 style="text-align:center; color:black; font-weight:400; font-size:20px;padding-top: 20px;" >SEARCHER WAREHOUSE RECEIPT</h3>
                                </div>
                            </div>           
                            <div class="row" style="margin-top:20px">
                            </div> 
                        </div>                                              
                    </div>
                </div>
            </div>    
        </div>
      </div>     
<?php } ?>

    <?php if ($step=='2'){ ?>
   
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-3 col-md-6 shadow2" style="background: white;margin-top:50px">
          <div class="row">
            <div class="col-md-12">
              <h3 style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">CREATE WAREHOUSE RECEIPT</h3>
            </div>
          </div> 
          <form action="action/savewaresthousestep2.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="warehouse_id" value=<?php echo $warehouse_id; ?>>
          <div class="row">
            <div class="col-md-12">
              <table class="table"> 
                <thead>
                  <tr>
                    <td class="text-center">Pieces</td>
                    <td class="text-center">Gross Weight</td>
                    <td class="text-center">Volume</td>
                    <td class="text-center">Charg.Weight</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th id="total_pieces" class="text-center"></th>
                    <th id="total_weight" class="text-center"></th>
                    <th id="total_volume" class="text-center"></th>
                    <th id="total_charg_weight" class="text-center"></th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <style>
          
          </style>
          <div class="row" style="margin-top:20px; margin-bottom:20px">
            <div class="col-md-offset-1 col-md-10">
              <input type="file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
            </div>
          </div>
          <input type="hidden" name="total_pieces">
          <input type="hidden" name="total_weight">
          <input type="hidden" name="total_volume">
          <input type="hidden" name="total_charg_weight">
          <div class="row">
            <div class="col-md-12">
              <div class="card" id="by_boxes_content">
                  <p><i class="fa fa-cubes"></i>&nbsp;By Boxes</p>
                  <div class="item">
                      <div class="form-group row" style="margin-bottom:0px;">
                         <div class="col-md-2 col-item text-center">
                              <label for="">Pieces</label>
                          </div>  
                          <div class="col-md-2 col-item text-center">
                              <label for="">Lenght</label>
                          </div>
                          <div class="col-md-2 col-item text-center">
                              <label for="">Width</label>
                          </div>
                          <div class="col-md-2 col-item text-center">
                              <label for="">Height</label>
                          </div>  
                          <div class="col-md-2 col-item text-center">
                              <label for="">Weight</label>
                          </div>                       
                      </div>
                  </div>                   
                  <div class="item col">
                      <div class="form-group row">
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_piecesx[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_lenghtX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_widthX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_heightX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_weightX[]" value="" required class="form-control">
                          </div>
                          
                          <div class="col-md-1 col-item">                                         
                              <button  type="button"  class="btn btn_plus">+</button>                                          
                          </div>
                      </div>
                  </div>                 
              </div>
            </div>
          </div>
          <div class="row" style="margin-bottom:30px">
            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    <?php } ?>
  <!-- Form -->
  </section>
</div>
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#shipment").addClass("active");
  $("#shipment #create").addClass("active");
  $(".select2").select2();
  $(function () {   
    
 
    $('input[type="file"]').imageuploadify();   
   
    
    $("#myModal1 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {     
          $("#step1_form select[name='supplier_id']").html(response);
          clear1();                          
          $("#myModal1").modal('hide');
          swal({
              title: "Supplier!",
              text: "New Supplier created successful!",
              icon: "success",
          });
      });
    })
    function clear1(){
      $("#myModal1 input[name='company']").val('');
      $("#myModal1 input[name='name']").val('');
      $("#myModal1 input[name='address_1']").val('');
      $("#myModal1 input[name='address_2']").val('');
      $("#myModal1 input[name='city']").val('');
      $("#myModal1 input[name='state']").val('');
      $("#myModal1 input[name='country']").val('');
      $("#myModal1 input[name='telf1']").val('');
      $("#myModal1 input[name='telf2']").val('');
      $("#myModal1 input[name='qq']").val('');
      $("#myModal1 input[name='wechat']").val('');
      $("#myModal1 input[name='email']").val('');
    }
    $("#myModal2 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {     
          $("#step1_form select[name='bill_id']").html(response);                          
          $("#myModal2").modal('hide');
          clear2();      
          swal({
              title: "Client!",
              text: "New Client created successful!",
              icon: "success",
          });
      });
    })
    function clear2(){
      $("#myModal2 input[name='agent_name']").val('');
      $("#myModal2 input[name='company']").val('');
      $("#myModal2 input[name='name']").val('');
      $("#myModal2 input[name='address_1']").val('');
      $("#myModal2 input[name='address_2']").val('');
      $("#myModal2 input[name='city']").val('');
      $("#myModal2 input[name='state']").val('');
      $("#myModal2 input[name='country']").val('');
      $("#myModal2 input[name='telf1']").val('');
      $("#myModal2 input[name='telf2']").val('');
      $("#myModal2 input[name='qq']").val('');
      $("#myModal2 input[name='wechat']").val('');
      $("#myModal2 input[name='email']").val('');
    }
    $("#myModal3 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {    
          var data=JSON.parse(response);
          if(data.status){                          
            $("#myModal3").modal('hide');
            clear3();      
            swal({
                title: "Consignee!",
                text: "New Password is "+data.password,
                icon: "success",
            });
            $("#step1_form select[name='consignee_id']").html(data.html);        
            $("#step1_form select[name='bill_id']").html(data.html);     
          }else{
              swal({
              title: "Waring!",
              text: data.html,
              icon: "error",
            });
          }
       
      });
    })
    function clear3(){
      $("#myModal3 input[name='agent_name']").val('');
      $("#myModal3 input[name='company']").val('');
      $("#myModal3 input[name='name']").val('');
      $("#myModal3 input[name='address_1']").val('');
      $("#myModal3 input[name='address_2']").val('');
      $("#myModal3 input[name='city']").val('');
      $("#myModal3 input[name='state']").val('');
      $("#myModal3 input[name='country']").val('');
      $("#myModal3 input[name='telf1']").val('');
      $("#myModal3 input[name='telf2']").val('');
      $("#myModal3 input[name='qq']").val('');
      $("#myModal3 input[name='wechat']").val('');
      $("#myModal3 input[name='email']").val('');
    }
    $("#by_boxes_content .btn_plus").on("click", function(e){
        e.preventDefault();
        var html='<div class="item col">';
            html+='<div class="form-group row">';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_piecesx[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="text" name="byBoxes_lenghtX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number" name="byBoxes_widthX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_heightX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_weightX[]" required class="form-control">';
            html+='</div>';            
            html+='<div class="col-md-1 col-item">';
            html+='<button  type="button" class="btn btn_minus">-</button>';
            html+='</div>';
            html+='</div>';
            html+='</div>';
           
        $("#by_boxes_content").append(html);
          $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_piecesx[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_widthX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_heightX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_lenghtX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
          })
          $('#by_boxes_content .btn_minus').on("click", function (e) {
            e.preventDefault(); 
            $(this).parent('div').parent('div').parent('div').remove(); 
            total_calculator();
          })
      });

      $('#by_boxes_content .btn_minus').on("click", function (e) {
        e.preventDefault(); 
        $(this).parent('div').parent('div').parent('div').remove(); 
        total_calculator();
      })

      $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_piecesx[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_widthX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_heightX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_lenghtX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
            total_calculator();
        })
   
    function total_calculator(){
      var total_pieces=0,total_weight=0, total_volume=0;
      $("#by_boxes_content .col").each(function(index,ele){
        var pieces=$(this)[0].children[0].children[0].children[0].value;
        var lenght=$(this)[0].children[0].children[1].children[0].value;
        var width=$(this)[0].children[0].children[2].children[0].value;
        var height=$(this)[0].children[0].children[3].children[0].value;
        var weight=$(this)[0].children[0].children[4].children[0].value;
        total_pieces=total_pieces+parseInt(pieces);
        total_volume=total_volume+parseInt(lenght)*parseInt(width)*parseInt(height)/1000000;
        total_weight=total_weight+parseFloat(weight)*parseInt(pieces);
        
      });
      $("#total_pieces").text(total_pieces);
      $("#total_weight").text(total_weight);
      $("#total_charg_weight").text(total_weight);
      $("#total_volume").text(total_volume.toFixed(5));

      $("input[name='total_pieces']").val(total_pieces);
      $("input[name='total_weight']").val(total_weight);
      $("input[name='total_volume']").val(total_volume.toFixed(5));
      $("input[name='total_charg_weight']").val(total_weight);
    
    }
  
  });
</script>


</body>
</html>
