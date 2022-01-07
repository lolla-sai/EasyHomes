<?php
    session_start();
    require './components/bootstrapcss.php';
    if(!isset($_SESSION['logged_id']))
    {
        $_SESSION['from']="pmc";
        header('location:index.php');
    }
    else
    {
        $c_id=$_SESSION['pm_cid'];
        $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
        $select=mysqli_query($conn,"SELECT * from pm_category WHERE category_id=$c_id");
        $row=mysqli_fetch_assoc($select);
    }
?>
<?php
    if(!empty($_POST['book']))
    {
        date_default_timezone_set("Asia/Calcutta");
        $user_id=$_SESSION['logged_id'];
        $c_id=$row['category_id'];
        $status=0;
        $b_time=date("Y/m/d H:i:s");
        $no=$_POST['no'];
        $s_l=$_POST['s_location'];
        $d_l=$_POST['d_location'];
        $insert=mysqli_query($conn,"INSERT INTO books(user_id,category_id,status,booking_time,no_of_trucks,source,destination) VALUES($user_id,$c_id,$status,'$b_time',$no,'$s_l','$d_l')");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        if($no>$row['no_of_trucks'])
        {
            echo "<script>alert('The number of trucks required are not available with us currently. Your Booking Request has been sent and will be accepted as soon as the required number of trucks are available with us. Sorry for the inconvinience caused')</script>";
        }
        else
        {
            echo "<script>alert('Your Booking Request for Packers and Movers has been registered with us. We will get back to you soon with the other details as soon as our Team processes your request')</script>";
        }
        header('location:packersandmovers.php');
    }
?>
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
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE"></script>
        <script>
            var position = [15.496596, 73.835353];
            
            function initialize() { 
                var latlng = new google.maps.LatLng(position[0], position[1]);
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
                document.querySelector("#location").value=position;
                if(i!=numDeltas){
                    i++;
                    setTimeout(moveMarker, delay);
                }
            }

            //For Second Map

            var positiond = [15.496596, 73.835353];
            
            function initialized() { 
                var latlngd = new google.maps.LatLng(positiond[0], positiond[1]);
                var myOptionsd = {
                    zoom: 16,
                    center: latlngd,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                mapd = new google.maps.Map(document.getElementById("mapCanvas2"), myOptionsd);
            
                markerd = new google.maps.Marker({
                    position: latlngd,
                    map: mapd,
                    title: "Latitude:"+positiond[0]+" | Longitude:"+positiond[1]
                });
            
                google.maps.event.addListener(mapd, 'click', function(event) {
                    var resultd = [event.latLng.lat(), event.latLng.lng()];
                    transitiond(resultd);
                });
            }
            
            //Load google map
            google.maps.event.addDomListener(window, 'load', initialized);
            
            
            var numDeltasd = 100;
            var delayd = 10; //milliseconds
            var i_d = 0;
            var deltaLatd;
            var deltaLngd;
            
            function transitiond(resultd){
                i_d = 0;
                deltaLatd = (resultd[0] - positiond[0])/numDeltasd;
                deltaLngd = (resultd[1] - positiond[1])/numDeltasd;
                moveMarkerd();
            }
            
            function moveMarkerd(){
                positiond[0] += deltaLatd;
                positiond[1] += deltaLngd;
                var latlngd = new google.maps.LatLng(positiond[0], positiond[1]);
                markerd.setTitle("Latitude:"+positiond[0]+" | Longitude:"+positiond[1]);
                markerd.setPosition(latlngd);
                document.querySelector("#d_location").value=positiond;
                if(i_d!=numDeltasd){
                    i_d++;
                    setTimeout(moveMarkerd, delayd);
                }
            }
        </script>
        <style>
            #mapCanvas{
                width: 100%;
                max-width: 500px;
                height: 500px;
            }
            #mapCanvas2{
                width: 100%;
                max-width: 500px;
                height: 500px;
            }
        </style>
    </head>
    <body>
        <?php
            require './components/navbar.php';
        ?>
        <section class="categoryDetails px-3 py-5">
            <div class="container">
                <div class="card my-3 mx-auto" style="max-width: 700px;">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-5">
                            <img src="./media/verylargetruck.jpg" class="img-fluid rounded-start d-block mx-auto" alt="...">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['category_name'] ?> (Id: <?php echo $row['category_id'] ?>)</h5>
                                <p class="card-text"><?php echo $text; ?></p>
                                <p class="card-text">
                                    <b>Capacity:</b> <?php echo $row['capacity'] ?><br>
                                    <b>Base Price:</b> <?php echo $row['base_price'] ?><br>
                                    <b>Number of Trucks Available:</b> <?php echo $row['no_of_trucks'] ?><br>
                                    <b>Price/km:</b> <?php echo $row['price_km'] ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-light px-3 py-5">
            <div class="container">
                <h2>Book Trucks</h2>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Number of Trucks Required*</label>
                        <input type="number" class="form-control" min="0" name="no" required><br>
                    </div>
                    <div class="mapsContainer mb-3 d-block d-md-flex align-items-center justify-content-center gap-4">
                        <div class="map1 flex-fill">
                            <h3 class="text-center">From</h3>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Source Location</span>
                                <input type="text" id="location" class="form-control" name="s_location" placeholder="Select Location on the Map Below" required>
                            </div>
                            <div id="mapCanvas" class="mx-auto my-1"></div>
                        </div>
                        <div class="map2 flex-fill">
                            <h3 class="text-center">To</h3>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Destination Location</span>
                                <input type="text" id="d_location" class="form-control" name="d_location" placeholder="Select Location on the Map Below" required>
                            </div>
                            <div id="mapCanvas2" class="mx-auto my-1"></div>
                        </div>
                    </div>
                    <button type="submit" name="book" value="book" class="btn btn-lg btn-success" style="width: 10rem;">Book</button>

                    <p>Note: In case the number of trucks required are not available currently with us, we will accept your Booking Request as soon as the trucks are available</p>
                </form>
            </div>
        </section>
    </body>
    <?php
        require './components/bootstrapjs.php';
    ?>
</html>