<?php 
include 'conn.php';
session_start();
$email= $_GET['email'];
 $consultaAgent = mysqli_query($connect, "SELECT b.* FROM `users` a LEFT JOIN `agents` b ON a.`username`= b.email WHERE b.email='$email'")
    or die ("Error al traer los Agent");
     while ($row = mysqli_fetch_array($consultaAgent)){
         $phone=$row['phone'];
         $name=$row['name'];
         $email=$row['email'];
         $level=$row['level'];
         $picture=$row['picture'];
         $wr_name=$row['wr_name'];
         $wr_logo=$row['wr_logo'];
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
            <div class="col-md-12">
                <h4 class="modal-title"><strong>Edit User</strong>
                <!-- <form method="POST" id="delete_user" action="./curd.php" style="display: contents;"> 
                    <input  type="hidden" name="email" value="<?php echo $email;?>">
                    <input  type="hidden" name="delete_user" value="delete">
                    <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger"><i class="fa fa-close"></i>&nbsp;Delete</button>
                </form>
                </h4>    -->
            </div>
        </div>
    </div>
    <div class="modal-body">            
        <div class="row" style="padding:50px;">
            <div class="col-md-12">
                <form id="update_user_form" action="./curd.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="create_user" value="create">
                <div class="form-group text-center">
                    <div class="card bd-0" style="border:unset">
                        <img class="card-img-top img-fluid user-image" id="image_upload"  alt="Image" src="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>" >
                        <input hidden type="file" id="my_file" name="avatar"  accept=".png, .jpg, .jpeg" value="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>"/>
                        <input type="hidden" id="user_logo" name="user_logo" value="<?php if($picture){ echo $picture;} else{echo './images/17-1.jpg';} ?>" />
                    </div>
                </div>
                <div class="form-group row">                
                    <label >Name</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control"  name="username" required placeholder="Enter Name"  value="<?php echo $name; ?>" >
                    </div>                   
                </div>
                <div class="form-group row">                
                    <label >Email</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control"  required placeholder="Enter Email" disabled value="<?php echo $email; ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    </div>                   
                </div>
                <div class="form-group row">                
                    <label >Phone</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control"  name="phone"  placeholder="Enter Phone" value="<?php echo $phone; ?>">
                    </div>                   
                </div>
                <div class="form-group">
                    <label >WareHouse LoGo</label>
                    <div class="card bd-0" style="border:unset">
                      <img class="card-img-top img-fluid" id="image_my_we_logo"  style="height:80px;" alt="Image" src="<?php if($wr_logo){ echo './images/'.$wr_logo;} else{echo './images/logoChina.png';} ?>" >
                      <input hidden type="file" id="my_we_logo" name="my_we_logo"  accept=".png, .jpg, .jpeg" value="<?php if($wr_logo){ echo $wr_logo;} else{echo 'logoChina.png';} ?>"/>
                      <input type="hidden" id="wr_logo" name="wr_logo" value="<?php if($wr_logo){ echo $wr_logo;} else{echo 'logoChina.png';} ?>" />
                    </div>
                  </div>
                  <div class="form-group row">                
                    <label >Entry Name</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-home"></i></span>
                      <input type="text" class="form-control"  name="wr_name" value="<?php if($wr_name){echo $wr_name;}else{ echo "LATIMCARGO";}?>" required placeholder="Enter Name">
                    </div>                   
                  </div>
                <div class="form-group row">                
                    <label >Level</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-star"></i></span>
                    <select name="level" id="" class="form-control select2" data-placeholder="Select Level" style="width:100%">
                        <option value="">Select Level</option>
                        <option 
                        <?php if($level=='Seller') {echo "selected";} ?>
                        value="Seller">Seller</option>
                        <option 
                        <?php if($level=='Administrator') {echo "selected";} ?>
                        value="Administrator">Administrator</option>
                    </select>
                    </div>                   
                </div>
                <div class="form-group row">
                    <label for=""><input type="checkbox" id="change_password" >&nbsp;&nbsp;<i class="fa fa-lock"></i> Change Password</label>
                </div>
                <div class="row change_password_content" style="display:none;margin-left:0px; margin-right:0px;">
                    <div class="form-group row">                
                        <label >New PassWord</label>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control"  name="password"  placeholder="Enter PassWord">
                        </div>                   
                    </div>
                    <div class="form-group row">                
                        <label >Confirm New PassWord</label>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control"  name="confirm_password"  placeholder="Enter PassWord Again">                            
                        </div>    
                        <small id="password_error" class="form-text text-muted" style="color:red;display:none">Password did not match.</small>               
                    </div>
                </div>                    
                <div class="form-group row text-right">                
                    <button  type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>                 
                </div>
                </form>
            </div>
        </div>  
    </div>       
    
</div>
<script>
    $(".select2").select2();
    
</script>
