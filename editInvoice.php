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
    $consulta2 = mysqli_query($connect, "SELECT * FROM invoices WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $branch= $row['branch'];
        $date= $row['date'];
        $account= $row['account'];
        $currency= $row['currency'];
        $total_invoiced= $row['total_invoiced'];
        $total_paid= $row['total_paid'];
        $cost_center= $row['cost_center'];
        $shipper= $row['shipper'];
        $consignee_id= $row['consignee_id'];
        $carrier= $row['carrier'];
        $entry= $row['entry'];
        $etd= $row['etd'];
        $eta= $row['eta'];
        $incoterm= $row['incoterm'];
        $exchange= $row['exchange'];
        $warehouse= json_decode($row['warehouse']);
        $purchase= $row['purchase'];
        $house= $row['house'];
        $file_val1= $row['file_val1'];
        $file_val2= $row['file_val2'];
        $pieces= $row['pieces'];
        $weight= $row['weight'];
        $volume= $row['volume'];
        $weight_c= $row['weight_c'];
        $origin= $row['origin'];
        $dest= $row['dest'];
        $po= $row['po'];
        $reference= $row['reference'];
        $bank_information= $row['bank_information'];
        $print_including_backup= $row['print_including_backup'];
        $print_grouped_by_concepts= $row['print_grouped_by_concepts'];
        $print_exchange= $row['print_exchange'];
        $invoice_status= $row['invoice_status'];
}
$wh_selected='';
    
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Edit</strong> Invoice #<?php echo $id;?>
            <form method="POST" id="delete_invoice" action="./curd_invoice.php" style="display: contents;"> 
                <input  type="hidden" name="invoice_id" value="<?php echo $id;?>">
                <input  type="hidden" name="delete_invoice" value="delete">
                <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
            </form>
        </h4>
    </div>
    <form method="POST" id="edit_invoice" action="./curd_invoice.php">
        <input type="hidden" name="id"  value="<?php echo $id; ?>">
        <input type="hidden" name="editinvoice"  value="edit">
        <div class="modal-body">
        <div class="row" style="margin:30px 20px">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Branch</label>
                      <div class="col-md-9">
                          <select name="branch" id="" class="form-control select2"  data-placeholder="Select Branch" required style="width:100%">
                              <option value="">Select Branch</option>
                              <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM branches  order by id ")
                                or die ("Error al traer los Agent");
                                while ($row = mysqli_fetch_array($consulta)){
                            
                                    $ID=$row['id'];
                                    $station=$row['station'];
                                    $company=$row['company'];
                                  
                              ?>  
                              <option
                              <?php if($branch==$ID){ echo "selected";} ?>
                               value="<?php echo $ID;?>"><?php echo $station;?> - <?php echo $company;?></option>
                              <?php } ?>                       
                            </select> 
                      </div>
                    </div>
                    
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Date</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" data-provide="datepicker" id="date"
                                    data-date-format="yyyy/m/d" laceholder="Date"   name="date"  value="<?php echo $date; ?>" autocomplete="off"  placeholder="Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Accounts</label>
                      <div class="col-md-9">                       
                            <select name="account" id="" class="form-control select2" data-placeholder="Select Account" required style="width:100%;" >
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
                              <option 
                              <?php if($account==$ID){ echo "selected";} ?>
                              value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> | <?php echo $company; ?></option>
                              <?php } ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Currency</label>
                      <div class="col-md-9">
                          <select name="currency" id="" class="form-control select2"  data-placeholder="Select Currency" style="width:100%">
                              <option value="">Select Currency</option>
                              <option 
                              <?php if($currency=='USD'){ echo "selected";} ?>
                              value="USD">USD - US Dollar</option>                           
                            </select> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Total Invoiced</label>
                      <div class="col-md-9">
                          <label id="total_invoiced" class="control-label"for="" style="font-weight:bold"><?php echo $total_invoiced;?></label>
                          <input type="hidden" name="total_invoiced" class="form-control" value="<?php echo $total_invoiced;?>"  placeholder="">
                      </div>
                    </div> 
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Total Paid</label>
                      <div class="col-md-9">
                          <label id="total_paid" class="control-label"for="" style="font-weight:bold"><?php echo $total_paid;?></label>
                          <input type="hidden" name="total_paid" class="form-control" value="<?php echo $total_paid;?>"  placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Cost Center</label>
                      <div class="col-md-9">
                          <input type="text" name="cost_center" class="form-control" value="<?php echo $cost_center;?>" placeholder="Cost Center">
                      </div>
                    </div>
                    <div class="form-group row">
                     <label for="" class="control-label col-md-3 text-right">Shipper</label>
                      <div class="col-md-9">                       
                            <select name="shipper" id="" class="form-control select2" data-placeholder="Select Shipper" required style="width:100%;" >
                              <option value="">--Select Shipper--</option>
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
                            <?php if($shipper==$ID){ echo "selected";} ?>
                            value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Consignee</label>
                      <div class="col-md-9">
                          <select name="consignee_id" id="" class="form-control select2" data-placeholder="Select Consignee" style="width:100%;" required>
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
                                 <?php if($consignee_id==$ID){ echo "selected";} ?> 
                               value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?>/<?php echo $company; ?> <?php echo $city; ?></option>
                              <?php } ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Carrier</label>
                      <div class="col-md-9">
                          <input type="text" name="carrier" class="form-control" value="<?php  echo $carrier;?>" placeholder="Carrier">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Entry</label>
                      <div class="col-md-9">
                          <input type="text" name="entry" class="form-control" value="<?php  echo $entry;?>" placeholder="Entry">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">ETD</label>
                      <div class="col-md-9">
                        <div class="input-group">
                          <input type="text" class="form-control" data-provide="datepicker" id="etd"
                                  data-date-format="yyyy/m/d" laceholder="ETD" value="<?php echo date('Y/n/d'); ?>" value="<?php echo $etd; ?>"  name="etd"  autocomplete="off"  placeholder="Due Date">
                          <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">ETA</label>
                      <div class="col-md-9">
                        <div class="input-group">
                          <input type="text" class="form-control" data-provide="datepicker" id="eta"
                                  data-date-format="yyyy/m/d" laceholder="ETA" value="<?php echo date('Y/n/d'); ?>"  name="eta" value="<?php echo $eta; ?>"  autocomplete="off"  placeholder="Due Date">
                          <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Incoterm</label>
                      <div class="col-md-9">
                          <input type="text" name="incoterm" class="form-control" value="<?php echo $incoterm; ?>"  placeholder="Incoterm">
                      </div>
                    </div>
                                       
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Exchange</label>
                      <label for="" class="control-label col-md-3 text-right" style="color:red">CNY</label>
                      <div class="col-md-6">
                          <input type="text" name="exchange" class="form-control" value="<?php echo $exchange; ?>" placeholder="0.000000">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">WareHouse</label>
                      <div class="col-md-9">
                      <select data-placeholder="warehouse" id="warehouse" class="form-control select2" name="warehouse[]" multiple style="width:100%;">

                            <?php $consulta22 = mysqli_query($connect, "SELECT  id FROM warehouse  ") or die ("Error al traer los datos");
                                    while ($row = mysqli_fetch_array($consulta22)){ 
                                  
                                    ?>
                            <?php 
                            $selected="";
                            foreach($warehouse as $wh){
                               if($row['id']==$wh){
                                   $selected.="selected";
                               }
                            } ?>
                            <option 
                            value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['id']; ?></option>
                            <?php }  ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Purchase</label>
                      <div class="col-md-9">
                          <input type="text" name="purchase" value="<?php echo $purchase; ?>"  class="form-control" placeholder="Purchase">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">House</label>
                      <div class="col-md-9">
                          <input type="text" name="house" class="form-control" value="<?php echo $house; ?>" placeholder="House">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">File</label>
                      <div class="col-md-3">
                        <input type="text"  name="file_val1" class="form-control" value="<?php echo $file_val1; ?>" placeholder="">
                      </div>
                      <div class="col-md-6">
                        <input type="text"  name="file_val2" class="form-control" value="<?php echo $file_val2; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Pieces</label>
                          <div class="col-md-6">
                            <input type="text"  name="pieces" class="form-control" value="<?php echo $pieces; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Weight G.</label>
                          <div class="col-md-6">
                            <input type="text"  name="weight" class="form-control"  value="<?php echo $weight; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Volume</label>
                          <div class="col-md-6">
                            <input type="text"  name="volume" class="form-control" value="<?php echo $volume; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Weight C.</label>
                          <div class="col-md-6">
                            <input type="text"  name="weight_c" class="form-control" value="<?php echo $weight_c; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Origin</label>
                          <div class="col-md-6">
                            <input type="text"  name="origin" class="form-control" value="<?php echo $origin; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <label for="" class="control-label col-md-6 text-right">Dest</label>
                          <div class="col-md-6">
                            <input type="text"  name="dest" class="form-control" value="<?php echo $dest; ?>" placeholder="">
                          </div>
                        </div>                        
                      </div>                     
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Po</label>
                      <div class="col-md-9">
                          <input type="text" name="po" class="form-control" value="<?php echo $po; ?>" placeholder="PO">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 text-right">Reference</label>
                      <div class="col-md-9">
                          <input type="text" name="reference" class="form-control" value="<?php echo $reference; ?>" placeholder="Reference">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-offset-3 col-md-9">
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input" name="bank_information" value="1"
                            <?php if($bank_information==1){echo "checked";}?>
                            >&nbsp; Bank Information
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"  name="print_including_backup" value="1"
                            <?php if($print_including_backup==1){echo "checked";}?>
                            >&nbsp;Print Including Backup
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"  name="print_grouped_by_concepts" value="1"
                            <?php if($print_grouped_by_concepts==1){echo "checked";}?>
                            >&nbsp;Print Grouped By Concepts
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="checkbox-inline">
                            <input type="checkbox" class="form-check-input"   name="print_exchange" value="1"
                            <?php if($print_exchange==1){echo "checked";}?>
                            >&nbsp;Print Exchange
                          </label>
                        </div>                                               
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-offset-3 col-md-9">
                        <label class="radio-inline">
                          <input type="radio" class="form-check-input" name="invoice_status"  value="PrePaid"
                          <?php if($invoice_status=='PrePaid'){echo "checked";}?>
                          >&nbsp;PrePaid
                        </label>
                        <label class="radio-inline">
                          <input type="radio" class="form-check-input" name="invoice_status" value="Collect"
                          <?php if($invoice_status=='Collect'){echo "checked";}?>
                          >&nbsp;Collect
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 text-right">
                    <button  type="button"class="btn btn-danger file_upload_btn"><i class="fa fa-cloud-upload"></i>&nbsp;Add Files</button>

                    <button  type="button"class="btn btn-danger invoice_td_add"><i class="fa fa-plus"></i>&nbsp;Add</button>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                    <div class="table-responsive">
                      <table  style="width:100%;" class='custom_table table table-bordered' >
                          <thead>
                              <tr class="text-center" >
                                  <th class="text-center" style=" background: #B80008;color:white">Units</th>
                                  <th class="text-center" style="width:300px; background: #B80008;color:white">G/L<br>Account</th>                                  
                                  <th class="text-center" style=" background: #B80008;color:white">CC</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Description</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Price</th>                                  
                                  <th class="text-center" style=" background: #B80008;color:white">Amount</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Tax(%)</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php 
                                $consultabillcontent = mysqli_query($connect, "SELECT * FROM invoices_detail WHERE invoice_id='$id' ")
                                    or die ("Error al traer los Quotations");
                                    $rowcount = mysqli_num_rows($consultabillcontent);
                                    while($rowcontent = mysqli_fetch_array($consultabillcontent)){ 
                                  
                                ?>    
                            <tr>                             
                              <td>
                                <input type="text" class="form-control text-center" name="td_units[]" value="<?php echo $rowcontent['units'];?>">
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
                              <option 
                              <?php if($rowcontent['gl_account']==$ID){echo "selected";} ?>
                              value="<?php echo $ID; ?>"><?php echo $name; ?> | <?php echo $title; ?></option>
                              <?php } ?>
                                </select>
                              </td>    
                              <td>
                                <input type="text" class="form-control" name="td_cc[]" value="<?php echo $rowcontent['cc'];?>">
                              </td>
                              <td>
                                <input type="text" class="form-control" name="td_desc[]" value="<?php echo $rowcontent['description'];?>">
                              </td>
                                                       
                              <td>
                                <input type="text" class="form-control text-right" name="td_price[]" value="<?php echo $rowcontent['price'];?>">
                              </td>
                              <td>
                                <input type="text" class="form-control text-right" name="td_amount[]" value="<?php echo $rowcontent['amount'];?>">
                              </td>
                              <td>
                                <input type="checkbox" name="td_tax[]" <?php if($rowcontent['tax']==1){echo "checked";} ?> value="1">
                              </td>
                              <td>
                                <i class="fa fa-trash action td_remove"></i>
                              </td>
                            </tr>
                            <?php } ?>
                            <?php if($rowcount==0) { ?>
                                <td>
                                <input type="text" class="form-control text-center" name="td_units[]">
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
                                <input type="text" class="form-control" name="td_cc[]">
                              </td>
                              <td>
                                <input type="text" class="form-control" name="td_desc[]">
                              </td>
                                                       
                              <td>
                                <input type="text" class="form-control text-right" name="td_price[]">
                              </td>
                              <td>
                                <input type="text" class="form-control text-right" name="td_amount[]">
                              </td>
                              <td>
                                <input type="checkbox" name="td_tax[]" value="1">
                              </td>
                              <td>
                                <i class="fa fa-trash action td_remove"></i>
                              </td>
                            </tr>
                            <?php } ?> 
                          </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                    <div class="table-responsive">
                      <table  style="width:100%;" class='file_table table table-bordered' >
                          <thead>
                              <tr class="text-center" >
                                  <th class="text-center" style=" background: #B80008;color:white">File Name</th>
                                  <th class="text-center" style=" background: #B80008;color:white">User</th>
                                  <th class="text-center" style=" background: #B80008;color:white">Date</th>                                
                                  <th class="text-center" style=" background: #B80008;color:white">Action</th>
                              </tr>
                          </thead>
                          <tbody> 
                          <?php 
                            $consulbillfile = mysqli_query($connect, "SELECT * FROM invoices_files WHERE invoice_id='$id' ")
                                or die ("Error al traer los Quotations");
                                while($rowfile = mysqli_fetch_array($consulbillfile)){  
                                
                            ?>     
                                <tr>
                                    <td><a href="./images/invoices/<?php echo $rowfile['file_name'] ?>" target="blank"><?php echo $rowfile['file_name'] ?></a><input type="hidden"  name="td_filename[]" value="<?php echo $rowfile['file_name'] ?>"></td>
                                    <td class="text-center"><?php echo $rowfile['agent_name'] ?><input type="hidden"  name="td_agent_name[]" value="<?php echo $rowfile['agent_name'] ?>"></td>
                                    <td class="text-center" ><?php echo $rowfile['fecha'] ?><input type="hidden"  name="td_fecha[]" value="<?php echo $rowfile['fecha'] ?>"></td>
                                    <td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>
                                    <input type="hidden"  name="td_fileid[]" value="<?php echo $rowfile['id']; ?>" >
                                </tr>
                            <?php } ?>
                        </tbody>                           
                      </table>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card">
                        <p><i  class="fa fa-star"></i> &nbsp;Remarks</p>
                        <div class="row">
                           <div class="col-md-12">
                                <div class="form-group">
                                <textarea name="notes" class="form-control" id="" cols="30" rows="5"></textarea>
                                </div>
                           </div>
                        </div>
                    </div>
                  </div>              
                </div>
                
        </div>
        <div class="modal-footer">
            <button type="submit"  class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Edit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
        </div>
    </form>
</div>
<script>
$(".select2").select2();
</script>
