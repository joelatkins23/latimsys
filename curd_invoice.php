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
if(isset($_POST["createinvoice"]) && !empty($_POST["createinvoice"])){ 
  
    $branch= $_POST['branch'];
    $date= $_POST['date'];
    $account= $_POST['account'];
    $currency= $_POST['currency'];
    $total_invoiced= $_POST['total_invoiced'];
    $total_paid= $_POST['total_paid'];
    $cost_center= $_POST['cost_center'];
    $shipper= $_POST['shipper'];
    $consignee_id= $_POST['consignee_id'];
    $carrier= $_POST['carrier'];
    $entry= $_POST['entry'];
    $etd= $_POST['etd'];
    $eta= $_POST['eta'];
    $incoterm= $_POST['incoterm'];
    $exchange= $_POST['exchange'];
    $warehouse= json_encode($_POST['warehouse']);
    $purchase= $_POST['purchase'];
    $house= $_POST['house'];
    $file_val1= $_POST['file_val1'];
    $file_val2= $_POST['file_val2'];
    $pieces= $_POST['pieces'];
    $weight= $_POST['weight'];
    $volume= $_POST['volume'];
    $weight_c= $_POST['weight_c'];
    $origin= $_POST['origin'];
    $dest= $_POST['dest'];
    $po= $_POST['po'];
    $reference= $_POST['reference'];
    $bank_information= (isset($_POST['bank_information']) && !empty($_POST['bank_information'])) ? $_POST['bank_information'] : 0;
    $print_including_backup= (isset($_POST['print_including_backup']) && !empty($_POST['print_including_backup'])) ? $_POST['print_including_backup'] : 0;
    $print_grouped_by_concepts= (isset($_POST['print_grouped_by_concepts']) && !empty($_POST['print_grouped_by_concepts'])) ? $_POST['print_grouped_by_concepts'] : 0;
    $print_exchange= (isset($_POST['print_exchange']) && !empty($_POST['print_exchange'])) ? $_POST['print_exchange'] : 0;
    $invoice_status= $_POST['invoice_status'];
    $fecha= date("Y-m-d H:i:s");
    $queryModel = mysqli_query($connect, "INSERT INTO invoices(branch, date, account, currency, total_invoiced, total_paid, cost_center, shipper, consignee_id, carrier, entry, etd, eta, incoterm, exchange, warehouse, purchase, house, file_val1, file_val2, pieces, weight, volume, weight_c, origin, dest, po, reference, bank_information, print_including_backup, print_grouped_by_concepts, print_exchange, invoice_status, fecha) VALUES ('$branch', '$date', '$account', '$currency', '$total_invoiced', '$total_paid', '$cost_center', '$shipper', '$consignee_id', '$carrier', '$entry', '$etd', '$eta', '$incoterm', '$exchange', '$warehouse', '$purchase', '$house', '$file_val1', '$file_val2', '$pieces', '$weight', '$volume', '$weight_c', '$origin', '$dest', '$po', '$reference', '$bank_information', '$print_including_backup', '$print_grouped_by_concepts', '$print_exchange', '$invoice_status', '$fecha')");
    $invoice_id = mysqli_insert_id($connect); 
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){
                
                $queryModel = mysqli_query($connect, "INSERT INTO invoices_files(invoice_id, file_name, agent_name, fecha) 
                VALUES ('$invoice_id', '".$_POST['td_filename'][$key]."', '".$_POST['td_agent_name'][$key]."', '$fecha' )");
        }  
    }
    if(isset($_POST['td_units']) && !empty($_POST['td_units'])){        
        foreach($_POST['td_units'] as $key=>$item){
            if($_POST['td_units'][$key]){      
                $tax=(isset($_POST['td_tax'][$key]) && !empty($_POST['td_tax'][$key])) ? $_POST['td_tax'][$key]:0;
       
                $queryModel = mysqli_query($connect, "INSERT INTO invoices_detail(invoice_id,  units, gl_account, cc, description, price, amount, tax,fecha) 
                VALUES ('$invoice_id', '".$_POST['td_units'][$key]."','".$_POST['td_account'][$key]."', '".$_POST['td_cc'][$key]."', '".$_POST['td_desc'][$key]."',  '".$_POST['td_price'][$key]."', '".$_POST['td_amount'][$key]."','$tax','".$fecha."' )");
        }
     }
    } 
    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ./createInvoice.php\">";
}
if(isset($_POST["getwh_info"]) && !empty($_POST["getwh_info"])){   
   
    
    $total_pieces=0;
    $total_weight=0;
    $total_volume=0;
    $total_charg_weight=0;
    if(isset($_POST['wh_arr']) && count($_POST['wh_arr'])>0){
        $wh_arr=$_POST['wh_arr'];
        $ids = join(",",$wh_arr);  
        $ids = '('.$ids.')';   
        $sql="SELECT  SUM(total_pieces)total_pieces,SUM(total_weight)total_weight, SUM(total_volume)total_volume, SUM(total_charg_weight)total_charg_weight from warehouse where id in $ids";
        $consulta = mysqli_query($connect,$sql) or die ("Error al traer los datos222");
        while ($row = mysqli_fetch_array($consulta)){  
            $total_pieces=$row['total_pieces'];
            $total_weight=$row['total_weight'];
            $total_volume=$row['total_volume'];
            $total_charg_weight=$row['total_charg_weight'];
        }
    }
    
    $data['total_pieces']=$total_pieces;
    $data['total_weight']=$total_weight;
    $data['total_volume']=$total_volume;
    $data['total_charg_weight']=$total_charg_weight;
    echo json_encode($data);
}   

if(isset($_POST["editinvoice"]) && !empty($_POST["editinvoice"])){    
    $id= $_POST['id'];
    $branch= $_POST['branch'];
    $date= $_POST['date'];
    $account= $_POST['account'];
    $currency= $_POST['currency'];
    $total_invoiced= $_POST['total_invoiced'];
    $total_paid= $_POST['total_paid'];
    $cost_center= $_POST['cost_center'];
    $shipper= $_POST['shipper'];
    $consignee_id= $_POST['consignee_id'];
    $carrier= $_POST['carrier'];
    $entry= $_POST['entry'];
    $etd= $_POST['etd'];
    $eta= $_POST['eta'];
    $incoterm= $_POST['incoterm'];
    $exchange= $_POST['exchange'];
    $warehouse= json_encode($_POST['warehouse']);
    $purchase= $_POST['purchase'];
    $house= $_POST['house'];
    $file_val1= $_POST['file_val1'];
    $file_val2= $_POST['file_val2'];
    $pieces= $_POST['pieces'];
    $weight= $_POST['weight'];
    $volume= $_POST['volume'];
    $weight_c= $_POST['weight_c'];
    $origin= $_POST['origin'];
    $dest= $_POST['dest'];
    $po= $_POST['po'];
    $reference= $_POST['reference'];
    $bank_information= (isset($_POST['bank_information']) && !empty($_POST['bank_information'])) ? $_POST['bank_information'] : 0;
    $print_including_backup= (isset($_POST['print_including_backup']) && !empty($_POST['print_including_backup'])) ? $_POST['print_including_backup'] : 0;
    $print_grouped_by_concepts= (isset($_POST['print_grouped_by_concepts']) && !empty($_POST['print_grouped_by_concepts'])) ? $_POST['print_grouped_by_concepts'] : 0;
    $print_exchange= (isset($_POST['print_exchange']) && !empty($_POST['print_exchange'])) ? $_POST['print_exchange'] : 0;
    $invoice_status= $_POST['invoice_status'];
    $notes= $_POST['notes'];
    $fecha= date("Y-m-d H:i:s");
    $queryModel = mysqli_query($connect, "UPDATE invoices SET 
        branch='$branch',
        date='$date',
        account='$account',
        currency='$currency',
        total_invoiced='$total_invoiced',
        total_paid='$total_paid',
        cost_center='$cost_center',
        shipper='$shipper',
        consignee_id='$consignee_id',
        carrier='$carrier',
        entry='$entry',
        etd='$etd',
        eta='$eta',
        incoterm='$incoterm',
        exchange='$exchange',
        warehouse='$warehouse',
        purchase='$purchase',
        house='$house',
        file_val1='$file_val1',
        file_val2='$file_val2',
        pieces='$pieces',
        weight='$weight',
        volume='$volume',
        weight_c='$weight_c',
        origin='$origin',
        dest='$dest',
        po='$po',
        reference='$reference',
        bank_information='$bank_information',
        print_including_backup='$print_including_backup',
        print_grouped_by_concepts='$print_grouped_by_concepts',
        print_exchange='$print_exchange',
        invoice_status='$invoice_status',
        fecha='$fecha'
       WHERE id='".$id."'");
    $invoice_id = $id; 
    if(isset($notes) && !empty($notes)){
        $queryModel = mysqli_query($connect, "INSERT INTO invoices_notes(invoice_id, notes, agent_name, fecha) 
        VALUES ('$invoice_id', '$notes', '".$agent_name."', '$fecha' )");
    }
    if(isset($_POST['td_filename'])){
        foreach($_POST['td_filename'] as $key=>$item){
            if(!$_POST['td_fileid'][$key]){
                $queryModel = mysqli_query($connect, "INSERT INTO invoices_files(invoice_id, file_name, agent_name, fecha) 
                VALUES ('$invoice_id', '".$_POST['td_filename'][$key]."', '".$_POST['td_agent_name'][$key]."', '$fecha' )");
            }                
                
        }  
    }
    $queryModel = mysqli_query($connect, "DELETE FROM invoices_detail WHERE invoice_id='$id'");
    if(isset($_POST['td_units']) && !empty($_POST['td_units'])){        
        foreach($_POST['td_units'] as $key=>$item){
            if($_POST['td_units'][$key]){
                $tax=(isset($_POST['td_tax'][$key]) && !empty($_POST['td_tax'][$key])) ? $_POST['td_tax'][$key]:0;
                $queryModel = mysqli_query($connect, "INSERT INTO invoices_detail(invoice_id,  units, gl_account, cc, description, price, amount, tax,fecha) 
                VALUES ('$invoice_id', '".$_POST['td_units'][$key]."','".$_POST['td_account'][$key]."', '".$_POST['td_cc'][$key]."', '".$_POST['td_desc'][$key]."',  '".$_POST['td_price'][$key]."', '".$_POST['td_amount'][$key]."','$tax','".$fecha."' )");
        }
     }
    } 
    echo true;
}
if(isset($_POST["delete_invoice"]) && !empty($_POST["delete_invoice"])){
    $id= $_POST['invoice_id'];
    $consultafile = mysqli_query($connect, "SELECT * FROM invoices_files where invoice_id='$id' order by id ")
    or die ("Error al traer los Agent");
    while ($row = mysqli_fetch_array($consultafile)){  
        $name=$row['file_name'];
        $ruta="./images/invoices/";
        $uploadfile_nombre=$ruta.$name; 
        unlink($uploadfile_nombre);
    }
    $resultado = mysqli_query($connect, "DELETE FROM invoices WHERE id='$id'")   or die ("Error al insertar los registros");
    $resultado = mysqli_query($connect, "DELETE FROM invoices_files WHERE invoice_id='$id'")   or die ("Error al insertar los registros");
    $resultado2 = mysqli_query($connect, "DELETE FROM invoices_detail WHERE invoice_id='$id'")   or die ("Error al insertar los registros");
    return true;    
}
if(isset($_POST["invoice_fileupload"]) && !empty($_POST["invoice_fileupload"])){
    $ruta="./images/invoices/";
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
        $file['agent_name']=$agent_name;
        $file['fecha']=date("Y-m-d H:i:s");
        array_push($new_arr,$file);   
    }   
    echo json_encode($new_arr);
}
if(isset($_POST["deletefile"]) && !empty($_POST["deletefile"])){
    $ruta="./images/invoices/";
    $name=$_POST['name'];
    $uploadfile_nombre=$ruta.$name; 
    unlink($uploadfile_nombre);
    echo true;
}
if(isset($_POST["get_notes"]) && !empty($_POST["get_notes"])){
    $id=$_POST['id'];
    $consultafile = mysqli_query($connect, "SELECT * FROM invoices_notes where invoice_id='$id' order by id desc")
    or die ("Error al traer los Agent");
    $data=array();
    while ($row = mysqli_fetch_array($consultafile)){  
       $item['date']=date_format(date_create($row['fecha']),'m/d/Y H:i:s');
       $item['agent_name']=$row['agent_name'];
       $item['notes']=$row['notes'];
       array_push($data,$item);
    }
   echo json_encode($data);
}
if(isset($_POST["deleteupdatefile"]) && !empty($_POST["deleteupdatefile"])){
    $id=$_POST['id'];
    if($_POST['id']){        
        $queryModel = mysqli_query($connect, "DELETE FROM invoices_files WHERE id='$id'"); 
    }
    $ruta="./images/invoices/";
    $name=$_POST['name'];
    $uploadfile_nombre=$ruta.$name; 
    unlink($uploadfile_nombre);
    echo true;
      
}