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
    <title>Latim Cargo & Trading | WareHouse Create</title>
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
        Loading Guide 
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Loading Guide</li>
      </ol>
    </section>

    <section class="content">   
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px">
          <div class="row" style="border-bottom:1px solid #555555; padding:20px;">
            <div class="col-md-10">
              <h3 style="text-align:center; color:black; font-weight:400;  font-size:20px; ">CREATE LOADING GUIDE</h3>
            </div>
            <div class="col-md-2" style="margin-top:15px;">
              <button type="button"  id="inculde_warehouse" class="btn btn-danger"><i class="fa fa-plus"></i>Add WareHouse</button>
            </div>
          </div> 
          <form  id="loading_guide_form" action="./warehouse_loading_curd.php" method="post" >
          <input type="hidden" name="loading_guide_save" value="save">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="all_total_pieces">
              <input type="hidden" name="all_total_weight">
              <input type="hidden" name="all_total_volume">
              <input type="hidden" name="all_total_charg_weight"> 
              <input type="hidden" name="all_warehouselist"> 
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
                    <th id="all_total_pieces" class="text-center"></th>
                    <th id="all_total_weight" class="text-center"></th>
                    <th id="all_total_volume" class="text-center"></th>
                    <th id="all_total_charg_weight" class="text-center"></th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row" style="margin-bottom:20px;">
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Branch</span>
                          <input type="text" name="branch" class="form-control" placeholder="Input Branch">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Agent</span>
                        <select name="agent_id" id="" class="form-control select2" data-placeholder="Select Agent" style="width:100%" >
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
                          <input type="text" name="reference" class="form-control" placeholder="Input Reference">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Line</span>
                          <input type="text" name="line" class="form-control" placeholder="Input Line">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Type</span>
                        <input type="text" name="type" class="form-control" placeholder="Input Type">
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
                  <table id='warehouse_reciept_lists' style="width:100%;" class="table">
                    <thead>
                      <tr class="text-center" style="background-color:#B80008 !important;color:white">
                          <th class="text-center">Number</th>
                          <th class="text-center">Reference</th>
                          <th class="text-center">Date</th>
                          <th class="text-center">Dest</th>                          
                          <th class="text-center">Pieces</th>
                          <th class="text-center">Weight</th>
                          <th class="text-center">Volume</th>
                          <th class="text-center">Shipper</th>
                          <th class="text-center">Consignee</th>
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
<div id="warehouse_for_loading" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">WareHouse List</h4>   
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
                        <button id="add_loadings_warelists"  type="button" class="btn btn-danger "><i class="fa fa-save"></i>&nbsp;Add Warehouse</button>                                
                    </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='empTable' style="width:100%;" class='display dataTable'>
                    <thead>
                      <tr class="text-center">
                          <th>Number</th>
                          <th>Reference</th>
                          <th>Date</th>
                          <th>Dest</th>                          
                          <th>Pieces</th>
                          <th>Weight</th>
                          <th>Volume</th>
                          <th>Shipper</th>
                          <th>Consignee</th>
                          <th>Action</th>
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
<div id="editwarehouse" class="modal fade" role="dialog" style="    overflow: auto!important;">
    <div class="modal-dialog modal-lg">
    </div>
</div>
<div id="file_update" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
        </div>
        <div class="modal-body" style="margin:20px;">
        <form action="./warehouse_curd.php" id="addfile" method="post" enctype="multipart/form-data">
          <input type="hidden" id="warehouse_fileupload" name="warehouse_fileupload" value="add">
          <input type="hidden" id="warehouse_fileupload_id" name="warehouse_fileupload_id" value="add">
          <div class="row">
            <div class="col-md-12">
                <input type="file" id="image_file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
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
<div id="editsupplier" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<div id="editconsignee" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<div id="editsbill" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div>
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#loadingguide_list").addClass("active");
  $("#loadingguide_list #create").addClass("active");
  $('input[type="file"]').imageuploadify();
    $(".select2").select2();    
    $('.form_datetime').datetimepicker();
    $('#datepicker').datepicker({
          autoclose: true
      });
    $("#inculde_warehouse").on("click", function(e){        
        $("#warehouse_for_loading").modal('show');
    });
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
              'url': 'ajaxfile_warehouse_for_loading.php',
              "data" :function(d){                  
                  d.from = Getfrom();
                  d.to = Getto();
                  d.checklist = Getchecklist();
              }
          },
        'columns': [ {
                data: 'id'
            },{
                data: 'reference_id'
            }, {
                data: 'fecha'
            },{
                data: 'destination'
            },   {
                data: 'total_pieces'
            }, {
                data: 'total_weight'
            }, {
                data: 'total_volume'
            }, {
                data: 'supplier_id'
            },{
                data: 'consignee_id'
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
          return $("input[name='all_warehouselist']").val();
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
      $("#add_loadings_warelists").on("click", function(e){      
            var  checks_warehouse= $("input[name='all_warehouselist']").val();
            if(checks_warehouse==''){
              checks_warehouse=[];
            } else {
              checks_warehouse=checks_warehouse.split(",");
            }
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function (e,ele) {
                  if(checks_warehouse.indexOf(ele.value) !== -1){
                      alert("The WareHouse already Include!");
                  } else{
                      checks_warehouse.push(ele.value);
                  }                    
              })
            if(checks_warehouse.length>0){
                $.ajax({
                method: 'POST',
                url: "./warehouse_loading_curd.php",
                data: {
                    checks_warehouse:checks_warehouse,
                    warehouse_list:'get'
                    }
                })
                .done(function (response) {
                    
                    var data=JSON.parse(response);
                    $("#warehouse_reciept_lists tbody").html(data.html);                  
                    $("input[name='all_total_pieces']").val(data.all_total_pieces);
                    $("input[name='all_total_weight']").val(data.all_total_weight);
                    $("input[name='all_total_volume']").val(data.all_total_volume);
                    $("input[name='all_total_charg_weight']").val(data.all_total_weight);
                    $("input[name='all_warehouselist']").val(data.all_warehouselist);
                    $("#all_total_pieces").text(data.all_total_pieces);
                    $("#all_total_weight").text(data.all_total_weight);
                    $("#all_total_volume").text(data.all_total_volume);
                    $("#all_total_charg_weight").text(data.all_total_weight);
                    table.ajax.reload( null, false ); 
                    $("#warehouse_for_loading").modal('hide');                  
                })
            }else{
                alert("Please check checkbox!!")
                
            }
             
      }); 
   
    function onwarehousedelete_loading(key,id){
      var  checks_warehouse= $("input[name='all_warehouselist']").val();
            checks_warehouse = checks_warehouse.split(",");
            var index = checks_warehouse.indexOf(id.toString());
            if (index > -1) {
              checks_warehouse.splice(index, 1);
            }           
            $.ajax({
                method: 'POST',
                url: "./warehouse_loading_curd.php",
                data: {
                    checks_warehouse:checks_warehouse,
                    warehouse_list:'get'
                    }
                })
                .done(function (response) {
                    
                    var data=JSON.parse(response);
                    $("#warehouse_reciept_lists tbody").html(data.html);                  
                    $("input[name='all_total_pieces']").val(data.all_total_pieces);
                    $("input[name='all_total_weight']").val(data.all_total_weight);
                    $("input[name='all_total_volume']").val(data.all_total_volume);
                    $("input[name='all_total_charg_weight']").val(data.all_total_weight);
                    $("input[name='all_warehouselist']").val(data.all_warehouselist);
                    $("#all_total_pieces").text(data.all_total_pieces);
                    $("#all_total_weight").text(data.all_total_weight);
                    $("#all_total_volume").text(data.all_total_volume);
                    $("#all_total_charg_weight").text(data.all_total_weight);
                })
    }
    
    
    $("#loading_guide_form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) { 
        if(response){
          swal({
              title: "Loading Guide!",
              text: "New Loading Guide created successful!",
              icon: "success",
          });
        }    
        location.reload();  
        
      });
    })
    function editwarehouse(id) {
          $.get('edit_warehouse.php?id='+id,function(response){ 
              $('#editwarehouse .modal-dialog').html(response); 
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
                $("#warehouse_receipt_content .btn_plus").on("click", function(e){
                    e.preventDefault();
                    var html='<div class="item col">';
                        html+='<div class="form-group row">';
                        html+='<div class="col-md-5 col-item">';
                        html+='<input type="text"  name="byBoxes_descriptionx[]"  class="form-control">';
                        html+='</div>';
                        html+='<div class="col-md-3 col-item">';
                        html+='<input type="text" name="byBoxes_pricex[]"  class="form-control">';
                        html+='</div>';
                        html+='<div class="col-md-3 col-item">';
                        html+='<input type="text" name="byBoxes_quantityx[]"  class="form-control">';
                        html+='</div>';                                      
                        html+='<div class="col-md-1 col-item">';
                        html+='<button  type="button" class="btn btn_minus">-</button>';
                        html+='</div>';
                        html+='</div>';
                        html+='</div>';
                      
                    $("#warehouse_receipt_content").append(html);                           
                      $('#warehouse_receipt_content .btn_minus').on("click", function (e) {
                        e.preventDefault(); 
                        $(this).parent('div').parent('div').parent('div').remove(); 
                      })
                  });

                  $('#warehouse_receipt_content .btn_minus').on("click", function (e) {
                    e.preventDefault(); 
                    $(this).parent('div').parent('div').parent('div').remove(); 
                  })
                    
                  $("#edit_warehouse_tab1").submit(function(e) {
                      event.preventDefault(); //prevent default action 
                      var post_url = $(this).attr("action"); //get form action url
                      var form_data = $(this).serialize(); //Encode form elements for submission
                      
                      $.post( post_url, form_data, function( response ) {  
                          table.ajax.reload( null, false );     
                          swal({
                              title: "WareHouse!",
                              text: "WareHouse updated successful!!",
                              icon: "success",
                            });   
                      });
                  });
                  $("#edit_warehouse_tab2").submit(function(e) {
                      event.preventDefault(); //prevent default action 
                      var post_url = $(this).attr("action"); //get form action url
                      var form_data = $(this).serialize(); //Encode form elements for submission
                      
                      $.post( post_url, form_data, function( response ) {  
                          table.ajax.reload( null, false );     
                          swal({
                              title: "WareHouse!",
                              text: "WareHouse updated successful!!",
                              icon: "success",
                            });   
                      });
                  });
                $("#delete_warehouse").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editwarehouse").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "WareHouse!",
                          text: "WareHouse deleted successful!",
                          icon: "error",
                      }); 
                  });
              });
              
            });                
        $("#editwarehouse").modal('show');
    }
    function addFile(id){
      $("#file_update").modal('show');
      $("#warehouse_fileupload_id").val(id);
    }
    function editsuppliermodal(id) {
          $.get('edit_supplier_warehouser.php?id='+id,function(response){ 
            $("#editsupplier .modal-dialog").html(response); 
            $("#edit_warehouse_supplier").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editsupplier").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "Supplier!",
                          text: "Supplier Information Updated successful!",
                          icon: "success",
                      }); 
                  });
              });
          });
          $("#editsupplier").modal('show');
    }
    function editconsigneemodal(id) {
          $.get('edit_consignee_warehouser.php?id='+id,function(response){ 
            $("#editconsignee .modal-dialog").html(response); 
            $("#edit_warehouse_consignee").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editconsignee").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "Consignee!",
                          text: "Consignee Information Updated successful!",
                          icon: "success",
                      }); 
                  });
              });
          });
          $("#editconsignee").modal('show');
    }
    function editbillmodal(id) {
          $.get('edit_bill_warehouser.php?id='+id,function(response){ 
            $("#editsbill .modal-dialog").html(response); 
            $("#edit_warehouse_bill").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editsbill").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "Bill!",
                          text: "Bill Information Updated successful!",
                          icon: "success",
                      }); 
                  });
              });
          });
          $("#editsbill").modal('show');
    }
    $("#addfile").submit(function(e) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var fd = new FormData();
        var totalfiles = document.getElementById('image_file').files.length;
          for (var index = 0; index < totalfiles; index++) {
            fd.append("image_file[]", document.getElementById('image_file').files[index]);
          }
         fd.append( 'warehouse_fileupload_id', $("input[name='warehouse_fileupload_id']").val());
         fd.append( 'warehouse_fileupload', 'add');
         $.ajax({
           url: './warehouse_curd.php',
           data: fd,
           processData: false,
           cache: false,
           contentType: false,
           type: 'POST',
           success: function(data){
            $("#file_body").html(data);  
            $("#file_update").modal('hide');         
            swal({
                title: "File!",
                text: "New Files Uploaded successful!!",
                icon: "success",
              });      
           }
         });
      });
    function onfiledelete(key,id,name){
      $.ajax({
        method: 'POST',
        url: "./warehouse_curd.php",
        data: {
            warehouse_id:id,
            name:name,
            filedelete :'delete',
            }
        })
        .done(function (response) {
          $("#file_list_"+key).remove();
            swal({
                title: "File Remove!",
                text: "File deleted successful!",
                icon: "error",
            }); 
        })
    }
      
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
</script>


</body>
</html>
