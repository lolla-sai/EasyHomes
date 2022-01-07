<?php
    function set_alert($message, $message_tag) {
        $_SESSION['messages'][] = "$message_tag-->$message";
    }
?>