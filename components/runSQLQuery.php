<?php
    function sql_query($conn, $sql, $return_last_id=false) {
        $sql = mysqli_query($conn, $sql);
        if($return_last_id)
            return mysqli_insert_id($conn);
        if(mysqli_error($conn)) {
            set_alert(mysqli_error($conn), "danger");
            return false;
        }
        return $sql;
    }
?>