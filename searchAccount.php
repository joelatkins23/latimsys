<?php 
include 'conn.php';
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./login.php");
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
     }  
?>
<!doctype html>
<html style="height: auto;">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <title>Latim Cargo & Trading | Search Account</title>
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
     
     <style>
     table.dataTable tbody th, table.dataTable tbody td {
        padding: 10px 10px;
    }
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
  <div class="wrapper" style="height:auto">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <div class="content-wrapper">
      <section class="content-header">
          <h1>
            Accounts 
            <small>Search</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Search Accounts</li>
          </ol>
      </section>
      <section class="content">
          <div class="searchPage shadow2" style="background:white; width:100%; margin-left:-50%;">
            <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                <div class="col-md-12">
                  <h3 class="text-center">Search Account</h3>                                        
                </div>
            </div>            
            <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                      <table id='empTable' style="width:100%;" class='display dataTable'>
                          <thead>
                              <tr>
                                  <th class="text-center">ID</th>
                                  <th class="text-center">Type</th>
                                  <th class="text-center">Contact Person</th>
                                  <th class="text-center">Company Name</th>
                                  <th class="text-center">Country</th>
                                  <th class="text-center">Agent</th>
                                  <th class="text-center">ShortCut</th>
                              </tr>
                          </thead>
                      </table>
                    </div>
                </div>
            </div>
          </div>       
      </section>
    </div>
  </div>
  <div id="editaccount" class="modal fade" role="dialog" style="overflow: auto;">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">              
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Edit Account</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-user"></i>&nbsp;Edit Account</a></li>
                            <li><a data-toggle="tab" href="#joborder"><i class="fa fa-files-o"></i>&nbsp;JobOrder</a></li>
                            <li><a data-toggle="tab" href="#warehouse"><i class="fa fa-files-o"></i>&nbsp;WareHouse</a></li>
                            <li><a data-toggle="tab" href="#quotation"><i class="fa fa-home"></i>&nbsp;Quotation</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="row" >
                                    <div class="col-md-12" >
                                        <h3 style="text-align:center; color:black; font-weight:400; font-size:20px;padding-top: 20px;" >Edit Account</h3>
                                    </div>
                                </div> 
                                <form action="./curd.php" id="edit_account_form" method="post">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="account_update" value="update">
                                    <div class="row" style="padding:20px;">
                                        <div class="col-md-6" style="padding:20px">
                                            <?php if($level!='Seller'){?>
                                            <div class="input-group" id="agent_name_all">
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-circle"></i></span>                                            
                                                <select  data-placeholder="Select Agent" name="agent_name"  class="form-control select2" style="width:100%;">
                                                </select>                                               
                                            </div>
                                            <?php }else{ ?>
                                            <div class="input-group" id="agent_name_seller">
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-circle"></i></span>                                            
                                                <input type="text"  name="agent_name" class="form-control" value="">                                                
                                            </div>
                                            <?php } ?>
                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">Company</span>
                                                <input name="company" type="text" class="form-control" value="" placeholder="Company Name">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">Person</span>
                                                <input name="name" type="text" class="form-control" value="" placeholder="Contact Person" required="required">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">Address 1</span>
                                                <input name="address_1" type="text" class="form-control" value="" placeholder="Address 1">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">Address 2</span>
                                                <input name="address_2" type="text" class="form-control" value="" placeholder="Address 2">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">City</span>
                                                <input name="city" type="text" class="form-control" value="" placeholder="City">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">State</span>
                                                <input name="state" type="text" class="form-control" value="" placeholder="State" >
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom">Country</span>
                                                <select name="country" class="form-control select2"  style="width:100%;" required="required">
                                                    <option value="">Select Country</option>
                                                <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                                                    while ($row = mysqli_fetch_array($consulta_coutry)){ 
                                                    ?>
                                                <option                                                
                                                value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                                                <?php } ?> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding:20px">
                                            <div class="input-group" >
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-phone"></i> Mobile</span>
                                                <input name="telf1" type="text" class="form-control" value="" placeholder="Mobile Phone">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-phone"></i> Office</span>
                                                <input name="telf2" type="text" class="form-control" value="" placeholder="Office Phone">
                                            </div>


                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-phone"></i> QQ</span>
                                                <input name="qq" type="text" value="" class="form-control" placeholder="QQ">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom"><i  class="fa fa-phone"></i> WeChat</span>
                                                <input name="wechat" type="text" value="" class="form-control" placeholder="WeChat">
                                            </div>

                                            <div class="input-group" style="margin-top:20px;">
                                                <span class="input-group-addon span_custom"><i style="width:20px;" class="fa fa-envelope"></i></span>
                                                <input name="email" type="text" value="" class="form-control" placeholder="E-mail">
                                            </div>

                                            <!-- radio -->
                                            <div class="input-group" style="margin-top:20px;">                    
                                                <label>
                                                <input type="radio" name="type" value="Client" class="flat-red" required="required" >
                                                <label>Client</label>
                                                </label>
                                                <br>
                                                <label>                      
                                                <input type="radio" name="type" value="Supplier" class="flat-red" required="required" >
                                                <label>Supplier</label>
                                                </label>
                                            </div>            
                                        </div>
                                        <div class="col-md-12 text-right" style="padding:20px">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="joborder" class="tab-pane fade">
                                <div class="row" >
                                    <div class="col-md-12" >
                                        <h3 style="text-align:center; color:black; font-weight:400; font-size:20px;padding-top: 20px;" >SEARCHER JOB ORDER</h3>
                                    </div>
                                </div>           
                                <div class="row" style="margin-top:20px">                                   
                                    <div class="col-md-12" style="margin-top:20px;">
                                        <form clsss="row text-center" action="#" id="filter_joborder">
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
                                            <table id='joborderTable' style="width:100%;" class='display dataTable'>
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Date</th>
                                                        <th>Job#</th>
                                                        <th>Customer Name</th>
                                                        <th style="width:200px;">Supplier Company</th>
                                                        <th>Service</th>
                                                        <th>Ship To:</th>
                                                        <th>Agent Name</th>
                                                        <th>Status</th>
                                                        <th>Tracking</th>
                                                        <th>WR #</th>
                                                        <th>Shortcut</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div id="warehouse" class="tab-pane fade">
                                <div class="row" >
                                    <div class="col-md-12" >
                                        <h3 style="text-align:center; color:black; font-weight:400; font-size:20px;padding-top: 20px;" >SEARCHER WAREHOUSE RECEIPT</h3>
                                    </div>
                                </div>           
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-12 text-center">
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
                                        <form clsss="row text-center" action="#" id="filter_warehouse">
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
                                            <table id='warehouseTable' style="width:100%;" class='display dataTable'>
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
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div id="quotation" class="tab-pane fade">
                                <div class="row" >
                                    <div class="col-md-12 text-center">
                                        <h3 class="text-center" style="text-align:center; color:black; font-weight:400; font-size:20px;padding-top: 20px;">Search Quotations</h3>
                                    </div>                                    
                                </div>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12 text-center" style="margin-top:20px;">
                                        <form action="#" id="filter_quotation" class="text-center">
                                            <div class="col-md-offset-3 col-md-2">                        
                                                <div class=" input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                                                    <input type="text" class="form-control" data-provide="datepicker" id="from"
                                            data-date-format="yyyy-mm-dd" laceholder="To" value=""  autocomplete="off"  placeholder="From">
                                                </div>                          
                                            </div>
                                            <div class="col-md-2">                        
                                                <div class=" input-group">
                                                    <input t type="text" class="form-control" data-provide="datepicker" id="to"
                                            data-date-format="yyyy-mm-dd" laceholder="To" value="" autocomplete="off"  placeholder="To">
                                                </div>                    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group row">                            
                                                    <button  type="submit" class="btn btn-success "><i class="fa fa-search"></i>&nbsp;Filter</button>                                
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id='quotationTable' style="width:100%;" class='display dataTable'>
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Quotation#</th>
                                                    <th class="text-center">Client</th>
                                                    <th class="text-center">Origin</th>
                                                    <th class="text-center">Destination</th>
                                                    <th class="text-center">Service</th>
                                                    <th class="text-center">Agent</th>
                                                    <th class="text-center">Shorcuts</th>
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
<div id="editquotation" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg" >
    </div>
</div>
<div id="viewNotes" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div> 
<div id="editclient" class="modal fade" role="dialog">
    <div class="modal-dialog">
    </div>
</div> 
<div id="editJobOrder" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
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
    $("#accounts_list").addClass("active");
    $("#accounts_list #search").addClass("active");
    $('input[type="file"]').imageuploadify();
    function ConfirmDelete() {
        return confirm("Are you sure you want to delete?");
    }
    //Initialize Select2 Elements
    $('.form_datetime').datetimepicker();
   
    $(".select2").select2();
    var client_id='', supplier_bill_consignee_id='', supplier_client_id='';
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
            [0, "asc"]
        ],            
        'ajax': {
            'url': 'ajaxfile_account.php'
        },
        'columns': [{
            data: 'id'
        }, {
            data: 'type'
        }, {
            data: 'name'
        }, {
            data: 'company'
        }, {
            data: 'country'
        }, {
            data: 'agent',
        },{
            data: 'shortcut'
        }]
    });   
    function editaccount(id){
        supplier_bill_consignee_id=id;
        client_id=id;
        supplier_client_id=id;        
        warehousetable.ajax.reload();
        quotationTable.ajax.reload();
        joborderTable.ajax.reload();
        $.ajax({
            url: './curd.php',
            dataType: 'text',
            type: 'post',
            data: {
                id:id,
                get_account:"update"
            },
            success: function( data ){
               var rep=JSON.parse(data);
               <?php if($level=='Seller') {?>
                    $("#edit_account_form input[name='agent_name']").val(rep.agent_name);
               <?php }else{?>
                    $("#edit_account_form select[name='agent_name']").html(rep.agent);
               <?php } ?>
               $("#edit_account_form input[name='id']").val(rep.id);
               $("#edit_account_form input[name='company']").val(rep.company);
               $("#edit_account_form input[name='name']").val(rep.name);
               $("#edit_account_form input[name='address_1']").val(rep.address_1);
               $("#edit_account_form input[name='address_2']").val(rep.address_2);
               $("#edit_account_form input[name='city']").val(rep.city);
               $("#edit_account_form input[name='state']").val(rep.state);
               $("#edit_account_form select[name='country']").val(rep.country).trigger("change");
               $("#edit_account_form input[name='telf1']").val(rep.telf1);
               $("#edit_account_form input[name='telf2']").val(rep.telf2);
               $("#edit_account_form input[name='qq']").val(rep.qq);
               $("#edit_account_form input[name='wechat']").val(rep.wechat);
               $("#edit_account_form input[name='email']").val(rep.email);
               $("#edit_account_form input[name='type'][value=" + rep.type + "]").prop('checked', true);

               

            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
        $("#editaccount").modal('show');

    } 
    $("#edit_account_form").submit(function(e) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var form_data = $(this).serialize(); //Encode form elements for submission
        
        $.post( post_url, form_data, function( response ) {  
            table.ajax.reload( null, false );     
            swal({
                title: "Account!",
                text: "Account Infomation updated successful!!",
                icon: "success",
            });   
            $("#editaccount").modal('hide');
        });
    });
    //  Edit warehouse
    var warehousetable=$('#warehouseTable').DataTable({
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
            targets: [8, 9, 12]
        }],
        'ajax': {
            'url': 'ajaxfile_account_warehouse.php',
            "data" :function(d){                 
                d.from = Getfrom();
                d.to = Getto();
                d.supplier_bill_consignee_id=Get_supplier_bill_consignee_id();
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
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
        if( $(this).css("background-color")=='rgb(0, 141, 76)'){          
          $(this).css("background-color","red");
        }else{
          $(this).css("background-color","rgb(0, 141, 76)");
         }
        
        // Get the column API object
        var column = warehousetable.column( $(this).attr('data-column') ); 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
    function Get_supplier_bill_consignee_id(){
            return supplier_bill_consignee_id;
    }
    function Getfrom(){
            return $("#filter_warehouse #from").val();
    }
    function Getto(){
        return $("#filter_warehouse #to").val();
    }    
    $("#filter_warehouse").submit(function(e) { 
        e.preventDefault();     
        swal({
        title: "Date Fiter!",
        text: "Data filtered successful!",
        icon: "success",
        });
        warehousetable.ajax.reload();
    });
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
                        warehousetable.ajax.reload( null, false );     
                          swal({
                              title: "WareHouse!",
                              text: "WareHouse updated successful!!",
                              icon: "success",
                            });   
                            $("#editwarehouse").modal('hide'); 
                      });
                  });
                  $("#edit_warehouse_tab2").submit(function(e) {
                      event.preventDefault(); //prevent default action 
                      var post_url = $(this).attr("action"); //get form action url
                      var form_data = $(this).serialize(); //Encode form elements for submission
                      
                      $.post( post_url, form_data, function( response ) {  
                        warehousetable.ajax.reload( null, false );     
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
                      warehousetable.ajax.reload(null, false);
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
                      warehousetable.ajax.reload(null, false);
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
                      warehousetable.ajax.reload(null, false);
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
                      warehousetable.ajax.reload(null, false);
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

// edit quotation

    var quotationTable=$('#quotationTable').DataTable({
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
            targets: [7]
        }],
        'ajax': {
            'url': 'ajaxfile_account_quotation.php',
            "data" :function(d){
                d.from = Getfrom_quotation();
                d.to = Getto_quotation();
                d.client_id = Getto_client();
            }
        },              
        'columns': [{
                data: 'fecha'
            }, {
                data: 'id'
            }, {
                data: 'client_name'
            }, {
                data: 'origin'
            }, {
                data: 'destination'
            }, {
                data: 'service'
            }, {
                data: 'agent_name'
            },
            {
                data: 'shortcut'
            }]
    });
    function Getto_client(){
        return client_id;
    }
    function Getfrom_quotation(){
        return $("#filter_quotation #from").val();
    }

    function Getto_quotation(){
        return $("#filter_quotation #to").val();
    }
    function editquotation(id) {
        $.get('edit_quotation_account.php?id='+id,function(response){ 
                $('#editquotation .modal-dialog').html(response); 
                    $("#edit_quotation").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) { 
                            $("#editquotation").modal('hide');
                            quotationTable.ajax.reload( null, false );     
                            swal({
                                title: "Quotations!",
                                text: "Quotations Updated successful!!",
                                icon: "success",
                                });   
                        });
                    });
                    $("#by_boxes_content_acount .btn_plus").on("click", function(e){
                        e.preventDefault();
                        var html='<div class="item">';
                            html+='<div class="form-group row">';
                            html+='<div class="col-md-2 col-item">';
                            html+='<input type="text" name="byBoxes_qtyX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-2 col-item">';
                            html+='<input type="number" name="byBoxes_widthX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-2 col-item">';
                            html+='<input type="number"  name="byBoxes_lenghtX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-2 col-item">';
                            html+='<input type="number"  name="byBoxes_heightX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-2 col-item">';
                            html+='<input type="number"  name="byBoxes_weightX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-1 col-item">';
                            html+='<button  type="button" class="btn btn_minus">-</button>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        $("#by_boxes_content_acount").append(html);

                        $('#by_boxes_content_acount .btn_minus').on("click", function (e) {
                            e.preventDefault(); 
                            $(this).parent('div').parent('div').parent('div').remove(); 
                        })
                    });

                    $('#by_boxes_content_acount .btn_minus').on("click", function (e) {
                        e.preventDefault(); 
                        $(this).parent('div').parent('div').parent('div').remove(); 
                    })
                    $("#freight_charges .btn_plus").on("click", function(e){
                        e.preventDefault();
                        var html='<div class="item">';
                            html+='<input type="hidden" name="freightid[]" value="">';
                            html+='<div class="form-group row">';
                            html+='<div class="col-md-4 col-item">';
                            html+='<input type="text" name="freightDescX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" name="freightChargeX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" value="1" name="freightChargeQX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-1 col-item">';
                            html+='<button  type="button" class="btn btn_minus">-</button>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        $("#freight_charges").append(html);

                        $('#freight_charges .btn_minus').on("click", function (e) {
                            e.preventDefault(); 
                            $(this).parent('div').parent('div').parent('div').remove(); 
                        })
                    });

                    $('#freight_charges .btn_minus').on("click", function (e) {
                        e.preventDefault(); 
                        $(this).parent('div').parent('div').parent('div').remove(); 
                    })
                    $("#origin_charges .btn_plus").on("click", function(e){
                        e.preventDefault();
                        var html='<div class="item">';
                            html+='<input type="hidden" name="originid[]" value="">';
                            html+='<div class="form-group row">';
                            html+='<div class="col-md-4 col-item">';
                            html+='<input type="text" name="originDescX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" name="originChargeX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" value="1" name="originChargeQX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-1 col-item">';
                            html+='<button  type="button" class="btn btn_minus">-</button>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        $("#origin_charges").append(html);

                        $('#origin_charges .btn_minus').on("click", function (e) {
                            e.preventDefault(); 
                            $(this).parent('div').parent('div').parent('div').remove(); 
                        })
                    });
                    
                    $('#origin_charges .btn_minus').on("click", function (e) {
                        e.preventDefault(); 
                        $(this).parent('div').parent('div').parent('div').remove(); 
                    })
                    $("#destination_charges .btn_plus").on("click", function(e){
                        e.preventDefault();
                        var html='<div class="item">';
                            html+='<input type="hidden" name="destinationtid[]" value="">';
                            html+='<div class="form-group row">';
                            html+='<div class="col-md-4 col-item">';
                            html+='<input type="text" name="destinationDescX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" name="destinationChargeX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-3 col-item">';
                            html+='<input type="number" value="1" name="destinationChargeQX[]" class="form-control">';
                            html+='</div>';
                            html+='<div class="col-md-1 col-item">';
                            html+='<button  type="button" class="btn btn_minus">-</button>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                        $("#destination_charges").append(html);

                        $('#destination_charges .btn_minus').on("click", function (e) {
                            e.preventDefault(); 
                            $(this).parent('div').parent('div').parent('div').remove(); 
                        })
                    });
                    
                    $('#destination_charges .btn_minus').on("click", function (e) {
                        e.preventDefault(); 
                        $(this).parent('div').parent('div').parent('div').remove(); 
                    })
                    $("#delete_quotation").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) {                                
                            $("#editquotation").modal('hide');
                            quotationTable.ajax.reload( null, false );  
                            swal({
                                title: "Quotations Delete!",
                                text: "Quotations deleted successful!",
                                icon: "error",
                            });
                        });
                    });
            });                
        $("#editquotation").modal('show');
    }
    function editClientmodal(id) {
        $.get('edit_bill_warehouser.php?id='+id,function(response){ 
        $("#editclient .modal-dialog").html(response); 
        $("#edit_warehouse_bill").submit(function(e) {
                event.preventDefault(); //prevent default action 
                var post_url = $(this).attr("action"); //get form action url
                var form_data = $(this).serialize(); //Encode form elements for submission

                $.post(post_url, form_data, function(response) {
                    $("#editclient").modal('hide');
                    quotationTable.ajax.reload(null, false);
                    swal({
                        title: "Client!",
                        text: "Client Information Updated successful!",
                        icon: "success",
                    }); 
                });
            });
            });
            $("#editclient").modal('show');
    }
    function viewNotes(id) {
        $.get('createnote_quo.php?id='+id,function(response){ 
                $('#viewNotes .modal-dialog').html(response); 
                $("#create_quotation").submit(function(e) {
                    event.preventDefault(); //prevent default action 
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission
                    
                    $.post( post_url, form_data, function( response ) {
                        
                        $("#viewNotes").modal('hide');
                        quotationTable.ajax.reload( null, false ); 
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
    $("#filter_quotation").submit(function(e) { 
        e.preventDefault();     
        swal({
        title: "Date Fiter!",
        text: "Data filtered successful!",
        icon: "success",
        });
        quotationTable.ajax.reload();
    });
    // search Job order
        var joborderTable = $('#joborderTable').DataTable({
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
                targets: [8, 9, 10]
            }],
            'ajax': {
                'url': 'ajaxfile_account_cn.php',
                "data": function(d) {
                    d.from = Getfrom_joborder();
                    d.to = Getto_joborder();
                    d.supplier_client_id = Get_supplier_client_id();
                }
            },
            'columns': [{
                data: 'fecha'
            }, {
                data: 'id'
            }, {
                data: 'customer_name'
            }, {
                data: 'supplier_company'
            }, {
                data: 'service'
            }, {
                data: 'customer_city'
            }, {
                data: 'agent_name'
            }, {
                data: 'status'
            }, {
                data: 'tracking'
            }, {
                data: 'wr'
            }, {
                data: 'shortcut'
            }]
        });
    function Getfrom_joborder(){
        return $("#filter_joborder #from").val();
    }

    function Getto_joborder(){
        return $("#filter_joborder #to").val();
    }
    function Get_supplier_client_id(){
        return supplier_client_id;
    }
    $("#filter_joborder").submit(function(e) { 
        e.preventDefault();     
        swal({
        title: "Date Fiter!",
        text: "Data filtered successful!",
        icon: "success",
        });
        joborderTable.ajax.reload();
    });
    function editJobOrder(id) {
        $.get('editorder.php?id=' + id, function(response) {
            $('#editJobOrder .modal-dialog').html(response);
            $("#edit_order").submit(function(e) {
                event.preventDefault(); //prevent default action 
                var post_url = $(this).attr("action"); //get form action url
                var form_data = $(this).serialize(); //Encode form elements for submission

                $.post(post_url, form_data, function(response) {
                    $("#editJobOrder").modal('hide');
                    joborderTable.ajax.reload(null, false);
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
                    joborderTable.ajax.reload(null, false);
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
                        joborderTable.ajax.reload(null, false);
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
                        joborderTable.ajax.reload(null, false);
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
                        joborderTable.ajax.reload(null, false);
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
                        joborderTable.ajax.reload(null, false);

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
                    joborderTable.ajax.reload(null, false);
                })
        }
    $(document).ready(function () {
      $("#state").select2({
        tags: true
      });

      $("#btn-add-state").on("click", function () {
        var newStateVal = $("#new-state").val();
        // Set the value, creating a new option if necessary
        if ($("#state").find("option[value='" + newStateVal + "']").length) {
          $("#state").val(newStateVal).trigger("change");
        } else {
          // Create the DOM option that is pre-selected by default
          var newState = new Option(newStateVal, newStateVal, true, true);
          // Append it to the select
          $("#state").append(newState).trigger('change');
        }
      });
    });


    $(document).ready(function () {
      $("#state2").select2({
        tags: true
      });

      $("#btn-add-state2").on("click", function () {
        var newState2Val = $("#new-state2").val();
        // Set the value, creating a new option if necessary
        if ($("#state2").find("option[value='" + newState2Val + "']").length) {
          $("#state2").val(newState2Val).trigger("change");
        } else {
          // Create the DOM option that is pre-selected by default
          var newState2 = new Option(newState2Val, newState2Val, true, true);
          // Append it to the select
          $("#state2").append(newState2).trigger('change');
        }
      });
    });

    $(document).ready(function () {
      $("#state3").select2({
        tags: true
      });

      $("#btn-add-state3").on("click", function () {
        var newState3Val = $("#new-state3").val();
        // Set the value, creating a new option if necessary
        if ($("#state3").find("option[value='" + newState3Val + "']").length) {
          $("#state3").val(newState3Val).trigger("change");
        } else {
          // Create the DOM option that is pre-selected by default
          var newState3 = new Option(newState3Val, newState3Val, true, true);
          // Append it to the select
          $("#state3").append(newState3).trigger('change');
        }
      });
    });  
    </script>
</body>

</html>