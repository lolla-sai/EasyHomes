<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Registered Users
        </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <style>
            li{
                padding: 2px;
            }
            li a{
                color: yellow;
                
            }
            li :hover a{
                color: yellow;
            }
            body{
                background-image: url('adminbg.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                min-height: 100vh;
            }
            div{
                min-width: max-content;
            }
        </style>
    </head>
    <body alink="yellow" vlink="yellow" link="yellow">
        <nav class="navbar" style="background-color: green;">
                    <ul class="navbar navbar-expand-lg" style="list-style-type: none;">
                        <li>
                        <a class="navbar-brand" href="#">EasyHomes Admin</a>
                        </li>
                        <li class="active"><a class="nav-link" href="admin.php">Admin Home</a></li>
                        <li><a class="nav-link" href="#">Registered Users</a></li>
                    </ul>
                    <form class="form-inline" action="#" method="POST">
                        <button class="navbar-btn" type="submit" name="logout" value="log">
                            <?php
                                    echo "Logout";
                                
                            ?>
                        </button>
                    </form>
                    <?php
                        if(!empty($_POST['logout']))
                        {
                            session_destroy();
                            header('location:home.php');
                        }

                    ?>
        </nav>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "easyhomes";
            $connection = mysqli_connect("localhost", "root", "", "easyhomes");

            $select=mysqli_query($connection,"SELECT * FROM `user`");
            $rows=mysqli_num_rows($select);
            if($rows>0)
            {
                while ($row = $select->fetch_assoc()) 
                {
                    ?>
                    <div class="container">
                        <div class="card-columns">
                            <div class="card bg-warning">
                                <div class="card-body text-center">
                                    <h1 class="card-title">
                                        <?php
                                            echo $row['fname']." ".$row['mname']." ".$row['lname']."<br>";
                                        ?>
                                    </h1>
                                    <p class="card-text">
                                        <?php
                                            echo "User ID: ".$row['user_id']."<br>";
                                            echo "Email ID: ".$row['email_id']."<br>";
                                            echo "Username: ".$row['username']."<br>";
                                            echo "Phone Number: ".$row['phone_number']."<br>";
                                            echo "Gender: ".$row['gender']."<br>";
                                            echo "Age: ".$row['age']."<br>";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                }
            }
            else
            {
                ?>
                <h1>
                    No Users Registered
                </h1>
                <?php
            }
        ?>
    </body>
</html>