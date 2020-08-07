<?php 

	error_reporting(0);
	require_once('conn.php');


	$branch= '';
	$agent_name= $_POST['agent_name'];
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
	$fecha = date('Y-m-d H:i:s');	
	
	$password=password_generate(6);
	$mail_password=$password;
	
	$password = trim($password);

	$result = mysqli_query($connect, "SELECT * FROM users where username='$email'") ;
	if(mysqli_num_rows($result) == 1){
		$username_err = "This username is already taken.";
		$data['status']=false;
		$data['html']=$username_err;
		echo json_encode($data);
	} else{
		$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
		if($stmt = mysqli_prepare($connect, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ss", $email, $password);		
			$username = $email;
			$password = password_hash($password, PASSWORD_DEFAULT);
	
			if(mysqli_stmt_execute($stmt)){
				$to = $email;
				$subject = "New account";
				$txt = "Your password id".$mail_password;
				$headers = "From: no-reply@latimcargo.com";			
				mail($to,$subject,$txt,$headers);
			}
	
			$queryModel = mysqli_query($connect, "INSERT INTO agents(name, phone, email, level) VALUES ('$name','$telf1', '$email', 'Client')") or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ../createWarehouse.php?step=1&message=Error\">");
	
			$queryModel = mysqli_query($connect, "INSERT INTO accounts(agent, company, name, address_1, address_2, city, state, country, telf1, telf2, qq, wechat, email, type, fecha, branch) 
							VALUES ('$agent_name', '$company', '$name', '$address_1', '$address_2', '$city', '$state', '$country', '$telf1', '$telf2', '$qq', '$wechat', '$email', '$type', '$fecha', '$branch')")
			or die ("<meta http-equiv=\"refresh\" content=\"0;URL= ../createWarehouse.php?step=1&message=Error\">");
				$accounts_id=mysqli_insert_id($connect);
				$html='';
				$consulta = mysqli_query($connect, "SELECT * FROM accounts where type='Client' or type='Agent' order by id ")
				or die ("Error al traer los Agent");
				while ($row = mysqli_fetch_array($consulta)){
					$ID=$row['id'];
					$name=$row['name'];
					$company=$row['company'];
					$city=$row['city'];
					if($accounts_id==$ID){
						$html.='<option selected value="'.$ID.'">'.$ID.' '.$name.' / '.$company.' '.$city.'</option>';
					}else{
						$html.='<option  value="'.$ID.'">'.$ID.' '.$name.' / '.$company.' '.$city.'</option>';
					}
				}
				$data['status']=true;
				$data['real_password']=$password;
				$data['html']=$html;
				$data['password']=$mail_password;
				echo json_encode($data);
		}
	}
	function password_generate($chars) 
	{
	  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	  return substr(str_shuffle($data), 0, $chars);
	}
 ?>