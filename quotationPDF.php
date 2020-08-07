<?php
ob_start();
// include(dirname(__FILE__).'/res/pdf_demo.php');
	require_once('conn.php');

	$id = $_GET['id'];


	 $consulta_quotations = mysqli_query($connect, "SELECT a.*,IF(b.company<>'', CONCAT(b.name,' | ', b.company), name)client_name FROM quotations  a left join accounts b on a.client_id=b.id WHERE a.id='$id'");
  while ($extraido_quotations = mysqli_fetch_array($consulta_quotations)) {
  		
  		$containerQuantity= $extraido_quotations['containerQuantity'];
  	  $remarks= strtoupper($extraido_quotations['remarks']);
  	  $commodity= strtoupper($extraido_quotations['commodity']);
  	  $origin= strtoupper($extraido_quotations['origin']);
  	  $destination= strtoupper($extraido_quotations['destination']);
  	  $initial_date= $extraido_quotations['initial_date'];
  	  $expiration_date= $extraido_quotations['expiration_date'];

  	  $client_name= strtoupper($extraido_quotations['client_name']);

  	  $client_nameXs = wordwrap($client_name, 40, "/n" ,TRUE);

  	  $client_nameX= explode("/n", $client_nameXs);

  	  if ($client_nameX[1]=='') {$client_nameX[1]=' ';}




  	  $agent_name= $extraido_quotations['agent_name'];
  	  $service= strtoupper($extraido_quotations['service']);
  }

  $pieces = explode(" | ", $client_name);
  $name= $pieces[0];
  $company= $pieces[1];

  $consulta_accounts = mysqli_query($connect, "SELECT * FROM accounts WHERE name='$name' OR company='$company' ");
  while ($extraido_accounts = mysqli_fetch_array($consulta_accounts)) {
  	$address= strtoupper($extraido_accounts['city'].' '.$extraido_accounts['state'].' '.$extraido_accounts['country']);  
  	$customer_telf1 = $extraido_accounts['telf1'];
  	$customer_telf2 = $extraido_accounts['telf2'];
  	$customer_qq = $extraido_accounts['qq'];
  	$customer_wechat = $extraido_accounts['wechat'];

  	 if ($customer_telf1!='') {$customer_telf1=' | Mobile: '.$customer_telf1;}
if ($customer_telf2!='') {$customer_telf2=' | Office: '.$customer_telf2;}
if ($customer_qq!='') {$customer_qq=' | QQ: '.$customer_qq;}
if ($customer_wechat!='') {$customer_wechat=' | WeChat: '.$customer_wechat;}




                        $customer_telf=strtoupper($customer_telf1.$customer_telf2.$customer_qq.$customer_wechat);
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
		$content .= '<img src="./img/logoChina.png" style="width:110px; height:120px; float:left;">';
			$content .= '<div style="float:right; position:relative; left:10px;">';
			$content .= '<strong><p style="font-weight:700; font-size:1.3em;">Latim Cargo & Trading</p></strong>';
			$content .= '<p style="margin-top:-10px;">Hengli north street, Hengli cun, Renhe town,</p>';
			$content .= '<p style="margin-top:-10px;">Baiyun District, Guangzhou City, CHINA / +86.132.6811.6490</p>';
			$content .= '<br>';
			$content .= '<br>';
			$content .= '<p style="color:#B70007; margin-top:-24px; text-decoration:underline;">www.latimcargo.com</p>';
			$content .= '</div>';

		$content .= '<div style="float:right;  position:absolute; left:313.5px; top:-30px;">';
		$content .= '<div><span style="position:absolute; top:260px; left:-285px; font-size:15px;">'.$client_nameX[0].'</span><br>';

		$content .= '<span style="position:absolute; top:282px; left:-285px; font-size:15px;">'.$client_nameX[1].'</span><br>';

		$content .= '<span style="position:absolute; text-align:left; float:left; top:312px; left:-285px; font-size:11px;">'.$address.'</span><br>';
		$content .= '<span style="position:absolute; top:332px; left:-288px; font-size:11px;">'.$customer_telf.'</span></div>';

		$content .= '<table style="position:absolute; top:240px; left:70px;">';

		$content .= '<span style="position:absolute; top:-40px; left:159px; font-size:18px;">QUOTATION</span><br>';

		$content .= '<tr><td><span style="font-size:9px; position:relative; top:-10px; left:-7px;">TYPE</span><span style="position:relative; top:10px; left:-20px; text-align:left;">SHIPMENTS</span></td><td><span style="font-size:9px; position:relative; top:-10px; left:-7px;">QUOTATION</span><span style="position:relative; top:10px; left:-53px; font-size:13px; text-align:left; ">'.$id.'</span></td></tr>';

		$content .= '<tr><td><span style="font-size:9px; position:relative; top:-10px; left:-7px;">LINE</span><span style="position:relative; top:10px; left:-20px; font-size:13px; ">'.$service.'</span></td><td style="width:60px;"><span style="font-size:9px; position:relative; top:-12px; left:-7px;">DATE</span><span style="position:relative; top:8px; left:-23px; font-size:13px; text-align:center;">'.$initial_date.'</span></td></tr>';

		$content .= '<tr><td style="width:120px; font-size:13px; "><span style="font-size:9px; position:relative; top:-10px; left:-7px;">CLASIFICATION</span><span style="position:relative; top:10px; font-size:13px; left:-66px;">EXPORT</span></td><td><span style="font-size:9px; position:relative; top:-12px; left:-7px;">EXPIRES</span><span style="position:relative; top:10px; left:-38px; font-size:13px;">'.$expiration_date.'</span></td></tr>';

		$content .= '</table>';
		$content .= '</div>';


		$content .= '</div>';
			$content .= '<br><BR>';
                
                $content .= '<div style="width:650px; text-align:center; margin-left: auto; margin-right: auto; color:white; font-size:12px; margin-top:-6px; margin-left:0.5px; border-top:2.5px solid #e2e2e2;">';
				$content .= '</div>';

				if ($service=='AIR DOOR TO DOOR' OR $service=='AIR SERVICE' OR $service=='AIR') {

				$content .= '<BR><span style="position:absolute; left:125px; font-size:20px; top:390;">→</span> <span style=" position:absolute; top:405px; left:282px;"><img src="./img/air.png" style="width:100px;"></span>';
				}else{
				$content .= '<span style="position:absolute; left:125px; font-size:20px; top:375;">→</span> <span style=" position:absolute; top:405px; left:282px;"><img src="./img/container.png" style="width:100px;"></span>';
				}
				if ($service=='AIR DOOR TO DOOR') {
				$content .= '<table style="display:inline-block; position:relative; padding:40px; margin-top:-95px; margin-left:-40px;"><tr>';
				}else{
					$content .= '<table style="display:inline-block; position:relative; padding:40px; margin-top:-115px; margin-left:-40px;"><tr>';
				}
				$content .= '<td style="width:80px;"><span style="font-size:9px; position:relative; top:-10px; left:-7px;">ORIGIN</span><span style="position:relative; top:10px; left:-31px; text-align:left;">'.$origin.'</span></td>';

				$content .= '<td style="width:90px; height:18px;"><span style="font-size:9px; position:relative; top:-10px; left:20px;">DESTINATION</span><span style="position:relative; top:10px; left:-59px; text-align:left;">'.$destination.'</span></td>';
				$content .= '</tr></table>';

				$content .= '<table style="display:inline-block; position:relative; top:-142px; left:364px; padding:40px; "><tr>';
				$content .= '<td style="width:80px; "><span style="font-size:9px; position:relative; top:-10px; left:-7px;">COMMODITY</span><span style="position:relative; top:10px; left:-50px; text-align:left; width:80px;">'.$commodity.'</span></td>';

				$content .= '<td style="width:80px;"><span style="font-size:9px; position:relative; top:-10px; left:-7px;">VALUE</span><span style="position:relative; top:10px; left:-28px; text-align:left;">N/A</span></td>';
				$content .= '</tr></table>';

				$consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcontents WHERE quotationID='$id' ")
    or die ("Error al traer los Quotations");



    			$byBoxes_qty=0;
    			$byVolume_qty=0;
    			$byVolume_volume=0;
    			$byVolume_weight=0;
    			$totalVolumeWeight=0;

    			$consultaQuotations2 = mysqli_query($connect, "SELECT * FROM quotationcontents WHERE quotationID='$id' ")
    or die ("Error al traer los Quotations");

    			while ($rowQuotations2 = mysqli_fetch_array($consultaQuotations2)){

					$byBoxes_qty = $rowQuotations2['byBoxes_qty'];
					$byVolume_qty = $rowQuotations2['byVolume_qty'];
					$byVolume_volume = $rowQuotations2['byVolume_volume'];
					$byVolume_weight = $rowQuotations2['byVolume_weight'];
				}


    			if ($byBoxes_qty != '0') {
    				

				$content .= '<table style="display:inline-block; position:relative; top:-42px; left:-150px; padding:40px; ">';

				$content .= '<tr>';

				$content .= '<td style="width:25px; padding-top:-3px; padding-right:-60px;  text-align:center; border:none;"><span style="font-size:9px; position:relative; top:-10px; left:190px;">PIECES</span></td>';

				$content .= '<td style="width:130px; padding-top:-3px; text-align:center; border:none; height:10px;"><span style="font-size:9px; position:relative; top:-10px; left:65px;">DIMENSIONS</span></td>';

				$content .= '<td style="width:50px; padding-top:-3px; text-align:center; border:none; height:10px;"><span style="font-size:9px; position:relative; top:-10px; left:18px;">WEIGHT</span></td>';

				$content .= '<td style="width:50px; padding-top:-3px; text-align:center; border:none; height:10px;"><span style="font-size:9px; position:relative; top:-10px; left:-7px;">VOLUME</span></td>';

				$content .= '<td style="width:50px; padding-top:-3px; text-align:center; border:none; height:10px;"><span style="font-size:9px; position:relative; top:-10px; left:-20px;">WEIGHT-VOLUME</span></td>';

				$content .= '</tr>';

				$totalWeight=0;
				$totalVolume=0;
				$totalPiece=0;
				$totalVolumeWeight=0;

				while ($rowQuotations = mysqli_fetch_array($consultaQuotations)){

					$byBoxes_qty = $rowQuotations['byBoxes_qty'];
					$byBoxes_width = $rowQuotations['byBoxes_width'];
					$byBoxes_lenght = $rowQuotations['byBoxes_lenght'];
					$byBoxes_height = $rowQuotations['byBoxes_height'];
					$byBoxes_weight = $rowQuotations['byBoxes_weight'];
					$volumeBox = ($byBoxes_width * $byBoxes_lenght * $byBoxes_height)/1000000;
					$volumeWeightBox = ($byBoxes_width * $byBoxes_lenght * $byBoxes_height)/166;

				if ($byBoxes_qty!='0') {

				$content .= '<tr>';

				$content .= '<td style="width:55px; padding-top:-25px;  position:relative; text-align:center; padding-right:-300px;  border:none;"><span style="position:relative; top:10px; margin-top:-3px;  left:-26px; font-size:11px; text-align:left; width:55px;height:10px;">'.$byBoxes_qty.'</span></td>';

				$content .= '<td style="width:210px; padding-top:-25px; position:relative; text-align:center; border:none; height:10px;"><span style="position:relative; top:10px; margin-top:-3px; left:60px; font-size:11px; text-align:center; width:210px;height:10px;">'.number_format($byBoxes_width,2).' X  '.number_format($byBoxes_lenght,2).' X '.number_format($byBoxes_height,2).' CM</span></td>';

				$content .= '<td style="width:60px; padding-top:-25px; position:relative; text-align:center; border:none; height:10px;"><span style="position:relative; top:10px; margin-top:-3px; left:18px; font-size:11px; text-align:center; width:50px;height:10px;">'.number_format($byBoxes_weight,2).' KG</span></td>';

				$content .= '<td style="width:80px; padding-top:-25px; position:relative; text-align:center; border:none; height:10px;"><span style="position:relative; top:10px; margin-top:-3px; left:8px; font-size:11px; text-align:center; width:80px;height:10px;">'.number_format($volumeBox,3).' CBM</span></td>';

				$content .= '<td style="width:80px; padding-top:-25px; position:relative; text-align:center; padding-left:-7px; border:none; height:10px;"><span style="position:relative; top:10px; margin-top:-3px; left:0px; font-size:11px; text-align:center; width:80px;height:10px;">'.number_format($volumeWeightBox,2).' KG</span></td>';

				$content .= '</tr>';

			}else{}

				$totalWeight = $totalWeight + ($byBoxes_weight*$byBoxes_qty);
				$totalVolume = $totalVolume + ($volumeBox*$byBoxes_qty);
				$totalVolumeWeight = $totalVolumeWeight + ($volumeWeightBox*$byBoxes_qty);
				$totalPiece += $byBoxes_qty;

				}

				$content .= '</table>';



				}else{$totalPiece = $byVolume_qty;
					$totalWeight = $byVolume_weight;
					$totalVolume = $byVolume_volume;}

				if ($byBoxes_qty==0 && $byVolume_qty==0 && $service=='FCL 40"') {$totalWeight=25000; $totalVolume=56; $totalPiece='N/A';}

				if ($byBoxes_qty==0 && $byVolume_qty==0 && $service=='FCL 40" HC') {$totalWeight=25000; $totalVolume=68; $totalPiece='N/A';}

				if ($byBoxes_qty==0 && $byVolume_qty==0 && $service=='FCL 20"') {$totalWeight=25000; $totalVolume=28; $totalPiece='N/A';}



				if ($byBoxes_qty==0 && $byVolume_qty!=0) {

				$content .= '<table style="display:inline-block; position:relative; padding:40px; margin-top:-48px; margin-left:35px; "><tr>';
				}elseif ($byBoxes_qty==0 && $byVolume_qty==0){
				$content .= '<table style="display:inline-block; position:relative; padding:40px; margin-top:-58px; margin-left:115px; "><tr>';
				}else{
					$content .= '<table style="display:inline-block; position:relative; padding:40px; margin-top:-98px; margin-left:55px; "><tr>';
				}




				
				if ($byBoxes_qty==0 && $byVolume_qty==0) {

					if ($containerQuantity==0) {$containerQuantity=1;}
				$content .= '<td style="width:85px;"><span style="font-size:9px; position:relative; top:-8px; text-align:center; left:8px;">CONTAINERS<br><span style="position:relative; left:-16px; top:-7px;">QTY</span></span><span style="position:relative; top:9px; left:-13px; font-size:11px; text-align:center;">'.$containerQuantity.'</span></td>';

				}else{

				$content .= '<td style="width:75px;"><span style="font-size:9px; position:relative; top:-10px; text-align:center; left:8px;">TOTAL PIECES</span><span style="position:relative; top:10px; left:-33px; font-size:11px; text-align:center;">'.$totalPiece.'</span></td>';
				}
				

				$content .= '<td style="width:92.5px;"><span style="font-size:9px; position:relative; top:-10px; text-align:center; left:8px;">TOTAL WEIGHT</span><span style="position:relative; top:10px; left:-58px; font-size:11px; text-align:center;">'.number_format($totalWeight,3).' KG</span></td>';

				$content .= '<td style="width:90.5px;"><span style="font-size:9px; position:relative; top:-10px; text-align:center; left:4px;">TOTAL VOLUME</span><span style="position:relative; top:10px; left:-61px; font-size:11px; text-align:center;">'.number_format($totalVolume,3).' CBM</span></td>';

				if ($byBoxes_qty==0 && $byVolume_qty==0) {

					
				}elseif ($byBoxes_qty==0 && $byVolume_qty!=0) {

					$totalVolumeWeight= $totalVolume*167;

					$content .= '<td style="width:105.5px;"><span style="font-size:9px; position:relative; top:-10px; text-align:center; left:-2px;">TOTAL VOLUME-WEIGHT</span><span style="position:relative; top:10px; left:-96px; font-size:11px; text-align:center;">'.number_format($totalVolumeWeight,3).' KG</span></td>';

				}else{
					$content .= '<td style="width:105.5px;"><span style="font-size:9px; position:relative; top:-10px; text-align:center; left:-2px;">TOTAL VOLUME-WEIGHT</span><span style="position:relative; top:10px; left:-96px; font-size:11px; text-align:center;">'.number_format($totalVolumeWeight,2).' KG</span></td>';
				}

				

				$content .= '</tr></table>';





				$content .= '<table style="margin-top:-35px; margin-left:5px;">';




				$content .= '<tr>';

				$content .= '<td style="width:400px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-7px;">FREIGHT CHARGES</span></td>';
				$content .= '<td style="width:25px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-127px;">CURRENCY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-90px;">QUANTITY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-137px;">AMOUNT</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-197px;">TOTAL</span></td>';
				$content .= '</tr>';
			
				$content .= '</table>';



				$content .= '<table style="margin-left:5px;">';

				$totalCharges = 0;

				$consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$id' AND type='Freight Charges' ")
    			or die ("Error al traer los Quotations");
				while ($rowQuotations = mysqli_fetch_array($consultaQuotations)){

					$description = $rowQuotations['description'];
					$charge = $rowQuotations['charge'];
					$quantity = $rowQuotations['quantity'];

					$subtotal= $charge*$quantity;

					$totalCharges += $subtotal;

				$content .= '<tr>';

				$content .= '<td style="width:400px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px;">'.$description.'</td>';
				$content .= '<td style="border:none; border-bottom:1px solid #e2e2e2; font-size:11px;"><span style="position:relative; left:-105px;">USD</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-20px;">'.$quantity.'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-90px;">$'.number_format($charge,2).'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-168px;">$'.number_format($subtotal,2).'</span></td>';
				$content .= '</tr>';

				}
				$content .= '</table>';




				$content .= '<table style="margin-top:10px; margin-left:5px;">';

				$content .= '<tr>';

				$content .= '<td style="width:400px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-7px;">ORIGIN CHARGES</span></td>';
				$content .= '<td style="width:25px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-127px;">CURRENCY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-90px;">QUANTITY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-137px;">AMOUNT</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-197px;">TOTAL</span></td>';
				$content .= '</tr>';

				$content .= '</table>';



				$content .= '<table style="margin-left:5px;">';

				$consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$id' AND type='Origin Charges' ")
    			or die ("Error al traer los Quotations");
				while ($rowQuotations = mysqli_fetch_array($consultaQuotations)){

					$description = $rowQuotations['description'];
					$charge = $rowQuotations['charge'];
					$quantity = $rowQuotations['quantity'];

					$subtotal= $charge*$quantity;

					$totalCharges += $subtotal;

				$content .= '<tr>';

				$content .= '<td style="width:400px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px;">'.$description.'</td>';
				$content .= '<td style="border:none; border-bottom:1px solid #e2e2e2; font-size:11px;"><span style="position:relative; left:-105px;">USD</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-20px;">'.$quantity.'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-90px;">$'.number_format($charge,2).'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-168px;">$'.number_format($subtotal,2).'</span></td>';
				$content .= '</tr>';
				}
				$content .= '</table>';




				$content .= '<table style="margin-top:10px; margin-left:5px;">';
				$content .= '<tr>';

				$content .= '<td style="width:400px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-7px;">DESTINATION CHARGES</span></td>';
				$content .= '<td style="width:25px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-127px;">CURRENCY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-90px;">QUANTITY</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-137px;">AMOUNT</span></td>';
				$content .= '<td style="width:100px; padding-top:-3px;  text-align:left; border:none; border-bottom:1px solid black;"><span style="font-size:12px; position:relative; top:20px; left:-197px;">TOTAL</span></td>';
				$content .= '</tr>';
				$content .= '</table>';



				$content .= '<table style="margin-left:5px;">';


				$consultaQuotations = mysqli_query($connect, "SELECT * FROM quotationcharges WHERE quotationID='$id' AND type='Destination Charges' ")
    			or die ("Error al traer los Quotations");
				while ($rowQuotations = mysqli_fetch_array($consultaQuotations)){

					$description = $rowQuotations['description'];
					$charge = $rowQuotations['charge'];
					$quantity = $rowQuotations['quantity'];

					$subtotal= $charge*$quantity;

					$totalCharges += $subtotal;


				$content .= '<tr>';

				$content .= '<td style="width:400px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px;">'.$description.'</td>';
				$content .= '<td style="border:none; border-bottom:1px solid #e2e2e2; font-size:11px;"><span style="position:relative; left:-105px;">USD</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-20px;">'.$quantity.'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-90px;">$'.number_format($charge,2).'</span></td>';
				$content .= '<td style="width:110px; border:none; border-bottom:1px solid #e2e2e2; font-size:11px; "><span style="position:relative; left:-168px;">$'.number_format($subtotal,2).'</span></td>';
				$content .= '</tr>';

				}
				$content .= '</table>';

				$content .= '<div style="position:relative; margin-top:0px; margin-left:440px; background:#b80008; color:white; text-align:center; width:200px; padding:5px; font-size:16px;"><span style="font-size:12px; position:relative; top:-1px; left:0px;"> TOTAL CHARGES </span>  <span style="position:relative; left:10px; top:1px;">$'.number_format($totalCharges,2).'</span> </div>';


				$content .= '<PAGE pagegroup="new" >';

				$content .= '<div style="margin:10px; font-size:12px; margin-top:10px; text-align:center; padding:10px; background:#e2e2e2; color:black; width:620px; padding-bottom:3px;">REMARKS</div>';

				$content .= '<div style="margin:40px; font-size:12px; line-height:15px; margin-top:0px; text-align:left; padding:10px;width:620px; padding-bottom:3px;"><span>'.$remarks.'</span></div>';

				$content .= '

				1. Tarifas aplicables para carga seca y general. Para carga peligrosa, refrigerada, sobredimensionada debe ser solicitada por el cliente.<br><br>

2. Cotizacion basada segun datos suministrados por el cliente, puede variar dependiendo de las generales exactas de la mercancia que nos pueda suministrar nuestro agente en origen.<br><br>
3. Las tarifas no incluye el seguro, ni gastos aduanales en destino.<br><br>
4. Todas las cargas viajan por cuenta y riesgo de nuestros clientes, por lo que su mercancia debe tener el embalaje correcto dependiendo del tipo de mercancia que se maneje y seguro, por lo que no nos hacemos responsables de ningun dano que pueda sufrir la misma desde, durante o hasta el trayecto final del embarque.<br><br>
5.Debe mediar orden por escrito de solicitud de seguro.<br><br>
6. Nuestra responsabilidad es limitada de acuerdo a los terminos y condiciones del Contrato de Transporte (Bill of Lading), y de origen bajo las condiciones generales y las leyes de la Republica de China, por lo que todas las operaciones de transporte no exceden, en ningun caso, a las que asumen frente a nosotros las companias de transporte, aereo, maritimo y terrestre.<br><br>
7. Las Tarifas arriba detalladas estan sujetas a cambios con o sin previo aviso o notificacion.<br><br>
8. El servicio solo cubre los cargos mencionados.<br><br>
9. Basada en las tarifas actuales hoy, puede cambiar de acuerdo a los cambios de moneda al momento.<br><br>
10. Esta oferta no incluye: demoras, retenciones, almacenajes, peajes, seguros, custodias, impuestos, gravamenes, gastos de destino, o cargos mas alla de nuestro control y/o responsabilidad ya sea de origen o de destino que no haya sido previamente cotizado.<br><br>
11. Esta cotizacion, una vez aprobada, se rige bajo todos los terminos y condiciones de la misma.<br><br>
12. Latim Cargo and Trading Inc, no se hace responsable de retenciones, almacenajes ni de cualquier gasto que surgiere por revision de contenedores en escaner, sellos etc, por parte de las Autoridades Gubernamentales correspondientes.</PAGE>';


				$content .= '</div>';


        // conversion HTML => PDF
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'en');
    $html2pdf->AddFont('freesans', 'normal', 'freesans.php');
    $html2pdf->setDefaultFont('freesans');

    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('JobOrder_'.$id.'.pdf'); 
}
catch(HTML2PDF_exception $e) { echo $e; }
?>