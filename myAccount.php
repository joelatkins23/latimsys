<?php 
error_reporting(0);
require_once('conn.php');
session_start();
  $step= $_GET['step']; 
  if(isset($_GET['message'])){
    $message= $_GET['message'];
  }
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
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <title>Latim Cargo & Trading | My Profile</title>
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
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        My Profile 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Profile</li>
      </ol>
    </section>
     <?php if ($message=='AgentSaved'){ ?>
        <div  id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
        right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
          <div style="padding:15px;margin-right:10px;">
          <strong>New agent has been registered.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
        </div>
      <?php }?>
      <?php if ($message=='updateProfile'){ ?>
        <div  id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
        right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
          <div style="padding:15px;margin-right:10px;">
          <strong>Your Profile updated Successful</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
        </div>
      <?php }?>
    <section class="content">
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-3 col-md-6 shadow2" style="background: white;margin-top:50px;padding:20px;">
          <div class="row">
            <div class="col-md-12 text-center" style="border-bottom:1px solid #555555;">
              <h3 style="color:black; font-weight:400;font-size:20px; ">My Profile</h3>
              <h4><?php echo $email; ?> | <?php echo $level; ?></h4>
            </div>            
            <form action="./curd.php" method="POST"  enctype="multipart/form-data">
              <input type="hidden" name="update_profile" value="Update">
              <input type="hidden" name="email" value="<?php echo $email; ?>">
              <div class="col-md-12" style="padding:30px;">
                <div class="form-group row">
                  <div class="col-md-12 text-center">
                    <div class="card bd-0" style="border:unset">
                      <img class="card-img-top img-fluid user-image" id="image_upload"  alt="Image" src="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>" >
                      <input hidden type="file" id="my_file" name="avatar"  accept=".png, .jpg, .jpeg" value="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>"/>
                      <input type="hidden" id="user_logo" name="user_logo" value="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>" />
                    </div>
                  </div>                
                </div>
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control"  disabled placeholder="Name" value="<?php echo $agent_name; ?>">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control"  disabled placeholder="Email" value="<?php echo $email; ?>">
                </div>              
                <div class="form-group row">
                  <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update</button>
                  </div>
                </div>              
              </div>
            </form>
        </div>        
      </div>
    </section>
    <section class="content">
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-3 col-md-6 shadow2" style="background: white;margin-top:50px;padding:20px;">
          <div class="row">
            <div class="col-md-12 text-center" style="border-bottom:1px solid #555555;">
              <h3 style="color:black; font-weight:400;font-size:20px; ">Change Password</h3>
              <h4><?php echo $email; ?> | <?php echo $level; ?></h4>
            </div>
            <div class="col-md-12" style="padding:30px;">
              <div class="form-group row">
                <div class="col-md-12 text-center">
                  <a href="reset.php"><button class="btn btn-danger btn-lg"><i class="fa fa-lock"></i>&nbsp;Change your Password</button></a>
                </div>
              </div>
              <?php if ($email=='manager@latimcargo.com'){ ?>
              <div class="form-group row">
                <div class="col-md-12 text-center">
                  <a href="register.php"><button class="btn btn-success btn-lg"><i class="fa fa-save"></i>&nbsp;Register New Agent</button></a>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>        
      </div>
    </section>     
  </div>
  <script type="text/javascript">
      setTimeout(fade_out, 3000);

      function fade_out() {
        $("#mydiv").fadeOut().empty();
      }
      $("#image_upload").click(function() {
            $("input[id='my_file']").click();
        });

        $(function(){
            $('#my_file').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image_upload').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                    $('#user_logo').val(null);
                }
                else
                {
                    $('#image_upload').attr('src', './images/17-1.jpg');
                }
            });
        });
</script>
</body>
</html>
