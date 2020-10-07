<?php
	ob_start();
	// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];

 	$consulta = mysqli_query($connect, "SELECT * FROM payments_contents WHERE id='$id' ");
	 $total_weight= 0;	
	 $total_pieces= 0;	
	 $total_volume= 0;		
	 $total_charg_weight= 0;
	 $supplier_id= 0;
	 $consignee_id= 0;
	 $reference_id= 0;
	 $tracking= 0;
	 $description= 0;
	 $po= 0;	
	 $invoice= 0;		
	 $can= 0;			
	 $destination= 0;
	 $delivered_by= 0;
//   while ($payment = mysqli_fetch_array($consulta)) {
	
// 		$account= $payment['account'];
	
// 		$fecha= date_format(date_create($warehouse['date']),'d/m/Y');
//     }

// 	$consulta_supplier = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$account' ORDER BY id asc ") or die ("Error al traer los datos222");
// 	while ($rowsupplier = mysqli_fetch_array($consulta_supplier)){  
// 		$supplier_company=$rowsupplier['company'];
// 		$supplier_name=$rowsupplier['name'];
// 		$supplier_email=$rowsupplier['email'];
// 		$supplier_address1=$rowsupplier['address_1'];
// 		$supplier_address2=$rowsupplier['address_2'];
// 		$supplier_city=$rowsupplier['city'];
// 		$supplier_state=$rowsupplier['state'];
// 		$supplier_country=$rowsupplier['country'];
// 		$supplier_telf1=$rowsupplier['telf1'];
// 		$supplier_telf2=$rowsupplier['telf2'];
// 		$supplier_qq=$rowsupplier['qq'];
// 		$supplier_wechat=$rowsupplier['wechat'];	
// 	}

// 	$consignee_customer = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$account' ORDER BY id asc ") or die ("Error al traer los datos222");
// 	while ($rowconsignee = mysqli_fetch_array($consignee_customer)){  
	
// 		$consignee_company=$rowconsignee['company'];
// 		$consignee_name=$rowconsignee['name'];
// 		$consignee_email=$rowconsignee['email'];
// 		$consignee_address1=$rowconsignee['address_1'];
// 		$consignee_address2=$rowconsignee['address_2'];
// 		$consignee_city=$rowconsignee['city'];
// 		$consignee_state=$rowconsignee['state'];
// 		$consignee_country=$rowconsignee['country'];
// 		$consignee_telf1=$rowconsignee['telf1'];
// 		$consignee_telf2=$rowconsignee['telf2'];
// 		$consignee_qq=$rowconsignee['qq'];
// 		$consignee_wechat=$rowconsignee['wechat'];
		
// 	}

// 	$consulta_agent = mysqli_query($connect, "SELECT * FROM agents WHERE id='$agent_id' ORDER BY id asc ") or die ("Error al traer los datos222");
// 	while ($rowagent = mysqli_fetch_array($consulta_agent)){  
	
// 		$agent_name=$rowagent['name'];
// 		$agent_email=$rowagent['email'];
// 	}
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
			border: 2px solid #000;
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
			font-size:10px;
			vertical-align: inherit;
		}
	</style>

		
	<div style="width:750px;position:relative; ">
		<div>
			<img src="./img/company_logo.png" alt="" style="width:164px;height:90px;">
		</div>
		<div style="margin-left:30px; margin-right:30px; display: inline;">
			<div class="" style="float:left;width:389px;display: inline;">				
				<p class="small_text">Guangzhou Latim Logistics LTD</p>
				<p class="small_text">No.493 Yuelong South Road</p>
				<p class="small_text">Guangzhou, Guangdong 510470</p>
				<p class="small_text">Tel:</p>
				<p class="small_text">Email: info@latimcargo.com</p>
				<div style="margin-top:20px;">
					<p>RECEIVED FOR:</p>
					<div style="margin-left:10px; margin-top:15px;">
						
					</div>
				</div>
			</div>
			<div style="float:left;width:300px;display: inline;">				
				<img style="text-align:right;margin-left:150px; margin-top:30px;" src="'.$img.'" alt=""  >
				<h2 style="margin-bottom:10px;text-align:right ">Payment</h2>
				<table style="width:100%">
					<tr>
						<td style="width:60%">
							<p class="sm_text">ACCOUNT</p>
							<p style="text-align:right"></p>
						</td>
						<td style="width:40%">
							<p class="sm_text">NUMBER</p>
							<p style="text-align:right; margin:0px; font-size:25px;font-weight:bold">'.$id.'</p>
						</td>
					</tr>
					<tr>
						<td >
							<p class="sm_text">DATE</p>
							<p ></p>
						</td>
						<td >
							<p class="sm_text">PIECES</p>
							<p ></p>
						</td>
					</tr>
					<tr>
						<td >
							<p class="sm_text">GROSS WEIGHT</p>
							<p ></p>
						</td>
						<td >
							<p class="sm_text">CUBIC</p>
							<p ></p>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-bottom:none;">
							<p class="sm_text">REFERENCE</p>
							<p></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div style=" margin:0px 30px;">
			<table style="width:100%">
				<tr>
					<td colspan="3" style="border-left:none;width:312px">
						<p class="sm_text">RECEIVED FROM</p>
						<p ></p>
					</td>
					<td style="width:168px;">
						<p class="sm_text">DELIVERED BY</p>
						<p >&nbsp;</p>
					</td>
					<td style="border-right:none;width:168px;">
						<p class="sm_text" >TRACKING NUMBER</p>
						<p >&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td  style="border-left:none; width:104px">
						<p class="sm_text">FREIGHT RECEIVED</p>
						<p >COLLECT </p>
					</td>
					<td  style="width:104px">
						<p class="sm_text">FREIGHT AMOUNT</p>
						<p >0.00</p>
					</td>
					<td style="width:104px">
						<p class="sm_text">COD AMOUNT</p>
						<p >0.00</p>
					</td>
					<td style="width:168px;">
						<p class="sm_text">ENCOMIENDAS</p>
						<p > - 0.00 [P]</p>
					</td>
					<td   style="border-right:none;width:168px">
						<p class="sm_text">ORIGIN/DESTINATION</p>
						<p >&nbsp;</p>
					</td>
				</tr>
			</table>
		</div>
		<div style=" margin:10px 30px;">			
			<p class="sm_text">DESCRIPTION</p>
			<p></p>					
		</div>
		<div style="margin:10px 30px; border-top:2px solid #000; border-left:2px solid #000">			
			<div style="float:left;width:540px;display: inline;">
				<div style="border-right:2px solid #000; border-bottom:2px solid #000">
					<table id="box_pieces" style="width:100%;max-width:100%">
						<tr>
							<td style="width:9%;text-align:center">PIECES</td>
							<td style="width:9%;text-align:center">TYPE</td>
							<td style="width:9%;text-align:center">LENGTH</td>
							<td style="width:9%;text-align:center">WIDTH</td>
							<td style="width:9%;text-align:center">HEIGHT</td>
							<td style="width:9%;text-align:center">WEIGHT</td>
							<td style="width:9%;text-align:center">UNITS</td>
							<td style="width:9%;text-align:center">VOLUME</td>
							<td style="width:9%;text-align:center">UNITS</td>
							<td style="width:19%;text-align:center">REFERENCE</td>						
						</tr>
					</table>
				</div>
			</div>
			<div  style="float:left;width:135px;display: inline-block;">
				<p style=" margin-left:5px;font-weight:bold">PO:</p>
				<p style="margin-bottom:40px;margin-left:5px;font-weight:bold">INVOICE:</p>
				<table style="width:100%;margin-left:5px;">
					<tr>
						<td style="width:100%">
							<p class="sm_text">PIECES</p>
							<p style="text-align:right;font-size:18px;font-weight:bold"> &nbsp;</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="sm_text">KILOS</p>
							<p style="text-align:right;font-size:18px;font-weight:bold"> &nbsp;</p>
						</td>						
					</tr>
					<tr>
						<td>
							<p class="sm_text">CUBIC METERS</p>
							<p style="text-align:right;font-size:18px;font-weight:bold"> &nbsp;</p>
						</td>						
					</tr>
					<tr>
						<td>
							<p class="sm_text">CHARG. WEIGHT</p>
							<p style="text-align:right;font-size:18px;font-weight:bold"> &nbsp;</p>
						</td>						
					</tr>
				</table>
			</div>			
		</div>
		<div style="margin:10px 30px; border:2px solid #000;">
			<p style="margin-bottom:10px;">*REMARKS*</p>
			<div style="margin:10px 20px;">';
		
	$content.='</div>			
		</div>
		<div style="margin:10px 30px;">
			<p class="small_text">La responsabilidad de Latim Cargo and Trading Inc se limita a US$ 100.00 en paquetes sin valor declarado. Si el valor de la mercancía supera los US$ 100,00, puede
			declarar un valor más alto. El costo del Seguro es del 10% de la factura Bajo previa inspección de los Artículos y Aprobación. (Seguro No aplica para productos copias).
			De igual forma no nos hacemos Responsables de Paquetes perdidos en Tránsito desde su Proveedor hasta nuestro Almacen. La Empresa no se hará Responsable por
			Perdida o Extravío de Envios por las Distintas empresas de Courier Venezolanas Tal como ZOOM, TEALCA, MRW, AEROCAV.
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
	$html2pdf->Output('Payment_'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }