<?php 

require_once('conn.php');
session_start();
$id= $_GET['id'];
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
 $consulta2 = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
                  
 while ($row = mysqli_fetch_array($consulta2)){  
    $jobId = $row['id'];
    $supplier_id=$row['supplier_id'];
    $client_id = $row['client_id'];            
    $service= $row['service'];
    $commodity= $row['commodity'];
    $wh_receipt= $row['wh_receipt'];
    $remark= $row['remark']; 

    $consulta_supplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($rowsupplier = mysqli_fetch_array($consulta_supplier)){  
        $supplier_company= $rowsupplier['company'];
        $supplier_if = $rowsupplier['name'];
        if ($supplier_company!='') { $supplier_if .= ', '.$supplier_company; }
    }   

    $consulta_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$client_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($rowcustomer = mysqli_fetch_array($consulta_customer)){  
        $customer_company=$rowcustomer['company'];
        $customer_if = $rowcustomer['name'];
        if ($customer_company!='') { $customer_if .= ', '.$customer_company; }  
    } 
    $WHReceipt='';
    $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$id."' order by id desc limit 1 ") or die ("Error al traer los Agent");
    while ($rowWR = mysqli_fetch_assoc($consultaWR)){
        $WHReceipt=$rowWR['wr'];
    }
?>

<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong> Add Warehouse Receipt</strong> Job Order #<?php echo $id;?> 
        <form method="POST" id="delete_wr" action="./curd.php" style="display: contents;"> 
            <input  type="hidden" name="jobId" value="<?php echo $id;?>">
            <input  type="hidden" name="delete_wr" value="delete">
            <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
        </form>
        </h4>
    </div>
    <div class="modal-body" style="margin:20px">
        <form id="add_wr" action="./curd.php" method="POST">
            <input type="hidden" name="addwr"  value="addwr">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $customer_if; ?>" disabled placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $supplier_if; ?>" disabled placeholder="Company Name">
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $commodity; ?>" disabled placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $jobId; ?>" name="jobOrderId">
                <input type="hidden" value="<?php echo $agent_name; ?>" name="agent_name">
                <div class="col-md-6" style="margin-top:50px">
                    <div class="form-group row">
                        <div class="col-md-12">                            
                            <input name="wr" type="number" class="form-control" value="<?php echo $WHReceipt; ?>"  autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button  type="submit" class="btn btn-success btn-block">save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>       
    </div>
</div>
 <?php } ?>
