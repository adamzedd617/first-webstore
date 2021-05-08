<?php 	

	session_start();
 
	// Check if the user is already logged in, if yes then redirect him to welcome page
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	  header("location: index.php");
	  exit;
	}

	require_once "config.php";
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	/*** THIS! ***/
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	/*** ^^^^^ ***/
	$username = $password ="";
	$username_err = $password_err ="";
	$check = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST"){

		if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    	} else{
        $username = trim($_POST["username"]);
    	}

		if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
   		} else{
        $password = trim($_POST["password"]);
    	}
	
	if(empty($username_err) && empty($password_err)){
		$sql = "SELECT id, name, password FROM users WHERE name = ?";

		if($stmt = mysqli_prepare($link, $sql)){
	            // Bind variables to the prepared statement as parameters
	            mysqli_stmt_bind_param($stmt, "s", $param_username);
	            
	            // Set parameters
	            $param_username = $username;
	            
	            // Attempt to execute the prepared statement
	            if(mysqli_stmt_execute($stmt)){
	                // Store result
	                mysqli_stmt_store_result($stmt);
	                
	                // Check if username exists, if yes then verify password
	                if(mysqli_stmt_num_rows($stmt) == 1){                    
	                    // Bind result variables
	                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

	                    if(mysqli_stmt_fetch($stmt)){

	                        if(password_verify( $password , $hashed_password)){
	                            // Password is correct, so start a new session
	                            session_start();
	                            
	                            // Store data in session variables
	                            $_SESSION["loggedin"] = true;
	                            $_SESSION["id"] = $id;
	                            $_SESSION["name"] = $username;                            
	                            
	                            // Redirect user to welcome page
	                            header("location: index.php");
	                        } else{
	                            // Display an error message if password is not valid
	                            $password_err = "The password you entered was not valid.";
	                        }
	                    }
	                } else{
	                    // Display an error message if username doesn't exist
	                    $username_err = "No account found with that username.";
	                }
	            } else{
	                $check = mysqli_stmt_error($stmt);
	            }
	    }
	    mysqli_stmt_close($stmt);
	}
}
	mysqli_close($link);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login page</title>
		<link rel="stylesheet" href="css/login.css">
	</head>
	
	<body>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="box"  method="post">
		<h1>LOGIN<h1>
		<div>
			<input type="text" name="username" placeholder="username">
			<span class="help-block"><?php echo $username_err; ?></span>
		</div>
		<div>
			<input type="password" name="password" placeholder="password">
			<span class="help-block"><?php echo $password_err; ?></span>
		</div>
		<input type="submit" name="" value="login">
		
	</form>
	<div class="below">
		<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
		<span><?php echo $check; ?></span>
	</div>
	</body>
	
</html>