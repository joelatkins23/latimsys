<?php
	ob_start();
	// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];
	$consulta = mysqli_query($connect, "SELECT * FROM accounts WHERE id='$id' ");

  while ($warehouse = mysqli_fetch_array($consulta)) {
	
		$company= $warehouse['company'];
		$name= $warehouse['name'];	
		$address_1= $warehouse['address_1'];
		$address_2= $warehouse['address_2'];
		$city= $warehouse['city'];
		$state= $warehouse['state'];
		$country= $warehouse['country'];
		
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
    
	file_put_contents($targetPath . $id . '.png', $imageData);
	
	$img=$targetPath . $id . '.png';

	$content = ob_get_clean();
	$content = '';

	$content .= '
	
    <style>
		
		table {
			border-collapse: collapse;
			display: table;
			width:100%;
		}
		td{
			border: 2px solid #000;
			vertical-align: inherit;
			padding: 5px 0px;
			
		}
		p{
			padding:0px;
			margin:2px;
		}
		.small_text{
			font-size:10px;
		}
		.sm_text{
			font-size:12px;	
		}
		#box_pieces td{
			border: 1px solid #333;
			font-size:10px;
			vertical-align: inherit;
		}
		h3{
			font-weight:800;
		}
		h2,h3,h4{
			margin-top:3px;
			margin-bottom:0px;
		}
		</style>
		<div style="width:750px;">		
			<div style="margin-left:30px; margin-right:30px;">
				<table style="width:100%; margin-top:-30px;">
					<tr>
						<td style="width:150px;border:none">
							<img src="./img/logoChina.png" alt="" style="width:100px; height:120px;">
						</td>
						<td style="width:300px;text-align:center;border:none">
							<h3 style="margin-top:40px;">LATIMCARGO<br>广州市拉汀国际物流有限公司</h3>	
						</td>
						<td style="width:240px; text-align:right;border:none">
							<h4 style="margin-top:40px;margin-bottom:0px;">ACCOUNT ID  <strong style="color:red">'.$id.'</strong></h4>					
							<img style="text-align:right;padding-top:10px;" src="'.$img.'" alt=""  >	
						</td>
					</tr>
				</table>
								
			</div>
			<div style="margin-left:30px; margin-right:30px; margin-top:20px;">				
				<table style="width:100%;">
					<tr>
						<td colspan="2" style="width:690px; text-align:center;border-left:none;border-right:none">
							<h3 style="color:blue;text-align:center">务必带此单入仓，否则货物仓库拒收！</h3>
							<h4 style="text-align:center">送货前请致电   13226678040  孙小姐 /13268116490 曹小姐 / 座机 020-31702153</h4>
						</td>						
					</tr>
					<tr>
						<td colspan="2" style="width:690px; text-align:center;border-left:none;border-right:none">
							<h4 style="color:red;text-align:center">退税报送服务/Customer Serivec: (&nbsp;&nbsp;&nbsp;) 正规报送 (&nbsp;&nbsp;&nbsp;)  实单报送</h4>
						</td>						
					</tr>
					<tr>
						<td  style="width:345px;border-left:none">
							<p class="sm_text">入仓单号</p>
							<p >&nbsp;</p>
						</td>
						<td  style="width:345px;border-right:none">
							<p class="sm_text"><span><img style="width:12px;" src="./img/star.png"></span>工厂英文名称/Supplier Information</p>
							<p >&nbsp;</p>
						</td>						
					</tr>
					<tr>
						<td  style="width:345px;border-left:none;">						
							<div style="width:300px;float:left;display:inline"><p >'.$address_1.' '.$address_2.' '.$city.' '.$state.' '.$country.'&nbsp;</p></div>
							<div style="width:40px;float:left;;display:inline;text-align:center"><img src="./img/venezuela.png" style="width:40px;margin:auto"></div>
						</td>
						<td  style="width:345px;border-right:none">
							<p class="sm_text"><span><img style="width:12px;" src="./img/star.png"></span>客户名字/Customer Name</p>
							<p >'.$name.' / '.$company.'&nbsp;</p>
						</td>						
					</tr>
				</table>				
			</div>
			<div style="margin-left:30px; margin-right:30px;border-top:3x solid #000">				
				<table style="width:100%;">					
					<tr>
						<td  style="width:100px;border-left:none;">						
							<p class="sm_text">唛头</p>
							<p class="sm_text">SHIPPING MARK</p>
						</td>
						<td  style="width:166px;">
							<p class="sm_text">中英文品名</p>
							<p class="sm_text">COMMODITY</p>							
						</td>						
						<td  style="width:100px;">
							<p class="sm_text">VAULE($)</p>
						</td>
						<td  style="width:100px;">
							<p class="sm_text">件数</p>
							<p class="sm_text">PACKAGES</p>
						</td>
						<td  style="width:100px;">
							<p class="sm_text">中英文品名</p>
							<p class="sm_text">VOLUME</p>
						</td>
						<td  style="width:100px;border-right:none">
							<p class="sm_text">中英文品名</p>
							<p class="sm_text">WEIGHT</p>
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;">						
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>						
						</td>						
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none">	
							<p>&nbsp;</p>						
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;">						
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>						
						</td>						
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none">	
							<p>&nbsp;</p>						
						</td>						
					</tr>
					<tr>
						<td  style="border-left:none;">						
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>						
						</td>						
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<p>&nbsp;</p>
						</td>
						<td  style="border-right:none">	
							<p>&nbsp;</p>						
						</td>						
					</tr>					
				</table>				
			</div>
			<div style="margin-left:80px; margin-right:80px; margin-top:20px;">				
				<table style="width:100%;">					
					<tr>
						<td  style="width:190px;border:none;">						
							<img style="width:180px;" src="./img/waring.png">
						</td>
						<td  style="width:400px;border:none;">
							<h4 ><span><img style="width:18px;" src="./img/star.png"></span>送货地址： 广州市白云区人和鎮蚌湖村相思街 2 号</h4>
							<h4 >（鑫辉工业园劳）导航：鑫辉园</h4>
							<h4 ><span><img style="width:18px;" src="./img/star.png"></span>海运入仓费： 70元/次，支付宝/微信支付， 不接受现金。</h4>
							<h4 ><span><img style="width:18px;" src="./img/star.png"></span>上班时间：早上 9：00 晚上 18:00</h4>
							<h4 style="color:red">国家节假日不上班， 周六日送货电话提前确认。</h4>
							<h4 style="color:red">(WORKDAY: 9:00AM-10:00PM, MONDAY-FRIDAY)</h4>	
							<h4 style="color:red">(DAY OFF: LEGAM HOLIDAY & WEEKEND)</h4>								
						</td>				
					</tr>
					<tr>						
						<td colspan="2" style="width:590px;border:none;">							
							<img style="width:560px; margin-top:20px;" src="./img/map_2.png">				
						</td>				
					</tr>									
				</table>				
			</div>
		</div>
 ';

				// echo $content;
				// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P', 'A4', 'en');
		$html2pdf->setDefaultFont('javiergb');
		
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('Account_'.$id.'.pdf'); 
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>