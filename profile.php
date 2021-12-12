<?php
    session_start();
    echo "Welcome to your Profile Page ".$_SESSION['logged_name'];
?>
<html>
    <head>
        <title>
            Profile Page
        </title>
    </head>
    <body>
        <br><br>
        <a href="home.php">Back to Home Page</a>
    </body>
</html>