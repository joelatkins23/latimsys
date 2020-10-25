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
     $post = array();
     $consulta = mysqli_query($connect, "SELECT * FROM gl_account order by id ")
     or die ("Error al traer los Agent");
     while ($rowgl = mysqli_fetch_array($consulta)){
         $post[] = $rowgl;      
     }
?>
<!doctype html>
<html style="height: auto;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Latim Cargo & Trading | Search Payments</title>
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
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/imageuploadify.min.js"></script>
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
        table.dataTable,
        table.dataTable th,
        table.dataTable td {
            height: auto;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div id="load_screen">
        <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
    </div>
    <div class="wrapper" style="height:auto">
        <?php include 'layout/header.php' ?>
        <?php include 'layout/sidebar.php' ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Payments
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Payments Received</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <h3 style="font-weight:800" class="text-center">Search Payments</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='empTable' width="100%" class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">Branch</th>
                                            <th class="text-center">Number</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Accounts</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Amount</th>
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
    <div id="viewinvoicePayment" class="modal fade" role="dialog" style="overflow: auto;">
        <div class="modal-dialog">
        </div>
    </div>
    <div id="filelistModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Files</h4>
                </div>
                <div class="modal-body" style="margin:20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class='display dataTable' style="width:100%">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Date</th>
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
    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#invoice_menu").addClass("active");
        $("#invoice_menu .sub_search_create").addClass("active");
        $("#invoice_menu #search_invoice_payments").addClass("active");
        $('input[type="file"]').imageuploadify();

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }
        var from = '',
            to = '';
        $('.select2').select2();
        var table = $('#empTable').DataTable({
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
                targets: [6]
            }],
            'ajax': {
                'url': 'ajax/ajaxfile_invoicepayment.php'
            },
            'columns': [{
                data: 'branch_name'
            },{
                data: 'id'
            },{
                data: 'date'
            },{
                data: 'account_name'
            },{
                data: 'type_name'
            },{
                data: 'amount'
            },{
                data: 'action'
            }]
        });
        function deleteinvoicePayment(id){
            $.ajax({
                url: './curd_invoicepayment.php',
                data: {
                    'deletepayment':'delete',
                    'id':id
                },
                type: 'POST',
                success: function(data){
                    table.ajax.reload(null, false);
                    swal({
                        title: "Payment!",
                        text: "Payment deleted successful!",
                        icon: "error",
                    });
                }
            })
                
           
        }
        function viewFilelist(id){
            $.ajax({
                url: './curd_invoicepayment.php',
                data: {
                    'getfiles':'get',
                    'id':id
                },
                type: 'POST',
                success: function(data){
                    $("#filelistModal tbody").html(data); 
                }
                })
            
            $("#filelistModal").modal('show');
        }
        function viewinvoicePayment(id) {
            $.get('viewinvoicePayment.php?id=' + id, function(response) {
                $('#viewinvoicePayment .modal-dialog').html(response); 
            });
            $("#viewinvoicePayment").modal('show');
        }     
        function selectRefresh() {
            $('.select2').select2({
                allowClear: true,
                width: '100%'
            });
        }

       
    </script>
</body>

</html>