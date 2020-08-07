<?php 



	require_once('conn.php');

	$agent_name= $_POST['agent_name'];
	$agent_email= $_POST['agent_email'];
	$client_id= $_POST['client_id'];
	$initial_date= $_POST['initial_date'];
	$expiration_date= $_POST['expiration_date'];
	$origin= $_POST['origin'];
	$destination= $_POST['destination'];
	$service= $_POST['service'];
	$commodity= $_POST['commodity'];
	$remarks= $_POST['remarks'];
	$containerQuantity= $_POST['containerQuantity'];
	$byVolume_qty= $_POST['byVolume_qty'];
	$byBoxes_qtyX= $_POST['byBoxes_qtyX'];
	date_default_timezone_set('America/La_Paz');
    $fecha_db= date('Y-m-d H:i:s');
	
	

if ($containerQuantity=='') {$containerQuantity=1;}

	$dt = new DateTime($initial_date);

	$initial_date = $dt->format('Y-m-d');

	$dt2 = new DateTime($expiration_date);

	$expiration_date = $dt2->format('Y-m-d');



	

	 $consultaQuotations = mysqli_query($connect, "SELECT * FROM quotations ORDER BY id DESC LIMIT 1 ")
    or die ("Error al traer los Quotations");


     while ($rowQuotations = mysqli_fetch_array($consultaQuotations)){

        $quotationID=$rowQuotations['id'];
}

$queryQuotation = mysqli_query($connect, "INSERT INTO quotations(agent_name, client_id, initial_date, expiration_date, origin, destination, service, commodity, containerQuantity, remarks, agent_email, fecha) VALUES ('$agent_name', '$client_id', '$initial_date', '$expiration_date', '$origin', '$destination', '$service', '$commodity', $containerQuantity, '".nl2br($remarks)."', '$agent_email', '$fecha_db' )")or die ("Error");


$quotationID++;

	
		

if ($byVolume_qty!='') {

		$byVolume_qty= $_POST['byVolume_qty'];
		$byVolume_volume= $_POST['byVolume_volume'];
		$byVolume_weight= $_POST['byVolume_weight'];

		$queryQuotationByVolume = mysqli_query($connect, "INSERT INTO quotationcontents(quotationID, byVolume_qty, byVolume_volume, byVolume_weight, type) 
			VALUES ('$quotationID', '$byVolume_qty', '$byVolume_volume', '$byVolume_weight', 'By Volume' )");

	}


		$byBoxes_qtyX= $_POST['byBoxes_qtyX'];
		$byBoxes_widthX= $_POST['byBoxes_widthX'];
		$byBoxes_lenghtX= $_POST['byBoxes_lenghtX'];
		$byBoxes_heightX= $_POST['byBoxes_heightX'];
		$byBoxes_weightX= $_POST['byBoxes_weightX'];
		$countBoxes=-1;

foreach ($byBoxes_qtyX as $byBoxes_qtyX => $byBoxes_qty) {

		$countBoxes++;
		if ($byBoxes_qty!='') {

		echo $byBoxes_qty.' ['.$byBoxes_widthX[$countBoxes].'] <br>';
		$queryQuotationContents = mysqli_query($connect, "INSERT INTO quotationcontents(quotationID, byBoxes_qty, byBoxes_width, byBoxes_lenght, byBoxes_height, byBoxes_weight) 
                VALUES ('$quotationID', '$byBoxes_qty', '$byBoxes_widthX[$countBoxes]', '$byBoxes_lenghtX[$countBoxes]', '$byBoxes_heightX[$countBoxes]', $byBoxes_weightX[$countBoxes] )");

	}
}

$freightChargeX= $_POST['freightChargeX'];
$freightChargeQX= $_POST['freightChargeQX'];
$freightDescX= $_POST['freightDescX'];
$countFreight=-1;

	

foreach ($freightChargeX as $freightChargeX => $freightCharge) {

		$countFreight++;
		if ($freightCharge!='') {

		$queryQuotationChargesx = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID, quantity, charge, description, type) 
                VALUES ('$quotationID', '$freightChargeQX[$countFreight]', '$freightCharge', '$freightDescX[$countFreight]', 'Freight Charges' )");

	}
}



	$originChargeX= $_POST['originChargeX'];
	$originChargeQX= $_POST['originChargeQX'];
	$originDescX= $_POST['originDescX'];
	$countOrigin=-1;

	

foreach ($originChargeX as $originChargeX => $originCharge) {

		$countOrigin++;

		if ($originCharge!='') {

		$queryQuotationChargesx = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID, quantity, charge, description, type) 
                VALUES ('$quotationID', '$originChargeQX[$countOrigin]', '$originCharge', '$originDescX[$countOrigin]', 'Origin Charges')");

	}
}


	$destinationChargeX= $_POST['destinationChargeX'];
	$destinationChargeQX= $_POST['destinationChargeQX'];
	$destinationDescX= $_POST['destinationDescX'];
	$countDestination=-1;


	

foreach ($destinationChargeX as $destinationChargeX => $destinationCharge) {

	$countDestination++;

	if ($destinationCharge!='') {

	$queryQuotationChargesx = mysqli_query($connect, "INSERT INTO quotationcharges(quotationID, quantity, charge, description, type) 
			VALUES ('$quotationID', '$destinationChargeQX[$countDestination]', '$destinationCharge', '$destinationDescX[$countDestination]', 'Destination Charges')");

}
}

echo "<meta http-equiv=\"refresh\" content=\"0;URL= createQuotation.php?message=QuotationCreated\">";




 ?>