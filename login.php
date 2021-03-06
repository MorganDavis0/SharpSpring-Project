<?php
#This file handles logging into the site. We will assume you already have an account as per the instructions given.
#Include config file
require_once './dbconnect.php';
# Define variables and initialize with empty values
$username = $password = $role = "";
$username_err = $password_err = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Check if username is empty
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter username.';
    } 
    else {
        $username = trim($_POST["username"]);
    }

    # Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } 
    else {
        $password = trim($_POST['password']);
    }

    # Validate credentials
    if (empty($username_err) && empty($password_err)) {
        # Prepare a select statement
		$sql = "SELECT id, name, email, password, updated_at, created_at FROM users WHERE name = ?";
        if ($stmt = mysqli_prepare($bcmdev, $sql)) {
		# Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            # Set parameters
            $param_username = $username;

            # Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                # Store result
                mysqli_stmt_store_result($stmt);

                # Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    # Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password, $updated_at, $created_at);
                    if (mysqli_stmt_fetch($stmt)) {
			#password is the ones specified, confirmed to already be hashed. Password verify will check the original against the hash.
                        if (password_verify($password, $hashed_password)) {
                            # Password is correct, so start a new session and save the variables.
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['id'] = $id;
                            $_SESSION['password'] = $password;
			    #send user to website proper.
                            header("location: index.php");
                        } 
			else {
                            # Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } 
		else {
                    # Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } 
	    else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        # Close statement
        mysqli_stmt_close($stmt);
    }
}
#below is the html for this page. Just simple login page with text boxes and a button.
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <title>Login</title>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	    <style type="text/css">
		body{ font: 14px sans-serif;}
		.wrapper{ width: 350px; padding: 20px; margin-left: 40%;}
	    </style>
	</head>
	<body>
	    <div class="wrapper">
		<h2>Login</h2>
		<p>Please fill in your credentials to login.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
			<label>Username:<sup>*</sup></label>
			<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
			<span class="help-block"><?php echo $username_err; ?></span>
		    </div>    
		    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
			<label>Password:<sup>*</sup></label>
			<input type="password" name="password" class="form-control">
			<span class="help-block"><?php echo $password_err; ?></span>
		    </div>
		    <div class="form-group">
			<input type="submit" class="btn btn-primary" value="Submit">
		    </div>
		    <p>Don't have an account? Contact your administrator.</p>
		</form>
	    </div>    
	</body>
</html>
