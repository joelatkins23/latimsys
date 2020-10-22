<?php 
error_reporting(0);
require_once('conn.php');

    $message= $_GET['message'];
    $step= $_GET['step'];
    $type= $_GET['type'];
    $job_id_step1= $_GET['job_id_step1'];

    // Initialize the session
session_start();

require_once('conn.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
    or die ("Error al traer los Agent");


     while ($rowAgent = mysqli_fetch_array($consultaAgent)){
        $agent_id=$rowAgent['id'];
        $agent_name=$rowAgent['name'];
        $phone=$rowAgent['phone'];
        $picture=$rowAgent['picture'];
        $level=$rowAgent['level'];
     } 
     if(isset($_GET['message'])){
      $message= $_GET['message'];
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>System | Create Invoices</title>
    <link rel="icon" type="image/x-icon" href="icoplane.ico" />
    <!-- CSS -->
    <link href='plugins/select2/select2.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href=" https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href='plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css'>  
    <link rel="stylesheet" href="./plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
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
    <script src="plugins/moment.min.js"></script>  
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>  
    <script src="assets/js/app.min.js"></script>
   
    <script>
        window.addEventListener("load", function() {
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
    </script>
    <style>
      .custom_table thead tr th {
        background: #B80008;
        border: none;
        font-weight: 400;
        color: white;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
  <div id="load_screen">
      <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
  </div>
  <div class="wrapper">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        Invoices 
          <small>Create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create Invoices</li>
        </ol>
      </section>
      <?php if ($message=='success'){ ?>
        <div  id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
        right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
          <div style="padding:15px;margin-right:10px;">
          <strong>New Invoices Created Successful</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
        </div>
      <?php }?>
      <!-- Main content -->
      <section class="content"> 
        <form action="./curd_invoice.php" method="post">   
          <input type="hidden" name="createinvoice" value="create">
          <div class="row" style="margin: 0px;"> 
            <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px">
              <div class="row">
                <div class="col-md-12 text-center" style="border-bottom:1px solid #555555; padding-bottom:10px;">
                  <h3 style="text-align:center; color:black; font-weight:800; font-size:20px;    margin-top: 30px; ">Create Invoices</h3>
                </div>
              </div>
                <div class="row" style="margin:30px 20px">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Branch</label>
                      <div class="col-md-9">
                          <select name="branch" id="" class="form-control select2"  data-placeholder="Select Branch" required style="width:100%">
                              <option value="">Select Branch</option>
                              <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM branches  order by id ")
                                or die ("Error al traer los Agent");
                                while ($row = mysqli_fetch_array($consulta)){
                            
                                    $ID=$row['id'];
                                    $station=$row['station'];
                                    $company=$row['company'];
                                  
                              ?>  
                              <option value="<?php echo $ID;?>"><?php echo $station;?> - <?php echo $company;?></option>
                              <?php } ?>                       
                            </select> 
                      </div>
                    </div>
                    
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Date</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" data-provide="datepicker" id="date"
                                    data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date('Y/n/d'); ?>"  name="date"  autocomplete="off"  placeholder="Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Accounts</label>
                      <div class="col-md-9">                       
                            <select name="account" id="" class="form-control select2" data-placeholder="Select Account" required style="max-width:100%; min-width:100%" >
                              <option value="">--Select Account--</option>
                            <?php 
                              $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                              or die ("Error al traer los Agent");
                              while ($row = mysqli_fetch_array($consulta)){
                          
                                  $ID=$row['id'];
                                  $name=$row['name'];
                                  $company=$row['company'];
                                  $city=$row['city'];
                                
                            ?>
                              <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> | <?php echo $company; ?></option>
                              <?php } ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Currency</label>
                      <div class="col-md-9">
                          <select name="currency" id="" class="form-control select2"  data-placeholder="Select Currency">
                              <option value="">Select Currency</option>
                              <option value="USD">USD - US Dollar</option>                           
                            </select> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Total Invoiced</label>
                      <div class="col-md-9">
                          <label id="total_invoiced" class="control-label"for="" style="font-weight:bold">0.00</label>
                          <input type="hidden" name="total_invoiced" class="form-control" value="0.00"  placeholder="">
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Total Paid</label>
                      <div class="col-md-9">
                          <label id="total_paid" class="control-label"for="" style="font-weight:bold">0.00</label>
                          <input type="hidden" name="total_paid" class="form-control" value="0.00"  placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Cost Center</label>
                      <div class="col-md-9">
                          <input type="text" name="cost_center" class="form-control" placeholder="Cost Center">
                      </div>
                    </div>
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Shipper</label>
                      <div class="col-md-9">                       
                            <select name="shipper" id="" class="form-control select2" data-placeholder="Select Shipper" required style="max-width:100%; min-width:100%" >
                              <option value="">--Select Shipper--</option>
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
                      <label for="" class="control-label col-md-3 text-right">Consignee</label>
                      <div class="col-md-9">
                          <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="min-width:100%;max-width:100%;" required>
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
                      <label for="" class="control-label col-md-3 text-right">Carrier</label>
                      <div class="col-md-9">
                          <input type="text" name="carrier" class="form-control" placeholder="Carrier">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Entry</label>
                      <div class="col-md-9">
                          <input type="text" name="entry" class="form-control" placeholder="Entry">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">ETD</label>
                      <div class="col-md-9">
                        <div class="input-group">
                          <input type="text" class="form-control" data-provide="datepicker" id="etd"
                                  data-date-format="yyyy/m/d" laceholder="ETD" value="<?php echo date('Y/n/d'); ?>"  name="etd"  autocomplete="off"  placeholder="Due Date">
                          <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">ETA</label>
                      <div class="col-md-9">
                        <div class="input-group">
                          <input type="text" class="form-control" data-provide="datepicker" id="eta"
                                  data-date-format="yyyy/m/d" laceholder="ETA" value="<?php echo date('Y/n/d'); ?>"  name="eta"  autocomplete="off"  placeholder="Due Date">
                          <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Incoterm</label>
                      <div class="col-md-9">
                          <input type="text" name="incoterm" class="form-control" placeholder="Incoterm">
                      </div>
                    </div>
                                       
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Exchange</label>
                      <label for="" class="control-label col-md-3 text-right" style="color:red">CNY</label>
                      <div class="col-md-6">
                          <input type="text" name="exchange" class="form-control" placeholder="0.000000">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">WareHouse</label>
                      <div class="col-md-9">
                      <select data-placeholder="warehouse" id="warehouse" class="form-control select2" name="warehouse[]" multiple>

                            <?php $consulta22 = mysqli_query($connect, "SELECT  id FROM warehouse  ") or die ("Error al traer los datos");
                                    while ($row = mysqli_fetch_array($consulta22)){ 
                                  
                                    ?>

                            <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                            <?php }  ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Purchase</label>
                      <div class="col-md-9">
                          <input type="text" name="purchase"  class="form-control" placeholder="Purchase">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">House</label>
                      <div class="col-md-9">
                          <input type="text" name="house" class="form-control" placeholder="House">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">File</label>
                      <div class="col-md-3">
                        <input type="text"  name="file_val1" class="form-control" placeholder="">
                      </div>
                      <div class="col-md-6">
                        <input type="text"  name="file_val2" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Pieces</label>
                          <div class="col-md-6">
                            <input type="text"  name="pieces" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Weight G.</label>
                          <div class="col-md-6">
                            <input type="text"  name="weight" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Volume</label>
                          <div class="col-md-6">
                            <input type="text"  name="volume" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Weight C.</label>
                          <div class="col-md-6">
                            <input type="text"  name="weight_c" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Origin</label>
                          <div class="col-md-6">
                            <input type="text"  name="origin" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Dest</label>
                          <div class="col-md-6">
                            <input type="text"  name="dest" class="form-control" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Po</label>
                      <div class="col-md-9">
                          <input type="text" name="po" class="form-control" placeholder="PO">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Reference</label>
                      <div class="col-md-9">
                          <input type="text" name="reference" class="form-control" placeholder="Reference">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-offset-3 col-md-9">
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input" name="bank_information" value="1">&nbsp; Bank Information
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"  name="print_including_backup" value="1">&nbsp;Print Including Backup
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"  name="print_grouped_by_concepts" value="1">&nbsp;Print Grouped By Concepts
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"   name="print_exchange" value="1">&nbsp;Print Exchange
                          </label>
                        </div>                                               
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-offset-3 col-md-9">
                        <label class="radio-inline">
                          <input type="radio" class="form-check-input" name="invoice_status" checked value="PrePaid">&nbsp;PrePaid
                        </label>
                        <label class="radio-inline">
                          <input type="radio" class="form-check-input" name="invoice_status" value="Collect">&nbsp;Collect
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 text-right">
                    <button  type="button"class="btn btn-danger file_upload_btn"><i class="fa fa-cloud-upload"></i>&nbsp;Add Files</button>

                    <button  type="button"class="btn btn-danger invoice_td_add"><i class="fa fa-plus"></i>&nbsp;Add</button>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                    <div class="table-responsive">
                      <table  style="width:100%;" class='custom_table table table-bordered' >
                          <thead>
                              <tr class="text-center" >
                                  <th class="text-center">Units</th>
                                  <th class="text-center" style="width:300px;">G/L<br>Account</th>                                  
                                  <th class="text-center">CC</th>
                                  <th class="text-center">Description</th>
                                  <th class="text-center">Price</th>                                  
                                  <th class="text-center">Amount</th>
                                  <th class="text-center">Tax(%)</th>
                                  <th class="text-center">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>                             
                              <td>
                                <input type="text" class="form-control text-center" name="td_units[]">
                              </td>
                              <td>
                                <select name="td_account[]" id="" class="form-control select2" data-placeholder="Select G/L Account" required>
                                <option value="">Select G/L Account</option>
                                <?php 
                                $post = array();
                                $consulta = mysqli_query($connect, "SELECT * FROM gl_account order by id ")
                                or die ("Error al traer los Agent");
                                while ($rowgl = mysqli_fetch_array($consulta)){
                                    $post[] = $rowgl;
                                    $ID=$rowgl['id'];
                                    $name=$rowgl['name'];
                                    $title=$rowgl['title'];
                                  
                              ?>
                              <option value="<?php echo $ID; ?>"><?php echo $name; ?> | <?php echo $title; ?></option>
                              <?php } ?>
                                </select>
                              </td>    
                              <td>
                                <input type="text" class="form-control" name="td_cc[]">
                              </td>
                              <td>
                                <input type="text" class="form-control" name="td_desc[]">
                              </td>
                                                       
                              <td>
                                <input type="text" class="form-control text-right" name="td_price[]">
                              </td>
                              <td>
                                <input type="text" class="form-control text-right" name="td_amount[]">
                              </td>
                              <td>
                                <input type="checkbox" name="td_tax[]" value="1">
                              </td>
                              <td>
                                <i class="fa fa-trash action td_remove"></i>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                    <div class="table-responsive">
                      <table  style="width:100%;" class='file_table table table-bordered' >
                          <thead>
                              <tr class="text-center" >
                                  <th class="text-center" style=" background: #B80008;color:white">File Name</th>
                                  <th class="text-center" style=" background: #B80008;color:white">User</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Date</th>                                
                                  <th class="text-center" style=" background: #B80008;color:white">Action</th>
                              </tr>
                          </thead>
                          <tbody>                            
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-12 text-right" style="margin-top:10px;">
                      <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                  </div>
                </div>
              </div>          
            </div>
          </div>     
        </form> 
      </section>
  </div>
</div>
<div id="file_upload" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
        </div>
        <div class="modal-body" style="margin:20px;">
        <form action="./curd_bill.php" id="addfile" method="post" enctype="multipart/form-data">
          <input type="hidden" id="bill_fileupload" name="bill_fileupload" value="add">
          <div class="row">
            <div class="col-md-12">
                <input type="file" id="image_file" name="image_file[]"  class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
            </div>
            <div class="col-md-12 text-center" style="margin:20px auto;">
              <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i>&nbsp;Upload</button>
            </div>
          </div>
        </form>
        </div>        
      </div>
    </div>
</div>
<!-- Page script -->
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#invoice_menu").addClass("active");
  $("#invoice_menu .sub_menu_create").addClass("active");
  $("#invoice_menu #create_invoice").addClass("active");
  $(".select2").select2();
  $('input[type="file"]').imageuploadify();
  setTimeout(fade_out, 3000);
    function fade_out() {
      $("#mydiv").fadeOut().empty();     
    }

  $(".file_upload_btn").on("click", function(){
    $("#file_upload").modal("show");    
  });
  $("#addfile").submit(function(e) {
      event.preventDefault(); //prevent default action 
      var post_url = $(this).attr("action"); //get form action url
      var fd = new FormData();
      var totalfiles = document.getElementById('image_file').files.length;
      for (var index = 0; index < totalfiles; index++) {
          fd.append("image_file[]", document.getElementById('image_file').files[index]);
      }
      fd.append( 'invoice_fileupload', 'add');
      $.ajax({
      url: './curd_invoice.php',
      data: fd,
      processData: false,
      cache: false,
      contentType: false,
      type: 'POST',
      success: function(data){         
          $("#file_upload").modal('hide');         
            swal({
                title: "File!",
                text: "New Files Uploaded successful!!",
                icon: "success",
            }); 
            $('input[type="file"]').val("");
            $(".imageuploadify-container").remove();
             var rep=JSON.parse(data); 
             var html="";
             for(var i=0; i<rep.length;i++){
                html+='<tr>';
                html+='<td  class="text-center"><a href="./images/bills/'+rep[i].name+'" target="blank">'+rep[i].name+'</a><input type="hidden"  name="td_filename[]" value="'+rep[i].name+'"></td>';
                html+='<td class="text-center">'+rep[i].agent_name+'<input type="hidden"  name="td_agent_name[]" value="'+rep[i].agent_name+'"></td>';
                html+='<td class="text-center" >'+rep[i].fecha+'<input type="hidden"  name="td_fecha[]" value="'+rep[i].fecha+'"></td>';
                html+='<td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>';               
                html+='</tr>';
             }
             $(".file_table tbody").append(html);
              $(".td_file_remove").on("click", function(e){
                var name=$(this).parent('td').parent('tr').find("td:eq(0)").text();
                $(this).parent('td').parent('tr').remove(); 
                $.ajax({
                    url: './curd_invoice.php',
                    data: {
                      'deletefile':'delete',
                      'name':name
                    },
                    type: 'POST',
                    success: function(data){
                      swal({
                        title: "Delete!",
                        text: "Files deleted successful!!",
                        icon: "error",
                      });
                      
                    }
                  })
              })
               
        }
      });
  });
  $(".invoice_td_add").on("click", function(e){
    var gl_lists=<?php echo json_encode($post); ?>;
    var html="";
      html+='<tr>';    
      html+='<td>';
      html+='<input type="text" class="form-control text-center"  name="td_units[]">';
      html+='</td>';
      html+='<td>';
      html+='<select name="td_account[]" class="form-control select2" data-placeholder="Select G/L Account" required>';
      html+='<option value="">Select G/L Account</option>';
      for(var i=0; i<gl_lists.length;i++){
        html+='<option value="'+gl_lists[i].id+'">'+gl_lists[i].name+' | '+gl_lists[i].title+'</option>';      
      }   
      html+='</select>';
      html+='</td>'; 
      html+='<td>';
      html+='<input type="text" class="form-control"  name="td_cc[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control" name="td_desc[]">';
      html+='</td>';        
      html+='<td>';
      html+='<input type="text" class="form-control text-right" name="td_price[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control text-right"  name="td_amount[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="checkbox" name="td_tax[]" value="1">';
      html+='</td>';
      html+='<td>';
      html+='<i class="fa fa-trash action td_remove"></i>';
      html+='</td>';
      html+='</tr>';
      $(".custom_table tbody").append(html);
      selectRefresh();
      $(".td_remove").on("click", function(e){
        $(this).parent('td').parent('tr').remove(); 
        total_calculator();
      });
      $(".custom_table  tbody tr input[name='td_amount[]']").keyup(function(e){
          total_calculator();
    })
  });
  $(".td_remove").on("click", function(e){
    $(this).parent('td').parent('tr').remove(); 
    total_calculator();
  });
  $(".custom_table  tbody tr input[name='td_amount[]']").keyup(function(e){
        total_calculator();
  })
  function selectRefresh() {
  $('.select2').select2({   
    allowClear: true,
    width: '100%'
  });
}
  function total_calculator(){
    var total_amount=0;
    $(".custom_table  tbody tr").each(function(index,ele){
        var amount=$(this)[0].children[5].children[0].value;  
        total_amount=total_amount+parseFloat(amount);       
      });     
      $("input[name='total_invoiced']").val(total_amount);
      $("#total_invoiced").text(total_amount);
      $("input[name='total_paid']").val(total_amount);
      $("#total_paid").text(total_amount);
  }
  $("#warehouse").on("change", function(e){
    var wh_arr=$("#warehouse").val();
    $.ajax({
          url: './curd_invoice.php',
          data: {
            'getwh_info':'get',
            'wh_arr':$("#warehouse").val()
          },
          type: 'POST',
          success: function(rep){
            var data=JSON.parse(rep);
            $("input[name='weight']").val(data.total_weight);
            $("input[name='pieces']").val(data.total_pieces);
            $("input[name='volume']").val(data.total_volume);
            $("input[name='weight_c']").val(data.total_charg_weight);         
          }
        })
   
  });
  $(function () {
    //Initialize Select2 Elements
   
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });   
  });
</script>


</body>
</html>
