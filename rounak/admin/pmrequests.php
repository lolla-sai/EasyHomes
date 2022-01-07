<?php
    require './components/bootstrapcss.php';
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);

?>
<?php
    if(!empty($_POST['view']))
    {
        $_SESSION['request']=$_POST['view'];
        header('location:pmreq.php');
    }
?>
<html>
    <head>
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
        <h2>Pending Requests:</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">Category ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Booking Time</th>
                    <th scope="col">Number of Trucks Required</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
            <?php
                $select=mysqli_query($conn,"SELECT * FROM books");
                $rows=mysqli_num_rows($select);
                if($rows>0)
                {
                    while($row=$select->fetch_assoc())
                    {
                        ?>
                        <tr>
                        <th scope="row"><?php echo $row['request_id'] ?></th>
                        <td><?php echo $row['category_id'] ?></td>
                        <td><?php echo $row['user_id'] ?></td>
                        <td><?php echo $row['booking_time'] ?></td>
                        <td><?php echo $row['no_of_trucks'] ?></td>
                        <td>
                            <?php
                                if($row['status']==0)
                                {
                                    echo "Pending";
                                }
                                else if($row['status']==1)
                                {
                                    echo "Assigned";
                                }
                                else
                                {
                                    echo "Complete";
                                }
                            ?>
                        </td>
                        <td>
                        <form action="#" method="POST">
                            <button type="submit" class="btn btn-primary" name="view" value="<?php echo $row['request_id'] ?>">View</button>
                        </form>
                        </td>
                        </tr>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <p>No Reuqests Registered Currently</p>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>