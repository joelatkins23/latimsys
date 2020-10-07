<?php 
include 'conn.php';
session_start();
$id= $_GET['id'];
$email = $_SESSION['username'];
 $consultaAgent = mysqli_query($connect, "SELECT * FROM pre_loading_plan WHERE id='$id' ")
    or die ("Error al traer los Agent");
     while ($row = mysqli_fetch_array($consultaAgent)){
        $branch=$row['branch'];
        $agent_id=$row['agent_id'];
        $reference=$row['reference'];
        $line=$row['line'];
        $type=$row['type'];  
        $type=$row['type'];
        $loose_pieces=$row['loose_pieces'];
        $joborder_list=$row['joborder_list'];       
        $status=$row['status'];
        $id=$row['id'];
        $all_list=json_decode($joborder_list);
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
                <h4 class="modal-title"><strong>Pre Loading Plan</strong>  #<?php echo $id;?>
                <form method="POST" id="delete_pre_loading_plan" action="./joborder_loading_curd.php" style="display: contents;"> 
                    <input  type="hidden" name="id" value="<?php echo $id;?>">
                    <input  type="hidden" name="delete_pre_loading_plan" value="delete">
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
            <form id="update_pre_loading_plan" action="./joborder_loading_curd.php" method="POST">
            <input type="hidden" name="update_pre_loading_plan" value="update">
            <input  type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="all_joborderslist" value="<?php echo $all_list; ?>">            
            <div class="row" style="margin-top:20px;">
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
                                $consulta = mysqli_query($connect, "SELECT * FROM pre_loading_plan_note WHERE pre_loading_plan_id='$id' ORDER BY fecha desc ") or die ("Error al traer los datos222");
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
                 <div class="col-md-12 text-right" style="padding-right:30px;">
                    <button type="button" class="btn btn-success download_excel"><i class="fa fa-file"></i>&nbsp;Download Excel</button>
                    <?php if($status=='unlock'){ ?>                       
                           
                            <button type="button"  id="inculde_joborders" class="btn btn-danger"><i class="fa fa-plus"></i>&nbsp;Add JobOrders</button>
                        
                    <?php } ?>
                    </div>
                    <div class="col-md-12" style="padding:10px 30px;">
                        <div class="table-responsive">
                            <table id='joborders_lists' style="width:100%;" class="table">
                                <thead>
                                    <tr class="text-center" style="background-color:#B80008 !important;color:white">
                                        <td class="text-center" style="color:white">Date</td>
                                        <td class="text-center" style="color:white">JOB</td>
                                        <td class="text-center" style="color:white">Customer<br>Name</td>
                                        <td class="text-center" style="color:white">Supplier<br>Company</td>                          
                                        <td class="text-center" style="color:white">Service</td>
                                        <td class="text-center" style="color:white">Ship To</td>
                                        <td class="text-center" style="color:white">Agent<br>Name</td>
                                        <td class="text-center" style="color:white">Status</td>
                                        <td class="text-center" style="color:white">Tracking#</td>
                                        <td class="text-center" style="color:white">WR#</td>
                                        <?php if($status=='unlock'){ ?>
                                        <td class="text-center" style="color:white">Action</td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(!empty($joborder_list)){
                                        $joborder_list	= json_decode($joborder_list);
                                        foreach($joborder_list as $key=>$item){                               
                                            $queryModel = mysqli_query($connect, "select a.id, a.fecha, a.status, a.service, a.tracking, b.name as customer_name, c.company as supplier_company,d.name as agent_name, a.customer_city from joborders a 
                                            left join accounts b on a.client_id =b.id 
                                            left join accounts c on a.supplier_id =c.id 
                                            left join agents d on a.agent_id=d.id 
                                            WHERE a.branch='' and a.id='$item'") or die ('error');
                                            while ($row = mysqli_fetch_array($queryModel)){  
                                                $id=$row['id'];
                                                if ($row['status']=='IN WAREHOUSE') {$statuss='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#00a75a; ">'.$row['status'].'</div>';}
                                                elseif ($row['status']=='PENDING') {$statuss='<div style="font-weight:600; font-size:9px; color:white; padding:5px;width:80px; border:0.5px solid gray; background:#db4c39; ">'.$row['status'].'</div>';}
                                                elseif ($row['status']=='READY TO CONTACT') {$statuss='<div style="font-weight:600; font-size:9px; color:white; width:80px; padding:5px; border:0.5px solid gray; background:#00c2f0; ">'.$row['status'].'</div>';}
                                                elseif ($row['status']=='CHECK NOTES') {$statuss='<div style="font-weight:600; font-size:9px; color:purple; padding:5px;width:80px; border:0.5px solid gray; background:#a62c0d8; ">'.$row['status'].'</div>';}
                                                else{$statuss='<div style="font-weight:600; color:black;">'.$row['status'].'</div>';}
                                                $shipping = $row['customer_city'].'<br><img src="./img/venezuela.png" style="width:40px;">';
                                                $service=$row['service'];
                                                if ($service=='') {$service=' ';}
                                                elseif ($service=='Air Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/air.png" style="width:40px; position:relative; top:10px;"><br>';}
                                                elseif($service=='Ocean Service') {$service_img='<span style="position:relative; top:-5px;"><img src="./img/ocean.png" style="width:40px; position:relative; top:10px;"><br>';}
                                                else{ $service_img='<span style="position:relative; top:0px;"><img src="./img/pending.png" style="width:20px; position:relative; top:4px;"><br>';}
                                                $service = ' '.$service_img.$row['service'].'</span>';
                                                $date=$row['fecha'];

                                                $supplier_company = $row['supplier_company'];
                                                $attr= "left=20,top=20,width=900,height=700,toolbar=1,resizable=0";
                                                $result = $connect->query("SELECT COUNT(*) AS total FROM notes WHERE jobOrderId='".$row["id"]."'")->fetch_array();
                                                if($result[0]!='0'){
                                                    $brage='<span class="label label-success brage">'.$result[0].'</span>';
                                                }else{
                                                    $brage=''; 
                                                }
                                                $wr='';
                                                $consultaWR = mysqli_query($connect, "SELECT * FROM receipt WHERE jobOrderId='".$row['id']."' order by id desc limit 1 ") or die ("Error al traer los Agent");
                                                while ($rowWR = mysqli_fetch_assoc($consultaWR)){
                                                    $WHReceipt=$rowWR['wr'];
                                                    $wr.='<a href="#" ><i class="fa fa-barcode" style="font-size: 30px;color: black;"></i></a><p>WR#'.$WHReceipt.'</p>';
                                                }

                                                $customer=$row['customer_name'];
                                                if ($customer=='') {$customer=' ';}

                                                $trackingJob= $row['tracking'];
                                                $tracking='<span style="font-size:10px; font-weight:600;">';
                                                if($trackingJob!=''){
                                                    $tracking.="Tracking J.O:".$trackingJob."<br>";
                                                }else{
                                                    $tracking.=$trackingJob."<br>";
                                                }
                                                $consultatrackings = mysqli_query($connect, "SELECT * FROM trackings WHERE jobOrderId='".$row['id']."' ORDER BY id DESC ") or die ("Error al traer los datos");

                                                while ($rowtrackings = mysqli_fetch_array($consultatrackings)){  

                                                    $tracking_text= $rowtrackings['tracking'];
                                                    $carrier= $rowtrackings['carrier']; 
                                                    $tracking.=$carrier.': '.$tracking_text.".<br>";

                                                }
                                                $tracking.='</span>';
                                                $agent=$row['agent_name'];
                                                
                                        ?>
                                        <tr id="joborders_loading_<?php echo $row['id'] ?>">
                                            <td class="text-center"><?php echo date_format(date_create($date),'m/d/Y H:i:s'); ?></td>
                                            <td class="text-center"><?php echo $id; ?></td>
                                            <td class="text-center"><?php echo $customer; ?></td>
                                            <td class="text-center"><?php echo $supplier_company; ?></td>
                                            <td class="text-center"><?php echo $service; ?></td>
                                            <td class="text-center"><?php echo $shipping; ?></td>
                                            <td class="text-center"><?php echo $agent; ?></td>
                                            <td class="text-center"><?php echo $statuss; ?></td>
                                            <td class="text-center"><?php echo $tracking; ?></td>
                                            <td class="text-center"><?php echo $wr; ?></td>
                                            <?php if($status=='unlock'){ ?>
                                            <td class="text-center"><a href='#' onclick='onjobordersdelete_loading(<?php echo $key; ?>, <?php echo $row["id"]; ?>)' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>
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
