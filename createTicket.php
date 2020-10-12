<?php 
error_reporting(0);
require_once('conn.php');

    $message= $_GET['message'];
    $step= $_GET['step'];
    $type= $_GET['type'];
    $job_id_step1= $_GET['job_id_step1'];

    // Initialize the session
session_start();

require_once('conn.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM agents WHERE email='$email' ")
    or die ("Error al traer los Agent");


     while ($rowAgent = mysqli_fetch_array($consultaAgent)){
        $agent_id=$rowAgent['id'];
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
    <title>System | Create Ticket</title>
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
  <div class="wrapper">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Tickets 
          <small>Create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create Tickets</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Form -->
  <?php if ($step=='') {$step='1';} ?>
  <?php if ($step=='1'){ ?>
    <div class="row" style="margin: 0px;"> 
          <div class="col-md-offset-2 col-md-8 shadow2" style="    background: white;margin-top:50px">
            <div class="row">
              <div class="col-md-12 text-center" style="border-bottom:1px solid #555555; padding-bottom:10px;">
                <h3 style="text-align:center; color:black; font-weight:400; font-size:20px; ">Create Ticket</h3>
                <span  style="color:black; font-size:14px; font-weight:400; padding:20px;">Please select one option:</span>
              </div>
            </div>
              <div class="row" style="margin:30px 10px">
                <div class="col-md-6">
                    <div class="form-group ">
                        <div class="text-center" style=" margin-bottom:20px">
                            <span style="font-size:60px; padding:10px;" class="glyphicon glyphicon-exclamation-sign"></span><br>
                        </div>
                    </div>
                    <form action="?" method="get">
                      <input type="hidden"  name="step" value="2">
                      <input type="hidden"  name="type" value="missing">
                      <div class="form-group row">
                          <div class="col-md-12" >
                            <div class=" input-group">
                              <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                              <select data-placeholder="Select Job Order" name="job_id_step1" class="form-control select2"  required="required" >
                                <option value="">Select Job Order</option>
                                <option value="Not Found">Not Found</option>
                                <?php 
                                if ($level=='Seller') { $consulta1 = mysqli_query($connect, "SELECT a.*, b.name, b.company FROM joborders a
                                  LEFT JOIN `accounts` b ON a.`client_id`=b.id 
                                  LEFT JOIN `agents` c ON a.`agent_id`=c.id
                                  WHERE c.`email`='$email' ORDER BY id desc ") or die ("Error al traer los datos"); 
                                }else{
                                  $consulta1 = mysqli_query($connect, "SELECT a.*, b.name, b.company FROM joborders a
                                  LEFT JOIN `accounts` b ON a.`client_id`=b.id order by id desc") or die ("Error al traer los datos");
                                }
                                while ($row = mysqli_fetch_array($consulta1)){ 
                                  $customer_name=$row['name'];
                                  $customer_company=$row['company'];
                                  $job_id=$row['id'];
                                  $customer= $customer_name.' / '.$customer_company;
                                  ?>       
                                <option value="<?php echo $job_id; ?>"><?php echo $job_id.' | '.$customer; ?></option>
                                <?php }  ?>                                
                              </select>
                            </div>                  
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-12 text-center">
                              <button type="submit"  class="btn btn-success" >Missing Cargo Ticket</button>
                          </div>
                      </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <div class="text-center" style=" margin-bottom:20px">
                            <span style="font-size:60px; padding:10px;" class="glyphicon glyphicon-file"></span><br>
                        </div>
                    </div>
                    <form action="?" method="get">
                      <input type="hidden"  name="step" value="2">
                      <input type="hidden"  name="type" value="warehouse">
                      <div class="form-group row">
                          <div class="col-md-12" >
                            <div class=" input-group">
                              <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                              <select data-placeholder="Select Job Order" name="job_id_step1" class="form-control select2"  required="required" >
                                <option value="">Select Job Order</option>
                                <option value="Not Found">Not Found</option>
                                <?php 

                                if ($level=='Seller') { $consulta1 = mysqli_query($connect, "SELECT a.*, b.name, b.company FROM joborders a
                                  LEFT JOIN `accounts` b ON a.`client_id`=b.id 
                                  LEFT JOIN `agents` c ON a.`agent_id`=c.id
                                  WHERE c.`email`='$email' ORDER BY id desc ") or die ("Error al traer los datos"); 
                                }else{
                                  $consulta1 = mysqli_query($connect, "SELECT a.*, b.name, b.company FROM joborders a
                                  LEFT JOIN `accounts` b ON a.`client_id`=b.id order by id desc") or die ("Error al traer los datos");
                                }
                                  while ($row = mysqli_fetch_array($consulta1)){ 
                                  $customer_name=$row['name'];
                                  $customer_company=$row['company'];
                                  $job_id=$row['id'];
                                  $customer= $customer_name.' / '.$customer_company;
                                  ?>       
                                <option value="<?php echo $job_id; ?>"><?php echo $job_id.' | '.$customer; ?></option>
                                <?php }  ?>
                              </select>
                            </div>                  
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-12 text-center">
                              <button type="submit"  class="btn btn-danger" >Warehouse Ticket</button>
                          </div>
                      </div>
                    </form>
                </div>
              </div>
              
          </div>
        </div>
  <?php } ?>
  <?php if ($message=='TicketSaved'){ ?>
      <div  id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
      right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
        <div style="padding:15px;margin-right:10px;">
        <strong>New Tickets Created Successful</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>          
      </div>
    <?php }?>
  <?php if ($step=='2' && $type=='missing') { ?>
        <div class="row" style="margin: 0px;"> 
          <div class="col-md-offset-3 col-md-6 shadow2" style="    background: white;margin-top:50px">
            <div class="row">
              <div class="col-md-12 " style="border-bottom:1px solid #555555; padding-bottom:10px;padding-top: 10px;">
                  <h4><span style="font-size:40px;  margin-right:20px; " class="glyphicon glyphicon-exclamation-sign"></span> &nbsp;New Missing Cargo Ticket</h4>
              </div>
            </div>
            <form action="action/saveTicket.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="missing">
              <input type="hidden" name="step" value="2">
              <?php 

                  $consulta2 = mysqli_query($connect, "SELECT a.*, (b.name)c_name,(b.`company`)c_company, (c.`name`)s_name, (c.`company`)s_company, (c.`telf1`)s_telf1,(c.`telf2`)s_telf2,(c.`wechat`)s_wechat,(c.`qq`)s_qq, (c.country)s_country, (c.state)s_state, (c.city)s_city, (c.address_1)s_address_1, (c.address_2)s_address_2 FROM joborders a
                  LEFT JOIN `accounts` b ON a.`client_id`=b.`id`
                  LEFT JOIN `accounts` c ON a.`supplier_id`=c.`id`
                  LEFT JOIN `agents` d ON a.`agent_id`=d.`id` where a.id='$job_id_step1'") or die ("Error al traer los datos");

                    while ($row2 = mysqli_fetch_array($consulta2)){ 
                        $client_id=$row2['client_id'];
                        $supplier_id=$row2['supplier_id'];
                        $customer_company= $row2['c_company'];
                        $customer_name= $row2['c_name']; 
                        $branch= $row2['branch'];
                        $service= $row2['service'];
                        $commodity= $row2['commodity'];
                        $wh_receipt= $row2['wh_receipt'];
                        $remark= $row2['remark'];
                        $supplier_name=$row2['s_name'];
                        $supplier_company=$row2['s_company'];
                        $supplier_address1=$row2['s_address_1'];
                        $supplier_address2=$row2['s_address_2'];
                        $supplier_city=$row2['s_city'];
                        $supplier_state=$row2['s_state'];
                        $supplier_country=$row2['s_country'];
                        $supplier_address= $supplier_address1.' '.$supplier_address2.' | '.$supplier_city.', '.$supplier_state.' - '.$supplier_country.'.';
                        $supplier_telf1=$row2['s_telf1'];
                        $supplier_telf2=$row2['s_telf2'];
                        $supplier_qq=$row2['s_qq'];
                        $supplier_wechat=$row2['s_wechat'];
                        if ($supplier_telf1!='') {$supplier_telf1=' - Mobile: '.$supplier_telf1;}
                        if ($supplier_telf2!='') {$supplier_telf2=' - Office: '.$supplier_telf2;}
                        if ($supplier_qq!='') {$supplier_qq=' - QQ: '.$supplier_qq;}
                        if ($supplier_wechat!='') {$supplier_wechat=' - WeChat: '.$supplier_wechat;}
                        $supplier_telf=$supplier_telf1.$supplier_telf2.$supplier_qq.$supplier_wechat;
                        
                        // $customer= $customer_name.' | '.$customer_company;
                }
              ?>
              <div class="row" style="margin:30px 10px">
                <div class="col-md-12">
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class=" input-group">
                              <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                              <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?>
                                name="agent_id"
                              <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?>
                                disabled
                              <?php } ?> >
                                <?php 

                                $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY id asc ") or die ("Error al traer los datos");

                                  while ($rowList = mysqli_fetch_array($consultaList)){ 

                                  $agent_List=$rowList['name']; ?>
                                    


                                <option 
                                <?php if($agent_id==$rowList['id']){ echo "selected";} ?>
                                value="<?php echo $rowList['id']; ?>"><?php echo $agent_List; ?></option> 
                                <?php }   ?>
                                
                              </select>
                          </div>
                      </div>
                  </div>
                  <?php if ($level=='Seller'){ ?>
                      <input type="hidden" name="agent_id"  value="<?php echo $agent_id; ?>">                      
                  <?php } ?>                   
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                            <input type="text" name="name" class="form-control" value="<?php if(isset($customer_name)){echo $customer_name;} ?>" placeholder="Customer or Company Name">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                            <input type="text" name="supplier" class="form-control" value="<?php if(isset($supplier_company)){echo $supplier_company;} ?>" placeholder="Supplier Name">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-phone input-fa"></i></div>
                            <input type="text" name="supplier_phone" class="form-control" value="<?php if(isset($supplier_company)){ echo $supplier_telf;}  ?>" placeholder="Supplier Phone">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                            <textarea name="supplier_address" cols="30" rows="2" class="form-control" placeholder="Supplier Address"><?php if(isset($supplier_address)){ echo $supplier_address;}  ?></textarea>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background: #D85050;color: white;"><i class="fa fa-file-word-o input-fa" style="color:white"></i>&nbsp;WR Number</div>
                            <input type="text" name="warehouse_receipt" class="form-control" value="<?php echo $wr; ?>" placeholder="Warehouse Receipt Number">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background:#D85050;"><i class="fa fa-barcode input-fa" style="color:white;"></i></div>
                            <input type="text" name="tracking_number" class="form-control"  placeholder="Tracking Number">
                        </div>
                        <span style="font-size:12px;">* Important to find missing cargos.</span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                            <select data-placeholder="Select Service" name="service" class="form-control select2"  required="">
                              <option value="<?php echo $service; ?>"><?php echo $service; ?></option>
                              <?php if ($service!='Air Service'){ ?>
                              <option value="Air Service">Air Service</option>
                              <?php } ?>

                              <?php if ($service!='Ocean Service'){ ?>
                              <option value="Ocean Service">Ocean Service</option>
                            <?php } ?>

                            <?php if ($service!='Pending'){ ?>
                              <option value="Pending">Pending</option>
                              <?php } ?>
                              
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (1) ↓</label>
                        <input name="image" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="display:none">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (2) ↓</label>
                        <input name="image2" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="display:none">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (3) ↓</label>
                        <input name="image3" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background:#D85050; color:white">Note</div>
                            <textarea name="notes" cols="30" rows="4" class="form-control" placeholder=""></textarea>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
  <?php }else if($step=='2' && $type=='warehouse'){ ?>
    <div class="row" style="margin: 0px;"> 
          <div class="col-md-offset-3 col-md-6 shadow2" style="background: white;margin-top:50px">
            <div class="row">
              <div class="col-md-12 " style="border-bottom:1px solid #555555; padding-bottom:10px;padding-top: 10px;">
                  <h4><span style="font-size:40px;  margin-right:20px; " class="glyphicon glyphicon-file"></span> &nbsp;New Warehouse Ticket</h4>
              </div>
            </div>
            <form action="action/saveTicket.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="warehouse">
              <input type="hidden" name="step" value="2">
              <?php 

                  $consulta2 = mysqli_query($connect, "SELECT a.*, (b.name)c_name,(b.`company`)c_company, (c.`name`)s_name, (c.`company`)s_company, (c.`telf1`)s_telf1,(c.`telf2`)s_telf2,(c.`wechat`)s_wechat,(c.`qq`)s_qq, (c.country)s_country, (c.state)s_state, (c.city)s_city, (c.address_1)s_address_1, (c.address_2)s_address_2 FROM joborders a
                  LEFT JOIN `accounts` b ON a.`client_id`=b.`id`
                  LEFT JOIN `accounts` c ON a.`supplier_id`=c.`id`
                  LEFT JOIN `agents` d ON a.`agent_id`=d.`id` where a.id='$job_id_step1'") or die ("Error al traer los datos");

                    while ($row2 = mysqli_fetch_array($consulta2)){ 
                        $client_id=$row2['client_id'];
                        $supplier_id=$row2['supplier_id'];
                        $customer_company= $row2['c_company'];
                        $customer_name= $row2['c_name']; 
                        $branch= $row2['branch'];
                        $service= $row2['service'];
                        $commodity= $row2['commodity'];
                        $wh_receipt= $row2['wh_receipt'];
                        $remark= $row2['remark'];
                        $supplier_name=$row2['s_name'];
                        $supplier_company=$row2['s_company'];
                        $supplier_address1=$row2['s_address_1'];
                        $supplier_address2=$row2['s_address_2'];
                        $supplier_city=$row2['s_city'];
                        $supplier_state=$row2['s_state'];
                        $supplier_country=$row2['s_country'];
                        $supplier_address= $supplier_address1.' '.$supplier_address2.' | '.$supplier_city.', '.$supplier_state.' - '.$supplier_country.'.';
                        $supplier_telf1=$row2['s_telf1'];
                        $supplier_telf2=$row2['s_telf2'];
                        $supplier_qq=$row2['s_qq'];
                        $supplier_wechat=$row2['s_wechat'];
                        if ($supplier_telf1!='') {$supplier_telf1=' - Mobile: '.$supplier_telf1;}
                        if ($supplier_telf2!='') {$supplier_telf2=' - Office: '.$supplier_telf2;}
                        if ($supplier_qq!='') {$supplier_qq=' - QQ: '.$supplier_qq;}
                        if ($supplier_wechat!='') {$supplier_wechat=' - WeChat: '.$supplier_wechat;}
                        $supplier_telf=$supplier_telf1.$supplier_telf2.$supplier_qq.$supplier_wechat;
                        
                        // $customer= $customer_name.' | '.$customer_company;
                }
              ?>

                <?php $consulta3 = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='$job_id_step1' ORDER BY id desc ") or die ("Error al traer los datos");
                    while ($row3 = mysqli_fetch_array($consulta3)){
                    $wr= $row3['wr'];
                }
              ?>
              <div class="row" style="margin:30px 10px">
                <div class="col-md-12">
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class=" input-group">
                              <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                              <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?>
                                name="agent_id"
                              <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?>
                                disabled
                              <?php } ?> >

                                <?php 

                                $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");

                                  while ($rowList = mysqli_fetch_array($consultaList)){ 

                                  $agent_List=$rowList['name']; ?>
                                    


                                      <option 
                                    <?php if($agent_id==$rowList['id']){ echo "selected";} ?>
                                    value="<?php echo $rowList['id']; ?>"><?php echo $agent_List; ?></option> 
                                    <?php }  ?>
                              </select>
                          </div>
                      </div>
                  </div>
                  <?php if ($level=='Seller'){ ?>
                        <input type="hidden" name="agent_id"  value="<?php echo $agent_id; ?>">
                        
                  <?php } ?>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                            <input type="text" name="name" class="form-control" value="<?php if(isset($customer_name)){echo $customer_name;} ?>" placeholder="Customer or Company Name">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                            <input type="text" name="supplier" class="form-control" value="<?php if(isset($supplier_company)){echo $supplier_company;} ?>" placeholder="Supplier Name">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-phone input-fa"></i></div>
                            <input type="text" name="supplier_phone" class="form-control" value="<?php if(isset($supplier_company)){ echo $supplier_telf;}  ?>" placeholder="Supplier Phone">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                            <textarea name="supplier_address" cols="30" rows="2" class="form-control" placeholder="Supplier Address"><?php if(isset($supplier_address)){ echo $supplier_address;}  ?></textarea>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background: #D85050;color: white;"><i class="fa fa-file-word-o input-fa" style="color:white"></i>&nbsp;WR Number</div>
                            <input type="text" name="warehouse_receipt" class="form-control" value="<?php echo $wr; ?>" placeholder="Warehouse Receipt Number">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background:#D85050;"><i class="fa fa-barcode input-fa" style="color:white;"></i></div>
                            <input type="text" name="tracking_number" class="form-control"  placeholder="Tracking Number">
                        </div>
                        <span style="font-size:12px;">* Required to identify the cargos.</span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                            <select data-placeholder="Select Service" name="service" class="form-control select2"  required="">
                              <option value="<?php echo $service; ?>"><?php echo $service; ?></option>
                              <?php if ($service!='Air Service'){ ?>
                              <option value="Air Service">Air Service</option>
                              <?php } ?>

                              <?php if ($service!='Ocean Service'){ ?>
                              <option value="Ocean Service">Ocean Service</option>
                            <?php } ?>

                            <?php if ($service!='Pending'){ ?>
                              <option value="Pending">Pending</option>
                              <?php } ?>
                        
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (1) ↓</label>
                        <input name="image" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="display:none">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (2) ↓</label>
                        <input name="image2" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row" style="display:none">
                    <div class="col-md-12">
                        <label for="">Tracking Number Photo (3) ↓</label>
                        <input name="image3" class="form-control" type="file">
                        <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:25px;right:12px"></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon" style="background:#D85050; color:white">Note</div>
                            <textarea name="notes" cols="30" rows="4" class="form-control" placeholder=""></textarea>
                            
                        </div>
                        <span style="font-size:12px;">* Important to resolve the inquiry.</span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
  <?php } ?>
      </section>
      <!-- /.content -->
  </div>


<!-- Page script -->
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#tickets_list").addClass("active");
  $("#tickets_list #create").addClass("active");
  setTimeout(fade_out, 3000);
    function fade_out() {
      $("#mydiv").fadeOut().empty();
    }
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });   
  });
</script>


</body>
</html>
