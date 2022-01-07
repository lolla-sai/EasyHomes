<?php
    require './components/runSQLQuery.php';
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    $getproperty=sql_query($conn,"SELECT property_id FROM interested GROUP BY property_id ORDER BY count(*) DESC LIMIT 3");
    while($property=$getproperty->fetch_assoc())
    {
        $pid=$property['property_id'];
        $getprop=sql_query($conn,"SELECT * FROM property WHERE property_id=$pid and category!='none'");
    }
?>