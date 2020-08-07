<?php 
include 'conn.php';
session_start();
$id= $_GET['id'];
$email = $_SESSION['username'];
$consultasupplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$id'") or die ("Error al traer los datos");

while ($row = mysqli_fetch_array($consultasupplier)){ 

        $supplier_name=$row['name'];
        $supplier_company=$row['company'];
        $supplier_address1=$row['address_1'];
        $supplier_address2=$row['address_2'];
        $supplier_city=$row['city'];
        $supplier_state=$row['state'];
        $supplier_country=$row['country'];
        $supplier_telf1=$row['telf1'];
        $supplier_telf2=$row['telf2'];
        $supplier_qq=$row['qq'];
        $supplier_wechat=$row['wechat'];
        $supplier_email=$row['email'];

}  
?>

<!-- Modal content-->

<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
        <h4 class="modal-title">Edit Supplier</h4>
    </div>
    <form method="POST" id="edit_warehouse_supplier" action="./warehouse_curd.php">
    <input type="hidden" name="id"  value="<?php echo $id; ?>">    
    <input type="hidden" name="edit_supplier"  value="update">     
    <div class="modal-body">
        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
            <input type="text" class="form-control" disabled placeholder="" value="<?php echo $id; ?>">
        </div>
        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-user"></i></span>
            <input name="name" type="text" class="form-control" placeholder="Contact Person" value="<?php echo $supplier_name; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-briefcase"></i></span>
            <input name="company" type="text" class="form-control" placeholder="Company Name" value="<?php echo $supplier_company; ?>">
        </div>


        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
            <input name="address_1" type="text" class="form-control" placeholder="Address 1" value="<?php echo $supplier_address1; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-location-arrow"></i></span>
            <input name="address_2" type="text" class="form-control" placeholder="Address 2" value="<?php echo $supplier_address2; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
            <input name="city" type="text" class="form-control" placeholder="City"  value="<?php echo $supplier_city; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-map-marker"></i></span>
            <input name="state" type="text" class="form-control" placeholder="State"  value="<?php echo $supplier_state; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-globe"></i></span>
            <select name="country" class="form-control select2" style="width:100%;">
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

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="telf1" type="text" class="form-control" placeholder="Mobile Phone" value="<?php echo $supplier_telf1; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="telf2" type="text" class="form-control" placeholder="Office Phone" value="<?php echo $supplier_telf2; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="qq" type="text" class="form-control" placeholder="QQ" value="<?php echo $supplier_qq; ?>">
        </div>

        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-phone"></i></span>
            <input name="wechat" type="text" class="form-control" placeholder="WeChat" value="<?php echo $supplier_wechat; ?>">
        </div>


        <div class="input-group" style="margin-top:20px;">
            <span class="input-group-addon"><i style="width:20px;" class="fa fa-envelope"></i></span>
            <input name="email" type="text" class="form-control" placeholder="E-mail" value="<?php echo $supplier_email; ?>">
        </div>

        <!-- radio -->
        <div class="input-group" style="margin-top:20px;">

            <label>
                <input type="radio" name="type" value="Supplier" class="flat-red" required="required" checked>
                <label>Supplier</label>
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
