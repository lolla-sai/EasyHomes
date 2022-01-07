<?php
    require './components/bootstrapcss.php';
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
?>
<?php
    if(!empty($_POST['edit']))
    {
        $_SESSION['pm_cid']=$_POST['edit'];
        header('location:editpmc.php');
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Packers and Movers</title>
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
        <h1>Categories of Packers and Movers:</h1><br>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Category ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Number of Trucks Available</th>
                    <th scope="col">Price/km</th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
            <?php
                $select=mysqli_query($conn,"SELECT * FROM pm_category");
                while($row=$select->fetch_assoc())
                {
                    ?>
                    <tr>
                    <th scope="row"><?php echo $row['category_id'] ?></th>
                    <td><?php echo $row['category_name'] ?></td>
                    <td><?php echo $row['capacity'] ?></td>
                    <td><?php echo $row['base_price'] ?></td>
                    <td><?php echo $row['no_of_trucks'] ?></td>
                    <td><?php echo $row['price_km'] ?></td>
                    <td>
                    <form action="#" method="POST">
                        <button type="submit" class="btn btn-primary" name="edit" value="<?php echo $row['category_id'] ?>">Edit</button>
                    </form>
                    </td>
                    </tr>
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