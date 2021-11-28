<!DOCTYPE html>
<html>
    <head>
        <title>
            Admin Page
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <style>
        body{
                background-image: url('adminbg.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                height: 100%;
                min-height: 100vh;
            }
        li{
            list-style-type: none;
            padding: 5px;
        }
    </style>
    <body>
        <nav class="navbar" style="background-color: black;">
                <ul class="navbar navbar-expand-lg">
                    <li>
                    <a class="navbar-brand" href="#">EasyHomes Admin</a>
                    </li>
                    <li class="active"><a class="card-link" href="#">Admin Home</a></li>
                    <li><a class="card-link" href="adminusers.php">Registered Users</a></li>
                </ul>
                <form class="form-inline" action="#" method="POST">
                    <button class="navbar-btn" type="submit" name="logout" value="log">
                        <?php
                                echo "Logout";
                            
                        ?>
                    </button>
                </form>
        </nav>
        <?php
            session_start();
            if(!empty($_POST['logout']))
            {
                session_destroy();
                header('location:home.php');
            }

        ?>
    </body>
</html>