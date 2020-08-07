<?php 
include 'conn.php';
session_start();
    $id= $_GET['id'];
    $consulta2 = mysqli_query($connect, "SELECT * FROM warehouse WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $agent_id=$colrow["agent_id"];
        $consulta_angent = mysqli_query($connect, "SELECT * FROM agents WHERE id='$agent_id' limit 1 ") or die ("Error al traer los datos222");
        while ($colangent = mysqli_fetch_array($consulta_angent)){  
            $agent_name=$colangent['name'];
        }
        $consignee_id=$colrow["consignee_id"];
        $consignee_angent = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$consignee_id' limit 1 ") or die ("Error al traer los datos222");
        while ($colconsignee = mysqli_fetch_array($consignee_angent)){  
            $consignee_name=$colconsignee['name'];
        }
?>

<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="row">
            <div class="col-md-8">
                <h4 class="modal-title">Edit WareHouse #<?php echo $id; ?>
                    <form method="POST" id="delete_warehouse" action="./warehouse_curd.php" style="display: contents;"> 
                        <input  type="hidden" name="warehouse_id" value="<?php echo $id;?>">
                        <input  type="hidden" name="deletewarehouse" value="delete">
                        <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
                    </form>
                </h4>
            </div>
            <div class="col-md-3 text-right">
                <button class="btn btn-primary" onclick="addFile(<?php echo $id; ?>)"><i class="fa fa-files-o"></i>&nbsp;Add File</button>
            </div>
        </div>
        
    </div>

    <div class="modal-body">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                        data-toggle="tab">WareHouse # <?php echo $id; ?></a></li>
                <li role="presentation"><a href="#change" aria-controls="change" role="tab" data-toggle="tab">Change</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <form method="POST"  id="edit_warehouse_tab1" action="./warehouse_curd.php" >
                    <input type="hidden" value="<?php echo $id;?>" name="warehouse_id">
                    <input type="hidden" value="edit" name="warehouse_tab1">
                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table"> 
                                    <thead>
                                    <tr>
                                        <td class="text-center">Pieces</td>
                                        <td class="text-center">Gross Weight</td>
                                        <td class="text-center">Volume</td>
                                        <td class="text-center">Charg.Weight</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th id="total_pieces" class="text-center"><?php echo $colrow['total_pieces']; ?></th>
                                        <th id="total_weight" class="text-center"><?php echo $colrow['total_weight']; ?></th>
                                        <th id="total_volume" class="text-center"><?php echo $colrow['total_volume']; ?></th>
                                        <th id="total_charg_weight" class="text-center"><?php echo $colrow['total_charg_weight']; ?></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                    <div class="row" style="margin:30px 0px">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group date form_datetime2" data-link-field="fecha">
                                        <div class="input-group-addon "><i class="fa fa-calendar input-fa"></i></div>
                                        <input type="text" class="form-control "   placeholder="Select date" readonly value="<?php echo $colrow['fecha']?>" required >
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <input type="hidden" id="fecha"  name="fecha" value="<?php echo $colrow['fecha']?>" />
                                    </div>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Supplier</span>
                                        <select name="supplier_id" id="" class="form-control select2"
                                            data-placeholder="Select Supplier" style="width:100%" required>
                                            <option value="">--Select Supplier--</option>
                                            <?php 
                                                $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Supplier' order by id ")
                                                or die ("Error al traer los Agent");
                                                while ($row = mysqli_fetch_array($consulta)){
                                            
                                                    $ID=$row['id'];
                                                    $name=$row['name'];
                                                    $company=$row['company'];
                                                    $city=$row['city'];
                                                    
                                                ?>
                                            <option 
                                            <?php if($colrow['supplier_id']==$ID) { echo "selected";} ?>
                                            value="<?php echo $ID; ?>"><?php echo $ID; ?>
                                                <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?>
                                            </option>
                                            <?php } ?>
                                        </select> 
                                        <span class="input-group-addon" onclick="editsuppliermodal(<?php echo $colrow['supplier_id']; ?>);" style="background-color: #B80008 !important;color: #fff;"><i class="fa fa-save"></i></span>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Consignee</span>
                                        <select name="consignee_id" id="" class="form-control select2"
                                            data-placeholder="Select Consignee" style="width:100%" required>
                                            <option value="">--Select Consignee--</option>
                                            <?php 
                                                $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                                or die ("Error al traer los Agent");
                                                while ($row = mysqli_fetch_array($consulta)){
                                            
                                                    $ID=$row['id'];
                                                    $name=$row['name'];
                                                    $company=$row['company'];
                                                    $city=$row['city'];
                                                    
                                                ?>
                                            <option 
                                            <?php if($colrow['consignee_id']==$ID) { echo "selected";} ?>
                                            value="<?php echo $ID; ?>"><?php echo $ID; ?>
                                                <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?>
                                            </option>
                                            <?php } ?>
                                        </select> 
                                        <span class="input-group-addon" onclick="editconsigneemodal(<?php echo $colrow['consignee_id']; ?>);" style="background-color: #B80008 !important;color: #fff;"><i class="fa fa-save"></i></span>                                     
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Agent</span>
                                        <select name="agent_id" id="" class="form-control select2"
                                            data-placeholder="Select Agent" style="width:100%">
                                            <option value="">--Select Agent--</option>
                                            <?php 
                                                    $consulta = mysqli_query($connect, "SELECT * FROM agents  where level='Administrator' or level='Seller' order by id ")
                                                    or die ("Error al traer los Agent");
                                                    while ($row = mysqli_fetch_array($consulta)){
                                                
                                                        $ID=$row['id'];
                                                        $name=$row['name'];
                                                    ?>
                                            <option 
                                            <?php if($colrow['agent_id']==$ID) { echo "selected";} ?>
                                            value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Bill to</span>
                                        <select name="bill_id" id="" class="form-control select2"
                                            data-placeholder="Select Bill" style="width:100%" required>
                                            <option value="">--Select Bill--</option>
                                            <?php 
                                                    $consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
                                                    or die ("Error al traer los Agent");
                                                    while ($row = mysqli_fetch_array($consulta)){
                                                
                                                        $ID=$row['id'];
                                                        $name=$row['name'];
                                                        $company=$row['company'];
                                                        $city=$row['city'];
                                                        
                                                    ?>
                                            <option 
                                            <?php if($colrow['bill_id']==$ID) { echo "selected";} ?>
                                            value="<?php echo $ID; ?>"><?php echo $ID; ?>
                                                <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?>
                                            </option>
                                            <?php } ?>
                                        </select> 
                                        <span class="input-group-addon" onclick="editbillmodal(<?php echo $colrow['bill_id']; ?>);" style="background-color: #B80008 !important;color: #fff;"><i class="fa fa-save"></i></span>                                    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Reference</span>
                                        <input type="text" name="reference_id" class="form-control" value="<?php echo $colrow['reference_id'];?>" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="">Invoice</span>
                                        <input type="text" name="invoice" class="form-control" value="<?php echo $colrow['invoice'];?>" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="font-size:12px">Value</span>
                                        <input type="text" name="value" class="form-control"  value="<?php echo $colrow['value'];?>" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="">PO</span>
                                        <input type="text" name="po" class="form-control" value="<?php echo $colrow['po'];?>" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="font-size:12px">Marks</span>
                                        <input type="text" name="marks" class="form-control" value="<?php echo $colrow['marks'];?>" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="font-size:12px">Delivered
                                            By</span>
                                        <input type="text" name="delivered_by1" class="form-control" value="<?php echo $colrow['delivered_by1'];?>" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="delivered_by2" class="form-control" value="<?php echo $colrow['delivered_by2'];?>" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Tracking</span>
                                        <textarea name="tracking" id="" cols="30" rows="2" class="form-control"><?php echo $colrow['tracking'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom"
                                            style="font-size: 13px;">Description</span>
                                        <textarea name="description" id="" cols="30" rows="3"
                                            class="form-control"><?php echo $colrow['description'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Comments</span>
                                        <textarea name="comments" id="" cols="30" rows="3"
                                            class="form-control"><?php echo $colrow['comments'];?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Branch</span>
                                        <input type="text" name="branch" class="form-control" value="<?php echo $colrow['branch'];?>" placeholder="Branch">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom" style="font-size:10px">Pickup
                                            Number</span>
                                        <input type="text" name="pickup_number" class="form-control" value="<?php echo $colrow['pickup_number'];?>"
                                            placeholder="Pickup Number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Location</span>
                                        <input type="text" name="location1" class="form-control" placeholder="" value="<?php echo $colrow['location1'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="location2" class="form-control" placeholder="" value="<?php echo $colrow['location2'];?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Can</span>
                                        <input type="text" name="can" class="form-control" placeholder="" value="<?php echo $colrow['can'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label"><input type="checkbox"
                                            <?php if($colrow['distribution']=='on'){echo "checked";} ?>
                                            name="distribution">&nbsp;Distribution</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom"
                                            style="font-size:13px;">Destination</span>
                                        <input type="text" name="destination" class="form-control" placeholder="" value="<?php echo $colrow['destination'];?>" >
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">                  
                                <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon span_custom">Service</span>
                                    <select name="instination" id="" class="form-control select2"  data-placeholder="Select Service" style="width:100%">
                                        <option value="">Select Service</option>
                                        <option <?php if($colrow['instination']=='Pending'){echo "selected";} ?> value="Pending">Pending</option>
                                        <option <?php if($colrow['instination']=='Air door to door'){echo "selected";} ?> value="Air door to door">Air door to door</option>
                                        <option <?php if($colrow['instination']=='Air Service'){echo "selected";} ?> value="Air Service">Air Service</option>
                                        <option <?php if($colrow['instination']=='Ocean door to door'){echo "selected";} ?> value="Ocean door to door">Ocean door to door</option>
                                        <option <?php if($colrow['instination']=='Ocean Service'){echo "selected";} ?> value="Ocean Service">Ocean Service</option>
                                    </select>
                                </div>
                                </div>                  
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Terms</span>
                                        <input type="text" name="terms" class="form-control" placeholder="" value="<?php echo $colrow['terms'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Condition</span>
                                        <input type="text" name="condition2" class="form-control" placeholder="" value="<?php echo $colrow['condition2'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">                  
                                <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon span_custom">Status</span>
                                    <select name="status" id="" class="form-control select2"  data-placeholder="Select Status" style="width:100%">
                                        <option value="">Select Status</option>
                                        <option <?php if($colrow['status']=='PRE-ALERT'){echo "selected";} ?> value="PRE-ALERT">PRE-ALERT</option>
                                        <option <?php if($colrow['status']=='RECIBIDO EN BODEGA CHINA'){echo "selected";} ?> value="RECIBIDO EN BODEGA CHINA">RECIBIDO EN BODEGA CHINA</option>
                                        <option <?php if($colrow['status']=='RETURNED'){echo "selected";} ?> value="RETURNED">RETURNED</option>
                                        <option <?php if($colrow['status']=='TRANSITO'){echo "selected";} ?> value="TRANSITO">TRANSITO</option>
                                        <option <?php if($colrow['status']=='EN DESTINO / PUERTO MARITIMO'){echo "selected";} ?> value="EN DESTINO / PUERTO MARITIMO">EN DESTINO / PUERTO MARITIMO</option>
                                        <option <?php if($colrow['status']=='CARGA ENTREGADA'){echo "selected";} ?> value="CARGA ENTREGADA">CARGA ENTREGADA</option>
                                        <option <?php if($colrow['status']=='RECIBIDO EN VALENCIA'){echo "selected";} ?> value="RECIBIDO EN VALENCIA">RECIBIDO EN VALENCIA</option>
                                        <option <?php if($colrow['status']=='COMUNICADO'){echo "selected";} ?> value="COMUNICADO">COMUNICADO</option>
                                        <option <?php if($colrow['status']=='EN DESTINO / AEROPUERTO'){echo "selected";} ?> value="EN DESTINO / AEROPUERTO">EN DESTINO / AEROPUERTO</option>
                                        <option <?php if($colrow['status']=='RECIBIDO EN ALMACEN CARACAS'){echo "selected";} ?> value="RECIBIDO EN ALMACEN CARACAS">RECIBIDO EN ALMACEN CARACAS</option>
                                    </select>
                                </div>
                                </div>                  
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label col-md-4"></label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label radio-inline"><input type="checkbox"
                                                <?php if($colrow['dangerous_goods']=='on'){echo "checked";} ?>
                                                    name="dangerous_goods">&nbsp;Dangerous Goods</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label radio-inline"><input type="checkbox"
                                            <?php if($colrow['seo']=='on'){echo "checked";} ?>
                                                    name="seo">&nbsp;SED</label>
                                            <label class="control-label radio-inline"><input type="checkbox"
                                                <?php if($colrow['fragile']=='on'){echo "checked";} ?>
                                                    name="fragile">&nbsp;FRAGILE</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label radio-inline"><input type="checkbox"
                                                <?php if($colrow['insurance']=='on'){echo "checked";} ?>
                                                    name="insurance">&nbsp;Insurance</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon span_custom">Note</span>
                                        <textarea name="notes" id="" cols="30" rows="3"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-12">                            
                            <div class="card">
                                <p style="color:#000;"><i class="fa fa-cube"></i>&nbsp;Tracking Event</p>
                                <div class="table-responsive">
                                    <table class="table">
                                            <tr class="text-left">
                                                <th class="text-left" style="border-top:unset"><?php echo date_format(date_create($colrow['fecha']),'m/d/Y H:i:s'); ?></th>
                                                <th class="text-left" style="border-top:unset">CAN</th>
                                                <th class="text-left" style="border-top:unset"><?php echo $colrow['status']?></th>
                                                <th class="text-center" style="border-top:unset"><?php echo $colrow['id']?></th>
                                                <th class="text-right" style="border-top:unset"><?php echo $agent_name;?></th>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">                            
                            <div class="card">
                                <p style="color:#000;"><i class="fa fa-check-circle"></i>&nbsp;Remarks</p>
                                <div class="table-responsive" style="max-height: 200px;overflow-y: auto;">
                                    <table class="table">
                                        <?php 
                                        $consulta = mysqli_query($connect, "SELECT * FROM warehouse_note WHERE warehouse_id='$id' ORDER BY fecha desc ") or die ("Error al traer los datos222");
                                        while ($row = mysqli_fetch_array($consulta)){  
                                        ?>
                                        <tr>
                                            <td class="text-left" style="border-top:unset;padding: 0px;line-height: 1.2;">
                                                <span style="color:#000; font-weight:300; font-size:15px;"><i class="fa fa-star" style="color:red"></i>&nbsp;<?php echo $row['notes']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="color:blue; font-weight:bold; font-size:15px;"><?php echo $row['agent_name']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="color:red; font-weight:300; font-size:13px;"><?php echo date_format(date_create($row['fecha']),'m/d/Y H:i:s'); ?></span>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <!-- <p style="color:#000; font-weight:300; font-size:15px;">Consignee Change: <?php echo $consignee_name; ?></p>
                                <p style="color:#000; font-weight:300; font-size:13px;"><?php echo $agent_name; ?>      <?php echo date_format(date_create($colrow['fecha']),'m/d/Y H:i:s'); ?></p> -->
                            </div>
                        </div>
                        <div class="col-md-12">                            
                            <div class="card">
                                <p style="color:#000;"><i class="fa fa-file"></i>&nbsp;File List</p>
                                <div class="table-responsive" style="max-height: 350px;overflow-y: auto;">
                                    <table class="table" >
                                        <thead>
                                            <tr class="text-center">
                                                <th class="text-center">File</th>
                                                <th class="text-center">User</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="file_body">
                                            <?php
                                            if(!empty($colrow['image_url'])){
                                                $file_list	= json_decode($colrow['image_url']);
                                                foreach($file_list as $key=>$item){
                                                    $file=explode('/', $item);
                                                    $file=end($file);
                                                    $queryModel = mysqli_query($connect, "SELECT * from warehouse_note where file_name='$file' and type='file' and warehouse_id='$id' and status=1 ") or die ('error');
                                                    while ($row = mysqli_fetch_array($queryModel)){  
                                                        $date=$row['fecha'];
                                                        $agent_nname=$row['agent_name'];
                                                    }
                                            ?>
                                            <tr id="file_list_<?php echo $key; ?>">
                                                <td class="text-left"><a href="./images/warehouse/<?php echo $file; ?>" class="file_download" target="blank" ><?php echo $file; ?></a></td>
                                                <td class="text-center"><?php echo $agent_nname; ?></td>
                                                <td class="text-center"><?php echo date_format(date_create($date),'m/d/Y H:i:s'); ?></td>
                                                <td class="text-center"><a href="#" onclick="onfiledelete(<?php echo $key; ?>, <?php echo $id; ?>,'<?php echo $item; ?>')" ><i  style="color:red; font-size:20px;" class="fa fa-trash"></i></a></td>
                                            </tr>
                                            <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" name="total_pieces" value="<?php echo $colrow['total_pieces']; ?>">
                            <input type="hidden" name="total_weight" value="<?php echo $colrow['total_weight']; ?>">
                            <input type="hidden" name="total_volume" value="<?php echo $colrow['total_volume']; ?>">
                            <input type="hidden" name="total_charg_weight" value="<?php echo $colrow['total_charg_weight']; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" id="by_boxes_content">
                                        <p><i class="fa fa-cubes"></i>&nbsp;By Boxes</p>
                                        <div class="item">
                                            <div class="form-group row" style="margin-bottom:0px;">
                                                <div class="col-md-2 col-item text-center">
                                                    <label for="">Pieces</label>
                                                </div>  
                                                <div class="col-md-2 col-item text-center">
                                                    <label for="">Lenght</label>
                                                </div>
                                                <div class="col-md-2 col-item text-center">
                                                    <label for="">Width</label>
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
                                        $consultaQuotations = mysqli_query($connect, "SELECT * FROM warehousecontents WHERE warehouse_id='$id'")
                                            or die ("Error al traer los Quotations");
                                            $rowcount = mysqli_num_rows($consultaQuotations);
                                            foreach($consultaQuotations as $key=>$rowQuotations){                           
                                            $byBoxes_pieces = $rowQuotations['byBoxes_pieces'];
                                            $byBoxes_lenght = $rowQuotations['byBoxes_lenght'];
                                            $byBoxes_width = $rowQuotations['byBoxes_width'];
                                            $byBoxes_height = $rowQuotations['byBoxes_height'];
                                            $byBoxes_weight = $rowQuotations['byBoxes_weight'];
                                        ?>                 
                                        <div class="item col">
                                            <div class="form-group row">
                                                <div class="col-md-2 col-item">
                                                    <input type="number" name="byBoxes_piecesx[]" value="<?php echo $byBoxes_pieces; ?>" required class="form-control">
                                                </div>
                                                <div class="col-md-2 col-item">
                                                    <input type="number" name="byBoxes_lenghtX[]" value="<?php echo $byBoxes_lenght; ?>" required class="form-control">
                                                </div>
                                                <div class="col-md-2 col-item">
                                                    <input type="number" name="byBoxes_widthX[]" value="<?php echo $byBoxes_width; ?>" required class="form-control">
                                                </div>
                                                <div class="col-md-2 col-item">
                                                    <input type="number" name="byBoxes_heightX[]" value="<?php echo $byBoxes_height; ?>" required class="form-control">
                                                </div>
                                                <div class="col-md-2 col-item">
                                                    <input type="number" name="byBoxes_weightX[]" value="<?php echo $byBoxes_weight; ?>" required class="form-control">
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
                                            <div class="item col">
                                                <div class="form-group row">
                                                    <div class="col-md-2 col-item">
                                                        <input type="number" name="byBoxes_piecesx[]" value="" required class="form-control">
                                                    </div>
                                                    <div class="col-md-2 col-item">
                                                        <input type="number" name="byBoxes_lenghtX[]" value="" required class="form-control">
                                                    </div>
                                                    <div class="col-md-2 col-item">
                                                        <input type="number" name="byBoxes_widthX[]" value="" required class="form-control">
                                                    </div>
                                                    <div class="col-md-2 col-item">
                                                        <input type="number" name="byBoxes_heightX[]" value="" required class="form-control">
                                                    </div>
                                                    <div class="col-md-2 col-item">
                                                        <input type="number" name="byBoxes_weightX[]" value="" required class="form-control">
                                                    </div>
                                                    
                                                    <div class="col-md-1 col-item">                                         
                                                        <button  type="button"  class="btn btn_plus">+</button>                                          
                                                    </div>
                                                </div>
                                            </div> 
                                        <?php } ?>                
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row" style="padding-bottom:30px">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="change" style="min-height:800px;">
                    <form method="POST"  id="edit_warehouse_tab2" action="./warehouse_curd.php" >
                        <input type="hidden" value="<?php echo $id;?>" name="warehouse_id">
                        <input type="hidden" value="edit" name="warehouse_tab2">
                        <div class="row" style="margin-top:50px;">
                            <div class="col-md-12">
                                <table class="table"> 
                                    <thead>
                                    <tr>
                                        <td class="text-center">Pieces</td>
                                        <td class="text-center">Gross Weight</td>
                                        <td class="text-center">Volume</td>
                                        <td class="text-center">Charg.Weight</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th id="total_pieces" class="text-center"><?php echo $colrow['total_pieces']; ?></th>
                                        <th id="total_weight" class="text-center"><?php echo $colrow['total_weight']; ?></th>
                                        <th id="total_volume" class="text-center"><?php echo $colrow['total_volume']; ?></th>
                                        <th id="total_charg_weight" class="text-center"><?php echo $colrow['total_charg_weight']; ?></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" id="warehouse_receipt_content">
                                    <p><i class="fa fa-cubes"></i>&nbsp;WAREHOUSE RECEIPT</p>
                                    <div class="item">
                                        <div class="form-group row" style="margin-bottom:0px;">
                                            <div class="col-md-5 col-item text-center">
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
                                    $consultawarehouse = mysqli_query($connect, "SELECT * FROM warehousechange_content WHERE warehouse_id='$id'")
                                            or die ("Error al traer los Quotations");
                                            $rowcount = mysqli_num_rows($consultawarehouse);
                                            foreach($consultawarehouse as $key=>$rowQuotations){                           
                                            $byBoxes_description = $rowQuotations['byBoxes_description'];
                                            $byBoxes_price = $rowQuotations['byBoxes_price'];
                                            $byBoxes_quantity = $rowQuotations['byBoxes_quantity'];
                                        ?>                    
                                    <div class="item col">
                                        <div class="form-group row">
                                            <div class="col-md-5 col-item">
                                                <input type="text" name="byBoxes_descriptionx[]" value="<?php echo $byBoxes_description; ?>"  class="form-control">
                                            </div>
                                            <div class="col-md-3 col-item">
                                                <input type="text" name="byBoxes_pricex[]" value="<?php echo $byBoxes_price; ?>"  class="form-control">
                                            </div>
                                            <div class="col-md-3 col-item">
                                                <input type="text" name="byBoxes_quantityx[]" value="<?php echo $byBoxes_quantity; ?>"  class="form-control">
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
                                  <?php }?>
                                  <?php if(mysqli_num_rows($consultawarehouse)==0) { ?>
                                    <div class="item col">
                                        <div class="form-group row">
                                            <div class="col-md-5 col-item">
                                                <input type="text" name="byBoxes_descriptionx[]" value=""  class="form-control">
                                            </div>
                                            <div class="col-md-3 col-item">
                                                <input type="text" name="byBoxes_pricex[]" value=""  class="form-control">
                                            </div>
                                            <div class="col-md-3 col-item">
                                                <input type="text" name="byBoxes_quantityx[]" value=""  class="form-control">
                                            </div> 
                                            <div class="col-md-1 col-item">                                         
                                                <button  type="button"  class="btn btn_plus">+</button>                                          
                                            </div>
                                        </div>
                                    </div> 
                                  <?php }?>             
                                </div>
                            </div>
                            
                        </div>
                        <div class="row" style="padding-bottom:30px;position: absolute;bottom: 20px;right:20px">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>        
</div>
<?php } ?>
<script>
    $(".select2").select2();
    $('.form_datetime2').datetimepicker();
</script>