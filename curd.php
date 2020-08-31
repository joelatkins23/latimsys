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
if(isset($_POST["get_account"]) && !empty($_POST["get_account"])){

    $id= $_POST['id'];
    $consulta2 = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $data['id']=$id;
        $agent=$colrow['agent'];
        $data['company']=$colrow['company'];
        $data['name']=$colrow['name'];
        $data['address_1']=$colrow['address_1'];
        $data['address_2']=$colrow['address_2'];
        $data['city']=$colrow['city'];
        $data['state']=$colrow['state'];
        $data['country']=$colrow['country'];
        $data['telf1']=$colrow['telf1'];
        $data['telf2']=$colrow['telf2'];
        $data['qq']=$colrow['qq'];
        $data['wechat']=$colrow['wechat'];
        $data['email']=$colrow['email'];
        $data['type']=$colrow['type'];
        $data['agent_name']=$colrow['agent'];
    }
    $html='<option selected value="'.$agent.'">'.$agent.'</option>';;
    $consultagent = mysqli_query($connect, "SELECT * FROM agents ORDER BY name asc ") or die ("Error al traer los datos222");
        while ($row = mysqli_fetch_array($consultagent)){ 
           
           $html.='<option  value="'.$row['name'].'">'.$row['name'].'</option>';
        }
    $data['agent']=$html;
    echo json_encode($data);
}
if(isset($_POST["account_update"]) && !empty($_POST["account_update"])){

    $id= $_POST['id'];
    $agent= $_POST['agent_name'];    
    $company= $_POST['company']; 
    $name=$_POST['name'];
    $address_1=$_POST['address_1'];
    $address_2=$_POST['address_2'];
    $city=$_POST['city'];   
    $state=$_POST['state'];
    $country=$_POST['country'];
    $telf1=$_POST['telf1'];
    $telf2=$_POST['telf2'];
    $qq=$_POST['qq'];
    $wechat=$_POST['wechat'];
    $email=$_POST['email'];
    $type=$_POST['type'];
    $queryModel = mysqli_query($connect, "UPDATE accounts SET 
                        agent='$agent',
                        company='$company',
                        name='$name',
                        city='$city',
                        state='$state',
                        country='$country',
                        telf1='$telf1',
                        telf2='$telf2',
                        qq='$qq',
                        wechat='$wechat',
                        address_1='$address_1',
                        address_2='$address_2',
                        email='$customer_email',
                        type='$type'
                        WHERE id='$id' ");

    if($queryModel){
        return true;
    }else{
        return false;
    }
}  
if(isset($_POST["editorder"]) && !empty($_POST["editorder"])){

    $jobId= $_POST['jobId'];
    $agent_id= $_POST['agent_id'];    
    $supplier_id= $_POST['supplier_id']; 
    $client_id= $_POST['client_id']; 
    $supplier_company=$_POST['supplier_company'];
    $supplier_name=$_POST['supplier_name'];
    $supplier_telf1=$_POST['supplier_telf1'];
    $supplier_telf2=$_POST['supplier_telf2'];
    $supplier_qq=$_POST['supplier_qq'];
    $supplier_wechat=$_POST['supplier_wechat'];   
    $supplier_email=$_POST['supplier_email'];
    $supplier_address1=$_POST['supplier_address1'];
    $supplier_address2=$_POST['supplier_address2'];
    $supplier_city=$_POST['supplier_city'];
    $supplier_state=$_POST['supplier_state'];
    $supplier_country=$_POST['supplier_country'];
    $customer_company=$_POST['customer_company'];
    $customer_name=$_POST['customer_name'];
    $customer_telf1=$_POST['customer_telf1'];
    $customer_telf2=$_POST['customer_telf2'];
    $customer_qq=$_POST['customer_qq'];
    $customer_wechat=$_POST['customer_wechat'];
    $customer_email=$_POST['customer_email'];
    $customer_address1=$_POST['customer_address1'];
    $customer_address2=$_POST['customer_address2'];
    $customer_city=$_POST['customer_city'];
    $customer_state=$_POST['customer_state'];
    $customer_country=$_POST['customer_country'];
    $service= $_POST['service'];
    $commodity= $_POST['commodity'];
    $remark= $_POST['remark'];
    $branch= $_POST['branch'];
    $wh_receipt= $_POST['wh_receipt'];
    $fecha=date('Y-m-d H:i:s');
    if($client_id){
        $queryModel = mysqli_query($connect, "UPDATE accounts SET
                        company='$customer_company',
                        name='$customer_name',
                        city='$customer_city',
                        state='$customer_state',
                        country='$customer_country',
                        telf1='$customer_telf1',
                        telf2='$customer_telf2',
                        qq='$customer_qq',
                        wechat='$customer_wechat',
                        address_1='$customer_address1',
                        address_2='$customer_address2',                        
                        email='$customer_email'
                        WHERE id='$client_id' ");
    }else{
        $type='Client';
        if ($customer_company=='' && $type=='Client') {
            $customer_company = 'Particular';
        }    
        if ($customer_name=='' && $type=='Client') {
            $customer_name = 'Pending';
        }
        $queryModel1 = mysqli_query($connect, "INSERT INTO accounts(company, name, address_1, address_2, city, state, country, telf1, telf2, qq, wechat, email, type, fecha) 
        VALUES ('$customer_company', '$customer_name', '$customer_address1', '$customer_address2', '$customer_city', '$customer_state', '$customer_country', '$customer_telf1', '$customer_telf2', '$customer_qq', '$customer_wechat', '$customer_email', '$type', '$fecha')");
    $client_id = mysqli_insert_id($connect);
}
    
    if($supplier_id){
        $queryModel = mysqli_query($connect, "UPDATE accounts SET
            company='$supplier_company',
            name='$supplier_name',
            telf1='$supplier_telf1',
            telf2='$supplier_telf2',
            qq='$supplier_qq',
            wechat='$supplier_wechat',
            address_1='$supplier_address1',
            address_2='$supplier_address2',
            city='$supplier_city',
            state='$supplier_state',
            country='$supplier_country',
            email='$supplier_email'
            WHERE id='$supplier_id' ");
    }else{ 
        $type='Supplier';       
        $agent_name = 'Supplier';
        $sql="INSERT INTO accounts(agent, company, name, address_1, address_2, city, state, country, telf1, telf2, qq, wechat, email, type, fecha) 
        VALUES ('$agent_name', '$supplier_company', '$supplier_name', '$supplier_address1', '$supplier_address2', '$supplier_city', '$supplier_state', '$supplier_country', '$supplier_telf1', '$supplier_telf2', '$supplier_qq', '$supplier_wechat', '$supplier_email', '$type', '$fecha')";
        $queryModel1 = mysqli_query($connect, "INSERT INTO accounts(agent, company, name, address_1, address_2, city, state, country, telf1, telf2, qq, wechat, email, type, fecha) 
        VALUES ('$agent_name', '$supplier_company', '$supplier_name', '$supplier_address1', '$supplier_address2', '$supplier_city', '$supplier_state', '$supplier_country', '$supplier_telf1', '$supplier_telf2', '$supplier_qq', '$supplier_wechat', '$supplier_email', '$type', '$fecha')");
        $supplier_id = mysqli_insert_id($connect); 
}
    

    $queryModel = mysqli_query($connect, "UPDATE joborders SET agent_id='$agent_id', supplier_id='$supplier_id', client_id='$client_id', service='$service', commodity='$commodity', wh_receipt='$wh_receipt', remark='$remark',  branch='$branch' WHERE id='$jobId' ");

    if($queryModel){
        return true;
    }else{
        return false;
    }
}
if(isset($_POST["createnote"]) && !empty($_POST["createnote"])){

    $jobOrderId= $_POST['jobOrderId'];
    $note= $_POST['note'];
    $noteBy= $_POST['noteBy'];
    $agent_name= $_POST['agent_name'];
    $dt = new DateTime($fecha);
    $fecha = $dt->format('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha)  VALUES ('$noteBy', '$jobOrderId', '$note', '$fecha')");
       if($queryModel){
           return true;
       }else{
           return false;
       }
   }

if(isset($_POST["order_delete"]) && !empty($_POST["order_delete"])){

    $id= $_POST['jobId'];        
    $modifica= "DELETE FROM joborders WHERE id='$id'";
    $resultado = mysqli_query($connect, $modifica);
    if($resultado){
        return true;
    }else{
        return false;
    }
}

if(isset($_POST["status_Update"]) && !empty($_POST["status_Update"])){

    if(!empty($_POST["jobCheck"])){
            foreach($_POST["jobCheck"] as $jobCheck)
            {
                $dt = new DateTime($fecha);
                $fecha = $dt->format('Y-m-d H:i:s');
                $statusUpdate = $_POST["statusUpdate"];
                $queryModel = mysqli_query($connect, "UPDATE joborders SET status='$statusUpdate' WHERE id='$jobCheck' ") or die ('error');
                $queryModel = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha) VALUES ('$agent_name', '$jobCheck', 'Updated to:  $statusUpdate.', '$fecha')");
            }
        }
    return true;

}
if(isset($_POST["addwr"]) && !empty($_POST["addwr"])){

        $jobOrderId= $_POST['jobOrderId'];
        $wr= $_POST['wr'];
        $agent_name= $_POST['agent_name'];
        $dt = new DateTime($fecha);
        $fecha = $dt->format('Y-m-d H:i:s');
        $queryModel = mysqli_query($connect, "INSERT INTO receipt(jobOrderId, wr, fecha) VALUES ('$jobOrderId', '$wr', '$fecha')");
        $queryModel2222 = mysqli_query($connect, "UPDATE joborders SET status='IN WAREHOUSE', wr='$wr' WHERE id='$jobOrderId' ") or die ('error');
        $queryModel2333 = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha)  VALUES ('$agent_name', '$jobOrderId', 'Updated to:  IN WAREHOUSE.', '$fecha')");
        return true;
        
}
if(isset($_POST["delete_wr"]) && !empty($_POST["delete_wr"])){
    $id= $_POST['jobId'];
    $modifica= "DELETE FROM receipt WHERE jobOrderId='$id'";
    $resultado = mysqli_query($connect, $modifica)   or die ("Error al insertar los registros");
    if($resultado){
        return true;
    }else{
        return false;
    }
}
if(isset($_POST["addtracking"]) && !empty($_POST["addtracking"])){

    $jobOrderId= $_POST['jobOrderId'];
    $tracking= $_POST['tracking'];
    $trackingBy= $_POST['trackingBy'];
    $carrier= $_POST['carrier'];
    $fecha = date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO trackings(agent_name, jobOrderId, carrier,  tracking, fecha) 
      VALUES ('$trackingBy', '$jobOrderId', '$carrier', '$tracking', '$fecha')")  or die ("Error al insertar los registros");
    return true;
     
}
if(isset($_GET["delete_tracking"]) && !empty($_GET["delete_tracking"])){

    $trackingId= $_GET["delete_tracking"];
    $queryModel = mysqli_query($connect, "DELETE FROM trackings WHERE id='$trackingId'")  or die ("Error al insertar los registros");
    return true;
     
}


if(isset($_POST["create_quotation"]) && !empty($_POST["create_quotation"])){

    $jobOrderId= $_POST['jobOrderId'];
    $note= $_POST['note'];
    $noteBy= $_POST['noteBy'];
    $fecha = date('Y-m-d H:i:s');
    $queryModel = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha) 
    VALUES ('$noteBy', '$jobOrderId', '$note', '$fecha')");
       return true; 
   }
if(isset($_POST["edit_quotation"]) && !empty($_POST["edit_quotation"])){

    $id=$_POST['jobId'];
    $agent_name= $_POST['agent_name'];
    $agent_email= $_POST['agent_email'];
    $initial_date= $_POST['initial_date'];
    $expiration_date= $_POST['expiration_date'];
    $service= $_POST['service'];
    $remarks= $_POST['remarks'];
    $dt = new DateTime($initial_date);
    $initial_date = $dt->format('Y-m-d');
    $dt2 = new DateTime($expiration_date);
    $expiration_date = $dt2->format('Y-m-d');
    if(isset($_POST['containerQuantity']) && !empty($_POST['containerQuantity'])){
        $containerQuantity= $_POST['containerQuantity'];
    }else{
        $containerQuantity=1;
    }

    $queryModel = mysqli_query($connect, "UPDATE quotations SET agent_name = '".$agent_name."', 
                                                                initial_date = '".$initial_date."', 
                                                                expiration_date = '".$expiration_date."', 
                                                                service = '".$service."', 
                                                                containerQuantity = '".$containerQuantity."', 
                                                                remarks = '".$remarks."', 
                                                                agent_email = '".$agent_email."'  
                                                                WHERE id='".$id."'");

    if(isset($_POST['byVolume_qty']) && !empty($_POST['byVolume_qty'])){
        $queryModel = mysqli_query($connect, "DELETE FROM quotationcontents WHERE quotationID='$id' and type='By Volume'");    
        $byVolume_qty= $_POST['byVolume_qty'];
		$byVolume_volume= $_POST['byVolume_volume'];
		$byVolume_weight= $_POST['byVolume_weight'];
        $queryQuotationByVolume = mysqli_query($connect, "INSERT INTO quotationcontents(quotationID, byVolume_qty, byVolume_volume, byVolume_weight, type) 
        VALUES ('$id', '$byVolume_qty', '$byVolume_volume', '$byVolume_weight', 'By Volume' )");
            
    }
    if(isset($_POST['byBoxes_qtyX']) && !empty($_POST['byBoxes_qtyX'])){
        $queryModel = mysqli_query($connect, "DELETE FROM quotationcontents WHERE quotationID='$id' and type=''");  
        foreach($_POST['byBoxes_qtyX'] as $key=>$item){
            if($_POST['byBoxes_qtyX'][$key]){
                $queryQuotationContents = mysqli_query($connect, "INSERT INTO quotationcontents(quotationID, byBoxes_qty, byBoxes_width, byBoxes_lenght, byBoxes_height, byBoxes_weight) 
                VALUES ('$id', '".$_POST['byBoxes_qtyX'][$key]."', '".$_POST['byBoxes_widthX'][$key]."', '".$_POST['byBoxes_lenghtX'][$key]."', '".$_POST['byBoxes_heightX'][$key]."', '".$_POST['byBoxes_weightX'][$key]."' )");
 
            }
        }
    }
    $queryModel = mysqli_query($connect, "DELETE FROM quotationcharges WHERE quotationID='$id'");
    if(isset($_POST['freightid']) && !empty($_POST['freightid'])){
        
        foreach($_POST['freightid'] as $key=>$item){
            if($_POST['freightChargeX'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID,  charge, quantity, description, type) 
                VALUES ('$id', '".$_POST['freightChargeX'][$key]."', '".$_POST['freightChargeQX'][$key]."', '".$_POST['freightDescX'][$key]."', 'Freight Charges' )");
            }
        }
    }
    if(isset($_POST['originid']) && !empty($_POST['originid'])){        
        foreach($_POST['originid'] as $key=>$item){
            if($_POST['originChargeX'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID,  charge, quantity, description, type) 
                VALUES ('$id', '".$_POST['originChargeX'][$key]."', '".$_POST['originChargeQX'][$key]."', '".$_POST['originDescX'][$key]."', 'Origin Charges' )");
            }
        }
    }
    if(isset($_POST['destinationid']) && !empty($_POST['destinationid'])){        
        foreach($_POST['destinationid'] as $key=>$item){
            if($_POST['destinationChargeX'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID,  charge, quantity, description, type) 
                VALUES ('$id', '".$_POST['destinationChargeX'][$key]."', '".$_POST['destinationChargeQX'][$key]."', '".$_POST['destinationDescX'][$key]."', 'Destination Charges' )");
            }
        }
    }   
   echo true;
   }

if(isset($_POST["quotation_delete"]) && !empty($_POST["quotation_delete"])){
    $id= $_POST['jobId'];
    $resultado = mysqli_query($connect, "DELETE FROM quotations WHERE id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM quotationcharges WHERE quotationID='$id'")   or die ("Error al insertar los registros");
    $resultado3 = mysqli_query($connect, "DELETE FROM quotationcontents WHERE quotationID='$id'")   or die ("Error al insertar los registros");
    return true;
    
}

if(isset($_POST["question_Update"]) && !empty($_POST["question_Update"])){

    if(!empty($_POST["jobCheck"])){
            foreach($_POST["jobCheck"] as $jobCheck)
            {
                $fecha = date('Y-m-d H:i:s');
                $statusUpdate = $_POST["statusUpdate"];
                $queryModel = mysqli_query($connect, "UPDATE joborders SET status='$statusUpdate' WHERE id='$jobCheck' ") or die ('error');
                $queryModel = mysqli_query($connect, "INSERT INTO notes(agent_name, jobOrderId, note, fecha) VALUES ('$agent_name', '$jobCheck', 'Updated to:  $statusUpdate.', '$fecha')");
            }
        }
    return true;

}
if(isset($_POST["update_profile"]) && !empty($_POST["update_profile"])){
    $email=$_POST["email"];
    $picture='';
    if($_POST["user_logo"]){
        $picture = $_POST["user_logo"];
    }else{
        $ruta="images/";//ruta carpeta donde queremos copiar las imágenes 
    
        $uploadfile_temporal1=$_FILES['avatar']['tmp_name'];
        $extension1 = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);    
       
        $picture=$ruta.time().'.'.$extension1;        
    
        if (is_uploaded_file($uploadfile_temporal1)) 
        { 
            move_uploaded_file($uploadfile_temporal1,$picture); 
        } 
    }
    $queryModel = mysqli_query($connect, "UPDATE agents SET picture='$picture' WHERE email='$email' ")
     or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ./myAccount.php?message=ErrorSaving\">");

    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ./myAccount.php?message=updateProfile\">";
    
    return true;

}
if(isset($_POST["create_user"]) && !empty($_POST["create_user"])){
    $email=$_POST["email"];
    $username=$_POST["username"];
    $phone=$_POST["phone"];
    $password=$_POST["password"];
    $level=$_POST["level"];
    $fecha=date('Y-m-d H:i:s');
    $mail_password=$password;
	
    $password = trim($password);
    
	$result = mysqli_query($connect, "SELECT * FROM users where username='$email'") ;
	if(mysqli_num_rows($result) == 1){
		$data['status']=false;
		$data['message']= "This username is already taken.";
		echo json_encode($data);
	} else{
		$sql = "INSERT INTO users (username, password, created_at) VALUES (?, ?, ?)";
		if($stmt = mysqli_prepare($connect, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "sss", $email, $password, $fecha);		
			$password = password_hash($password, PASSWORD_DEFAULT);
           
            
			if(mysqli_stmt_execute($stmt)){
			// 	$to = $email;
			// 	$subject = "New User";
			// 	$txt = "Your password id".$mail_password;
			// 	$headers = "From: no-reply@latimcargo.com";			
			// 	mail($to,$subject,$txt,$headers);
            }
            
            $picture='';
            if($_POST["user_logo"]){
                $picture = $_POST["user_logo"];
            }else{
                $ruta="images/";//ruta carpeta donde queremos copiar las imágenes 
            
                $uploadfile_temporal1=$_FILES['avatar']['tmp_name'];
                $extension1 = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);    
               
                $picture=$ruta.time().'.'.$extension1;        
            
                if (is_uploaded_file($uploadfile_temporal1)) 
                { 
                    move_uploaded_file($uploadfile_temporal1,$picture); 
                } 
            }
            
			$queryModel = mysqli_query($connect, "INSERT INTO agents(name, phone, email, picture, level) VALUES ('$username','$phone', '$email', '".$picture."', '".$level."')") or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ./createUsers.php\">");
	
            $data['status']=true;
            $data['message']='New User created successful';
            $data['password']=$mail_password;
            echo json_encode($data);
		}
	}
}
if(isset($_POST["update_user_no_password"]) && !empty($_POST["update_user_no_password"])){
    $email=$_POST["email"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $level=$_POST["level"];
    $picture='';
    if($_POST["user_logo"]){
        $picture = $_POST["user_logo"];
    }else{
        $ruta="images/";//ruta carpeta donde queremos copiar las imágenes 
    
        $uploadfile_temporal1=$_FILES['avatar']['tmp_name'];
        $extension1 = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);    
       
        $picture=$ruta.time().'.'.$extension1;        
    
        if (is_uploaded_file($uploadfile_temporal1)) 
        { 
            move_uploaded_file($uploadfile_temporal1,$picture); 
        } 
    }
   
    $queryModel = mysqli_query($connect, "UPDATE agents SET  picture='$picture', name='$username', phone='$phone',  level='$level' WHERE email='$email' ");
    $data['status']=true;
    $data['message']='User Updated successful';
    
    echo json_encode($data);

}
if(isset($_POST["update_user"]) && !empty($_POST["update_user"])){
    $email=$_POST["email"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $level=$_POST["level"];
    $password=$_POST["password"];
    $mail_password=$password;	
    $password = trim($password);
        $sql = "UPDATE users SET password = ? WHERE username = ?";
		if($stmt = mysqli_prepare($connect, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ss", $password, $email);		
			$password = password_hash($password, PASSWORD_DEFAULT);
           
            
			if(mysqli_stmt_execute($stmt)){
			// 	$to = $email;
			// 	$subject = "New User";
			// 	$txt = "Your password id".$mail_password;
			// 	$headers = "From: no-reply@latimcargo.com";			
			// 	mail($to,$subject,$txt,$headers);
            }
            
            $picture='';
            if($_POST["user_logo"]){
                $picture = $_POST["user_logo"];
            }else{
                $ruta="images/";//ruta carpeta donde queremos copiar las imágenes 
            
                $uploadfile_temporal1=$_FILES['avatar']['tmp_name'];
                $extension1 = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);    
            
                $picture=$ruta.time().'.'.$extension1;        
            
                if (is_uploaded_file($uploadfile_temporal1)) 
                { 
                    move_uploaded_file($uploadfile_temporal1,$picture); 
                } 
            }
            $queryModel = mysqli_query($connect, "UPDATE agents SET  picture='$picture', name='$username', phone='$phone',  level='$level' WHERE email='$email' ");
            $data['status']=true;
            $data['password']=$mail_password;
            $data['message']='User Updated successful';
            
            echo json_encode($data);
        }
   
    

}
if(isset($_POST["joborder_fileupload"]) && !empty($_POST["joborder_fileupload"])){
    $joborder_id=$_POST["joborder_fileupload_id"];
    $consulta2 = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$joborder_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $file_item=$colrow['atteched_files'];
    }
    $file_arr=json_decode($file_item);
    if($file_arr==Null){
       $arr='[]';
       $new_arr=json_decode($arr);
    }else{
        $new_arr=$file_arr;
    }
    $ruta="./images/joborder/";
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
        $queryModel = mysqli_query($connect, "INSERT INTO joborder_atteched(agent_name, joborder_id, notes, fecha, file_name) VALUES ('$agent_name', '$joborder_id', 'File Add:  $file.', '$fecha','$file')");
        array_push($new_arr,$uploadfile_nombre1);   
        array_push($uploadfile,$uploadfile_nombre1);            
    } 
    $new_arr=json_encode($new_arr);
    $queryModel = mysqli_query($connect, "UPDATE joborders SET atteched_files='$new_arr' WHERE id='$joborder_id' ") or die ('error');
    $new_arr=json_decode($new_arr);
    $html='';  
    $consulta3 = mysqli_query($connect, "SELECT * FROM joborder_atteched WHERE id='$joborder_id' ORDER BY id desc ") or die ("Error al traer los datos222");
    while ($colhtml = mysqli_fetch_array($consulta3)){     
        $html.='<tr>';
        $html.='<td class="text-left"><a href="./images/joborder/'.$colhtml['file_name'].'" class="file_download" target="blank" >'.$colhtml['file_name'].'</a></td>';
        $html.='<td class="text-center">'.date_format(date_create($colhtml['fecha']),'m/d/Y H:i:s').'</td>';
        $html.='<td class="text-center">'.$colhtml['agent_name'].'</td>';
        $html.='<td class="text-center">'.$colhtml['notes'].'</td>';
        $html.='</tr>';
    }
    echo $html;
}
if(isset($_GET["orders_files_delete"]) && !empty($_GET["orders_files_delete"])){
    $id=$_GET["id"];
    $joborder_id=$_GET["joborders_id"];
    $consulta2 = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$joborder_id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($colrow = mysqli_fetch_array($consulta2)){  
        $file_item=$colrow['atteched_files'];
    }
    $consulta3 = mysqli_query($connect, "SELECT * FROM joborder_atteched WHERE id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
    while ($row = mysqli_fetch_array($consulta3)){  
        $file_name=$row['file_name'];
    }
    $file_name='../images/joborder/'.$file_name;

    $file_arr=json_decode($file_item);
    $new_arr=[];
    foreach($file_arr as $key=>$item){
        if($item!=$file_name){
           array_push($new_arr,$item); 
        }
    }
    $new_arr=json_encode($new_arr);
    $queryModel = mysqli_query($connect, "UPDATE joborders SET atteched_files='$new_arr' WHERE id='$joborder_id'");
    $queryModel = mysqli_query($connect, "DELETE FROM joborder_atteched WHERE id='$id'");
    $file_name=str_replace('../','./', $file_name);
    unlink($file_name);
    echo true;
}