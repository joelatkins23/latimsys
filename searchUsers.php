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

    <style>
        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 10px 10px;
        }

        table.dataTable,
        table.dataTable th,
        table.dataTable td {
            height: auto;
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
                    Users
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Search Users</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:100%; margin-left:-50%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">
                            <h3 class="text-center">Search Users</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='empTable' style="width:100%;" class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">UserName</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Level</th>
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
        <div class="modal fade" id="editusermodal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">

            </div>
        </div>
        <script>
            $(".sidebar-menu li a").removeClass('active');
            $(".treeview").removeClass('active');
            $("#users_list").addClass("active");
            $("#users_list #search").addClass("active");
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
                    [1, "asc"]
                ],
                'columnDefs': [{
                    orderable: false,
                    targets: [0, 5]
                }],
                'ajax': {
                    'url': 'ajax/ajaxfile_users.php'
                },
                'columns': [{
                    data: 'photo'
                }, {
                    data: 'name'
                }, {
                    data: 'email'
                }, {
                    data: 'phone'
                }, {
                    data: 'level'
                }, {
                    data: 'action'
                }]
            });
            function editusers(email) {
                $.get('edit_users.php?email=' + email, function (response) {
                    $('#editusermodal .modal-dialog').html(response);
                    $("#change_password").click(function () {
                        if ($(this).is(':checked')) {
                            $(".change_password_content").css("display", "block");
                        } else {
                            $(".change_password_content").css("display", "none");
                        }
                    });

                    $("#image_upload").click(function () {
                        $("input[id='my_file']").click();
                    });
                    $("#image_my_we_logo").click(function() {
                        $("input[id='my_we_logo']").click();
                    });
                    $(function () {
                        $('#my_file').change(function () {
                            var input = this;
                            var url = $(this).val();
                            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#image_upload').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                                $('#user_logo').val(null);
                            }
                            else {
                                $('#image_upload').attr('src', './images/17-1.jpg');
                            }
                        });
                    });
                    $(function(){
                        $('#my_we_logo').change(function(){
                            var input = this;
                            var url = $(this).val();
                            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                            {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#image_my_we_logo').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                                $('#wr_logo').val(null);
                            }
                            else
                            {
                                $('#image_my_we_logo').attr('src', './images/logoChina.png');
                            }
                        });
                    });
                    $("#update_user_form").submit(function(e) {
                        event.preventDefault();
                        console.log($("#change_password").is(':checked'));
                        if($("#change_password").is(':checked')){
                            if($("input[name='password']").val() == $("input[name='confirm_password']").val()){
                                $("#password_error").css("display","none");                                
                                var fd = new FormData();
                                fd.append( 'avatar', $("input[name='avatar']").prop('files')[0]);
                                fd.append( 'wr_img', $("input[name='my_we_logo']").prop('files')[0]);
                                fd.append( 'update_user', 'update');
                                fd.append( 'username', $("input[name='username']").val());
                                fd.append( 'email', $("input[name='email']").val());
                                fd.append( 'wr_name', $("input[name='wr_name']").val());
                                fd.append( 'phone', $("input[name='phone']").val());
                                fd.append( 'password', $("input[name='password']").val());
                                fd.append( 'user_logo', $("input[name='user_logo']").val());
                                fd.append( 'wr_logo', $("input[name='wr_logo']").val());
                                fd.append( 'level', $("select[name='level']").val());
                                $.ajax({
                                    url: './curd.php',
                                    data: fd,
                                    processData: false,
                                    cache: false,
                                    contentType: false,
                                    type: 'POST',
                                    success: function(response){              
                                        var data=JSON.parse(response);
                                        if(data.status){ 
                                                swal({
                                                    title: "New User!",
                                                    text: "New Password is "+data.password,
                                                    icon: "success",
                                                }); 
                                                $("#editusermodal").modal('hide');              
                                            }else{
                                                swal({
                                                    title: "Waring!",
                                                    text: data.message,
                                                    icon: "error",
                                                });
                                            }            
                                        }
                                });
                            }else{
                                $("#password_error").css("display","block");
                            }
                        }else{
                            var fd = new FormData();
                                fd.append( 'avatar', $("input[name='avatar']").prop('files')[0]);
                                fd.append( 'wr_img', $("input[name='my_we_logo']").prop('files')[0]);
                                fd.append( 'user_logo', $("input[name='user_logo']").val());
                                fd.append( 'wr_logo', $("input[name='wr_logo']").val());
                                fd.append( 'wr_name', $("input[name='wr_name']").val());
                                fd.append( 'update_user_no_password', 'update');
                                fd.append( 'username', $("input[name='username']").val());
                                fd.append( 'email', $("input[name='email']").val());
                                fd.append( 'phone', $("input[name='phone']").val());
                                fd.append( 'level', $("select[name='level']").val());
                                $.ajax({
                                    url: './curd.php',
                                    data: fd,
                                    processData: false,
                                    cache: false,
                                    contentType: false,
                                    type: 'POST',
                                    success: function(response){              
                                        var data=JSON.parse(response);
                                            swal({
                                                title: "New User!",
                                                text: data.message,
                                                icon: "success",
                                            }); 
                                            $("#editusermodal").modal('hide');              
                                            table.ajax.reload( null, false );           
                                        }
                                });
                        }
                        
                        
                    });   
                });
                $("#editusermodal").modal('show');
            }

        </script>
</body>

</html>