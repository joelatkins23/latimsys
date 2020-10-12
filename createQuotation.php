<?php 
error_reporting(0);
require_once('conn.php');
session_start();
    if(isset($_GET['client_id'])){
      $client_id= $_GET['client_id'];
    }else{
      $client_id='';
    }
    $message= $_GET['message'];
    $option= $_GET['option'];
    $step= $_GET['step'];

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

<?php date_default_timezone_set('America/La_Paz');
    $fecha_db= date('Y-m-d H:i:s');
    $fecha_vista= date('d-m-Y'); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  
  <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
  <title>Latim Cargo & Trading | System</title>
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
          Quotations
          <small>create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create Quotations</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <?php if ($option==''){ ?>
        <div class="row" style="    margin: 0px;">
          <div class="col-md-offset-3 col-md-6 form_1 shadow2">
            <div class="row">
              <div class="col-md-12">
                <h3
                  style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">
                  Create Quotation<br>
                  <span style="color:black; font-size:14px; font-weight:400; position:relative; top:10px;">Please select
                    one option:</span>
                </h3>

                <?php if ($message=='AccountSaved'){ ?>
                <br>
                <div id="mydiv"
                  style="background-color: rgba(0, 127, 70, 1); padding:20px;color:white; position:absolute; left:50%; width:300px; margin-left:140px; top:-80px;">
                  <center>
                    <span style="font-style: oblique; ">Account has been created.</span>
                  </center>
                </div>
                <?php } ?>
                <?php if ($message=='QuotationCreated'){ ?>
                <br>
                <div id="mydiv"
                  style="background-color: rgba(0, 127, 70, 1); padding:20px;color:white; position:absolute; left:50%; width:300px; margin-left:140px; top:-80px;">
                  <center>
                    <span style="font-style: oblique; ">Quotation has been created.</span>
                  </center>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 text-center" style="padding:30px">
                <span style="font-size:60px;" class="fa fa-ship"></span>
                <div class="form-group" style="margin-top:15px">
                  <a href="?step=2&option=FCL" class="btn btn-success btn-block">FCL Shipment</a>
                </div>
              </div>
              <div class="col-md-6 text-center" style="padding:30px">
                <span style="font-size:60px;" class="fa fa-cubes"></span>
                <div class="form-group" style="margin-top:15px">
                  <a href="?step=2&option=Pieces" class="btn btn-danger btn-block">By Pieces</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <!--end step1 -->
        <!-- start step2 -->
        <?php if ($step=='2'){ ?>
        <div class="row" style="margin: 0px;">
          <div class="col-md-offset-3 col-md-6 form_1 shadow2">
            <div class="row">
              <div class="col-md-12">
                <h3
                  style="text-align:center; color:black; font-weight:400; padding:20px; font-size:20px; border-bottom:1px solid #555555;">
                  Create Quotation<br>
                  <span style="color:black; font-size:14px; font-weight:400; position:relative; top:10px;">Please select
                    one option:</span>
                </h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-offset-3 col-md-6 text-center"
                style="border-bottom:1px solid #555555; margin-bottom:20px">
                <span style="font-size:35px; padding:10px;" class="glyphicon glyphicon-user"></span><br>
                <span style="padding-top:15px;font-size:16px;">Select Client Account</span>
              </div>
            </div>
            <form action="?" method="get">
              <div class="row">
                <div class="col-md-offset-3 col-md-6 text-center" style="margin-bottom:20px">
                  <div class=" input-group">
                    <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                    <select name="client_id" data-placeholder="Select Client" id="" class="form-control select2"
                      required style="width:100%">
                      <option value="">Select Client</option>
                      <?php 
                          if ($level=='Seller') {
                            $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE agent='$agent_name' AND type='Client' ORDER BY name asc ") or die ("Error al traer los datos"); 
                          }else{
                            $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE type='Client' ORDER BY name asc ") or die ("Error al traer los datos");
                          }
                          while ($row = mysqli_fetch_array($consulta)){ 
                            $company=$row['company'];
                            $name=$row['name'];
                            $customer_if= $name;
                              if ($company!='') { $customer_if .= ' | '.$company; }

                            ?>
                      <?php if ($customer!=$customer_if){ ?>
                      <option <?php if($client_id==$row['id']){ echo "selected";} ?> value="<?php echo $row['id']; ?>">
                        <?php echo $customer_if; ?></option>
                      <?php }?>
                      <?php }  ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-offset-3 col-md-6 text-center" style="margin-bottom:20px">
                  <button type="button" data-toggle="modal" data-target="#myModal1" class="btn btn-danger btn-sm">Add
                    New Client</button>
                </div>
                <div class="col-md-3 text-center" style="margin-bottom:20px">
                  <input type="hidden" name="option" value="<?php echo $option; ?>">
                  <input type="hidden" name="step" value="3">
                  <button type="submit" class="btn btn-success btn-block btn-sm">Next</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add new client</h4>
              </div>
              <div class="modal-body">
                <form action="action/saveAccountQuotation.php" method="POST">
                  <input name="supplier" value="<?php echo $supplier; ?>" style="display:none;">
                  <input name="option" value="<?php echo $option; ?>" style="display:none;">

                  <div class="input-group">
                    <span class="input-group-addon"><i style="width:20px;" class="fa fa-circle"></i></span>
                    <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?> name="agent_name" <?php } ?>
                      class="form-control select2" <?php if ($level=='Seller'){ ?> disabled <?php } ?>
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





                    </select>

                    <?php if ($level=='Seller'){ ?>
                    <input type="text" name="agent_name" style="display:none;" value="<?php echo $agent_name; ?>">
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
                <button type="button" class="btn btn-default"
                  style="background:#B80008; border:none; height:40px; border-radius:2px; color:white; position:relative; left:-30px; width:100px;"
                  data-dismiss="modal">Cancel</button>
                <input type="submit" value="Save" class="form_1_submit" style="top:0px; background:#007F46;">
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        <!--end step2 -->
        <!--start step3 fcl -->
        <?php if ($option=='FCL' && $step=='3'){ ?>
        <div class="row searchPage shadow2">
          <div class="col-md-12 ">
            <h3
              style="text-align:center; color:black; font-weight:400; padding-bottom:20px;font-size:20px; border-bottom:1px solid #555555;">
              FCL Quotation<br>
            </h3>
          </div>
          <form action="quotation.php" method="POST" style="padding: 100px 40px 20px 40px;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                      <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?> name="agent_name"
                        <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?> disabled <?php } ?>
                        style="width:100%;">

                        <?php 
                                        $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");
                                        while ($rowList = mysqli_fetch_array($consultaList)){ 
                                        $agent_List=$rowList['name']; ?>
                        <option <?php if($agent_name==$rowList['name']){echo "selected";} ?>
                          value="<?php echo $agent_List; ?>"><?php echo $agent_List; ?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>
                </div>
                <?php if ($level=='Seller'){ ?>
                <input type="hidden" name="agent_name" value="<?php echo $agent_name; ?>">
                <?php } ?>

                <input type="hidden" name="agent_email" value="<?php echo $email; ?>">
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                      <select data-placeholder="Select Client" name="client_id" class="form-control select2"
                        style="width:100%;">
                        <option value="">Select Client</option>
                        <?php 
                                  if ($level=='Seller') { $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE agent='$agent_name' AND type='Client' ORDER BY name asc ") or die ("Error al traer los datos"); 
                                  }else{
                                    $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE type='Client' ORDER BY name asc ") or die ("Error al traer los datos");}

                                    while ($row = mysqli_fetch_array($consulta)){ 
                                        $company=$row['company'];
                                        $name=$row['name'];

                                        $customer_if= $name;
                                        if ($company!='') { $customer_if .= ' | '.$company; }
                                        if ($customer!=$customer_if){ ?>
                        <option <?php if($client_id==$row['id']){ echo "selected";} ?>
                          value="<?php echo $row['id']; ?>"><?php echo $customer_if; ?></option>
                        <?php } ?>
                        <?php }  ?>

                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                      <input type="text" class="form-control" name="expiration_date" data-provide="datepicker"
                        data-date-format="dd-mm-yyyy" laceholder="To" placeholder="Expiration Date">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <input type="text" class="form-control" name="initial_date" data-provide="datepicker"
                      data-date-format="dd-mm-yyyy" laceholder="To" value="<?php echo $fecha_vista; ?>"
                      placeholder="Initial Date">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-map-marker input-fa"></i></div>
                      <select id="state2" class="form-control select2" name="origin" required="required"
                        data-placeholder="Origin" style="width:100%;">
                        <option></option>
                        <?php $consulta22 = mysqli_query($connect, "SELECT DISTINCT origin FROM quotations  ") or die ("Error al traer los datos");

                                    while ($row = mysqli_fetch_array($consulta22)){ 
                                    $origin=$row['origin'];
                                    ?>
                            <option value="<?php echo $origin; ?>"><?php echo $origin; ?></option>

                        <?php } ?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-map-marker input-fa"></i></div>
                      <select id="state3" class="form-control select2" name="destination" required="required"
                        data-placeholder="Destination" style="width:100%;">
                        <option></option>

                        <?php $consulta22 = mysqli_query($connect, "SELECT DISTINCT destination FROM quotations  ") or die ("Error al traer los datos");

                                  while ($row = mysqli_fetch_array($consulta22)){ 
                                  $destination=$row['destination'];
                                  ?>
                        <option value="<?php echo $destination; ?>"><?php echo $destination; ?></option>

                        <?php } ?>

                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-ship input-fa"></i></div>
                      <select data-placeholder="Select Service" required="required" name="service"
                        class="form-control select2" style="width:100%;">
                        <option></option>
                        <option value='FCL 20"'>FCL 20"</option>
                        <option value='FCL 40"'>FCL 40"</option>
                        <option value='FCL 40" HC'>FCL 40" HC</option>
                      </select>  
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-star input-fa"></i></div>
                      <input type="number" name="containerQuantity" class="form-control" value="1"
                        placeholder="container Quantity">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                      <select id="state" class="form-control select2" name="commodity" data-placeholder="Select Commodity"
                        style="width:100%;">
                        <option></option>
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
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-money input-fa"></i></div>
                      <input type="number" name="value" class="form-control" value="" placeholder="Value">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card" id="freight_charges">
                  <p>Freight Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="freightDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="freightChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="freightChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <?php if($key==0){ ?>
                        <button type="button" class="btn btn_plus">+</button>
                        <?php }else{ ?>
                        <button type="button" class="btn btn_minus">-</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" id="origin_charges">
                  <p>Origin Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="originDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="originChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="originChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <button type="button" class="btn btn_plus">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" id="destination_charges">
                  <p>Destination Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="destinationDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="destinationChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="destinationChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <button type="button" class="btn btn_plus">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <p>Remarks</p>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-11 col-item">
                        <textarea name="remarks" id="" cols="30" rows="10" class="form-control">A. COTIZACION ES BASADA EN TERMINO FOB DESDE BODEGA GUANGZHOU.
B. TRANSITO APROX:  X Dias 
C. NO INCLUYE SEGURO DE CARGA, NO INCLUYE AGENCIAMIENTO ADUANAL.</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="from-group row">
                  <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                  </div>

                </div>
              </div>
            </div>
          </form>
        </div>

        <?php } ?>
        <!--end step3 fcl -->
        <!--start step3 Pieces -->
        <?php if($option=='Pieces' && $step=='3'){ ?>
        <div class="row searchPage shadow2">
          <div class="col-md-12 ">
            <h3
              style="text-align:center; color:black; font-weight:400; padding-bottom:20px;font-size:20px; border-bottom:1px solid #555555;">
              By Pieces Quotation<br>
            </h3>
          </div>
          <form action="quotation.php" method="POST" style="padding: 100px 40px 20px 40px;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                      <select data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?> name="agent_name"
                        <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?> disabled <?php } ?>
                        style="width:100%;">

                        <?php 
                                        $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");
                                        while ($rowList = mysqli_fetch_array($consultaList)){ 
                                        $agent_List=$rowList['name']; ?>
                        <option <?php if($agent_name==$rowList['name']){echo "selected";} ?>
                          value="<?php echo $agent_List; ?>"><?php echo $agent_List; ?></option>
                        <?php }  ?>
                      </select>
                    </div>
                  </div>
                </div>
                <?php if ($level=='Seller'){ ?>
                <input type="hidden" name="agent_name" value="<?php echo $agent_name; ?>">
                <?php } ?>

                <input type="hidden" name="agent_email" value="<?php echo $email; ?>">
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                      <select data-placeholder="Select Client" name="client_id" class="form-control select2"
                        style="width:100%;">
                        <option value="">Select Client</option>

                        <?php 
                                  if ($level=='Seller') { $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE agent='$agent_name' AND type='Client' ORDER BY name asc ") or die ("Error al traer los datos"); 
                                  }else{
                                    $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE type='Client' ORDER BY name asc ") or die ("Error al traer los datos");}

                                    while ($row = mysqli_fetch_array($consulta)){ 
                                        $company=$row['company'];
                                        $name=$row['name'];

                                        $customer_if= $name;
                                        if ($company!='') { $customer_if .= ' | '.$company; }
                                        if ($customer!=$customer_if){ ?>
                        <option <?php if($client_id==$row['id']) {echo "selected";} ?>
                          value="<?php echo $row['id']; ?>"><?php echo $customer_if; ?></option>
                        <?php } ?>
                        <?php }  ?>

                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                      <input type="text" class="form-control" name="expiration_date" data-provide="datepicker"
                        data-date-format="dd-mm-yyyy" laceholder="To" placeholder="Expiration Date">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <input type="text" class="form-control" name="initial_date" data-provide="datepicker"
                      data-date-format="dd-mm-yyyy" laceholder="To" value="<?php echo $fecha_vista; ?>"
                      placeholder="Initial Date">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-map-marker input-fa"></i></div>
                      <select id="state2" class="form-control select2" name="origin" required="required"
                        data-placeholder="Origin" style="width:100%;">
                        <option></option>
                        <?php $consulta22 = mysqli_query($connect, "SELECT DISTINCT origin FROM quotations  ") or die ("Error al traer los datos");

                                    while ($row = mysqli_fetch_array($consulta22)){ 
                                    $origin=$row['origin'];
                                    ?>
                        <option value="<?php echo $origin; ?>"><?php echo $origin; ?></option>

                        <?php } ?>

                      </select>
                     
                    </div>
                  </div>
                  <div class="col-md-5">
                    <select id="state3" class="form-control select2" name="destination" required="required"
                      data-placeholder="Destination" style="width:100%;">
                      <option></option>

                      <?php $consulta22 = mysqli_query($connect, "SELECT DISTINCT destination FROM quotations  ") or die ("Error al traer los datos");

                                while ($row = mysqli_fetch_array($consulta22)){ 
                                $destination=$row['destination'];
                                ?>
                      <option value="<?php echo $destination; ?>"><?php echo $destination; ?></option>

                      <?php } ?>

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-ship input-fa"></i></div>
                      <select data-placeholder="Select Service" required="required" name="service"
                        class="form-control select2" style="width:100%;">
                        <option></option>
                        <option value="Air Service">Air Service</option>
                        <option value="Ocean Service">Ocean Service</option>
                        <option value="LCL">LCL</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                      <select id="state" class="form-control select2" name="commodity" data-placeholder="Commodity"
                        style="width:100%;">
                        <option> </option>
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
                    <div class=" input-group">
                      <div class="input-group-addon"><i class="fa fa-money input-fa"></i></div>
                      <input type="number" name="value" class="form-control" value="" placeholder="Value">
                    </div>
                  </div>
                </div>
                <div class="card">
                  <p><i class="fa fa-cube"></i>&nbsp;By Weight and Volume</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                      <div class="col-md-4 col-item text-center">
                        <label for="">Volume</label>
                      </div>
                      <div class="col-md-4 col-item text-center">
                        <label for="">Weight</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="byVolume_qty" value="" class="form-control">
                      </div>
                      <div class="col-md-4 col-item">
                        <input type="number" name="byVolume_volume" value="" class="form-control">
                      </div>
                      <div class="col-md-4 col-item">
                        <input type="number" name="byVolume_weight" value="" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" id="by_boxes_content">
                  <p><i class="fa fa-cubes"></i>&nbsp;By Boxes</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-2 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                      <div class="col-md-2 col-item text-center">
                        <label for="">Width</label>
                      </div>
                      <div class="col-md-2 col-item text-center">
                        <label for="">Lenght</label>
                      </div>
                      <div class="col-md-2 col-item text-center">
                        <label for="">Height</label>
                      </div>
                      <div class="col-md-2 col-item text-center">
                        <label for="">Weight</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-2 col-item">
                        <input type="text" name="byBoxes_qtyX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-2 col-item">
                        <input type="number" name="byBoxes_widthX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-2 col-item">
                        <input type="number" name="byBoxes_lenghtX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-2 col-item">
                        <input type="number" name="byBoxes_heightX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-2 col-item">
                        <input type="number" name="byBoxes_weightX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <button type="button" class="btn btn_plus">+</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card" id="freight_charges">
                  <p>Freight Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>

                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="freightDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="freightChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="freightChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <?php if($key==0){ ?>
                        <button type="button" class="btn btn_plus">+</button>
                        <?php }else{ ?>
                        <button type="button" class="btn btn_minus">-</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" id="origin_charges">
                  <p>Origin Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="originDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="originChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="originChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <button type="button" class="btn btn_plus">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" id="destination_charges">
                  <p>Destination Charges</p>
                  <div class="item">
                    <div class="form-group row" style="margin-bottom:0px;">
                      <div class="col-md-4 col-item text-center">
                        <label for="">Description</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Price</label>
                      </div>
                      <div class="col-md-3 col-item text-center">
                        <label for="">Quantity</label>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-4 col-item">
                        <input type="text" name="destinationDescX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="destinationChargeX[]" value="" class="form-control">
                      </div>
                      <div class="col-md-3 col-item">
                        <input type="number" name="destinationChargeQX[]" value="1" class="form-control">
                      </div>
                      <div class="col-md-1 col-item">
                        <button type="button" class="btn btn_plus">+</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <p>Remarks</p>
                  <div class="item">
                    <div class="form-group row">
                      <div class="col-md-11 col-item">
                        <textarea name="remarks" id="" cols="30" rows="10" class="form-control"> A. COTIZACION ES BASADA EN TERMINO FOB DESDE BODEGA GUANGZHOU. B. TRANSITO APROX:  X Dias 
C. NO INCLUYE SEGURO DE CARGA, NO INCLUYE AGENCIAMIENTO ADUANAL.</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="from-group row">
                  <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                  </div>

                </div>
              </div>
            </div>
          </form>
        </div>

        <?php }?>
      </section>
    </div>
  </div>
  <script>
    $(".sidebar-menu li a").removeClass('active');
    $(".treeview").removeClass('active');
    $("#quotations_list").addClass("active");
    $("#quotations_list #create").addClass("active");
    $(".select2").select2();
    $("#by_boxes_content .btn_plus").on("click", function (e) {
      e.preventDefault();
      var html = '<div class="item">';
      html += '<div class="form-group row">';
      html += '<div class="col-md-2 col-item">';
      html += '<input type="text" name="byBoxes_qtyX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-2 col-item">';
      html += '<input type="number" name="byBoxes_widthX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-2 col-item">';
      html += '<input type="number"  name="byBoxes_lenghtX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-2 col-item">';
      html += '<input type="number"  name="byBoxes_heightX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-2 col-item">';
      html += '<input type="number"  name="byBoxes_weightX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-1 col-item">';
      html += '<button  type="button" class="btn btn_minus">-</button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      $("#by_boxes_content").append(html);

      $('#by_boxes_content .btn_minus').on("click", function (e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
      })
    });

    $('#by_boxes_content .btn_minus').on("click", function (e) {
      e.preventDefault();
      $(this).parent('div').parent('div').parent('div').remove();
    })
    $("#freight_charges .btn_plus").on("click", function (e) {
      e.preventDefault();
      var html = '<div class="item">';
      html += '<div class="form-group row">';
      html += '<div class="col-md-4 col-item">';
      html += '<input type="text" name="freightDescX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" name="freightChargeX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" value="1" name="freightChargeQX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-1 col-item">';
      html += '<button  type="button" class="btn btn_minus">-</button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      $("#freight_charges").append(html);

      $('#freight_charges .btn_minus').on("click", function (e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
      })
    });

    $('#freight_charges .btn_minus').on("click", function (e) {
      e.preventDefault();
      $(this).parent('div').parent('div').parent('div').remove();
    })
    $("#origin_charges .btn_plus").on("click", function (e) {
      e.preventDefault();
      var html = '<div class="item">';
      html += '<div class="form-group row">';
      html += '<div class="col-md-4 col-item">';
      html += '<input type="text" name="originDescX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" name="originChargeX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" value="1" name="originChargeQX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-1 col-item">';
      html += '<button  type="button" class="btn btn_minus">-</button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      $("#origin_charges").append(html);

      $('#origin_charges .btn_minus').on("click", function (e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
      })
    });

    $('#origin_charges .btn_minus').on("click", function (e) {
      e.preventDefault();
      $(this).parent('div').parent('div').parent('div').remove();
    })
    $("#destination_charges .btn_plus").on("click", function (e) {
      e.preventDefault();
      var html = '<div class="item">';
      html += '<div class="form-group row">';
      html += '<div class="col-md-4 col-item">';
      html += '<input type="text" name="destinationDescX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" name="destinationChargeX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-3 col-item">';
      html += '<input type="number" value="1" name="destinationChargeQX[]" class="form-control">';
      html += '</div>';
      html += '<div class="col-md-1 col-item">';
      html += '<button  type="button" class="btn btn_minus">-</button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      $("#destination_charges").append(html);

      $('#destination_charges .btn_minus').on("click", function (e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
      })
    });

    $('#destination_charges .btn_minus').on("click", function (e) {
      e.preventDefault();
      $(this).parent('div').parent('div').parent('div').remove();
    })
    //Datemask dd/mm/yyyy
    

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $(document).ready(function () {
      $("#state").select2({
        tags: true
      });

      $("#btn-add-state").on("click", function () {
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


    $(document).ready(function () {
      $("#state2").select2({
        tags: true
      });

      $("#btn-add-state2").on("click", function () {
        var newState2Val = $("#new-state2").val();
        // Set the value, creating a new option if necessary
        if ($("#state2").find("option[value='" + newState2Val + "']").length) {
          $("#state2").val(newState2Val).trigger("change");
        } else {
          // Create the DOM option that is pre-selected by default
          var newState2 = new Option(newState2Val, newState2Val, true, true);
          // Append it to the select
          $("#state2").append(newState2).trigger('change');
        }
      });
    });

    $(document).ready(function () {
      $("#state3").select2({
        tags: true
      });

      $("#btn-add-state3").on("click", function () {
        var newState3Val = $("#new-state3").val();
        // Set the value, creating a new option if necessary
        if ($("#state3").find("option[value='" + newState3Val + "']").length) {
          $("#state3").val(newState3Val).trigger("change");
        } else {
          // Create the DOM option that is pre-selected by default
          var newState3 = new Option(newState3Val, newState3Val, true, true);
          // Append it to the select
          $("#state3").append(newState3).trigger('change');
        }
      });
    });

    //Initialize Select2 Elements



    jQuery(function ($) {
      $('form').bind('submit', function () {
        $(this).find(':input').prop('disabled', false);
      });
    });
  </script>



</body>

</html>