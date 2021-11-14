<?php
    require 'sendmail.php';
    // require 'connect_db.php';

    $conn = mysqli_connect("localhost", "root", "", "easyhomessai", 3306);
    if($conn->connect_error) {
        set_alert("Database Connection Failed", "danger");
        goto endpoint;
    }

    if(!empty($_POST['send_otp']))
    {
        $d = strtotime("+10 minutes");
        $expire = date("Y-m-d H:i:s", $d);
        $email=$_POST['email_id'];
        $_SESSION['email'] = filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL);
        if(!$_SESSION['email']) {
            set_alert("Invalid Email Entered!", "danger");
            goto endpoint;
        }

        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(!$sql) set_alert(mysqli_error($conn), 'danger', true);
        if(mysqli_num_rows($sql)) {
            unset($_SESSION['email']);
            set_alert("User with the same email already exists!! Login Instead!", "danger");
            goto endpoint;
        }

        $otp = rand(100000,999999);
        $subject = "OTP Verification for Easy Homes";
        $content = "Hello, Greetings from the EasyHomes Team!<br><br>The OTP for your Registration is: $otp. Please keep this confidential!!<br><br>This OTP will expire on: $expire <br><br>Cheers, <br>EasyHomes Team<br>";
        // print_r($_SESSION);

        $sql = mysqli_query($conn,"DELETE FROM otp_table WHERE email = '$email'"); // delete old otp's for the same email
        if(!$sql){ 
            set_alert(mysqli_error($conn), "danger");
            goto endpoint;
        }
        $sql = mysqli_query($conn, "INSERT INTO otp_table VALUES ($otp, '$email', '$expire')"); // insert new otp for the given email
        if(!$sql){ 
            set_alert(mysqli_error($conn), "danger");
            goto endpoint;
        }

        $result = send_mail('easyhomes878@gmail.com', 'EasyHomes', 'Dbmqpbuyhomes@788', $email, $subject, $content);
        
        if(!$result) {
            set_alert("Error while sending Email", "danger");
            goto endpoint;
        }
        else {
            // $_SESSION['email_sent'] += 1;
            echo "<script src='enableotp.js' defer></script>";
            set_alert("Email sent successfully", "success");
        }
    }

    if(!empty($_POST['verify_otp']))
    {
        if(!isset($_SESSION['email']) or !$_SESSION['email'])
        {
            set_alert("Session Dead, enter the email again", "danger");
            goto endpoint;
        }
        $email_for_otp = $_SESSION['email'];
        $now = date("Y-m-d H:i:s");
        $sql=mysqli_query($conn,"SELECT * FROM otp_table WHERE email='{$email_for_otp}' and expire>'$now'");
        if(!$sql){
            set_alert(mysqli_error($conn), "danger");
            goto endpoint;
        }
        $row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
        $n=mysqli_num_rows($sql);
        if($row['otp']==$_POST['OTP'])
        {
            $sql=mysqli_query($conn,"DELETE FROM otp_table WHERE email='{$email_for_otp}'");
            if(mysqli_error($conn)) {
                set_alert(mysqli_error($conn), "danger");
                goto endpoint;
            }
            set_alert("OTP Verified", "success");
            header('location:registerpage.php');
        }
        else {
            session_destroy();
            session_start();
            $_SESSION['messages'] = array();
            set_alert("Invalid OTP!", "danger");
            goto endpoint;
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
                $_SESSION['logged_id']=$row['user_id'];
                $_SESSION['logged_name']=$row['name'];
                $_SESSION['logged_email']=$row['email'];
            }
            else
            {
                $displaymsg="Sorry Admin is not registered with us";
            }
        }
        else
        {
            $select=mysqli_query($conn,"SELECT * FROM `users` WHERE username='{$uname}'");
            $n=mysqli_num_rows($select);
            $row=mysqli_fetch_array($select,MYSQLI_ASSOC);
            if($n==0)
            {
                set_alert("User is not registered with us!", "info");
                goto endpoint;
            }
            if($row['username']==$uname && password_verify($pass,$row['password']))
            {
                $_SESSION['logged_id']=$row['user_id'];
                $_SESSION['logged_name']=$row['name'];
                $username = $_SESSION['logged_name'];
                $_SESSION['logged_email']=$row['email'];
                $_SESSION['logged_username']=$row['username'];
                set_alert("Welcome $username", "success");
                header('location:home.php');
            }
            else if($row['username']==$uname)
            {
                set_alert("Invalid Credentials", "danger");
            }
        }
    }
    endpoint:
?>