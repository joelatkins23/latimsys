<?php 
    error_reporting(0);
    require_once('conn.php');
    session_start();
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
  <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Latim Cargo & Trading | Create Users</title>
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
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script> 
  <script src="dist/js/app.min.js"></script>
   

  <script>
    window.addEventListener("load", function(){
      var load_screen = document.getElementById("load_screen");
      document.body.removeChild(load_screen);
    });
</script>
</head>

<body class="hold-transition sidebar-mini">
  <div id="load_screen"><div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div></div>
  <div class="wrapper">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Users
          <small>Create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create Users</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row" style="    margin: 0px;">
          <div class="col-md-offset-3 col-md-6 form_1 shadow2">
            <div class="row">
              <div class="col-md-12">
                <h3
                  style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">
                  Create Users                  
                </h3>
              </div>
            </div>
            <div class="row" style="padding:50px;">
              <div class="col-md-12">
                <form id="creat_form" action="./curd.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="create_user" value="create">
                  <div class="form-group text-center">
                    <div class="card bd-0" style="border:unset">
                      <img class="card-img-top img-fluid user-image" id="image_upload"  alt="Image" src="./images/17-1.jpg" >
                      <input hidden type="file" id="my_file" name="avatar"  accept=".png, .jpg, .jpeg" value=""/>
                      <input type="hidden" id="user_logo" name="user_logo" value="" />
                    </div>
                  </div>
                  <div class="form-group row">                
                    <label >Name</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control"  name="username" required placeholder="Enter Name">
                    </div>                   
                  </div>
                  <div class="form-group row">                
                    <label >Email</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input type="email" class="form-control"  name="email" required placeholder="Enter Email">
                    </div>                   
                  </div>
                  <div class="form-group row">                
                    <label >Phone</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input type="text" class="form-control"  name="phone" required placeholder="Enter Phone">
                    </div>                   
                  </div>
                  <div class="form-group row">                
                    <label >Level</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-star"></i></span>
                      <select name="level" id="" class="form-control select2" data-placeholder="Select Level">
                        <option value="">Select Level</option>
                        <option value="Seller">Seller</option>
                        <option value="Administrator">Administrator</option>
                      </select>
                    </div>                   
                  </div>
                  <div class="form-group row">                
                    <label >PassWord</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control"  name="password" required placeholder="Enter PassWord">
                    </div>                   
                  </div>
                  <div class="form-group row">                
                    <label >Confirm PassWord</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control"  name="confirm_password" required placeholder="Enter PassWord Again">
                      
                    </div>    
                    <small id="password_error" class="form-text text-muted" style="color:red;display:none">Password did not match.</small>               
                  </div>
                  <div class="form-group row text-right">                
                    <button  type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>                 
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

  <script>
    $(".sidebar-menu li a").removeClass('active');
    $(".treeview").removeClass('active');
    $("#users_list").addClass("active");
    $("#users_list #create").addClass("active");

    $(".select2").select2();
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
    $(function () {
      $("#creat_form").submit(function(e) {
        event.preventDefault();
        if($("input[name='password']").val() == $("input[name='confirm_password']").val()){
          $("#password_error").css("display","none");
         
          var fd = new FormData();
          fd.append( 'avatar', $("input[name='avatar']").prop('files')[0]);
          fd.append( 'user_logo', $("input[name='user_logo']").val());
          fd.append( 'create_user', $("input[name='create_user']").val());
          fd.append( 'username', $("input[name='username']").val());
          fd.append( 'email', $("input[name='email']").val());
          fd.append( 'phone', $("input[name='phone']").val());
          fd.append( 'password', $("input[name='password']").val());
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
                  $("#my_file").val("");
                  $("#my_file").trigger('change');
                  $('#image_upload').attr('src', './images/17-1.jpg');  
                  $("input[name='username']").val(""); 
                  $("input[name='email']").val("");  
                  $("input[name='phone']").val("");  
                  $("input[name='password']").val(""); 
                  $("input[name='confirm_password']").val("");    
                  $("select[name='level']").val(""); 
                  $("select[name='level']").trigger('change');               
                  swal({
                      title: "New User!",
                      text: "New Password is "+data.password,
                      icon: "success",
                  });               
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
         
      });
    });
  </script>


</body>

</html>