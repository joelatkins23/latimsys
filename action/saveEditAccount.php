<?php 

	error_reporting(0);
require_once('conn.php');
	
	$id= $_POST['id'];
	$agent= $_POST['agent_name'];
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

	if ($type=='Supplier') {
		$agent = 'Supplier';
	}


    $queryModel = mysqli_query($connect, "UPDATE accounts SET agent='$agent', company='$company', name='$name', address_1='$address_1', address_2='$address_2', city='$city', state='$state', country='$country', telf1='$telf1', telf2='$telf2', qq='$qq', wechat='$wechat', email='$email', type='$type' WHERE id='$id' ")
or die ("<meta http-equiv=\"refresh\" content=\"0;URL= createAccount.php?message=ErrorSavingAccount\">");


   

    echo "<meta http-equiv=\"refresh\" content=\"0;URL= ../editAccount.php?id_account=$id&message=AccountSaved\">";




 ?>

