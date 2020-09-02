<?php 

  error_reporting(0);
  require_once('conn.php');

    $consulta_invoice = mysqli_query($connect, "SELECT * FROM joborders ORDER BY id DESC LIMIT 1");

     $num_rows_invoice = mysqli_num_rows($consulta_invoice);

      if($num_rows_invoice==0)
      {
        $invoice=1000;
        $mensaje='No existen invoices';
      }
      else
      {

        while ($extraido_email = mysqli_fetch_array($consulta_invoice)) {

              $invoice= $extraido_email['id'];
              
          }

        $invoice=$invoice+1;
      }
    


                        $client_id=$_POST['client_id'];
                        $supplier_id=$_POST['supplier_id'];

                        $cus_id=$_POST['cus_id'];
                        $supp_id=$_POST['supp_id'];

                        $customer_name=$_POST['customer_name'];
                        $customer_company=$_POST['customer_company'];
                        $customer_telf1=$_POST['customer_telf1'];
                        $customer_telf2=$_POST['customer_telf2'];
                        $customer_qq=$_POST['customer_qq'];
                        $customer_wechat=$_POST['customer_wechat'];

                        $branch='';
                       
                        $customer_email=$_POST['customer_email'];
                        $customer_address1=$_POST['customer_address1'];
                        $customer_address2=$_POST['customer_address2'];
                        $customer_city=$_POST['customer_city'];
                        $customer_state=$_POST['customer_state'];
                        $customer_country=$_POST['customer_country'];


                        
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

                        $agent_id=$_POST['agent_id'];
                        $agent_email=$_POST['agent_email'];
                        $service=$_POST['service'];
                        $commodity=$_POST['commodity'];
                        $wh_receipt=$_POST['wh_receipt'];
                        $remark=$_POST['remark'];
                        $payment=$_POST['payment']; 
                        $dt = new DateTime($fecha_segundos);
                        $segundos = $dt->format('H:i:s');
                        $fecha=$_POST['fecha'];
                        $hora=$_POST['hora'];
                        $fecha.= ' '.$hora;
                        $fecha=str_replace('/','-',$fecha);
                        $dt = new DateTime($fecha);
                        $fecha = $dt->format('Y-m-d H:i:s');

                        $status='PENDING';

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
                                        city='$customer_city',
                                        state='$customer_state',
                                        country='$customer_country',
                                        email='$customer_email'
                                        WHERE id='$cus_id' ");

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
                                        WHERE id='$supp_id' ");


                        $queryModel = mysqli_query($connect, "INSERT INTO joborders(id,  customer_city, service, value, commodity, wh_receipt, remark, payment, status, fecha, branch, client_id, supplier_id, agent_id) 

                                        VALUES ('$invoice', '$customer_city','$service','$value', '$commodity', '$wh_receipt', '$remark', '$payment', '$status', '$fecha', '$branch', '$cus_id', '$supp_id', '$agent_id')")
                        or die ("");

echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../createJobOrder.php?message=JobOrderSaved\">";


 ?>