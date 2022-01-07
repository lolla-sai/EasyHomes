<?php
    session_start();
    require './components/bootstrapcss.php';
?>
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
    </style>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./media/icons8-home-240.png" alt="Home Icon" width="30" height="24" class="d-inline-block align-text-top">
                    EasyHomes Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Admin Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="adminusers.php">Registered Users</a>
                        </li>
                        <div class="dropdown profile">
                                <div class="d-flex" data-bs-toggle="dropdown">
                                <a class="nav-link dropdown-toggle" role="button" id="pmDropdownLink">Packers and Movers</a>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="pmrequests.php">Check Requests</a></li>
                                    <li><a class="dropdown-item" href="pmedit.php">Edit Category</a></li>
                                </ul>
                        </div>
                    </ul>
                    <form action="logout.php" method="POST">
                        <button class="btn btn-primary" name="logout" value="logout" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <?php
            if(!empty($_POST['logout']))
            {
                session_destroy();
                header('location:home.php');
            }

        ?>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>