<?php
    session_start();
?>
<?php
    if(!isset($_SESSION['messages'])) {
        $_SESSION['messages']=array();
    }
    $_SESSION['logged_dp'] = 'media/lolla-sai/dp20211110160144';
    $_SESSION['logged_username'] = 'Sai Lolla';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyHomes - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./media/icons8-home-240.png" alt="Home Icon" width="30" height="24" class="d-inline-block align-text-top">
                EasyHomes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
                <div class="dropdown profile">
                    <div class="d-flex" data-bs-toggle="dropdown">
                    <img src="<?php echo $_SESSION['logged_dp']; ?>" alt="DP">
                    <a class="nav-link dropdown-toggle" role="button" id="profileDropdownLink"><?php echo $_SESSION['logged_username']; ?></a>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">My Properties</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <section class="landing d-flex align-items-center justify-content-center">
        <div class="text-center p-5 rounded landing-pane">
            <h1>What do you want to do today?</h1>
            <div class="d-flex flex-md-row flex-column justify-content-center gap-3 align-items-center mt-5">
                <a class="btn btn-primary btn-lg">Buy/Take On Rent</a>
                <p class="h3">Or</p>
                <a class="btn btn-warning btn-lg">Sell/Give On Rent</a>
            </div>
        </div>
    </section>

    <section class="buy py-5 bg-light">
        <div class="container">
            <h1 class="mb-4">Search properties for Sale/Rent</h1>
            <form action="#" class="mx-auto mt-2" method="get">
                <div class="input-group input-group-lg rounded">
                    <input class="form-control" placeholder="Search properties by location..." type="text" name="searchbar" id="searchbar">
                    <input class="btn btn-primary" type="submit" value="Search">
                </div>
            </form>
            <div class="search-results">
                <h2 class="my-4">Search Results</h2>
                <div class="cards d-flex flex-wrap gap-3">
                    <div class="card" style="width: 18rem;">
                        <!-- <img src="media/housebg3.jpg" class="card-img-top" alt="..."> -->
                        <div id="propertyCarousal" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img src="media/default.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item active">
                                    <img src="media/housebg3.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="media/lolla-sai/dp20211109173019.jpg" class="card-img-top custImg" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousal" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousal" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Duplex house around Anjuna</h5>
                            <p class="card-text">Fully furnished duplex house for sale. Close to the scenic Anjuna beach.</p>
                            <p class="card-text price lead">&#8377; 32,87,600</p>
                            <a href="#" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem;">
                        <!-- <img src="media/housebg3.jpg" class="card-img-top" alt="..."> -->
                        <div id="propertyCarousal2" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img src="media/default.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item active">
                                    <img src="media/housebg3.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="media/lolla-sai/dp20211109173019.jpg" class="card-img-top custImg" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousal2" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousal2" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Flat for rent in Margao</h5>
                            <p class="card-text">2-BHK house for rent. Close to Margao Bus Stand.</p>
                            <p class="card-text price lead">&#8377; 10800/month</p>
                            <a href="#" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hot-properties">
                <h2 class="my-4">Hot Properties</h2>
                <div class="cards d-flex flex-wrap gap-3">
                    <div class="card" style="width: 18rem;">
                        <!-- <img src="media/housebg3.jpg" class="card-img-top" alt="..."> -->
                        <div id="propertyCarousal3" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img src="media/default.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item active">
                                    <img src="media/housebg3.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="media/lolla-sai/dp20211109173019.jpg" class="card-img-top custImg" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousal3" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousal3" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Duplex house around Anjuna</h5>
                            <p class="card-text">Fully furnished duplex house for sale. Close to the scenic Anjuna beach.</p>
                            <p class="card-text price lead">&#8377; 32,87,600</p>
                            <a href="#" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem;">
                        <!-- <img src="media/housebg3.jpg" class="card-img-top" alt="..."> -->
                        <div id="propertyCarousal4" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img src="media/default.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item active">
                                    <img src="media/housebg3.jpg" class="card-img-top custImg" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="media/lolla-sai/dp20211109173019.jpg" class="card-img-top custImg" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousal4" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousal4" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Flat for rent in Margao</h5>
                            <p class="card-text">2-BHK house for rent. Close to Margao Bus Stand.</p>
                            <p class="card-text price lead">&#8377; 10800/month</p>
                            <a href="#" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sell container py-5">
        <h1 class="mb-4">Sell/Rent Properties</h1>
        <form action="#" method="post">
            <div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="category">Category</label>
                    <select class="form-select" name="category" id="category">
                        <option value="house">House</option>
                        <option value="flat">Flat</option>
                        <option value="plot">Plot</option>
                    </select>
                    <label for="for" class="input-group-text">For</label>
                    <select class="form-select" name="for" id="for">
                        <option value="rent">Rent</option>
                        <option value="sale">Sale</option>
                    </select>
                </div>
            </div>
            <div class="category_specific_details">
                <div class="input-group mb-3">
                    <label for="house_no" class="input-group-text">House No</label>
                    <input type="number" id="house_no" name="house_no" class="form-control">
                    <label for="house_plot_no" class="input-group-text">Plot No</label>
                    <input type="number" id="house_plot_no" name="house_plot_no" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <label for="plot_no" class="input-group-text">Plot No</label>
                    <input type="number" id="plot_no" name="plot_no" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <label for="flat_no" class="input-group-text">Flat No</label>
                    <input type="number" id="flat_no" name="flat_no" class="form-control">
                    <label for="flat_name" class="input-group-text">Flat Name</label>
                    <input type="text" id="flat_name" name="flat_name" class="form-control">
                </div>
            </div>
            <div class="input-group mb-3">
                <label for="location" class="input-group-text">Location</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="Search for a nearby place or landmark">
            </div>
            <div class="input-group mb-3">
                <input type="file" name="property_pics" id="property_pics" class="form-control" multiple accept=".jpg,.png,.jpeg,.gif">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Description/Facilities</span>
                <textarea class="form-control" name="desc" id="desc"></textarea>
            </div>
            <div class="d-flex flex-column flex-md-row gap-2">
                <div class="input-group mb-3">
                    <label for="area" class="input-group-text">Area (in sq. ft)</label>
                    <input type="number" name="area" id="area" min="10" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <label for="area" class="input-group-text">Price/Rent per month (in INR)</label>
                    <input type="number" name="price" id="price" min="10" class="form-control">
                </div>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script
      src="https://kit.fontawesome.com/529db58a1d.js"
      crossorigin="anonymous"
    ></script>

    <div class="messages" style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 90%;">
        <?php
            foreach ($_SESSION['messages'] as $msg) {
                $msgArr = explode("-->", $msg, 2);
                echo "<div class='alert alert-$msgArr[0] alert-dismissible fade show' role='alert'>
                        <span>$msgArr[1]</span>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
            $_SESSION['messages'] = array();
        ?>
    </div>
</body>
</html>