<?php
    session_start();
    require './components/initialiseMessages.php';
    require './components/cleanInputFn.php';
    require './components/handleFileUploads.php';
    require './components/setAlertFn.php';
    require './components/runSQLQuery.php';
    ?>
<?php
    if(!isset($_SESSION['logged_id']))
    {
        set_alert("Please login to enter sell page", "info");
        $_SESSION['from']="sell";
        header('location:index.php');
    }
    else
    {
        unset($_SESSION['from']);
        $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
        if($conn->connect_error) {
            set_alert("Database Connection Failed", "danger");
            goto endpoint;
        }
    
        if(isset($_POST['submit'])) {
            $user_id=$_SESSION['logged_id'];
            $category = clean_input($_POST['category']);
            $for = clean_input($_POST['for']);
            if($category=='house') {
                $house_no = $_POST['house_no'];
                $house_plot_no = $_POST['house_plot_no'];
            }
            else if($category=='plot') {
                $plot_no = $_POST['plot_no'];
            }
            else if($category=='flat') {
                $flat_no = $_POST['flat_no'];
                $flat_name = $_POST['flat_name'];
            }
    
            
            // $location = clean_input($_POST['location']);
            $latitude = clean_input($_POST['latitude']);
            $longitude = clean_input($_POST['longitude']);
    
            if($for=='sale')
            {
                $price = clean_input($_POST['price']);
            }
            else if($for=='both')
            {
                $price = clean_input($_POST['price']);
                $rent_price = clean_input($_POST['rent_price']);
            }
            else
            {
                $price=clean_input($_POST['rent_price']);
            }
           
            $description = clean_input($_POST['desc']);
            $area = clean_input($_POST['area']);
            if($_POST['age']!=NULL)
            {
                $age= clean_input($_POST['age']);
            }
    
            $imagesStr = handle_file_uploads('media' . '/' .($_SESSION['logged_username']) . '/', 'property_pics');
    
            if($category=='plot' || $_POST['age']==NULL)
            {
                $last_id = sql_query($conn, "INSERT INTO property (latitude,longitude, category, description, images, area) VALUES ($latitude,$longitude, '$for', '$description', '$imagesStr', $area)", true);
            }
            else
            {
                $last_id = sql_query($conn, "INSERT INTO property (latitude,longitude, category, description, images, area,age) VALUES ($latitude,$longitude, '$for', '$description', '$imagesStr', $area,$age)", true);
            }
    
            sql_query($conn, "INSERT INTO user_owns (user_id,property_id) VALUES ($user_id,$last_id)");
    
            if($category=='house') {
                sql_query($conn, "INSERT INTO house (house_no, plot_no, property_id) VALUES ('$house_no', '$house_plot_no', $last_id)");
            }
            else if($category=='plot') {
                sql_query($conn, "INSERT INTO plot (plot_number, property_id) VALUES ('$plot_no', $last_id)");
            }
            else if($category=='flat') {
                sql_query($conn, "INSERT INTO flat (flat_no, building_name, property_id) VALUES ('$flat_no', '$flat_name', $last_id)");
            }
    
            if($for=='sale')
            {
                sql_query($conn,"INSERT INTO sale_price(property_id,price) VALUES ($last_id,$price)");
    
            }
            else if($for=='rent')
            {
                sql_query($conn,"INSERT INTO rent_price(property_id,rprice) VALUES ($last_id,$price)");
            }
            else
            {
                sql_query($conn,"INSERT INTO sale_price(property_id,price) VALUES ($last_id,$price)");
                sql_query($conn,"INSERT INTO rent_price(property_id,rprice) VALUES ($last_id,$rent_price)");
            }
            header('location:userpage.php');
        }
        endpoint:
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sell Property</title>
        <?php
            require './components/bootstrapcss.php';
            require './components/googlemap.php';
            require './components/showdownjs.php';
        ?>
        <style>
            .landing {
                min-height: 90vh;
            }
        </style>
    </head>
    <body>
        <?php
            require './components/navbar.php';
        ?>
        <section class="landing py-4 px-2 bg-light d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                        <h1>Have some property to sell or rent?</h1>
                        <p class="lead">Don't worry, we got you covered! With our time tested solutions, your property won't be left abandoned for long. Be it rent/sell, be it plot/flat/house, we are always there to help you out!</p>
                        <button class="btn btn-primary btn-lg">List Property</button>
                    </div>
                    <div class="col-10 mx-auto col-md-6 order-1 order-md-2 my-4">
                        <img src='./media/housebg3.jpg' alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="landing py-4 px-2 d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-10 mx-auto col-md-6 my-4">
                        <img src='./assets/lock.webp' alt="" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-5 py-2">
                        <h1>Security and Privacy First</h1>
                        <p class="lead">With our website, your property will be exposed to a lot of potential buyers. With security solutions, like visit requests and rent requests, you can be assured that your property details wont be shared to any random person.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing py-4 px-2 bg-light d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                        <h1>Powerful Interface</h1>
                        <p class="lead">With feautures like map based location settings, your clients wont find it difficult to visit your site in person. Plus, with just 3 simple steps, you can have your property up for the world to see. Listing a property has never been so simple.</p>
                    </div>
                    <div class="col-10 mx-auto col-md-6 order-1 order-md-2 my-4">
                        <img src='./assets/GoogleMap.jpg' alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="container py-5">
            <h1 class="mb-3">Sell/Rent A House</h1>
            <p class="lead">Sell your house in 3 easy steps</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" class="my-4" onsubmit="modifyTextToAddNewLine">
                <ul class="nav nav-pills mb-4 nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab">1. Basic Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab">2. Location and Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab">3. Upload Files</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
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
                                    <option value="sale">Sale</option>
                                    <option value="rent">Rent</option>
                                    <option value="both">Sale and Rent</option>
                                </select>
                            </div>
                        </div>
                        <div class="category_specific_details">
                            <div class="input-group mb-3" data-name="house">
                                <label for="house_no" class="input-group-text">House No</label>
                                <input type="text" id="house_no" name="house_no" class="form-control">
                                <label for="house_plot_no" class="input-group-text">Plot No</label>
                                <input type="text" id="house_plot_no" name="house_plot_no" class="form-control">
                            </div>
                            <div class="input-group mb-3" data-name="plot">
                                <label for="plot_no" class="input-group-text">Plot No</label>
                                <input type="text" id="plot_no" name="plot_no" class="form-control">
                            </div>
                            <div class="input-group mb-3" data-name="flat">
                                <label for="flat_no" class="input-group-text">Flat No</label>
                                <input type="text" id="flat_no" name="flat_no" class="form-control">
                                <label for="flat_name" class="input-group-text">Building Name</label>
                                <input type="text" id="flat_name" name="flat_name" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <div class="input-group mb-3">
                                <label for="area" class="input-group-text">Area (in sq. ft)</label>
                                <input type="number" name="area" id="area" min="10" class="form-control">
                            </div>
                            <div class="input-group mb-3" data-name="age">
                                <label for="area" class="input-group-text">Age of Property(in Years):</label>
                                <input type="number" name="age" id="age" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="category_specific_details d-block d-md-flex gap-3">
                            <div class="input-group mb-3" data-name="for_sale">
                                <label for="area" class="input-group-text">Price</label>
                                <input type="number" name="price" id="price" min="10" class="form-control">
                            </div>
                            <div class="input-group mb-3" data-name="for_rent">
                                <label for="area" class="input-group-text">Price for Rent(Per Month)</label>
                                <input type="number" name="rent_price" id="rprice" min="10" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning px-4" onclick="turnPage" data-page="2">Next</button>
                            <button type="reset" class="btn btn-danger px-4">Reset</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12 col-md-5 order-2 order-md-1">
                                <div class="input-group mb-3">
                                    <label for="latitude" class="input-group-text">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" class="form-control" readonly>
                                    <label for="longitude" class="input-group-text">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" class="form-control" readonly>
                                </div>
                                <!-- <div class="input-group mb-3">
                                    <label for="property_title" class="input-group-text">Property title</label>
                                    <input type="text" id="property_title" name="property_title" class="form-control" placeholder="Enter a short heading that best describes your property.." max="80">
                                </div> -->
                                <span class="input-group-text">Description/Facilities</span>
                                <div class="input-group mb-3">
                                    <textarea class="form-control" style="height: 400px;" name="desc" id="desc" placeholder="This description section is very powerful! Dont think this is a simple text box. You can enter text here in markdown language syntax. Dont know what it means? Refer "></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 order-1 order-md-2 py-1">
                                <ul class="nav nav-tabs" id="mapandoutputtabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="map" data-bs-toggle="tab" data-bs-target="#map-tab" type="button" role="tab" >Map</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="output" data-bs-toggle="tab" data-bs-target="#output-tab" type="button" role="tab">Output</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="mapandoutputtabcontent">
                                    <div class="tab-pane fade show active" id="map-tab" role="tabpanel">
                                        <div id="mapCanvas"></div>
                                    </div>
                                    <div class="tab-pane fade" id="output-tab" role="tabpanel">
                                        <div class="w-100 border p-3" style="height: 500px; overflow-y: auto;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-warning px-4" onclick="turnPage" data-page="1">Previous</button>
                            <button type="button" class="btn btn-warning px-4" onclick="turnPage" data-page="3">Next</button>
                            <button type="reset" class="btn btn-danger px-4">Reset</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel">
                        <div class="input-group mb-3">
                            <input type="file" onchange="showImages" name="property_pics[]" id="property_pics" class="form-control" multiple accept=".jpg,.png,.jpeg,.gif">
                        </div>

                        
                        <div class="imageField" style="min-height: 400px">
                            <div id="carouselExampleIndicators" style="display: none" class="carousel slide" data-bs-ride="carousel">
                                <p class="h3 my-2">Your selected images</p>
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner" id="carousal-images-container">
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <input type="submit" value="Submit" name="submit" class="btn btn-primary mx-auto">
                            <button type="button" class="btn btn-warning px-4" onclick="turnPage" data-page="2">Previous</button>
                            <button type="reset" class="btn btn-danger px-4">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <?php
            require './components/footer.php';
            require './components/fontawesome.php';
            require './components/bootstrapjs.php';
            require './components/displayMessages.php';
        ?>

        <script>
            let inputElem = document.querySelector('#desc');
            let outputElem = document.querySelector('#output-tab>div');
            inputElem.addEventListener('input', (e) => {
                outputElem.innerHTML = markdownToHTML(inputElem.value);
            });
        </script>
        <script src="toggleCategory.js"></script>
        <script>
            let pages = [document.querySelector('#pills-home-tab'), document.querySelector('#pills-profile-tab'), document.querySelector('#pills-contact-tab')];
            function turnPage(e) {
                console.log(e);
                let tgt = e.target;
                console.log(tgt.dataset.page);
                pages[parseInt(tgt.dataset.page)-1].click();
            }

            document.querySelectorAll('[data-page]').forEach(btn => {
                btn.addEventListener('click', turnPage);
            });
        </script>
        <script>
            let fileInput = document.querySelector('#property_pics');
            let carousel = document.querySelector('.imageField>div');

            function showImages(event) {
                let imageField = document.querySelector('.imageField #carousal-images-container');
                imageField.children = [];
                if(event.target.files.length) {
                    carousel.style.display = 'block';
                }
                else {
                    carousel.style.display = 'none';
                }
                for(let i=0; i < event.target.files.length; i++) {
                    let div = document.createElement('DIV');
                    div.classList.add('carousel-item');
                    if(!document.querySelector('.carousel-item.active'))
                        div.classList.add('active');
                    let file = event.target.files[i];
                    
                    let img = document.createElement('IMG');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('d-block', 'w-100', 'img-fluid');
                    img.style.maxWidth = '100%';
                    img.style.minHeight = '400px';
                    img.style.objectFit = 'contain';

                    div.appendChild(img);

                    imageField.appendChild(div);
                }
            }
            fileInput.addEventListener('change', showImages);
        </script>
        <script>
            function modifyTextToAddNewLine() {
                let textBox = document.querySelector('#desc');
                textBox.value.replace('\n', '|---|');
                return true;
            }
            document.querySelector('form').addEventListener('submit', modifyTextToAddNewLine);
        </script>
    </body>
</html>