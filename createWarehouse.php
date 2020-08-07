<?php 
error_reporting(0);
require_once('conn.php');   
session_start();
$message= $_GET['message'];
$step= $_GET['step'];
$warehouse_id= $_GET['warehouse_id'];
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
    <title>Latim Cargo & Trading | WareHouse Create</title>
    <link rel="icon" type="image/x-icon" href="icoplane.ico" />
    <!-- CSS -->
    <link href='plugins/select2/select2.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href=" https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href='plugins/datatables/jquery.dataTables.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./plugins/datetimepicker/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="latimstyle.css">
    <link href='assets/css/style.css' rel='stylesheet' type='text/css'>
    <link href='assets/css/imageuploadify.min.css' rel='stylesheet' type='text/css'>
    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>   
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/imageuploadify.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/select2/select2.js"></script>
    <script src="plugins/moment.min.js"></script>
    <script src="./plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
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
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Warehouse 
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Warehouse</li>
      </ol>
    </section>

    <section class="content">

<?php if ($step=='') {$step='1';} ?>

<?php if ($step=='1'){ ?>
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-2 col-md-8 shadow2" style="background: white;margin-top:50px">
          <div class="row" style=" border-bottom:1px solid #555555;">
            <div class="col-md-12" style="margin-top: 20px;">
              <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon span_custom"><img  src="./images/1528723895.png" id="qrcode" alt="qrcode" style="width:50px"></span>
                      <input type="number" name="joborderId" id="joborderId" class="form-control"  placeholder="ID" style="height:64px;font-size:30px;">
                  </div>                            
              </div>
              <div class="col-md-8">
                <h3 style="color:black; font-weight:400; padding:20px; font-size:20px;">CREATE WAREHOUSE RECEIPT</h3>
              </div>
             
            </div>
          </div>
          <form action="action/savewaresthousestep1.php?step=2" id="step1_form"  method="post">
            <div class="row" style="margin:30px 0px">
              <div class="col-md-6">   
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group date form_datetime" data-link-field="fecha">
                            <div class="input-group-addon "><i class="fa fa-calendar input-fa"></i></div>
                            <input type="text" class="form-control "   placeholder="Select date" readonly value="<?php echo date('Y-m-d H:i:s');?>" required >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <input type="hidden" id="fecha"  name="fecha" value="" />
                          </div>
                    </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Supplier</span>
                        <select name="supplier_id" id="" class="form-control select2" data-placeholder="Select Supplier" style="width:100%" required>
                          <option value="">--Select Supplier--</option>
                        <?php 
                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                          or die ("Error al traer los Agent");
                           while ($row = mysqli_fetch_array($consulta)){
                      
                              $ID=$row['id'];
                              $name=$row['name'];
                              $company=$row['company'];
                              $city=$row['city'];
                            
                        ?>
                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                           <?php } ?>
                        </select>
                      <span class="input-group-addon add_btn"><button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus"></i>&nbsp;Add</button></span>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Consignee</span>
                      <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="width:100%" required>
                          <option value="">--Select Consignee--</option>
                        <?php 
                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                          or die ("Error al traer los Agent");
                           while ($row = mysqli_fetch_array($consulta)){
                      
                              $ID=$row['id'];
                              $name=$row['name'];
                              $company=$row['company'];
                              $city=$row['city'];
                            
                        ?>
                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                           <?php } ?>
                        </select>
                      <span class="input-group-addon add_btn"><button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal3"><i class="fa fa-plus"></i>&nbsp;Add</button></span>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Agent</span>
                      <select name="agent_id" id="" class="form-control select2" data-placeholder="Select Agent" style="width:100%" >
                          <option value="">--Select Agent--</option>
                        <?php 
                          $consulta = mysqli_query($connect, "SELECT * FROM agents  where level='Administrator' or level='Seller' order by id ")
                          or die ("Error al traer los Agent");
                           while ($row = mysqli_fetch_array($consulta)){
                      
                              $ID=$row['id'];
                              $name=$row['name'];
                        ?>
                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?></option>
                           <?php } ?>
                        </select>
                    </div>
                  </div>                  
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Bill to</span>
                      <select name="bill_id" id="" class="form-control select2" data-placeholder="Select Bill" style="width:100%" required>
                          <option value="">--Select Bill--</option>
                        <?php 
                          $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                          or die ("Error al traer los Agent");
                           while ($row = mysqli_fetch_array($consulta)){
                      
                              $ID=$row['id'];
                              $name=$row['name'];
                              $company=$row['company'];
                              $city=$row['city'];
                            
                        ?>
                          <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                           <?php } ?>
                        </select>
                        <span class="input-group-addon add_btn"><button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i>&nbsp;Add</button></span>
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Reference</span>
                        <input type="text" name="reference_id" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="">Invoice</span>
                          <input type="text" name="invoice" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-6">                    
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="font-size:12px">Value</span>
                          <input type="text" name="value" class="form-control" placeholder="">
                      </div>
                    </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="">PO</span>
                          <input type="text" name="po" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-6">                    
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="font-size:12px">Marks</span>
                          <input type="text" name="marks" class="form-control" placeholder="">
                      </div>
                    </div>
                </div>                 
                <div class="form-group row">                  
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon span_custom" style="font-size:12px">Delivered By</span>
                          <input type="text" name="delivered_by1" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">                    
                          <input type="text" name="delivered_by2" class="form-control" placeholder="">
                    </div>
                </div>                
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Tracking</span>
                        <textarea name="tracking" class="form-control" id="2" cols="30" rows="2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom" style="font-size: 13px;">Description</span>
                        <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Comments</span>
                        <textarea name="comments" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6"> 
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Branch</span>
                        <input type="text" name="branch" class="form-control" placeholder="Branch">
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom" style="font-size:10px">Pickup Number</span>
                        <input type="text" name="pickup_number" class="form-control" placeholder="Pickup Number">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Location</span>
                          <input type="text" name="location1" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">                    
                          <input type="text" name="location2" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Can</span>
                          <input type="text" name="can" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">                    
                      <label  class="control-label"><input type="checkbox" name="distribution">&nbsp;Distribution</label>
                    </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom" style="font-size:13px;">Destination</span>
                        <input type="text" name="destination" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Service</span>
                          <select name="instination" id="" class="form-control select2"  data-placeholder="Select Service">
                            <option value="">Select Service</option>
                            <option value="Pending">Pending</option>
                            <option value="Air door to door">Air door to door</option>
                            <option value="Air Service">Air Service</option>
                            <option value="Ocean door to door">Ocean door to door</option>
                            <option value="Ocean Service">Ocean Service</option>
                          </select>
                      </div>
                    </div>                  
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Terms</span>
                        <input type="text" name="terms" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon span_custom">Condition</span>
                        <input type="text" name="condition2" class="form-control" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="form-group row">                  
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon span_custom">Status</span>
                          <select name="status" id="" class="form-control select2"  data-placeholder="Select Status">
                            <option value="">Select Status</option>
                            <option value="PRE-ALERT">PRE-ALERT</option>
                            <option value="RECIBIDO EN BODEGA CHINA">RECIBIDO EN BODEGA CHINA</option>
                            <option value="RETURNED">RETURNED</option>
                            <option value="TRANSITO">TRANSITO</option>
                            <option value="EN DESTINO / PUERTO MARITIMO">EN DESTINO / PUERTO MARITIMO</option>
                            <option value="CARGA ENTREGADA">CARGA ENTREGADA</option>
                            <option value="RECIBIDO EN VALENCIA">RECIBIDO EN VALENCIA</option>
                            <option value="COMUNICADO">COMUNICADO</option>
                            <option value="EN DESTINO / AEROPUERTO">EN DESTINO / AEROPUERTO</option>
                            <option value="RECIBIDO EN ALMACEN CARACAS">RECIBIDO EN ALMACEN CARACAS</option>
                          </select>
                      </div>
                    </div>                  
                </div>                
                <div class="form-group row">
                  <label class="control-label col-md-4" ></label>
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox" name="dangerous_goods" >&nbsp;Dangerous Goods</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox"  name="seo" >&nbsp;SED</label>
                          <label class="control-label radio-inline"><input type="checkbox"  name="fragile">&nbsp;FRAGILE</label>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="col-md-12">
                          <label class="control-label radio-inline"><input type="checkbox"  name="insurance" >&nbsp;Insurance</label>
                        </div>
                      </div> 
                    </div>                   
                </div>
              </div>
            </div>
            <div class="row" style="padding-bottom:30px">
                  <div class="col-md-12 text-right">
                      <button type="submit" class="btn btn-success" >Next&nbsp;<i class="fa fa fa-chevron-right"></i></button>
                  </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add new supplier</h4>
                </div>
                <form action="action/saveSupplierStep1waresthouse.php" method="POST">
                <div class="modal-body">                    

                        <input name="customer" value="<?php echo $customer; ?>" type="hidden">                      

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                            <input name="company" type="text" class="form-control" placeholder="Company Name">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                            <input name="name" type="text" class="form-control" placeholder="Contact Person">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_1" type="text" class="form-control" placeholder="Address 1">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_2" type="text" class="form-control" placeholder="Address 2">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="city" type="text" class="form-control" placeholder="City">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="state" type="text" class="form-control" placeholder="State">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
                            <select name="country" class="form-control select2" style="width:100%;" required="required">
                              <option value="">Select Country</option>
                              <option value="CN">China</option>
                              <option value="VE">Venezuela</option>
                              <option value="PY">Paraguay</option>
                              <option value="AR">Argentina</option>
                              <option value="US">United States</option>
                              <option value=""></option>
                              <option value="">-------------------</option>
                              <option value=""></option>
                              <option value="AF">Afghanistan</option>
                              <option value="AX">Åland Islands</option>
                              <option value="AL">Albania</option>
                              <option value="DZ">Algeria</option>
                              <option value="AS">American Samoa</option>
                              <option value="AD">Andorra</option>
                              <option value="AO">Angola</option>
                              <option value="AI">Anguilla</option>
                              <option value="AQ">Antarctica</option>
                              <option value="AG">Antigua and Barbuda</option>
                              
                              <option value="AM">Armenia</option>
                              <option value="AW">Aruba</option>
                              <option value="AU">Australia</option>
                              <option value="AT">Austria</option>
                              <option value="AZ">Azerbaijan</option>
                              <option value="BS">Bahamas</option>
                              <option value="BH">Bahrain</option>
                              <option value="BD">Bangladesh</option>
                              <option value="BB">Barbados</option>
                              <option value="BY">Belarus</option>
                              <option value="BE">Belgium</option>
                              <option value="BZ">Belize</option>
                              <option value="BJ">Benin</option>
                              <option value="BM">Bermuda</option>
                              <option value="BT">Bhutan</option>
                              <option value="BO">Bolivia, Plurinational State of</option>
                              <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                              <option value="BA">Bosnia and Herzegovina</option>
                              <option value="BW">Botswana</option>
                              <option value="BV">Bouvet Island</option>
                              <option value="BR">Brazil</option>
                              <option value="IO">British Indian Ocean Territory</option>
                              <option value="BN">Brunei Darussalam</option>
                              <option value="BG">Bulgaria</option>
                              <option value="BF">Burkina Faso</option>
                              <option value="BI">Burundi</option>
                              <option value="KH">Cambodia</option>
                              <option value="CM">Cameroon</option>
                              <option value="CA">Canada</option>
                              <option value="CV">Cape Verde</option>
                              <option value="KY">Cayman Islands</option>
                              <option value="CF">Central African Republic</option>
                              <option value="TD">Chad</option>
                              <option value="CL">Chile</option>                              
                              <option value="CX">Christmas Island</option>
                              <option value="CC">Cocos (Keeling) Islands</option>
                              <option value="CO">Colombia</option>
                              <option value="KM">Comoros</option>
                              <option value="CG">Congo</option>
                              <option value="CD">Congo, the Democratic Republic of the</option>
                              <option value="CK">Cook Islands</option>
                              <option value="CR">Costa Rica</option>
                              <option value="CI">Côte d'Ivoire</option>
                              <option value="HR">Croatia</option>
                              <option value="CU">Cuba</option>
                              <option value="CW">Curaçao</option>
                              <option value="CY">Cyprus</option>
                              <option value="CZ">Czech Republic</option>
                              <option value="DK">Denmark</option>
                              <option value="DJ">Djibouti</option>
                              <option value="DM">Dominica</option>
                              <option value="DO">Dominican Republic</option>
                              <option value="EC">Ecuador</option>
                              <option value="EG">Egypt</option>
                              <option value="SV">El Salvador</option>
                              <option value="GQ">Equatorial Guinea</option>
                              <option value="ER">Eritrea</option>
                              <option value="EE">Estonia</option>
                              <option value="ET">Ethiopia</option>
                              <option value="FK">Falkland Islands (Malvinas)</option>
                              <option value="FO">Faroe Islands</option>
                              <option value="FJ">Fiji</option>
                              <option value="FI">Finland</option>
                              <option value="FR">France</option>
                              <option value="GF">French Guiana</option>
                              <option value="PF">French Polynesia</option>
                              <option value="TF">French Southern Territories</option>
                              <option value="GA">Gabon</option>
                              <option value="GM">Gambia</option>
                              <option value="GE">Georgia</option>
                              <option value="DE">Germany</option>
                              <option value="GH">Ghana</option>
                              <option value="GI">Gibraltar</option>
                              <option value="GR">Greece</option>
                              <option value="GL">Greenland</option>
                              <option value="GD">Grenada</option>
                              <option value="GP">Guadeloupe</option>
                              <option value="GU">Guam</option>
                              <option value="GT">Guatemala</option>
                              <option value="GG">Guernsey</option>
                              <option value="GN">Guinea</option>
                              <option value="GW">Guinea-Bissau</option>
                              <option value="GY">Guyana</option>
                              <option value="HT">Haiti</option>
                              <option value="HM">Heard Island and McDonald Islands</option>
                              <option value="VA">Holy See (Vatican City State)</option>
                              <option value="HN">Honduras</option>
                              <option value="HK">Hong Kong</option>
                              <option value="HU">Hungary</option>
                              <option value="IS">Iceland</option>
                              <option value="IN">India</option>
                              <option value="ID">Indonesia</option>
                              <option value="IR">Iran, Islamic Republic of</option>
                              <option value="IQ">Iraq</option>
                              <option value="IE">Ireland</option>
                              <option value="IM">Isle of Man</option>
                              <option value="IL">Israel</option>
                              <option value="IT">Italy</option>
                              <option value="JM">Jamaica</option>
                              <option value="JP">Japan</option>
                              <option value="JE">Jersey</option>
                              <option value="JO">Jordan</option>
                              <option value="KZ">Kazakhstan</option>
                              <option value="KE">Kenya</option>
                              <option value="KI">Kiribati</option>
                              <option value="KP">Korea, Democratic People's Republic of</option>
                              <option value="KR">Korea, Republic of</option>
                              <option value="KW">Kuwait</option>
                              <option value="KG">Kyrgyzstan</option>
                              <option value="LA">Lao People's Democratic Republic</option>
                              <option value="LV">Latvia</option>
                              <option value="LB">Lebanon</option>
                              <option value="LS">Lesotho</option>
                              <option value="LR">Liberia</option>
                              <option value="LY">Libya</option>
                              <option value="LI">Liechtenstein</option>
                              <option value="LT">Lithuania</option>
                              <option value="LU">Luxembourg</option>
                              <option value="MO">Macao</option>
                              <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                              <option value="MG">Madagascar</option>
                              <option value="MW">Malawi</option>
                              <option value="MY">Malaysia</option>
                              <option value="MV">Maldives</option>
                              <option value="ML">Mali</option>
                              <option value="MT">Malta</option>
                              <option value="MH">Marshall Islands</option>
                              <option value="MQ">Martinique</option>
                              <option value="MR">Mauritania</option>
                              <option value="MU">Mauritius</option>
                              <option value="YT">Mayotte</option>
                              <option value="MX">Mexico</option>
                              <option value="FM">Micronesia, Federated States of</option>
                              <option value="MD">Moldova, Republic of</option>
                              <option value="MC">Monaco</option>
                              <option value="MN">Mongolia</option>
                              <option value="ME">Montenegro</option>
                              <option value="MS">Montserrat</option>
                              <option value="MA">Morocco</option>
                              <option value="MZ">Mozambique</option>
                              <option value="MM">Myanmar</option>
                              <option value="NA">Namibia</option>
                              <option value="NR">Nauru</option>
                              <option value="NP">Nepal</option>
                              <option value="NL">Netherlands</option>
                              <option value="NC">New Caledonia</option>
                              <option value="NZ">New Zealand</option>
                              <option value="NI">Nicaragua</option>
                              <option value="NE">Niger</option>
                              <option value="NG">Nigeria</option>
                              <option value="NU">Niue</option>
                              <option value="NF">Norfolk Island</option>
                              <option value="MP">Northern Mariana Islands</option>
                              <option value="NO">Norway</option>
                              <option value="OM">Oman</option>
                              <option value="PK">Pakistan</option>
                              <option value="PW">Palau</option>
                              <option value="PS">Palestinian Territory, Occupied</option>
                              <option value="PA">Panama</option>
                              <option value="PG">Papua New Guinea</option>
                              
                              <option value="PE">Peru</option>
                              <option value="PH">Philippines</option>
                              <option value="PN">Pitcairn</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="PR">Puerto Rico</option>
                              <option value="QA">Qatar</option>
                              <option value="RE">Réunion</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russian Federation</option>
                              <option value="RW">Rwanda</option>
                              <option value="BL">Saint Barthélemy</option>
                              <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                              <option value="KN">Saint Kitts and Nevis</option>
                              <option value="LC">Saint Lucia</option>
                              <option value="MF">Saint Martin (French part)</option>
                              <option value="PM">Saint Pierre and Miquelon</option>
                              <option value="VC">Saint Vincent and the Grenadines</option>
                              <option value="WS">Samoa</option>
                              <option value="SM">San Marino</option>
                              <option value="ST">Sao Tome and Principe</option>
                              <option value="SA">Saudi Arabia</option>
                              <option value="SN">Senegal</option>
                              <option value="RS">Serbia</option>
                              <option value="SC">Seychelles</option>
                              <option value="SL">Sierra Leone</option>
                              <option value="SG">Singapore</option>
                              <option value="SX">Sint Maarten (Dutch part)</option>
                              <option value="SK">Slovakia</option>
                              <option value="SI">Slovenia</option>
                              <option value="SB">Solomon Islands</option>
                              <option value="SO">Somalia</option>
                              <option value="ZA">South Africa</option>
                              <option value="GS">South Georgia and the South Sandwich Islands</option>
                              <option value="SS">South Sudan</option>
                              <option value="ES">Spain</option>
                              <option value="LK">Sri Lanka</option>
                              <option value="SD">Sudan</option>
                              <option value="SR">Suriname</option>
                              <option value="SJ">Svalbard and Jan Mayen</option>
                              <option value="SZ">Swaziland</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="SY">Syrian Arab Republic</option>
                              <option value="TW">Taiwan, Province of China</option>
                              <option value="TJ">Tajikistan</option>
                              <option value="TZ">Tanzania, United Republic of</option>
                              <option value="TH">Thailand</option>
                              <option value="TL">Timor-Leste</option>
                              <option value="TG">Togo</option>
                              <option value="TK">Tokelau</option>
                              <option value="TO">Tonga</option>
                              <option value="TT">Trinidad and Tobago</option>
                              <option value="TN">Tunisia</option>
                              <option value="TR">Turkey</option>
                              <option value="TM">Turkmenistan</option>
                              <option value="TC">Turks and Caicos Islands</option>
                              <option value="TV">Tuvalu</option>
                              <option value="UG">Uganda</option>
                              <option value="UA">Ukraine</option>
                              <option value="AE">United Arab Emirates</option>
                              <option value="GB">United Kingdom</option>
                              
                              <option value="UM">United States Minor Outlying Islands</option>
                              <option value="UY">Uruguay</option>
                              <option value="UZ">Uzbekistan</option>
                              <option value="VU">Vanuatu</option>
                              
                              <option value="VN">Viet Nam</option>
                              <option value="VG">Virgin Islands, British</option>
                              <option value="VI">Virgin Islands, U.S.</option>
                              <option value="WF">Wallis and Futuna</option>
                              <option value="EH">Western Sahara</option>
                              <option value="YE">Yemen</option>
                              <option value="ZM">Zambia</option>
                              <option value="ZW">Zimbabwe</option>
                          </select>
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf1" type="text" class="form-control" placeholder="Mobile">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf2" type="text" class="form-control" placeholder="Office">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="qq" type="text" class="form-control" placeholder="QQ">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="wechat" type="text" class="form-control" placeholder="WeChat">
                        </div>



                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
                            <input name="email" type="text" class="form-control" placeholder="E-mail">
                        </div>

                        <!-- radio -->
                        <div class="input-group" style="margin-top:20px;">

                            <label>
                              <input type="radio" name="type" value="Supplier" class="flat-red" required="required" checked>
                              <label>Supplier</label>
                            </label>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background:#B80008; border:none; height:40px; border-radius:2px; color:white; position:relative; left:-30px; width:100px;" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="form_1_submit" style="top:0px; background:#007F46;">

                    
                </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add new Bill</h4>
                </div>
                <form action="action/saveClientStep1waresthouse.php" method="POST">
                    <div class="modal-body">                    

                        <div class="input-group">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-circle"></i></span>
                            <select data-placeholder="Select Agent" <?php if ($level!='Seller' ){ ?> name="agent_name"
                                <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?> disabled <?php } ?>
                                style="width:100%;">

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
                            <input type="text" name="agent_name" type="hidden" value="<?php echo $agent_name; ?>">
                            <?php } ?>



                        </div>
                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                            <input name="company" type="text" class="form-control" placeholder="Company Name">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                            <input name="name" type="text" class="form-control" placeholder="Contact Person">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_1" type="text" class="form-control" placeholder="Address 1">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_2" type="text" class="form-control" placeholder="Address 2">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="city" type="text" class="form-control" placeholder="City">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="state" type="text" class="form-control" placeholder="State">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
                            <select name="country" class="form-control select2" style="width:100%;" required="required">
                              <option value="">Select Country</option>
                              <option value="CN">China</option>
                              <option value="VE">Venezuela</option>
                              <option value="PY">Paraguay</option>
                              <option value="AR">Argentina</option>
                              <option value="US">United States</option>
                              <option value=""></option>
                              <option value="">-------------------</option>
                              <option value=""></option>
                              <option value="AF">Afghanistan</option>
                              <option value="AX">Åland Islands</option>
                              <option value="AL">Albania</option>
                              <option value="DZ">Algeria</option>
                              <option value="AS">American Samoa</option>
                              <option value="AD">Andorra</option>
                              <option value="AO">Angola</option>
                              <option value="AI">Anguilla</option>
                              <option value="AQ">Antarctica</option>
                              <option value="AG">Antigua and Barbuda</option>
                              
                              <option value="AM">Armenia</option>
                              <option value="AW">Aruba</option>
                              <option value="AU">Australia</option>
                              <option value="AT">Austria</option>
                              <option value="AZ">Azerbaijan</option>
                              <option value="BS">Bahamas</option>
                              <option value="BH">Bahrain</option>
                              <option value="BD">Bangladesh</option>
                              <option value="BB">Barbados</option>
                              <option value="BY">Belarus</option>
                              <option value="BE">Belgium</option>
                              <option value="BZ">Belize</option>
                              <option value="BJ">Benin</option>
                              <option value="BM">Bermuda</option>
                              <option value="BT">Bhutan</option>
                              <option value="BO">Bolivia, Plurinational State of</option>
                              <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                              <option value="BA">Bosnia and Herzegovina</option>
                              <option value="BW">Botswana</option>
                              <option value="BV">Bouvet Island</option>
                              <option value="BR">Brazil</option>
                              <option value="IO">British Indian Ocean Territory</option>
                              <option value="BN">Brunei Darussalam</option>
                              <option value="BG">Bulgaria</option>
                              <option value="BF">Burkina Faso</option>
                              <option value="BI">Burundi</option>
                              <option value="KH">Cambodia</option>
                              <option value="CM">Cameroon</option>
                              <option value="CA">Canada</option>
                              <option value="CV">Cape Verde</option>
                              <option value="KY">Cayman Islands</option>
                              <option value="CF">Central African Republic</option>
                              <option value="TD">Chad</option>
                              <option value="CL">Chile</option>
                              
                              <option value="CX">Christmas Island</option>
                              <option value="CC">Cocos (Keeling) Islands</option>
                              <option value="CO">Colombia</option>
                              <option value="KM">Comoros</option>
                              <option value="CG">Congo</option>
                              <option value="CD">Congo, the Democratic Republic of the</option>
                              <option value="CK">Cook Islands</option>
                              <option value="CR">Costa Rica</option>
                              <option value="CI">Côte d'Ivoire</option>
                              <option value="HR">Croatia</option>
                              <option value="CU">Cuba</option>
                              <option value="CW">Curaçao</option>
                              <option value="CY">Cyprus</option>
                              <option value="CZ">Czech Republic</option>
                              <option value="DK">Denmark</option>
                              <option value="DJ">Djibouti</option>
                              <option value="DM">Dominica</option>
                              <option value="DO">Dominican Republic</option>
                              <option value="EC">Ecuador</option>
                              <option value="EG">Egypt</option>
                              <option value="SV">El Salvador</option>
                              <option value="GQ">Equatorial Guinea</option>
                              <option value="ER">Eritrea</option>
                              <option value="EE">Estonia</option>
                              <option value="ET">Ethiopia</option>
                              <option value="FK">Falkland Islands (Malvinas)</option>
                              <option value="FO">Faroe Islands</option>
                              <option value="FJ">Fiji</option>
                              <option value="FI">Finland</option>
                              <option value="FR">France</option>
                              <option value="GF">French Guiana</option>
                              <option value="PF">French Polynesia</option>
                              <option value="TF">French Southern Territories</option>
                              <option value="GA">Gabon</option>
                              <option value="GM">Gambia</option>
                              <option value="GE">Georgia</option>
                              <option value="DE">Germany</option>
                              <option value="GH">Ghana</option>
                              <option value="GI">Gibraltar</option>
                              <option value="GR">Greece</option>
                              <option value="GL">Greenland</option>
                              <option value="GD">Grenada</option>
                              <option value="GP">Guadeloupe</option>
                              <option value="GU">Guam</option>
                              <option value="GT">Guatemala</option>
                              <option value="GG">Guernsey</option>
                              <option value="GN">Guinea</option>
                              <option value="GW">Guinea-Bissau</option>
                              <option value="GY">Guyana</option>
                              <option value="HT">Haiti</option>
                              <option value="HM">Heard Island and McDonald Islands</option>
                              <option value="VA">Holy See (Vatican City State)</option>
                              <option value="HN">Honduras</option>
                              <option value="HK">Hong Kong</option>
                              <option value="HU">Hungary</option>
                              <option value="IS">Iceland</option>
                              <option value="IN">India</option>
                              <option value="ID">Indonesia</option>
                              <option value="IR">Iran, Islamic Republic of</option>
                              <option value="IQ">Iraq</option>
                              <option value="IE">Ireland</option>
                              <option value="IM">Isle of Man</option>
                              <option value="IL">Israel</option>
                              <option value="IT">Italy</option>
                              <option value="JM">Jamaica</option>
                              <option value="JP">Japan</option>
                              <option value="JE">Jersey</option>
                              <option value="JO">Jordan</option>
                              <option value="KZ">Kazakhstan</option>
                              <option value="KE">Kenya</option>
                              <option value="KI">Kiribati</option>
                              <option value="KP">Korea, Democratic People's Republic of</option>
                              <option value="KR">Korea, Republic of</option>
                              <option value="KW">Kuwait</option>
                              <option value="KG">Kyrgyzstan</option>
                              <option value="LA">Lao People's Democratic Republic</option>
                              <option value="LV">Latvia</option>
                              <option value="LB">Lebanon</option>
                              <option value="LS">Lesotho</option>
                              <option value="LR">Liberia</option>
                              <option value="LY">Libya</option>
                              <option value="LI">Liechtenstein</option>
                              <option value="LT">Lithuania</option>
                              <option value="LU">Luxembourg</option>
                              <option value="MO">Macao</option>
                              <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                              <option value="MG">Madagascar</option>
                              <option value="MW">Malawi</option>
                              <option value="MY">Malaysia</option>
                              <option value="MV">Maldives</option>
                              <option value="ML">Mali</option>
                              <option value="MT">Malta</option>
                              <option value="MH">Marshall Islands</option>
                              <option value="MQ">Martinique</option>
                              <option value="MR">Mauritania</option>
                              <option value="MU">Mauritius</option>
                              <option value="YT">Mayotte</option>
                              <option value="MX">Mexico</option>
                              <option value="FM">Micronesia, Federated States of</option>
                              <option value="MD">Moldova, Republic of</option>
                              <option value="MC">Monaco</option>
                              <option value="MN">Mongolia</option>
                              <option value="ME">Montenegro</option>
                              <option value="MS">Montserrat</option>
                              <option value="MA">Morocco</option>
                              <option value="MZ">Mozambique</option>
                              <option value="MM">Myanmar</option>
                              <option value="NA">Namibia</option>
                              <option value="NR">Nauru</option>
                              <option value="NP">Nepal</option>
                              <option value="NL">Netherlands</option>
                              <option value="NC">New Caledonia</option>
                              <option value="NZ">New Zealand</option>
                              <option value="NI">Nicaragua</option>
                              <option value="NE">Niger</option>
                              <option value="NG">Nigeria</option>
                              <option value="NU">Niue</option>
                              <option value="NF">Norfolk Island</option>
                              <option value="MP">Northern Mariana Islands</option>
                              <option value="NO">Norway</option>
                              <option value="OM">Oman</option>
                              <option value="PK">Pakistan</option>
                              <option value="PW">Palau</option>
                              <option value="PS">Palestinian Territory, Occupied</option>
                              <option value="PA">Panama</option>
                              <option value="PG">Papua New Guinea</option>
                              
                              <option value="PE">Peru</option>
                              <option value="PH">Philippines</option>
                              <option value="PN">Pitcairn</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="PR">Puerto Rico</option>
                              <option value="QA">Qatar</option>
                              <option value="RE">Réunion</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russian Federation</option>
                              <option value="RW">Rwanda</option>
                              <option value="BL">Saint Barthélemy</option>
                              <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                              <option value="KN">Saint Kitts and Nevis</option>
                              <option value="LC">Saint Lucia</option>
                              <option value="MF">Saint Martin (French part)</option>
                              <option value="PM">Saint Pierre and Miquelon</option>
                              <option value="VC">Saint Vincent and the Grenadines</option>
                              <option value="WS">Samoa</option>
                              <option value="SM">San Marino</option>
                              <option value="ST">Sao Tome and Principe</option>
                              <option value="SA">Saudi Arabia</option>
                              <option value="SN">Senegal</option>
                              <option value="RS">Serbia</option>
                              <option value="SC">Seychelles</option>
                              <option value="SL">Sierra Leone</option>
                              <option value="SG">Singapore</option>
                              <option value="SX">Sint Maarten (Dutch part)</option>
                              <option value="SK">Slovakia</option>
                              <option value="SI">Slovenia</option>
                              <option value="SB">Solomon Islands</option>
                              <option value="SO">Somalia</option>
                              <option value="ZA">South Africa</option>
                              <option value="GS">South Georgia and the South Sandwich Islands</option>
                              <option value="SS">South Sudan</option>
                              <option value="ES">Spain</option>
                              <option value="LK">Sri Lanka</option>
                              <option value="SD">Sudan</option>
                              <option value="SR">Suriname</option>
                              <option value="SJ">Svalbard and Jan Mayen</option>
                              <option value="SZ">Swaziland</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="SY">Syrian Arab Republic</option>
                              <option value="TW">Taiwan, Province of China</option>
                              <option value="TJ">Tajikistan</option>
                              <option value="TZ">Tanzania, United Republic of</option>
                              <option value="TH">Thailand</option>
                              <option value="TL">Timor-Leste</option>
                              <option value="TG">Togo</option>
                              <option value="TK">Tokelau</option>
                              <option value="TO">Tonga</option>
                              <option value="TT">Trinidad and Tobago</option>
                              <option value="TN">Tunisia</option>
                              <option value="TR">Turkey</option>
                              <option value="TM">Turkmenistan</option>
                              <option value="TC">Turks and Caicos Islands</option>
                              <option value="TV">Tuvalu</option>
                              <option value="UG">Uganda</option>
                              <option value="UA">Ukraine</option>
                              <option value="AE">United Arab Emirates</option>
                              <option value="GB">United Kingdom</option>
                              
                              <option value="UM">United States Minor Outlying Islands</option>
                              <option value="UY">Uruguay</option>
                              <option value="UZ">Uzbekistan</option>
                              <option value="VU">Vanuatu</option>
                              
                              <option value="VN">Viet Nam</option>
                              <option value="VG">Virgin Islands, British</option>
                              <option value="VI">Virgin Islands, U.S.</option>
                              <option value="WF">Wallis and Futuna</option>
                              <option value="EH">Western Sahara</option>
                              <option value="YE">Yemen</option>
                              <option value="ZM">Zambia</option>
                              <option value="ZW">Zimbabwe</option>
                          </select>
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf1" type="text" class="form-control" placeholder="Mobile">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf2" type="text" class="form-control" placeholder="Office">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="qq" type="text" class="form-control" placeholder="QQ">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="wechat" type="text" class="form-control" placeholder="WeChat">
                        </div>



                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
                            <input name="email" type="text" class="form-control" placeholder="E-mail">
                        </div>

                        <!-- radio -->
                        <div class="input-group" style="margin-top:20px;">

                            <label>
                              <input type="radio" name="type" value="Client" class="flat-red" required="required" checked>
                              <label>Client</label>
                            </label>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background:#B80008; border:none; height:40px; border-radius:2px; color:white; position:relative; left:-30px; width:100px;" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="form_1_submit" style="top:0px; background:#007F46;">

                    
                </div>
                </form>
            </div>
        </div>
      </div>
      <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add new Consignee</h4>
                </div>
                <form action="action/saveConsigneeStep1waresthouse.php" method="POST">
                      <div class="modal-body">
                         <div class="input-group">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-circle"></i></span>
                            <select data-placeholder="Select Agent" <?php if ($level!='Seller' ){ ?> name="agent_name"
                                <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?> disabled <?php } ?>
                                style="width:100%;">

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
                            <input type="text" name="agent_name" type="hidden" value="<?php echo $agent_name; ?>">
                            <?php } ?>



                        </div>
                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                            <input name="company" type="text" class="form-control" placeholder="Company Name">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                            <input name="name" type="text" class="form-control" placeholder="Contact Person">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_1" type="text" class="form-control" placeholder="Address 1">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_2" type="text" class="form-control" placeholder="Address 2">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="city" type="text" class="form-control" placeholder="City">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="state" type="text" class="form-control" placeholder="State">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
                            <select name="country" class="form-control select2" style="width:100%;" required="required">
                              <option value="">Select Country</option>
                              <option value="CN">China</option>
                              <option value="VE">Venezuela</option>
                              <option value="PY">Paraguay</option>
                              <option value="AR">Argentina</option>
                              <option value="US">United States</option>
                              <option value=""></option>
                              <option value="">-------------------</option>
                              <option value=""></option>
                              <option value="AF">Afghanistan</option>
                              <option value="AX">Åland Islands</option>
                              <option value="AL">Albania</option>
                              <option value="DZ">Algeria</option>
                              <option value="AS">American Samoa</option>
                              <option value="AD">Andorra</option>
                              <option value="AO">Angola</option>
                              <option value="AI">Anguilla</option>
                              <option value="AQ">Antarctica</option>
                              <option value="AG">Antigua and Barbuda</option>
                              
                              <option value="AM">Armenia</option>
                              <option value="AW">Aruba</option>
                              <option value="AU">Australia</option>
                              <option value="AT">Austria</option>
                              <option value="AZ">Azerbaijan</option>
                              <option value="BS">Bahamas</option>
                              <option value="BH">Bahrain</option>
                              <option value="BD">Bangladesh</option>
                              <option value="BB">Barbados</option>
                              <option value="BY">Belarus</option>
                              <option value="BE">Belgium</option>
                              <option value="BZ">Belize</option>
                              <option value="BJ">Benin</option>
                              <option value="BM">Bermuda</option>
                              <option value="BT">Bhutan</option>
                              <option value="BO">Bolivia, Plurinational State of</option>
                              <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                              <option value="BA">Bosnia and Herzegovina</option>
                              <option value="BW">Botswana</option>
                              <option value="BV">Bouvet Island</option>
                              <option value="BR">Brazil</option>
                              <option value="IO">British Indian Ocean Territory</option>
                              <option value="BN">Brunei Darussalam</option>
                              <option value="BG">Bulgaria</option>
                              <option value="BF">Burkina Faso</option>
                              <option value="BI">Burundi</option>
                              <option value="KH">Cambodia</option>
                              <option value="CM">Cameroon</option>
                              <option value="CA">Canada</option>
                              <option value="CV">Cape Verde</option>
                              <option value="KY">Cayman Islands</option>
                              <option value="CF">Central African Republic</option>
                              <option value="TD">Chad</option>
                              <option value="CL">Chile</option>
                              
                              <option value="CX">Christmas Island</option>
                              <option value="CC">Cocos (Keeling) Islands</option>
                              <option value="CO">Colombia</option>
                              <option value="KM">Comoros</option>
                              <option value="CG">Congo</option>
                              <option value="CD">Congo, the Democratic Republic of the</option>
                              <option value="CK">Cook Islands</option>
                              <option value="CR">Costa Rica</option>
                              <option value="CI">Côte d'Ivoire</option>
                              <option value="HR">Croatia</option>
                              <option value="CU">Cuba</option>
                              <option value="CW">Curaçao</option>
                              <option value="CY">Cyprus</option>
                              <option value="CZ">Czech Republic</option>
                              <option value="DK">Denmark</option>
                              <option value="DJ">Djibouti</option>
                              <option value="DM">Dominica</option>
                              <option value="DO">Dominican Republic</option>
                              <option value="EC">Ecuador</option>
                              <option value="EG">Egypt</option>
                              <option value="SV">El Salvador</option>
                              <option value="GQ">Equatorial Guinea</option>
                              <option value="ER">Eritrea</option>
                              <option value="EE">Estonia</option>
                              <option value="ET">Ethiopia</option>
                              <option value="FK">Falkland Islands (Malvinas)</option>
                              <option value="FO">Faroe Islands</option>
                              <option value="FJ">Fiji</option>
                              <option value="FI">Finland</option>
                              <option value="FR">France</option>
                              <option value="GF">French Guiana</option>
                              <option value="PF">French Polynesia</option>
                              <option value="TF">French Southern Territories</option>
                              <option value="GA">Gabon</option>
                              <option value="GM">Gambia</option>
                              <option value="GE">Georgia</option>
                              <option value="DE">Germany</option>
                              <option value="GH">Ghana</option>
                              <option value="GI">Gibraltar</option>
                              <option value="GR">Greece</option>
                              <option value="GL">Greenland</option>
                              <option value="GD">Grenada</option>
                              <option value="GP">Guadeloupe</option>
                              <option value="GU">Guam</option>
                              <option value="GT">Guatemala</option>
                              <option value="GG">Guernsey</option>
                              <option value="GN">Guinea</option>
                              <option value="GW">Guinea-Bissau</option>
                              <option value="GY">Guyana</option>
                              <option value="HT">Haiti</option>
                              <option value="HM">Heard Island and McDonald Islands</option>
                              <option value="VA">Holy See (Vatican City State)</option>
                              <option value="HN">Honduras</option>
                              <option value="HK">Hong Kong</option>
                              <option value="HU">Hungary</option>
                              <option value="IS">Iceland</option>
                              <option value="IN">India</option>
                              <option value="ID">Indonesia</option>
                              <option value="IR">Iran, Islamic Republic of</option>
                              <option value="IQ">Iraq</option>
                              <option value="IE">Ireland</option>
                              <option value="IM">Isle of Man</option>
                              <option value="IL">Israel</option>
                              <option value="IT">Italy</option>
                              <option value="JM">Jamaica</option>
                              <option value="JP">Japan</option>
                              <option value="JE">Jersey</option>
                              <option value="JO">Jordan</option>
                              <option value="KZ">Kazakhstan</option>
                              <option value="KE">Kenya</option>
                              <option value="KI">Kiribati</option>
                              <option value="KP">Korea, Democratic People's Republic of</option>
                              <option value="KR">Korea, Republic of</option>
                              <option value="KW">Kuwait</option>
                              <option value="KG">Kyrgyzstan</option>
                              <option value="LA">Lao People's Democratic Republic</option>
                              <option value="LV">Latvia</option>
                              <option value="LB">Lebanon</option>
                              <option value="LS">Lesotho</option>
                              <option value="LR">Liberia</option>
                              <option value="LY">Libya</option>
                              <option value="LI">Liechtenstein</option>
                              <option value="LT">Lithuania</option>
                              <option value="LU">Luxembourg</option>
                              <option value="MO">Macao</option>
                              <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                              <option value="MG">Madagascar</option>
                              <option value="MW">Malawi</option>
                              <option value="MY">Malaysia</option>
                              <option value="MV">Maldives</option>
                              <option value="ML">Mali</option>
                              <option value="MT">Malta</option>
                              <option value="MH">Marshall Islands</option>
                              <option value="MQ">Martinique</option>
                              <option value="MR">Mauritania</option>
                              <option value="MU">Mauritius</option>
                              <option value="YT">Mayotte</option>
                              <option value="MX">Mexico</option>
                              <option value="FM">Micronesia, Federated States of</option>
                              <option value="MD">Moldova, Republic of</option>
                              <option value="MC">Monaco</option>
                              <option value="MN">Mongolia</option>
                              <option value="ME">Montenegro</option>
                              <option value="MS">Montserrat</option>
                              <option value="MA">Morocco</option>
                              <option value="MZ">Mozambique</option>
                              <option value="MM">Myanmar</option>
                              <option value="NA">Namibia</option>
                              <option value="NR">Nauru</option>
                              <option value="NP">Nepal</option>
                              <option value="NL">Netherlands</option>
                              <option value="NC">New Caledonia</option>
                              <option value="NZ">New Zealand</option>
                              <option value="NI">Nicaragua</option>
                              <option value="NE">Niger</option>
                              <option value="NG">Nigeria</option>
                              <option value="NU">Niue</option>
                              <option value="NF">Norfolk Island</option>
                              <option value="MP">Northern Mariana Islands</option>
                              <option value="NO">Norway</option>
                              <option value="OM">Oman</option>
                              <option value="PK">Pakistan</option>
                              <option value="PW">Palau</option>
                              <option value="PS">Palestinian Territory, Occupied</option>
                              <option value="PA">Panama</option>
                              <option value="PG">Papua New Guinea</option>
                              
                              <option value="PE">Peru</option>
                              <option value="PH">Philippines</option>
                              <option value="PN">Pitcairn</option>
                              <option value="PL">Poland</option>
                              <option value="PT">Portugal</option>
                              <option value="PR">Puerto Rico</option>
                              <option value="QA">Qatar</option>
                              <option value="RE">Réunion</option>
                              <option value="RO">Romania</option>
                              <option value="RU">Russian Federation</option>
                              <option value="RW">Rwanda</option>
                              <option value="BL">Saint Barthélemy</option>
                              <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                              <option value="KN">Saint Kitts and Nevis</option>
                              <option value="LC">Saint Lucia</option>
                              <option value="MF">Saint Martin (French part)</option>
                              <option value="PM">Saint Pierre and Miquelon</option>
                              <option value="VC">Saint Vincent and the Grenadines</option>
                              <option value="WS">Samoa</option>
                              <option value="SM">San Marino</option>
                              <option value="ST">Sao Tome and Principe</option>
                              <option value="SA">Saudi Arabia</option>
                              <option value="SN">Senegal</option>
                              <option value="RS">Serbia</option>
                              <option value="SC">Seychelles</option>
                              <option value="SL">Sierra Leone</option>
                              <option value="SG">Singapore</option>
                              <option value="SX">Sint Maarten (Dutch part)</option>
                              <option value="SK">Slovakia</option>
                              <option value="SI">Slovenia</option>
                              <option value="SB">Solomon Islands</option>
                              <option value="SO">Somalia</option>
                              <option value="ZA">South Africa</option>
                              <option value="GS">South Georgia and the South Sandwich Islands</option>
                              <option value="SS">South Sudan</option>
                              <option value="ES">Spain</option>
                              <option value="LK">Sri Lanka</option>
                              <option value="SD">Sudan</option>
                              <option value="SR">Suriname</option>
                              <option value="SJ">Svalbard and Jan Mayen</option>
                              <option value="SZ">Swaziland</option>
                              <option value="SE">Sweden</option>
                              <option value="CH">Switzerland</option>
                              <option value="SY">Syrian Arab Republic</option>
                              <option value="TW">Taiwan, Province of China</option>
                              <option value="TJ">Tajikistan</option>
                              <option value="TZ">Tanzania, United Republic of</option>
                              <option value="TH">Thailand</option>
                              <option value="TL">Timor-Leste</option>
                              <option value="TG">Togo</option>
                              <option value="TK">Tokelau</option>
                              <option value="TO">Tonga</option>
                              <option value="TT">Trinidad and Tobago</option>
                              <option value="TN">Tunisia</option>
                              <option value="TR">Turkey</option>
                              <option value="TM">Turkmenistan</option>
                              <option value="TC">Turks and Caicos Islands</option>
                              <option value="TV">Tuvalu</option>
                              <option value="UG">Uganda</option>
                              <option value="UA">Ukraine</option>
                              <option value="AE">United Arab Emirates</option>
                              <option value="GB">United Kingdom</option>
                              
                              <option value="UM">United States Minor Outlying Islands</option>
                              <option value="UY">Uruguay</option>
                              <option value="UZ">Uzbekistan</option>
                              <option value="VU">Vanuatu</option>
                              
                              <option value="VN">Viet Nam</option>
                              <option value="VG">Virgin Islands, British</option>
                              <option value="VI">Virgin Islands, U.S.</option>
                              <option value="WF">Wallis and Futuna</option>
                              <option value="EH">Western Sahara</option>
                              <option value="YE">Yemen</option>
                              <option value="ZM">Zambia</option>
                              <option value="ZW">Zimbabwe</option>
                          </select>
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf1" type="text" class="form-control" placeholder="Mobile">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf2" type="text" class="form-control" placeholder="Office">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="qq" type="text" class="form-control" placeholder="QQ">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="wechat" type="text" class="form-control" placeholder="WeChat">
                        </div>



                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
                            <input name="email" type="text" class="form-control" placeholder="E-mail">
                        </div>

                        <!-- radio -->
                        <div class="input-group" style="margin-top:20px;">

                            <label>
                              <input type="radio" name="type" value="Client" class="flat-red" required="required" checked>
                              <label>Consignee</label>
                            </label>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background:#B80008; border:none; height:40px; border-radius:2px; color:white; position:relative; left:-30px; width:100px;" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="form_1_submit" style="top:0px; background:#007F46;">

                    
                </div>
                </form>
            </div>
        </div>
      </div>
<?php } ?>

    <?php if ($step=='2'){ ?>
   
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-3 col-md-6 shadow2" style="background: white;margin-top:50px">
          <div class="row">
            <div class="col-md-12">
              <h3 style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">CREATE WAREHOUSE RECEIPT</h3>
            </div>
          </div> 
          <form action="action/savewaresthousestep2.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="warehouse_id" value=<?php echo $warehouse_id; ?>>
          <div class="row">
            <div class="col-md-12">
              <table class="table"> 
                <thead>
                  <tr>
                    <td class="text-center">Pieces</td>
                    <td class="text-center">Gross Weight</td>
                    <td class="text-center">Volume</td>
                    <td class="text-center">Charg.Weight</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th id="total_pieces" class="text-center"></th>
                    <th id="total_weight" class="text-center"></th>
                    <th id="total_volume" class="text-center"></th>
                    <th id="total_charg_weight" class="text-center"></th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <style>
          
          </style>
          <div class="row" style="margin-top:20px; margin-bottom:20px">
            <div class="col-md-offset-1 col-md-10">
              <input type="file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
            </div>
          </div>
          <input type="hidden" name="total_pieces">
          <input type="hidden" name="total_weight">
          <input type="hidden" name="total_volume">
          <input type="hidden" name="total_charg_weight">
          <div class="row">
            <div class="col-md-12">
              <div class="card" id="by_boxes_content">
                  <p><i class="fa fa-cubes"></i>&nbsp;By Boxes</p>
                  <div class="item">
                      <div class="form-group row" style="margin-bottom:0px;">
                         <div class="col-md-2 col-item text-center">
                              <label for="">Pieces</label>
                          </div>  
                          <div class="col-md-2 col-item text-center">
                              <label for="">Lenght</label>
                          </div>
                          <div class="col-md-2 col-item text-center">
                              <label for="">Width</label>
                          </div>
                          <div class="col-md-2 col-item text-center">
                              <label for="">Height</label>
                          </div>  
                          <div class="col-md-2 col-item text-center">
                              <label for="">Weight</label>
                          </div>                       
                      </div>
                  </div>                   
                  <div class="item col">
                      <div class="form-group row">
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_piecesx[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_lenghtX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_widthX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_heightX[]" value="" required class="form-control">
                          </div>
                          <div class="col-md-2 col-item">
                              <input type="number" name="byBoxes_weightX[]" value="" required class="form-control">
                          </div>
                          
                          <div class="col-md-1 col-item">                                         
                              <button  type="button"  class="btn btn_plus">+</button>                                          
                          </div>
                      </div>
                  </div>                 
              </div>
            </div>
          </div>
          <div class="row" style="margin-bottom:30px">
            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    <?php } ?>
  <!-- Form -->
  </section>
</div>
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#warehouses_list").addClass("active");
  $("#warehouses_list #create").addClass("active");
  $(function () {   
    $(".select2").select2();
    $("#joborderId").on('keyup',function(e){    
       if(e.keyCode==13){
         var id= $("#joborderId").val();
        //  $.ajax({
        //   method: 'POST',
        //   url: "./warehouse_curd.php",
        //   data: {
        //       jobid:id,
        //       qrcode :"create",
        //       }
        //   })
        //   .done(function (response) {
        //     var rep=JSON.parse(response);
        //     $("#qrcode").attr("src",rep.targetPath+''+rep.timestamp+'.png');
             $.ajax({
              method: 'POST',
              url: "./warehouse_curd.php",
              data: {
                  jobid:id,
                  jobfind :'find',
                  }
              })
              .done(function (response) {
                var rep=JSON.parse(response);
                if(rep.success){      
                    $("#step1_form select[name='supplier_id']").val(rep.data.supplier_id);
                    $("#step1_form select[name='supplier_id']").trigger('change');
                    $("#step1_form select[name='bill_id']").val(rep.data.bill_id);
                    $("#step1_form select[name='bill_id']").trigger('change');
                    $("#step1_form select[name='consignee_id']").val(rep.data.bill_id);
                    $("#step1_form select[name='consignee_id']").trigger('change');
                    $("#step1_form select[name='agent_id']").val(rep.data.agent_id);
                    $("#step1_form select[name='agent_id']").trigger('change');
                    $("#step1_form select[name='instination']").val(rep.data.service);
                    $("#step1_form select[name='instination']").trigger('change');
                    $("input[name='branch']").val(rep.data.branch);
                    $("textarea[name='description']").text(rep.data.commodity);
                    $("input[name='destination']").val(rep.data.customer_city);                    
                    $("textarea[name='tracking']").text(rep.data.tracking);
                } else {
                    $("#step1_form select[name='supplier_id']").val("");
                    $("#step1_form select[name='supplier_id']").trigger('change');
                    $("#step1_form select[name='bill_id']").val("");
                    $("#step1_form select[name='bill_id']").trigger('change');
                    $("#step1_form select[name='consignee_id']").val("");
                    $("#step1_form select[name='consignee_id']").trigger('change');
                    $("#step1_form select[name='agent_id']").val("");
                    $("#step1_form select[name='agent_id']").trigger('change');
                    $("#step1_form select[name='instination']").val("");
                    $("#step1_form select[name='instination']").trigger('change');
                    $("input[name='branch']").val("");
                    $("textarea[name='description']").text("");
                    $("input[name='destination']").val("");                    
                    $("textarea[name='tracking']").text("");
                    swal({
                        title: "Job ORDER!",
                        text: "No Exist Job ORDER!",
                        icon: "error",
                    }); 
                }
          })
            // const html5QrCode = new Html5Qrcode("reader");
            //   Html5Qrcode.getCameras().then(cameras => {
            //       /**
            //         * devices would be an array of objects of type:
            //         * { id: "id", label: "label" }
            //       */
            //       if (devices && devices.length) {
            //           var cameraId = devices[0].id;
            //           console.log("true");
            //             // .. use this to start scanning.
            //         }
            //   }).catch(err => {
            //         // handle err   
            // });
            // onScan.attachTo(document, {
            //     suffixKeyCodes: [13], // enter-key expected at the end of a scan
            //     reactToPaste: true, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
            //     onScan: function(sCode, iQty) { // Alternative to document.addEventListener('scan')
            //         console.log('Scanned: ' + iQty + 'x ' + sCode); 
            //     },
            //     onKeyDetect: function(iKeyCode){ // output all potentially relevant key events - great for debugging!
            //         console.log('Pressed: ' + iKeyCode);
            //     }
            // });
          // })
        
       }
    });
    $('input[type="file"]').imageuploadify();   
   
    $('.form_datetime').datetimepicker();
    
    $("#myModal1 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {     
          $("#step1_form select[name='supplier_id']").html(response);
          clear1();                          
          $("#myModal1").modal('hide');
          swal({
              title: "Supplier!",
              text: "New Supplier created successful!",
              icon: "success",
          });
      });
    })
    function clear1(){
      $("#myModal1 input[name='company']").val('');
      $("#myModal1 input[name='name']").val('');
      $("#myModal1 input[name='address_1']").val('');
      $("#myModal1 input[name='address_2']").val('');
      $("#myModal1 input[name='city']").val('');
      $("#myModal1 input[name='state']").val('');
      $("#myModal1 input[name='country']").val('');
      $("#myModal1 input[name='telf1']").val('');
      $("#myModal1 input[name='telf2']").val('');
      $("#myModal1 input[name='qq']").val('');
      $("#myModal1 input[name='wechat']").val('');
      $("#myModal1 input[name='email']").val('');
    }
    $("#myModal2 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {     
          $("#step1_form select[name='bill_id']").html(response);                          
          $("#myModal2").modal('hide');
          clear2();      
          swal({
              title: "Client!",
              text: "New Client created successful!",
              icon: "success",
          });
      });
    })
    function clear2(){
      $("#myModal2 input[name='agent_name']").val('');
      $("#myModal2 input[name='company']").val('');
      $("#myModal2 input[name='name']").val('');
      $("#myModal2 input[name='address_1']").val('');
      $("#myModal2 input[name='address_2']").val('');
      $("#myModal2 input[name='city']").val('');
      $("#myModal2 input[name='state']").val('');
      $("#myModal2 input[name='country']").val('');
      $("#myModal2 input[name='telf1']").val('');
      $("#myModal2 input[name='telf2']").val('');
      $("#myModal2 input[name='qq']").val('');
      $("#myModal2 input[name='wechat']").val('');
      $("#myModal2 input[name='email']").val('');
    }
    $("#myModal3 form").submit(function(e){
      event.preventDefault(); 
      var post_url = $(this).attr("action"); //get form action url
      var form_data = $(this).serialize(); //Encode form elements for submission                            
      $.post( post_url, form_data, function( response ) {    
          var data=JSON.parse(response);
          if(data.status){                          
            $("#myModal3").modal('hide');
            clear3();      
            swal({
                title: "Consignee!",
                text: "New Password is "+data.password,
                icon: "success",
            });
            $("#step1_form select[name='consignee_id']").html(data.html);        
            $("#step1_form select[name='bill_id']").html(data.html);     
          }else{
              swal({
              title: "Waring!",
              text: data.html,
              icon: "error",
            });
          }
       
      });
    })
    function clear3(){
      $("#myModal3 input[name='agent_name']").val('');
      $("#myModal3 input[name='company']").val('');
      $("#myModal3 input[name='name']").val('');
      $("#myModal3 input[name='address_1']").val('');
      $("#myModal3 input[name='address_2']").val('');
      $("#myModal3 input[name='city']").val('');
      $("#myModal3 input[name='state']").val('');
      $("#myModal3 input[name='country']").val('');
      $("#myModal3 input[name='telf1']").val('');
      $("#myModal3 input[name='telf2']").val('');
      $("#myModal3 input[name='qq']").val('');
      $("#myModal3 input[name='wechat']").val('');
      $("#myModal3 input[name='email']").val('');
    }
    $("#by_boxes_content .btn_plus").on("click", function(e){
        e.preventDefault();
        var html='<div class="item col">';
            html+='<div class="form-group row">';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_piecesx[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="text" name="byBoxes_lenghtX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number" name="byBoxes_widthX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_heightX[]" required class="form-control">';
            html+='</div>';
            html+='<div class="col-md-2 col-item">';
            html+='<input type="number"  name="byBoxes_weightX[]" required class="form-control">';
            html+='</div>';            
            html+='<div class="col-md-1 col-item">';
            html+='<button  type="button" class="btn btn_minus">-</button>';
            html+='</div>';
            html+='</div>';
            html+='</div>';
           
        $("#by_boxes_content").append(html);
          $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_piecesx[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_widthX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_heightX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_lenghtX[]']").keyup(function(e){
              total_calculator();
          })
          $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
          })
          $('#by_boxes_content .btn_minus').on("click", function (e) {
            e.preventDefault(); 
            $(this).parent('div').parent('div').parent('div').remove(); 
            total_calculator();
          })
      });

      $('#by_boxes_content .btn_minus').on("click", function (e) {
        e.preventDefault(); 
        $(this).parent('div').parent('div').parent('div').remove(); 
        total_calculator();
      })

      $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
              total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_piecesx[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_widthX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_heightX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_lenghtX[]']").keyup(function(e){
            total_calculator();
        })
        $("#by_boxes_content input[name='byBoxes_weightX[]']").keyup(function(e){
            total_calculator();
        })
   
    function total_calculator(){
      var total_pieces=0,total_weight=0, total_volume=0;
      $("#by_boxes_content .col").each(function(index,ele){
        var pieces=$(this)[0].children[0].children[0].children[0].value;
        var lenght=$(this)[0].children[0].children[1].children[0].value;
        var width=$(this)[0].children[0].children[2].children[0].value;
        var height=$(this)[0].children[0].children[3].children[0].value;
        var weight=$(this)[0].children[0].children[4].children[0].value;
        total_pieces=total_pieces+parseInt(pieces);
        total_volume=total_volume+parseInt(lenght)*parseInt(width)*parseInt(height)/1000000;
        total_weight=total_weight+parseFloat(weight)*parseInt(pieces);
        
      });
      $("#total_pieces").text(total_pieces);
      $("#total_weight").text(total_weight);
      $("#total_charg_weight").text(total_weight);
      $("#total_volume").text(total_volume.toFixed(5));

      $("input[name='total_pieces']").val(total_pieces);
      $("input[name='total_weight']").val(total_weight);
      $("input[name='total_volume']").val(total_volume.toFixed(5));
      $("input[name='total_charg_weight']").val(total_weight);
    
    }
  
  });
</script>


</body>
</html>
