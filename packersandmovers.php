<?php
    session_start();
    require './components/bootstrapcss.php';
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
?>
<?php
    if(!empty($_POST['Book']))
    {
        $_SESSION['pm_cid']=$_POST['Book'];
        header('location:pmcategoryform.php');
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
        <?php
            require './components/navbar.php';
        ?>
        <section class="subLanding py-4 px-2 bg-light d-flex align-items-center" style="min-height: 90vh;">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                        <h1>Shifting is not difficult*</h1>
                        <p class="text-secondary">*If you use EasyHomes &#128513;</p>
                        <p class="lead">Why sweat and cough, while we are here to handle the tough. Start off today in 3 simple steps, with plans that suite all your needs.</p>
                        <a href="#plans" class="btn btn-primary btn-lg">Explore Plans</a>
                    </div>
                    <div class="col-10 mx-auto col-md-6 order-1 order-md-2 my-4">
                        <img src='./media/packersandmovers2.jpg' alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <div class="container px-3 py-5" id="plans">
            <h1>Explore Plans</h1>
            <p class="lead">We have a dedicated categories for all family/goods sizes. Pick the one that sounds perfect to you, and we'll arrange it for you. <br> Note: <b>1.</b> images shown below are just for representation. <br> <b>2.</b> Packers charges are seperate</p>
            <div class="cards p-3 my-3 d-flex gap-4 align-items-center justify-content-center flex-wrap">
                <?php
                    $select=mysqli_query($conn,"SELECT * FROM pm_category");
                    while($row=$select->fetch_assoc())
                    {
                        ?>
                        <div class="card" style="width: 18rem;">
                            <?php
                                switch($row['category_name']) {
                                    case "Very Small":
                                        $url = "./media/verysmall.jpg";
                                        $text = "Best suited for bachelors / individuals with not much items.";
                                        break;
                                    case "Small":
                                        $url = "./media/smalltruck.jpg";
                                        $text = "A truck with bigger space then an auto. Best suited for small families of 2 people.";
                                        break;
                                    case "Medium":
                                        $url = "./media/mediumtruck.webp";
                                        $text = "A medium sized truck for families of upto 4 people, having appliances like TV, washing machine etc.";
                                        break;
                                    case "Large":
                                        $url = "./media/largetruck.jpg";
                                        $text = "A larger truck for someone with a lot of furniture, appliances and things.";
                                        break;
                                    default:
                                        $url = "./media/verylargetruck.jpg";
                                        $text = "A container truck, for interstate transporting. Use this if you are shifting outstation, or if you have a lot of goods to take.";
                                        break;
                                }
                            ?>
                            <img src=<?php echo $url; ?> class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['category_name'] ?> (Id: <?php echo $row['category_id'] ?>)</h5>
                                <p class="card-text"><?php echo $text; ?></p>
                                <p class="card-text">
                                    <b>Capacity:</b> <?php echo $row['capacity'] ?><br>
                                    <b>Base Price:</b> <?php echo $row['base_price'] ?><br>
                                    <b>Number of Trucks Available:</b> <?php echo $row['no_of_trucks'] ?><br>
                                    <b>Price/km:</b> <?php echo $row['price_km'] ?><br>
                                </p>
                                <form action="#" method="POST">
                                    <button type="submit" class="btn btn-primary" name="Book" value="<?php echo $row['category_id'] ?>">Book</button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
            </div>
        </div>
        <?php
            require './components/footer.php';
            require './components/fontawesome.php';
        ?>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>