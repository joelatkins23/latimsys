<?php 
include 'conn.php';
session_start();
$id= $_GET['id'];
$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM loading_guide WHERE id='$id' ")
    or die ("Error al traer los Agent");
     while ($row = mysqli_fetch_array($consultaAgent)){
        $branch=$row['branch'];
        $agent_id=$row['agent_id'];
        $reference=$row['reference'];
        $line=$row['line'];
        $type=$row['type'];  
        $type=$row['type'];
        $loose_pieces=$row['loose_pieces'];
        $warehouse_list=$row['warehouse_list'];
        $all_total_pieces=$row['all_total_pieces'];
        $all_total_weight=$row['all_total_weight'];
        $all_total_volume=$row['all_total_volume'];
        $all_total_charg_weight=$row['all_total_charg_weight'];
        $status=$row['status'];
        $id=$row['id'];
        $all_list=json_decode($warehouse_list);
        $all_list=implode(',', $all_list);
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
            <div class="col-md-8">
                <h4 class="modal-title"><strong>Loading Guide</strong>  #<?php echo $id;?>
                <form method="POST" id="delete_loading_guide" action="./warehouse_loading_curd.php" style="display: contents;"> 
                    <input  type="hidden" name="id" value="<?php echo $id;?>">
                    <input  type="hidden" name="delete_loading_guide" value="delete">
                    <button type="submit" Onclick="return ConfirmDelete()" class="btn btn-danger">Delete</button>
                </form>
                </h4>   
            </div>
            
            <div class="col-md-3 text-right" >
                <div class="checkbox_content">
                    <label for="">Change Status</label><br>
                    <div class="">
                        <label class="radio-inline"><input type="radio" 
                        <?php if($status=='lock'){echo "checked";} ?>
                        name="status" value="lock"><i class="fa fa-lock" style="font-size:25px;"></i></label>
                        <label class="radio-inline"><input type="radio"
                        <?php if($status=='unlock'){echo "checked";} ?>
                        name="status" value="unlock"><i class="fa fa-unlock-alt" style="font-size:25px;"></i></label>                
                    </div>           
                </div>
            </div>
        </div>
    </div>
        <div class="modal-body">
            <form id="update_loading_guide" action="./warehouse_loading_curd.php" method="POST">
            <input type="hidden" name="update_loading_guide" value="update">
            <input  type="hidden" name="id" value="<?php echo $id;?>">
            <div class="row" >
                <div class="col-md-12" style="padding:30px;">
                <input type="hidden" name="all_total_pieces" value="<?php echo $all_total_pieces; ?>">
                <input type="hidden" name="all_total_weight" value="<?php echo $all_total_weight; ?>">
                <input type="hidden" name="all_total_volume" value="<?php echo $all_total_volume; ?>">
                <input type="hidden" name="all_total_charg_weight" value="<?php echo $all_total_charg_weight; ?>"> 
                <input type="hidden" name="all_warehouselist" value="<?php echo $all_list; ?>"> 
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
                                <th id="all_total_pieces" class="text-center"><?php echo $all_total_pieces; ?></th>
                                <th id="all_total_weight" class="text-center"><?php echo $all_total_weight; ?></th>
                                <th id="all_total_volume" class="text-center"><?php echo $all_total_volume; ?></th>
                                <th id="all_total_charg_weight" class="text-center"><?php echo $all_total_charg_weight; ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>              
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Branch</span>
                            <input type="text" name="branch" class="form-control" placeholder="Input Branch" value="<?php echo $branch; ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Agent</span>
                            <select name="agent_id" id="" class="form-control select2" data-placeholder="Select Agent" style="width:100%" >
                                <option value="">--Select Agent--</option>
                            <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM agents  where level='Administrator' or level='Seller' order by id ")
                                or die ("Error al traer los Agent");
                                while ($row = mysqli_fetch_array($consulta)){
                            
                                    $ID=$row['id'];
                                    $name=$row['name'];
                            ?>
                                <option 
                                <?php if($agent_id==$ID){ echo "selected"; } ?>
                                value="<?php echo $ID; ?>"><?php echo $ID; ?> <?php echo $name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>                  
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Reference</span>
                            <input type="text" name="reference" class="form-control" placeholder="Input Reference" value="<?php echo $reference; ?>">
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Line</span>
                            <input type="text" name="line" class="form-control" placeholder="Input Line" value="<?php echo $line; ?>">
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon span_custom">Type</span>
                            <input type="text" name="type" class="form-control" placeholder="Input Type" value="<?php echo $type; ?>">
                        </div>
                        </div>                  
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4" for="" style="margin-top:10px;font-weight: 500;">Loose Pieces</label>
                        <div class="col-md-8">
                                <label class="control-label radio-inline"><input type="radio" value="Yes" 
                                <?php if($loose_pieces=='Yes'){echo "checked";} ?>
                                name="losses_pieces" >&nbsp;Yes</label>
                                <label class="control-label radio-inline"><input type="radio"
                                <?php if($loose_pieces=='No'){echo "checked";} ?>
                                value="No" name="losses_pieces">&nbsp;No</label>
                        </div>
                    </div>                
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12">                            
                    <div class="card">
                        <p style="color:#000;"><i class="fa fa-check-circle"></i>&nbsp;Remarks</p>
                        <div class="table-responsive" style="max-height: 200px;overflow-y: auto;">
                            <table class="table">
                                <?php 
                                $consulta = mysqli_query($connect, "SELECT * FROM loading_guide_note WHERE loadingguide_id='$id' ORDER BY fecha desc ") or die ("Error al traer los datos222");
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
                    </div>
                </div>
                <div class="row">
                    <?php if($status=='unlock'){ ?>
                        <div class="col-md-12 text-right" style="padding-right:30px;">
                            <button type="button"  id="inculde_warehouse" class="btn btn-danger"><i class="fa fa-plus"></i>Add WareHouse</button>
                        </div>
                    <?php } ?>
                    <div class="col-md-12" style="padding:10px 30px;">
                        <div class="table-responsive">
                            <table id='warehouse_reciept_lists' style="width:100%;" class="table">
                                <thead>
                                    <tr class="text-center" style="background-color:#B80008 !important;color:white">
                                        <th class="text-center">Number</th>
                                        <th class="text-center">Reference</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Dest</th>                          
                                        <th class="text-center">Pieces</th>
                                        <th class="text-center">Weight</th>
                                        <th class="text-center">Volume</th>
                                        <th class="text-center">Shipper</th>
                                        <th class="text-center">Consignee</th>
                                        <?php if($status=='unlock'){ ?>
                                        <th class="text-center">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($warehouse_list)){
                                        $wares_list	= json_decode($warehouse_list);
                                        foreach($wares_list as $key=>$item){                               
                                            $queryModel = mysqli_query($connect, "select a.*, b.name as supplier_name,c.name as consignee_name from warehouse a
                                            left join accounts b on (a.supplier_id=b.id)
                                            left join accounts c on (a.consignee_id=c.id) WHERE a.id='$item'") or die ('error');
                                            while ($rows = mysqli_fetch_array($queryModel)){  
                                                
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $rows['id']; ?></td>
                                            <td class="text-center"><?php echo $rows['reference_id']; ?></td>
                                            <td class="text-center"><?php echo date_format(date_create($row['fecha']),'m/d/Y'); ?></td>
                                            <td class="text-center"><?php echo $rows['destination']; ?></td>
                                            <td class="text-center"><?php echo $rows['total_pieces']; ?></td>
                                            <td class="text-center"><?php echo $rows['total_weight']; ?></td>
                                            <td class="text-center"><?php echo $rows['total_volume']; ?></td>
                                            <td class="text-center"><?php echo $rows['supplier_name']; ?></td>
                                            <td class="text-center"><?php echo $rows['consignee_name']; ?></td>
                                            <?php if($status=='unlock'){ ?>
                                            <td class="text-center"><a href='#' onclick='onwarehousedelete_loading(<?php echo $key; ?>, <?php echo $rows["id"]; ?>)' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>
                                            <?php } ?>
                                        </tr>

                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>                 
                    </div>
                </div>
                <div class="row" style="margin-bottom:30px;margin-right:0px;">
                    <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
          </div> 
        </div>        
    
</div>
<script>
    $(".select2").select2();
</script>
