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
                    <li class="active">Search Payments</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <h3 class="text-center">Search Payments</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='empTable' width="100%" class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Checkbooks</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Check Number</th>
                                            <th class="text-center">Accounts</th>
                                            <th class="text-center">Print</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Memo</th>
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
    <div id="editPayment" class="modal fade" role="dialog" style="overflow: auto;">
        <div class="modal-dialog modal-lg">
        </div>
    </div>
    <div id="file_upload" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
                </div>
                <div class="modal-body" style="margin:20px;">
                    <form action="./curd_payment.php" id="addfile" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="payment_fileupload" name="payment_fileupload" value="add">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="file" id="image_file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple />
                            </div>
                            <div class="col-md-12 text-center" style="margin:20px auto;">
                                <button type="submit" class="btn btn-success"><i
                                        class="fa fa-cloud-upload"></i>&nbsp;Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#bill_menu").addClass("active");
        $("#bill_menu .sub_search_create").addClass("active");
        $("#bill_menu #search_payment_menu").addClass("active");
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
                [0, "desc"]
            ],
            'columnDefs': [{
                orderable: false,
                targets: [8]
            }],
            'ajax': {
                'url': 'ajax/ajaxfile_payment.php'
            },
            'columns': [{
                data: 'date'
            }, {
                data: 'checkbooks_name'
            }, {
                data: 'type_name'
            }, {
                data: 'check_number'
            }, {
                data: 'account_name'
            }, {
                data: 'print'
            }, {
                data: 'amount'
            }, {
                data: 'meno'
            }, {
                data: 'action'
            }, ]
        });

        function editPayment(id) {
            $.get('editPayment.php?id=' + id, function(response) {
                $('#editPayment .modal-dialog').html(response);
                $(".file_upload_btn").on("click", function() {
                    $("#file_upload").modal("show");
                });

                $(".td_file_remove").on("click", function(e) {
                    var name = $(this).parent('td').parent('tr').find("td:eq(0)").text();
                    var id = $(this).parent('td').parent('tr').find("input[name='td_fileid[]']").val();
                    $(this).parent('td').parent('tr').remove();
                    $.ajax({
                        url: './curd_payment.php',
                        data: {
                            'deleteupdatefile': 'delete',
                            'name': name,
                            'id': id
                        },
                        type: 'POST',
                        success: function(data) {
                            swal({
                                title: "Delete!",
                                text: "Files deleted successful!!",
                                icon: "error",
                            });

                        }
                    })
                })
                $("#edit_payment").submit(function(e) {
                    event.preventDefault(); //prevent default action 
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission                      
                    $.post(post_url, form_data, function(response) {
                        table.ajax.reload(null, false);
                        swal({
                            title: "Payment!",
                            text: "Payment updated successful!!",
                            icon: "success",
                        });
                    });
                    $("#editPayment").modal('hide');
                });
                $("#delete_payment").submit(function(e) {
                    event.preventDefault(); //prevent default action 
                    var post_url = $(this).attr("action"); //get form action url
                    var form_data = $(this).serialize(); //Encode form elements for submission

                    $.post(post_url, form_data, function(response) {
                        $("#editPayment").modal('hide');
                        table.ajax.reload(null, false);
                        swal({
                            title: "Payment!",
                            text: "Payment deleted successful!",
                            icon: "error",
                        });
                    });
                });
            });
            $("#editPayment").modal('show');
        }
        $("#addfile").submit(function(e) {
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var fd = new FormData();
            var totalfiles = document.getElementById('image_file').files.length;
            for (var index = 0; index < totalfiles; index++) {
                fd.append("image_file[]", document.getElementById('image_file').files[index]);
            }
            fd.append('payment_fileupload', 'add');
            $.ajax({
                url: './curd_payment.php',
                data: fd,
                processData: false,
                cache: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    $("#file_upload").modal('hide');
                    swal({
                        title: "File!",
                        text: "New Files Uploaded successful!!",
                        icon: "success",
                    });
                    $('input[type="file"]').val("");
                    $(".imageuploadify-container").remove();
                    var rep = JSON.parse(data);
                    var html = "";
                    for (var i = 0; i < rep.length; i++) {
                        html += '<tr>';
                        html += '<td class="" ><a href="./images/bills/' + rep[i].name + '" target="blank">' + rep[i].name + '</a><input type="hidden"  name="td_filename[]" value="' + rep[i].name + '"></td>';
                        html += '<td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>';
                        html += '<input type="hidden"  name="td_fileid[]" value="" >';
                        html += '</tr>';
                    }
                    $(".file_table tbody").append(html);
                    $(".td_file_remove").on("click", function(e) {
                        var name = $(this).parent('td').parent('tr').find("td:eq(0)").text();
                        var id = $(this).parent('td').parent('tr').find("input[name='td_fileid[]']").val();
                        $(this).parent('td').parent('tr').remove();
                        $.ajax({
                            url: './curd_payment.php',
                            data: {
                                'deleteupdatefile': 'delete',
                                'name': name,
                                'id': id
                            },
                            type: 'POST',
                            success: function(data) {
                                swal({
                                    title: "Delete!",
                                    text: "Files deleted successful!!",
                                    icon: "error",
                                });

                            }
                        })
                    })

                }
            });
        });

        function onpayment(ele) {
            var bill_id = ele.parent('td').parent('tr').find("td:eq(0)").text();
            var inv = ele.parent('td').parent('tr').find("td:eq(1)").text();
            var account = ele.parent('td').parent('tr').find("td:eq(2)").text();
            var currency = ele.parent('td').parent('tr').find("td:eq(3)").text();
            var amount = ele.parent('td').parent('tr').find("td:eq(4)").text();
            var payment = ele.parent('td').parent('tr').find("#td_payment").val();
            var change_payment = ele.parent('td').parent('tr').find("#td_change_payment").val();
            if (change_payment - payment > 0) {
                var dif = Math.round((change_payment - payment) * 100) / 100;
                ele.parent('td').parent('tr').find("#td_payment").val(dif);
                ele.parent('td').parent('tr').find("#td_change_payment").val(dif);
            } else if (change_payment - payment == 0) {
                ele.parent('td').parent('tr').remove();
            }
            var tbody = "";
            tbody += '<tr>';
            tbody += '<td class="text-center">' + bill_id + '</td>';
            tbody += '<td class="text-center">' + inv + '</td>';
            tbody += '<td class="text-center">' + account + '</td>';
            tbody += '<td class="text-center">' + currency + '</td>';
            tbody += '<td class="text-center">' + amount + '</td>';
            tbody += '<td class="text-center">' + payment + '</td>';
            tbody += '<td class="text-center"><i class="fa fa-trash action td_remove" onclick="ontdremove($(this))"></i></td>';
            tbody += '<input type="hidden" name="td_paid[]" value="' + payment + '" class="form-control text-right">';
            tbody += '<input type="hidden" name="td_bill_id[]" value="' + bill_id + '" class="form-control text-right">';
            tbody += '</tr>';
            $(".paid_table tbody").append(tbody);
            total_calculator();
        }

        function ontdremove(ele) {
            var bill_id = ele.parent('td').parent('tr').find("td:eq(0)").text();
            var element = '';
            $(".payment_table tbody tr").each(function(index, ele1) {
                var id = $(this).find("td:eq(0)").text();
                if (bill_id == id) {
                    element = $(this);
                }
            });
            var paid = 0;
            if (element) {
                var id = element.find("td:eq(0)").text();
                var payment = ele.parent('td').parent('tr').find("td:eq(5)").text();
                var old_payment = element.find("#td_payment").val();
                paid = parseFloat(payment);
                var dif = Math.round((parseFloat(old_payment) + parseFloat(payment)) * 100) / 100;
                element.find("#td_payment").val(dif);
                element.find("#td_change_payment").val(dif);

            } else {
                var td_inv = ele.parent('td').parent('tr').find("td:eq(1)").text();
                var td_account = ele.parent('td').parent('tr').find("td:eq(2)").text();
                var td_currency = ele.parent('td').parent('tr').find("td:eq(3)").text();
                var td_amount = ele.parent('td').parent('tr').find("td:eq(4)").text();

                var td_payment = ele.parent('td').parent('tr').find("td:eq(5)").text();
                paid = parseFloat(td_payment);
                var html = '';
                html += '<tr>';
                html += '<td class="text-center">' + bill_id + '</td>';
                html += '<td class="text-center">' + td_inv + '</td>';
                html += '<td class="text-center">' + td_account + '</td>';
                html += '<td class="text-center">' + td_currency + '</td>';
                html += '<td class="text-center">' + td_amount + '</td>';
                html += '<td class="text-center">';
                html += '<input type="text" id="td_payment" value="' + td_payment + '" class="form-control text-right">';
                html += '</td>';
                html += '<td class="text-center"><button type="button"  onclick="onpayment($(this))" class="btn btn-success payment_btn btn-sm"><i class="fa fa-money"></i>&nbsp;Pay</button></td>';
                html += '<input type="hidden" id="td_change_payment" value="' + td_payment + '" class="form-control text-right">';
                html += '</tr>';
                $(".payment_table tbody").append(html);
            }
            var payment_id = ele.parent('td').parent('tr').find("input[name='td_payment_id[]']").val();
            if (payment_id) {
                $.ajax({
                    url: './curd_payment.php',
                    data: {
                        'deletepayment_item': 'delete',
                        'payment_id': payment_id,
                        'bill_id': bill_id,
                        'paid': paid
                    },
                    type: 'POST',
                    success: function(data) {
                        swal({
                            title: "Payment!",
                            text: "Payment deleted successful!!",
                            icon: "error",
                        });

                    }
                })
            }
            ele.parent('td').parent('tr').remove();
            total_calculator();
        }

        function selectRefresh() {
            $('.select2').select2({
                allowClear: true,
                width: '100%'
            });
        }

        function total_calculator() {
            var total_amount = 0;
            $(".paid_table  tbody tr").each(function(index, ele) {
                var amount = $(this).find("td:eq(5)").text();
                total_amount = total_amount + parseFloat(amount);
            });
            $("#amount").text(total_amount);
            $("input[name='amount']").val(total_amount);
        }
    </script>
</body>

</html>