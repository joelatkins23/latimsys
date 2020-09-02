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
     if(isset($_GET['message'])){
      $message= $_GET['message'];
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>System | Create Bills</title>
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
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>  
    <script src="dist/js/app.min.js"></script>
   
    <script>
        window.addEventListener("load", function() {
            var load_screen = document.getElementById("load_screen");
            document.body.removeChild(load_screen);
        });
    </script>
    <style>
      .custom_table thead tr th {
        background: #B80008;
        border: none;
        font-weight: 400;
        color: white;
    }
    </style>
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
          Bills 
          <small>Create</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Create Bills</li>
        </ol>
      </section>
      <?php if ($message=='success'){ ?>
        <div  id="mydiv" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;top: 30px;
        right: 0px;z-index: 10000;opacity: 1; border:unset;padding: 0;">
          <div style="padding:15px;margin-right:10px;">
          <strong>New Bills Created Successful</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
        </div>
      <?php }?>
      <!-- Main content -->
      <section class="content"> 
        <form action="./curd_bill.php" method="post">   
          <input type="hidden" name="createbill" value="create">
          <div class="row" style="margin: 0px;"> 
            <div class="col-md-offset-1 col-md-10 shadow2" style="background: white;margin-top:50px">
              <div class="row">
                <div class="col-md-12 text-center" style="border-bottom:1px solid #555555; padding-bottom:10px;">
                  <h3 style="text-align:center; color:black; font-weight:400; font-size:20px; ">Create Bills</h3>
                </div>
              </div>
                <div class="row" style="margin:30px 20px">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Currency</span>
                          <select name="currency" id="" class="form-control select2"  data-placeholder="Select Currency">
                              <option value="">Select Currency</option>
                              <option value="USD">USD - US Dollar</option>                           
                            </select> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Date</span>
                            <input type="text" class="form-control" data-provide="datepicker" id="date"
                                    data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date('Y/n/d'); ?>"  name="date"  autocomplete="off"  placeholder="Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Branch</span>
                          <select name="branch" id="" class="form-control select2"  data-placeholder="Select Branch" required>
                              <option value="">Select Branch</option>
                              <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM branches  order by id ")
                                or die ("Error al traer los Agent");
                                while ($row = mysqli_fetch_array($consulta)){
                            
                                    $ID=$row['id'];
                                    $station=$row['station'];
                                    $company=$row['company'];
                                  
                              ?>  
                              <option value="<?php echo $ID;?>"><?php echo $station;?> - <?php echo $company;?></option>
                              <?php } ?>                       
                            </select> 
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Accounts</span>
                            <select name="account" id="" class="form-control select2" data-placeholder="Select Account" required style="max-width:100%; min-width:100%" >
                              <option value="">--Select Account--</option>
                            <?php 
                              $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                              or die ("Error al traer los Agent");
                              while ($row = mysqli_fetch_array($consulta)){
                          
                                  $ID=$row['id'];
                                  $name=$row['name'];
                                  $company=$row['company'];
                                  $city=$row['city'];
                                
                            ?>
                              <option value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> | <?php echo $company; ?></option>
                              <?php } ?>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Inv#</span>
                          <input type="text" name="inv" class="form-control" placeholder="Inv#">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Description</span>
                          <input type="text" name="description" class="form-control" placeholder="Description">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Due Date</span>
                            <input type="text" class="form-control" data-provide="datepicker" id="date"
                                    data-date-format="yyyy/m/d" laceholder="Due Date" value="<?php echo date('Y/n/d'); ?>"  name="due_date"  autocomplete="off"  placeholder="Due Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Amount</span>                          
                          <input type="text" name="amount" disabled class="form-control" placeholder="Amount">
                          <input type="hidden" name="amount" disabled class="form-control" placeholder="Amount">
                        </div>
                      </div>
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-md-4">
                        <div class="checkbox" style="margin-top:0px;">
                          <label class="control-label">
                            Payroll&nbsp;<input type="checkbox" style="margin-left:0px;" name='payroll'> 
                          </label>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Exchange</span>
                            <input type="text" name="exchange" class="form-control" placeholder="Exchange">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">Cost Center</span>
                          <input type="text" name="cost_center" class="form-control" placeholder="Cost Center">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">WareHouse</span>
                          <input type="number" name="warehouse" class="form-control" value="0" placeholder="WareHouse">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">File</span>
                          <input type="number" name="file" class="form-control" placeholder="" value="0">
                        </div>
                      </div>                      
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon span_custom">House</span>
                            <input type="number" name="house" class="form-control" placeholder="" value="0">
                        </div>
                      </div>                    
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table file_table table-bordered" style="width:100%" >
                            <thead>
                              <tr>
                                <th class="text-center"  style=" width:250px;background: #B80008;color:white">File Name</th>
                                <th class="text-center"  style=" background: #B80008;color:white">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="form-group row" style="margin-top:30px;">
                      <div class="col-md-offset-3 col-md-6">
                        <button  type="button"class="btn btn-success file_upload_btn btn-lg"><i class="fa fa-cloud-upload"></i>&nbsp;File Upload</button>
                      </div>                    
                    </div>
                  </div>
                  <div class="col-md-12 text-right">
                    <button  type="button"class="btn btn-danger bills_td_add"><i class="fa fa-plus"></i>&nbsp;Add</button>
                  </div>
                  <dic class="col-md-12" style="margin-top:10px;">
                    <div class="table-responsive">
                      <table  style="width:100%;" class='custom_table table table-bordered' >
                          <thead>
                              <tr class="text-center" >
                                  <th class="text-center">Date</th>
                                  <th class="text-center">File</th>
                                  <th class="text-center">House</th>
                                  <th class="text-center">WH</th>
                                  <th class="text-center" style="width:300px;">G/L<br>Account</th>
                                  <th class="text-center">Description</th>
                                  <th class="text-center">Amount</th>
                                  <th class="text-center">IVA</th>
                                  <th class="text-center">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <input type="text" class="form-control" data-provide="datepicker"  required
                                    data-date-format="yyyy/m/d" laceholder="Date" value=""  name="td_date[]"  autocomplete="off"  placeholder="Date">
                              </td>
                              <td>
                                <input type="text" class="form-control" value="0" name="td_file[]">
                              </td>
                              <td>
                                <input type="text" class="form-control" value="0" name="td_house[]">
                              </td>
                              <td>
                                <input type="text" class="form-control" value="0" name="td_wh[]">
                              </td>
                              <td>
                                <select name="td_account[]" id="" class="form-control select2" data-placeholder="Select G/L Account" required>
                                <option value="">Select G/L Account</option>
                                <?php 
                                $post = array();
                                $consulta = mysqli_query($connect, "SELECT * FROM gl_account order by id ")
                                or die ("Error al traer los Agent");
                                while ($rowgl = mysqli_fetch_array($consulta)){
                                    $post[] = $rowgl;
                                    $ID=$rowgl['id'];
                                    $name=$rowgl['name'];
                                    $title=$rowgl['title'];
                                  
                              ?>
                              <option value="<?php echo $ID; ?>"><?php echo $name; ?> | <?php echo $title; ?></option>
                              <?php } ?>
                                </select>
                              </td>                             
                              <td>
                                <input type="text" class="form-control" name="td_desc[]">
                              </td>
                              <td>
                                <input type="text" class="form-control text-right" value="0" name="td_amount[]">
                              </td>
                              <td>
                                <input type="text" class="form-control text-right"  value="0" name="td_iva[]">
                              </td>
                              <td>
                                <i class="fa fa-trash action td_remove"></i>
                              </td>
                            </tr>
                          </tbody>
                      </table>
                    </div>
                  </dic>
                  <div class="col-md-12 text-right" style="margin-top:10px;">
                      <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                  </div>
                </div>
              </div>          
            </div>
          </div>     
        </form> 
      </section>
  </div>
</div>
<div id="file_upload" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
        </div>
        <div class="modal-body" style="margin:20px;">
        <form action="./curd_bill.php" id="addfile" method="post" enctype="multipart/form-data">
          <input type="hidden" id="bill_fileupload" name="bill_fileupload" value="add">
          <div class="row">
            <div class="col-md-12">
                <input type="file" id="image_file" name="image_file[]"  class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
            </div>
            <div class="col-md-12 text-center" style="margin:20px auto;">
              <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i>&nbsp;Upload</button>
            </div>
          </div>
        </form>
        </div>        
      </div>
    </div>
</div>
<!-- Page script -->
<script>
  $(".sidebar-menu li a").removeClass('active');
  $(".treeview").removeClass('active');
  $("#bill_menu").addClass("active");
  $("#bill_menu .sub_menu_create").addClass("active");
  $("#bill_menu #create_bills_menu").addClass("active");
  $(".select2").select2();
  $('input[type="file"]').imageuploadify();
  setTimeout(fade_out, 3000);
    function fade_out() {
      $("#mydiv").fadeOut().empty();
     
    }
  $(".file_upload_btn").on("click", function(){
    $("#file_upload").modal("show");
    
  });
  $("#addfile").submit(function(e) {
      event.preventDefault(); //prevent default action 
      var post_url = $(this).attr("action"); //get form action url
      var fd = new FormData();
      var totalfiles = document.getElementById('image_file').files.length;
      for (var index = 0; index < totalfiles; index++) {
          fd.append("image_file[]", document.getElementById('image_file').files[index]);
      }
      fd.append( 'bill_fileupload', 'add');
      $.ajax({
      url: './curd_bill.php',
      data: fd,
      processData: false,
      cache: false,
      contentType: false,
      type: 'POST',
      success: function(data){         
          $("#file_upload").modal('hide');         
            swal({
                title: "File!",
                text: "New Files Uploaded successful!!",
                icon: "success",
            }); 
            $('input[type="file"]').val("");
            $(".imageuploadify-container").remove();
             var rep=JSON.parse(data); 
             var html="";
             for(var i=0; i<rep.length;i++){
                html+='<tr>';
                html+='<td class="" ><a href="./images/bills/'+rep[i].name+'" target="blank">'+rep[i].name+'</a><input type="hidden"  name="td_filename[]" value="'+rep[i].name+'"></td>';
                html+='<td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>';               
                html+='</tr>';
             }
             $(".file_table tbody").append(html);
              $(".td_file_remove").on("click", function(e){
                var name=$(this).parent('td').parent('tr').find("td:eq(0)").text();
                $(this).parent('td').parent('tr').remove(); 
                $.ajax({
                    url: './curd_bill.php',
                    data: {
                      'deletefile':'delete',
                      'name':name
                    },
                    type: 'POST',
                    success: function(data){
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
  $(".bills_td_add").on("click", function(e){
    var gl_lists=<?php echo json_encode($post); ?>;
    var html="";
      html+='<tr>';
      html+='<td>';
      html+='<input type="text" required class="form-control" data-provide="datepicker" data-date-format="yyyy/m/d" laceholder="Date" value=""  name="td_date[]"  autocomplete="off"  placeholder="Date">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control" value="0" name="td_file[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control" value="0" name="td_house[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control" value="0" name="td_wh[]">';
      html+='</td>';
      html+='<td>';

      html+='<select name="td_account[]" class="form-control select2" data-placeholder="Select G/L Account" required>';
      html+='<option value="">Select G/L Account</option>';
      for(var i=0; i<gl_lists.length;i++){
        html+='<option value="'+gl_lists[i].id+'">'+gl_lists[i].name+' | '+gl_lists[i].title+'</option>';      
      }   
      html+='</select>';
      html+='</td>';    
      html+='<td>';
      html+='<input type="text" class="form-control" name="td_desc[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control text-right" value="0" name="td_amount[]">';
      html+='</td>';
      html+='<td>';
      html+='<input type="text" class="form-control text-right" value="0" name="td_iva[]">';
      html+='</td>';
      html+='<td>';
      html+='<i class="fa fa-trash action td_remove"></i>';
      html+='</td>';
      html+='</tr>';
      $(".custom_table tbody").append(html);
      selectRefresh();
      $(".td_remove").on("click", function(e){
        $(this).parent('td').parent('tr').remove(); 
        total_calculator();
      });
      $(".custom_table  tbody tr input[name='td_amount[]']").keyup(function(e){
          total_calculator();
    })
  });
  $(".td_remove").on("click", function(e){
    $(this).parent('td').parent('tr').remove(); 
    total_calculator();
  });
  $(".custom_table  tbody tr input[name='td_amount[]']").keyup(function(e){
        total_calculator();
  })
  function selectRefresh() {
  $('.select2').select2({   
    allowClear: true,
    width: '100%'
  });
}
  function total_calculator(){
    var total_amount=0;
    $(".custom_table  tbody tr").each(function(index,ele){
        var amount=$(this)[0].children[6].children[0].value;      
        total_amount=total_amount+parseFloat(amount);       
      });
      $("input[name='amount']").val(total_amount);
  }
  $(function () {
    //Initialize Select2 Elements
   
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });   
  });
</script>


</body>
</html>
