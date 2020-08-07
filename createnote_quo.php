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
 $consulta2 = mysqli_query($connect, "SELECT a.*,IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name FROM quotations  a left join accounts b on a.client_id=b.id WHERE a.id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
                  

 while ($row = mysqli_fetch_array($consulta2)){  

            $jobId = $row['id'];
            $agent_name= $row['agent_name'];            
            $service= $row['service'];
            $customer_if = $row['client_name'];

            

?>

<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong> Create </strong> Job Order #<?php echo $id;?> </h4>
    </div>
    <div class="modal-body" style="margin:20px">
        <form id="create_quotation" action="./curd.php" method="POST">
            <input type="hidden" name="create_quotation"  value="edit">
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
                                <select name="commodity" id="" class="form-control">
                                    <option value="">Select Commodity</option>
                                     <?php $consulta223 = mysqli_query($connect, "SELECT DISTINCT commodity FROM joborders  ") or die ("Error al traer los datos");

                                        while ($row223 = mysqli_fetch_array($consulta223)){ 
                                        $commodity=$row223['commodity'];
                                        ?>

                                        <option value="<?php echo $commodity; ?>"><?php echo $commodity; ?></option>
                                        <?php }  ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $jobId; ?>" name="jobOrderId">
                <input type="hidden" value="<?php echo $noteBy; ?>" name="noteBy">
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
                    <?php $consultaNotes = mysqli_query($connect, "SELECT * FROM notes WHERE jobOrderId='$jobId' ORDER BY id DESC ") or die ("Error al traer los datos");

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
