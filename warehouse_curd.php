<?php 

include 'conn.php';
session_start();
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

if(isset($_POST["warehouse_tab1"]) && !empty($_POST["warehouse_tab1"])){
    $warehouse_id= $_POST['warehouse_id'];
    $fecha= $_POST['fecha'];
	$supplier_id= $_POST['supplier_id'];
	$agent_id= $_POST['agent_id'];
	$bill_id= $_POST['bill_id'];
	$consignee_id= $_POST['consignee_id'];
	$reference_id= $_POST['reference_id'];
	$invoice= $_POST['invoice'];
	$value= $_POST['value'];
	$po= $_POST['po'];
	$marks= $_POST['marks'];
	$delivered_by1= $_POST['delivered_by1'];
	$delivered_by2= $_POST['delivered_by2'];
	$tracking= $_POST['tracking'];
	$description= $_POST['description'];
	$comments= $_POST['comments'];
	$branch= $_POST['branch'];
	$pickup_number= $_POST['pickup_number'];
	$location1= $_POST['location1'];
	$location2= $_POST['location2'];
	$can= $_POST['can'];
	$destination= $_POST['destination'];
	$instination= $_POST['instination'];
	$terms= $_POST['terms'];
    $condition2= $_POST['condition2'];
    if(isset($_POST['distribution'])){
        $distribution= $_POST['distribution'];
    }else{
        $distribution= '';
    }
	
    $status= $_POST['status'];
    if(isset($_POST['dangerous_goods'])){
        $dangerous_goods= $_POST['dangerous_goods'];
    }else{
        $dangerous_goods= '';
    }
    if(isset($_POST['seo'])){
        $seo= $_POST['seo'];
    }else{
        $seo= '';
    }
    if(isset($_POST['fragile'])){
        $fragile= $_POST['fragile'];
    }else{
        $fragile= '';
    }
    if(isset($_POST['insurance'])){
        $insurance= $_POST['insurance'];
    }else{
        $insurance= '';
    }
	
	
	
	
	$dt = new DateTime($fecha);
    $fecha = $dt->format('Y-m-d H:i:s');
    $total_pieces=$_POST['total_pieces'];
    $total_weight=$_POST['total_weight'];
    $total_volume=$_POST['total_volume'];
    $total_charg_weight=$_POST['total_charg_weight'];
    $consulta2 = mysqli_query($connect, "SELECT * FROM warehouse WHERE id='$warehouse_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $date=date('Y-m-d H:i:s');
        if($supplier_id!=$colrow['supplier_id']){
            $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_id' limit 1 ") or die ("Error al traer los datos222");
            while ($row = mysqli_fetch_array($consulta)){
                $supplier_name=$row['name'];
            }
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Supplier Change: $supplier_name.', '$date')");

        }
        if($consignee_id!=$colrow['consignee_id']){
            $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$consignee_id' limit 1 ") or die ("Error al traer los datos222");
            while ($row = mysqli_fetch_array($consulta)){
                $consignee_name=$row['name'];
            }
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Consignee Change: $consignee_name.', '$date')");

        }
        if($agent_id!=$colrow['agent_id']){
            $consulta = mysqli_query($connect, "SELECT * FROM agents WHERE id='$agent_id' limit 1 ") or die ("Error al traer los datos222");
            while ($row = mysqli_fetch_array($consulta)){
                $agent__name=$row['name'];
            }
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Angent Change: $agent__name.', '$date')");

        }
        if($bill_id!=$colrow['bill_id']){
            $consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$bill_id' limit 1 ") or die ("Error al traer los datos222");
            while ($row = mysqli_fetch_array($consulta)){
                $bill_name=$row['name'];
            }
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Bill Change: $bill_name.', '$date')");

        }
        if($reference_id!=$colrow['reference_id']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Reference Change: $reference_id.', '$date')");
        }
        if($invoice!=$colrow['invoice']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Invoice Change: $invoice.', '$date')");
        }
        if($value!=$colrow['value']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Value Change: $value.', '$date')");
        }
        if($po!=$colrow['po']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Po Change: $po.', '$date')");
        }
        if($marks!=$colrow['marks']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Marks Change: $marks.', '$date')");
        }
        if($delivered_by1!=$colrow['delivered_by1']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Delivered By Change: $delivered_by1.', '$date')");
        }
        if($delivered_by2!=$colrow['delivered_by2']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Delivered By Change: $delivered_by2.', '$date')");
        }
        if($tracking!=$colrow['tracking']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Tracking Change: $tracking.', '$date')");
        }
        if($description!=$colrow['description']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Description Change: $description.', '$date')");
        }
        if($comments!=$colrow['comments']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Comments Change: $comments.', '$date')");
        }
        if($branch!=$colrow['branch']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Branch Change: $branch.', '$date')");
        }
        if($pickup_number!=$colrow['pickup_number']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Pickup Number Change: $pickup_number.', '$date')");
        }
        if($location1!=$colrow['location1']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Location Change: $location1.', '$date')");
        }
        if($location2!=$colrow['location2']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Location Change: $location2.', '$date')");
        }
        if($can!=$colrow['can']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Can Change: $can.', '$date')");
        }
        if($destination!=$colrow['destination']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Destination Change: $destination.', '$date')");
        }
        if($instination!=$colrow['instination']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Instination Change: $instination.', '$date')");
        }
        if($terms!=$colrow['terms']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Terms Change: $terms.', '$date')");
        }
        if($condition2!=$colrow['condition2']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Condition Change: $condition2.', '$date')");
        }
        if($distribution!=$colrow['distribution']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Distribution Change: $distribution.', '$date')");
        }
        if($status!=$colrow['status']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Status Change: $Status.', '$date')");
        }
        if($dangerous_goods!=$colrow['dangerous_goods']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Dangerous Goods Change: $dangerous_goods.', '$date')");
        }
        if($seo!=$colrow['seo']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Seo Change: $seo.', '$date')");
        }
        if($fragile!=$colrow['fragile']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Fragile Change: $fragile.', '$date')");
        }
        if($insurance!=$colrow['insurance']){          
            $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', 'Insurance Change: $insurance.', '$date')");
        }
    }
	$queryModel = mysqli_query($connect, 
	"UPDATE warehouse SET 
        fecha='$fecha',
        supplier_id='$supplier_id',
        agent_id='$agent_id',
        bill_id='$bill_id',
        consignee_id='$consignee_id',
        reference_id='$reference_id',
        invoice='$invoice',
        value='$value',
        po='$po',
        marks='$marks',
        delivered_by1='$delivered_by1',
        delivered_by2='$delivered_by2',
        tracking='$tracking',
        description='$description',
        comments='$comments',
        branch='$branch',
        pickup_number='$pickup_number',
        location1='$location1',
        location2='$location2',
        can='$can',
        destination='$destination',
        instination='$instination',
        terms='$terms',
        condition2='$condition2',
        distribution='$distribution',
        status='$status',
        dangerous_goods='$dangerous_goods',
        seo='$seo',
        fragile='$fragile',
        insurance='$insurance',
        total_pieces='$total_pieces',
        total_weight='$total_weight',
        total_volume='$total_volume',
        total_charg_weight='$total_charg_weight' 
    WHERE id='$warehouse_id'");
    $fecha=date('Y-m-d H:i:s');
    // $notes=$_POST['notes'];
    $getboxModel = mysqli_query($connect, "SELECT pieces_id FROM warehousecontents WHERE warehouse_id='$warehouse_id'")  
    or die ("Error al traer los datos222");
    while ($rowbox = mysqli_fetch_array($getboxModel)){  
        $get_pieces=$rowbox['pieces_id'];
        if(!in_array($get_pieces,$_POST['pieces_id'])){
            $queryModel = mysqli_query($connect, "DELETE FROM warehousecontents WHERE pieces_id='$get_piece'");  
        }
    }

    if(isset($_POST['byBoxes_piecesx']) && !empty($_POST['byBoxes_piecesx'])){
        foreach($_POST['byBoxes_piecesx'] as $key=>$item){
            if($_POST['byBoxes_piecesx'][$key]){
                if($_POST['pieces_id'][$key]){
                    $aaa=$_POST['pieces_id'][$key];
                    $getpieceModel = mysqli_query($connect, "SELECT byBoxes_pieces FROM warehousecontents WHERE pieces_id='$aaa'")  
                    or die ("Error al traer los datos222");
                    while ($rowpieces = mysqli_fetch_array($getpieceModel)){  
                        $num_pieces=$rowpieces['byBoxes_pieces'];
                    }
                    if($num_pieces>=$_POST['byBoxes_piecesx'][$key]){
                        for($i=1; $i<=$_POST['byBoxes_piecesx'][$key];$i++){
                            $querywarehousecontents = mysqli_query($connect, "UPDATE warehousecontents SET 
                            byBoxes_pieces='".$_POST['byBoxes_piecesx'][$key]."', 
                            byBoxes_lenght='".$_POST['byBoxes_lenghtX'][$key]."', 
                            byBoxes_width='".$_POST['byBoxes_widthX'][$key]."', 
                            byBoxes_height='".$_POST['byBoxes_heightX'][$key]."', 
                            byBoxes_weight='".$_POST['byBoxes_weightX'][$key]."' 
                            WHERE pieces_id='".$_POST['pieces_id'][$key]."' and pieces_num='$i'");
                        }
                        $queryModel = mysqli_query($connect, "DELETE FROM warehousecontents  WHERE pieces_id='".$_POST['pieces_id'][$key]."' and pieces_num>'".$_POST['byBoxes_piecesx'][$key]."'");
                    }else{
                        for($i=1; $i<=$num_pieces;$i++){
                            $querywarehousecontents = mysqli_query($connect, "UPDATE warehousecontents SET 
                            byBoxes_pieces='".$_POST['byBoxes_piecesx'][$key]."', 
                            byBoxes_lenght='".$_POST['byBoxes_lenghtX'][$key]."', 
                            byBoxes_width='".$_POST['byBoxes_widthX'][$key]."', 
                            byBoxes_height='".$_POST['byBoxes_heightX'][$key]."', 
                            byBoxes_weight='".$_POST['byBoxes_weightX'][$key]."' 
                            WHERE pieces_id='".$_POST['pieces_id'][$key]."' and pieces_num='$i'");
                        }
                        for($j=$num_pieces+1; $j<=$_POST['byBoxes_piecesx'][$key];$j++){
                            $querywarehousecontents = mysqli_query($connect, "INSERT INTO warehousecontents(warehouse_id,pieces_id, pieces_num, byBoxes_pieces, byBoxes_lenght, byBoxes_width, byBoxes_height, byBoxes_weight) 
                            VALUES ('$warehouse_id','$aaa', '$j', '".$_POST['byBoxes_piecesx'][$key]."', '".$_POST['byBoxes_lenghtX'][$key]."', '".$_POST['byBoxes_widthX'][$key]."', '".$_POST['byBoxes_heightX'][$key]."', '".$_POST['byBoxes_weightX'][$key]."' )");
                        }
                        
                    }
                }else{
                    $lastpiecesModel = mysqli_query($connect, "SELECT MAX(pieces_id)max_id FROM warehousecontents") or die ('error');
                    while ($row = mysqli_fetch_array($lastpiecesModel)){
                            $max_id=$row['max_id'];   
                        }
                    $pieces_id=$max_id+1;
                    for($i=1; $i<=$_POST['byBoxes_piecesx'][$key];$i++){
                        $querywarehousecontents = mysqli_query($connect, "INSERT INTO warehousecontents(warehouse_id,pieces_id, pieces_num, byBoxes_pieces, byBoxes_lenght, byBoxes_width, byBoxes_height, byBoxes_weight) 
                    VALUES ('$warehouse_id','$pieces_id', '$i', '".$_POST['byBoxes_piecesx'][$key]."', '".$_POST['byBoxes_lenghtX'][$key]."', '".$_POST['byBoxes_widthX'][$key]."', '".$_POST['byBoxes_heightX'][$key]."', '".$_POST['byBoxes_weightX'][$key]."' )");
                    }
                }
            }
        }
    }
    // $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', '$notes', '$fecha')");
     echo true;
}
if(isset($_POST["warehouse_tab2"]) && !empty($_POST["warehouse_tab2"])){
    $warehouse_id= $_POST['warehouse_id'];
    $fecha=date('Y-m-d H:i:s');
    // $notes=$_POST['notes'];
    if(isset($_POST['byBoxes_pricex']) && !empty($_POST['byBoxes_pricex'])){
        $queryModel = mysqli_query($connect, "DELETE FROM warehousechange_content WHERE warehouse_id='$warehouse_id'");  
        foreach($_POST['byBoxes_pricex'] as $key=>$item){
            if($_POST['byBoxes_pricex'][$key]){
                $querywarehousecontents = mysqli_query($connect, "INSERT INTO warehousechange_content(warehouse_id, byBoxes_description, byBoxes_price, byBoxes_quantity) 
                VALUES ('$warehouse_id', '".$_POST['byBoxes_descriptionx'][$key]."', '".$_POST['byBoxes_pricex'][$key]."', '".$_POST['byBoxes_quantityx'][$key]."')");
    
            }
        }
    }
    // $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$warehouse_id', '$notes', '$fecha')");
    echo true;
}
if(isset($_POST["deletewarehouse"]) && !empty($_POST["deletewarehouse"])){
    $warehouse_id= $_POST['warehouse_id'];
    $queryModel = mysqli_query($connect, "UPDATE warehouse SET deleted=1 WHERE id='$warehouse_id'"); 
    echo true;
}
if(isset($_POST["filedelete"]) && !empty($_POST["filedelete"])){
    $warehouse_id= $_POST['warehouse_id'];
    $name= $_POST['name'];
    $consulta2 = mysqli_query($connect, "SELECT * FROM warehouse WHERE id='$warehouse_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $file_item=$colrow['image_url'];
    }
    $file_arr=json_decode($file_item);
    $new_arr=[];
    foreach($file_arr as $key=>$item){
        if($item!=$name){
           array_push($new_arr,$item); 
        }
    }
    $fecha=date('Y-m-d H:i:s');
    $file=explode('/', $name);
    $file=end($file);
    $queryModel = mysqli_query($connect, "UPDATE warehouse_note SET status='0' WHERE warehouse_id='$warehouse_id' and file_name='$file' ");
    $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha, type, file_name, status) VALUES ('$agent_name', '$warehouse_id', 'File Delete:  $file.', '$fecha', 'file','$file',0)");

    $new_arr=json_encode($new_arr);
    $queryModel = mysqli_query($connect, "UPDATE warehouse SET image_url='$new_arr' WHERE id='$warehouse_id'");
    $name=str_replace('../','./', $name);
    unlink($name);
    echo true;
}
if(isset($_POST["status_Update"]) && !empty($_POST["status_Update"])){

    if(!empty($_POST["jobCheck"])){
            foreach($_POST["jobCheck"] as $jobCheck)
            {
                $fecha = date('Y-m-d H:i:s');
                $status = $_POST["status"];
                $queryModel = mysqli_query($connect, "UPDATE warehouse SET status='$status' WHERE id='$jobCheck' ") or die ('error');
                $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha) VALUES ('$agent_name', '$jobCheck', 'Status Change:  $status.', '$fecha')");
            }
        }
    echo true;

}
if(isset($_POST["warehouse_fileupload"]) && !empty($_POST["warehouse_fileupload"])){
    $warehouse_id=$_POST["warehouse_fileupload_id"];
    $consulta2 = mysqli_query($connect, "SELECT * FROM warehouse WHERE id='$warehouse_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $file_item=$colrow['image_url'];
    }
    $file_arr=json_decode($file_item);
    if($file_arr==Null){
       $arr='[]';
       $new_arr=json_decode($arr);
    }else{
        $new_arr=$file_arr;
    }
    $ruta="./images/warehouse/";
    $uploadfile=[];
    $fecha=date('Y-m-d H:i:s');
    foreach($_FILES['image_file']['name'] as $key=>$item){
        $uploadfile_temporal1=$_FILES['image_file']['tmp_name'][$key];
        $extension1 = pathinfo($_FILES['image_file']['name'][$key], PATHINFO_EXTENSION);
        $filename=$_FILES['image_file']['name'][$key];
        $path_parts = pathinfo($filename);
        $filename= $path_parts['filename'];
        if ($uploadfile_temporal1=='') {
        }else{
            $uploadfile_nombre1=$ruta.time().$filename.'.'.$extension1; 
            if (is_uploaded_file($uploadfile_temporal1)) 
            { 
                move_uploaded_file($uploadfile_temporal1,$uploadfile_nombre1); 
            }         
        }        
        $uploadfile_nombre1='.'.$uploadfile_nombre1;
        $file=explode('/', $uploadfile_nombre1);
        $file=end($file);
        $queryModel = mysqli_query($connect, "INSERT INTO warehouse_note(agent_name, warehouse_id, notes, fecha, type, file_name) VALUES ('$agent_name', '$warehouse_id', 'File Add:  $file.', '$fecha', 'file','$file')");
        array_push($new_arr,$uploadfile_nombre1);   
        array_push($uploadfile,$uploadfile_nombre1);            
    } 
    $new_arr=json_encode($new_arr);
    $queryModel = mysqli_query($connect, "UPDATE warehouse SET image_url='$new_arr' WHERE id='$warehouse_id' ") or die ('error');
    $new_arr=json_decode($new_arr);
    $html='';    
    foreach(array_reverse($new_arr) as $keyy=>$subarr){        
        $file=explode('/', $subarr);
        $file=end($file);
        $queryModel = mysqli_query($connect, "SELECT * from warehouse_note where file_name='$file' and type='file' and warehouse_id='$warehouse_id' and status=1 order by fecha desc") or die ('error');
        while ($row = mysqli_fetch_array($queryModel)){  
            $date=$row['fecha'];
        }
        $html.='<tr id="file_list_'.$keyy.'">';
        $html.='<td class="text-left"><a href="./images/warehouse/'.$file.'" class="file_download" target="blank" >'.$file.'</a></td>';
        $html.='<td class="text-center">'.$agent_name.'</td>';
        $html.='<td class="text-center">'.date_format(date_create($date),'m/d/Y H:i:s').'</td>';
        $html.="<td class='text-center'><a href='#' onclick='onfiledelete(".$keyy.", ".$warehouse_id.",\"".$subarr."\")' ><i  style='color:red; font-size:20px;' class='fa fa-trash'></i></a></td>";
        $html.='</tr>';
    }

    echo $html;
}
if(isset($_POST["jobfind"]) && !empty($_POST["jobfind"])){

    $id=$_POST['jobid'];
    $data=[];
    $consulta = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ")
        or die ("Error al traer los Agent");
        while ($row = mysqli_fetch_array($consulta)){
            $data['bill_id']=$row['client_id'];
            $data['supplier_id']=$row['supplier_id'];
            $data['tracking']=$row['tracking'];
            $data['branch']=$row['branch'];
            $data['agent_id']=$row['agent_id'];
            $data['commodity']=$row['commodity'];
            $data['service']=$row['service'];
            $data['customer_city']=$row['customer_city'];
        } 
    if(mysqli_num_rows($consulta)==1){
        $return['success']=true;
        $return['data']=$data;
    }else{
        $return['success']=false; 
    }
    echo json_encode($return);

}
if(isset($_POST["qrcode"]) && !empty($_POST["qrcode"])){

    $id=$_POST['jobid'];
    require ('./tc-lib-barcode/vendor/autoload.php');
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $targetPath = "qr-code/";
    
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
    $bobj = $barcode->getBarcodeObj('QRCODE,H', $id, - 16, - 16, 'black', array(
        - 2,
        - 2,
        - 2,
        - 2
    ))->setBackgroundColor('#f0f0f0');
    
    $imageData = $bobj->getPngData();
    $timestamp = time();    
    file_put_contents($targetPath . $timestamp . '.png', $imageData);
    $return['targetPath']=$targetPath;
    $return['timestamp']=$timestamp;
    echo json_encode($return);
}
if(isset($_POST["edit_consignee"]) && !empty($_POST["edit_consignee"])){
    $id= $_POST['id'];
    $company= $_POST['company'];
	$name= $_POST['name'];
	$address_1= $_POST['address_1'];
	$address_2= $_POST['address_2'];
	$city= $_POST['city'];
	$state= $_POST['state'];
	$country= $_POST['country'];
	$telf1= $_POST['telf1'];
	$telf2= $_POST['telf2'];
	$qq= $_POST['qq'];
	$wechat= $_POST['wechat'];
	$email= $_POST['email'];

    $queryModel = mysqli_query($connect, "UPDATE accounts SET
                                        company='$company',
                                        name='$name',
                                        city='$city',
                                        state='$state',
                                        address_1='$address_1',
                                        address_2='$address_2',
                                        country='$country',
                                        telf1='$telf1',
                                        telf2='$telf2',
                                        qq='$qq',
                                        wechat='$wechat',                                              
                                        email='$email' 
                                        WHERE id='$id'"); 
    echo true;
}
if(isset($_POST["edit_supplier"]) && !empty($_POST["edit_supplier"])){
    $id= $_POST['id'];
    $company= $_POST['company'];
	$name= $_POST['name'];
	$address_1= $_POST['address_1'];
	$address_2= $_POST['address_2'];
	$city= $_POST['city'];
	$state= $_POST['state'];
	$country= $_POST['country'];
	$telf1= $_POST['telf1'];
	$telf2= $_POST['telf2'];
	$qq= $_POST['qq'];
	$wechat= $_POST['wechat'];
	$email= $_POST['email'];

    $queryModel = mysqli_query($connect, "UPDATE accounts SET
                                        company='$company',
                                        name='$name',
                                        city='$city',
                                        state='$state',
                                        address_1='$address_1',
                                        address_2='$address_2',
                                        country='$country',
                                        telf1='$telf1',
                                        telf2='$telf2',
                                        qq='$qq',
                                        wechat='$wechat',                                              
                                        email='$email' 
                                        WHERE id='$id'"); 
    echo true;
}
if(isset($_POST["edit_bill"]) && !empty($_POST["edit_bill"])){
    $id= $_POST['id'];
    $company= $_POST['company'];
	$name= $_POST['name'];
	$address_1= $_POST['address_1'];
	$address_2= $_POST['address_2'];
	$city= $_POST['city'];
	$state= $_POST['state'];
	$country= $_POST['country'];
	$telf1= $_POST['telf1'];
	$telf2= $_POST['telf2'];
	$qq= $_POST['qq'];
	$wechat= $_POST['wechat'];
	$email= $_POST['email'];

    $queryModel = mysqli_query($connect, "UPDATE accounts SET
                                        company='$company',
                                        name='$name',
                                        city='$city',
                                        state='$state',
                                        address_1='$address_1',
                                        address_2='$address_2',
                                        country='$country',
                                        telf1='$telf1',
                                        telf2='$telf2',
                                        qq='$qq',
                                        wechat='$wechat',                                              
                                        email='$email' 
                                        WHERE id='$id'"); 
    echo true;
}