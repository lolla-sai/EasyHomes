<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/SMTP.php';
    require 'vendor/autoload.php';
    date_default_timezone_set("Asia/Kolkata");

    function send_mail($sender_email_id, $sender_name, $sender_email_password, $receiver_email_id, $subject, $content) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPKeepAlive = true; 
        $mail->Mailer='smtp';

        //$mail->SMTPDebug  = 1;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port       = 465;
        $mail->Host       = 'smtp.gmail.com';
        
        // $mail->Username='yummycreation61@gmail.com';
        // $mail->Password='YummyCre@tion61';
        // $mail->Username='easyhomes878@gmail.com';
        // $mail->Password='Dbmqpbuyhomes@788';
        $mail->Username=$sender_email_id;
        $mail->Password=$sender_email_password;

        $mail->IsHTML(true);
        $mail->AddAddress($receiver_email_id);
        $mail->SetFrom($sender_email_id, $sender_name);
        // $mail->Subject = "OTP Verification for Easy Homes";
        $mail->Subject = $subject;
        // $content = "Hello, Greetings from the EasyHomes Team!<br><br>The OTP for your Registration is: $otp<br><br>Yours, <br>EasyHomes Team<br>";

        $mail->MsgHTML($content);
        $result=$mail->Send();
        return $result;
    }

    function exit_own($message, $message_tag, $reload=true, $die=true) {
        $_SESSION['messages'][] = "$message_tag-->$message";
        if($reload)
            echo "<script>window.location = window.location.href;</script>";
        // header('location:reload')
        // if($die)
        //     die("");
    }
?>


<!-- 
+---------+-----------+-----+--------------------------------------+---------------------------+--------+-----------+--------------+--------------------------------------------------------------+
| user_id | name      | age | dp                                   | email                     | gender | username  | phone_number | password                                                     |
+---------+-----------+-----+--------------------------------------+---------------------------+--------+-----------+--------------+--------------------------------------------------------------+
|       5 | Sai Lolla |  20 | media/lolla-sai/dp20211110160144.jpg | saisameer.lolla@gmail.com |      1 | lolla-sai | 9404181639   | $2y$10$wnYmdHqSc5O9NsWccB50Re./mfbTx1lhlDwS2P.Rb3nPGaOv2hDli |
+---------+-----------+-----+--------------------------------------+---------------------------+--------+-----------+--------------+--------------------------------------------------------------+
1 row in set (0.00 sec) -->