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
        $mail->Subject = $subject;

        $mail->MsgHTML($content);
        $result=$mail->Send();
        return $result;
    }
?>