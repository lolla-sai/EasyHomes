<?php
    require './components/bootstrapcss.php';
    session_start();
    $r_id=$_SESSION['request'];
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    $get_request=mysqli_query($conn,"SELECT * FROM books WHERE request_id=$r_id");
    if(mysqli_error($conn))
    {
        echo mysqli_error($conn);
    }
    $request_row=mysqli_fetch_assoc($get_request);
    $c_id=$request_row['category_id'];
    $get_category=mysqli_query($conn,"SELECT * from pm_category WHERE category_id=$c_id");
    if(mysqli_error($conn))
    {
        echo mysqli_error($conn);
    }
    $c_row=mysqli_fetch_assoc($get_category);
?>
<?php
    if(!empty($_POST['assign']))
    {
        $rid=$request_row['request_id'];
        $tid=$_POST['truck_id'];
        $ph_no=$_POST['number'];
        $date=$_POST['date'];
        $time=$_POST['time'];
        $status=1;
        $insert=mysqli_query($conn,"UPDATE books SET truck_id=$tid, driver_contactno=$ph_no, status=$status, pickup_date='$date', pickup_time='$time' WHERE request_id=$rid");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        $new_t=$c_row['no_of_trucks']-$request_row['no_of_trucks'];
        $cid=$c_row['category_id'];
        $put=mysqli_query($conn,"UPDATE pm_category SET no_of_trucks=$new_t WHERE category_id=$cid");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        header('location:pmreq.php');
    }
?>
<html>
    <head>
        <title>Request</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">
                    <img src="./media/icons8-home-240.png" alt="Home Icon" width="30" height="24" class="d-inline-block align-text-top">
                    EasyHomes Admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Admin Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="adminusers.php">Registered Users</a>
                        </li>
                        <div class="dropdown profile">
                                <div class="d-flex" data-bs-toggle="dropdown">
                                <a class="nav-link dropdown-toggle" role="button" id="pmDropdownLink">Packers and Movers</a>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="pmrequests.php">Check Requests</a></li>
                                    <li><a class="dropdown-item" href="pmedit.php">Edit Category</a></li>
                                </ul>
                        </div>
                    </ul>
                    <form action="logout.php" method="POST">
                        <button class="btn btn-primary" name="logout" value="logout" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <h5>Category:</h5>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Category ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Number of Trucks Available</th>
                    <th scope="col">Price/km</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?php echo $c_row['category_id'] ?></th>
                    <td><?php echo $c_row['category_name'] ?></td>
                    <td><?php echo $c_row['capacity'] ?></td>
                    <td><?php echo $c_row['base_price'] ?></td>
                    <td><?php echo $c_row['no_of_trucks'] ?></td>
                    <td><?php echo $c_row['price_km'] ?></td>
                </tr>
            </tbody>
        </table>
        <h5>Request:</h5>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Category ID</th>
                    <th scope="col">Booking Time</th>
                    <th scope="col">Number of Trucks Required</th>
                    <th scope="col">Status</th>
                    <?php
                        if($request_row['status']==1)
                        {
                            ?>
                            <th scope="col">Truck ID</th>
                            <th scope="col">Driver Contact No</th>
                            <th scope="col">Pickup Date</th>
                            <th scope="col">Pickup TIme</th>
                            <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?php echo $request_row['request_id'] ?></th>
                    <td><?php echo $request_row['user_id'] ?></td>
                    <td><?php echo $request_row['category_id'] ?></td>
                    <td><?php echo $request_row['booking_time'] ?></td>
                    <td><?php echo $request_row['no_of_trucks'] ?></td>
                    <td>
                        <?php
                            if($request_row['status']==0)
                            {
                                echo "Pending";
                            }
                            else if($request_row['status']==1)
                            {
                                echo "Assigned";
                            }
                            else
                            {
                                echo "Complete";
                            }
                        ?>
                    </td>
                    <?php
                        if($request_row['status']==1)
                        {
                            ?>
                            <td><?php echo $request_row['truck_id'] ?></td>
                            <td><?php echo $request_row['driver_contactno'] ?></td>
                            <td><?php echo $request_row['pickup_date'] ?></td>
                            <td><?php echo $request_row['pickup_time'] ?></td>
                            <?php
                        }
                    ?>
                </tr>
            </tbody>
        </table>
        <?php
            if($request_row['status']==0)
            {
                ?>
                <form action="#" method="POST">
                    Truck ID:
                    <input type="text" name="truck_id"><br>
                    Contact Number of Driver:
                    <input type="number" name="number"><br>
                    Pickup Date:
                    <input type="date" name="date">
                    Pickup Time:
                    <input type="time" name="time"><br>
                    <button type="submit" name="assign" value="assign" class="btn btn-primary">Assign</button>
                </form>
                <?php
            }
        ?>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>