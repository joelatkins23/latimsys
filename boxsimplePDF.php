<?php
	ob_start();
	// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];

 	$consulta = mysqli_query($connect, "SELECT * FROM warehouse  WHERE id='$id' ");

  while ($warehouse = mysqli_fetch_array($consulta)) {
	
		$total_pieces= $warehouse['total_pieces'];
		$total_weight= $warehouse['total_weight'];	
		$total_volume= $warehouse['total_volume'];		
		$total_charg_weight= $warehouse['total_charg_weight'];
		$supplier_id= $warehouse['supplier_id'];
		$supplier_id= $warehouse['supplier_id'];
		$agent_id= $warehouse['agent_id'];
		$consignee_id= $warehouse['consignee_id'];
		$reference_id= $warehouse['reference_id'];
		$tracking= $warehouse['tracking'];
		$instination= $warehouse['instination'];
		$description= $warehouse['description'];
		$po= $warehouse['po'];	
		$value= $warehouse['value'];		
		$can= $warehouse['can'];			
		$destination= $warehouse['destination'];
		$delivered_by= $warehouse['delivered_by1'].''.$warehouse['delivered_by2'];
		$fecha= date_format(date_create($warehouse['fecha']),'n/d/Y');
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
	

	$content = ob_get_clean();
	$content = '
    <style>
		table {
			border-collapse: initial;
			width:100%;
		}
		td{
			border-top: 5px solid #000;
			border-right: 5px solid #000;
			vertical-align: baseline;
			align-items: baseline;	
			padding:5px;
			
		}
		
		.text{
			padding:5px;
			margin:5px;
			font-size:20px;
		}
		.bold_text{
			padding:5px;
			margin:5px;
			font-size:20px;
			font-weight:bold;
		}
		.small_text{
			font-size:16px;
			padding:4px;
			margin:2px;
		}
		.bg_text{
			font-size:150px;
			padding:5px;
			margin:5px;
		}
	</style>';
	$consultacontent = mysqli_query($connect, "SELECT * FROM `warehousecontents` WHERE warehouse_id='$id' ORDER BY pieces_id, pieces_num ASC ");
	$i=0;
	$rowcount=mysqli_num_rows($consultacontent);
  while ($rowcontent = mysqli_fetch_array($consultacontent)) {
	  $i++;
	$warehouse_id=$rowcontent['warehouse_id'];
	$pieces_num=$rowcontent['pieces_num'];
	$pieces_id=$rowcontent['id'];
	$byBoxes_pieces=$rowcontent['byBoxes_pieces'];
	$byBoxes_lenght=$rowcontent['byBoxes_lenght'];
	$byBoxes_width=$rowcontent['byBoxes_width'];
	$byBoxes_height=$rowcontent['byBoxes_height'];
	$byBoxes_weight=$rowcontent['byBoxes_weight'];	
	$productData = str_pad($pieces_id, 4, '0', STR_PAD_LEFT);
	// echo $data;
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $bobj = $barcode->getBarcodeObj('C128', "{$productData}", 200, 80, 'black', array(
        0,
        0,
        0,
        0
    ));
    
    $imageData = $bobj->getPngData();
    $timestamp = time();
    
	file_put_contents($targetPath . 'warehouse_content'.$pieces_id.'.png', $imageData);
	
	$img=$targetPath .'warehouse_content'.$pieces_id.'.png';	
	$content.='<div style="width:750px;position:relative; ">
		<div style="margin:80px 30px; margin-bottom:0px;">
			<table style="width:100%">
				<tr>
					<td colspan="2" style="border-right:none;width:640px;">
						<p class="small_text">Shipper</p>
						<p class="text">'.$supplier_name.' '.$supplier_company.'</p>
					</td>					
				</tr>
				<tr>
					<td colspan="2" style="border-right:none;width:640px;">
						<p class="small_text">Consignee</p>
						<p class="bold_text" style="margin-bottom:0px;">'.$consignee_name.' / '.$consignee_company.'&nbsp;</p>
						<p class="text" style="margin-top:0px;padding-top:0px;">'.$consignee_address1.' '.$consignee_address2.' '.$consignee_city.' '.$consignee_state.' '.$consignee_country.'&nbsp;</p>
					</td>					
				</tr>
				<tr>
					<td colspan="2" style="border-right:none;width:640px;">
						<p class="text" style="margin-bottom:0px;text-align:center">'.$byBoxes_weight.' KGS&nbsp;&nbsp;&nbsp;&nbsp;'.$byBoxes_lenght.'&times;'.$byBoxes_width.'&times;'.$byBoxes_height.'&nbsp;&nbsp;&nbsp;&nbsp;  ('.$pieces_num.'/'.$byBoxes_pieces.')&nbsp;</p>
						<p class="text" style="margin-top:0px;padding-top:0px;text-align:center">'.$description.' $'.$value.'&nbsp;</p>
					</td>					
				</tr>
				<tr>
					<td colspan="2" style="border-right:none;width:640px;">
						<p class="bg_text" style="margin-bottom:0px;text-align:center">&nbsp;'.$warehouse_id.'&nbsp;</p>
					</td>					
				</tr>
				<tr>
					<td style="width:340px;">
						<p class="small_text">Destination</p>
						<p class="bold_text"  style="margin-top:0px;padding-top:0px;font-size:60px">'.$destination.'&nbsp;</p>
					</td>
					<td style="border-right:none;width:300px;">
						<p class="small_text" >Route/ Agent</p><br>
						<p class="bold_text"  style="margin-top:0px;padding-top:0px;font-size:30px; vertical-align: bottom;	">'.$agent_name.'&nbsp;</p>
					</td>					
				</tr>				
			</table>
			<table style="width:100%">				
				<tr>
					<td style="width:460px;border-right:none;">
						<p class="small_text">Service</p>
						<p class="text" style="margin-top:0px;padding-top:0px;">SUR400027979888</p>
						<p class="bold_text"  style="margin-top:0px;padding-top:0px;font-size:60px">'.$instination.'&nbsp;</p>
						<p class="text" style="margin-top:0px;padding-top:0px;margin-left:30px">'.$pieces_id.'</p>
						<img style="text-align:right;margin-left:10px;margin-left:30px" src="'.$img.'" alt=""  >
					</td>
					<td style="border-right:none;width:180px;">
						<p class="small_text "  style="text-align:center">'.$fecha.'</p><br><br><br><br>
						<p class="bold_text"  style="font-size:50px;text-align:center">'.$i.'/'.$rowcount.'</p>
					</td>					
				</tr>
			</table>
		</div>		
	</div>
 ';
  }
 require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
{
	$html2pdf = new HTML2PDF('P', 'A4', 'en');
	$html2pdf->AddFont('freesans', 'normal', 'freesans.php');
	$html2pdf->setDefaultFont('freesans');

	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('warehouse_box_'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }