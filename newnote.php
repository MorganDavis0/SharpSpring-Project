<?php
#This page is use to create notes. Start by starting the session and requiring the dbconnect like the rest
session_start();
require_once './dbconnect.php';

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
#Set these variables.
$title = $note = "";
$title_err = $note_err = "";
#when the submit button is pressed, check that a title and note were entered. 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title is empty
    if (empty(trim($_POST['title']))) {
        $title_err = 'Please enter title.';
    } 
	else {
        $title = trim($_POST["title"]);
    }

    // Check if note is empty
    if (empty(trim($_POST['note']))) {
        $note_err = 'Please enter your note.';
    } 
	else {
        $note = trim($_POST['note']);
    }
	#as long as both the title and note are there, move forward and prepare the sql statement and variables.
	if (empty($title_err) && empty($note_err)) {
		$user_id=$_SESSION["id"];
		$created_on=date('l jS \of F Y');
		$sql="INSERT INTO notes (userid, title, note, created_on) VALUES(?, ?, ?, ?)";
		#prepare the statement
		if ($stmt = mysqli_prepare($bcmdev, $sql)) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "isss", $user_id, $title, $note, $created_on);
			if (mysqli_stmt_execute($stmt)) {
				#if it executes correctly, refresh the page and close the statement.
				echo "<meta http-equiv='refresh' content='0'>";
				$stmt->close();
			}
		}
	}
}
#the html for the page is below and it does the following: includes the navbar, gives the user some instruction, creates the text boxes, and creates the button. The boxes are very similar to the login pages boxes i think. Not pretty though. I'd have liked to ahve made the note box bigger so you could see all of your note at once.
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="stylesheet.css" rel="stylesheet" type="text/css">
        <style>
            body{ font: 14px sans-serif; }
            .wrappera{ width: 350px; padding: 20px; float: left;}
            .wrapperb{ width: 40%; padding: 20px; float: left;}
            .parentwrapa {margin: auto; width: 700px;}
            .parentwrapb {margin-left: 10%; width: 100%; clear: both;}
        </style>
    </head>
    <body>

        <?php
        include_once 'navbar.php';
        ?>
		
		<div class="content">
            <h1>Please fill out the following fields</h1>
        </div>
	</body>
    <body>
		<style>
			.Center { 
            width:500px; 
            height:500px; 
            position: fixed;  
            top: 30%; 
            left: 50%; 
            margin-top: -100px; 
            margin-left: -250px; 
        }
		</style>
        <div class="Center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>Title:<sup>*</sup></label>
                    <input type="text" name="title" style="width: 500px;" class="form-control" value="<?php echo $title; ?>">
                    <span class="help-block"><?php echo $title_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($note_err)) ? 'has-error' : ''; ?>">
                    <label>Note:<sup>*</sup></label>
                    <input type="text" name="note" style="width: 500px;" class="form-control" value="<?php echo $note; ?>">
                    <span class="help-block"><?php echo $note_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" onclick='document.getElementById("title").value=""; document.getElementById("note").value="";'>
                </div>
            </form>
        </div>
    </body>
</html>