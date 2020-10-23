<?php
	ob_start();
	require_once('conn.php');

	$id = $_GET['id'];

 	$consulta = mysqli_query($connect, "SELECT * FROM invoices WHERE id='$id' ");

  while ($invoices = mysqli_fetch_array($consulta)) {
	
		$pieces= $invoices['pieces'];
		$weight= $invoices['weight'];
		$volume= $invoices['volume'];
		$weight_c= $invoices['weight_c'];
		$currency= $invoices['currency'];
		$total_invoiced= number_format($invoices['total_invoiced'],2);
		$etd= date_format(date_create($invoices['etd']),'d/m/Y');
		$eta= date_format(date_create($invoices['eta']),'d/m/Y');
		$supplier_id= $invoices['shipper'];
		$house= $invoices['house'];
		$origin= $invoices['origin'];
		$dest= $invoices['dest'];
		$consignee_id= $invoices['consignee_id'];
		$reference= $invoices['reference'];
		$po= $invoices['po'];	
		$warehouse=json_decode($invoices['warehouse']);	
		$warehouse_str=implode(", ", $warehouse);
		$fecha= date_format(date_create($invoices['fecha']),'d/m/Y H:i:s');
    }

	$consulta_supplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$supplier_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowsupplier = mysqli_fetch_array($consulta_supplier)){  
		$supplier_company=$rowsupplier['company'];
		$supplier_name=$rowsupplier['name'];
		$supplier_email=$rowsupplier['email'];
		$supplier_address1=$rowsupplier['address_1'];
		$supplier_address2=$rowsupplier['address_2'];
		$supplier_city=$rowsupplier['city'];
		$supplier_state=$rowsupplier['state'];
		$supplier_country=$rowsupplier['country'];
		$supplier_telf1=$rowsupplier['telf1'];
		$supplier_telf2=$rowsupplier['telf2'];
		$supplier_qq=$rowsupplier['qq'];
		$supplier_wechat=$rowsupplier['wechat'];	
	}

	$consignee_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$consignee_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowconsignee = mysqli_fetch_array($consignee_customer)){  
	
		$consignee_company=$rowconsignee['company'];
		$consignee_name=$rowconsignee['name'];
		$consignee_email=$rowconsignee['email'];
		$consignee_address1=$rowconsignee['address_1'];
		$consignee_address2=$rowconsignee['address_2'];
		$consignee_city=$rowconsignee['city'];
		$consignee_state=$rowconsignee['state'];
		$consignee_country=$rowconsignee['country'];
		$consignee_telf1=$rowconsignee['telf1'];
		$consignee_telf2=$rowconsignee['telf2'];
		$consignee_qq=$rowconsignee['qq'];
		$consignee_wechat=$rowconsignee['wechat'];
		
	}
	
	require_once(dirname(__FILE__).'/tc-barcode/vendor/autoload.php');
	$barcode = new \Com\Tecnick\Barcode\Barcode();
	$targetPath = "barcode/";
    
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
	}
	$productData = '999555'.$id;	
    $bobj = $barcode->getBarcodeObj('C128', "{$productData}", 150, 30, 'black', array(
        0,
        0,
        0,
        0
    ));
    
    $imageData = $bobj->getPngData();
    $timestamp = time();
    
	file_put_contents($targetPath . 'warehouse_'.$id.'.png', $imageData);
	
	$img=$targetPath .'warehouse_'.$id.'.png';

	$content = ob_get_clean();
	$content = '
    <style>
		table {
			border-collapse: collapse;
			display: table;
			width:100%;
		}
		td{
			border: 1px solid #000;
			vertical-align: baseline;
			
		}
		p{
			padding:0px;
			margin:2px;
		}
		.small_text{
			font-size:10px;
		}
		.sm_text{
			font-size:8px;	
		}
		#box_pieces td{
			border: 1px solid #333;
			font-size:12px;
			vertical-align: inherit;
		}
	
	</style>

		
	<div style="width:750px;position:relative; ">
		<div>
			<img src="./img/company_logo.jpg" alt="" style="width:164px;height:90px;">
		</div>
		<div style="margin-left:30px;margin-top:5px; margin-right:30px; display: inline;">
			<div class="" style="float:left;width:389px;display: inline;">				
				<p class="small_text">Guangzhou Latim Logistics LTD - TAX ID: GD201910223838</p>
				<p class="small_text">No. 2 Acacias Street, Banghu Village</p>
				<p class="small_text">Renhe Town, Baiyun District</p>
				<p class="small_text">Guangzhou, Guangdong 510470</p>
				<p class="small_text">Tel:</p>
				<div style="margin-top:10px;">
					<p>SERVICIOS PRESTADOS A:</p>
					<div style="margin-left:10px; margin-top:15px;">
						<p>'.$consignee_name.' '.$consignee_company.'&nbsp;</p>
						<p>'.$consignee_address1.'&nbsp;</p>
						<p>'.$consignee_address2.'&nbsp;</p>
						<p>'.$consignee_state.' - '.$consignee_country.'</p>
						<p>Tel: '.$consignee_telf1.' Mobile: '.$consignee_telf2.'</p>
					</div>
				</div>
			</div>
			<div style="float:left;width:300px;display: inline;">				
				<img style="text-align:right;" src="'.$img.'" alt=""  >
				<h2 style="margin-bottom:10px;margin-top:-160px; ">FACTURA</h2>
				<table style="width:100%">
					<tr>
						<td style="width:60%">
							<p class="sm_text">NÚMERO DE CUENTA</p>
							<p style="text-align:right"></p>
						</td>
						<td style="width:40%">
							<p class="sm_text">NÚMERO</p>
							<p style="text-align:right; margin:0px; font-size:25px;font-weight:bold">'.$id.'</p>
						</td>
					</tr>
					<tr>
						<td >
							<p class="sm_text">FECHA</p>
							<p >'.$etd.'&nbsp;</p>
						</td>
						<td >
							<p class="sm_text">EXPEDIENTE</p>
							<p >&nbsp;</p>
						</td>
					</tr>
					<tr>
						<td >
							<p class="sm_text">FECHA VENCIMIENTO</p>
							<p >'.$eta.'&nbsp;</p>
						</td>
						<td >
							<p class="sm_text">REFERENCIA</p>
							<p >'.$reference.'&nbsp;</p>
						</td>
					</tr>
					<tr>
						<td style="border-bottom:none;">
							<p class="sm_text" >TÉRMINOS</p>
							<p >&nbsp;</p>
						</td>
						<td style="border-bottom:none;">
							<p class="sm_text">NO. PEDIDO</p>
							<p >N/A</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div style=" margin:0px 30px;">
			<table style="width:100%">
				<tr>
					<td colspan="3" style="border-left:none;width:312px">
						<p class="sm_text">TRANSPORTISTA</p>
						<p >&nbsp;</p>
					</td>
					<td style="width:168px;">
						<p class="sm_text">MASTER</p>
						<p >&nbsp;</p>
					</td>
					<td style="border-right:none;width:185px;">
						<p class="sm_text" >HOUSE</p>
						<p >'.$house.'&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td  style="border-left:none; width:104px">
						<p class="sm_text">FECHA DE LLEGADA</p>
						<p >&nbsp; </p>
					</td>
					<td  style="width:104px">
						<p class="sm_text">FECHA SALIDA</p>
						<p >&nbsp;</p>
					</td>
					<td colspan="2" style="width:272px">
						<p class="sm_text">REMITENTE</p>
						<p >'.$supplier_company.' | '.$supplier_name.'&nbsp;</p>
					</td>					
					<td style="border-right:none;width:185px">
						<p class="sm_text">ORIGIN/DESTINATION</p>
						<p >'.$origin.'/'.$dest.'&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td  style="border-left:none; width:104px">
						<p class="sm_text">BULTOS</p>
						<p style="text-align:right">'.$pieces.'&nbsp; </p>
					</td>
					<td  style="width:104px">
						<p class="sm_text">PESO</p>
						<p style="text-align:right">'.$weight.'&nbsp;</p>
					</td>
					<td colspan="2" style="width:272px">
						<p class="sm_text">DESTINATARIO</p>
						<p >&nbsp;</p>
					</td>					
					<td style="border-right:none;width:185px">
						<p class="sm_text">VOLUMEN</p>
						<p >'.$volume.'&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td  style="border-left:none; width:104px">
						<p class="sm_text">FECHA DESPACHO</p>
						<p >&nbsp; </p>
					</td>
					<td colspan="2" style="width:208px">
						<p class="sm_text">NÚMERO ADUANAS</p>
						<p >&nbsp;</p>
					</td>										
					<td colspan="2"  style="border-right:none;width:353px">
						<p class="sm_text">DESCRIPCIÓN</p>
						<p >WAREHOUSE RECEIPT '.$warehouse_str.'&nbsp;</p>
					</td>
				</tr>
				<tr style="padding:0px;margin:0px">
					<td style="border:none;width:104px;padding:0px;margin:0px">						
					</td>
					<td style="border:none;width:104px;padding:0px;margin:0px">
					</td>
					<td style="border:none;width:104px;padding:0px;margin:0px">					
					</td>
					<td style="border:none;width:168px;padding:0px;margin:0px">					
					</td>
					<td style="border:none;width:185px;padding:0px;margin:0px">					
					</td>
				</tr>
			</table>
		</div>		
		<div style="margin:10px 30px;  margin-top:0px;">			
			<div style="float:left;width:520px;display: inline;">
				<div>
					<table id="box_pieces" style="width:100%;max-width:100%">
						';
					$consulta_content = mysqli_query($connect, "SELECT * FROM invoices_detail WHERE invoice_id='$id'");

					while ($result_content = mysqli_fetch_array($consulta_content)) {
					  
						  $description= $result_content['description'];
						  $amount= number_format($result_content['amount'],2);
						  $content.='<tr>
									<td style="width:70%;">'.$description.'</td>
									<td style="width:30%;text-align:right">'.$amount.'</td>									
								</tr>';
					  }
					  $rowcount=mysqli_num_rows($consulta_content);
						$num=20-$rowcount;
					  for($i=0;$i<$num;$i++){
						$content.='<tr style="text-align:center">
										<td style="width:70%;">&nbsp;</td>
										<td style="width:30%;text-align:right"></td>												
									</tr>';
					  }						
		$content.='
					</table>
				</div>
			</div>
			<div  style="float:left;width:163px;display: inline-block;">				
				<table style="width:100%;margin-left:5px; margin-top:-135px;">
					<tbody>
						<tr>
							<td style="width:100%">
								<p class="sm_text">SUBTOTAL</p>
								<p style="text-align:right;font-size:14px;font-weight:bold">'.$currency.' '.$total_invoiced.' &nbsp;</p>
							</td>
						</tr>
						<tr>
							<td>
								<p class="sm_text">TAX</p>
								<p style="text-align:right;font-size:14px;font-weight:bold"> &nbsp;</p>
							</td>						
						</tr>
						<tr>
							<td>
								<p class="sm_text">&nbsp;</p>
								<p style="text-align:right;font-size:14px;font-weight:bold"> &nbsp;</p>
							</td>						
						</tr>
						<tr>
							<td style="background:#c1bebe">
								<p class="sm_text">TOTAL</p>
								<p style="text-align:right;font-size:14px;font-weight:bold">'.$currency.' '.$total_invoiced.' &nbsp;</p>
							</td>						
						</tr>
					</tbody>
				</table>
			</div>			
		</div>
		<div style="margin:10px 30px; border:1px solid #000;">
			<p style="margin-top:10px; font-size:12px;">*NOTAS*</p>
			<div style="margin:10px 10px;">';
			$consulta_note = mysqli_query($connect, "SELECT * FROM invoices_notes WHERE invoice_id='$id' order by fecha desc ");

					while ($result_note = mysqli_fetch_array($consulta_note)) {
					  
						  $agent_name= $result_note['agent_name'];
						  $notes= $result_note['notes'];
						  $date= date_format(date_create($result_note['fecha']),'d/m/Y H:i:s');
						  $content.='<p class="small_text" style="font-size:12px;">'.$notes.' <strong>'.$agent_name.'</strong> <span style="color:red">'.$date.'</span></p>';
					  }
	$content.='</div>			
		</div>
		<div style="margin:10px 30px;">
			<p class="small_text" style="font-size:8px;">CREADO POR ROGABY DIAZ. DOCUMENTO IMPRESO USANDO EL SERVICIO DE CARGOTRACK. PARA MAS INFORMACIÓN IR A HTTP://WWW.CARGOTRACK.NET.
			</p>						
		</div>
	</div>
 ';
 require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
{
	$html2pdf = new HTML2PDF('P', 'A4', 'en');
	$html2pdf->AddFont('freesans', 'normal', 'freesans.php');
	$html2pdf->setDefaultFont('freesans');

	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('Invoice #'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }