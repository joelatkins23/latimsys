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
<head >
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
    <title>Latim Cargo & Trading | Search Quotations</title>
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
    <script src="./plugins/datepicker/bootstrap-datepicker.js"></script>    
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
  <div class="wrapper" style="height:auto">
    <?php include 'layout/header.php' ?>
    <?php include 'layout/sidebar.php' ?>
    <div class="content-wrapper">
      <section class="content-header">
          <h1>
            Quotations 
            <small>Search</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Search Quotations</li>
          </ol>
      </section>
      <section class="content">
          <div class="searchPage shadow2" >
            <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                <div class="col-md-offset-3 col-md-5 text-center">
                    <h3 class="text-center" style="font-weight:bold">Search Quotations</h3>
                </div>
                <div class="col-md-4 text-center" style="margin-bottom:10px;">
                    <p class="text-center">Change Status</p>
                    <form class="form-inline">
                    <div class="form-group">
                        <select name="statusUpdate" id="statusUpdate" class="form-control select2" style="width:150px; font-size:13px;">
                          <option value="PENDING">Pending</option>
                          <option value="READY TO CONTACT">Ready to contact</option>
                          <option value="CHECK NOTES">Check Notes</option>
                          <option value="IN PROCESS">In process</option>
                          <option value="SHIPPED">Shipped</option>
                          <option value="IN WAREHOUSE">In Warehouse</option>
                        </select>
                    </div>
                    <button type="button" id="statusUpdate_btn" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
            <div class="row" style="margin-top:20px;">
              <form action="#" id="filter">
                  <div class="col-md-2">                        
                      <div class=" input-group">
                          <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                          <input type="text" class="form-control" data-provide="datepicker" id="from"
                data-date-format="yyyy-mm-dd" laceholder="To" value=""  autocomplete="off"  placeholder="From">
                      </div>                          
                  </div>
                  <div class="col-md-2">                        
                      <div class=" input-group">
                          <input t type="text" class="form-control" data-provide="datepicker" id="to"
                data-date-format="yyyy-mm-dd" laceholder="To" value="" autocomplete="off"  placeholder="To">
                      </div>                    
                  </div>
                  <div class="col-md-2">
                      <div class="form-group row">                            
                          <button  type="submit" class="btn btn-success "><i class="fa fa-search"></i>&nbsp;Filter</button>                                
                      </div>
                  </div>
              </form>
              <div class="col-md-6">
                <div class="form-group text-right">                            
                    <button type="button" class="btn btn-danger download_excel">
                    <i class="fa fa-file"></i>&nbsp;Download EXCEL</button>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                      <table id='empTable' style="width:100%;" class='display dataTable'>
                          <thead>
                              <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Quotation#</th>
                                <th class="text-center">Client</th>
                                <th class="text-center">Origin</th>
                                <th class="text-center">Destination</th>
                                <th class="text-center">Service</th>
                                <th class="text-center">Agent</th>
                                <th class="text-center">Shorcuts</th>
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
    <div id="editquotation" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
        </div>
    </div>
    <div id="viewNotes" class="modal fade" role="dialog">
        <div class="modal-dialog">
        </div>
    </div> 
    <div id="editclient" class="modal fade" role="dialog">
      <div class="modal-dialog">
      </div>
    </div>   
    <script> 
    $(".sidebar-menu li a").removeClass('active');
    $(".treeview").removeClass('active');
    $("#quotations_list").addClass("active");
    $("#quotations_list #search").addClass("active");

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      }); 
        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }      
            var from='', to='', jobCheckval;
            $('.select2').select2();
            var table=$('#empTable').DataTable({
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
                    [1, "desc"]
                ],
                'columnDefs': [{
                    orderable: false,
                    targets: [7, 8]
                }],
                'ajax': {
                    'url': 'ajaxfile_quotation.php',
                    "data" :function(d){
                        d.from = Getfrom();
                        d.to = Getto();
                        d.jobCheckval = GetjobCheck();                      
                    }
                },              
                'columns': [{
                    data: 'fecha'
                }, {
                    data: 'id'
                }, {
                    data: 'client_name'
                }, {
                    data: 'origin'
                }, {
                    data: 'destination'
                }, {
                    data: 'service'
                }, {
                    data: 'agent_name'
                },
                 {
                    data: 'shortcut'
                }, {
                    data: 'action'
                }, ]
            });
        function editquotation(id) {
            $.get('edit_quotation.php?id='+id,function(response){ 
                    $('#editquotation .modal-dialog').html(response); 
                        $("#edit_quotation").submit(function(e) {
                            event.preventDefault(); //prevent default action 
                            var post_url = $(this).attr("action"); //get form action url
                            var form_data = $(this).serialize(); //Encode form elements for submission
                            
                            $.post( post_url, form_data, function( response ) { 
                                $("#editquotation").modal('hide');
                                table.ajax.reload( null, false );     
                                swal({
                                    title: "Quotations!",
                                    text: "Quotations Updated successful!!",
                                    icon: "success",
                                 });   
                            });
                        });
                        $("#by_boxes_content .btn_plus").on("click", function(e){
                          e.preventDefault();
                          var html='<div class="item">';
                              html+='<div class="form-group row">';
                              html+='<div class="col-md-2 col-item">';
                              html+='<input type="text" name="byBoxes_qtyX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-2 col-item">';
                              html+='<input type="number" name="byBoxes_widthX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-2 col-item">';
                              html+='<input type="number"  name="byBoxes_lenghtX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-2 col-item">';
                              html+='<input type="number"  name="byBoxes_heightX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-2 col-item">';
                              html+='<input type="number"  name="byBoxes_weightX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-1 col-item">';
                              html+='<button  type="button" class="btn btn_minus">-</button>';
                              html+='</div>';
                              html+='</div>';
                              html+='</div>';
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
                        $("#freight_charges .btn_plus").on("click", function(e){
                          e.preventDefault();
                          var html='<div class="item">';
                              html+='<input type="hidden" name="freightid[]" value="">';
                              html+='<div class="form-group row">';
                              html+='<div class="col-md-4 col-item">';
                              html+='<input type="text" name="freightDescX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" name="freightChargeX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" value="1" name="freightChargeQX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-1 col-item">';
                              html+='<button  type="button" class="btn btn_minus">-</button>';
                              html+='</div>';
                              html+='</div>';
                              html+='</div>';
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
                        $("#origin_charges .btn_plus").on("click", function(e){
                          e.preventDefault();
                          var html='<div class="item">';
                              html+='<input type="hidden" name="originid[]" value="">';
                              html+='<div class="form-group row">';
                              html+='<div class="col-md-4 col-item">';
                              html+='<input type="text" name="originDescX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" name="originChargeX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" value="1" name="originChargeQX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-1 col-item">';
                              html+='<button  type="button" class="btn btn_minus">-</button>';
                              html+='</div>';
                              html+='</div>';
                              html+='</div>';
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
                        $("#destination_charges .btn_plus").on("click", function(e){
                          e.preventDefault();
                          var html='<div class="item">';
                              html+='<input type="hidden" name="destinationtid[]" value="">';
                              html+='<div class="form-group row">';
                              html+='<div class="col-md-4 col-item">';
                              html+='<input type="text" name="destinationDescX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" name="destinationChargeX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-3 col-item">';
                              html+='<input type="number" value="1" name="destinationChargeQX[]" class="form-control">';
                              html+='</div>';
                              html+='<div class="col-md-1 col-item">';
                              html+='<button  type="button" class="btn btn_minus">-</button>';
                              html+='</div>';
                              html+='</div>';
                              html+='</div>';
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
                        $("#delete_quotation").submit(function(e) {
                            event.preventDefault(); //prevent default action 
                            var post_url = $(this).attr("action"); //get form action url
                            var form_data = $(this).serialize(); //Encode form elements for submission
                            
                            $.post( post_url, form_data, function( response ) {                                
                                $("#editquotation").modal('hide');
                                table.ajax.reload( null, false );  
                                swal({
                                    title: "Quotations Delete!",
                                    text: "Quotations deleted successful!",
                                    icon: "error",
                                });
                            });
                        });
                });                
            $("#editquotation").modal('show');
        }
        function editClientmodal(id) {
          $.get('edit_bill_warehouser.php?id='+id,function(response){ 
            $("#editclient .modal-dialog").html(response); 
            $("#edit_warehouse_bill").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editclient").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "Client!",
                          text: "Client Information Updated successful!",
                          icon: "success",
                      }); 
                  });
              });
              });
              $("#editclient").modal('show');
        }
        function Getfrom(){
            from=$("#from").val();
            return $("#from").val();
        }
        function Getto(){
            to=$("#to").val();
            return $("#to").val();
        }
        function GetjobCheck(){
            return jobCheckval;
        }
        $("#filter").submit(function(e) {      
            swal({
            title: "Date Fiter!",
            text: "Data filtered successful!",
            icon: "success",
            });
            table.ajax.reload();
        });   
        function viewNotes(id) {
            $.get('createnote_quo.php?id='+id,function(response){ 
                    $('#viewNotes .modal-dialog').html(response); 
                    $("#create_quotation").submit(function(e) {
                        event.preventDefault(); //prevent default action 
                        var post_url = $(this).attr("action"); //get form action url
                        var form_data = $(this).serialize(); //Encode form elements for submission
                        
                        $.post( post_url, form_data, function( response ) {
                           
                            $("#viewNotes").modal('hide');
                            table.ajax.reload( null, false ); 
                            swal({
                                title: "New Notes!",
                                text: "New Notes created successful!",
                                icon: "success",
                                });
                        });
                    });    
                });
            $("#viewNotes").modal('show');
        }
       $("#statusUpdate_btn").on("click", function(e){      
            var  jobCheck=[];
            $("#empTable tbody tr [name='jobCheck[]']:checked").each(function (e,ele) {
                jobCheck.push(ele.value);
            })
            jobCheckval = Object.assign({}, jobCheck);
            if(jobCheck.length>0){
                $.ajax({
                method: 'POST',
                url: "./curd.php",
                data: {
                    jobCheck:jobCheck,
                    question_Update:'question_Update',
                    statusUpdate: $("#statusUpdate").val()
                    }
                })
                .done(function (response) {
                    swal({
                        title: "Status!",
                        text: "Status updated successful!",
                        icon: "success",
                    });  
                    table.ajax.reload( null, false ); 
                   
                })
            }else{
                alert("Please check checkbox!!")
            }
             
       });
       $(".download_excel").on("click", function(e){
            window.open("./excel/excel_quotation.php?from="+from+"&to="+to);
        })
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