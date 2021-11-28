<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "easyhomes";
    $conn = mysqli_connect($servername, $username, $password, $dbname, 3306);
?>
<html>
    <head>
        <title>
            Buy Property
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <?php
            $get=mysqli_query($conn,"Select * from property");
            $rows=mysqli_num_rows($get);
            if($rows>0)
            {
                while ($row = $get->fetch_assoc())
                {
                    $id=$row['property_id'];
                    if($row['category']=="sale")
                    {
                        $for="For Sale";
                        $get_price=mysqli_query($conn,"SELECT price FROM sale_price WHERE property_id=$id");
                        $price=mysqli_fetch_assoc($get_price);
                    }
                    else if($row['category']=="rent")
                    {
                        $for="For Rent";
                        $get_price=mysqli_query($conn,"SELECT rprice FROM rent_price WHERE property_id=$id");
                        $price=mysqli_fetch_assoc($get_price);
                    }
                    else
                    {
                        $for="For Sale and Rent";
                        $get_price=mysqli_query($conn,"SELECT price FROM sale_price WHERE property_id=$id");
                        $get_rprice=mysqli_query($conn,"SELECT rprice FROM rent_price WHERE property_id=$id");
                        $price=mysqli_fetch_assoc($get_price);
                        $rprice=mysqli_fetch_assoc($get_rprice);
                    }
                    ?>
                    <div class="row">
                        <div class="card col-12 mt-3">
                            <!-- <div class="card" style="width:100%"> -->
                                <!-- <div class="card-horizontal"> -->
                                    
                                    
                                    <div class="card-body row">
                                        <div class="col-4">
                                        <img class="card-img-top" src="<?php echo $row['images']?>" alt="Card image">
                                        </div>
                                        <div class="col-8">
                                        <h4 class="card-title">Property ID: <?php echo $row['property_id'] ?></h4>
                                    <p class="card-text">
                                        Area: <?php echo $row['area'] ?><br>
                                        <?php
                                            if($row['age']!=NULL)
                                            {
                                                ?>
                                                Property Age: <?php echo $row['age']?>
                                                <?php
                                            }
                                        ?>
                                        <br>
                                        Description: <?php echo $row['description']?>

                                        <br>
                                        <?php
                                            echo $for."<br>";
                                            if($for=="For Sale")
                                            {
                                                echo "Price: ".$price['price'];
                                            }
                                            else if($for=="For Rent")
                                            {
                                                echo "Rent Per Month: ".$price['rprice'];
                                            }
                                            else
                                            {
                                                echo "Price: ".$price['price']."<br>"; 
                                                echo "Rent Per Month: ".$rprice['rprice'];
                                            }
                                        ?>
                                    </p>
                                    <form action="#" method="POST">
                                        <button class="btn btn-primary" name="more" type="submit" value="<?php echo $row['property_id'] ?>">More Details</button>
                                    </form>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            <!-- </div> -->
                            <?php
                                if(!empty($_POST['more']))
                                {
                                    $_SESSION['property_id']=$_POST['more'];
                                    header('location:property.php');
                                }
                            ?>
                        </div>
                    </div>
                    
                    <?php
                }
            }
            else
            {
                echo "No Properties Listed with us in this category";
            }
        ?>
    </body>
</html>