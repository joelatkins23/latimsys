<?php
ob_start();
include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];

 $consulta_invoice = mysqli_query($connect, "SELECT * FROM joborders WHERE id='$id' ");


  while ($extraido_email = mysqli_fetch_array($consulta_invoice)) {

  

  
  $customer_name= $extraido_email['customer_name'];
  $customer_company= $extraido_email['customer_company'];
  $customer_telf= $extraido_email['customer_telf'];
  $customer_email= $extraido_email['customer_email'];
  $customer_address= $extraido_email['customer_address'];

  $supplier_name= $extraido_email['supplier_name'];
  $supplier_company= $extraido_email['supplier_company'];
  $supplier_telf= $extraido_email['supplier_telf'];
  $supplier_email= $extraido_email['supplier_email'];
  $supplier_address= $extraido_email['supplier_address'];

  $agent_name= $extraido_email['agent_name'];
  $agent_email= $extraido_email['agent_email'];

  $service= $extraido_email['service'];
  $commodity= $extraido_email['commodity'];
  $remark= $extraido_email['remark'];
  $payment= $extraido_email['payment'];
  $fecha= $extraido_email['fecha'];
  $wh_receipt= $extraido_email['wh_receipt'];
  $fondo='';
    }



    if ($remark=='yes') {
    	$remark='NEED PICK-UP';
    }

    if ($remark=='no') {
    	$remark='<br>';
    	$fondo='background:white;';
    }


    if ($payment=='yes') {
    	$payment=' | NEED PAYMENT ASSISTANT';
    }else{$payment='';}

    if ($commodity=='') {
    	$commodity='<br>';
    }


$content = ob_get_clean();
        


        $content = '';

        $content .= '
    <style>
    table {
    border-collapse: collapse;
    }

    table{
     width:800px;
     margin:0 auto;
    }

    td{
    border: 1px solid #e2e2e2;
    padding: 10px; 
    max-width:520px;
    word-wrap: break-word;
    }


    </style>

    ';
        /* you css */



        $content .= '<div style="padding:50px;">';
		$content .= '<div style="width:50%; height:300px;">';
		$content .= '<img src="saspy.png" style="width:130px; float:left;">';
			$content .= '<div style="text-align:center; width:400px; position:relative;  margin-left:-0px;">';
			$content .= '<div style="border-top:2x solid black; position:relative; left:-200px;"> <strong><p style="font-weight:700; position:absolute; top:-10px; font-size:22px; ">www.saspyexpress.com</p></strong> </div>';
			$content .= '<p style="margin-top:-70px;">Hengli north street, Hengli cun, Renhe town,</p>';
			$content .= '<p style="margin-top:-10px;">Baiyun District, Guangzhou City, CHINA / +86.132.6811.6490</p>';
			$content .= '<p style="margin-top:-10px;">广州市拉汀国际贸易有限公司</p>';
			$content .= '<div style="border-bottom:1px solid black; position:relative; left:-200px; padding-bottom:10px;"><p style="margin-top:-10px;">广州市白云区人和镇横沥村拱津西㇐巷2号</p></div>';
			$content .= '</div>';
		$content .= '<div style="float:right; position:relative; left:380px; top:75px;">';
			$content .= '<p><span style="font-weight:700; font-weight:bolder; font-size:18px;">Job Order N°</span> <span style="border-bottom:2px solid black; color:#B70007; font-size:18px;">'.$id.'</span>.</p>';
			$content .= '<p style="position:relative; top:-25px;"><span style="font-weight:700; font-weight:bolder; font-size:18px;">WR-</span><span style="border-bottom:2px solid black; color:black; font-size:18px;">'.$wh_receipt.'</span>.</p>';
		$content .= '</div>';


		$content .= '</div>';
			$content .= '<br>';
                
                $content .= '<div style="width:650px; text-align:center; margin-left: auto; margin-right: auto;  background:#002A7D; color:white; font-size:12px; padding:10px; margin-top:-130px;">';
				$content .= '<span style="font-weight:600; text-align:center;">SERVICE ORDER</span>';
		$content .= '</div>';
		
		$content .= '<div style="width:660px; margin-top:10px; text-align:center; margin-left: auto; margin-right: auto;  background:#919191; color:black; font-size:12px; padding:5px; margin-bottom:10px;">';
				$content .= '<span style="font-weight:600; text-align:center;">CUSTOMER DATA</span>';
		$content .= '</div>';
		
		
		
		
		
		$content .= '<div style="position:relative; left:0px;">';
		
		
		$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Contact Person</span>';
				
		$content .= '</div>';
		    
				$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$customer_name.'</span>';
				
				$content .= '</div>';
		
		$content .= '<div style="width:320px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Company Name</span>';
				
		$content .= '</div>';
		
			$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$customer_company.'</span>';
				
				$content .= '</div>';
		
		
		$content .= '</div>';
		
		
		
		
		$content .= '<div style="position:relative; left:0px;">';
		
		
		$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Phone Number</span>';
				
		$content .= '</div>';
		    
				$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$customer_telf.'</span>';
				
				$content .= '</div>';
		
		$content .= '<div style="width:320px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Delivery Address</span>';
				
		$content .= '</div>';
		
			$content .= '<div style="width:320px; font-size:10px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px; height:100px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$customer_address.'</span>';
				
				$content .= '</div>';
		
		
		$content .= '</div>';
		
		
		
		
		
		
		
		
		
		
		$content .= '<div style="position:relative; left:335px; margin-top:-266.5px;">';
		
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Service</span>';
				
		$content .= '</div>';
		
		$content .= '<div style="width:325px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$service.'</span>';
				
				$content .= '</div>';
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Commodity</span>';
				
		$content .= '</div>';
		
		$content .= '<div style="width:325px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$commodity.'</span>';
				
				$content .= '</div>';
		
		
		$content .= '</div>';
		
		
		$content .= '<div style="position:relative; left:335px; margin-top:0px;">';
		
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Remark</span>';
				
		$content .= '</div>';
		
		
		$content .= '<div style="width:325px; float:left; display:inline-block; margin-top:0px; text-align:center; color:white; background:#B80008; font-size:12px; padding:5px; '.$fondo.'">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$remark.$payment.'</span>';
				
				$content .= '</div>';
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Agent</span>';
				
		$content .= '</div>';
		
		$content .= '<div style="width:325px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$agent_name.'</span>';
				
				$content .= '</div>';
		
		
		$content .= '</div>';
		
		
		
		
		$content .= '<div style="position:relative; left:0px; margin-top:20;">';
		
		
		$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Contact E-mail</span>';
				
		$content .= '</div>';
		    
				$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$customer_email.'</span>';
				
				$content .= '</div>';
		
		
		$content .= '</div>';


		$content .= '<div style="position:relative; left:335px; margin-top:-45;">';
		
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Agent E-mail</span>';
				
		$content .= '</div>';
		
		$content .= '<div style="width:325px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$agent_email.'</span>';
				
				$content .= '</div>';
	
		
		
		$content .= '</div>';
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			$content .= '<div style="width:660px; margin-top:30px; text-align:center; margin-left: auto; margin-right: auto;  background:#919191; color:black; font-size:12px; padding:5px; margin-bottom:10px;">';
				$content .= '<span style="font-weight:600; text-align:center;">SUPPLIER DATA</span>';
		$content .= '</div>';
		
		
		
		
		
		$content .= '<div style="position:relative; left:0px;">';
		
		
		$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center; background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Supplier Company</span>';
				
		$content .= '</div>';
		    
				$content .= '<div style="width:320px; height:100px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$supplier_company.'</span>';
				
				$content .= '</div>';
		
	
		
		
		$content .= '</div>';
		
		
		
		
		$content .= '<div style="position:relative; left:0px;">';
		
		
		$content .= '<div style="width:320px; float:left; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Phone Number</span>';
				
		$content .= '</div>';
		    
				$content .= '<div style="width:320px; height:100px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$supplier_name.' | '.$supplier_telf.'</span>';
				
				$content .= '</div>';
		
	
		
		
		$content .= '</div>';
		
		
		
		
		
		
		
		
		
		
		$content .= '<div style="position:relative; left:335px; margin-top:-266.5px;">';
		
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">Company Adress</span>';
				
		$content .= '</div>';
		
		$content .= '<div style="width:325px; height:100px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$supplier_address.'</span>';
				
				$content .= '</div>';
		
		
		
		$content .= '</div>';
		
		
		$content .= '<div style="position:relative; left:335px; margin-top:0px;">';
		
		
		$content .= '<div style="width:325px; float:right; display:inline-block; margin-top:0px; text-align:center;  background:#BFBFBF; color:black; font-size:12px; padding:5px;">';
		
				$content .= '<span style="font-weight:600; text-align:center;">E-mail</span>';
				
		$content .= '</div>';
		
		
		$content .= '<div style="width:325px; height:100px; float:left; display:inline-block; margin-top:0px; text-align:center; color:black; font-size:12px; padding:5px;">';
				
				$content .= '<span style="font-weight:600; font-size:10px; text-align:center;">'.$supplier_email.'</span>';
				
				$content .= '</div>';
		
		
		
		
		$content .= '</div>';
		
		
		
		
		
		
		
		
                
$content .= '</div>';


        // conversion HTML => PDF
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->setDefaultFont('javiergb');

    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('JobOrder_'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }
?>