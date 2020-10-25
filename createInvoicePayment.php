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
  <title>System | Create payment</title>
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
    window.addEventListener("load", function () {
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

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
      border: 1px solid #ddd !important;
      /* align-items: initial; */
      vertical-align: baseline;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div id="load_screen">
    <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span
        style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
  </div>
  <div class="wrapper">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          payment
          <small>Create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create payment</li>
        </ol>
      </section>
      <?php if ($message=='success'){ ?>
      <div id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
        right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
        <div style="padding:15px;margin-right:10px;">
          <strong>New payment Created Successful</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php }?>
      <!-- Main content -->
      <section class="content">
        <form action="./curd_invoicepayment.php" method="post">
          <input type="hidden" name="createpayment" value="create">
          <div class="row" style="margin: 0px;">
            <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px">
              <div class="row">
                <div class="col-md-12 text-center"
                  style="border-bottom:1px solid #555555; padding-bottom:10px;margin-top:20px">
                  <h3 style="text-align:center; color:black; font-weight:800; font-size:20px; ">Create payment</h3>
                </div>
              </div>
              <div class="row" style="margin:30px 20px">

                <div class="col-md-offset-1 col-md-8">
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Date</label>
                    <div class="col-md-9">
                      <div class="input-group">
                        <input type="text" class="form-control" data-provide="datepicker" id="date"
                          data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date('Y/n/d'); ?>" name="date"
                          autocomplete="off" placeholder="Date">
                        <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Accounts</label>
                    <div class="col-md-9">
                      <select name="account" id="" class="form-control select2" data-placeholder="Select Account"
                        required style="width:100%; max-width:100%; min-width:100%">
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
                        <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> |
                          <?php echo $company; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Branch</label>
                    <div class="col-md-9">
                      <select name="branch" id="" class="form-control select2" data-placeholder="Select Branch" required
                        style="width:100%">
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
                    <label for="" class="control-label col-md-3 text-right">Type</label>
                    <div class="col-md-9">
                      <select name="type" id="" class="form-control select2" data-placeholder="Select Type" required
                        style="width:100%">
                        <option value="">Select Type</option>
                        <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM bill_type  order by id ")
                                or die ("Error al traer los Agent");
                                while ($row = mysqli_fetch_array($consulta)){                         
                                   
                                  
                              ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-6">
                      <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6 text-right">Number</label>
                        <div class="col-md-6">
                          <input type="text" name="number" class="form-control" placeholder="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row" style="margin-bottom:0">
                        <label for="" class="control-label col-md-6 text-right">Date on Check</label>
                        <div class="col-md-6">
                          <div class="input-group">
                            <input type="text" class="form-control" data-provide="datepicker" 
                              data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date('Y/n/d'); ?>"
                              name="date_on_check" autocomplete="off" placeholder="Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Amount</label>
                    <div class="col-md-3">
                      <select name="currency" id="" class="form-control select2" data-placeholder="Select Currency"
                        style="width:100%">
                        <option value="">Select Currency</option>
                        <option value="USD">USD - US Dollar</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <input type="text" name="amount" class="form-control text-right" placeholder="">
                    </div>
                    <label for="" class="control-label col-md-2 text-right">Exchange</label>
                    <div class="col-md-2">
                      <input type="text" name="exchange" class="form-control text-right" placeholder="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Reference</label>
                    <div class="col-md-9">
                      <input type="text" name="reference" class="form-control" placeholder="Reference">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">Comments</label>
                    <div class="col-md-9">
                      <textarea name="comments" id="comments" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-3 text-right">General Ledger</label>
                    <div class="col-md-9">
                      <input type="text" name="general_ledger" class="form-control" placeholder="General Ledger">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table file_table table-bordered" style="width:100%" >
                          <thead>
                            <tr>
                              <th class="text-center"  style=" width:250px;background: #B80008;color:white">File Name</th>
                              <th class="text-center"  style=" background: #B80008;color:white">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                    </div>
                  </div>  
                  <div class="form-group row">
                    <div class="col-md-12 text-right" style="margin-top:10px;">
                      <button  type="button"class="btn btn-success file_upload_btn"><i class="fa fa-cloud-upload"></i>&nbsp;File Upload</button>
                      <button type="button" class="btn btn-success open_payment_modal"><i class="fa fa-save"></i>&nbsp;payment</button>
                    </div>
                  </div> 
                                 
                </div>
                <div id="paymentmodal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-money"></i>&nbsp; Payment Received Wire Transfer</h4>
                      </div>
                      <div class="modal-body" style="padding:20px; margin-top:0px">
                        <div class="row" style="margin:0">
                          <div class="col-md-12">
                            <h4 style="color:red; font-weight:bold">Amount to apply can't be larger than the amount due on the invoice.</h4>
                            <p style="margin-bottom: 0px;">Processing receipts for : <strong id="account_name">Prueba Diaz</strong></p>
                            <p>Amount Available to process : <strong id="available_amout" style="color:red">USD 350.00</strong></p>
                            <button type="submit" class="btn btn-danger">APPLY CREDIT</button>
                            <p style="margin-bottom: 0px;margin-top: 10px; color:red">No Invoices have been processed yet</p>
                            <h4 class="text-right" id="available_invoice_element" style="color:red; font-weight:bold;display:none">Amount Available to process <strong id="available_invoice_amount" style="color:red">USD 350.00</strong></h4>
                          </div>
                          <div id="available_element" style="display:none">
                            <div class="col-md-12" style="margin-top:30px;">
                              <small for="" style="color:#B80008">Selected on this Reference</small>
                            </div>
                            <div class="col-md-12" style="margin-top:10px;">
                              <div class="table-responsive">
                                <table style="width:100%;" class='custom_table paid_table table table-bordered'>
                                  <thead>
                                    <tr class="text-center">
                                      <th class="text-center">Date</th>
                                      <th class="text-center">Number</th>
                                      <th class="text-center">Account</th>
                                      <th class="text-center">Currency</th>
                                      <th class="text-center">Amount</th>
                                      <th class="text-center">Paid</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                </table>
                              </div>
                            </div>                          
                            <div class="col-md-12">
                              <small for="" style="color:#B80008">Avaliable for selection</small>
                            </div>
                            <div class="col-md-12" style="margin-top:10px;">
                              <div class="table-responsive">
                                <table style="width:100%;" class='custom_table payment_table table table-bordered'>
                                  <thead>
                                    <tr class="text-center">
                                      <th class="text-center">Date</th>
                                      <th class="text-center">Number</th>
                                      <th class="text-center">Account</th>
                                      <th class="text-center">Currency</th>
                                      <th class="text-center">Amount</th>
                                      <th class="text-center">Toatal Paid</th>
                                      <th class="text-center">&nbsp;</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
        </div>
        <div class="modal-body" style="margin:20px;">
          <form action="./curd_payment.php" id="addfile" method="post" enctype="multipart/form-data">
            <input type="hidden" id="payment_fileupload" name="payment_fileupload" value="add">
            <div class="row">
              <div class="col-md-12">
                <input type="file" id="image_file" name="image_file[]" class="file-upload"
                  accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple />
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
    $("#invoice_menu #create_invoice_payments").addClass("active");
    $('input[type="file"]').imageuploadify();
    $(".select2").select2();
    setTimeout(fade_out, 3000);
    function fade_out() {
      $("#mydiv").fadeOut().empty();
    }
    var total_val=0, count=0;
    $(".file_upload_btn").on("click", function () {
      $("#file_upload").modal("show");
    });
    $(".open_payment_modal").on("click", function(){
      if($("select[name='account']").val() && $("input[name='amount']").val() && $("select[name='type']").val() && $("select[name='currency']").val()){
        if(total_val==0){
          total_val=$("input[name='amount']").val();
        }
        var amount_text = $("select[name='currency']").val()+" "+total_val;
        $("#available_amout").text(amount_text);
        if(count>0){
            $("#available_element").css("display","block");
            $("#available_invoice_element").css("display","block");  
        }else{
            $("#available_element").css("display","none");
            $("#available_invoice_element").css("display","none");  
        }
        $("#paymentmodal").modal("show");
      }else{
        swal({
              title: "Error!",
              text: "Insert Account, Amount, Type and Currency values!",
              icon: "error",
          });
      }
      
    })
    $("#addfile").submit(function (e) {
      event.preventDefault(); //prevent default action 
      var post_url = $(this).attr("action"); //get form action url
      var fd = new FormData();
      var totalfiles = document.getElementById('image_file').files.length;
      for (var index = 0; index < totalfiles; index++) {
        fd.append("image_file[]", document.getElementById('image_file').files[index]);
      }
      fd.append('payment_fileupload', 'add');
      $.ajax({
        url: './curd_invoicepayment.php',
        data: fd,
        processData: false,
        cache: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          $("#file_upload").modal('hide');
          swal({
            title: "File!",
            text: "New Files Uploaded successful!!",
            icon: "success",
          });
          $('input[type="file"]').val("");
          $(".imageuploadify-container").remove();
          var rep = JSON.parse(data);
          var html = "";
          for (var i = 0; i < rep.length; i++) {
            html += '<tr>';
            html += '<td class="" ><a href="./images/bills/' + rep[i].name + '" target="blank">' + rep[i].name + '</a><input type="hidden"  name="td_filename[]" value="' + rep[i].name + '"></td>';
            html += '<td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>';
            html += '</tr>';
          }
          $(".file_table tbody").append(html);
          $(".td_file_remove").on("click", function (e) {
            var name = $(this).parent('td').parent('tr').find("td:eq(0)").text();
            $(this).parent('td').parent('tr').remove();
            $.ajax({
              url: './curd_invoicepayment.php',
              data: {
                'deletefile': 'delete',
                'name': name
              },
              type: 'POST',
              success: function (data) {
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
    $("select[name='account']").on("change", function (e) {
      var id = e.target.value;
      $.ajax({
        url: './curd_invoicepayment.php',
        data: {
          'getinvoice': 'true',
          'id': id
        },
        type: 'POST',
        success: function (data) {
          var respo=JSON.parse(data);
          var account_name=respo.account_name;
          $("#account_name").html(account_name);
          var rep = respo.post;
          var html = "";
          count=rep.length;
          total_val=0;
          for (var i = 0; i < rep.length; i++) {
            var diff_val = rep[i].total_invoiced - rep[i].paid;
            total_val = total_val + diff_val;
            html += '<tr>';
            html += '<td class="text-center">' + rep[i].date + '</td>';
            html += '<td class="text-center">' + rep[i].id + '</td>';
            html += '<td class="text-center">' + rep[i].account_name + '</td>';
            html += '<td class="text-center">' + rep[i].currency + '</td>';
            html += '<td class="text-center">' + rep[i].total_invoiced + '</td>';
            html += '<td class="text-center">' + rep[i].paid + '</td>';
            html += '<td class="text-center">';
            html += '<input type="text" id="td_payment" value="' + diff_val + '" class="form-control text-right">';
            html += '</td>';
            html += '<td class="text-center"><button type="button" onclick="onpayment($(this))" class="btn btn-success payment_btn btn-sm"><i class="fa fa-money"></i>&nbsp;Pay</button></td>';
            html += '<input type="hidden" id="td_change_payment" value="' + diff_val + '" class="form-control text-right">';
            html += '</tr>';
          }
          if(count>0){
            $("#available_element").css("display","block");
            $("#available_invoice_element").css("display","block");  
            var amount_text = "USD "+total_val;
            $("#available_amout").text(amount_text); 
            $("input[name='amount']").val(total_val); 
            $("#available_invoice_amount").text(amount_text);          
          }else{
            $("input[name='amount']").val(0); 
          }
          $(".payment_table tbody").html(html);
        }
      });
    });
    function onpayment(ele) {
      var date = ele.parent('td').parent('tr').find("td:eq(0)").text();
      var invoice_id = ele.parent('td').parent('tr').find("td:eq(1)").text();
      var account = ele.parent('td').parent('tr').find("td:eq(2)").text();
      var currency = ele.parent('td').parent('tr').find("td:eq(3)").text();
      var total_invoiced = ele.parent('td').parent('tr').find("td:eq(4)").text();
      var total_paid = ele.parent('td').parent('tr').find("td:eq(5)").text();
      var paid = ele.parent('td').parent('tr').find("#td_payment").val();
      var change_payment = ele.parent('td').parent('tr').find("#td_change_payment").val();
      total_paid = Math.round((parseFloat(total_paid) + parseFloat(paid)) * 100) / 100;    
      ele.parent('td').parent('tr').find("td:eq(5)").text(total_paid);
      if (change_payment - paid > 0) {
        var dif = Math.round((change_payment - paid) * 100) / 100;
        ele.parent('td').parent('tr').find("#td_payment").val(dif);
        ele.parent('td').parent('tr').find("#td_change_payment").val(dif);
      } else if (change_payment - paid == 0) {
        ele.parent('td').parent('tr').remove();
      }
      var tbody = "";
      tbody += '<tr>';
      tbody += '<td class="text-center">' + date + '</td>';
      tbody += '<td class="text-center">' + invoice_id + '</td>';
      tbody += '<td class="text-center">' + account + '</td>';
      tbody += '<td class="text-center">' + currency + '</td>';
      tbody += '<td class="text-center">' + total_invoiced + '</td>';
      tbody += '<td class="text-center">' + paid + '</td>';
      tbody += '<td class="text-center"><i class="fa fa-trash action td_remove" onclick="ontdremove($(this))"></i></td>';
      tbody += '<input type="hidden" name="td_paid[]" value="' + paid + '" class="form-control text-right">';
      tbody += '<input type="hidden" name="td_invoice_id[]" value="' + invoice_id + '" class="form-control text-right">';
      tbody += '</tr>';
      $(".paid_table tbody").append(tbody);
      total_calculator();
    }
    function ontdremove(ele) {
      var invoice_id = ele.parent('td').parent('tr').find("td:eq(1)").text();
      var element = '';
      $(".payment_table tbody tr").each(function (index, ele1) {
        var id = $(this).find("td:eq(1)").text();
        if (invoice_id == id) {
          element = $(this);
        }
      });
      if (element) {
        var id = element.find("td:eq(1)").text();
        var total_paid = element.find("td:eq(5)").text();
        var payment = ele.parent('td').parent('tr').find("td:eq(5)").text();
        total_paid = Math.round((parseFloat(total_paid) + parseFloat(payment)) * 100) / 100;
        element.find("td:eq(5)").text(total_paid);
        var old_payment = element.find("#td_payment").val();
        var dif = Math.round((parseFloat(old_payment) + parseFloat(payment)) * 100) / 100;
        element.find("#td_payment").val(dif);
        element.find("#td_change_payment").val(dif);

      } else {

        var date = ele.parent('td').parent('tr').find("td:eq(0)").text();
        var td_inv = ele.parent('td').parent('tr').find("td:eq(1)").text();
        var td_account = ele.parent('td').parent('tr').find("td:eq(2)").text();
        var td_currency = ele.parent('td').parent('tr').find("td:eq(3)").text();
        var td_amount = ele.parent('td').parent('tr').find("td:eq(4)").text();
        var td_payment = ele.parent('td').parent('tr').find("td:eq(5)").text();
        var html = '';
        html += '<tr>';
        html += '<td class="text-center">' + date + '</td>';
        html += '<td class="text-center">' + invoice_id + '</td>';
        html += '<td class="text-center">' + td_account + '</td>';
        html += '<td class="text-center">' + td_currency + '</td>';
        html += '<td class="text-center">' + td_amount + '</td>';
        html += '<td class="text-center">' + td_payment + '</td>';
        html += '<td class="text-center">';
        html += '<input type="text" id="td_payment" value="' + td_payment + '" class="form-control text-right">';
        html += '</td>';
        html += '<td class="text-center"><button type="button"  onclick="onpayment($(this))" class="btn btn-success payment_btn btn-sm"><i class="fa fa-money"></i>&nbsp;Pay</button></td>';
        html += '<input type="hidden" id="td_change_payment" value="' + td_payment + '" class="form-control text-right">';

        html += '</tr>';
        $(".payment_table tbody").append(html);
      }
      ele.parent('td').parent('tr').remove();
      total_calculator();
    }

    function selectRefresh() {
      $('.select2').select2({
        allowClear: true,
        width: '100%'
      });
    }
    function total_calculator() {
      var total_amount = 0;
      $(".paid_table  tbody tr").each(function (index, ele) {
        var amount = $(this).find("td:eq(5)").text();
        total_amount = total_amount + parseFloat(amount);
      });
      $("#amount").text(total_amount);
      $("input[name='amount']").val(total_amount);
    }
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