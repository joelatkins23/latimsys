<?php 
error_reporting(0);
require_once('conn.php');

// Initialize the session
session_start();

require_once('conn.php');
 
 $email=$_SESSION['username'];

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["username"]) || $_SESSION["username"] !== 'manager@latimcargo.com'){
    header("location: login.php");
    exit;
}

    
?>

<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        include_once 'conn.php';

        $consulta_invoice = mysqli_query($connect, "SELECT * FROM agents ORDER BY id DESC LIMIT 1");

     $num_rows_invoice = mysqli_num_rows($consulta_invoice);

if($num_rows_invoice==0)
{
  $invoice=1;
  $mensaje='No existen invoices';
}
else
{

  while ($extraido_email = mysqli_fetch_array($consulta_invoice)) {

        $invoice= $extraido_email['id'];
        
    }

  $invoice=$invoice+1;
}
        $email = $_POST['username'];
        $agent_name= $_POST['agent_name'];
        $phone= $_POST['phone'];
        $level= $_POST['level'];
        $ruta="images/";//ruta carpeta donde queremos copiar las imágenes 
    
    $uploadfile_temporal1=$_FILES['image']['tmp_name']; 
    if ($uploadfile_temporal1=='') {
    }else{
    $uploadfile_nombre1=$ruta.$invoice.'-1.jpg'; 


    if (is_uploaded_file($uploadfile_temporal1)) 
    { 
        move_uploaded_file($uploadfile_temporal1,$uploadfile_nombre1); 
    } 
    else 
    { 
    echo "error"; 
    } 
}


        $query1 = mysqli_query($connect, "INSERT INTO agents(name, phone, email, picture, level) VALUES ('$agent_name','$phone', '$email', '$uploadfile_nombre1', '$level')") or die ('Error');


         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: myAccount.php?message=AgentSaved");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

      <link rel="icon" type="image/x-icon" href="icoplane.ico" />

    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Be+Vietnam&display=swap" rel="stylesheet">

<!-- Latim style -->
  <link rel="stylesheet" href="latimstyle.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body style="background:#b80008;">

    <center><img src="./img/logo.png" style="width:160px; margin-top:80px;"></center>
    <div class="wrapper" style="text-align:center; background:white; width:400px; position:relative; left:50%; margin-left:-200px; margin-top:60px;">

        <h4 style="font-weight:600; color:black;">Register a new agent </h2>
            <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">


            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="text" name="username" class="form-control" placeholder="E-mail" <?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group has-feedback" style="margin-top:0px;">
                <label>Name</label>
                <input name="agent_name" type="text" class="form-control" placeholder="Name" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" style="margin-top:0px;">
                <label>Phone</label>
                <input name="phone" type="text" class="form-control" placeholder="Phone" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" style="margin-top:0px;">
                <label>Agent Picture ↓</label>
                <input name="image" class="form-control" type="file">
                <span class="glyphicon glyphicon-picture form-control-feedback" style="position:absolute; top:22px;"></span>
            </div>

            <div class="input-group" style="margin-top:-3px;">
                <label>Agent View Level ↓</label>
                  <select name="level" class="form-control" style="width:320px;">
                      <option></option>
                      <option value="Seller">Seller</option>
                      <option value="Administrator">Administrator</option>
                    </select>
            </div>
            <br>


            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>



            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    

    <br><br>  <br><br>  
</body>
</html>