<?php
    function clean_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
?>