<?php
    
    session_start();
    if(!isset($_SESSION['logged_id']))
    {
        header('location:index.php');
        $_SESSION['from']="sell";
    }
    else
    {
        unset($_SESSION['from']);
        function clean_input($input) {
            return htmlspecialchars(stripslashes(trim($input)));
        }
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
    
            
            $location = clean_input($_POST['location']);
    
            if($for=='sale' || $for=='rent')
            {
                $price = clean_input($_POST['price']);
            }
            else if($for=='both')
            {
                $price = clean_input($_POST['price']);
                $rent_price = clean_input($_POST['rent_price']);
            }
            
           //$num = "<script>document.write(position[0])</script>";
           
            $description = clean_input($_POST['desc']);
            $area = clean_input($_POST['area']);
            //echo $_POST['age'];
            if($_POST['age']!=NULL)
            {
                $age= clean_input($_POST['age']);
            }
            $images = array();
    
        // Configure upload directory and allowed file types
            $upload_dir = 'media' . '/' .($_SESSION['logged_username']). '/';
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    
            // Define maxsize for files i.e 2MB
            $maxsize = 3 * 1024 * 1024;
        
            // Checks if user sent an empty form
            if(!empty($_FILES['property_pics']['name'])) {
                // print_r($_FILES['property_pics']);
                // Loop through each file in files[] array
                foreach ($_FILES['property_pics']['tmp_name'] as $key => $file) {
                    $file_tmpname = $_FILES['property_pics']['tmp_name'][$key];
                    $file_name = $_FILES['property_pics']['name'][$key];
                    $file_size = $_FILES['property_pics']['size'][$key];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        
                    // Set upload file path
                    $filepath = $upload_dir.$file_name;
    
                    // echo $file_name . " " . $file_size . " " . $file_ext . " " . $filepath . "<br>";
        
                    // Check file type is allowed or not
                    if(in_array(strtolower($file_ext), $allowed_types)) {
                        if ($file_size > $maxsize)        
                            echo "Error: File size is larger than the allowed limit.";
        
                        // If file with name already exist then append time in
                        // front of name of the file to avoid overwriting of file
                        if(file_exists($filepath)) {
                            $filepath = $upload_dir.time().$file_name;
                        }
                        
                        if(move_uploaded_file($file_tmpname, $filepath)) {
                            echo "{$file_name} successfully uploaded <br />";
                            // $images.push($filepath);
                            array_push($images, $filepath);
                        }
                        else {                    
                            echo "Error uploading {$file_name} <br />";
                        }
                    }
                    else {
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                }
            }
            else {
                
                // If no files selected
                echo "No files selected.";
            }
            $imagesStr = implode(',', $images);
            if($category=='plot' || $_POST['age']==NULL)
            {
                $sql = mysqli_query($conn, "INSERT INTO property (location, category, description, images, area) VALUES ('$location', '$for', '$description', '$imagesStr', $area)");
                $last_id = mysqli_insert_id($conn);
                if(mysqli_error($conn)) {
                    set_alert(mysqli_error($conn), "danger");
                } 
            }
            else
            {
                $sql = mysqli_query($conn, "INSERT INTO property (location, category, description, images, area,age) VALUES ('$location', '$for', '$description', '$imagesStr', $area,$age)");
                $last_id = mysqli_insert_id($conn);
                if(mysqli_error($conn)) {
                    set_alert(mysqli_error($conn), "danger");
                }
            }
            $insert=mysqli_query($conn,"INSERT INTO user_owns (user_id,property_id) VALUES ($user_id,$last_id)");
            if(mysqli_error($conn))
            {
                echo "Error in Insert";
            }

            if($category=='house') {
                mysqli_query($conn, "INSERT INTO house (house_no, plot_no, property_id) VALUES ('$house_no', '$house_plot_no', $last_id)");
                if(mysqli_error($conn)) {
                    //set_alert(mysqli_error($conn), "danger");
                    echo mysqli_error($conn);
                }
            }
            else if($category=='plot') {
                mysqli_query($conn, "INSERT INTO plot (plot_number, property_id) VALUES ('$plot_no', $last_id)");
                if(mysqli_error($conn)) {
                    //set_alert(mysqli_error($conn), "danger");
                    echo mysqli_error($conn);
                }
            }
            else if($category=='flat') {
                mysqli_query($conn, "INSERT INTO flat (flat_no, building_name, property_id) VALUES ('$flat_no', '$flat_name', $last_id)");
                if(mysqli_error($conn)) {
                    echo mysqli_error($conn);
                    // set_alert(mysqli_error($conn), "danger");
                }
            }
    
            if($for=='sale')
            {
                mysqli_query($conn,"INSERT INTO sale_price(property_id,price) VALUES ($last_id,$price)");
    
            }
            else if($for=='rent')
            {
                mysqli_query($conn,"INSERT INTO rent_price(property_id,rprice) VALUES ($last_id,$price)");
            }
            else
            {
                mysqli_query($conn,"INSERT INTO sale_price(property_id,price) VALUES ($last_id,$price)");
                mysqli_query($conn,"INSERT INTO rent_price(property_id,rprice) VALUES ($last_id,$rent_price)");
            }
            header('location:profile.php');
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
            </script>
            <style>
                #mapCanvas{
                            width: 500px;
                            height: 500px;
                        }
            </style>
</head>
<body>
    <h1>Sell/Rent A House</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
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
        <div class="input-group mb-3">
            <label for="location" class="input-group-text">Location</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="Search for a nearby place or landmark">
        </div>
        <div id="mapCanvas"></div>
        
        <div class="input-group mb-3">
            <input type="file" name="property_pics[]" id="property_pics" class="form-control" multiple accept=".jpg,.png,.jpeg,.gif">
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
            <div class="category_specific_details">
                <div class="input-group mb-3" data-name="for_sale">
                    <label for="area" class="input-group-text">Price</label>
                    <input type="number" name="price" id="price" min="10" class="form-control">
                </div>
                <div class="input-group mb-3" data-name="for_rent">
                    <label for="area" class="input-group-text">Price for Rent(Per Month)</label>
                    <input type="number" name="rent_price" id="rprice" min="10" class="form-control">
                </div>  
            </div>
            <div class="input-group mb-3" data-name="age">
                <label for="area" class="input-group-text">Number of Years Old Property:</label>
                <input type="number" name="age" id="age" class="form-control">
            </div>
        </div>
        <input type="submit" value="submit" name="submit">
    </form>

    <h1>Show Interested People</h1>
    <h1>Show Visit Requests</h1>


    <script src="toggleCategory.js"></script>
</body>
</html>
