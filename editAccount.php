<?php 
error_reporting(0);
require_once('conn.php');

$message= $_GET['message'];

$id_account= $_GET['id_account'];
// Initialize the session
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
    <title>Latim Cargo & Trading | Search Account</title>
    <!-- Datatable CSS -->
    <link href='plugins/select2/select2.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href=" https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href='plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="./plugins/datepicker/datepicker3.css">    
    
    
    <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
    <link rel="stylesheet" href="latimstyle.css">
    <link href='assets/css/style.css' rel='stylesheet' type='text/css'> 
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> -->
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
    <header class="main-header">

      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="./img/logo.png" style="width:55px; padding:5px;"></span>
        <!-- logo for regular state and mobile devices -->
        <img src="./img/logo.png" style="width:100px; padding:5px;">
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" style="background:#B80008; color:white;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="color:white;">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu" style="color:white;">
          <ul class="nav navbar-nav">

            
            <!-- Tasks: style can be found in dropdown.less -->
            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;">
                <?php if($picture){ ?>
            <img src="<?php echo $picture; ?>" class="user-image" alt="User Image">
            <?php }else{ ?>
              <img src="./images/17-1.jpg" class="user-image" alt="User Image">
            <?php }?>
                <span class="hidden-xs"><?php echo $agent_name; ?></span>
              </a>
              <ul class="dropdown-menu shadow2">
                <!-- User image -->
                <li class="user-header" >
                  <?php if($picture){ ?>
            <img src="<?php echo $picture; ?>" class="img-circle" alt="User Image">
            <?php }else{ ?>
              <img src="./images/17-1.jpg" class="img-circle" alt="User Image">
            <?php }?>

                  <p style="color:black;">
                    <?php echo $agent_name; ?> | <?php echo $level; ?>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="myAccount.php" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar" style="background:#910007;">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <?php if($picture){ ?>
            <img src="<?php echo $picture; ?>" class="img-circle" alt="User Image">
            <?php }else{ ?>
              <img src="./images/17-1.jpg" class="img-circle" alt="User Image">
            <?php }?>
          </div>
          <div class="pull-left info">
            <p style="color:#e0e0e0;"><?php echo $agent_name; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

          <li style="border-bottom:1px solid gray; padding:5px;">
            <a href="index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li style="border-bottom:1px solid gray; padding:5px;">
              <span class="" style="text-align:center; color:white; ">Quick Searcher <img src="./img/chinaFlag.png" style="width:30px; position:relative; top:-3px; left:10px;"> </span>
              <form method="get" action="searcherJobOrder.php?">
              <input name="JO"  placeholder="J.O# / CLIENT or SUPPLIER NAME" style="width:100%; font-size:12px; text-align:center; border:1px solid gray; padding:15px;">
              <br><br>
        </form>
          </li>

          <center>
          <div style="width:100%; height:20px; position:relative; top:0px; background:#CECAC6; color:#630000; font-weight:600; font-size:14px;">CARGOS</div></center>
          <li class="active treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-users"></i> <span style="font-size:11px; ">Accounts</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li ><a href="createAccount.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a class="active" href="searchAccount.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

        
          <li class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px; ">Quotations</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right" ></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><a href="createQuotation.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li ><a href="searchQuotation.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          <li class=" treeview" style="border-bottom:1px solid gray; padding:5px;">
          <a href="#" style="height:25px; position:relative; top:-10px;">
            <i class="fa fa-home"></i> <span style="font-size:11px; ">Warehouse</span>
            <span class="pull-right-container" style="top:22px;">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a class="" href="createWarehouse.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
            <li><a href="searchWarehouse.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
          </ul>
          </li>
          <center><div style="width:100%; height:20px; position:relative; top:0px; background:#CECAC6; color:#630000; font-weight:600; font-size:14px;">JOB ORDERS</div></center>

          <li class=" treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">CHINA Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class=""><a  href="createJobOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li ><a class="" href="searchJobOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li class="treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">USA Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="" href="createUsaOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a href="searchUsaOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li class="treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">LATAM Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="createLATAMOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li ><a href="searchLATAMOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li class=" treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">TAIWAN Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="" href="createTAIWANOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li ><a href="searchTAIWANOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          <center><div style="width:100%; height:20px; position:relative; top:0px; background:#CECAC6; color:#630000; font-weight:600; font-size:14px;">SUPPORT AREA</div></center>
          <li class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;"> 
              <i class="fa fa-info"></i> <span style="font-size:11px;">Tickets</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li ><a  href="createTicket.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a href="searchTicket.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

      </section>
      <!-- /.sidebar -->
    </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Accounts 
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Accounts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row" style="margin: 0px;"> 
            <div class="col-md-offset-3 col-md-6 shadow2" style="    background: white;margin-top:50px">
                <div class="row" style="border-bottom:1px solid #555555; padding:20px;">
                    <div class="col-md-9">
                      <h3 style="text-align:center; color:black; font-weight:400;  font-size:20px; ">Edit Account

                      </h3>
                    </div>
                    <dvi class="col-md-3 text-right" style="margin-top: 10px;">
                      <a Onclick="return ConfirmDelete()" href="action/deleteAccount.php?id=<?php echo $id_account; ?>" ><button  type="button" class="btn btn-danger"><i class="fa fa-close"></i>&nbsp;Delete</button></a>

                    </dvi>
                </div>
                <?php if ($message=='AccountSaved'){ ?>
                  <br>
                  <div id="mydiv" style="background-color: rgba(0, 127, 70, 1); padding:20px;color:white; position:absolute; left:50%; width:300px; margin-left:140px; top:-80px;">
                    <center>
                      <span style="font-style: oblique; ">Account has been edited.</span>
                    </center>
                  </div>
                <?php } ?>
                <br>

                <script>
                function ConfirmDelete() {
                  return confirm("Are you sure you want to delete?");
                }
                </script>

                <script type="text/javascript">
                    setTimeout(fade_out, 3000);

                function fade_out() {
                  $("#mydiv").fadeOut().empty();
                }
                </script>
                <?php $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$id_account' ") or die ("Error al traer los datos");

                    while ($row = mysqli_fetch_array($consulta)){

                      $agent=$row['agent'];
                      $company=$row['company'];
                      $name=$row['name'];
                      $address_1=$row['address_1'];
                      $address_2=$row['address_2'];
                      $city=$row['city'];
                      $state=$row['state'];
                      $country=$row['country'];
                      $telf1=$row['telf1'];
                      $telf2=$row['telf2'];
                      $qq=$row['qq'];
                      $wechat=$row['wechat'];
                      $email=$row['email'];
                      $type=$row['type'];


                    }?>
                  <form action="action/saveEditAccount.php" method="POST">


                  <input style="display:none;" name="id"  value="<?php echo $id_account; ?>">
                    <div class="input-group">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-circle"></i></span>
                    
                      <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?>
                          name="agent_name"
                        <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?>
                          disabled
                        <?php } ?> style="width:100%;">

                          <option value="<?php echo $agent_name; ?>"><?php echo $agent_name; ?></option>

                          <?php 

                          $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");

                            while ($rowList = mysqli_fetch_array($consultaList)){ 

                            $agent_List=$rowList['name']; ?>
                              

                              <?php if ($agent_name!=$agent_List){ ?>

                          <option value="<?php echo $agent_List; ?>"><?php echo $agent_List; ?></option> 
                          <?php } }  ?>
                          
                        </select>
                    <?php if ($level=='Seller'){ ?>
                      <input type="text" name="agent_name" style="display:none;" value="<?php echo $agent_name; ?>">
                    <?php } ?>
                  </div>
                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                    <input name="company" type="text" class="form-control" value="<?php echo $company; ?>" placeholder="Company Name">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                    <input name="name" type="text" class="form-control" value="<?php echo $name; ?>" placeholder="Contact Person" required="required">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                    <input name="address_1" type="text" class="form-control" value="<?php echo $address_1; ?>" placeholder="Address 1">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                    <input name="address_2" type="text" class="form-control" value="<?php echo $address_2; ?>" placeholder="Address 2">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                    <input name="city" type="text" class="form-control" value="<?php echo $city; ?>" placeholder="City">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                    <input name="state" type="text" class="form-control" value="<?php echo $state; ?>" placeholder="State" >
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
                    <select name="country" class="form-control select2"  style="width:100%;" required="required">
                        <option value="">Select Country</option>
                      <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                          while ($row = mysqli_fetch_array($consulta_coutry)){ 
                          ?>
                      <option 
                          <?php if($country == $row['sub_name'] ){ echo "selected"; } ?>
                      value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                      <?php } ?> 
                    </select>
                  </div>


                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i> Mobile</span>
                    <input name="telf1" type="text" class="form-control" value="<?php echo $telf1; ?>" placeholder="Mobile Phone">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i> Office</span>
                    <input name="telf2" type="text" class="form-control" value="<?php echo $telf2; ?>" placeholder="Office Phone">
                  </div>


                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i> QQ</span>
                    <input name="qq" type="text" value="<?php echo $qq; ?>" class="form-control" placeholder="QQ">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i> WeChat</span>
                    <input name="wechat" type="text" value="<?php echo $wechat; ?>" class="form-control" placeholder="WeChat">
                  </div>

                  <div class="input-group" style="margin-top:20px;">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
                    <input name="email" type="text" value="<?php echo $email; ?>" class="form-control" placeholder="E-mail">
                  </div>

                   <!-- radio -->
                  <div class="input-group" style="margin-top:20px;">                    
                    <label>
                      <input type="radio" name="type" value="Client" class="flat-red" required="required" <?php if ($type=='Client'){ ?> checked <?php } ?>>
                      <label>Client</label>
                    </label>
                     <br>
                    <label>                      
                      <input type="radio" name="type" value="Supplier" class="flat-red" required="required" <?php if ($type=='Supplier'){ ?> checked <?php } ?>>
                      <label>Supplier</label>
                    </label>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12 text-right">
                          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                      </div>                        
                  </div>                  
              </form>


              </div> 
        </div>
    </section>
    <!-- /.content -->
  </div>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>
