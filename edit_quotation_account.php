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
    $consulta2 = mysqli_query($connect, "SELECT * FROM quotations WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $jobId = $row['id'];
        $client_id= $row['client_id']; 

        $initial_date= $row['initial_date']; 
        $expiration_date= $row['expiration_date']; 
        $dt = new DateTime($initial_date);
        $initial_date = $dt->format('Y-m-d');
        $dt2 = new DateTime($expiration_date);
        $expiration_date = $dt2->format('Y-m-d');
        date_default_timezone_set('America/La_Paz');

        $origin= $row['origin']; 
        $destination= $row['destination']; 
        $agent_name= $row['agent_name'];
        $service= $row['service'];
        $commodity= $row['commodity'];
        $containerQuantity= $row['containerQuantity'];
        
     
}

 
?>

<!-- Modal content-->
<style>
.card{
    border: 1px solid #D2D6DE;
    padding: 15px;
    margin-bottom:20px;
}
.col-item{
    padding-left: 5px;
    padding-right: 5px;
}
.item{
    margin-left: 20px;
}
.btn_plus{
    background-color: #007F46;
    color: #fff;
    font-weight: bold;
    border-radius: 0px;
}
.item .form-group label{
    font-size:11px;
    text-align:center;
}
.btn_minus{
    background-color: #DD4B39;
    color: #fff;
    font-weight: bold;
    border-radius: 0px; 
    width:34.19px
}
</style>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Edit</strong> Quotation #<?php echo $jobId;?>
        <form method="POST" id="delete_quotation" action="./curd.php" style="display: contents;"> 
        <input  type="hidden" name="jobId" value="<?php echo $jobId;?>">
        <input  type="hidden" name="quotation_delete" value="delete">
        <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
        </form>
        </h4>      

    </div>
    <form method="POST" id="edit_quotation" action="./curd.php">
        <input type="hidden" name="jobId"  value="<?php echo $jobId; ?>">
        <input type="hidden" name="edit_quotation"  value="edit">
        <div class="modal-body">
            <div class="row" style="margin:30px">
                <div class="col-md-6">                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                                <select  id="" <?php if ($level!='Seller' ){ ?>    name="agent_name" <?php } ?> class="form-control select2"  <?php if ($level=='Seller'){ ?> disabled <?php } ?>  placeholder="Select Agent" style="width:100%">
                                    
                                    <?php 
                                        $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");
                                        while ($rowList = mysqli_fetch_array($consultaList)){ 
                                        $agent_List=$rowList['name']; ?>
                                    <option <?php if($agent_name==$rowList['name']){echo "selected";} ?> value="<?php echo $agent_List; ?>"><?php echo $agent_List; ?></option>
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
                                <select data-placeholder="Select Client" name="client_id" class="form-control select2" style="width:100%;">
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
                                       ?>
                                        <option 
                                        <?php if($client_id==$row['id']){echo "selected";}?>
                                        value="<?php echo $row['id']; ?>"><?php echo $customer_if; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" onclick="editClientmodal(<?php echo $client_id;?>);" style="background-color: #B80008 !important;color: #fff;"><i class="fa fa-save"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar input-fa"></i></div>
                                <input type="text" class="form-control" name="expiration_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" laceholder="To"  value="<?php echo $expiration_date; ?>"    placeholder="Expiration Date">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control"  name="initial_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" laceholder="To" value="<?php echo $initial_date; ?>"    placeholder="Initial Date">
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-map-marker input-fa"></i></div>
                                <input type="text" class="form-control" name="origin" value="<?php echo $origin; ?>" disabled  placeholder="Origin">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control"  name="destination" value="<?php echo $destination; ?>" disabled    placeholder="Destination">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-ship input-fa"></i></div>
                                <select placeholder="Select Service" name="service" class="form-control select2" style="width:100%">
                                    <option value="<?php echo $service; ?>"><?php echo $service; ?></option>

                                    <?php if ($service!='Pending'){ ?>
                                    <option value="Pending">Pending</option>
                                    <?php } ?>

                                    <?php if ($service!='Air door to door'){ ?>
                                    <option value="Air door to door">Air door to door</option>
                                    <?php } ?>

                                    <?php if ($service!='Ocean door to door'){ ?>
                                    <option value="Ocean door to door">Ocean door to door</option>
                                    <?php } ?>

                                    <?php if ($service!='LCL'){ ?>
                                    <option value="LCL">LCL</option>
                                    <?php } ?>

                                    <?php if ($service!='Air'){ ?>
                                    <option value="Air">Air</option>
                                    <?php } ?>

                                    <?php if ($service!='FCL 20\"'){ ?>
                                    <option value='FCL 20\"'>FCL 20"</option>
                                    <?php } ?>

                                    <?php if ($service!='FCL 40\"'){ ?>
                                    <option value='FCL 40\"'>FCL 40"</option>
                                    <?php } ?>

                                    <?php if ($service!='FCL 40\" HC'){ ?>
                                    <option value='FCL 40\" HC'>FCL 40" HC</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                                <input type="text" name="commodity" class="form-control" value="<?php echo $commodity; ?>" disabled placeholder="Commodity">
                            </div>
                        </div>
                    </div>
                    <?php if ($service=='Ocean door to door' || $service=='Air door to door' || $service=='Air' || $service=='AIR' || $service=='Air Service' || $service=='Ocean Service'){ ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-money input-fa"></i></div>
                                    <input type="number" name="value" class="form-control" value="<?php echo $commodity; ?>"  placeholder="Value">
                                </div>
                            </div>
                        </div>
                        <div class="card" >
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
                            <?php 
                                $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcontents WHERE quotationID='$jobId' AND type='By Volume' ")
                                or die ("Error al traer los Quotations");
                                foreach($consultaQuotations as $key=>$rowQuotations){                           
                                $byVolume_qty = $rowQuotations['byVolume_qty'];
                                $byVolume_volume = $rowQuotations['byVolume_volume'];
                                $byVolume_weight = $rowQuotations['byVolume_weight'];
                            ?>
                            <div class="item">
                                <div class="form-group row">
                                    <div class="col-md-4 col-item">
                                        <input type="text" name="byVolume_qty" value="<?php echo $byVolume_qty; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-item">
                                        <input type="number" name="byVolume_volume" value="<?php echo $byVolume_volume; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-item">
                                        <input type="number" name="byVolume_weight" value="<?php echo $byVolume_weight; ?>" class="form-control">
                                    </div>                                       
                                </div>
                            </div> 
                            <?php } ?>
                        <?php if(mysqli_num_rows($consultaQuotations)==0) { ?>
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
                        <?php } ?> 
                    </div>
                    <div class="card" id="by_boxes_content_acount">
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
                        <?php 
                            $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcontents WHERE quotationID='$jobId' AND type=''")
                                or die ("Error al traer los Quotations");
                                $rowcount = mysqli_num_rows($consultaQuotations);
                                foreach($consultaQuotations as $key=>$rowQuotations){                           
                                $byBoxes_qtyX = $rowQuotations['byBoxes_qty'];
                                $byBoxes_widthX = $rowQuotations['byBoxes_width'];
                                $byBoxes_lenghtX = $rowQuotations['byBoxes_lenght'];
                                $byBoxes_heightX = $rowQuotations['byBoxes_height'];
                                $byBoxes_weightX = $rowQuotations['byBoxes_weight'];
                            ?>
                                <div class="item">
                                    <div class="form-group row">
                                        <div class="col-md-2 col-item">
                                            <input type="text" name="byBoxes_qtyX[]" value="<?php echo $byBoxes_qtyX; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-item">
                                            <input type="number" name="byBoxes_widthX[]" value="<?php echo $byBoxes_widthX; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-item">
                                            <input type="number" name="byBoxes_lenghtX[]" value="<?php echo $byBoxes_lenghtX; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-item">
                                            <input type="number" name="byBoxes_heightX[]" value="<?php echo $byBoxes_heightX; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-item">
                                            <input type="number" name="byBoxes_weightX[]" value="<?php echo $byBoxes_weightX; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-1 col-item">
                                           <?php if($key==0){ ?>
                                                <button  type="button"  class="btn btn_plus">+</button>
                                            <?php }else{ ?>
                                                <button  type="button" class="btn btn_minus">-</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php if(mysqli_num_rows($consultaQuotations)==0) { ?>
                            <div class="item">
                                <div class="form-group row">
                                    <div class="col-md-2 col-item">
                                        <input type="text" name="byBoxes_qtyX[]" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-item">
                                        <input type="number" name="byBoxes_widthX[]" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-item">
                                        <input type="number" name="byBoxes_lenghtX[]" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-item">
                                        <input type="number"  name="byBoxes_heightX[]" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-item">
                                        <input type="number"  name="byBoxes_weightX[]" class="form-control">
                                    </div>
                                    <div class="col-md-1 col-item">
                                        <button  type="button"  class="btn btn_plus">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
                    </div>
                    <?php }else{ ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-star input-fa"></i></div>
                                    <input type="number" name="containerQuantity" class="form-control" value="<?php echo $containerQuantity; ?>"  placeholder="container Quantity">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class=" input-group">
                                    <div class="input-group-addon"><i class="fa fa-money input-fa"></i></div>
                                    <input type="number" name="value" class="form-control" value="<?php echo $commodity; ?>"  placeholder="Value">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
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
                        <?php 
                            $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$jobId' AND type='Freight Charges' ")
                                or die ("Error al traer los Quotations");
                                $rowcount = mysqli_num_rows($consultaQuotations);
                                foreach($consultaQuotations as $key=>$rowQuotations){                           
                                $description = $rowQuotations['description'];
                                $charge = $rowQuotations['charge'];
                                $quantity = $rowQuotations['quantity'];
                                $id = $rowQuotations['id'];
                            ?>
                                <div class="item">
                                    <input type="hidden" name="freightid[]" value="<?php echo $id; ?>">
                                    <div class="form-group row">
                                        <div class="col-md-4 col-item">
                                            <input type="text" name="freightDescX[]" value="<?php echo $description; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="freightChargeX[]" value="<?php echo $charge; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="freightChargeQX[]" value="<?php echo $quantity; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-1 col-item">
                                           <?php if($key==0){ ?>
                                                <button  type="button"  class="btn btn_plus">+</button>
                                            <?php }else{ ?>
                                                <button  type="button" class="btn btn_minus">-</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php if(mysqli_num_rows($consultaQuotations)==0) { ?>
                            <div class="item">
                                <input type="hidden" name="freightid[]" value="">
                                <div class="form-group row">
                                    <div class="col-md-4 col-item">
                                        <input type="text" name="freightDescX[]" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-item">
                                        <input type="number" name="freightChargeX[]" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-item">
                                        <input type="number" value="1"  name="freightChargeQX[]" class="form-control">
                                    </div>
                                    <div class="col-md-1 col-item">
                                        <button  type="button"  class="btn btn_plus">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
                        <!--                         -->
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
                        <?php 
                            $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$jobId' AND type='Origin Charges' ")
                                or die ("Error al traer los Quotations");
                                $rowcount = mysqli_num_rows($consultaQuotations);
                                foreach($consultaQuotations as $key=>$rowQuotations){                           
                                $description = $rowQuotations['description'];
                                $charge = $rowQuotations['charge'];
                                $quantity = $rowQuotations['quantity'];
                                $id = $rowQuotations['id'];
                            ?>
                                <div class="item">
                                    <input type="hidden" name="originid[]" value="<?php echo $id; ?>">
                                    <div class="form-group row">
                                        <div class="col-md-4 col-item">
                                            <input type="text" name="originDescX[]" value="<?php echo $description; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="originChargeX[]" value="<?php echo $charge; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number"  name="originChargeQX[]" value="<?php echo $quantity; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-1 col-item">
                                           <?php if($key==0){ ?>
                                                <button  type="button"  class="btn btn_plus">+</button>
                                            <?php }else{ ?>
                                                <button  type="button" class="btn btn_minus">-</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                        <?php if(mysqli_num_rows($consultaQuotations)==0) { ?>
                            <div class="item">
                                <input type="hidden" name="originid[]" value="">
                                <div class="form-group row">
                                    <div class="col-md-4 col-item">
                                        <input type="text" name="originDescX[]" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-item">
                                        <input type="number" name="originChargeX[]" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-item">
                                        <input type="number" value="1"  name="originChargeQX[]" class="form-control">
                                    </div>
                                    <div class="col-md-1 col-item">
                                        <button  type="button"  class="btn btn_plus">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> 
                                               
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
                        <?php 
                            $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$jobId' AND type='Destination Charges' ")
                                or die ("Error al traer los Quotations");
                                $rowcount = mysqli_num_rows($consultaQuotations);
                                foreach($consultaQuotations as $key=>$rowQuotations){                           
                                $description = $rowQuotations['description'];
                                $charge = $rowQuotations['charge'];
                                $quantity = $rowQuotations['quantity'];
                                $id = $rowQuotations['id'];
                            ?>
                                <div class="item">
                                    <input type="hidden" name="destinationid[]" value="<?php echo $id; ?>">
                                    <div class="form-group row">
                                        <div class="col-md-4 col-item">
                                            <input type="text" name="destinationDescX[]" value="<?php echo $description; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="destinationChargeX[]" value="<?php echo $charge; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="destinationChargeQX[]" value="<?php echo $quantity; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-1 col-item">
                                           <?php if($key==0){ ?>
                                                <button  type="button"  class="btn btn_plus">+</button>
                                            <?php }else{ ?>
                                                <button  type="button" class="btn btn_minus">-</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                            <?php if(mysqli_num_rows($consultaQuotations)==0) { ?>
                                <div class="item">
                                    <input type="hidden" name="destinationid[]" value="">
                                    <div class="form-group row">
                                        <div class="col-md-4 col-item">
                                            <input type="text" name="destinationDescX[]" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" name="destinationChargeX[]" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-item">
                                            <input type="number" value="1"  name="destinationChargeQX[]" class="form-control">
                                        </div>
                                        <div class="col-md-1 col-item">
                                            <button  type="button"  class="btn btn_plus">+</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?> 
                                                
                        </div>
                    <!-- <div class="card">
                        <p></p>
                    </div>                          -->
                    <div class="card">
                        <p>Remarks</p>
                        <div class="item">
                            <div class="form-group row">
                                <div class="col-md-11 col-item">                                   
                                   <textarea name="remarks" id="" cols="30" rows="10" class="form-control">1. COTIZACION ES BASADA EN TERMINO EXW DESDE BODEGA.
2. NO INCLUYE SEGURO DE CARGA, NO INCLUYE AGENCIAMEINTO ADUANAL EN PARAGUAY Y ENTREGA PUERTA A PUERTA.
3.LOS CARGOS EN DESTINOS SON APROXIMADOS, Y DEBERAN SER CANCELADOS AL AGENTE DESCONSOLIDADOR AL MOMENTO DEL ARRIBO.</textarea>
                                </div>
                            </div>
                        </div>                                        
                    </div>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit"  class="btn btn-success">Edit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
<script>
    $(".select2").select2();
</script>
