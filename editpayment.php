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
    $consulta2 = mysqli_query($connect, "SELECT * FROM payments WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $date=$row['date'];
        $checkbooks=$row['checkbooks'];       
        $type= $row['type'];
        $check_number= $row['check_number'];
        $account= $row['account'];
        $print= $row['print'];
        $amount= $row['amount'];
        $meno= $row['meno'];
        $exchange= $row['exchange'];
     
}
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Edit</strong> Payment #<?php echo $id;?>
            <form method="POST" id="delete_payment" action="./curd_payment.php" style="display: contents;"> 
                <input  type="hidden" name="payment_id" value="<?php echo $id;?>">
                <input  type="hidden" name="delete_payment" value="delete">
                <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
            </form>
        </h4>
    </div>
    <form method="POST" id="edit_payment" action="./curd_payment.php">
        <input type="hidden" name="id"  value="<?php echo $id; ?>">
        <input type="hidden" name="editpayment"  value="edit">
        <div class="modal-body">
            <div class="row" style="margin:30px 20px">
                
                <div class="col-md-6">                    
                  <div class="form-group row">
                   <label for="" class="control-label col-md-4 text-right">Date</label>
                    <div class="col-md-8">
                      <div class="input-group">
                          <input type="text" class="form-control" data-provide="datepicker" id="date"
                                  data-date-format="yyyy/m/d" laceholder="Date" value="<?php echo date_format(date_create($date),'Y/n/d'); ?>"  name="date"  autocomplete="off"  placeholder="Date">
                          <span class="input-group-addon"><i class="fa fa-calendar input-fa"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-4 text-right">Checkbooks</label>
                    <div class="col-md-8">
                        <select name="checkbooks" id="" class="form-control select2"  data-placeholder="Select Checkbooks" required style="width:100%">
                            <option value="">Select Checkbooks</option>
                            <?php 
                              $consulta = mysqli_query($connect, "SELECT * FROM checkbooks  order by id ")
                              or die ("Error al traer los Agent");
                              while ($row = mysqli_fetch_array($consulta)){
                          
                                  $ID=$row['id'];
                                
                            ?>  
                            <option
                            <?php if($checkbooks==$row['id']){echo "selected";} ?>
                            value="<?php echo $row['id'];?>"><?php echo $row['name'];?> (<?php echo $row['balance'];?>) - <?php echo $row['branch'];?></option>
                            <?php } ?>                       
                          </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                   <label for="" class="control-label col-md-4 text-right">Type</label>
                    <div class="col-md-8">
                        <select name="type" id="" class="form-control select2"  data-placeholder="Select Type" required style="width:100%">
                            <option value="">Select Type</option>
                            <?php 
                              $consulta = mysqli_query($connect, "SELECT * FROM bill_type  order by id ")
                              or die ("Error al traer los Agent");
                              while ($row = mysqli_fetch_array($consulta)){                         
                                 
                                
                            ?>  
                            
                            <option 
                            <?php if($type==$row['id']){echo "selected";} ?>
                            value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php } ?>                       
                          </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-4 text-right">Check Number</label>
                    <div class="col-md-8">
                        <input type="text" name="check_number" class="form-control" placeholder="Check Number" value='<?php echo $check_number;?>'>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-4 text-right">Accounts</label>
                    <div class="col-md-8">
                          <select name="account" id="" class="form-control select2" disabled data-placeholder="Select Account" required style="width:100%; max-width:100%; min-width:100%" >
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
                            <?php if($account==$row['id']){echo "selected";} ?>
                            value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?> | <?php echo $company; ?></option>
                            <?php } ?>
                          </select>
                          <input type="hidden" value="<?php echo $account; ?>" name="account">
                    </div>
                  </div>
                  <div class="form-group row">
                   <label for="" class="control-label col-md-4 text-right">Print</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="print" value="<?php echo $print;?>" placeholder="Print">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="control-label col-md-4 text-right">Amount</label>
                    <div class="col-md-8">
                        <label id="amount" class="control-label"for="" style="font-weight:bold"><?php echo $amount;?></label>
                        <input type="hidden" name="amount" class="form-control" value="<?php echo $amount;?>" disable placeholder="Amount">
                    </div>
                  </div>                    
                </div> 
                <div class="col-md-6">
                  
                  <div class="form-group row">
                    <label for="" class="control-label col-md-4 text-right">Memo</label>
                    <div class="col-md-8">
                        <input type="text" name="meno" class="form-control" value='<?php echo $meno;?>' placeholder="Memo">
                    </div>
                  </div>
                  <div class="form-group row">  
                    <label for="" class="control-label col-md-4 text-right">Exchange</label>                   
                    <div class="col-md-8">
                          <input type="text" name="exchange" class="form-control" value="<?php echo $exchange;?>" placeholder="Exchange">
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
                                $consultpaymentfile = mysqli_query($connect, "SELECT * FROM payments_files WHERE payment_id='$id' ")
                                    or die ("Error al traer los Quotations");
                                    while($rowfile = mysqli_fetch_array($consultpaymentfile)){  
                                  
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
                <div class="col-md-12">
                  <small for="" style="color:#B80008">Selected on this Reference</small>
                </div>
                <dic class="col-md-12" style="margin-top:10px;">
                  <div class="table-responsive">
                    <table  style="width:100%;" class='custom_table paid_table table table-bordered' >
                        <thead>
                            <tr class="text-center">
                                <th class="text-center" style="background: #B80008;color:white">Bill ID</th>
                                <th class="text-center" style="background: #B80008;color:white">Inv#</th>
                                <th class="text-center" style="background: #B80008;color:white">Account</th>
                                <th class="text-center" style="background: #B80008;color:white">Currency</th>
                                <th class="text-center" style="background: #B80008;color:white">Amount</th>
                                <th class="text-center" style="background: #B80008;color:white">Paid</th>
                                <th class="text-center" style="background: #B80008;color:white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $consultpaid = mysqli_query($connect, "SELECT a.*, b.name as account_name, c.amount as amount_val FROM payments_contents a left join accounts b   on a.account=b.id left join bills c   on a.bill_id=c.id  WHERE a.payment_id='$id' ")
                                    or die ("Error al traer los Quotations");
                                    while($row = mysqli_fetch_array($consultpaid)){  
                                  
                                ?>     
                                    <tr>
                                        <td class="text-center"><?php echo $row['bill_id']; ?></td>
                                        <td class="text-center"><?php echo $row['inv']; ?></td>
                                        <td class="text-center"><?php echo $row['account_name']; ?></td>
                                        <td class="text-center"><?php echo $row['currency']; ?></td>
                                        <td class="text-center"><?php echo $row['amount_val']; ?></td>
                                        <td class="text-center"><?php echo $row['paid']; ?></td>                
                                        <td class="text-center"><i class="fa fa-trash action td_remove" onclick="ontdremove($(this))"></i><a href="subpaymentpdf.php?id=<?php echo  $row['id']; ?>" target="blank"><i class="fa fa-file-pdf-o action" ></i></a></td>  
                                        <input type="hidden" name="td_paid[]" value="<?php echo $row['paid']; ?>" class="form-control text-right">  
                                        <input type="hidden" name="td_bill_id[]" value="<?php echo $row['bill_id']; ?>" class="form-control text-right">
                                        <input type="hidden" name="td_payment_id[]" value="<?php echo $row['id']; ?>" class="form-control text-right">                
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                  </div>
                </dic>
                <div class="col-md-12">
                  <small for="" style="color:#B80008">Avaliable for selection</small>
                </div>
                <dic class="col-md-12" style="margin-top:10px;">
                  <div class="table-responsive">
                    <table  style="width:100%;" class='custom_table payment_table table table-bordered' >
                        <thead>
                            <tr class="text-center">
                                <th class="text-center" style="background: #B80008;color:white">Bill ID</th>
                                <th class="text-center" style="background: #B80008;color:white">Inv#</th>
                                <th class="text-center" style="background: #B80008;color:white">Account</th>
                                <th class="text-center" style="background: #B80008;color:white">Currency</th>
                                <th class="text-center" style="background: #B80008;color:white">Amount</th>
                                <th class="text-center" style="background: #B80008;color:white">Payment</th>
                                <th class="text-center" style="background: #B80008;color:white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $consultpayment = mysqli_query($connect, "SELECT a.*, b.name as account_name, (a.amount-a.paid)diff FROM bills a left join accounts b  on a.account=b.id WHERE a.account='$account' and a.amount>a.paid ")
                                    or die ("Error al traer los Quotations");
                                    while($row = mysqli_fetch_array($consultpayment)){  
                                  
                                ?>     
                                    <tr>
                                        <td class="text-center"><?php echo $row['id']; ?></td>
                                        <td class="text-center"><?php echo $row['inv']; ?></td>
                                        <td class="text-center"><?php echo $row['account_name']; ?></td>
                                        <td class="text-center"><?php echo $row['currency']; ?></td>
                                        <td class="text-center"><?php echo $row['amount']; ?></td>
                                        <td class="text-center">
                                        <input type="text" id="td_payment" value="<?php echo $row['diff']; ?>" class="form-control text-right">
                                        </td>
                                        <td class="text-center"><button type="button" onclick="onpayment($(this))" class="btn btn-success payment_btn btn-sm"><i class="fa fa-money"></i>&nbsp;Pay</button></td>               
                                        <input type="hidden" id="td_change_payment" value="<?php echo $row['diff']; ?>" class="form-control text-right">
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
