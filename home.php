<?php

    session_start();
    
    if(isset($_SESSION['id']))
    {
        $displaymsg="Welcome ".$_SESSION['fname'];
    }
    else
    {
        $displaymsg="Welcome User";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home | EasyHomes</title>
        <link rel="shortcut icon" href="houseicon.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar" style="background-color: black;">
                <ul class="nav navbar-nav">
                    <li>
                    <a class="navbar-brand" href="#">EasyHomes</a>
                    </li>
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Buy</a></li>
                    <li><a href="#">Sell</a></li>
                    <li><a href="#">Rent</a></li>
                </ul>
                <form class="form-inline" action="#" method="POST">
                    <button class="navbar-btn" type="submit" name="log" value="log">
                        <?php
                            if(isset($_SESSION['id']))
                            {
                                echo "Logout";
                            }
                            else
                            {
                                echo "Login";
                            }
                        ?>
                    </button>
                </form>
        </nav>
        <?php
            if(!empty($_POST['log']))
            {
                if(isset($_SESSION['id']))
                {
                    session_destroy();
                    header('location:home.php');
                }
                else
                {
                    header('location:index.php');
                }
            }
        ?>
        <div style="background-color: lightskyblue; border-radius: 5px; ">
            <h1>EasyHomes</h1>
        </div>
        <h1>
            <?php
                echo $displaymsg;
            ?>
        </h1>
        

    </body>
</html>