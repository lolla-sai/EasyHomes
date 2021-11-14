<?php
    require 'sendmail.php';
    // require 'connect_db.php';

    $conn = mysqli_connect("localhost", "root", "", "easyhomessai", 3306);
    if($conn->connect_error) {
        exit_own("Database Connection Failed", "danger");
    }

    if(!empty($_POST['send_otp']) /*&& $_SESSION['email_sent']==0*/)
    {
        $d = strtotime("+10 minutes");
        $expire = date("Y-m-d H:i:s", $d);
        $email=$_POST['email_id'];
        $_SESSION['email'] = filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL);
        if(!$_SESSION['email']) {
            exit_own("Invalid Email Entered!", "danger");
        }

        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(!$sql) die(mysqli_error($conn));
        if(mysqli_num_rows($sql)) {
            unset($_SESSION['email']);
            exit_own("User with the same email already exists!! Login Instead!", "danger");
        }

        $otp = rand(100000,999999);
        $subject = "OTP Verification for Easy Homes";
        $content = "Hello, Greetings from the EasyHomes Team!<br><br>The OTP for your Registration is: $otp. Please keep this confidential!!<br><br>This OTP will expire on: $expire <br><br>Cheers, <br>EasyHomes Team<br>";
        // print_r($_SESSION);

        $sql = mysqli_query($conn,"DELETE FROM otp_table WHERE email = '$email'"); // delete old otp's for the same email
        if(!$sql) exit_own(mysqli_error($conn), "danger");
        $sql = mysqli_query($conn, "INSERT INTO otp_table VALUES ($otp, '$email', '$expire')"); // insert new otp for the given email
        if(!$sql) exit_own(mysqli_error($conn), "danger");

        $result = send_mail('easyhomes878@gmail.com', 'EasyHomes', 'Dbmqpbuyhomes@788', $email, $subject, $content);
        
        if(!$result) {
            exit_own("Error while sending Email", "danger");
        }
        else {
            // $_SESSION['email_sent'] += 1;
            echo "<script src='enableotp.js' defer></script>";
            exit_own("Email sent successfully", "success", false);
        }
    }

    if(!empty($_POST['verify_otp']))
    {
        if(!isset($_SESSION['email']) or !$_SESSION['email'])
        {
            exit_own("Session Dead, enter the email again", "danger");
        }
        $email_for_otp = $_SESSION['email'];
        $now = date("Y-m-d H:i:s");
        $sql=mysqli_query($conn,"SELECT * FROM otp_table WHERE email='{$email_for_otp}' and expire>'$now'");
        // echo mysqli_error($conn);
        if(!$sql) exit_own(mysqli_error($conn), "danger");
        $row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
        // echo $row;
        // foreach ($row as $key => $value) {
        //     echo "$key=>$value<br>";
        // }
        // print_r($_POST); echo "<br>";
        $n=mysqli_num_rows($sql);
        // echo $n;
        // echo $email_for_otp;
        // echo $row['otp'] . "<br>";
        // echo $_POST['OTP'] . "<br>";
        if($row['otp']==$_POST['OTP'])
        {
            // echo "OTP Verified";
            $sql=mysqli_query($conn,"DELETE FROM otp_table WHERE email_id='{$email_for_otp}'");
            // echo "Email Verified";
            if(mysqli_error($conn)) {
                exit_own(mysqli_error($conn), "danger");
            }
            exit_own("OTP Verified", "success", false, false);
            // $_SESSION['messages'][] = "success-->Email Verified";
            header('location:registerpage.php');
            // echo "<script>window.location = 'http://localhost/EasyHomesSai/'.href+'/registerpage.php'</script>";
        }
        else {
            session_destroy();
            exit_own("Invalid OTP!", "danger");
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
                exit_own("Sorry User is not registered with us!", "info");
                // die("Sorry User is not registered with us");
            }
            if($row['username']==$uname && password_verify($pass,$row['password']))
            {
                $_SESSION['logged_id']=$row['user_id'];
                $_SESSION['logged_name']=$row['name'];
                $username = $_SESSION['logged_name'];
                // $_SESSION['age']=$row['age'];
                // $_SESSION['dp']=$row['dp'];
                $_SESSION['logged_email']=$row['email'];
                // $_SESSION['gender']=$row['gender'];
                $_SESSION['logged_username']=$row['username'];
                exit_own("Welcome $username", "success", false, false);
                header('location:home.php');
                // $_SESSION['phone_number']=$row['phone_number'];
            }
            else if($row['username']==$uname)
            {
                exit_own("Invalid Credentials", "danger", false);
            }
        }
    }

    // insert into users (name, age, email) values ('Sasi Lolla', 17, 'saisasanklolla@gmail.com');
?>