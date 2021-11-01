<?php
    $displaymsg="";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gentium+Basic:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="./login.js" defer></script>
</head>
<body>
    <div class="auth_card">
        <div class="buttons">
            <button type="button" class="active">Login</button>
            <button type="button">Sign Up</button>
        </div>
        <div class="content">
            <?php
                    if($displaymsg!="")
                    {
                        ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errormsg; ?></div>
                        <?php
                    }
                ?>
            <form action="#" method="post" data-name="login">
                <input type="text" name="uname" id="uname" placeholder="Username">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="submit" value="Log in" name="Login">
            </form>
            <form action="#" method="post" data-name="signup" class="hidden">
                <input type="email" id="email" name="email_id" placeholder="Email">
                <input type="submit" value="Send OTP" name="send_otp">
                <input type="number" name="OTP" id="OTP" placeholder="OTP" disabled>
                <input type="submit" value="Verify OTP" id="OTP_BUTTON" name="verify_otp" disabled>
            </form>
        </div>
    </div>
    <?php
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;
            require 'PHPMailer-master/src/Exception.php';
            require 'PHPMailer-master/src/PHPMailer.php';
            require 'PHPMailer-master/src/SMTP.php';

            require 'vendor/autoload.php';

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "easyhomes";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $displaymsg="";
            


            if(!isset($_SESSION['email']))
            {
                session_start();
                $_SESSION['email_sent']=0;
            }
            
            if(!empty($_POST['send_otp']) /*&& $_SESSION['email_sent']==0*/)
            {
                $_SESSION['email']=$_POST['email_id'];
                $_SESSION['email_sent']=1;
                echo $_POST['email_id'];
                $otp=rand(100000,999999);
                $email=$_POST['email_id'];
                
                if ($conn->connect_error) {
                    echo "Error!";
                  }
                $sql = mysqli_query($conn,"INSERT INTO user_signin VALUES ('{$email}','{$otp}')");
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPKeepAlive = true; 
                $mail->Mailer='smtp';

                //$mail->SMTPDebug  = 1;  
                $mail->SMTPAuth   = TRUE;
                $mail->SMTPSecure = 'ssl'; 
                $mail->Port       = 465;
                $mail->Host       = 'smtp.gmail.com';
                
                $mail->Username='easyhomes878@gmail.com';
                $mail->Password='Dbmqpbuyhomes@788';
                $mail->IsHTML(true);
                $mail->AddAddress($email);
                $mail->SetFrom('easyhomes878@gmail.com', 'EasyHomes');
                $mail->Subject = "OTP Verification for EasyHomes";
                $content = "Hello, Greetings from the EasyHomes Team<br><br>The OTP for your Registration is: $otp<br><br>EasyHomes Team";
 
                $mail->MsgHTML($content); 
                $result=$mail->Send();
                if(!$result) {
                echo "Error while sending Email.";
                //var_dump($mail);
                } else {
                echo "Email sent successfully";
                echo "<script type='text/javascript'>document.getElementById('OTP').disabled=false;
                document.getElementById('OTP_BUTTON').disabled=false;</script>";
                }
     
            }
            if(!empty($_POST['verify_otp']))
            {
                echo "OTP Submitted is : {$_POST['OTP']}<br>";
                $email_for_otp=$_SESSION['email'];
                $sql=mysqli_query($conn,"SELECT * FROM `user_signin` WHERE email_id='{$email_for_otp}'");
                //echo $original_otp;
                $row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
                $n=mysqli_num_rows($sql);
                echo $n;
                echo $email_for_otp;
                if($email_for_otp==NULL)
                {
                    echo "NULL";
                }
                if($row['otp']==$_POST['OTP'])
                {
                    $sql=mysqli_query($conn,"DELETE FROM `user_signin` WHERE email_id='{$email_for_otp}'");
                    header('location:registerpage.php');
                }
            }
            if(!empty($_POST['Login']))
            {
                $uname=$_POST['uname'];
                $pass=$_POST['password'];

                if($uname=='easyhomesadmin')
                {
                    $getrow=mysqli_query($conn,"SELECT * FROM `admin` WHERE username='{$uname}'");
                    $row=mysqli_fetch_array($getrow,MYSQLI_ASSOC);
                    if(password_verify($pass,$row['password']))
                    {
                        header('location:admin.php');
                        $_SESSION['id']=$row['user_id'];
                        $_SESSION['fname']=$row['fname'];
                        $_SESSION['email']=$row['email_id'];
                    }
                    else
                    {
                        $displaymsg="Sorry Admin is not registered with us";
                    }
                }
                else
                {
                    $select=mysqli_query($conn,"SELECT * FROM `user` WHERE username='{$uname}'");
                    $n=mysqli_num_rows($select);
                    $row=mysqli_fetch_array($select,MYSQLI_ASSOC);
                    if($n==0)
                    {
                        $displaymsg="Sorry User is not registered with us";
                    }
                    if($row['username']==$uname && password_verify($pass,$row['password']))
                    {
                        $_SESSION['id']=$row['user_id'];
                        $_SESSION['fname']=$row['fname'];
                        $_SESSION['email']=$row['email_id'];
                        header('location:home.php');    
                    }
                    else if($row['username']==$uname)
                    {
                        $displaymsg="Password Incorrect";
                    }
                }
            }
        ?>
</body>
</html>
