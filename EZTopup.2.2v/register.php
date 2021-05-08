<?php 
	require_once "config.php";

    ini_set('display_errors',1);
    error_reporting(E_ALL);

    /*** THIS! ***/
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    /*** ^^^^^ ***/

	
	$username = $email = $phonenum = $password = $confirm_pass = "";
	$tempusername = $tempemail = $tempconfirmpass = "";
	$username_err = $email_err = $phonenum_err = $password_err = $confirm_password_err = "";
    $check ="";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$tempusername = trim($_POST["username"]);
		$tempemail = trim($_POST["email"]);
		$phonenum = trim($_POST["phonenum"]);
		$password = trim($_POST["password"]);
		$tempconfirmpass = trim($_POST["confirmpassword"]);

		//validate username
		if (empty($tempusername)){
            $username_err = "Please enter a name.";
        } 
        else {
        	$sql = "SELECT id FROM users WHERE name= ?";

        	if ($stmt = mysqli_prepare($link , $sql)) {
        		
        		mysqli_stmt_bind_param($stmt , "s",$param_username);

        		$param_username = $tempusername;

        		if (mysqli_stmt_execute($stmt)) {
        			mysqli_stmt_store_result($stmt);

        			if (mysqli_stmt_num_rows($stmt) == 1) {
        				$username_err = "This username is already taken.";
        			}
        			else {
        				$username = $tempusername;
        			}
        		}
        		else{
        			$check = "Oops! Something went  wrong. Please try again later.";
        		}
        	}

        }

        //validate email
        if (empty($tempemail)) {
        	$email_err= "Please enter an email.";
        }
        elseif (!filter_var($tempemail, FILTER_VALIDATE_EMAIL)) {
 			$email_err = "Invalid email format."; 
		}
        else{
        	$email = $tempemail;
        }

        //validate phone number
        if (empty($phonenum)){
            $phonenum_err = "Please enter a contact number.";
        }

        //validate password
        if (empty($password)) {
            $password_err = "Please enter a password.";
        }
        elseif (strlen(trim($password)) < 6){
            $password_err = "Password must have atleast 6 characters.";
        }

        //validate confirm password and match password
        if (empty($tempconfirmpass)) {
            $confirm_password_err = "Please enter a password.";
        }
        elseif ($tempconfirmpass == $password) {
            $confirm_password = $tempconfirmpass;
        }
        else{
            $confirm_password_err = "The password does not match.";
        }

        //validate error value b4 inserting into database
        if (empty($username_err) && empty($email_err) && empty($confirm_password_err)) {
        	
        	$sql = "INSERT into users ( name , password , email , phonenum ) values ( ? , ? , ? , ?)";

        	//sql statement inserted to database
            if ($stmt = mysqli_prepare($link, $sql)){
                //to transfer the information
                mysqli_stmt_bind_param($stmt,"ssss",$tran_user,$tran_pass,$tran_email,$tran_phonenum);

                //set the temp variable to the information
                $tran_user = $username;
                $tran_pass = password_hash( $confirm_password , PASSWORD_DEFAULT);
                $tran_email = $email;
                $tran_phonenum = $phonenum;

                //execute the insert information statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    header("location: login.php");
                    exit();
                } else{
                    $check = mysqli_stmt_error($stmt);
                }
            }else{
                    $check = "Something went wrong2. Please try again later.";
                }
            mysqli_stmt_close($stmt);
        }
    mysqli_close($link);
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register form</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
	<div class="boxx">
	<h1>Sign Up Here!!!<h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >

		<input type="text" name="username" placeholder="Username.." ><br>
		<span class="help-block"><?php echo $username_err; ?></span>

		<input type="email" name="email" placeholder="Email.." ><br>
		<span class="help-block"><?php echo $email_err; ?></span>

		<input type="tel" name="phonenum" placeholder="Phone Number.." ><br>
        <span class="help-block"><?php echo $phonenum_err; ?></span>

		<input type="password" name="password" placeholder="Password.." ><br>
		<span class="help-block"><?php echo $password_err; ?></span>

		<input type="password" name="confirmpassword" placeholder="Confirm Password.." ><br>
		<span class="help-block"><?php echo $confirm_password_err; ?></span>

		<input type="submit" placeholder="Submit" required>
        
	</form>
	</div>
	<div class="talk">
	<p>Already have an account? <a href="login.php">Sign in now</a>.</p>
    <span><?php echo $check; ?></span>
	</div>
</body>
</html>