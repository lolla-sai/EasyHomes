<?php
    session_start();
    if(!isset($_SESSION['logged_id']))
    {
        $_SESSION['from']="submit";
        header('location:index.php');
    }
    else
    {
        unset($_SESSION['from']);
        echo "Submit your details";
    }
?>