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
                    Loading Guide
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Search Loading Guide</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <h3 class="text-center">Search Loading Guide</h3>
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
                                            <th>Pieces</th>
                                            <th>Weight</th>
                                            <th>Volume</th>
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

    <div id="edit_loading_guide" class="modal fade" role="dialog" style="    overflow: auto;">
        <div class="modal-dialog modal-lg">
        </div>
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
                                            data-date-format="yyyy-mm-dd" laceholder="To" value="1990-01-01"
                                            autocomplete="off" placeholder="From">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class=" input-group">
                                        <input t type="text" class="form-control" data-provide="datepicker" id="to"
                                            data-date-format="yyyy-mm-dd" laceholder="To"
                                            value="<?php echo date('Y-m-d') ?>" autocomplete="off" placeholder="To">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <button type="submit" class="btn btn-success "><i
                                                class="fa fa-search"></i>&nbsp;Filter</button>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <button id="add_loadings_warelists" type="button" class="btn btn-danger "><i
                                            class="fa fa-save"></i>&nbsp;Add Warehouse</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='warehousetable' style="width:100%;" class='display dataTable'>
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

    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#pre_loading_plan").addClass("active");
        $("#pre_loading_plan #search").addClass("active");
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });
        function editloadingguide(id) {
            $.get('edit_loading_guide.php?id=' + id, function (response) {
                $('#edit_loading_guide .modal-dialog').html(response);

                $("#inculde_warehouse").on("click", function (e) {
                    table2.ajax.reload();
                    $("#warehouse_for_loading").modal('show');
                });
                $("input[name='status']").on("change", function (e) {
                    $.post("./warehouse_loading_curd.php",
                        {
                            id: $("input[name='id']").val(),
                            loading_guide_status: 'update',
                            status: e.target.value,
                        },
                        function (data, status) {
                            $('#edit_loading_guide').modal('hide');
                            table.ajax.reload(null, false);
                            swal({
                                title: "Loading Guide!",
                                text: "Loading Guide Status updated successful!",
                                icon: "success",
                            });
                        });
                });
                $("#add_loadings_warelists").on("click", function (e) {
                    var checks_warehouse = $("input[name='all_warehouselist']").val();
                    if (checks_warehouse == '') {
                        checks_warehouse = [];
                    } else {
                        checks_warehouse = checks_warehouse.split(",");
                    }
                    $("#warehousetable tbody tr [name='jobCheck[]']:checked").each(function (e, ele) {
                        if (checks_warehouse.indexOf(ele.value) !== -1) {
                            alert("The WareHouse already Include!");
                        } else {
                            checks_warehouse.push(ele.value);
                        }
                    })
                    if (checks_warehouse.length > 0) {
                        $.ajax({
                            method: 'POST',
                            url: "./warehouse_loading_curd.php",
                            data: {
                                checks_warehouse: checks_warehouse,
                                warehouse_list: 'get'
                            }
                        })
                            .done(function (response) {
                                var data = JSON.parse(response);
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
                                table2.ajax.reload(null, false);
                                $("#warehouse_for_loading").modal('hide');
                            })
                    } else {
                        alert("Please check checkbox!!")

                    }
                });
                $("#update_loading_guide").submit(function (e) {
                    event.preventDefault();
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission                            
                    $.post(post_url, form_data, function (response) {
                        if (response) {
                            swal({
                                title: "Loading Guide!",
                                text: "Loading Guide Updated successful!",
                                icon: "success",
                            });
                            $('#edit_loading_guide').modal('hide');
                            table.ajax.reload(null, false);
                        }
                    });
                });
                $("#delete_loading_guide").submit(function (e) {
                    event.preventDefault();
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission                            
                    $.post(post_url, form_data, function (response) {
                        if (response) {
                            swal({
                                title: "Loading Guide!",
                                text: "Loading Guide Deleted successful!",
                                icon: "error",
                            });
                            $('#edit_loading_guide').modal('hide');
                            table.ajax.reload(null, false);
                        }
                    });
                });
            });
            $('#edit_loading_guide').modal('show');
        }
        function onwarehousedelete_loading(key, id) {
            var checks_warehouse = $("input[name='all_warehouselist']").val();
            checks_warehouse = checks_warehouse.split(",");
            var index = checks_warehouse.indexOf(id.toString());
            if (index > -1) {
                checks_warehouse.splice(index, 1);
            }            
            $.ajax({
                method: 'POST',
                url: "./warehouse_loading_curd.php",
                data: {
                    checks_warehouse: checks_warehouse,
                    warehouse_delete: 'get',
                    loadingguide_id: $("input[name='id']").val(),
                    id: id
                }
            })
                .done(function (response) {
                    var data = JSON.parse(response);
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
                [0, "asc"]
            ],
            'columnDefs': [{
                orderable: false,
                targets: [8, 9, 10]
            }],
            'ajax': {
                'url': 'ajaxfile_loadingguide.php'
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
            }, {
                data: 'all_total_pieces'
            }, {
                data: 'all_total_weight'
            },
            {
                data: 'all_total_volume'
            },
            {
                data: 'status'
            },
            {
                data: 'action'
            }]
        });
        var from = '', to = '', checklist = '';
        var table2 = $('#warehousetable').DataTable({
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
            'columnDefs': [{
                orderable: false,
                targets: [9]
            }],
            'ajax': {
                'url': 'ajaxfile_warehouse_for_loading.php',
                "data": function (d) {
                    d.from = Getfrom();
                    d.to = Getto();
                    d.checklist = Getchecklist();
                }
            },
            'columns': [{
                data: 'id'
            }, {
                data: 'reference_id'
            }, {
                data: 'fecha'
            }, {
                data: 'destination'
            }, {
                data: 'total_pieces'
            }, {
                data: 'total_weight'
            }, {
                data: 'total_volume'
            }, {
                data: 'supplier_id'
            }, {
                data: 'consignee_id'
            }, {
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
            if ($("input[name='all_warehouselist']").length) {
                return $("input[name='all_warehouselist']").val();
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