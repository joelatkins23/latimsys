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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
    <title>Latim Cargo & Trading | Search USA Order</title>
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
    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/select2/select2.js"></script>  
    <script src="plugins/moment.min.js"></script>  
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>  
    <script src="dist/js/app.min.js"></script>
   
    <script>
        window.addEventListener("load", function() {
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
    </script>
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
                    LATAM Orders
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Search LATAM Order</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <div class="col-md-offset-4 col-md-4 text-center">
                                <h3 class="text-center">Search LATAM Order</h3>
                            </div>
                            <div class="col-md-4 text-center" style="margin-bottom:10px;">
                                <p class="text-center">Change Status</p>
                                <form class="form-inline">
                                    <div class="form-group">
                                        <select name="statusUpdate" id="statusUpdate" class="form-control select2" style="width:150px; font-size:13px;">
                      <option value="PENDING">Pending</option>
                      <option value="READY TO CONTACT">Ready to contact</option>
                      <option value="CHECK NOTES">Check Notes</option>
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
                                    <input type="text" class="form-control" data-provide="datepicker" id="from" data-date-format="yyyy-mm-dd" laceholder="To" value="" autocomplete="off"  placeholder="From">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class=" input-group">
                                    <input t type="text" class="form-control" data-provide="datepicker" id="to" data-date-format="yyyy-mm-dd" laceholder="To" value="" autocomplete="off"  placeholder="To">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-success "><i class="fa fa-search"></i>&nbsp;Filter</button>
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
                                            <th>Action</th>
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
    <script>
        $(document).ready(function() {

        });
    </script>
    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#latamorders_list").addClass("active");
        $("#latamorders_list #search").addClass("active");

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }
        var from = '',
            to = '',
            jobCheckval;
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
                targets: [8, 9, 10, 11]
            }],
            'ajax': {
                'url': 'ajaxfile_latam.php',
                "data": function(d) {
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
            }, {
                data: 'shortcut'
            }, {
                data: 'action'
            }, ]
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

        function Getfrom() {
            return $("#from").val();
        }

        function Getto() {
            return $("#to").val();
        }

        function GetjobCheck() {
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
        $("#statusUpdate_btn").on("click", function(e) {
            var jobCheck = [];
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function(e, ele) {
                jobCheck.push(ele.value);
            })
            jobCheckval = Object.assign({}, jobCheck);
            if (jobCheck.length > 0) {
                $.ajax({
                        method: 'POST',
                        url: "./curd.php",
                        data: {
                            jobCheck: jobCheck,
                            status_Update: 'statusUpdate',
                            statusUpdate: $("#statusUpdate").val()
                        }
                    })
                    .done(function(response) {
                        swal({
                            title: "Status!",
                            text: "Status updated successful!",
                            icon: "success",
                        });
                        table.ajax.reload(null, false);

                    })
            } else {
                alert("Please check checkbox!!")
            }

        });
    </script>
</body>

</html>