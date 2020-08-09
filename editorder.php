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
    $consulta2 = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta2)){  
        $jobId = $row['id'];
        $supplier_id=$row['supplier_id'];
        $client_id=$row['client_id'];
        $agent_id=$row['agent_id'];       
        $branch= $row['branch'];
        $service= $row['service'];
        $commodity= $row['commodity'];
        $wh_receipt= $row['wh_receipt'];
        $remark= $row['remark'];
}
$consulta_supplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_id' ORDER BY id asc ") or die ("Error al traer los datos222");
while ($rowsupplier = mysqli_fetch_array($consulta_supplier)){  
    $supplier_company=$rowsupplier['company'];
    $supplier_name=$rowsupplier['name'];
    $supplier_email=$rowsupplier['email'];
    $supplier_address1=$rowsupplier['address_1'];
    $supplier_address2=$rowsupplier['address_2'];
    $supplier_city=$rowsupplier['city'];
    $supplier_state=$rowsupplier['state'];
    $supplier_country=$rowsupplier['country'];
    $supplier_telf1=$rowsupplier['telf1'];
    $supplier_telf2=$rowsupplier['telf2'];
    $supplier_qq=$rowsupplier['qq'];
    $supplier_wechat=$rowsupplier['wechat'];
   
  
   
}
$consulta_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$client_id' ORDER BY id asc ") or die ("Error al traer los datos222");
while ($rowcustomer = mysqli_fetch_array($consulta_customer)){  

    $customer_company=$rowcustomer['company'];
    $customer_name=$rowcustomer['name'];
    $customer_email=$rowcustomer['email'];
    $customer_address1=$rowcustomer['address_1'];
    $customer_address2=$rowcustomer['address_2'];
    $customer_city=$rowcustomer['city'];
    $customer_state=$rowcustomer['state'];
    $customer_country=$rowcustomer['country'];
    $customer_telf1=$rowcustomer['telf1'];
    $customer_telf2=$rowcustomer['telf2'];
    $customer_qq=$rowcustomer['qq'];
    $customer_wechat=$rowcustomer['wechat'];
 
  
   
}
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Edit</strong> Job Order #<?php echo $id;?>
        <form method="POST" id="delete_order" action="./curd.php" style="display: contents;"> 
        <input  type="hidden" name="jobId" value="<?php echo $id;?>">
        <input  type="hidden" name="order_delete" value="delete">
        <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
        </form>
        </h4>      

    </div>
    <form method="POST" id="edit_order" action="./curd.php">
        <input type="hidden" name="jobId"  value="<?php echo $jobId; ?>">
        <input type="hidden" name="editorder"  value="edit">
        <input type="hidden" name="supplier_id"  value="<?php echo $supplier_id; ?>">
        <input type="hidden" name="client_id"  value="<?php echo $client_id; ?>">
        <input type="hidden" name="agent_id"  value="<?php echo $agent_id; ?>">
        <div class="modal-body">
            <div class="row" style="margin:30px">
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <i class="fa fa-user icon"></i>
                            <h4 class="title">Customer Data</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                <input type="text" name="customer_name" class="form-control" value="<?php echo $customer_name; ?>"  placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                <input type="text" name="customer_company" class="form-control" value="<?php echo $customer_company; ?>"  placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Mobile</div>
                              <input type="text" name="customer_telf1" class="form-control" value="<?php echo $customer_telf1; ?>" placeholder="Mobile">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Office</div>
                              <input type="text" name="customer_telf2" class="form-control" value="<?php echo $customer_telf2; ?>" placeholder="Office">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;QQ</div>
                              <input type="text" name="customer_qq" class="form-control" value="<?php echo $customer_qq; ?>" placeholder="QQ">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;WeChat</div>
                              <input type="text" name="customer_wechat" class="form-control" value="<?php echo $customer_wechat; ?>" placeholder="WeChat">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-envelope input-fa"></i></div>
                              <input type="text" name="customer_email" class="form-control" value="<?php echo $customer_email; ?>" placeholder="E-mail">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                            <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 1</span>
                            <input name="customer_address1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $customer_address1;?>">
                        </div>
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group" >
                          <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 2</span>
                          <input name="customer_address2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $customer_address2;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                            <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;City</span>
                            <input name="customer_city" type="text" class="form-control" placeholder="City"  value="<?php echo $customer_city;?>">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                          <span class="input-group-addon"><i  class="fa fa-map-marker input-fa"></i>&nbsp;State</span>
                          <input name="customer_state" type="text" class="form-control" placeholder="State"  value="<?php echo $customer_state;?>">
                        </div>
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                          <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;Country</span>
                          <select name="customer_country" class="form-control select2" style="width:100%;" >
                          <option value="">Select Country</option>
                          <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                              while ($row = mysqli_fetch_array($consulta_coutry)){ 
                              ?>
                            <option 
                                <?php if($customer_country == $row['sub_name'] ){ echo "selected"; } ?>
                            value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>                   
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <i class="fa fa-briefcase icon"></i>
                            <h4 class="title">Supplier Data</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-briefcase input-fa"></i></div>
                                <input type="text" class="form-control"  value="<?php echo $supplier_company; ?>" name="supplier_company"  placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-user input-fa"></i></div>
                                <input type="text" class="form-control" value="<?php echo $supplier_name; ?>" name="supplier_name"  placeholder="Contact Person">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Mobile</div>
                              <input type="text" name="supplier_telf1" class="form-control" value="<?php echo $supplier_telf1; ?>" placeholder="Mobile">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;Office</div>
                              <input type="text" name="supplier_telf2" class="form-control" value="<?php echo $supplier_telf2; ?>" placeholder="Office">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;QQ</div>
                              <input type="text" name="supplier_qq" class="form-control" value="<?php echo $supplier_qq; ?>" placeholder="QQ">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-phone input-fa"></i>&nbsp;WeChat</div>
                              <input type="text" name="supplier_wechat" class="form-control" value="<?php echo $supplier_wechat; ?>" placeholder="WeChat">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12">
                          <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-envelope input-fa"></i></div>
                              <input type="text" name="supplier_email" class="form-control" value="<?php echo $supplier_email; ?>" placeholder="E-mail">
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                            <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 1</span>
                            <input name="supplier_address1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $supplier_address1;?>">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="input-group" >
                          <span class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i>&nbsp;Address 2</span>
                          <input name="supplier_address2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $supplier_address2;?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                            <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;City</span>
                            <input name="supplier_city" type="text" class="form-control" placeholder="City"  value="<?php echo $supplier_city;?>">
                        </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                          <span class="input-group-addon"><i  class="fa fa-map-marker input-fa"></i>&nbsp;State</span>
                          <input name="supplier_state" type="text" class="form-control" placeholder="State"  value="<?php echo $supplier_state;?>">
                        </div>
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" >
                          <span class="input-group-addon"><i class="fa fa-map-marker input-fa"></i>&nbsp;Country</span>
                          <select name="supplier_country" class="form-control select2" style="width:100%;" >
                          <option value="">Select Country</option>
                          <?php $consulta_coutry = mysqli_query($connect, "SELECT * FROM countries  order by id ") or die ("Error al traer los datos");
                              while ($row = mysqli_fetch_array($consulta_coutry)){ 
                              ?>
                            <option 
                                <?php if($supplier_country == $row['sub_name'] ){ echo "selected"; } ?>
                            value="<?php echo $row['sub_name']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>                   
                        </select>
                      </div>
                    </div>
                  </div> 
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Branch 
                            <?php if ($branch=='USA') { ?>
                                <img src="./img/usaFlag.png" style="width:50px; padding:5px;">
                                <?php } ?>

                                <?php if ($branch=='TAIWAN') { ?>
                                <img src="./img/taiwanflag.png" style="width:50px; padding:5px;">
                                <?php } ?>
                                <?php if ($branch=='LATAM') { ?>
                                <img src="./img/paraguay.png" style="width:50px; padding:5px;">
                                <?php } ?>
                                <?php if ($branch=='' OR $branch==' ') { ?>
                                <img src="./img/chinaFlag.png" style="width:50px; padding:5px;">
                                <?php } ?>
                            </label>
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-location-arrow input-fa"></i></div>
                                <select placeholder="Select Branch" name="branch" id="" class="form-control select2" style="width:100%">
                                <?php if ($branch=='' OR $branch ==' '){ ?>
                                    <option value=" ">[Actual: CHINA]</option>
                                    <?php }elseif ($branch=='USA') { ?>
                                    <option value="USA">[Actual: USA]</option>
                                    <?php }elseif ($branch=='TAIWAN') { ?>
                                    <option value="TAIWAN">[Actual: TAIWAN]</option>
                                    <?php }elseif ($branch=='LATAM') { ?>
                                    <option value="LATAM">[Actual: LATAM]</option>
                                    <?php } ?>
                                    <?php if ($branch=='' OR $branch ==' '){ ?>
                                    <option value="USA">USA</option>
                                    <option value="TAIWAN">TAIWAN</option>
                                    <option value="LATAM">LATAM</option>
                                    <?php }elseif ($branch=='USA') { ?>
                                    <option value=" ">CHINA</option>
                                    <?php }elseif ($branch=='TAIWAN') { ?>
                                    <option value=" ">CHINA</option>
                                    <option value="USA">USA</option>
                                    <option value="LATAM">LATAM</option>
                                    <?php }elseif ($branch=='LATAM') { ?>
                                    <option value=" ">CHINA</option>
                                    <option value="USA">USA</option>
                                    <option value="TAIWAN">TAIWAN</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <i class="fa fa-plane icon"></i>
                            <h4 class="title">Service Data</h4>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-circle input-fa"></i></div>
                                <select id="" style="width:100%" class="form-control select2" data-placeholder="Select Agent" <?php if ($level!='Seller'){ ?> name="agent_id" <?php } ?> <?php if ($level=='Seller'){ ?> disabled <?php } ?>>
                                <option value="">Select Agent</option>
                                <?php 
                                    $consultaList = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos");

                                    while ($rowList = mysqli_fetch_array($consultaList)){ 

                                    $agent_List=$rowList['name'];
                                    
                                    ?>
                                    <option <?php if($agent_id==$rowList['id']){ echo "selected"; } ?> value="<?php echo $rowList['id']; ?>"><?php echo $agent_List; ?></option>
                                    <?php }   ?>
                                </select>
                                <?php if ($level=='Seller'){ ?>
                                <input type="text" name="agent_id" type="hidden" value="<?php echo $agent_id; ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class=" input-group">
                                <div class="input-group-addon"><i class="fa fa-plane input-fa"></i></div>
                                <select name="service" id="" class="form-control select2" placeholder="Select Service" required style="width:100%">
                                    <option value="<?php echo $service; ?>"><?php echo $service; ?></option>
                                    <?php if ($service!='Air door to door'){ ?>
                                        <option value="Air door to door">Air door to door</option>
                                    <?php } ?>

                                    <?php if ($service!='Pending'){ ?>
                                        <option value="Pending">Pending</option>
                                    <?php } ?>

                                    <?php if ($service!='Ocean door to door'){ ?>
                                        <option value="Ocean door to door">Ocean door to door</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-cube input-fa"></i></div>
                                <input type="text" name="commodity" class="form-control" value="<?php echo $commodity; ?>" placeholder="Commodity" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-folder-open-o input-fa"></i></div>
                                <input type="text" name="wh_receipt" class="form-control"  value="<?php echo $wh_receipt; ?>" placeholder="WH Receipt">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Need Pick-Up?</label>
                        </div>
                        <div class="col-md-12">
                            <label class="radio-inline">
                                <input type="radio" name="remark" checked value="no"  <?php if ($remark=='no'){ ?> checked <?php } ?>> No
                                </label>
                            <label class="radio-inline">
                                <input type="radio" name="remark" value="yes"  <?php if ($remark=='yes'){ ?> checked <?php } ?>> Yes
                                </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Need Payment Assistant?</label>
                        </div>
                        <div class="col-md-12">
                            <label class="radio-inline">
                                <input type="radio" name="payment" checked value="no" <?php if ($remark=='no'){ ?> checked <?php } ?>> No
                                </label>
                            <label class="radio-inline">
                                <input type="radio" name="payment" value="yes" <?php if ($remark=='yes'){ ?> checked <?php } ?>> Yes
                                </label>
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
