<?php 
include 'conn.php';
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
    $consulta2 = mysqli_query($connect, "SELECT * FROM tickets WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $jobId = $row['id'];
        $service= $row['service'];
        $agent_id= $row['agent_id'];
        $supplier_address= $row['supplier_address']; 
        $service= $row['service'];
        $imagen1 = $row['imagen1'];
        $imagen2 = $row['imagen2'];
        $imagen3 = $row['imagen3'];
        $type = $row['type'];
        $notes = $row['notes'];
        $client= $row['name'];
        $job_order= $row['job_order'];
        $supplier= $row['supplier'];
        $supplier_phone= $row['supplier_phone'];
        $tracking_number = $row['tracking_number'];
        $warehouse_receipt = $row['warehouse_receipt'];
        $status= $row['status'];        
}

 
?>

<!-- Modal content-->
<style>
.title_span{
    font-size:12px; 
    color:red; 
    font-weight:600;
}
.icon {
    font-size: 57px !important;
    color: black !important;
}
</style>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="row">
            <div class="col-md-4">
                <h4 class="modal-title"><strong>Inquiry</strong> Ticket #<?php echo $id;?>
                <form method="POST" id="delete_ticket" action="./curd.php" style="display: contents;"> 
                    <input  type="hidden" name="jobId" value="<?php echo $id;?>">
                    <input  type="hidden" name="order_ticket" value="delete">
                    <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
                </form>
                </h4>   
            </div>
            <div class="col-md-4 text-center" id="title">
                <h4 class="modal-title"><strong>Inquiry</strong> Missing Cargos <br><span class="title_span">[Find Warehouse Receipt Number]</span></h4>
            </div>
            <div class="col-md-3" style="text-align: center;background: #B80008;padding: 5px;color: #fff;">
                <div class="checkbox_content">
                    <label for="">Change Ticket</label><br>
                    <div class="">
                        <label class="radio-inline"><input type="radio" checked name="ticket_status" value="1">Missing Cargo</label>
                        <label class="radio-inline"><input type="radio" name="ticket_status" value="2">Warehouse Inquiry</label>                
                    </div>           
                </div>
            </div>
        </div>
    </div>
        <div class="modal-body">
            <div class="row" style="margin:30px">
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <i class="fa fa-paperclip icon"></i>
                            <h4 class="title change_tracking_text">Tracking</h4>
                        </div>
                    </div>  
                    <form action="./curd.php" id="tracking_photo" method="post" enctype="multipart/form-data">
                        <input  type="hidden" name="jobId" value="<?php echo $id;?>">
                        <input  type="hidden" name="tracking_photo" value="edit">              
                        <div class="form-group row" id="tracking_number">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-barcode input-fa"></i></div>
                                    <input type="text" name="tracking_number"  class="form-control" value="<?php echo $tracking_number; ?>"  placeholder="Tracking Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <label>Change File/Photo ↓</label>
                                    <input type="file" class="form-control" name="tracking_img" style="padding-right: 30px;">
                                    <i class="fa fa-file-image-o" style="position: absolute;right: 10px;top: 36px;z-index: 1000;"></i>                               
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <img src="./images/Tickets/78-2.jpeg" id="photo_img" alt="" class="img-responsive" style="padding: 30px;">                                
                            </div>
                        </div>   
                    </form>                 
                </div>
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-offset-3 col-md-6" style="text-align: center;background: #B80008;padding: 5px;color: #fff;">
                            <label for="">Inquiry solved?</label><br>
                            <div class="">
                                <label class="radio-inline"><input type="radio" checked name="inquiry_status" value="1">No</label>
                                <label class="radio-inline"><input type="radio" name="inquiry_status" value="2">Yes</label>                
                            </div> 
                        </div>
                        <dvi class="col-md-12">
                            <h4 class="title">Inquiry Information</h4>
                        </dvi>
                    </div>
                    <form action="./curd.php" id="inquiry_informtion" method="post" >
                        <input  type="hidden" name="jobId" value="<?php echo $id;?>">
                        <input  type="hidden" name="inquiry_informtion" value="edit">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                    <input type="text" class="form-control" name="client"  value="<?php echo $client; ?>" placeholder="Client">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                    <input type="text" name="job_order" class="form-control" value="<?php echo $job_order; ?>" placeholder="Job Order">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                                    <select name="service" id="" class="form-control" style="width:100%">
                                        <option <?php if($service=='Air Service'){echo "selected";} ?> value="Air Service">Air Service</option>
                                        <option <?php if($service=='Ocean Service'){echo "selected";} ?> value="Ocean Service">Ocean Service</option>
                                        <option <?php if($service=='Pending'){echo "selected";} ?> value="Pending">Pending</option>
                                    </select>                           
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                    <textarea name="notes" id="" cols="30" rows="4" class="form-control"><?php echo $notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                                    <input type="text" name="warehouse_receipt" class="form-control" value="<?php echo $warehouse_receipt; ?>" placeholder="Warehouse ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button  type="submit" class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                        <div class="form-group row" style="text-align: center;">
                            <div class="col-md-12">
                                <h4 class="title">Supplier Information</h4>
                            </div>
                        </div>                    
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                    <input type="text" name="supplier" class="form-control" value="<?php echo $supplier; ?>" disabled placeholder="Contact Person">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-phone input-fa"></i></div>
                                    <input type="text" name="supplier_phone" class="form-control" value="<?php echo $supplier_phone; ?>" placeholder="Telephone">                           
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                    <textarea name="supplier_address" id="" cols="30" rows="4" class="form-control"><?php echo $supplier_address; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <i class="fa fa-comment icon"></i>
                            <h4 class="title">Service Data</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                    <select  placeholder="Select Agent"  <?php if ($level!='Seller'){ ?>
                                        name="agent_name"
                                        <?php } ?> class="form-control select2" <?php if ($level=='Seller'){ ?>
                                        disabled
                                        <?php } ?> style="width:100%;">
                                        <?php 
                                         $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");
                                         while ($rowList = mysqli_fetch_array($consultaList)){ 
                                        ?>
                                            <option <?php if($agent_id==$rowList['id']){echo "selected";} ?> value="<?php echo $rowList['id']; ?>"><?php echo $rowList['name']; ?></option> 
                                         <?php } ?>
                                    </select>                           
                            </div>
                        </div>
                    </div>  
                    <form action="./curd.php" id="create_note" method="POST" enctype="multipart/form-data">
                        <input  type="hidden" name="jobId" value="<?php echo $id;?>">
                        <input  type="hidden" name="create_note" value="edit">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <label>File/Photo ↓</label>
                                    <input type="file" class="form-control" name="image" style="padding-right: 30px;">
                                    <i class="fa fa-file-image-o" style="position: absolute;right: 10px;top: 36px;z-index: 1000;"></i>                               
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                    <textarea name="supplier_address" id="supplier_address" cols="30" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <p>Notes History ↓</p>
                        </div>
                        <div class="col-md-12" style="max-height: 350px;overflow-y: auto;">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">By</th>
                                        <th class="text-center">Note</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $consultaNotes = mysqli_query($connect, "SELECT * FROM ticket_notes WHERE ticket_id='$id' ORDER BY id DESC ") or die ("Error al traer los datos");
                                    while ($rowNotes = mysqli_fetch_array($consultaNotes)){  
                                    $id_ticket_note = $rowNotes['id'];
                                    $agent_name_notes = $rowNotes['agent_name'];
                                    $note= $rowNotes['note'];
                                    $fecha_note= $rowNotes['fecha'];
                                    $file= $rowNotes['imagen']; 
                                ?>
                                    <tr id="tr_<?php echo $id_ticket_note; ?>">  
                                        <td><a Onclick="return ConfirmDelete()" href="./curd.php?id_ticket_note=<?php echo $id_ticket_note; ?>&id_ticket=<?php echo $id; ?>"><i class="fa fa-close" style="background: red; padding: 3px 4px;border-radius: 50%;"></i></a></td>
                                        <td style="color:black; text-align:center; font-size:10px"><center><?php echo $fecha_note; ?></center></td>
                                        <td style="color:black; text-align:center; font-size:10px"><center><?php echo $agent_name_notes; ?></center></td>
                                        <td style="color:black; text-align:center; font-size:10px"><center><?php echo $note; ?></center></td>
                                        <td style="color:black; text-align:center;">
                                            <a style="font-size:10px;" href='download.php?file=images/<?php echo $file; ?>'>
                                                <?php   $file= ($file) ? explode("../images/Tickets/notes/",$file)[1] :''; ?>
                                                <?php echo $file; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    
                    </div>                
                </div>
            </div>
        </div>        
    </form>
</div>
<script>
    $(".select2").select2();
</script>
