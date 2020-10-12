<?php 
error_reporting(0);
require_once('conn.php');

  $message= $_GET['message'];
  $step= $_GET['step']; 
  $customer_id= $_GET['customer_id'];
  $supplier_idd= $_GET['supplier_idd'];
  $customer_step1= $_POST['customer_step1'];
  $supplier_step1= $_POST['supplier_step1'];

  $consultaClient = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$customer_step1' AND type='Client'   ") or die ("Error al traer los datos");

  while ($row = mysqli_fetch_array($consultaClient)){ 

    $cus_id=$row['id'];
    $customer_name=$row['name'];
    $customer_company=$row['company'];
    $customer_address1=$row['address_1'];
    $customer_address2=$row['address_2'];
    $customer_city=$row['city'];
    $customer_state=$row['state'];
    $customer_country=$row['country'];
    $customer_telf1=$row['telf1'];
    $customer_telf2=$row['telf2'];
    $customer_qq=$row['qq'];
    $customer_wechat=$row['wechat'];
    $customer_email=$row['email'];
    if ($customer_company=='') {
      $customer_company='Particular';
    }

    $client_id=$row['client_id'];

}  

$consultaSupplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_step1' AND type='Supplier'") or die ("Error al traer los datos");

    while ($row = mysqli_fetch_array($consultaSupplier)){ 


      $supp_id=$row['id'];
      $supplier_company=$row['company'];
      $supplier_name=$row['name'];
      $supplier_address1=$row['address_1'];
      $supplier_address2=$row['address_2'];
      $supplier_city=$row['city'];
      $supplier_state=$row['state'];
      $supplier_country=$row['country'];
      $supplier_telf1=$row['telf1'];
      $supplier_telf2=$row['telf2'];
      $supplier_qq=$row['qq'];
      $supplier_wechat=$row['wechat'];
      $supplier_email=$row['email'];
      $supplier_id=$row['client_id'];

} 
 
date_default_timezone_set('America/La_Paz');
    $fecha_db= date('Y-m-d H:i:s');
    $fecha_vista= date('d/m/Y');

include_once 'includes/register.inc.php';
include_once 'includes/functions.php';

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>System | Create Usa Orders</title>
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
        USA Orders 
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create USA Orders</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php if ($step=='') {$step='1';} ?>

<?php if ($step=='1'){ ?>
      <div class="row" style="margin: 0px;"> 
        <div class="col-md-offset-2 col-md-8 shadow2" style="    background: white;margin-top:50px">
          <div class="row">
            <div class="col-md-12">
              <h3 style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">Create USA Order

              </h3>
            </div>
          </div>
          <form action="?step=2" method="post">
            <div class="row" style="margin:30px 50px">
              <div class="col-md-6">
                  <div class="form-group ">
                      <div class="text-center" style="border-bottom:1px solid #555555; margin-bottom:20px">
                          <span style="font-size:35px; padding:10px;" class="glyphicon glyphicon-user"></span><br>
                          <span style="padding-top:15px;font-size:16px;">Select Client Account</span>                        
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12" >
                        <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                          <select data-placeholder="Select Client" name="customer_step1" class="form-control select2" style="max-width:100%; min-width:100%" required="required" >

                            <option value="">Select Client</option>
                            <?php 

                            if ($level=='Seller') { $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE agent='$agent_name' AND type='Client' ORDER BY name asc ") or die ("Error al traer los datos"); 
                            }else{
                              $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE type='Client' ORDER BY name asc ") or die ("Error al traer los datos");
                            }
                              while ($row = mysqli_fetch_array($consulta)){ 
                                $company=$row['company'];
                                $name=$row['name'];

                                $customer_if= $name;
                                if ($company!='') { $customer_if .= ' | '.$company; } 
                                if ($customer!=$customer_if){ ?>
                                
                                <option 
                                <?php if($customer_id==$row['id']){ echo "selected";} ?>
                                value="<?php echo $row['id']; ?>"><?php echo $customer_if; ?></option>
                                <?php }?>
                            <?php }  ?>
                          </select>
                        </div>                  
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12 text-center">
                          <button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal1">Add New Client</button>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group ">
                      <div class="text-center" style="border-bottom:1px solid #555555; margin-bottom:20px">
                          <span style="font-size:35px; padding:10px;" class="glyphicon glyphicon-briefcase"></span><br>
                          <span style="padding-top:15px;font-size:16px;">Select Supplier Account</span>                        
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12" >
                        <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                          <select data-placeholder="Select Supplier" name="supplier_step1" class="form-control select2" style="max-width:100%; min-width:100%" required="required">
                              <option selected="selected" value="<?php echo $supplier; ?>"><?php echo $supplier; ?></option>
                                <option value="No Supplier Information">No Supplier Information</option>
                                <option value="Amazon">Amazon</option>
                                <option value="Wal-Mart">Wal-Mart</option>
                                <option value="eBay">eBay</option>
                                        <?php  if ($level=='Seller') { $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE agent='$agent_name' AND type='Supplier' AND branch='USA' ORDER BY name asc ") or die ("Error al traer los datos"); 
                                      }else{
                                        $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE type='Supplier' AND branch='USA' ORDER BY name asc ") or die ("Error al traer los datos");}

                                      while ($row = mysqli_fetch_array($consulta)){ 
                                        $company=$row['company'];
                                        $name=$row['name'];
                
                                         $customer_if= $name;
                                          if ($company!='') { $customer_if .= ' | '.$company; }
                                      if ($customer!=$customer_if){ ?>
                                      <option 
                                          <?php if($supplier_idd == $row['id'] ){ echo "selected"; } ?>
                                      value="<?php echo $row['id']; ?>"><?php echo $customer_if; ?></option>
                                      <?php } ?>
                                  <?php }  ?>
                            </select>
                        </div>                  
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12 text-center">
                          <button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModal2">Add New Supplier</button>
                      </div>
                  </div>
              </div>
              
            </div>
            <div class="row" style="padding-bottom:30px">
                  <div class="col-md-12 text-center">
                      <button type="submit" class="btn btn-success" style="width:200px">Next</button>
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
                    <h4 class="modal-title" id="myModalLabel">Add new client</h4>
                </div>
                <form action="saveAccountStep1USA.php" method="POST">
                <div class="modal-body">
                    
                        <input name="supplier_id" value="<?php echo $supplier_id; ?>" type="hidden"> 

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
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
                            <input name="name" type="text" class="form-control" placeholder="Contact Person">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
                            <input name="company" type="text" class="form-control" placeholder="Company Name">
                        </div>


                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_1" type="text" class="form-control" placeholder="Address 1" value="">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
                            <input name="address_2" type="text" class="form-control" placeholder="Address 2">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="city" type="text" class="form-control" placeholder="City" required="required">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
                            <input name="state" type="text" class="form-control" placeholder="State" required="required">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
                            <select name="country" class="form-control select2" style="width:100%;" required="required">
                            <option value="">Select Country</option>
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
                            <input name="telf1" type="text" class="form-control" placeholder="Mobile Phone">
                        </div>

                        <div class="input-group" style="margin-top:20px;">
                            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
                            <input name="telf2" type="text" class="form-control" placeholder="Office Phone">
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
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add new supplier</h4>
                </div>
                <form action="saveSupplierStep1USA.php" method="POST">
                <div class="modal-body">
                    

                        <input name="customer_id" value="<?php echo $customer_id; ?>" type="hidden">

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
    <?php } ?>

    <?php if ($step=='2'){ ?>
   
        <div class="searchPage shadow2" style=" background: white;margin-top:50px">
          <div class="row">
            <div class="col-md-12">
              <h3 style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">Create USA Order
              </h3>
            </div>
          </div>
          <form action="saveJobOrderUSA.php" method="POST">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row text-center">
                  <div class="col-md-12">
                      <i class="fa fa-user icon"></i>
                      <h4 class="title">Customer Data</h4>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                          <input type="text"name="cus_id" class="form-control" disabled value="<?php echo $cus_id; ?>">
                          <input type="hidden"name="cus_id" class="form-control" value="<?php echo $cus_id; ?>">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                          <input type="text" name="customer_name" class="form-control" value="<?php echo $customer_name; ?>" placeholder="customer_name">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                          <input type="text" name="customer_company" class="form-control" value="<?php echo $customer_company; ?>" placeholder="Company Name">
                      </div>
                  </div>
              </div>               
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Mobile</div>
                          <input type="text" name="customer_telf1" class="form-control" value="<?php echo $customer_telf1; ?>" placeholder="Mobile">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Office</div>
                          <input type="text" name="customer_telf2" class="form-control" value="<?php echo $customer_telf2; ?>" placeholder="Office">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;QQ</div>
                          <input type="text" name="customer_qq" class="form-control" value="<?php echo $customer_qq; ?>" placeholder="QQ">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;WeChat</div>
                          <input type="text" name="customer_wechat" class="form-control" value="<?php echo $customer_wechat; ?>" placeholder="WeChat">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-envelope input-fa"></i></div>
                          <input type="text" name="customer_email" class="form-control" value="<?php echo $customer_email; ?>" placeholder="E-mail">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                        <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 1</span>
                        <input name="customer_address1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $customer_address1;?>">
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <div class="input-group" >
                      <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 2</span>
                      <input name="customer_address2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $customer_address2;?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                        <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;City</span>
                        <input name="customer_city" type="text" class="form-control" placeholder="City"  value="<?php echo $customer_city;?>">
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                      <span class="input-group-addon"><i  class="fa fa-map-marker input-fa"></i>&nbsp;State</span>
                      <input name="customer_state" type="text" class="form-control" placeholder="State"  value="<?php echo $customer_state;?>">
                    </div>
                </div>
              </div>                  
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                      <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;Country</span>
                      <select name="customer_country" class="form-control select2" style="width:100%;" >
                      <option value="">Select Country</option>
                      <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                          while ($row = mysqli_fetch_array($consulta_coutry)){ 
                          ?>
                        <option 
                            <?php if($customer_country == $row['sub_name'] ){ echo "selected"; } ?>
                        value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>                   
                    </select>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-md-4">
                <div class="form-group row text-center">
                    <div class="col-md-12">
                        <i class="fa fa-briefcase icon"></i>
                        <h4 class="title">Supplier Data</h4>
                    </div>
                </div>
                
                <?php if ($supplier_company=='eBay' or $supplier_company=='Wal-Mart' or $supplier_company=='Amazon'){ ?>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class=" input-group">
                            <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                            <input type="text" class="form-control"  value="<?php echo $supplier_company; ?>" disabled placeholder="Company Name">
                            <input type="hidden" value="<?php echo $supplier_company; ?>" name="supplier_company">
                            <input type="hidden" value="<?php echo $supp_id; ?>" name="supp_id">
                        </div>
                    </div>
                </div>  
                <?php }else{ ?>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class=" input-group">
                            <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                            <input type="text" class="form-control"  value="<?php echo $supp_id; ?>" disabled placeholder="">
                            <input type="hidden" value="<?php echo $supp_id; ?>" name="supp_id">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class=" input-group">
                            <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                            <input type="text" class="form-control" name='supplier_company' value="<?php echo $supplier_company; ?>"  placeholder="Company Name">
                        </div>
                    </div>
                </div>               
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class=" input-group">
                            <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                            <input type="text" class="form-control" value="<?php echo $supplier_name; ?>" name="supplier_name" placeholder="Contact Person">
                        </div>
                    </div>
                </div>                              
                <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Mobile</div>
                          <input type="text" name="supplier_telf1" class="form-control" value="<?php echo $supplier_telf1; ?>" placeholder="Mobile">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Office</div>
                          <input type="text" name="supplier_telf2" class="form-control" value="<?php echo $supplier_telf2; ?>" placeholder="Office">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;QQ</div>
                          <input type="text" name="supplier_qq" class="form-control" value="<?php echo $supplier_qq; ?>" placeholder="QQ">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;WeChat</div>
                          <input type="text" name="supplier_wechat" class="form-control" value="<?php echo $supplier_wechat; ?>" placeholder="WeChat">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-envelope input-fa"></i></div>
                          <input type="text" name="supplier_email" class="form-control" value="<?php echo $supplier_email; ?>" placeholder="E-mail">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                        <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 1</span>
                        <input name="supplier_address1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $supplier_address1;?>">
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <div class="input-group" >
                      <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 2</span>
                      <input name="supplier_address2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $supplier_address2;?>">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                        <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;City</span>
                        <input name="supplier_city" type="text" class="form-control" placeholder="City"  value="<?php echo $supplier_city;?>">
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                      <span class="input-group-addon"><i  class="fa fa-map-marker input-fa"></i>&nbsp;State</span>
                      <input name="supplier_state" type="text" class="form-control" placeholder="State"  value="<?php echo $supplier_state;?>">
                    </div>
                </div>
              </div>                  
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group" >
                      <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;Country</span>
                      <select name="supplier_country" class="form-control select2" style="width:100%;" >
                      <option value="">Select Country</option>
                      <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                          while ($row = mysqli_fetch_array($consulta_coutry)){ 
                          ?>
                        <option 
                            <?php if($supplier_country == $row['sub_name'] ){ echo "selected"; } ?>
                        value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>                   
                    </select>
                  </div>
                </div>
              </div> 
              <?php } ?>
            </div>
            <div class="col-md-4">
              <div class="form-group row text-center">
                  <div class="col-md-12">
                      <i class="fa fa-plane icon"></i>
                      <h4 class="title">Service Data</h4>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                          <input type="text" class="form-control" data-provide="datepicker" name="fecha" data-date-format="dd-mm-yyyy" placeholder="Select date" value="<?php echo $fecha_vista; ?>" required >
                          <input name="hora" type="hidden" value="<?php echo date('H:i:s') ?>">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                          <select id="" class="form-control select2" placeholder="Select Agent" <?php if ($level!='Seller'){ ?> name="agent_id" <?php } ?> <?php if ($level=='Seller'){ ?> disabled <?php } ?>>
                          <option value="<?php echo $agent_id; ?>"><?php echo $agent_name; ?></option>
                          <?php 
                              $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");

                              while ($rowList = mysqli_fetch_array($consultaList)){ 
                                $agentid=$rowList['id']; 
                              $agent_List=$rowList['name']; 
                              if ($agent_name!=$agent_List){ 
                              ?>
                              <option value="<?php echo $agentid; ?>"><?php echo $agent_List; ?></option>
                              <?php }   ?>
                              <?php }  ?>
                          </select>
                          <?php if ($level=='Seller'){ ?>
                            <input type="text" name="agent_id" type="hidden" value="<?php echo $agent_id; ?>">
                          <?php } ?>
                      </div>
                  </div>
              </div>
              <input type="hidden" name="agent_email" value="<?php echo $email; ?>">
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                          <select name="service" id="" class="form-control select2" data-placeholder="Select Service" required>
                                <option></option>
                                <option value="Pending">Pending</option>
                                <option value="Air door to door">Air door to door</option>
                                <option value="Ocean door to door">Ocean door to door</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                          <select data-placeholder="Commodity" id="state" class="form-control select2" name="commodity" type="text" multiple>


                          <?php $consulta22 = mysqli_query($connect, "SELECT DISTINCT commodity FROM joborders  ") or die ("Error al traer los datos");

                                  while ($row = mysqli_fetch_array($consulta22)){ 
                                  $commodity=$row['commodity'];
                                  ?>

                          <option value="<?php echo $commodity; ?>"><?php echo $commodity; ?></option>
                          <?php }  ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-folder-open-o input-fa"></i></div>
                          <input type="text" name="wh_receipt" class="form-control"  value="" placeholder="WH Receipt">
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-square input-fa"></i></div>
                          <textarea name="tracking" type="text" style="" class="form-control" placeholder="Tracking Number" value=""></textarea>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-money input-fa"></i></div>
                        <input type="text" name="value" class="form-control"  placeholder="Value">
                    </div>
                </div>
            </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <label for="">Need Pick-Up?</label>
                  </div>
                  <div class="col-md-12">
                      <label class="radio-inline">
                          <input type="radio" name="remark" id="no" value="no" checked  > No
                          </label>
                      <label class="radio-inline">
                          <input type="radio"   name="remark" id="yes" value="yes"  > Yes
                          </label>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <label for="">Need Payment Assistant?</label>
                  </div>
                  <div class="col-md-12">
                      <label class="radio-inline">
                          <input type="radio" name="payment" id="no" value="no" checked> No
                          </label>
                      <label class="radio-inline">
                          <input type="radio" name="payment" id="yes" value="yes" > Yes
                          </label>
                  </div>
                </div>
            </div>
            <div class="col-md-12 text-right">
            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
            </div>
            </div>
          </div>
          </form>
      </div>        
    <?php } ?>

    </section>

</div>
<!-- ./wrapper -->

<!-- Page script -->
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#usaorders_list").addClass("active");
  $("#usaorders_list #create").addClass("active");
  $(".select2").select2();
 
  $(document).ready(function() {
    $("#state").select2({
      tags: true
    });
      
    $("#btn-add-state").on("click", function(){
      var newStateVal = $("#new-state").val();
      // Set the value, creating a new option if necessary
      if ($("#state").find("option[value='" + newStateVal + "']").length) {
        $("#state").val(newStateVal).trigger("change");
      } else { 
        // Create the DOM option that is pre-selected by default
        var newState = new Option(newStateVal, newStateVal, true, true);
        // Append it to the select
        $("#state").append(newState).trigger('change');
      } 
    });  
});
  $(function () {

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   
    
  });

   
</script>



</body>
</html>
