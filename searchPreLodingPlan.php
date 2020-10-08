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
    <title>Latim Cargo & Trading | Search Pre Loading Plan</title>
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
    <style>
        table.dataTable,
        table.dataTable th,
        table.dataTable td {
            height: 40px;
        }
    </style>
    <script>
        window.addEventListener("load", function () {
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div id="load_screen">
        <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span
                style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
    </div>
    <div class="wrapper" style="height:auto">
        <?php include 'layout/header.php' ?>
        <?php include 'layout/sidebar.php' ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                   Pre Loading Plan
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Search Pre Loading Plan</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <h3 class="text-center">Search Pre Loading Plan</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='empTable' style="width:100%;" class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Branch</th>
                                            <th>Reference</th>
                                            <th>Agent</th>
                                            <th>Line</th>
                                            <th>Type</th>
                                            <th>Status</th>
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
    <div id="edit_pre_loading_plan" class="modal fade" role="dialog" style="overflow: auto;">
        <div class="modal-dialog modal-lg">
        </div>
    </div>
    <div id="joborders_for_loading" class="modal fade" role="dialog" >
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
                                <table id='jobordersTable' style="width:100%;" class='display dataTable'>
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
    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#pre_loading_plan").addClass("active");
        $("#pre_loading_plan #search").addClass("active");
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });
        function editpreloadingplan(id) {
            $.get('edit_pre_loading_plan.php?id=' + id, function (response) {
                $('#edit_pre_loading_plan .modal-dialog').html(response);

                $("#inculde_joborders").on("click", function (e) {
                    table2.ajax.reload();
                    $("#joborders_for_loading").modal('show');
                });
                $(".download_excel").on("click", function(e){
                    window.open("./excel/excel_preloadingplan.php?id="+id);
                }) 
                $("input[name='status']").on("change", function (e) {
                    $.post("./joborder_loading_curd.php",
                        {
                            id: $("input[name='id']").val(),
                            pre_loading_plan_status: 'update',
                            status: e.target.value,
                        },
                        function (data, status) {
                            $('#edit_pre_loading_plan').modal('hide');
                            table.ajax.reload(null, false);
                            swal({
                                title: "Pre Loading Plan!",
                                text: "Pre Loading Plan Status updated successful!",
                                icon: "success",
                            });
                        });
                });
                $("#add_loadings_joborderslists").on("click", function (e) {
                    var checks_joborders = $("input[name='all_joborderslist']").val();
                    if (checks_joborders == '') {
                        checks_joborders = [];
                    } else {
                        checks_joborders = checks_joborders.split(",");
                    }
                    $("#jobordersTable tbody tr [name='jobCheck[]']:checked").each(function (e, ele) {
                        if (checks_joborders.indexOf(ele.value) !== -1) {
                            alert("The Job Order already Include!");
                        } else {
                            checks_joborders.push(ele.value);
                        }
                    })
                    if (checks_joborders.length > 0) {
                        $.ajax({
                            method: 'POST',
                            url: "./joborder_loading_curd.php",
                            data: {
                                checks_joborders: checks_joborders,
                                joborders_list: 'get'
                            }
                        })
                            .done(function (response) {
                                var data = JSON.parse(response);
                                $("#joborders_lists tbody").html(data.html);                      
                                $("input[name='all_joborderslist']").val(data.all_joborderslist);
                                table2.ajax.reload(null, false);
                                $("#joborders_for_loading").modal('hide');
                            })
                    } else {
                        alert("Please check checkbox!!")

                    }
                });
                $("#update_pre_loading_plan").submit(function (e) {
                    event.preventDefault();
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission                            
                    $.post(post_url, form_data, function (response) {
                        if (response) {
                            swal({
                                title: "Pre Loading Plan!",
                                text: "Pre Loading Plan Updated successful!",
                                icon: "success",
                            });
                            $('#edit_pre_loading_plan').modal('hide');
                            table.ajax.reload(null, false);
                        }
                    });
                });
                $("#delete_pre_loading_plan").submit(function (e) {
                    event.preventDefault();
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission                            
                    $.post(post_url, form_data, function (response) {
                        if (response) {
                            swal({
                                title: "Pre Loading Plan!",
                                text: "Pre Loading Plan Deleted successful!",
                                icon: "error",
                            });
                            $('#edit_pre_loading_plan').modal('hide');
                            table.ajax.reload(null, false);
                        }
                    });
                });
            });
            $('#edit_pre_loading_plan').modal('show');
        }
        function onjobordersdelete_loading(key, id) {
            var checks_joborders = $("input[name='all_joborderslist']").val();
            checks_joborders = checks_joborders.split(",");
            var index = checks_joborders.indexOf(id.toString());
            if (index > -1) {
                checks_joborders.splice(index, 1);
            }            
            $.ajax({
                method: 'POST',
                url: "./joborder_loading_curd.php",
                data: {
                    checks_joborders: checks_joborders,
                    joborder_delete: 'get',
                    pre_loading_plan_id: $("input[name='id']").val(),
                    id: id
                }
            })
                .done(function (response) {
                    var data = JSON.parse(response);
                    $("#joborders_lists tbody").html(data.html);                
                    $("input[name='all_joborderslist']").val(data.all_joborderslist);                 
                })
        }
        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }
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
                [0, "desc"]
            ],
            'columnDefs': [{
                orderable: false,
                targets: [6,7]
            }],
            'ajax': {
                'url': 'ajaxfile_preloadingplan.php'
            },
            'columns': [{
                data: 'id'
            }, {
                data: 'branch'
            }, {
                data: 'reference'
            }, {
                data: 'name'
            }, {
                data: 'line'
            }, {
                data: 'type'
            }, 
            {
                data: 'status'
            },
            {
                data: 'action'
            }]
        });
        var from = '', to = '', checklist = '';
        var table2 = $('#jobordersTable').DataTable({
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
                "data": function (d) {
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
        function Getfrom() {
            return $("#from").val();
        }
        function Getto() {
            return $("#to").val();
        }
        function Getchecklist() {
            if ($("input[name='all_joborderslist']").length) {
                return $("input[name='all_joborderslist']").val();
            } else {
                return '';
            }
        }
        $("#filter").submit(function (e) {
            e.preventDefault();
            swal({
                title: "Date Fiter!",
                text: "Data filtered successful!",
                icon: "success",
            });
            table2.ajax.reload();
        }); 
        
    </script>
</body>

</html>