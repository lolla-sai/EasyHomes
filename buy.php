<?php
    session_start();
    require './components/runSQLQuery.php';
    require './components/setAlertFn.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "easyhomes";
    $conn = mysqli_connect($servername, $username, $password, $dbname, 3306);
?>
<?php
    if(!empty($_POST['more']))
    {
        $_SESSION['property_id']=$_POST['more'];
        header('location:property.php');
    }
?>
<html>
    <head>
        <title>
            Buy Property
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php require './components/bootstrapcss.php' ?>
        <style>
            .landing {
                min-height: 90vh;
            }
            .custImg {
                width: 100%;
                height: 200px;
                object-fit: cover;
            }
            @media screen and (max-width: 768px) {
                body > section.buy.py-5 > div > form > div > div:nth-child(2) > h3:nth-child(1) {
                    padding-top: 1rem;
                }
            }
        </style>
        <?php
            require './components/showdownjs.php';
        ?>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE"></script>

        <script>
            let coords = [];
            var position = [15.496596, 73.835353];
        </script>

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                $lat = 0;
                $lng = 0;
                if(isset($_GET['latitude']))
                    $lat = floatval($_GET['latitude']);
                if(isset($_GET['longitude']))
                    $lng = floatval($_GET['longitude']);
                if($lat == 0 && $lng == 0) {
                    $lat = 15.496596;
                    $lng = 73.835353;
                }
                echo "<script>position = [$lat, $lng];</script>";
                $lat_limits = [$lat-0.005, $lat+0.005];
                $lng_limits = [$lng-0.005, $lng+0.005];

                if(!isset($_SESSION['logged_id']))
                {
                    $output = sql_query($conn, "SELECT * from property WHERE (latitude BETWEEN " . implode(' AND ', $lat_limits) . ") AND (longitude BETWEEN " . implode(' AND ', $lng_limits) . ")");
                    // $get=mysqli_query($conn,"Select * from property");
                }
                else
                {
                    $user_id=$_SESSION['logged_id'];
                    // $get=sql_query($conn,"SELECT * from property WHERE property_id IN (SELECT distinct property_id from user_owns WHERE user_id!=$user_id)");
                    
                    $output = sql_query($conn, "SELECT * from property WHERE property_id IN (SELECT DISTINCT property_id FROM user_owns WHERE user_id!=$user_id) AND (latitude BETWEEN " . implode(' AND ', $lat_limits) . ") AND (longitude BETWEEN " . implode(' AND ', $lng_limits) . ")");
                }
                
                while($row = $output->fetch_assoc()) {
                    // echo $row['property_id'] . '<br>';
                    $id = $row['property_id'];
                    $row_lat = $row['latitude'];
                    $row_lng = $row['longitude'];
                    echo "<script>coords.push([$row_lat, $row_lng, '$id'])</script>";
                }
                $_SESSION['output'] = $output;
            }
        ?>

        <script>
            function initialize() { 
                var latlng = new google.maps.LatLng(position[0], position[1]);

                const svgMarker = {
                    path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                    fillColor: "green",
                    fillOpacity: 0.6,
                    strokeWeight: 0,
                    rotation: 0,
                    scale: 2,
                    anchor: new google.maps.Point(15, 30),
                };

                var myOptions = {
                    zoom: 16,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: "Latitude:"+position[0]+" | Longitude:"+position[1]
                });
                
                console.log(coords);
                coords.forEach(coordinate => {
                    let latlng = new google.maps.LatLng(coordinate[0], coordinate[1]);
                    let marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: "Property ID: " + coordinate[2],
                        icon: svgMarker
                    });
                })
            
            
                google.maps.event.addListener(map, 'click', function(event) {
                    var result = [event.latLng.lat(), event.latLng.lng()];
                    transition(result);
                });
            }
            
            //Load google map
            google.maps.event.addDomListener(window, 'load', initialize);
            
            
            var numDeltas = 100;
            var delay = 10; //milliseconds
            var i = 0;
            var deltaLat;
            var deltaLng;
            
            function transition(result){
                i = 0;
                deltaLat = (result[0] - position[0])/numDeltas;
                deltaLng = (result[1] - position[1])/numDeltas;
                moveMarker();
            }

            function moveMarker(){
                position[0] += deltaLat;
                position[1] += deltaLng;
                var latlng = new google.maps.LatLng(position[0], position[1]);
                marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);
                marker.setPosition(latlng);
                document.querySelector("#latitude").value=position[0];
                document.querySelector("#longitude").value=position[1];
                if(i!=numDeltas){
                    i++;
                    setTimeout(moveMarker, delay);
                }
            }
        </script>

        <style>
            #mapCanvas {
                width: 95vw;
                height: 95vw;
                max-width: 500px;
                max-height: 500px;
                /* margin: 2rem; */
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <?php
            require './components/navbar.php';
            function validate($row, $minPrice, $maxPrice, $minArea, $maxArea, $category, $for) {
                GLOBAL $conn;
                $pid = $row['property_id'];
                if($row['category'] == 'none') {
                    return false;
                }

                if($row['category'] == 'sale' || $row['category'] == 'both') {
                    $price = sql_query($conn, "SELECT price from sale_price where property_id = $pid");
                    $price = $price->fetch_row()[0];
                    // print_r($price);
                }
                else {
                    $price = sql_query($conn, "SELECT rprice from rent_price where property_id = $pid");
                    $price = $price->fetch_row()[0];
                    // print_r($price);
                }

                if(mysqli_num_rows(sql_query($conn, "SELECT * FROM property WHERE category!='none' and property_id = $pid and property_id IN (SELECT property_id FROM flat)"))) {
                    $type = 'flat';
                }
                else if(mysqli_num_rows(sql_query($conn, "SELECT * FROM property WHERE category!='none' and property_id = $pid and property_id IN (SELECT property_id FROM house)"))) {
                    $type = 'house';
                }
                else {
                    $type = 'plot';
                }

                // echo $row['category'] == $category , $price <= $maxPrice , $price >= $minPrice , $row['area'] <= $maxArea , $row['area'] >= $minArea , $type == $for . "<br>";
                // echo ($row['category'] == $category && $price <= $maxPrice && $price >= $minPrice && $row['area'] <= $maxArea && $row['area'] >= $minArea && $type == $for);
                // echo $pid . "<br>";
                // echo $row['category'] . "==" . $for . "<BR>";
                // echo $price . "between" . $maxPrice . " and " . $minPrice . "<BR>";
                // echo $row['area'] . "between" . $maxArea . " and " . $minArea . "<BR>";
                // echo $type . "==" . $category . "<BR>";
                // echo "<br>";
                if($row['category'] == $for && $price <= $maxPrice && $price >= $minPrice && $row['area'] <= $maxArea && $row['area'] >= $minArea && $type == $category) {
                    // echo $row['pid'];
                    return true;
                }
                return false;
            }
        ?>
        
        <section class="landing py-4 px-2 bg-light d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-12 col-md-5 py-2 order-2 order-md-1">
                        <h1>Want to shift to a new home?</h1>
                        <p class="lead">At EasyHomes, we know that homes are more than just bricks and cement. They are feelings. Be it properties for sale or on rent, you'll find it all, here. All the goodies, with the added security of EasyHomes.</p>
                        <button class="btn btn-primary btn-lg">List Property</button>
                    </div>
                    <div class="col-10 mx-auto col-md-6 my-4 order-1 order-md-2">
                        <img src='./media/housebg3.jpg' alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section>

        <section class="buy py-5">
            <div class="container">
                <h1 class="mb-4">Search properties for Sale/Rent</h1>
                <form action="#" class="mx-auto mt-2" method="get">
                    <div class="d-block d-md-flex align-items-center justify-content-between gap-0 gap-md-3">
                        <div id="mapCanvas" class="mx-auto"></div>
                        <div style="flex-grow: 1;">
                            <h3 class="pb-1">Your Location</h3>
                            <div class="input-group mb-3">
                                <label for="latitude" class="input-group-text">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Search for a nearby place or landmark">
                            </div>
                            <div class="input-group mb-3">
                                <label for="longitude" class="input-group-text">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Search for a nearby place or landmark">
                            </div>
                            <h3 class="pb-1">Filters</h3>
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
                            <div class="input-group mb-3">
                                <label for="areaMin" class="input-group-text">Area</label>
                                <input type="number" class="form-control" name="areaMin" id="areaMin">
                                <label for="areaMax" class="input-group-text">To</label>
                                <input type="number" class="form-control" name="areaMax" id="areaMax">
                            </div>
                            <div class="input-group mb-3">
                                <label for="priceMin" class="input-group-text">Price</label>
                                <input type="number" class="form-control" name="priceMin" id="priceMin">
                                <label for="priceMax" class="input-group-text">To</label>
                                <input type="number" class="form-control" name="priceMax" id="priceMax">
                            </div>
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
                <div class="search-results">
                    <h2 class="my-4">Search Results</h2>
                    <div class="cards d-flex justify-content-center flex-wrap gap-3">
                        <?php
                            $get=$output;
                            mysqli_data_seek($get, 0);
                            $rows=mysqli_num_rows($get);
                            if($rows>0)
                            {
                                while ($row = $get->fetch_assoc())
                                {
                                    $priceMin = -10000;
                                    $priceMax = 100000000000;
                                    $areaMin = -10000;
                                    $areaMax = 100000000000;
                                    $for = "sale";
                                    $category = "house";

                                    if(isset($_GET['priceMin']))
                                        $priceMin = $_GET['priceMin']==''?-10000:$_GET['priceMin'];
                                    if(isset($_GET['priceMax']))
                                        $priceMax = $_GET['priceMax']==''?100000000000:$_GET['priceMax'];
                                    if(isset($_GET['areaMin']))
                                        $areaMin = $_GET['areaMin']==''?-10000:$_GET['areaMin'];
                                    if(isset($_GET['areaMax']))
                                        $areaMax = $_GET['areaMax']==''?100000000000:$_GET['areaMax'];
                                    if(isset($_GET['for']))
                                        $for = $_GET['for']==''?"sale":$_GET['for'];
                                    if(isset($_GET['category']))
                                        $category = $_GET['category']==''?"house":$_GET['category'];
                                    if(!validate($row, $priceMin, $priceMax, $areaMin, $areaMax, $category, $for)) {
                                        continue;
                                    }
                                    $id=$row['property_id'];
                                    $head = str_replace("# ","",explode(PHP_EOL,$row['description'])[0]);
                                    // var_dump(explode(PHP_EOL,$row['description']));
                                    $images = $row['images'];

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
                                    <div class="card" style="width: 18rem;">
                                        <div id="property<?php echo $row['property_id'] ?>Carousal" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                    $imagesArr = explode(',', $images);
                                                    if($images=='') {
                                                        $img = './media/defaultProperty.jpg';
                                                        echo "<div class='carousel-item active'>
                                                            <img src='$img' class='card-img-top custImg' alt='...'>
                                                        </div>";
                                                    }
                                                    else
                                                    for($i=0; $i<count($imagesArr); $i++) {
                                                        $active = "";
                                                        if($i==0) {
                                                            $active = "active";
                                                        }
                                                        $img = $imagesArr[$i];
                                                        echo "<div class='carousel-item $active'>
                                                            <img src='$img' class='card-img-top custImg' alt='...'>
                                                        </div>";
                                                    }
                                                ?>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#property<?php echo $row['property_id'] ?>Carousal" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#property<?php echo $row['property_id'] ?>Carousal" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $head; ?></h5>
                                            <p class="card-text"><?php echo $row['description'] ?></p>
                                            <p class="card-text price lead"><?php 
                                                // echo $row['price'];
                                                // echo $for."<br>";
                                                if($for=="For Sale")
                                                {
                                                    echo "Price: &#8377;".$price['price'];
                                                }
                                                else if($for=="For Rent")
                                                {
                                                    echo "Rent Per Month: &#8377;".$price['rprice'];
                                                }
                                                else
                                                {
                                                    echo "Price: &#8377;".$price['price']."<br>"; 
                                                    echo "Rent Per Month: &#8377;".$rprice['rprice'];
                                                }
                                            ?></p>
                                            <form action="#" method="POST">
                                                <button class="btn btn-primary" name="more" type="submit" value="<?php echo $row['property_id'] ?>">More Details</button>
                                            </form>
                                        </div>
                                    </div>

                                    <?php
                                        if(!empty($_POST['more']))
                                        {
                                            $_SESSION['property_id']=$_POST['more'];
                                            header('location:property.php');
                                        }
                                    ?>
                                    
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No Properties Listed with us in this category";
                            }
                        ?>


                    </div>
                </div>


                <div class="search-results">
                    <h2 class="my-4">Hot Properties</h2>
                    <div class="cards d-flex justify-content-center flex-wrap gap-3">
                        <?php
                            $getproperty=sql_query($conn,"SELECT property_id FROM interested GROUP BY property_id ORDER BY count(*) DESC LIMIT 3");
                            while($property=$getproperty->fetch_assoc())
                            {
                                $pid=$property['property_id'];
                                $getprop=sql_query($conn,"SELECT * FROM property WHERE property_id=$pid and category!='none'");

                                $get=$getprop;
                                // mysqli_data_seek($get, 0);
                                $rows=mysqli_num_rows($get);
                                if($rows>0)
                                {
                                    while ($row = $get->fetch_assoc())
                                    {
                                        $id=$row['property_id'];
                                        $head = str_replace("# ","",explode(PHP_EOL,$row['description'])[0]);
                                        // var_dump(explode(PHP_EOL,$row['description']));
                                        $images = $row['images'];

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
                                        <div class="card" style="width: 18rem;">
                                            <div id="property<?php echo $row['property_id'] ?>Carousal" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php
                                                        $imagesArr = explode(',', $images);
                                                        if($images=='') {
                                                            $img = './media/defaultProperty.jpg';
                                                            echo "<div class='carousel-item active'>
                                                                <img src='$img' class='card-img-top custImg' alt='...'>
                                                            </div>";
                                                        }
                                                        else
                                                        for($i=0; $i<count($imagesArr); $i++) {
                                                            $active = "";
                                                            if($i==0) {
                                                                $active = "active";
                                                            }
                                                            $img = $imagesArr[$i];
                                                            echo "<div class='carousel-item $active'>
                                                                <img src='$img' class='card-img-top custImg' alt='...'>
                                                            </div>";
                                                        }
                                                    ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#property<?php echo $row['property_id'] ?>Carousal" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#property<?php echo $row['property_id'] ?>Carousal" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $head; ?></h5>
                                                <p class="card-text"><?php echo $row['description'] ?></p>
                                                <p class="card-text price lead"><?php 
                                                    // echo $row['price'];
                                                    // echo $for."<br>";
                                                    if($for=="For Sale")
                                                    {
                                                        echo "Price: &#8377;".$price['price'];
                                                    }
                                                    else if($for=="For Rent")
                                                    {
                                                        echo "Rent Per Month: &#8377;".$price['rprice'];
                                                    }
                                                    else
                                                    {
                                                        echo "Price: &#8377;".$price['price']."<br>"; 
                                                        echo "Rent Per Month: &#8377;".$rprice['rprice'];
                                                    }
                                                ?></p>
                                                <form action="#" method="POST">
                                                    <button class="btn btn-primary" name="more" type="submit" value="<?php echo $row['property_id'] ?>">More Details</button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "No Properties Listed with us in this category";
                                }
                            }
                        ?>


                    </div>
                </div>
            </div>
        </section>
        <?php 
            require './components/footer.php';
            require './components/fontawesome.php';
            require './components/bootstrapjs.php'; 
        ?>
    </body>
</html>