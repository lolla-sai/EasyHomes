<?php
    $errormsg = "";
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "easyhomes";
            $connection = mysqli_connect("localhost", "root", "", "easyhomes");
                if($_SERVER['REQUEST_METHOD']=="POST"){
                    //echo "post triggered";
                    if(!empty($_POST['submit']))
                    {
                        //echo "Submitted";
                        //$connection = mysqli_connect("localhost", "root", "", "easyhomes");

                        $fname=$_POST['fname'];
                        $mname=$_POST['mname'];
                        $lname=$_POST['lname'];
                        $age=$_POST['age'];
                        $email_id=$_POST['email_id'];
                        $uname=$_POST['uname'];
                        $pass=$_POST['password'];
                        $hashpass=password_hash($pass,PASSWORD_DEFAULT);
                        $g=$_POST['gender'];
                        $ph_no=$_POST['phno'];
                        //echo $fname,$mname,$lname,$email_id,$g;
                        //$img=$_FILES['image']['name'];
                        $flag=0;

                        A:
                        $user_id=rand(100000,999999);
                        
                        /*$sql=mysqli_query($connection,"SELECT * FROM `user`");
                        if(mysqli_num_rows($sql)>0)
                        {
                            while ($row = $sql->fetch_assoc()) 
                            {
                                if($row['user_id']==$user_id)
                                {
                                    goto A;
                                }
                            }
                        }*/

                        $sql=mysqli_query($connection,"SELECT * FROM `user`");
                        if(mysqli_num_rows($sql)>=0)
                        {
                            //echo "Inside if";
                            if(mysqli_num_rows($sql)!=0)
                            {
                                while ($row = $sql->fetch_assoc()) 
                                {
                                    if($row['email_id']==$_POST['email_id'])
                                    {
                                        $errormsg="Email ID is already linked to another account";
                                        $flag=1;
                                    }
                                    else if($row['username']==$_POST['uname'])
                                    {
                                        $errormsg="Username is already taken";
                                        $flag=1;
                                    }
                                    else if($row['password']==$_POST['password'])
                                    {
                                        $errormsg="Password taken";
                                        $flag=1;
                                    }
                                }
                            }
                            if($flag==0)
                            {
                                //echo "if";
                                $insert = mysqli_query($connection,"INSERT INTO `user` VALUES('$user_id','{$fname}','{$mname}','{$lname}','$age','{$g}','{$email_id}','$ph_no','{$uname}','{$hashpass}')");
                                //move_uploaded_file($_FILES["image"]["tmp_name"],"upload/".basename($_FILES["image"]["name"]));
                                session_start();
                                $_SESSION['fname']=$fname;
                                $_SESSION['id']=$user_id;
                                $_SESSION['email']=$email_id;
                                header('location:home.php');
                            }
                            else
                            {
                                //echo "Inside else";
                            }
                        }
                        

                    }
                }
                //echo "Outisde submit";

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <style>
            input{
                border-spacing: 10px;
            }
        </style>
    </head>
        <body>
            <div class="container p-5 my-5 border">
                <?php
                    if($errormsg!="")
                    {
                        ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errormsg; ?></div>
                        <?php
                    }
                ?>
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" >
                First Name:
                <input type="text" name="fname" required >
                <br>
                Middle Name: 
                <input type="text" name="mname" required>
                <br>
                Last Name:
                <input type="text" name="lname" required>
                <br>
                Age:
                <input type="number" name="age" required>
                <br>
                Email ID:
                <input type="email" name="email_id" required>
                <br>
                Username: 
                <input type="text" name="uname" required>
                <br>
                Password:
                <input type="password" name="password" required>
                <br>
                Gender:
                <br>
                Male:
                <input type="radio" name="gender" value="M" required>
                Female: 
                <input type="radio" name="gender" value="F" required>
                Other:
                <input type="radio" name="gender" value="O" required>
                <br>
                Phone Number: 
                <input type="number" name="phno" required>
                <br>
                User Image: 
                <input type="file" name="image" disabled>
                <br>
                 <input type="submit" name="submit" value="Submit">
            </form>
            </div>
        </body>
</html>