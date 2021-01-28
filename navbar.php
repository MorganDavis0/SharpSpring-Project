<?php
#this file is used to make a navbar for the website. Helps the user navigate and such.
?>
<!DOCTYPE html>
    <html>
        <body>
            <nav class="topnav">
                <a href="logout.php" style="background-color:red; float:right">Log Out</a>
				<a href="newnote.php" style="background-color:grey; float:right">+New Note</a>
				<a href="index.php" style="background-color:grey; float:left">Home</a>
                <div style="float: right;">
                    <div style="position: center; color: white; padding: 14px;"><strong>Welcome, <?php print $_SESSION["username"]; ?></strong></div>
                </div>
            </nav>
        </body>
    </html>
