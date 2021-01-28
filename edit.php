<?php
#this page handles editing and deleting notes. This page unfortunately isn't functional. I do not know why, but I could not get mysql queries to work on this page. I do not know why. 
# Initialize the session like the others. Included the navbar up here this time.
session_start();
require_once './navbar.php';
require_once './dbconnect.php';
$title = $note = "";
$title_err = $note_err = "";

# If session variable is not set it will redirect to login page
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
# this is a function to delete the current entry. I have it commented out. as this page isn't correctly implemented. Essentially it would delete the current note based on the noteid in the table. No checking if title and note are filled in here, just delete by id.
/*function deleteEntry(){
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$sql="DELETE FROM notes WHERE noteid=?";
		if ($stmt = mysqli_prepare($bcmdev, $sql)) {
			#if ($stmt = $bcmdev -> prepare("select * from users where name = ?")){
			# Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "i", $var);
			if (mysqli_stmt_execute($stmt)) {
				# Store result
				$stmt->close();
				header("location: index.php");
			}
		}
	}
}*/
#down here are some of my attempts to fix the query issue on this page. I don't think I left every attempt unfortunately. 
/*mysqli_close($bcmdev);
$servername="127.0.0.1";
$username="root";
$password="root";
#establish connection
$bcmdev=new mysqli($servername,$username,$password);
$bcmdev = mysqli_connect($servername, $username, $password, "c1");
if ($bcmdev->connect_error){
		die("Connection Failed: " . $bcmdev->connect_error);
}*/
#get's the value passed in by the index page.
if(isset($_GET['value_key'])){
  $var = intval($_GET['value_key']); #some_value
  #I'll Leave my debugging in for you to see if you like. 
  echo $var;
  
}
#prepare the sql statement that doesn't work. Can't find out why.
$sql = "SELECT *  FROM notes WHERE 'noteid' = ?";
#$sql = "SELECT * FROM notes";
if ($stmt = mysqli_prepare($bcmdev, $sql)) {
	mysqli_stmt_bind_param($stmt, "i", $var);
	#print(strval($stmt));
	#mysqli_stmt_bind_param($stmt, "i", 6);
	if (mysqli_stmt_execute($stmt)) {
		#print(mysqli_stmt_error($stmt));
		$result=mysqli_stmt_get_result($stmt);
		print(mysqli_stmt_num_rows($stmt));
		if (mysqli_stmt_num_rows($stmt) >= 1) {
			mysqli_stmt_bind_result($stmt, $uid, $nid, $title, $note, $created_on);
			mysqli_stmt_fetch($stmt);
			$notesRow=mysqli_fetch_assoc($result);
		}
		else{
			$note_err="no notes to retrieve.";
		}
		#$notesRow=mysqli_fetch_assoc($result);
	}
}
/*$result=$bcmdev->query($sql);
$notesRow=$result->fetch_assoc();
#print($notesRow);*/
#the html for the page is below. Sets up boxes and buttons currently. 
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
    </head>
	<body>
		<div class="Center">
            	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>Title:<sup>*</sup></label>
                    <input type="text" name="title" style="width: 500px;" class="form-control" value="<?php echo $title; ?>">
                    <span class="help-block"><?php echo $title_err; ?><?php $notesRow["title"]?></span>
                </div>
                <div class="form-group <?php echo (!empty($note_err)) ? 'has-error' : ''; ?>">
                    <label>Note:<sup>*</sup></label>
                    <input type="text" name="note" style="width: 500px;" class="form-control" value="<?php echo $note; ?>">
                    <span class="help-block"><?php echo $note_err; ?><?php $notesRow["title"]?></span>
                </div>
		<div id="container">
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Submit" onclick='document.getElementById("title").value=""; document.getElementById("note").value="";'>
				<input type="submit" class="btn btn-primary" value="Delete" onclick='document.getElementById("title").value=""; document.getElementById("note").value=""; deleteEntry();'>
			</div>
		</div>
            	</form>
        	</div>
		<?php
			#more php. I put this section down here after the buttons. This section will handle the submit button. This one is more in line with the submit button on other pages.
			/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
				echo "inside first if.";
				# Check if title is empty
				if (empty(trim($_POST['title']))) {
					$title_err = 'Please enter title.';
					echo "inside empty title if.";
				} 
				else {
					$title = trim($_POST["title"]);
					echo "inside title else.";
				}

				# Check if note is empty
				if (empty(trim($_POST['note']))) {
					$note_err = 'Please enter your note.';
				} 
				else {
					$note = trim($_POST['note']);
					echo "inside empty note else.";
				}
				
				if (empty($title_err) && empty($note_err)) {
					#$user_id=$_SESSION["id"];
					#setup an update query instead of select or insert.
					$sql="UPDATE notes SET title=?, note=? WHERE noteid=?";
					if ($stmt = mysqli_prepare($bcmdev, $sql)) {
						#if ($stmt = $bcmdev -> prepare("select * from users where name = ?")){
						# Bind variables to the prepared statement as parameters
						echo "inside the mysqli prepare statement.";
						mysqli_stmt_bind_param($stmt, "ssi", $title, $note, $var);
						if (mysqli_stmt_execute($stmt)) {
							# Store result
							echo "inside statement exec if.";
							mysqli_stmt_store_result($stmt);
							echo "<meta http-equiv='refresh' content='0'>";
							$stmt->close();
						}
					}
				}
			}*/
		?>
	</body>
</html>
