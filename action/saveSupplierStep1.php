<?php 

	error_reporting(0);
	require_once('conn.php');

	if(isset($_POST['supplier_idd'])){
		$supplier_idd= $_POST['supplier_idd'];
	}
	if(isset($_POST['customer_id'])){
		$customer_id= $_POST['customer_id'];
	}
	$agent= $_POST['agent'];
	$company= $_POST['company'];
	$name= $_POST['name'];
	$address_1= $_POST['address_1'];
	$address_2= $_POST['address_2'];
	$city= $_POST['city'];
	$state= $_POST['state'];
	$country= $_POST['country'];
	$telf1= $_POST['telf1'];
	$telf2= $_POST['telf2'];
	$qq= $_POST['qq'];
	$wechat= $_POST['wechat'];
	$email= $_POST['email'];
	$type= $_POST['type'];

	$supplier_id= $_POST['supplier_id'];

	if ($type=='Supplier') {
		$agent = 'Supplier';
	}

	$dt = new DateTime($fecha);

$fecha = $dt->format('Y-m-d H:i:s');
	



$queryModel = mysqli_query($connect, "INSERT INTO accounts(agent, company, name, address_1, address_2, city, state, country, telf1, telf2, qq, wechat, email, type, fecha, client_id) 
                VALUES ('$agent', '$company', '$name', '$address_1', '$address_2', '$city', '$state', '$country', '$telf1', '$telf2', '$qq', '$wechat', '$email', '$type', '$fecha', '$supplier_id')")
or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ../createJobOrder.php?step=1&message=Error\">");




$supplier_idd = mysqli_insert_id($connect);

echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../createJobOrder.php?step=1&customer_id=$customer_id&supplier_idd=$supplier_idd\">";


 ?>