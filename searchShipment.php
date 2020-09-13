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
    <title>Latim Cargo & Trading | Shipment Search</title>
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
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="assets/js/imageuploadify.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/select2/select2.js"></script> 
    <script src="plugins/moment.min.js"></script>
    <script src="./plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
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
        <small>Search</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search SHIPMENT</li>
      </ol>
    </section>

    <section class="content">

<?php if ($step=='') {$step='1';} ?>

<?php if ($step=='1'){ ?>
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-2 col-md-8 shadow2" style="background: white;margin-top:50px">
          <div class="row">
            <div class="col-md-12">
              <h3 style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">SEARCHER SHIPMENT</h3>
            </div>
          </div>
          <form action="searchWarehouse.php" id="step1_form"  method="get">
            <input name="step" type="hidden"  value="2" class="form-control">
            <div class="row" style="margin:30px 0px">
              <div class="col-md-6">  
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group date form_datetime" data-link-field="fecha">
                            <div class="input-group-addon "><i class="fa fa-calendar input-fa"></i></div>
                            <input type="text" class="form-control "   placeholder="Select date" readonly >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <input type="hidden" id="fecha"  name="fecha" value="" />
                          </div>
                    </div>
                </div>                 
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Tracking</span>
                        <textarea name="tracking" class="form-control" id="" cols="30" rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Supplier</span>
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
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Consignee</span>
                      <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="width:100%" >
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
                      <span class="input-group-addon span_custom">Bill to</span>
                      <select name="bill_id" id="" class="form-control select2" data-placeholder="Select Bill" style="width:100%" >
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
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Reference</span>
                        <input type="text" name="reference_id" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="">Invoice</span>
                          <input type="text" name="invoice" class="form-control" placeholder="">
                      </div>
                    </div>                    
                </div>
                <div class="form-group row">                  
                  <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="">PO</span>
                          <input type="text" name="po" class="form-control" placeholder="">
                      </div>
                  </div>    
                </div>                 
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="font-size:12px">Delivered By</span>
                          <input type="text" name="delivered_by1" class="form-control" placeholder="">
                      </div>
                    </div>                    
                </div>                
              </div>  
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
                      <span class="input-group-addon span_custom" style="font-size:10px">Pickup Number</span>
                        <input type="text" name="pickup_number" class="form-control" placeholder="Pickup Number">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Location</span>
                          <input type="text" name="location1" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">                    
                          <input type="text" name="location2" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Can</span>
                          <input type="text" name="can" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">                    
                      <label  class="control-label"><input type="checkbox" name="distribution">&nbsp;Distribution</label>
                    </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom" style="font-size:13px;">Destination</span>
                        <input type="text" name="destination" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Service</span>
                          <select name="instination" id="" class="form-control select2"  data-placeholder="Select Service">
                            <option value="">Select Service</option>
                            <option value="Pending">Pending</option>
                            <option value="Air door to door">Air door to door</option>
                            <option value="Air Service">Air Service</option>
                            <option value="Ocean door to door">Ocean door to door</option>
                            <option value="Ocean Service">Ocean Service</option>
                          </select>
                      </div>
                    </div>                  
                </div>
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Status</span>
                          <select name="status" id="" class="form-control select2"  data-placeholder="Select Status">
                            <option value="">Select Status</option>
                            <option value="PRE-ALERT">PRE-ALERT</option>
                            <option value="RECIBIDO EN BODEGA CHINA">RECIBIDO EN BODEGA CHINA</option>
                            <option value="RETURNED">RETURNED</option>
                            <option value="TRANSITO">TRANSITO</option>
                            <option value="EN DESTINO / PUERTO MARITIMO">EN DESTINO / PUERTO MARITIMO</option>
                            <option value="CARGA ENTREGADA">CARGA ENTREGADA</option>
                            <option value="RECIBIDO EN VALENCIA">RECIBIDO EN VALENCIA</option>
                            <option value="COMUNICADO">COMUNICADO</option>
                            <option value="EN DESTINO / AEROPUERTO">EN DESTINO / AEROPUERTO</option>
                            <option value="RECIBIDO EN ALMACEN CARACAS">RECIBIDO EN ALMACEN CARACAS</option>
                          </select>
                      </div>
                    </div>                  
                </div> 
                <div class="form-group row">
                  <label class="control-label col-md-4" ></label>
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox" name="dangerous_goods" >&nbsp;Dangerous Goods</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox"  name="seo" >&nbsp;SED</label>
                          <label class="control-label radio-inline"><input type="checkbox"  name="fragile">&nbsp;FRAGILE</label>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox"  name="insurance" >&nbsp;Insurance</label>
                        </div>
                      </div> 
                    </div>                   
                </div>
              </div>
            </div>
            <div class="row" style="padding-bottom:30px">
                  <div class="col-md-12 text-right">
                      <button type="submit" class="btn btn-success" >Next&nbsp;<i class="fa fa fa-chevron-right"></i></button>
                  </div>
            </div>
          </form>
        </div>
      </div>     
<?php } ?>

    <?php if ($step=='2'){ ?>
   
        <div class="searchPage shadow2" style="background: white;margin-top:50px">
          <div class="row" style="border-bottom:1px solid #555555;">
            <div class="col-md-8" >
              <h3 style="text-align:center; color:black; font-weight:400; font-size:20px;" >SEARCHER WAREHOUSE RECEIPT</h3>
            </div>
            <div class="col-md-4 text-center" style="margin-bottom:10px;">
                <p class="text-center">Change Status</p>
                <form class="form-inline">
                  <div class="form-group">
                      <select name="statusUpdate" id="statusUpdate" data-placeholder="Select Status" class="form-control select2" style="min-width:200px;">
                            <option value="">Select Status</option>
                            <option value="PRE-ALERT">PRE-ALERT</option>
                            <option value="RECIBIDO EN BODEGA CHINA">RECIBIDO EN BODEGA CHINA</option>
                            <option value="RETURNED">RETURNED</option>
                            <option value="TRANSITO">TRANSITO</option>
                            <option value="EN DESTINO / PUERTO MARITIMO">EN DESTINO / PUERTO MARITIMO</option>
                            <option value="CARGA ENTREGADA">CARGA ENTREGADA</option>
                            <option value="RECIBIDO EN VALENCIA">RECIBIDO EN VALENCIA</option>
                            <option value="COMUNICADO">COMUNICADO</option>
                            <option value="EN DESTINO / AEROPUERTO">EN DESTINO / AEROPUERTO</option>
                            <option value="RECIBIDO EN ALMACEN CARACAS">RECIBIDO EN ALMACEN CARACAS</option>
                      </select>
                  </div>
                  <button type="button" id="statusUpdate_btn" class="btn btn-primary">Update</button>
                </form>
            </div>
          </div>           
          <div class="row" style="margin-top:20px">
              <div class="col-md-12 text-right">
                <a class="toggle-vis btn btn-success btn-sm" data-column="0">Service</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="1">Number</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="2">Dest</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="3">Date</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="4">Pieces</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="5">Weight</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="6">Volume</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="7">Value</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="8">Shipper</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="9">Consignee</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="10">Reference</a>
                <a class="toggle-vis btn btn-success btn-sm" data-column="11">Tracking</a>
              </div>
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
                </form>
              </div>
              <div class="col-md-12">                  
                <div class="table-responsive">
                      <table id='empTable' style="width:100%;" class='display dataTable'>
                          <thead>
                              <tr class="text-center">
                                  <th>Service</th>
                                  <th>Number</th>
                                  <th>Dest</th>
                                  <th >Date</th>
                                  <th>Pieces</th>
                                  <th>Weight</th>
                                  <th>Volume</th>
                                  <th>Value</th>
                                  <th>Shipper</th>
                                  <th>Consignee</th>
                                  <th>Reference</th>
                                  <th>Tracking</th>
                                  <th>ShortCut</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div> 
        </div>
    <?php } ?>
  <!-- Form -->
  </section>
</div>
<div id="editwarehouse" class="modal fade" role="dialog" style="overflow: auto!important;">
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
  $("#shipment").addClass("active");
  $("#shipment #search").addClass("active");
  $('input[type="file"]').imageuploadify();
  function ConfirmDelete() {
        return confirm("Are you sure you want to delete?");
    }
    //Initialize Select2 Elements
    $('.form_datetime').datetimepicker();
   
    $(".select2").select2();
    var jobCheckval, from='', to='';
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
              targets: [8, 9, 12,13]
          }],
          'ajax': {
              'url': 'ajaxfile_warehouse.php',
              "data" :function(d){
                  d.fecha ='<?php echo $_GET['fecha'] ?>';
                  d.tracking ='<?php echo $_GET['tracking'] ?>';
                  d.supplier_id ='<?php echo $_GET['supplier_id'] ?>';
                  d.consignee_id ='<?php echo $_GET['consignee_id'] ?>';
                  d.agent_id ='<?php echo $_GET['agent_id'] ?>';
                  d.bill_id ='<?php echo $_GET['bill_id'] ?>';
                  d.reference_id ='<?php echo $_GET['reference_id'] ?>';
                  d.invoice ='<?php echo $_GET['invoice'] ?>';
                  d.po ='<?php echo $_GET['po'] ?>';
                  d.delivered_by1 ='<?php echo $_GET['delivered_by1'] ?>';
                  d.branch ='<?php echo $_GET['branch'] ?>';
                  d.pickup_number ='<?php echo $_GET['pickup_number'] ?>';
                  d.location1 ='<?php echo $_GET['location1'] ?>';
                  d.location2 ='<?php echo $_GET['location2'] ?>';
                  d.can ='<?php echo $_GET['can'] ?>';
                  d.destination ='<?php echo $_GET['destination'] ?>';
                  d.instination ='<?php echo $_GET['instination'] ?>';
                  d.status ='<?php echo $_GET['status'] ?>';
                  d.dangerous_goods ='<?php echo $_GET['dangerous_goods'] ?>';
                  d.seo ='<?php echo $_GET['seo'] ?>';
                  d.insurance ='<?php echo $_GET['insurance'] ?>';
                  d.fragile ='<?php echo $_GET['fragile'] ?>';
                  d.from = Getfrom();
                  d.to = Getto();
                  d.jobCheckval = GetjobCheck(); 
              }
          },
        'columns': [{
                data: 'instination'
            }, {
                data: 'id'
            },{
                data: 'destination'
            }, {
                data: 'fecha'
            },   {
                data: 'total_pieces'
            }, {
                data: 'total_weight'
            },
            {
                data: 'total_volume'
            },
            {
                data: 'value'
            },{
                data: 'supplier_id'
            }, {
                data: 'consignee_id'
            },
              {
                data: 'reference_id'
            },
              {
                data: 'tracking'
            },{
                data: 'shortcut'
            },
              {
                data: 'action'
            }],
          "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            switch(aData['status']){
                case 'PRE-ALERT':
                    $('td', nRow).css('background-color', 'white')
                  break;
                case 'RECIBIDO EN BODEGA CHINA':
                    $('td', nRow).css('background-color', '#4ee27f9e')
                  break;
                case 'RETURNED':
                    $('td', nRow).css('background-color', 'orange')
                  break;
                case 'TRANSITO':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'EN DESTINO / PUERTO MARITIMO':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'CARGA ENTREGADA':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'RECIBIDO EN VALENCIA':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'COMUNICADO':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'EN DESTINO / AEROPUERTO':
                    $('td', nRow).css('background-color', 'red')
                  break;
                case 'RECIBIDO EN ALMACEN CARACAS':
                    $('td', nRow).css('background-color', 'red')
                    break;
            }
        }
      });
      function Getfrom(){
            return $("#from").val();
      }
      function Getto(){
          return $("#to").val();
      }
      function GetjobCheck(){
            return jobCheckval;
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
      $("#statusUpdate_btn").on("click", function(e){      
            var  jobCheck=[];
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function (e,ele) {
                jobCheck.push(ele.value);
            })
            jobCheckval = Object.assign({}, jobCheck);
            if(jobCheck.length>0){
                $.ajax({
                method: 'POST',
                url: "./warehouse_curd.php",
                data: {
                    jobCheck:jobCheck,
                    status_Update:'statusUpdate',
                    status: $("#statusUpdate").val()
                    }
                })
                .done(function (response) {
                    swal({
                        title: "Status!",
                        text: "Status updated successful!",
                        icon: "success",
                    });  
                    table.ajax.reload( null, false ); 
                   
                })
            }else{
                alert("Please check checkbox!!")
            }
             
       }); 
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
        if( $(this).css("background-color")=='rgb(0, 141, 76)'){          
          $(this).css("background-color","red");
        }else{
          $(this).css("background-color","rgb(0, 141, 76)");
         }
        
        // Get the column API object
        var column = table.column( $(this).attr('data-column') ); 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
    function editwarehouse(id) {
          $.get('edit_warehouse.php?id='+id,function(response){ 
              $('#editwarehouse .modal-dialog').html(response); 
              $("#by_boxes_content .btn_plus").on("click", function(e){
                e.preventDefault();
                var html='<div class="item col">';
                    html+='<input type="hidden" name="pieces_id[]" value="">';
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
                    html+='<input type="text"  name="byBoxes_weightX[]" required class="form-control">';
                    html+='</div>';            
                    html+='<div class="col-md-2 col-item">';
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
                        html+='<input type="hidden" name="pieces_id[]" value="">';
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
                      $("#editwarehouse").modal('hide'); 
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
                            $("#editwarehouse").modal('hide'); 
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
          var pieces=$(this)[0].children[1].children[0].children[0].value;
          var lenght=$(this)[0].children[1].children[1].children[0].value;
          var width=$(this)[0].children[1].children[2].children[0].value;
          var height=$(this)[0].children[1].children[3].children[0].value;
          var weight=$(this)[0].children[1].children[4].children[0].value;
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
