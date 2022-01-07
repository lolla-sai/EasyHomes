<?php
    require './runSQLQuery.php';
    function filterbyprice($conn,$min=0,$max=100000000)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and property_id IN (SELECT property_id from sale_price WHERE price BETWEEN $min AND $max)");
        return $result;
    }

    function filterbyrentprice($conn,$min=0,$max=100000000)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and property_id IN (SELECT property_id from rent_price WHERE rprice BETWEEN $min AND $max)");
        return $result;
    }

    function filterbycategory($conn,$category)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category='$category'");
        return $result;
    }

    function filtergetflats($conn)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and property_id IN (SELECT property_id FROM flat)");
        return $result;
    }
    
    function filtergethouse($conn)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and property_id IN (SELECT property_id FROM house)");
        return $result;
    }

    function filtergetplot($conn)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and property_id IN (SELECT property_id FROM plot)");
        return $result;
    }

    function filterbyarea($conn,$min_area=0,$max_area=10000)
    {
        $result=sql_query($conn,"SELECT * FROM property WHERE category!='none' and area BETWEEN $min_area AND $max_area");
        return $result;
    }




?>