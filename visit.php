<?php
    session_start();
    require './components/runSQLQuery.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "easyhomes";
    $conn = mysqli_connect($servername, $username, $password, $dbname, 3306);
    if(!isset($_SESSION['logged_id']))
    {
        $_SESSION['from']="visit";
        header('location:index.php');
    }
    else
    {
        unset($_SESSION['from']);
        $user_id=$_SESSION['logged_id'];
        $pid=$_SESSION['property_id'];
        $get=sql_query($conn,"SELECT * from property WHERE property_id=$pid and property_id NOT IN (SELECT distinct property_id FROM user_owns WHERE user_id=$user_id)");
        if(mysqli_num_rows($get)==0)
        {
            echo "<script>alert('You can't proceed as you own this property')</script>";
            header('location:buy.php');
        }


    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <title>
            Book a Visit
        </title>
    </head>
    <body>
        <form action="#" method="POST">
            Property ID: 
            <input type="number" name="p_id" id="p_id" required><br>
            Preferred Visit Date:
            <input type="date" name="date" required ><br>
            Your User ID:
            <input type="number" name="u_id" id="u_id" required>
            <br>
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Book Visit</button>
        </form>
    </body>
    <script type="text/javascript">
            document.querySelector("#p_id").value=<?php echo $_SESSION['property_id']?>;
            document.querySelector("#u_id").value=<?php echo $_SESSION['logged_id']?>;
    </script>
</html>
<?php
    if(!empty($_POST['submit']))
    {
        $userid=$_POST['u_id'];
        $propertyid=$_POST['p_id'];
        $date=$_POST['date'];
        $request_status=0;
        $insert=mysqli_query($conn,"INSERT INTO visits(user_id,property_id,date) VALUES($userid,$propertyid,'{$date}')");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "<script>alert('Your Visit Request has been Booked and Sent to the Owner of the Property. You will be Notified once the request has been accepted')</script>";
            header('location:property.php');
        }
    }
?>