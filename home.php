<?php
    session_start();
    require './components/initialiseMessages.php';
    require './components/setAlertFn.php';
?>
<?php
    if(!empty($_POST['login']))
    {
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyHomes - Home</title>
    <?php
        require './components/bootstrapcss.php';
    ?>
    <style>
        .profile img {
            display: block;
            width: 50px;
            height: 50px;
            object-fit: cover;
            max-width: 100%;
            border-radius: 50%;
        }
        .landing {
            background: url('./media/housebg.jpg') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            /* min-height: 450px; */
        }
        .landing-pane {
            background-color: rgba(255, 255, 255, .8);
        }
        .custImg {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .subLanding {
            min-height: 90vh;
        }
    </style>
</head>
<body>
    <?php
        require './components/navbar.php';
    ?>

    <section class="landing d-flex align-items-center justify-content-center p-3">
        <div class="text-center p-5 rounded landing-pane">
            <h1>What do you want to do today?</h1>
            <div class="d-flex flex-md-row flex-column justify-content-center gap-3 align-items-center mt-5">
                <a class="btn btn-primary btn-lg" href="buy.php">Buy/Take On Rent</a>
                <p class="h3">Or</p>
                <a class="btn btn-warning btn-lg" href="sell.php">Sell/Give On Rent</a>
            </div>
        </div>
    </section>

    <section class="subLanding py-4 px-2 bg-light d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                    <h1>Want to shift to a new home?</h1>
                    <p class="lead">At EasyHomes, we know that homes are more than just bricks and cement. They are feelings. Be it properties for sale or on rent, you'll find it all, here. All the goodies, with the added security of EasyHomes.</p>
                    <a href="buy.php" class="btn btn-primary btn-lg">Buy/Rent home</a>
                </div>
                <div class="col-10 mx-auto col-md-6 order-1 order-md-2 my-4">
                    <img src='./media/housebg3.jpg' alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section class="subLanding py-4 px-2 bg-light d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-10 mx-auto col-md-6 my-4">
                    <img src='./media/sellpic.jpg' alt="" class="img-fluid">
                </div>
                <div class="col-12 col-md-5 py-2">
                    <h1>Have some property to sell or rent?</h1>
                    <p class="lead">Don't worry, we got you covered! With our time tested solutions, your property won't be left abandoned for long. Be it rent/sell, be it plot/flat/house, we are always there to help you out!</p>
                    <a href="sell.php" class="btn btn-primary btn-lg ">List Property</a>
                </div>
            </div>
        </div>
    </section>

    <section class="subLanding py-4 px-2 bg-light d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                    <h1>Shifting houses need not be difficult</h1>
                    <p class="lead">Be it heavy cupboards, or sensitive table glass, you can trust us on safely delivering it from anywhere to anywhere. Our drivers are very professional and experienced. Our services are very swift and trustworthy. Select the category, that best suits you.</p>
                    <a href="packersandmovers.php" class="btn btn-primary btn-lg">Book Packers and Movers</a>
                </div>
                <div class="col-10 mx-auto col-md-6 order-1 order-md-2 my-4">
                    <img src='./media/top-20-reliable-packers-movers-in-india-1.jpg' alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <?php
        require './components/footer.php';
        require './components/bootstrapjs.php';
        require './components/fontawesome.php';
        require './components/displayMessages.php';
    ?>
</body>
</html>
