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
if(isset($_POST["getinvoice"]) && !empty($_POST["getinvoice"])){  
    $id=$_POST['id'];
    $post = array();
    $consulta = mysqli_query($connect, "SELECT a.*, b.name as account_name FROM invoices a left join accounts b on a.account=b.id where a.account='$id' and a.total_invoiced>a.paid order by id ")
    or die ("Error al traer los Agent");
    while ($rowgl = mysqli_fetch_array($consulta)){
        $post[] = $rowgl;    
    } 
    $consulta = mysqli_query($connect, "SELECT * from accounts where id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consulta)){
        $name = $row['name'];    
    } 
    $data['post']=$post;
    $data['account_name']=$name;
    echo json_encode($data);
}   
if(isset($_POST["createpayment"]) && !empty($_POST["createpayment"])){ 
    $date= $_POST['date'];
    $type= $_POST['type'];
    $branch= $_POST['branch'];
    $account= $_POST['account'];
    $currency= $_POST['currency'];
    $number= $_POST['number'];
    $date_on_check= $_POST['date_on_check'];
    $amount= $_POST['amount']; 
    $exchange= $_POST['exchange'];     
    $reference= $_POST['reference'];
    $comments= $_POST['comments'];
    $general_ledger= $_POST['general_ledger'];
    $queryModel = mysqli_query($connect, "INSERT INTO invoicepayments(date, type, branch, account, currency, number, date_on_check, amount, exchange, reference, comments, general_ledger) 
    VALUES ('$date', '$type', '$branch', '$account',  '$currency','$number', '$date_on_check', '$amount', '$exchange', '$reference', '$comments', '$general_ledger')");
    $invoice_payment_id = mysqli_insert_id($connect); 
    $fecha=date('Y-m-d H:i:s');
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){                
                $queryModel = mysqli_query($connect, "INSERT INTO invoicepayments_files(invoice_payment_id, file_name, fecha) 
                VALUES ('$invoice_payment_id', '".$_POST['td_filename'][$key]."', '".$fecha."' )");
        }  
    }
    if(isset($_POST['td_invoice_id']) && !empty($_POST['td_invoice_id'])){        
        foreach($_POST['td_invoice_id'] as $key=>$item){
            if($_POST['td_invoice_id'][$key]){    
                $invoice_id= $_POST['td_invoice_id'][$key];
                $consulta = mysqli_query($connect, "SELECT * FROM invoices where id='$invoice_id' order by id ")
                or die ("Error al traer los Agent");
                while ($row = mysqli_fetch_array($consulta)){                    
                    $queryModel = mysqli_query($connect, "INSERT INTO invoicepayments_contents(invoice_payment_id,  invoice_id, account, currency, amount, paid, fecha) 
                    VALUES ('$invoice_payment_id', '".$invoice_id."', '".$row['account']."',  '".$row['currency']."', '".$row['total_invoiced']."', '".$_POST['td_paid'][$key]."','".$fecha."' )");
                }
            $queryModel = mysqli_query($connect, "UPDATE invoices SET paid= paid+'".$_POST['td_paid'][$key]."' WHERE id='$invoice_id' ") or die ('error');

        }
     }
    } 
    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ./createInvoicePayment.php\">";
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
if(isset($_POST["getfiles"]) && !empty($_POST["getfiles"])){
    $id=$_POST['id'];
    $html="";
    $consulta = mysqli_query($connect, "SELECT * FROM invoicepayments_files where invoice_payment_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consulta)){  
       $html.="<tr>";
       $html.="<td class='text-left'><a href='./images/bills/".$row['file_name']."' target='blank'>".$row['file_name']."</a></td>";
       $html.="<td class='text-left'>".$row['fecha']."</td>";
       $html.="</tr>";
    }
    echo $html;
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
if(isset($_POST["deletepayment"]) && !empty($_POST["deletepayment"])){
    $id= $_POST['id'];
    $consulta = mysqli_query($connect, "SELECT * FROM invoicepayments_contents where invoice_payment_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consulta)){  
        $invoice_id=$row['invoice_id'];
        $paid=$row['paid'];
        $queryModel = mysqli_query($connect, "UPDATE invoices SET paid= paid-'$paid' WHERE id='$invoice_id' ") or die ('error'); 
    }
    $consultafile = mysqli_query($connect, "SELECT * FROM invoicepayments_files where invoice_payment_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consultafile)){  
        $name=$row['file_name'];
        $ruta="./images/bills/";
        $uploadfile_nombre=$ruta.$name; 
        unlink($uploadfile_nombre);
    }
    $resultado = mysqli_query($connect, "DELETE FROM invoicepayments WHERE id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM invoicepayments_contents WHERE invoice_payment_id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM invoicepayments_files WHERE invoice_payment_id='$id'")   or die ("Error al insertar los registros");
    return true;    
}