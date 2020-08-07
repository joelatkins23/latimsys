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
           $client_id = $row['client_id'];            
            $service= $row['service'];
            $commodity= $row['commodity'];
            $wh_receipt= $row['wh_receipt'];
            $remark= $row['remark']; 
              
    $consulta_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$client_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($rowcustomer = mysqli_fetch_array($consulta_customer)){  
        $customer_company=$rowcustomer['company'];
        $customer_if = $rowcustomer['name'];
        if ($customer_company!='') { $customer_if .= ', '.$customer_company; }  
    }        
?>

<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong> Create Note for </strong> Job Order #<?php echo $id;?> </h4>
    </div>
    <div class="modal-body" style="margin:20px">
        <form id="create_order" action="./curd.php" method="POST">
            <input type="hidden" name="createnote"  value="edit">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $agent_name; ?>" disabled placeholder="Select Agent">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $customer_if; ?>" disabled placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $service; ?>" disabled placeholder="Ocean door to door">
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
                <input type="hidden" value="<?php echo $agent_name; ?>" name="noteBy">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea name="note" id="" cols="30" rows="7" class="form-control" placeholder="Write your note here..."></textarea>
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
        <div class="row">
            <div class="col-md-12">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">By</th>
                            <th class="text-center">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $consultaNotes = mysqli_query($connect, "SELECT * FROM notes WHERE jobOrderId='$id' ORDER BY id DESC ") or die ("Error al traer los datos");

                    while ($rowNotes = mysqli_fetch_array($consultaNotes)){  
                            $agent_name_notes = $rowNotes['agent_name'];
                            $note= $rowNotes['note'];
                            $fecha_note= $rowNotes['fecha']; ?>
                            <tr>
                                <td  class="text-center"><?php echo $fecha_note; ?></td>
                                <td class="text-center"><?php echo $agent_name_notes; ?></td>
                                <td class="text-center"><?php echo $note; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 <?php } ?>
