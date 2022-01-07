<?php
    require './components/bootstrapcss.php';
    session_start();
    $pmcid=$_SESSION['pm_cid'];
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    $get=mysqli_query($conn,"SELECT * FROM pm_category WHERE category_id=$pmcid");
    $category=mysqli_fetch_assoc($get);
?>
<html>
    <head>
        <title>
            Edit Category
        </title>
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
        <p>Category ID: <?php echo $category['category_id'] ?></p>
        <form action="#" method="POST">
            Category Name:
            <input type="text" name="name" id="name" value="<?php echo $category['category_name'] ?>"><br>
            Capacity:
            <input type="number" name="capacity" id="capacity" value="<?php echo $category['capacity'] ?>"><br>
            Base Price:
            <input type="number" name="price" id="price" value="<?php echo $category['base_price'] ?>"><br>
            Number of Trucks Available:
            <input type="number" name="no" id="no" value="<?php echo $category['no_of_trucks'] ?>"><br>
            Price/km:
            <input type="number" name="km" id="km" value="<?php echo $category['price_km'] ?>"><br>
            <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
        </form>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>
<?php
    if(!empty($_POST['update']))
    {
        $id=$category['category_id'];
        $name=$_POST['name'];
        $capacity=$_POST['capacity'];
        $price=$_POST['price'];
        $no=$_POST['no'];
        $km=$_POST['km'];
        $update=mysqli_query($conn,"UPDATE pm_category SET category_name='$name', capacity=$capacity, base_price=$price, no_of_trucks=$no, price_km=$km WHERE category_id=$id");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:pmedit.php');
        }
    }
?>