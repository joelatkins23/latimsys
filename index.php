<?php 
error_reporting(0);
require_once('conn.php');
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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
    <title>Latim Cargo & Trading | System</title>
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
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/imageuploadify.min.js"></script>
    <script src="plugins/select2/select2.js"></script>    
    <script src="plugins/moment.min.js"></script>    
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="dist/js/app.min.js"></script>   
 

</head>
<style type="text/css"> 
      /* The Modal (background) */
      .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 99999;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
      }
      .modal2 {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 99999;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
      }
      /* Modal Content/Box */
      .modal-content {
        background-color: #fefefe;
        margin: 3% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        /* width: 80%; */
        /* Could be more or less, depending on screen size */
      }
      /* Modal Content/Box */
      .modal-content2 {
        background-color: #fefefe;
        margin: 3% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
      }

      
      /* The Close Button */
      .close {
        float: right;
      }

      .close:hover,
      .close:focus {
        text-decoration: none;
        cursor: pointer;
      }

</style>
<script>
    window.addEventListener("load", function(){
      var load_screen = document.getElementById("load_screen");
      document.body.removeChild(load_screen);
    });
</script>
<body class="hold-transition sidebar-mini">
  <div id="load_screen">
        <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
    </div>
  <div class="wrapper">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>
      <section class="content">
        <div class="searchPage shadow2" style="background:white; width:100%; margin-left:-50%;">

          <div class="row">
            <div class="col-md-12 text-center">
                <h3 style="color: #000; font-weight:800;text-decoration:underline;font-size:20px;margin-bottom:20px;"><span style="color: #B80008;">LATIM </span> Work Tools</h3>
            </div>
          </div>     
          <div class="row">
            <div class="col-md-12 text-center">
            <div class="text-center" style="display:inline-block;">
              <a id="myBtn">
                <div class="img-wrapper input-group img-magnifier-container"
                  style=" margin-top:20px; cursor:pointer; z-index:1; ">
                  <p style="color:black; font-weight:600;">Ocean  Rates</p>
                  <img id="myimage" style="height:150px;" src="images/tarifario.jpeg">
                  <div class="overlay" data-toggle="modal" data-target="#myModal">
                    <div class="text"><span style="font-size:14px;">Click to Full Size</div>
                  </div>
                </div>
              </a>
              <div id="myModal" class="modal">
                <div class="modal-content input-group img-magnifier-container" style="margin-top:20px; width:700px;">
                  <span class="close" data-dismiss="modal" aria-label="Close"
                    style="font-size:20px; opacity:1; position:relative; top:-15px; font-weight:bolder;">&times;</span>
                  <img id="myimage" style="width:700px;" src="images/tarifario.jpeg">
                </div>
              </div>
            </div>
            <div class="text-center" style="display:inline-block;">
              <a id="myBtn2">
                <div class="img-wrapper input-group img-magnifier-container"
                  style="margin-top:20px; cursor:pointer; z-index:1; ">
                  <p
                    style="color:black; font-weight:600; ">Services
                    Rates</p>
                  <img id="myimage2" style="height:150px;" src="images/servicios.jpg">
                  <div class="overlay" data-toggle="modal" data-target="#myModal2">
                    <div class="text"><span style="font-size:14px;">Click to Full Size</div>
                  </div>
                </div>
              </a>
              <div id="myModal2" class="modal2">
                <div class="modal-content2 input-group img-magnifier-container" style="margin-top:20px; width:700px;">
                  <span class="close" data-dismiss="modal" aria-label="Close"
                    style="font-size:20px; position:relative; top:-15px; font-weight:bolder">&times;</span>
                  <img id="myimage2" style="width:700px;" src="images/servicios.jpg">
                </div>
              </div>
            </div>
            <div class="text-center" style="display:inline-block;">
              <a href='download.php?file=brochure.pdf'>
                <div class="img-wrapper input-group img-magnifier-container"
                  style=" margin-top:20px; cursor:pointer; z-index:1; ">
                  <p
                    style="color:black; font-weight:600;">Download
                    Brochure</p>
                  <img id="myimage3" style="height:150px;" src="images/brochure.jpg">
                  <div class="overlay">
                    <div class="text"><span style="font-size:14px;">Click to Download</div>
                  </div>
                </div>
              </a>             
            </div> 
            </div>
          </div> 
            <div class="row" style="border-bottom: 1px solid #000; margin: 40px 0px;">
                <div class="col-md-12">                 
                    <div class="col-md-offset-2 col-md-6 text-center">
                        <h3 class="text-center" style="font-weight:bold">READY TO CONTACT <span style="font-weight:200">JOB ORDERS</span></h3>
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
                <div class="col-md-6">
                  <div class="form-group text-right">                            
                      <button type="button" class="btn btn-danger download_excel">
                      <i class="fa fa-file"></i>&nbsp;Download EXCEL</button>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id='empTable' style="width:100%;" class='display dataTable'>
                        <thead>
                            <tr>
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
                                <th>Attached</th>
                                <th>Shortcut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>       
        
      </section>
    </div>

  </div>

  <div id="editJobOrder" class="modal fade" role="dialog">
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
    <div id="file_update" class="modal fade" role="dialog">
        <div class="modal-dialog ">       
        </div>
    </div>
<script> 
      $(".sidebar-menu li a").removeClass('active');
      $(".treeview").removeClass('active');
      $("#dashbord_list a").addClass("active");
      $('input[type="file"]').imageuploadify();

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      }); 
        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }      
            var from='', to='', jobCheckval;
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
                    targets: [8, 9, 10,11,12]
                }],
                'ajax': {
                    'url': 'ajaxfile_index.php',
                    "data" :function(d){
                        d.from = Getfrom();
                        d.to = Getto();
                        d.jobCheckval = GetjobCheck();                      
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
            },{
                data: 'atteched'
            }, {
                data: 'shortcut'
            }, {
                data: 'action'
            }, ]
        });
        function editattached(id){
            $.get('edit_joborder_file.php?id=' + id, function(response) {
                $('#file_update .modal-dialog').html(response);
                $("#addfile").submit(function(e) {
                    event.preventDefault(); //prevent default action 
                    var post_url = $(this).attr("action"); //get form action url
                    var fd = new FormData();
                    var totalfiles = document.getElementById('image_file').files.length;
                    for (var index = 0; index < totalfiles; index++) {
                        fd.append("image_file[]", document.getElementById('image_file').files[index]);
                    }
                    fd.append( 'joborder_fileupload_id', $("input[name='joborder_fileupload_id']").val());
                    fd.append( 'joborder_fileupload', 'add');
                    fd.append( 'agent_name', $("input[name='agent_name']").val());
                    $.ajax({
                    url: './curd.php',
                    data: fd,
                    processData: false,
                    cache: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){
                        $("#file_body").html(data);  
                        table.ajax.reload(null, false);
                        $("#file_update").modal('hide');         
                        swal({
                            title: "File!",
                            text: "New Files Uploaded successful!!",
                            icon: "success",
                        });      
                    }
                    });
                });
            });
            $("#file_update").modal('show');
        }
        function orders_files_delete(joborders_id,id){
            $.ajax({
                method: 'GET',
                url: "./curd.php",
                data: {
                    orders_files_delete:'delete',
                    id:id,
                    joborders_id:joborders_id,
                    }
                })
                .done(function (response) {
                    swal({
                        title: "File!",
                        text: "Files Deleted successful!!",
                        icon: "error",
                    });  
                    $("#file_update #tr_orders_files_"+id).remove(); 
                    table.ajax.reload( null, false );  
                })            
        }
        function editJobOrder(id) {
            $.get('editorder.php?id='+id,function(response){ 
                    $('#editJobOrder .modal-dialog').html(response); 
                        $("#edit_order").submit(function(e) {
                            event.preventDefault(); //prevent default action 
                            var post_url = $(this).attr("action"); //get form action url
                            var form_data = $(this).serialize(); //Encode form elements for submission
                            
                            $.post( post_url, form_data, function( response ) {                                
                                $("#editJobOrder").modal('hide');
                                table.ajax.reload( null, false );     
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
                            
                            $.post( post_url, form_data, function( response ) {                                
                                $("#editJobOrder").modal('hide');
                                table.ajax.reload( null, false );  
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
        function Getfrom(){
            from=$("#from").val();
            return $("#from").val();
        }
        function Getto(){
            to=$("#to").val();
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
        function viewNotes(id) {
            $.get('createnote.php?id='+id,function(response){ 
                    $('#viewNotes .modal-dialog').html(response); 
                    $("#create_order").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) {
                           
                            $("#viewNotes").modal('hide');
                            table.ajax.reload( null, false ); 
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
            $.get('addwr2.php?id='+id,function(response){ 
                    $('#addwr .modal-dialog').html(response); 
                    $("#add_wr").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) {
                           
                            $("#addwr").modal('hide');
                            table.ajax.reload( null, false ); 
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
                            
                            $.post( post_url, form_data, function( response ) {                                
                                $("#addwr").modal('hide');
                                table.ajax.reload( null, false );  
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
        function addtracking(id){
            $.get('addtracking.php?id='+id,function(response){ 
                    $('#addtracking .modal-dialog').html(response); 
                    $("#add_tracking").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) {                           
                            $("#addtracking").modal('hide');
                            swal({
                                title: "New Tracking!",
                                text: "New Tracking created successful!",
                                icon: "success",
                                });
                            table.ajax.reload( null, false ); 
                            
                        });
                    });
                       
                });
            $("#addtracking").modal('show');
        }
        function tracking_delete(id){
            $.ajax({
                method: 'GET',
                url: "./curd.php",
                data: {
                    delete_tracking:id,
                    }
                })
                .done(function (response) {
                    swal({
                        title: "Tracking!",
                        text: "Tracking deleted successful!",
                        icon: "success",
                    }); 
                    $("#addtracking .tr_"+id).remove(); 
                    table.ajax.reload( null, false );  
                })
        } 
       $("#statusUpdate_btn").on("click", function(e){      
            var  jobCheck=[];
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function (e,ele) {
                jobCheck.push(ele.value);
            })
            jobCheckval = Object.assign({}, jobCheck);
            if(jobCheck.length>0){
                $.ajax({
                method: 'POST',
                url: "./curd.php",
                data: {
                    jobCheck:jobCheck,
                    status_Update:'statusUpdate',
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
       $(".download_excel").on("click", function(e){
            window.open("./excel/excel_job_index.php?from="+from+"&to="+to);
        })
    </script>






  


  <script type="text/javascript">
    $('#example1 tbody').on('click', document.getElementById('modal'), function () {
      var modalBtns = [...document.querySelectorAll(".button")];
      modalBtns.forEach(function (btn) {
        btn.onclick = function () {
          var modal = btn.getAttribute('data-modal');
          document.getElementById(modal).style.display = "block";
        }
      });

      var closeBtns = [...document.querySelectorAll(".close")];
      closeBtns.forEach(function (btn) {
        btn.onclick = function () {
          var modal = btn.closest('.modal');
          modal.style.display = "none";
        }
      });

      window.onclick = function (event) {
        if (event.target.className === "modal") {
          event.target.style.display = "none";
        }
      }
    });
  </script>
</body>
</html>