<?php
require './components/runSQLQuery.php';
    session_start();
    if(!isset($_SESSION['logged_id']))
    {
        $_SESSION['from']="rent";
        header('location:index.php');
    }
    else
    {
        unset($_SESSION['from']);
        $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);

        $user_id=$_SESSION['logged_id'];
        $pid=$_SESSION['property_id'];
        $get=sql_query($conn,"SELECT * from property WHERE property_id=$pid and property_id NOT IN (SELECT distinct property_id FROM user_owns WHERE user_id=$user_id)");
        if(mysqli_num_rows($get)==0)
        {
            echo "<script>alert('You can't proceed as you own this property')</script>";
            header('location:buy.php');
        }

        $id=$_SESSION['property_id'];
        $select=mysqli_query($conn,"SELECT * FROM property WHERE property_id=$id");
        $price=mysqli_query($conn,"SELECT * FROM rent_price WHERE property_id=$id");
        $property=mysqli_fetch_assoc($select);
        $rprice=mysqli_fetch_assoc($price);
    }
?>
<html>
    <head>
        <title>
            Take Property on Rent
        </title> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>  
        <style>
            img{
                max-width: 500px;
                max-height: 500px;

            }
        </style> 
    </head>
    <body>
        <div style="align-content: center;">
            <div style="text-align: center;">
                <img src="<?php echo $property['images'] ?>" alt="Property Image">
            </div>
            <div>
                Property ID: <?php echo $property['property_id'] ?>
            </div>
            <div>
                Price for Rent: <?php echo $rprice['rprice'] ?>
            </div>
            <form action="#" method="POST">
                Number of People:
                <input type="number" name="number" min="0"><br>
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Take on Rent</button>
            </form>
        </div>
    </body>
</html>
<?php
    if(!empty($_POST['submit']))
    {
        date_default_timezone_set("Asia/Calcutta");
        $user_id=$_SESSION['logged_id'];
        $p_id=$_SESSION['property_id'];
        $r_time=date("Y/m/d H:i:s");
        $status=0;
        $no=$_POST['number'];
        $insert=mysqli_query($conn,"INSERT INTO rent_request(property_id,user_id,request_time,no_of_people,request_status) VALUES ($p_id,$user_id,'$r_time',$no,$status)");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "<script>alert('Your Request for Rent has been sent to the Owner of the Property. You will be notified about the request status after the concerned Owner's approval')</script>";
            header('location:property.php');
        }
    }
?>