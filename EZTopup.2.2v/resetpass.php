<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
ini_set('display_errors',1);
error_reporting(E_ALL);

/*** THIS! ***/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*** ^^^^^ ***/
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$check = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }else{
	        $check = mysqli_stmt_error($stmt);
	    }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password page</title>
        <link rel="stylesheet" href="css/resetpass.css">
    </head>
    
    <body>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="box"  method="post">
        <h1>RESET PASSWORD<h1>
        <div>
            <input type="password" name="new_password" placeholder="New Password..">
            <span class="help-block"><?php echo $new_password_err; ?></span>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="Confirm Password..">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <input type="submit" name="" value="reset">
        
    </form>
    <div class="below">
        <span><?php echo $check; ?></span>
    </div>
    </body>
    
</html>