<?php
#This is the page for the note display.
#Initialize the session
session_start();
require_once './dbconnect.php';
$note_err="";

# If session variable is not set it will redirect to login page
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
#setup the select statement to populate notes. If there are no notes, non will be populated as per the while loop below.
$sql = "SELECT userid, noteid, title, note, created_on FROM notes WHERE userid = ?";
if ($stmt = mysqli_prepare($bcmdev, $sql)) {
	mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
	if (mysqli_stmt_execute($stmt)) {
		$result=mysqli_stmt_get_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >= 1) {
		}
		else{
			$note_err="no notes to retrieve.";
		}
	}
}
#below is the html for this page. I wish it looked better, but I'm not well versed in html. The html below creates the welcome message, includes the navbar, and populates the notes using a while loop so we have as many boxes as notes for that user. I decided to have the notes click-able, and doing so will take you tot he edit page that isn't functional.
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="https:#maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="stylesheet.css" rel="stylesheet" type="text/css">
        <style>
            body{ font: 14px sans-serif; }
            .wrappera{ width: 350px; padding: 20px; float: left;}
            .wrapperb{ width: 40%; padding: 20px; float: left;}
            .parentwrapa {margin: auto; width: 700px;}
            .parentwrapb {margin-left: 10%; width: 100%; clear: both;}
        </style>
		<style>
			.city {
			  color: black;
			  border: 5px solid black;
			  margin: 20px;
			  padding: 20px;
			  width: 800px;
			  height: 300px;
			  margin-left: 400px;
			}
		</style>
    </head>
    <body>
	
	<script>
		function winOpen() {
			var myWindow = window.open("", "MsgWindow", "width=500,height=500,resizable");
			myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
		}
	</script>

        <?php
        include_once 'navbar.php';
        ?>

        <div class="content">
            <h1>Your Notes. Click on a note to edit or Delete.</h1>
        </div>
		<?php
			while($notesRow=mysqli_fetch_assoc($result)){
			$var=$notesRow["noteid"];
			#while ($stmt->fetch()){
				#print($notesRow);
		?>
			<a href="edit.php?value_key=<?php print($var);?>">
				<div class=city>
					<fieldset>
						<legend style="background-color: grey; color: white;"><?php print($notesRow["title"]); print(" (created by {$_SESSION["username"]} on {$notesRow["created_on"]})"); ?></legend>
						<h2><?php print($notesRow["note"]);?></h2>
					</fieldset>
				</div>
			</a>
		<?php
			}
			$stmt->close();
			mysqli_free_result($result);
		?>
    </body>
</html>