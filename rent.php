<?php
    session_start();
    if(!isset($_SESSION['logged_id']))
    {
        $_SESSION['from']="rent";
        header('location:index.php');
    }
    else
    {
        unset($_SESSION['from']);
    }
?>