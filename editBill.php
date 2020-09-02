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
    $consulta2 = mysqli_query($connect, "SELECT * FROM bills WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $currency=$row['currency'];
        $date=$row['date'];
        $branch=$row['branch'];       
        $account= $row['account'];
        $inv= $row['inv'];
        $description= $row['description'];
        $due_date= $row['due_date'];
        $amount= $row['amount'];
        $paid= $row['paid'];
        $payroll= $row['payroll'];
        $exchange= $row['exchange'];
        $cost_center= $row['cost_center'];
        $warehouse= $row['warehouse'];
        $file= $row['file'];
        $house= $row['house'];
}
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Edit</strong> Bill #<?php echo $id;?>
            <form method="POST" id="delete_bill" action="./curd_bill.php" style="display: contents;"> 
                <input  type="hidden" name="bill_id" value="<?php echo $id;?>">
                <input  type="hidden" name="delete_bill" value="delete">
                <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
            </form>
        </h4>
    </div>
    <form method="POST" id="edit_bill" action="./curd_bill.php">
        <input type="hidden" name="id"  value="<?php echo $id; ?>">
        <input type="hidden" name="editbill"  value="edit">
        <div class="modal-body">
            <div class="row" style="margin:30px 20px">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Currency</span>
                            <select name="currency" id="" class="form-control select2"  data-placeholder="Select Currency" style="width:100%; max-width:100%; min-width:100%">
                                <option value="">Select Currency</option>
                                <option 
                                <?php if($currency=='USD'){ echo "selected";} ?>
                                value="USD">USD - US Dollar</option>                           
                            </select> 
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Date</span>
                            <input type="text" class="form-control" data-provide="datepicker" id="date"
                                    data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date_format(date_create($date),'Y/n/d'); ?>"  name="date"  autocomplete="off"  placeholder="Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon span_custom">Branch</span>
                                <select name="branch" id="" class="form-control select2"  data-placeholder="Select Branch" required style="width:100%; max-width:100%; min-width:100%">
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
                                    <?php if($branch==$ID){echo "selected";} ?>
                                    value="<?php echo $ID;?>"><?php echo $station;?> - <?php echo $company;?></option>
                                    <?php } ?>                       
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Accounts</span>
                            <select name="account" id="" class="form-control select2" data-placeholder="Select Account" required style="width:100%; max-width:100%; min-width:100%" >
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
                                <?php if($account==$ID){echo "selected";} ?>
                                value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> | <?php echo $company; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Inv#</span>
                            <input type="text" name="inv" class="form-control" placeholder="Inv#" value="<?php echo $inv ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Description</span>
                            <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $description ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Due Date</span>
                            <input type="text" class="form-control" data-provide="datepicker" id="due_date"
                                    data-date-format="yyyy/m/d" laceholder="Due Date" value="<?php echo date_format(date_create($due_date),'Y/n/d'); ?>"  name="due_date"  autocomplete="off"  placeholder="Due Date">
                            <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Amount</span>
                            <input type="text" name="amount" disabled class="form-control" placeholder="Amount" value="<?php echo $amount ?>">
                            <input type="hidden" name="amount"  class="form-control" placeholder="Amount" value="<?php echo $amount ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Paid</span>
                            <input type="text" name="paid" disabled class="form-control" placeholder="Paid" value="<?php echo $paid ?>">
                            <input type="hidden" name="paid" class="form-control" placeholder="Paid" value="<?php echo $paid ?>">
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-4">
                        <div class="checkbox" style="margin-top:0px;">
                            <label class="control-label">
                            Payroll&nbsp;<input type="checkbox" 
                            <?php if($payroll==1){ echo "checked";} ?>
                            style="margin-left:0px;" name='payroll'> 
                            </label>
                        </div>
                        </div>
                        <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Exchange</span>
                            <input type="text" name="exchange" class="form-control" placeholder="Exchange" value="<?php echo $exchange ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Cost Center</span>
                            <input type="text" name="cost_center" class="form-control" placeholder="Cost Center" value="<?php echo $cost_center ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">WareHouse</span>
                            <input type="number" name="warehouse" class="form-control" value="<?php echo $warehouse ?>" placeholder="WareHouse">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">File</span>
                            <input type="number" name="file" class="form-control" placeholder="" value="<?php echo $file ?>">
                        </div>
                        </div>                      
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">House</span>
                            <input type="number" name="house" class="form-control" placeholder="" value="<?php echo $house ?>">
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
                            <?php 
                                $consulbillfile = mysqli_query($connect, "SELECT * FROM bills_files WHERE bill_id='$id' ")
                                    or die ("Error al traer los Quotations");
                                    while($rowfile = mysqli_fetch_array($consulbillfile)){  
                                  
                                ?>     
                                    <tr>
                                        <td><a href="./images/bills/<?php echo $rowfile['file_name'] ?>" target="blank"><?php echo $rowfile['file_name'] ?></a><input type="hidden"  name="td_filename[]" value="<?php echo $rowfile['file_name'] ?>"></td>
                                        <td class="text-center"><i class="fa fa-trash action td_file_remove"></i></td>
                                        <input type="hidden"  name="td_fileid[]" value="<?php echo $rowfile['id']; ?>" >
                                    </tr>
                                <?php } ?>
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
                                <tr class="text-center">
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
                            <?php 
                                $consultabillcontent = mysqli_query($connect, "SELECT * FROM bills_contents WHERE bill_id='$id' ")
                                    or die ("Error al traer los Quotations");
                                    $rowcount = mysqli_num_rows($consultabillcontent);
                                    while($rowcontent = mysqli_fetch_array($consultabillcontent)){ 
                                  
                                ?>       
                                <tr>
                                    <td>
                                    <input type="text" class="form-control" data-provide="datepicker"  required
                                        data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date_format(date_create($rowcontent['date']),'Y/n/d') ?>"  name="td_date[]"  autocomplete="off"  placeholder="Date">
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $rowcontent['file'] ?>" name="td_file[]">
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $rowcontent['house'] ?>" name="td_house[]">
                                    </td>
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $rowcontent['wh'] ?>" name="td_wh[]">
                                    </td>
                                    <td>
                                    <select name="td_account[]" id="" class="form-control select2" data-placeholder="Select G/L Account" required style="width:100%">
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
                                        <?php if($rowcontent['account']==$ID){ echo "selected";} ?>
                                    value="<?php echo $ID; ?>"><?php echo $name; ?> | <?php echo $title; ?></option>
                                    <?php } ?>
                                    </select>
                                    </td>                             
                                    <td>
                                    <input type="text" class="form-control" value="<?php echo $rowcontent['description'] ?>" name="td_desc[]">
                                    </td>
                                    <td>
                                    <input type="text" class="form-control text-right" value="<?php echo $rowcontent['amount'] ?>" name="td_amount[]">
                                    </td>
                                    <td>
                                    <input type="text" class="form-control text-right"  value="<?php echo $rowcontent['iva'] ?>" name="td_iva[]">
                                    </td>
                                    <td>
                                    <i class="fa fa-trash action td_remove"></i>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if($rowcount==0) { ?>
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
                                    <select name="td_account[]" id="" class="form-control select2" data-placeholder="Select G/L Account" required style="width:100%">
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
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </dic>               
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
