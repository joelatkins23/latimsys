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
if(isset($_POST["createbill"]) && !empty($_POST["createbill"])){ 
    $currency= $_POST['currency'];
    $date= $_POST['date'];
    $branch= $_POST['branch'];
    $account= $_POST['account'];
    $inv= $_POST['inv'];
    $description= $_POST['description'];
    $due_date= $_POST['due_date'];
    $amount= $_POST['amount'];
    $paid= 0;
    $exchange= $_POST['exchange'];
    $cost_center= $_POST['cost_center'];
    $warehouse= $_POST['warehouse'];
    $file= $_POST['file'];
    $house= $_POST['house'];   
    if(isset($_POST['payroll'])){
        $payroll=1;
    }else{
        $payroll=0;
    }
    
    $queryModel = mysqli_query($connect, "INSERT INTO bills(currency, date, branch, account, inv, description, due_date, amount, paid, exchange, cost_center, warehouse, file, house, payroll) 
    VALUES ('$currency', '$date', '$branch', '$account', '$inv', '$description', '$due_date', '$amount', '$paid', '$exchange', '$cost_center', '$warehouse', '$file', '$house', '$payroll')");
    $bill_id = mysqli_insert_id($connect); 

    $fecha=date('Y-m-d H:i:s');
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){
                
                $queryModel = mysqli_query($connect, "INSERT INTO bills_files(bill_id, file_name, fecha) 
                VALUES ('$bill_id', '".$_POST['td_filename'][$key]."', '".$fecha."' )");
        }  
    }
    if(isset($_POST['td_date']) && !empty($_POST['td_date'])){        
        foreach($_POST['td_date'] as $key=>$item){
            if($_POST['td_date'][$key]){             
                $queryModel = mysqli_query($connect, "INSERT INTO bills_contents(bill_id,  date, file, house, wh, account, description, amount, iva, fecha) 
                VALUES ('$bill_id', '".$_POST['td_date'][$key]."', '".$_POST['td_file'][$key]."', '".$_POST['td_house'][$key]."',  '".$_POST['td_wh'][$key]."', '".$_POST['td_account'][$key]."','".$_POST['td_desc'][$key]."','".$_POST['td_amount'][$key]."','".$_POST['td_iva'][$key]."','".$fecha."' )");
        }
     }
    } 
    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ./createBill.php\">";
}
if(isset($_POST["editbill"]) && !empty($_POST["editbill"])){    
    $id=$_POST['id'];
    $currency= $_POST['currency'];
    $date= $_POST['date'];
    $branch= $_POST['branch'];
    $account= $_POST['account'];
    $inv= $_POST['inv'];
    $description= $_POST['description'];
    $due_date= $_POST['due_date'];
    $amount= $_POST['amount'];
    $paid= $_POST['paid'];
    $exchange= $_POST['exchange'];
    $cost_center= $_POST['cost_center'];
    $warehouse= $_POST['warehouse'];
    $file= $_POST['file'];
    $house= $_POST['house'];   
    if(isset($_POST['payroll'])){
        $payroll=1;
    }else{
        $payroll=0;
    }
    
    $queryModel = mysqli_query($connect, "UPDATE bills SET 
        currency = '".$currency."', 
        date = '".$date."', 
        account = '".$account."', 
        inv = '".$inv."', 
        description = '".$description."', 
        due_date = '".$due_date."', 
        amount = '".$amount."', 
        paid = '".$paid."', 
        exchange = '".$exchange."', 
        cost_center = '".$cost_center."', 
        warehouse = '".$warehouse."', 
        file = '".$file."', 
        house = '".$house."', 
        payroll = '".$payroll."'
       WHERE id='".$id."'");
    $bill_id = $id; 
    $fecha=date('Y-m-d H:i:s');
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){
            if(!$_POST['td_fileid'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO bills_files(bill_id, file_name, fecha) 
                VALUES ('$bill_id', '".$_POST['td_filename'][$key]."', '".$fecha."' )");
            }                
                
        }  
    }
    $queryModel = mysqli_query($connect, "DELETE FROM bills_contents WHERE bill_id='$id'");
    if(isset($_POST['td_date']) && !empty($_POST['td_date'])){        
        foreach($_POST['td_date'] as $key=>$item){
            if($_POST['td_date'][$key]){
             
                $queryModel = mysqli_query($connect, "INSERT INTO bills_contents(bill_id,  date, file, house, wh, account, description, amount, iva, fecha) 
                VALUES ('$bill_id', '".$_POST['td_date'][$key]."', '".$_POST['td_file'][$key]."', '".$_POST['td_house'][$key]."',  '".$_POST['td_wh'][$key]."', '".$_POST['td_account'][$key]."','".$_POST['td_desc'][$key]."','".$_POST['td_amount'][$key]."','".$_POST['td_iva'][$key]."','".$fecha."' )");
        }
     }
    } 
    echo true;
}
if(isset($_POST["delete_bill"]) && !empty($_POST["delete_bill"])){
    $id= $_POST['bill_id'];
    $consultafile = mysqli_query($connect, "SELECT * FROM bills_files where bill_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consultafile)){  
        $name=$row['file_name'];
        $ruta="./images/bills/";
        $uploadfile_nombre=$ruta.$name; 
        unlink($uploadfile_nombre);
    }
    $resultado = mysqli_query($connect, "DELETE FROM bills WHERE id='$id'")   or die ("Error al insertar los registros");
    $resultado = mysqli_query($connect, "DELETE FROM bills_files WHERE bill_id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM bills_contents WHERE bill_id='$id'")   or die ("Error al insertar los registros");
    return true;    
}
if(isset($_POST["bill_fileupload"]) && !empty($_POST["bill_fileupload"])){
    $ruta="./images/bills/";
    $new_arr=[];
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
        
        $name=explode('/', $uploadfile_nombre1);
        $file['name']=end($name);

        array_push($new_arr,$file);   
    }   
    echo json_encode($new_arr);
}
if(isset($_POST["deletefile"]) && !empty($_POST["deletefile"])){
    $ruta="./images/bills/";
    $name=$_POST['name'];
    $uploadfile_nombre=$ruta.$name; 
    unlink($uploadfile_nombre);
    echo true;
}
if(isset($_POST["deleteupdatefile"]) && !empty($_POST["deleteupdatefile"])){
    $id=$_POST['id'];
    if($_POST['id']){        
        $queryModel = mysqli_query($connect, "DELETE FROM bills_files WHERE id='$id'"); 
    }
    $ruta="./images/bills/";
    $name=$_POST['name'];
    $uploadfile_nombre=$ruta.$name; 
    unlink($uploadfile_nombre);
    echo true;
      
}