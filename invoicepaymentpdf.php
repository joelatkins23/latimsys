<?php
	ob_start();
	require_once('conn.php');

	$id = $_GET['id'];

	$consulta2 = mysqli_query($connect, "select a.*, b.station as branch_name, c.name as type_name, d.name as account_name from invoicepayments a 
	left join branches b on a.branch=b.id 
	left join bill_type c on a.type=c.id 
	left join accounts d on a.account=d.id 
	WHERE a.id='$id' ORDER BY id asc ") or die ("Error al traer los datos222");
while ($row = mysqli_fetch_array($consulta2)){  
$branch=$row['branch_name'];
$date=$row['date'];
$account= $row['account_name'];
$type= $row['type_name'];
$amount= $row['amount'];
$currency= $row['currency'];
$id= $row['id'];
$date= date_format(date_create($row['exchange']),'m/d/Y');
$number= $row['number'];
$reference= $row['reference'];
$comments= $row['comments'];
}

	$content = ob_get_clean();
	$content = '
    <style>
		table {
			border-collapse: collapse;
			display: table;
			width:100%;
		}
		td{
			vertical-align: baseline;
			padding:5px;
			
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
		label{
			display:inline-block;
			font-size:16px
		}
		.form-group{
			margin-bottom:10px;
		}
	</style>

		
	<div style="width:750px;position:relative;">
		<div>
			<img src="./img/company_logo.jpg" alt="" style="width:164px;height:90px;">
		</div>
		<div style="margin-left:30px;margin-top:5px; margin-right:30px;">
			<p class="small_text"><strong>No. 2 Acacias Street, Banghu Village</strong></p>
			<p class="small_text"><strong>Guangzhou Guangdong 510470</strong></p>
		</div>
		<div style="margin:0px 30px; border-bottom:2px solid #000">
			<h3 style="font-weight:bold; margin-bottom:10px">Cashier`s Receipt </h3>
		</div>		
		<div style="margin:10px 30px;border-bottom:2px solid #000">	
			<div style="position:relative;display:block">
				<div style="float:left;width:342px;position: relative;display: inline;">
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Branch</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$branch.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Account</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$account.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Type</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$type.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Check Amount</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$currency.' '.$amount.'</label>
						</div>					
					</div>			
				</div>
				<div style="float:left;width:342px;position: relative;display: inline;">
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Number</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$id.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Date</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$date.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Number</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$number.'</label>
						</div>					
					</div>
					<div class="form-group">
						<div style="width:171px;float:left;display: inline;">
							<label  style="font-weight:300;">Reference</label>
						</div>
						<div style="width:171px;float:left;display: inline;">
							<label style="font-weight:bold;">'.$reference.'</label>
						</div>					
					</div>			
				</div>	
			</div>	
			<div style="position:relative;display:block;margin-top:-75px">
				<div class="form-group">
					<div style="width:171px;float:left;display: inline;">
						<label  style="font-weight:300;">Comments</label>
					</div>
					<div style="width:513px;float:left;display: inline;">
						<label style="font-weight:300;">'.$comments.'</label>
					</div>					
				</div>
			</div>			
		</div>
		<div style="margin:10px 30px;">
			<div style="position:relative;display:block">
				<table style="width:100%;max-width:100%;border: 1px solid;" >
					<thead>
						<tr>
							<th style="width:50%">Invoice Number</th>
							<th style="width:50%;text-align:right">Amount</th>
						</tr>
					</thead>
					<tbody>	';
						$consulta_content = mysqli_query($connect, "SELECT * FROM invoicepayments_contents WHERE invoice_payment_id='$id' group by id ");

						while ($result_content = mysqli_fetch_array($consulta_content)) {					  
							
							$content.='<tr>
											<td>'.$result_content['invoice_id'].'</td>								
											<td style="text-align:right">'.$result_content['currency'].' '.$result_content['paid'].'</td>						
										</tr>';
						}
					$content.='</tbody>
				</table>
			</div>
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
	$html2pdf->Output('Payment #'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }