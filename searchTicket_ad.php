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
<head >
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Latim Cargo & Trading | Search Administration Tickets</title>
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
    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/select2/select2.js"></script>  
    <script src="plugins/moment.min.js"></script>  
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>  
    <script src="assets/js/app.min.js"></script>
   
    <script>
    window.addEventListener("load", function(){
      var load_screen = document.getElementById("load_screen");
      document.body.removeChild(load_screen);
    });
</script>
<style>
   #notetable th, #notetable td {
        height: auto;
    }
</style>
</head>

<body class="hold-transition sidebar-mini">
  <div id="load_screen"><div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div></div>
  <div class="wrapper" style="height:auto">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <div class="content-wrapper">
      <section class="content-header">
          <h1>
            Tickets 
            <small>Search</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Search Administration  Tickets</li>
          </ol>
      </section>
      <section class="content">
          <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
            <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                <div class="col-md-12">                  
                    <div class="col-md-offset-3 col-md-5 text-center">
                      <div class="form-group">
                        <h3 class="text-center" style="font-weight:bold">SEARCH Administration TICKETS</h3>
                      </div>                    
                    </div>
                    <div class="col-md-4 text-center" style="margin-bottom:10px;">
                        <p class="text-center">Change Status</p>
                        <form class="form-inline">
                          <div class="form-group">
                              <select name="statusUpdate" id="statusUpdate" class="form-control select2" style="width:150px; font-size:13px;">
                                  <option value="PENDING">Pending</option>
                                  <option value="READY TO CONTACT">Ready to contact</option>
                                  <option value="IN PROCESS">In process</option>
                                  <option value="SHIPPED">Shipped</option>
                                  <option value="IN WAREHOUSE">In Warehouse</option>
                                  <option value="CANCELED">Canceled</option>
                              </select>
                          </div>
                          <button type="button" id="statusUpdate_btn" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-8 text-center">
                    <div class="form-group" style="background: #B80008;  padding-top: 10px; padding-bottom: 10px;">
                        <button class="btn pending_ticket"><i class="fa fa-eye"></i>&nbsp;View Pending Tickets Only</button>
                        <button class="btn all_ticket"><i class="fa fa-eye"></i>&nbsp;View All Tickets</button>
                        <button class="btn all_ticket btn_notes"><i class="fa fa-bell-o"></i>&nbsp;Notes</button>
                        <button class="btn  download_excel">
                            <i class="fa fa-file"></i>&nbsp;Download EXCEL</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:20px;">
              <form action="#" id="filter">
                  <div class="col-md-2">                        
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                          <input type="text" class="form-control" data-provide="datepicker" id="from"
                                data-date-format="yyyy-mm-dd" laceholder="To" value=""   autocomplete="off"  placeholder="From">
                      </div>                          
                  </div>
                  <div class="col-md-2">                        
                      <div class=" input-group">
                          <input t type="text" class="form-control" data-provide="datepicker" id="to"
                            data-date-format="yyyy-mm-dd" laceholder="To" value=""   autocomplete="off"  placeholder="To">
                      </div>                    
                  </div>
                  <div class="col-md-2">
                      <div class="form-group row">                            
                          <button  type="submit" class="btn btn-success "><i class="fa fa-search"></i>&nbsp;Filter</button>                                
                      </div>
                  </div>
              </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                      <table id='empTable' style="width:100%;" class='display dataTable'>
                          <thead>
                              <tr>
                                  <th class="text-center">Date</th>
                                  <th class="text-center">Tickets#</th>
                                  <th class="text-center">Client</th>
                                  <th class="text-center" style="width:200px;">Supplier</th>
                                  <th class="text-center">Type</th>
                                  <th class="text-center">Service</th>
                                  <th class="text-center">Agent</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Shortcut</th>
                                  <th class="text-center">Action</th>
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
  <div id="noteModal" class="modal fade" role="dialog">
      <div class="modal-dialog" style="width:800px">
        <!-- Modal content-->
        <div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>               
                 <h4 class="modal-title"><i class="fa fa-bell"></i> &nbsp;Administration  Tickets Notes</h4>                        
            </div>        
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="notetable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ticket ID</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">By</th>
                                        <th class="text-center">Note</th>
                                        <th class="text-center">File</th>
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
    <div id="editticket" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
          <style>
          .title_span{
              font-size:12px; 
              color:red; 
              font-weight:600;
          }
          .icon {
              font-size: 57px !important;
              color: black !important;
          }
          </style>
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <div class="row">
                      <div class="col-md-4">
                          <h4 class="modal-title"><strong>Inquiry</strong> Ticket # <span id="ticket_num"></span>
                          <form method="POST" id="delete_ticket" action="./action/curd_ad_ticket.php" style="display: contents;"> 
                          <input  type="hidden" name="jobId" value="">
                          <input  type="hidden" name="order_ticket" value="delete">
                          <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
                          </form>
                          </h4>   
                      </div>
                      <div class="col-md-4 text-center" id="title">
                          <h4 class="modal-title"><strong>Inquiry</strong> Missing Cargos <br><span class="title_span">[Find Warehouse Receipt Number]</span></h4>
                      </div>
                      <div class="col-md-3" style="text-align: center;background: #B80008;padding: 5px;color: #fff;">
                          <div class="checkbox_content">
                              <label for="">Change Ticket</label><br>
                              <div class="">
                                  <label class="radio-inline"><input type="radio" name="ticket_status" value="1">Missing Cargo</label>
                                  <label class="radio-inline"><input type="radio" name="ticket_status" value="2">Warehouse Inquiry</label>                
                              </div>           
                          </div>
                      </div>
                  </div>
              </div>
                  <div class="modal-body">
                      <div class="row" style="margin:30px">
                          <div class="col-md-4">
                              <div class="form-group row text-center">
                                  <div class="col-md-12">
                                      <i class="fa fa-paperclip icon"></i>
                                      <h4 class="title change_tracking_text">Tracking</h4>
                                  </div>
                              </div>  
                              <div  id="tracking_photo" >
                                  <input  type="hidden" name="jobId" value="">
                                  <input  type="hidden" name="tracking_photo" value="edit">              
                                  <div class="form-group row" id="tracking_number">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-barcode input-fa"></i></div>
                                              <input type="text" name="tracking_number"  class="form-control" value=""  placeholder="Tracking Number">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <label>Change File/Photo ↓</label>
                                              <input type="file" class="form-control" name="tracking_img" style="padding-right: 30px;">
                                              <i class="fa fa-file-image-o" style="position: absolute;right: 10px;top: 36px;z-index: 1000;"></i>                               
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <button type="button" class="btn btn-success btn-block">Save</button>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12 img-wrapper">
                                          <img src="" id="photo_img" alt="" class="img-responsive" style="padding: 30px;" >                                
                                          <div class="overlay" data-toggle="modal" data-target="#imgModal">
                                            <div class="text"><span style="font-size:18px;">Click to Full Size</div>
                                          </div>
                                        </div>
                                  </div>   
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group row text-center">
                                  <div class="col-md-offset-3 col-md-6" style="text-align: center;background: #B80008;padding: 5px;color: #fff;">
                                      <label for="">Inquiry solved?</label><br>
                                      <div class="">
                                          <label class="radio-inline"><input type="radio" name="inquiry_status" value="1">No</label>
                                          <label class="radio-inline"><input type="radio" name="inquiry_status" value="2">Yes</label>                
                                      </div> 
                                  </div>
                                  <dvi class="col-md-12">
                                      <h4 class="title">Inquiry Information</h4>
                                  </dvi>
                              </div>
                              <form action="./action/curd_ad_ticket.php" id="inquiry_informtion" method="post" >
                                  <input  type="hidden" name="jobId" value="">
                                  <input  type="hidden" name="inquiry_informtion" value="edit">
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                              <input type="text" class="form-control" name="client"  value="" placeholder="Client">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                              <input type="text" name="job_order" class="form-control" value="" placeholder="Job Order">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                                              <select name="service" id="" class="form-control select2" style="width:100%">
                                                  
                                              </select>                   
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                              <textarea name="notes" id="" cols="30" rows="4" class="form-control"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                                              <input type="text" name="warehouse_receipt" class="form-control" value="" placeholder="Warehouse ">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <button  type="submit" class="btn btn-success btn-block">Save</button>
                                      </div>
                                  </div>
                                  <div class="form-group row" style="text-align: center;">
                                      <div class="col-md-12">
                                          <h4 class="title">Supplier Information</h4>
                                      </div>
                                  </div>                    
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                              <input type="text" name="supplier" class="form-control" value="" disabled placeholder="Contact Person">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i></div>
                                              <input type="text" name="supplier_phone" class="form-control" value="" placeholder="Telephone">                           
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                              <textarea name="supplier_address" id="" cols="30" rows="4" class="form-control"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group row text-center">
                                  <div class="col-md-12">
                                      <i class="fa fa-comment icon"></i>
                                      <h4 class="title">Service Data</h4>
                                  </div>
                              </div>
                              <div id="notes_content" >
                              <div class="form-group row">
                                  <div class="col-md-12">
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                          <select  placeholder="Select Agent"  name="agent_name" class="form-control select2"  style="width:100%;">
                                                  
                                          </select>       
                                      </div>
                                  </div>
                              </div>  
                              
                                  <input  type="hidden" name="jobId" value="">
                                  <input  type="hidden" name="create_note" value="edit">
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <label>File/Photo ↓</label>
                                              <input type="file" class="form-control" name="image" style="padding-right: 30px;">
                                              <i class="fa fa-file-image-o" style="position: absolute;right: 10px;top: 36px;z-index: 1000;"></i>                               
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <div class=" input-group">
                                              <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                              <textarea name="notess" id="notess" cols="30" rows="4" class="form-control"></textarea>
                                          </div>
                                      </div>
                                  </div> 
                                  <div class="form-group row">
                                      <div class="col-md-12">
                                          <button type="button" class="btn btn-success btn-block">Save</button>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-md-12">
                                      <p>Notes History ↓</p>
                                  </div>
                                  <div class="col-md-12" style="max-height: 350px;overflow-y: auto;">
                                      <table class="table" width="100%" id="note_list">
                                          <thead>
                                              <tr>
                                                  <th class="text-center"></th>
                                                  <th class="text-center">Date</th>
                                                  <th class="text-center">By</th>
                                                  <th class="text-center">Note</th>
                                                  <th class="text-center">File</th>
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
              </form>
          </div>
        </div>
    </div>  
    <div id="imgModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">          
          <div class="modal-body">
            <img src="" id="modal_img" alt="" class="img-responsive">
          </div>        
        </div>
      </div>
    </div>
    <script> 
    $(".sidebar-menu li a").removeClass('active');
    $(".treeview").removeClass('active');
    $("#ad_tickets_list").addClass("active");
    $("#ad_tickets_list #search").addClass("active"); 

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      }); 
      var table2=$('#notetable').DataTable({
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
            'ajax': {
                'url': 'ajax/ajaxfile_ticket_ad_note.php',                   
            },
            'columns': [{
                data: 'ticket_id'
            }, {
                data: 'fecha'
            }, {
                data: 'agent_name'
            }, {
                data: 'note'
            }, {
                data: 'imagen'
            }]
        });
      $('.btn_notes').on("click", function(e){
            table2.ajax.reload( null, false );     
            $("#noteModal").modal("show");
      })
        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }      
            var from='', to='', jobCheckval, type="PENDING";
            $('.select2').select2();
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
                    targets: [8,9]
                }],
                'ajax': {
                    'url': 'ajax/ajaxfile_ticket_ad.php',
                    "data" :function(d){
                        d.from = Getfrom();
                        d.to = Getto();
                        d.jobCheckval = GetjobCheck();            
                        d.type = Gettype();           
                    }
                },
                'columns': [{
                    data: 'fecha'
                }, {
                    data: 'id'
                }, {
                    data: 'name'
                }, {
                    data: 'supplier'
                }, {
                    data: 'type'
                }, {
                    data: 'service'
                }, {
                    data: 'agent_name'
                }, {
                    data: 'status'
                },                      
                 {
                    data: 'shortcut'
                }, {
                    data: 'action'
                }, ]
            });
        function Gettype(){
          return type;
        }
        $(".pending_ticket").on("click", function(e){
          type="PENDING"
          table.ajax.reload( null, false );     
        });
        $(".all_ticket").on("click", function(e){
          type="All"
          table.ajax.reload( null, false );     
        });
        $("input[name='ticket_status']").on("change", function(e){
          if(e.target.value==1){
            $.post("./action/curd_ad_ticket.php",
            {
              id:$("input[name='jobId']").val(),
              ticket_status:'ticket_status',
              type:"missing",
            },
            function(data, status){  
                table.ajax.reload( null, false );  
                swal({
                    title: "Ticket!",
                    text: "Ticket updated successful!",
                    icon: "success",
                });       
            });    
            var title='<h4 class="modal-title"><strong>Inquiry:</strong> Missing Cargos <br><span class="title_span">[Find Warehouse Receipt Number]</span></h4>';
            $("#tracking_number").css("display","block");
            $(".change_tracking_text").text("Tracking");
          }else if(e.target.value==2){
            var title='<h4 class="modal-title"><strong>Inquiry:</strong> Warehouse Receipt Inquiry <br><span class="title_span">[Resolve the problem using notes in the right area]</span></h4>';
            $("#tracking_number").css("display","none");
            $(".change_tracking_text").text("Photos");
            $.post("./action/curd_ad_ticket.php",
            {
              id:$("input[name='jobId']").val(),
              ticket_status:'ticket_status',
              type:"warehouse",
            },
            function(data, status){  
                table.ajax.reload( null, false );  
                swal({
                    title: "Ticket!",
                    text: "Ticket updated successful!",
                    icon: "success",
                });       
            });    
          };
          $("#title").html(title);
        });
        $("input[name='inquiry_status']").on("change", function(e){
          if(e.target.value==2){
            $.post("./action/curd_ad_ticket.php",
            {
              id:$("input[name='jobId']").val(),
              inquiry_save:'inquiry_save',
              status:"SOLVED",
            },
            function(data, status){  
              $("#editticket").modal('hide');
                table.ajax.reload( null, false );  
                swal({
                    title: "Ticket!",
                    text: "Ticket updated successful!",
                    icon: "success",
                });       
            });    
          }else if(e.target.value==1){
            $.post("./action/curd_ad_ticket.php",
            {
              id:$("input[name='jobId']").val(),
              inquiry_save:'inquiry_save',
              status:"PENDING",
            },
            function(data, status){  
              $("#editticket").modal('hide');
                table.ajax.reload( null, false );  
                swal({
                    title: "Ticket!",
                    text: "Ticket updated successful!",
                    icon: "success",
                });       
            }); 
          }
        });
        function editticket(id) {
          $.get('./action/curd_ad_ticket.php?ticket='+id,function(response){
            var rep=JSON.parse(response);
            $("input[name='jobId']").val(rep.ticket.jobId);
            $("#ticket_num").text(rep.ticket.jobId);
            $("input[name='tracking_number']").val(rep.ticket.tracking_number);
            $("input[name='tracking_img']").val('');
            $("input[name='image']").val('');
            $("textarea[name='notess']").val('');
            if(rep.ticket.imagen1){
              $("#photo_img").attr("src",rep.ticket.imagen1.split("../")[1]);
              $("#modal_img").attr("src",rep.ticket.imagen1.split("../")[1]);
            }else{
              $("#photo_img").attr("src",'');
            }
            $("input[name='ticket_status']").prop('checked',false);
            if(rep.ticket.type=='missing'){              
              $("input[name=ticket_status][value=1]").prop('checked', true);
              $("input[name=ticket_status][value=2]").prop('checked', false);
              var title='<h4 class="modal-title"><strong>Inquiry:</strong> Missing Cargos <br><span class="title_span">[Find Warehouse Receipt Number]</span></h4>';
              $("#tracking_number").css("display","block");
              $(".change_tracking_text").text("Tracking");
            }else{
              $("input[name=ticket_status][value=1]").prop('checked', false);
              $("input[name=ticket_status][value=2]").prop('checked', true);
              var title='<h4 class="modal-title"><strong>Inquiry:</strong> Warehouse Receipt Inquiry <br><span class="title_span">[Resolve the problem using notes in the right area]</span></h4>';
              $("#tracking_number").css("display","none");
              $(".change_tracking_text").text("Photos");
            }
            $("#title").html(title);
            $("input[name='inquiry_status']").prop('checked',false);
            if(rep.ticket.status=="PENDING"){              
              $("input[name=inquiry_status][value=1]").prop('checked', true);
              $("input[name=inquiry_status][value=2]").prop('checked', false);              
            }else if(rep.ticket.status=="SOLVED"){
              $("input[name=inquiry_status][value=1]").prop('checked', false);
              $("input[name=inquiry_status][value=2]").prop('checked', true);
            }
           
            $("input[name='client']").val(rep.ticket.client);
            $("input[name='job_order']").val(rep.ticket.job_order);
            $("select[name='service']").html(rep.service_select);
            $("textarea[name='notes']").val(rep.ticket.notes);
            $("textarea[name='notes']").text(rep.ticket.notes);
            $("input[name='warehouse_receipt']").val(rep.ticket.warehouse_receipt);
            $("input[name='supplier']").val(rep.ticket.supplier);
            $("input[name='supplier_phone']").val(rep.ticket.supplier_phone);            
            $("select[name='agent_name']").html(rep.agent_select);
            $("textarea[name='supplier_address']").val(rep.ticket.supplier_address);
            $("textarea[name='supplier_address']").text(rep.ticket.supplier_address);
            $("#note_list tbody").html(rep.tbody);
          });         
                         
            $("#editticket").modal('show');
            
        }
        $("#delete_ticket").submit(function(e) {
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var form_data = $(this).serialize(); //Encode form elements for submission                            
            $.post( post_url, form_data, function( response ) {                                
                $("#editticket").modal('hide');
                table.ajax.reload( null, false );  
                swal({
                    title: "Ticket!",
                    text: "Ticket deleted successful!",
                    icon: "error",
                });
            });
        });
        $("#tracking_photo .btn").on('click', function() {
         
         var fd = new FormData();
         fd.append( 'tracking_img', $("input[name='tracking_img']").prop('files')[0]);
         fd.append( 'jobId', $("input[name='jobId']").val());
         fd.append( 'tracking_photo', 'edit');
         fd.append( 'tracking_number', $("input[name='tracking_number']").val());
         $.ajax({
           url: './action/curd_ad_ticket.php',
           data: fd,
           processData: false,
           cache: false,
           contentType: false,
           type: 'POST',
           success: function(data){
            if(data!=''){
              $("#photo_img").attr("src",data.split("../")[1]);
              $("#modal_img").attr("src",data.split("../")[1]);
              $("input[name='tracking_img']").val('');
              
            }    
            // $("#photo_img").load(location.href,"");  
            // $("#photo_img").loading();      
           }
         });
       
     });
     $("#notes_content .btn").on('click', function() {
         var fd = new FormData();
         fd.append( 'image', $("input[name='image']").prop('files')[0]);
         fd.append( 'jobId', $("input[name='jobId']").val());
         fd.append( 'create_note', 'edit');
         fd.append( 'notess', $("textarea[name='notess']").val());
         fd.append( 'agent_name', $("select[name='agent_name']").val());
         $.ajax({
           url: './action/curd_ad_ticket.php',
           data: fd,
           processData: false,
           cache: false,
           contentType: false,
           type: 'POST',
           success: function(data){
              var rep=JSON.parse(data);
              if(rep.imagen){
                    var file="<td><a href='images/Tickets/notes/"+rep.imagen.split("/")[4]+"' style='color:#3c8dbc;font-weight: 100;' target='blank'>"+rep.imagen.split("/")[4]+"</a></td>" ;
                }else{
                   var file="<td></td>";
              }
              var html="";
               html+="<tr id='tr_"+rep.id+"' class='text-center'>"; 
               html+="<td><a href='#' onclick='note_delete("+rep.id+")' ><i class='fa fa-close' style='background: red; padding: 3px 4px;border-radius: 50%;'></i></a></td>";  
               html+="<td>"+rep.fecha+"</td>";  
               html+="<td>"+rep.agent_name+"</td>";  
               html+="<td>"+rep.notes+"</td>";  
               html+=file; 
               html+="</tr>";
               $("#note_list tbody").prepend(html);
               $("input[name='image']").val('');
               $("textarea[name='notess']").val('');
           }
         });
       
     });
     $("#inquiry_informtion").submit(function(e) {
          event.preventDefault(); //prevent default action 
          var post_url = $(this).attr("action"); //get form action url
          var form_data = $(this).serialize(); //Encode form elements for submission
          $.post( post_url, form_data, function( response ) {                                
              table.ajax.reload( null, false );     
              swal({
                  title: "Ticket!",
                  text: "Ticket Updated successful!!",
                  icon: "success",
                });   
          });
      });
      function note_delete(id){
        $.post("./action/curd_ad_ticket.php",
            {
              id:id,
              note_delete:'delete'
            },
            function(data, status){  
              $("#tr_"+id).remove();             
            });        
      } 
        function Getfrom(){
            from=$("#from").val();
            return $("#from").val();
        }
        function Getto(){
            to=$("#from").val();
            return $("#to").val();
        }
        function GetjobCheck(){
            return jobCheckval;
        }
        $("#filter").submit(function(e) {      
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
                url: "./action/curd_ad_ticket.php",
                data: {
                    jobCheck:jobCheck,
                    ticket_Update:'ticket_Update',
                    statusUpdate: $("#statusUpdate").val()
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
         // excel download
         $(".download_excel").on("click", function(e){
            window.open("./excel/excel_ticket_ad.php?from="+from+"&to="+to+"&type="+type);
        })
    </script>
</body>

</html>