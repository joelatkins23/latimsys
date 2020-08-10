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
    <title>Latim Cargo & Trading | Pre Loading Plan</title>
    <link rel="icon" type="image/x-icon" href="icoplane.ico" />
    <!-- CSS -->
    <link href='plugins/select2/select2.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href=" https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href='plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="./plugins/datetimepicker/bootstrap-datetimepicker.css">
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
    <script src="plugins/moment.min.js"></script>
    <script src="./plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="dist/js/app.min.js"></script>
   <style>
    table.dataTable, table.dataTable th, table.dataTable td {
        height: auto;
    }
   </style>
    
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
        Pre Loading Plan
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Pre Loading Plan</li>
      </ol>
    </section>
    <section class="content">   
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px">
          <div class="row" style="border-bottom:1px solid #555555; padding:20px;">
            <div class="col-md-10">
              <h3 style="text-align:center; color:black; font-weight:400;  font-size:20px; ">CREATE PRE LOADING PLAN</h3>
            </div>
            <div class="col-md-2" style="margin-top:15px;">
              <button type="button"  id="inculde_joborders" class="btn btn-danger"><i class="fa fa-plus"></i>&nbsp;ADD JOB ORDERS</button>
            </div>
          </div> 
          <form  id="loading_guide_form" action="./joborder_loading_curd.php" method="post" >
          <input type="hidden" name="loading_plan_save" value="save">
          <input type="hidden" name="all_joborderslist">          
          <div class="row" style="margin-top:20px;">
            <div class="col-md-12">
              <div class="row" style="margin-bottom:20px;">
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Branch</span>
                          <input type="text" name="branch" class="form-control" required placeholder="Input Branch">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Agent</span>
                        <select name="agent_id" id="" class="form-control select2" required data-placeholder="Select Agent" style="width:100%" >
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
                        <span class="input-group-addon span_custom">Reference</span>
                          <input type="text" name="reference" class="form-control"  required placeholder="Input Reference">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Line</span>
                          <input type="text" name="line" class="form-control" required placeholder="Input Line">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Type</span>
                        <input type="text" name="type" class="form-control" required placeholder="Input Type">
                      </div>
                    </div>                  
                  </div>
                  <div class="form-group row">
                      <label class="col-md-4" for="" style="margin-top:10px;font-weight: 500;">Loose Pieces</label>
                      <div class="col-md-8">
                            <label class="control-label radio-inline"><input type="radio" value="Yes" checked  name="losses_pieces" >&nbsp;Yes</label>
                            <label class="control-label radio-inline"><input type="radio" value="No" name="losses_pieces">&nbsp;No</label>
                      </div>
                  </div>                
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" >
                  <table id='joborders_lists' style="width:100%;" class="table">
                    <thead>
                      <tr class="text-center" style="background-color:#B80008 !important;color:white">
                          <th class="text-center" style="color:white">Date</th>
                          <th class="text-center" style="color:white">JOB</th>
                          <th class="text-center" style="color:white">Customer<br>Name</th>
                          <th class="text-center" style="color:white">Supplier<br>Company</th>                          
                          <th class="text-center" style="color:white">Service</th>
                          <th class="text-center" style="color:white">Ship To</th>
                          <th class="text-center" style="color:white">Agent<br>Name</th>
                          <th class="text-center" style="color:white">Status</th>
                          <th class="text-center" style="color:white">Tracking#</th>
                          <th class="text-center" style="color:white">WR#</th>
                          <th class="text-center" style="color:white">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
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
  <!-- Form -->
  </section>
</div>
<div id="joborders_for_loading" class="modal fade" role="dialog" style="overflow: auto!important;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">JobOrders List</h4>   
        </div>
        <div class="modal-body">
            <div class="row">
             <div class="col-md-12" style="margin-top:20px;">
                <form clsss="row text-center" action="#" id="filter">
                    <div class="col-md-offset-3 col-md-2">                        
                        <div class=" input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                            <input type="text" class="form-control" data-provide="datepicker" id="from"
                            data-date-format="yyyy-mm-dd" laceholder="To" value="1990-01-01"   autocomplete="off"  placeholder="From">
                        </div>                          
                    </div>
                    <div class="col-md-2">                        
                        <div class=" input-group">
                            <input t type="text" class="form-control" data-provide="datepicker" id="to"
                                  data-date-format="yyyy-mm-dd" laceholder="To" value="<?php echo date('Y-m-d') ?>"   autocomplete="off"  placeholder="To">
                        </div>                    
                    </div>
                    <div class="col-md-2">
                        <div class="form-group row">                            
                            <button  type="submit" class="btn btn-success "><i class="fa fa-search"></i>&nbsp;Filter</button>                                
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        <button id="add_loadings_joborderslists"  type="button" class="btn btn-danger "><i class="fa fa-save"></i>&nbsp;Add JobOrders</button>                                
                    </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='empTable' style="width:100%;" class='display dataTable'>
                    <thead>
                      <tr class="text-center">
                          <th class="text-center" style="color:white">Date</th>
                          <th class="text-center" style="color:white">JOB</th>
                          <th class="text-center" style="color:white">Customer<br>Name</th>
                          <th class="text-center" style="color:white">Supplier<br>Company</th>                          
                          <th class="text-center" style="color:white">Service</th>
                          <th class="text-center" style="color:white">Ship To</th>
                          <th class="text-center" style="color:white">Agent<br>Name</th>
                          <th class="text-center" style="color:white">Status</th>
                          <th class="text-center" style="color:white">Tracking#</th>
                          <th class="text-center" style="color:white">WR#</th>
                          <th class="text-center" style="color:white">ShortCut</th>
                          <th class="text-center" style="color:white">Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
        </div>        
      </div>
    </div>
</div>
<div id="editJobOrder" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
    </div>
</div>
<div id="viewNotes" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<div id="addwr" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<div id="addtracking" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#pre_loading_plan").addClass("active");
  $("#pre_loading_plan #create").addClass("active");
  $('input[type="file"]').imageuploadify();
    $(".select2").select2();    
    $('.form_datetime').datetimepicker();
    $('#datepicker').datepicker({
          autoclose: true
      });
    $("#inculde_joborders").on("click", function(e){    
        table.ajax.reload( null, false );   
        $("#joborders_for_loading").modal('show');
    });  
    var from='', to='', checklist;
    var table=$('#empTable').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          'processing': true,
          'serverSide': true,        
          'serverMethod': 'post',
          "order": [
              [1, "desc"]
          ],
          'columnDefs': [{
              orderable: false,
              targets: [9]
          }],
          'ajax': {
              'url': 'ajaxfile_joborders_for_loading.php',
              "data" :function(d){                  
                  d.from = Getfrom();
                  d.to = Getto();
                  d.checklist = Getchecklist();
              }
          },
        'columns': [ {
                data: 'fecha'
            },{
                data: 'id'
            }, {
                data: 'customer_name'
            },{
                data: 'supplier_company'
            },   {
                data: 'service'
            }, {
                data: 'customer_city'
            }, {
                data: 'agent_name'
            }, {
                data: 'status'
            },{
                data: 'tracking'
            },{
                data: 'wr'
            },{
                data: 'shortcut'
            },{
                data: 'action'
            }]
      });
      function Getfrom(){
            return $("#from").val();
      }
      function Getto(){
          return $("#to").val();
      }     
      function Getchecklist(){
          return $("input[name='all_joborderslist']").val();
      } 
      $("#filter").submit(function(e) { 
        e.preventDefault();     
          swal({
          title: "Date Fiter!",
          text: "Data filtered successful!",
          icon: "success",
          });
          table.ajax.reload();
      });
      $("#add_loadings_joborderslists").on("click", function(e){      
            var  checks_joborders= $("input[name='all_joborderslist']").val();
            if(checks_joborders==''){
              checks_joborders=[];
            } else {
              checks_joborders=checks_joborders.split(",");
            }
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function (e,ele) {
                  if(checks_joborders.indexOf(ele.value) !== -1){
                      alert("The WareHouse already Include!");
                  } else{
                      checks_joborders.push(ele.value);
                  }                    
              })
            if(checks_joborders.length>0){
                $.ajax({
                method: 'POST',
                url: "./joborder_loading_curd.php",
                data: {
                    checks_joborders:checks_joborders,
                    joborders_list:'get'
                    }
                })
                .done(function (response) {
                    
                    var data=JSON.parse(response);
                    $("#joborders_lists tbody").html(data.html);                  
                    $("input[name='all_joborderslist']").val(data.all_joborderslist);                   
                    table.ajax.reload( null, false ); 
                    $("#joborders_for_loading").modal('hide');                  
                })
            }else{
                alert("Please check checkbox!!")
                
            }
             
      }); 
   
    function onjobordersdelete_loading(key,id){
      var  checks_joborders= $("input[name='all_joborderslist']").val();
        checks_joborders = checks_joborders.split(",");
        var index = checks_joborders.indexOf(id.toString());
        if (index > -1) {
          checks_joborders.splice(index, 1);
        }           
        $.ajax({
            method: 'POST',
            url: "./joborder_loading_curd.php",
            data: {
                checks_joborders:checks_joborders,
                joborders_list:'get'
                }
            })
            .done(function (response) {                    
                var data=JSON.parse(response);
                $("#joborders_lists tbody").html(data.html);  
                $("input[name='all_joborderslist']").val(data.all_joborderslist);
            })
    }
    $("#loading_guide_form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) { 
        if(response){
          swal({
              title: "Pre Loading Plan!",
              text: "New Pre Loading Plan created successful!",
              icon: "success",
          });
        }    
        location.reload();  
        
      });
    })
    function editJobOrder(id) {
        $.get('editorder.php?id=' + id, function(response) {
            $('#editJobOrder .modal-dialog').html(response);
            $("#edit_order").submit(function(e) {
                event.preventDefault(); //prevent default action 
                var post_url = $(this).attr("action"); //get form action url
                var form_data = $(this).serialize(); //Encode form elements for submission
                $.post(post_url, form_data, function(response) {
                    $("#editJobOrder").modal('hide');
                    table.ajax.reload(null, false);
                    swal({
                        title: "JobOrder!",
                        text: "JobOrder deleted successful!!",
                        icon: "success",
                    });
                });
            });
            $("#delete_order").submit(function(e) {
                event.preventDefault(); //prevent default action 
                var post_url = $(this).attr("action"); //get form action url
                var form_data = $(this).serialize(); //Encode form elements for submission
                $.post(post_url, form_data, function(response) {
                    $("#editJobOrder").modal('hide');
                    table.ajax.reload(null, false);
                    swal({
                        title: "JobOrder Update!",
                        text: "JobOrder updated successful!",
                        icon: "error",
                    });
                });
            });
        });
        $("#editJobOrder").modal('show');
    }
    function viewNotes(id) {
          $.get('createnote.php?id=' + id, function(response) {
              $('#viewNotes .modal-dialog').html(response);
              $("#create_order").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {

                      $("#viewNotes").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "New Notes!",
                          text: "New Notes created successful!",
                          icon: "success",
                      });
                  });
              });
          });
          $("#viewNotes").modal('show');
      }

      function addwr(id) {
          $.get('addwr2.php?id=' + id, function(response) {
              $('#addwr .modal-dialog').html(response);
              $("#add_wr").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {

                      $("#addwr").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "NEW WR!",
                          text: "New WR created successful!",
                          icon: "success",
                      });
                  });
              });
              $("#delete_wr").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#addwr").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "WR!",
                          text: "WR deleted successful!",
                          icon: "error",
                      });
                  });
              });
          });
          $("#addwr").modal('show');
      }

      function addtracking(id) {
          $.get('addtracking.php?id=' + id, function(response) {
              $('#addtracking .modal-dialog').html(response);
              $("#add_tracking").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#addtracking").modal('hide');
                      swal({
                          title: "New Tracking!",
                          text: "New Tracking created successful!",
                          icon: "success",
                      });
                      table.ajax.reload(null, false);

                  });
              });

          });
          $("#addtracking").modal('show');
      }

      function tracking_delete(id) {
          $.ajax({
                  method: 'GET',
                  url: "./curd.php",
                  data: {
                      delete_tracking: id,
                  }
              })
              .done(function(response) {
                  swal({
                      title: "Tracking!",
                      text: "Tracking deleted successful!",
                      icon: "success",
                  });
                  $("#addtracking .tr_" + id).remove();
                  table.ajax.reload(null, false);
              })
      }
</script>


</body>
</html>
