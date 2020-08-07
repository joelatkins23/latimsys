<?php 
include 'conn.php';
session_start();
$id= $_GET['id'];
$email = $_SESSION['username'];
$consultaClient = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$id'") or die ("Error al traer los datos");

while ($row = mysqli_fetch_array($consultaClient)){ 

        $cus_id=$row['id'];
        $customer_name=$row['name'];
        $customer_company=$row['company'];
        $customer_address1=$row['address_1'];
        $customer_address2=$row['address_2'];
        $customer_city=$row['city'];
        $customer_state=$row['state'];
        $customer_country=$row['country'];
        $customer_telf1=$row['telf1'];
        $customer_telf2=$row['telf2'];
        $customer_qq=$row['qq'];
        $customer_wechat=$row['wechat'];
        $customer_email=$row['email'];
        $client_id=$row['client_id'];

}  
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
        <h4 class="modal-title">Edit Client</h4>
    </div>
    <form method="POST" id="edit_warehouse_bill" action="./warehouse_curd.php">
    <input type="hidden" name="id"  value="<?php echo $id; ?>">    
    <input type="hidden" name="edit_bill"  value="update">     
    <div class="modal-body">
        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
            <input type="text" class="form-control" disabled placeholder="" value="<?php echo $id; ?>">
        </div>
        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
            <input name="name" type="text" class="form-control" placeholder="Contact Person" value="<?php echo $customer_name; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
            <input name="company" type="text" class="form-control" placeholder="Company Name" value="<?php echo $customer_company; ?>">
        </div>


        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
            <input name="address_1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $customer_address1; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
            <input name="address_2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $customer_address2; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
            <input name="city" type="text" class="form-control" placeholder="City"  value="<?php echo $customer_city; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
            <input name="state" type="text" class="form-control" placeholder="State"  value="<?php echo $customer_state; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
            <select name="country" class="form-control select2" style="width:100%;">
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

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="telf1" type="text" class="form-control" placeholder="Mobile Phone" value="<?php echo $customer_telf1; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="telf2" type="text" class="form-control" placeholder="Office Phone" value="<?php echo $customer_telf2; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="qq" type="text" class="form-control" placeholder="QQ" value="<?php echo $customer_qq; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="wechat" type="text" class="form-control" placeholder="WeChat" value="<?php echo $customer_wechat; ?>">
        </div>


        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
            <input name="email" type="text" class="form-control" placeholder="E-mail" value="<?php echo $customer_email; ?>">
        </div>

        <!-- radio -->
        <div class="input-group" style="margin-top:20px;">

            <label>
                <input type="radio" name="type" value="Client" class="flat-red" required="required" checked>
                <label>Client</label>
            </label>

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
