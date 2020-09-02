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
if(isset($_POST["getbill"]) && !empty($_POST["getbill"])){  
    $id=$_POST['id'];
    $post = array();
    $consulta = mysqli_query($connect, "SELECT a.*, b.name as account_name FROM bills a left join accounts b on a.account=b.id where a.account='$id' and a.amount>a.paid order by id ")
    or die ("Error al traer los Agent");
    while ($rowgl = mysqli_fetch_array($consulta)){
        $post[] = $rowgl;    
    } 
    echo json_encode($post);
}   
if(isset($_POST["createpayment"]) && !empty($_POST["createpayment"])){ 
    $date= $_POST['date'];
    $checkbooks= $_POST['checkbooks'];
    $type= $_POST['type'];
    $check_number= $_POST['check_number'];
    $account= $_POST['account'];
    $print= $_POST['print'];
    $amount= $_POST['amount'];  
    $meno= $_POST['meno'];
    $exchange= $_POST['exchange'];
    
    $queryModel = mysqli_query($connect, "INSERT INTO payments(date, checkbooks, type, check_number, account, print, amount, meno, exchange) 
    VALUES ('$date', '$checkbooks', '$type', '$check_number', '$account', '$print', '$amount', '$meno', '$exchange')");
    $payment_id = mysqli_insert_id($connect); 

    $fecha=date('Y-m-d H:i:s');
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){                
                $queryModel = mysqli_query($connect, "INSERT INTO payments_files(payment_id, file_name, fecha) 
                VALUES ('$payment_id', '".$_POST['td_filename'][$key]."', '".$fecha."' )");
        }  
    }
    if(isset($_POST['td_bill_id']) && !empty($_POST['td_bill_id'])){        
        foreach($_POST['td_bill_id'] as $key=>$item){
            if($_POST['td_bill_id'][$key]){    
                $bill_id= $_POST['td_bill_id'][$key];
                $consulta = mysqli_query($connect, "SELECT * FROM bills where id='$bill_id' order by id ")
                or die ("Error al traer los Agent");
                while ($row = mysqli_fetch_array($consulta)){                    
                    $queryModel = mysqli_query($connect, "INSERT INTO payments_contents(payment_id,  bill_id, inv, account, currency, amount, paid, fecha) 
                    VALUES ('$payment_id', '".$bill_id."', '".$row['inv']."', '".$row['account']."',  '".$row['currency']."', '".$row['amount']."', '".$_POST['td_paid'][$key]."','".$fecha."' )");
                }
            $queryModel = mysqli_query($connect, "UPDATE bills SET paid= paid+'".$_POST['td_paid'][$key]."' WHERE id='$bill_id' ") or die ('error');

        }
     }
    } 
    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ./createPayment.php\">";
}
if(isset($_POST["editpayment"]) && !empty($_POST["editpayment"])){    
    $id=$_POST['id'];
    $date= $_POST['date'];
    $checkbooks= $_POST['checkbooks'];
    $type= $_POST['type'];
    $check_number= $_POST['check_number'];
    $account= $_POST['account'];
    $print= $_POST['print'];
    $amount= $_POST['amount'];  
    $meno= $_POST['meno'];
    $exchange= $_POST['exchange'];
    
    $queryModel = mysqli_query($connect, "UPDATE payments SET 
        date = '".$date."', 
        checkbooks = '".$checkbooks."', 
        type = '".$type."', 
        check_number = '".$check_number."', 
        account = '".$account."', 
        print = '".$print."', 
        amount = '".$amount."', 
        meno = '".$meno."', 
        exchange = '".$exchange."' 
       WHERE id='".$id."'");
    $payment_id = $id; 
    $fecha=date('Y-m-d H:i:s');
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){
            if(!$_POST['td_fileid'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO payments_files(payment_id, file_name, fecha) 
                VALUES ('$payment_id', '".$_POST['td_filename'][$key]."', '".$fecha."' )");
            }   
        }  
    }
    if(isset($_POST['td_bill_id']) && !empty($_POST['td_bill_id'])){        
        foreach($_POST['td_bill_id'] as $key=>$item){
            if(!$_POST['td_payment_id'][$key]){ 
                $bill_id= $_POST['td_bill_id'][$key];            
                $consulta = mysqli_query($connect, "SELECT * FROM bills where id='$bill_id' order by id ")
                or die ("Error al traer los Agent");
                while ($row = mysqli_fetch_array($consulta)){                    
                    $queryModel = mysqli_query($connect, "INSERT INTO payments_contents(payment_id,  bill_id, inv, account, currency, amount, paid, fecha) 
                    VALUES ('$payment_id', '".$bill_id."', '".$row['inv']."', '".$row['account']."',  '".$row['currency']."', '".$row['amount']."', '".$_POST['td_paid'][$key]."','".$fecha."' )");
                }
            $queryModel = mysqli_query($connect, "UPDATE bills SET paid= paid+'".$_POST['td_paid'][$key]."' WHERE id='$bill_id' ") or die ('error');
        }
     }
    } 
    echo true;
}
if(isset($_POST["deletepayment_item"]) && !empty($_POST["deletepayment_item"])){
    $payment_id=$_POST['payment_id'];
    $bill_id=$_POST['bill_id'];
    $paid=$_POST['paid'];
    $consulta = mysqli_query($connect, "SELECT * FROM payments_contents WHERE id='$payment_id'")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consulta)){                    
       $payment=$row['payment_id'];
    }
    $queryModel = mysqli_query($connect, "UPDATE payments SET amount= amount-'$paid' WHERE id='$payment' ") or die ('error');
    $resultado = mysqli_query($connect, "DELETE FROM payments_contents WHERE id='$payment_id'")   or die ("Error al insertar los registros");
    $queryModel = mysqli_query($connect, "UPDATE bills SET paid= paid-'$paid' WHERE id='$bill_id' ") or die ('error');
    echo true;
}
if(isset($_POST["payment_fileupload"]) && !empty($_POST["payment_fileupload"])){
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
        $queryModel = mysqli_query($connect, "DELETE FROM payments_files WHERE id='$id'"); 
    }
    $ruta="./images/bills/";
    $name=$_POST['name'];
    $uploadfile_nombre=$ruta.$name; 
    unlink($uploadfile_nombre);
    echo true;
}
if(isset($_POST["delete_payment"]) && !empty($_POST["delete_payment"])){
    $id= $_POST['payment_id'];
    $consulta = mysqli_query($connect, "SELECT * FROM payments_contents where payment_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consulta)){  
        $bill_id=$row['bill_id'];
        $paid=$row['paid'];
        $queryModel = mysqli_query($connect, "UPDATE bills SET paid= paid-'$paid' WHERE id='$bill_id' ") or die ('error'); 
    }
    $consultafile = mysqli_query($connect, "SELECT * FROM payments_files where payment_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consultafile)){  
        $name=$row['file_name'];
        $ruta="./images/bills/";
        $uploadfile_nombre=$ruta.$name; 
        unlink($uploadfile_nombre);
    }
    $resultado = mysqli_query($connect, "DELETE FROM payments WHERE id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM payments_contents WHERE payment_id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM payments_files WHERE payment_id='$id'")   or die ("Error al insertar los registros");
    return true;    
}