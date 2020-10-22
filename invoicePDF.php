<?php
	ob_start();
	// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];

 	$consulta = mysqli_query($connect, "SELECT * FROM warehouse WHERE id='$id' ");

  while ($warehouse = mysqli_fetch_array($consulta)) {
	
		$total_pieces= $warehouse['total_pieces'];
		$total_weight= $warehouse['total_weight'];	
		$total_volume= $warehouse['total_volume'];		
		$total_charg_weight= $warehouse['total_charg_weight'];
		$supplier_id= $warehouse['supplier_id'];
		$consignee_id= $warehouse['consignee_id'];
		$reference_id= $warehouse['reference_id'];
		$tracking= $warehouse['tracking'];
		$description= $warehouse['description'];
		$po= $warehouse['po'];	
		$invoice= $warehouse['invoice'].' $'.$warehouse['value'];		
		$can= $warehouse['can'];			
		$destination= $warehouse['destination'];
		$delivered_by= $warehouse['delivered_by1'].''.$warehouse['delivered_by2'];
		$fecha= date_format(date_create($warehouse['fecha']),'d/m/Y H:i:s');
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

	$consulta_agent = mysqli_query($connect, "SELECT * FROM agents WHERE id='$agent_id' ORDER BY id asc ") or die ("Error al traer los datos222");
	while ($rowagent = mysqli_fetch_array($consulta_agent)){  
	
		$agent_name=$rowagent['name'];
		$agent_email=$rowagent['email'];
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
						<p>'.$consignee_name.' '.$consignee_company.'&nbsp;</p>
						<p>'.$consignee_address1.'&nbsp;</p>
						<p>'.$consignee_address2.'&nbsp;</p>
						<p>'.$consignee_state.' - '.$consignee_country.'</p>
						<p>Tel: '.$consignee_telf1.' Mobile: '.$consignee_telf2.'</p>
					</div>
				</div>
			</div>
			<div style="float:left;width:300px;display: inline;">				
				<img style="text-align:right;margin-left:10px;" src="'.$img.'" alt=""  >
				<h2 style="margin-bottom:10px;margin-top:-160px; ">WAREHOUSE RECEIPT</h2>
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
							<p >'.$fecha.'</p>
						</td>
						<td >
							<p class="sm_text">PIECES</p>
							<p >'.$total_pieces.'</p>
						</td>
					</tr>
					<tr>
						<td >
							<p class="sm_text">GROSS WEIGHT</p>
							<p >'.$total_weight.' KGS</p>
						</td>
						<td >
							<p class="sm_text">CUBIC</p>
							<p >'.$total_volume.' M3</p>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-bottom:none;">
							<p class="sm_text">REFERENCE</p>
							<p>'.$reference_id.'&nbsp;</p>
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
						<p >'.$supplier_name.' '.$supplier_company.'</p>
					</td>
					<td style="width:168px;">
						<p class="sm_text">DELIVERED BY</p>
						<p >'.$delivered_by.'&nbsp;</p>
					</td>
					<td style="border-right:none;width:168px;">
						<p class="sm_text" >TRACKING NUMBER</p>
						<p >'.$tracking.'&nbsp;</p>
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
						<p >'.$can.'/'.$destination.'&nbsp;</p>
					</td>
				</tr>
			</table>
		</div>
		<div style=" margin:10px 30px;">			
			<p class="sm_text">DESCRIPTION</p>
			<p>'.$description.'</p>					
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
						</tr>';
					$consulta_content = mysqli_query($connect, "SELECT * FROM warehousecontents WHERE warehouse_id='$id' group by pieces_id ");

					while ($result_content = mysqli_fetch_array($consulta_content)) {
					  
						  $byBoxes_pieces= $result_content['byBoxes_pieces'];
						  $byBoxes_lenght= $result_content['byBoxes_lenght'];
						  $byBoxes_width= $result_content['byBoxes_width'];
						  $byBoxes_height= $result_content['byBoxes_height'];
						  $byBoxes_weight= $result_content['byBoxes_weight'];
						  $byBoxes_vloume= $result_content['byBoxes_lenght']*$result_content['byBoxes_height']*$result_content['byBoxes_width']/1000000;
						  $content.='<tr style="text-align:center">
									<td>'.$byBoxes_pieces.'</td>
									<td>PIEC</td>
									<td>'.$byBoxes_lenght.'</td>
									<td>'.$byBoxes_width.'</td>
									<td>'.$byBoxes_height.'</td>
									<td>'.$byBoxes_weight.'</td>
									<td>kgs</td>
									<td>'.$byBoxes_vloume.'</td>
									<td>1</td>
									<td></td>						
								</tr>';
					  }
					  $rowcount=mysqli_num_rows($consulta_content);
						$num=17-$rowcount;
					  for($i=0;$i<$num;$i++){
						$content.='<tr style="text-align:center">
										<td>&nbsp;</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>						
									</tr>';
					  }						
		$content.='
					</table>
				</div>
			</div>
			<div  style="float:left;width:135px;display: inline-block;">
				<p style="margin-top:-234px; margin-left:5px;font-weight:bold">PO:'.$po.'</p>
				<p style="margin-bottom:40px;margin-left:5px;font-weight:bold">INVOICE:'.$invoice.'</p>
				<table style="width:100%;margin-left:5px;">
					<tr>
						<td style="width:100%">
							<p class="sm_text">PIECES</p>
							<p style="text-align:right;font-size:18px;font-weight:bold">'.$total_pieces.' &nbsp;</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="sm_text">KILOS</p>
							<p style="text-align:right;font-size:18px;font-weight:bold">'.$total_weight.' &nbsp;</p>
						</td>						
					</tr>
					<tr>
						<td>
							<p class="sm_text">CUBIC METERS</p>
							<p style="text-align:right;font-size:18px;font-weight:bold">'.$total_volume.' &nbsp;</p>
						</td>						
					</tr>
					<tr>
						<td>
							<p class="sm_text">CHARG. WEIGHT</p>
							<p style="text-align:right;font-size:18px;font-weight:bold">'.$total_weight.' &nbsp;</p>
						</td>						
					</tr>
				</table>
			</div>			
		</div>
		<div style="margin:10px 30px; border:2px solid #000;">
			<p style="margin-bottom:10px;">*REMARKS*</p>
			<div style="margin:10px 20px;">';
			$consulta_note = mysqli_query($connect, "SELECT * FROM warehouse_note WHERE warehouse_id='$id' order by fecha desc ");

					while ($result_note = mysqli_fetch_array($consulta_note)) {
					  
						  $agent_name= $result_note['agent_name'];
						  $notes= $result_note['notes'];
						  $date= date_format(date_create($result_note['fecha']),'d/m/Y H:i:s');
						  $content.='<p class="small_text">'.$notes.' '.$agent_name.' <span style="color:red">'.$date.'</span></p>';
					  }
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
	$html2pdf->Output('Invoice #'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }