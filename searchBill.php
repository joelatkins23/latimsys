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
     $post = array();
     $consulta = mysqli_query($connect, "SELECT * FROM gl_account order by id ")
     or die ("Error al traer los Agent");
     while ($rowgl = mysqli_fetch_array($consulta)){
         $post[] = $rowgl;      
     }
?>
<!doctype html>
<html style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Latim Cargo & Trading | Search Bills</title>
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
<style>
    table.dataTable, table.dataTable th, table.dataTable td {
    height: auto;
}
</style>
</head>

<body class="hold-transition sidebar-mini">
    <div id="load_screen">
        <div id="loading"><img src="./img/logo.png" style="width:180px; padding:5px;"><br><span style="font-size:26px; color:yellow; position:relative; left:18px;">LOADING...</span></div>
    </div>
    <div class="wrapper" style="height:auto">
        <?php include 'layout/header.php' ?>
        <?php include 'layout/sidebar.php' ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Biils
                    <small>Search</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Search Biils</li>
                </ol>
            </section>
            <section class="content">
                <div class="searchPage shadow2" style="background:white; width:90%; margin-left:-45%;">
                    <div class="row" style="border-bottom: 1px solid #000; margin-left: 0; margin-right: 0;">
                        <div class="col-md-12">                            
                            <h3 class="text-center">Search Bills</h3>                          
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id='empTable' width="100%" class='display dataTable'>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th style="width:250px;">Branch</th>
                                            <th style="width:250px;">Account</th>
                                            <th>#INV</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                            <th>Cost Center</th>
                                            <th>Warehouse</th>
                                            <th>File</th>
                                            <th>House</th>
                                            <th>Due date</th>
                                            <th>Action</th>
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
    <div id="editBill" class="modal fade" role="dialog" style="overflow: auto;">
        <div class="modal-dialog modal-lg">
        </div>
    </div>
    <div id="file_upload" class="modal fade" role="dialog" >
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
                    <input type="file" id="image_file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
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
    <script>
        $(".sidebar-menu li a").removeClass('active');
        $(".treeview").removeClass('active');
        $("#bill_menu").addClass("active");
        $("#bill_menu .sub_search_create").addClass("active");
        $("#bill_menu #search_bills_menu").addClass("active");
        $('input[type="file"]').imageuploadify();
        
        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        function ConfirmDelete() {
            return confirm("Are you sure you want to delete?");
        }
        var from = '',
            to = '';
        $('.select2').select2();
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
                [0, "desc"]
            ],
            'columnDefs': [{
                orderable: false,
                targets: [12]
            }],
            'ajax': {
                'url': 'ajax/ajaxfile_bill.php',
                // "data": function(d) {
                //     d.from = Getfrom();
                //     d.to = Getto();
                // }
            },
            'columns': [{
                data: 'date'
            }, {
                data: 'branch_name'
            }, {
                data: 'account_name'
            }, {
                data: 'inv'
            }, {
                data: 'description'
            }, {
                data: 'amount'
            }, {
                data: 'paid'
            }, {
                data: 'cost_center'
            }, {
                data: 'warehouse'
            }, {
                data: 'file'
            },{
                data: 'house'
            }, {
                data: 'due_date'
            }, {
                data: 'action'
            }, ]
        });
        function editBill(id){
            $.get('editBill.php?id=' + id, function(response) {
                $('#editBill .modal-dialog').html(response);
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
                $("#edit_bill").submit(function(e) {
                      event.preventDefault(); //prevent default action 
                      var post_url = $(this).attr("action"); //get form action url
                      var form_data = $(this).serialize(); //Encode form elements for submission                      
                      $.post( post_url, form_data, function( response ) {  
                          table.ajax.reload( null, false );     
                          swal({
                              title: "Bill!",
                              text: "Bill updated successful!!",
                              icon: "success",
                            });   
                      });
                      $("#editBill").modal('hide'); 
                  });
                $("#delete_bill").submit(function(e) {
                  event.preventDefault(); //prevent default action 
                  var post_url = $(this).attr("action"); //get form action url
                  var form_data = $(this).serialize(); //Encode form elements for submission

                  $.post(post_url, form_data, function(response) {
                      $("#editBill").modal('hide');
                      table.ajax.reload(null, false);
                      swal({
                          title: "Bill!",
                          text: "Bill deleted successful!",
                          icon: "error",
                      }); 
                  });
              });
              $(".file_upload_btn").on("click", function(){
                $("#file_upload").modal("show");                
              });
              
            $(".td_file_remove").on("click", function(e){
                var name=$(this).parent('td').parent('tr').find("td:eq(0)").text();
                var id=$(this).parent('td').parent('tr').find("input[name='td_fileid[]']").val();
                $(this).parent('td').parent('tr').remove(); 
                $.ajax({
                    url: './curd_bill.php',
                    data: {
                    'deleteupdatefile':'delete',
                    'name':name,
                    'id':id
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
        });
        $("#editBill").modal('show');
        
    }
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
                        html+='<input type="hidden"  name="td_fileid[]" value="" >';             
                        html+='</tr>';
                }
                $(".file_table tbody").append(html);
                $(".td_file_remove").on("click", function(e){
                    var name=$(this).parent('td').parent('tr').find("td:eq(0)").text();
                    var id=$(this).parent('td').parent('tr').find("input[name='td_fileid[]']").val();
                    $(this).parent('td').parent('tr').remove(); 
                    $.ajax({
                        url: './curd_bill.php',
                        data: {
                        'deleteupdatefile':'delete',
                        'name':name,
                        'id':id
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
 
    </script>
</body>

</html>