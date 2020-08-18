<?php 

require_once('conn.php');
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

 ?>
<div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-files-o"></i>&nbsp; Add File</h4>
    </div>
    <div class="modal-body" style="margin:20px;">
        <form action="./curd.php" id="addfile" method="post" enctype="multipart/form-data">
            <input type="hidden" id="joborder_fileupload" name="joborder_fileupload" value="add">
            <input type="hidden" id="joborder_fileupload_id" name="joborder_fileupload_id" value="<?php echo $id; ?>">
            <input type="hidden"  name="agent_name" value="<?php echo $agent_name; ?>">
            <div class="row">
                <div class="col-md-12">
                    <input type="file" id="image_file" name="image_file[]" class="file-upload" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf"   multiple/> 
                </div>
                <div class="col-md-12 text-center" style="margin:20px auto;">
                    <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i>&nbsp;Upload</button>
                </div>
            </div>                
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class="table" width="100%">
                    <thead>
                        <tr>                           
                            <th class="text-center">File Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">By</th>
                            <th class="text-center">Note</th>
                        </tr>
                    </thead>
                    <tbody id="file_body">
                    <?php $consultaNotes = mysqli_query($connect, "SELECT * FROM joborder_atteched WHERE joborder_id='$id' ORDER BY id DESC ") or die ("Error al traer los datos");

                    while ($rowNotes = mysqli_fetch_array($consultaNotes)){  
                            $agent_name = $rowNotes['agent_name'];
                            $notes= $rowNotes['notes'];
                            $file_name= $rowNotes['file_name'];
                            $fecha_note= $rowNotes['fecha']; 
                            ?>                  
                        <tr>
                            
                            <td class="text-center"><a href="./images/joborder/<?php echo $file_name; ?>" class="file_download" target="blank" ><?php echo $file_name; ?></a></td>
                            <td class="text-center"><?php echo date_format(date_create($fecha_note),'m/d/Y H:i:s'); ?></td>
                            <td class="text-center"><?php echo $agent_name; ?></td>
                            <td class="text-center"><?php echo $notes; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>        
</div>
<script>
 $('input[type="file"]').imageuploadify();
</script>