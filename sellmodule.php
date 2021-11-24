<?php
    function clean_input($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
    
    session_start();

    $conn = mysqli_connect("localhost", "root", "", "easyhomessai", 3306);
    if($conn->connect_error) {
        set_alert("Database Connection Failed", "danger");
        goto endpoint;
    }

    if(isset($_POST['submit'])) {
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
        $description = clean_input($_POST['desc']);
        $area = clean_input($_POST['area']);
        $price = clean_input($_POST['price']);
        $images = array();

    // Configure upload directory and allowed file types
        $upload_dir = 'media' . '/' . ($_SESSION['username']??'lolla-sai') . '/';
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
        $sql = mysqli_query($conn, "INSERT INTO property (location, category, description, images, area, price) VALUES ('$location', '$for', '$description', '$imagesStr', $area, $price)");
        $last_id = mysqli_insert_id($conn);
        if(mysqli_error($conn)) {
            set_alert(mysqli_error($conn), "danger");
        }
        if($category=='house') {
            mysqli_query($conn, "INSERT INTO house (house_no, plot_no, property_id) VALUES ($house_no, $house_plot_no, $last_id)");
            if(mysqli_error($conn)) {
                set_alert(mysqli_error($conn), "danger");
            }
        }
        else if($category=='plot') {
            mysqli_query($conn, "INSERT INTO plot (plot_number, property_id) VALUES ($plot_no, $last_id)");
            if(mysqli_error($conn)) {
                set_alert(mysqli_error($conn), "danger");
            }
        }
        else if($category=='flat') {
            mysqli_query($conn, "INSERT INTO flat (flat_no, building_name, property_id) VALUES ($flat_no, '$flat_name', $last_id)");
            if(mysqli_error($conn)) {
                echo mysqli_error($conn);
                // set_alert(mysqli_error($conn), "danger");
            }
        }
    }
    endpoint:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Property</title>
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
                </select>
            </div>
        </div>
        <div class="category_specific_details">
            <div class="input-group mb-3" data-name="house">
                <label for="house_no" class="input-group-text">House No</label>
                <input type="number" id="house_no" name="house_no" class="form-control">
                <label for="house_plot_no" class="input-group-text">Plot No</label>
                <input type="number" id="house_plot_no" name="house_plot_no" class="form-control">
            </div>
            <div class="input-group mb-3" data-name="plot">
                <label for="plot_no" class="input-group-text">Plot No</label>
                <input type="number" id="plot_no" name="plot_no" class="form-control">
            </div>
            <div class="input-group mb-3" data-name="flat">
                <label for="flat_no" class="input-group-text">Flat No</label>
                <input type="number" id="flat_no" name="flat_no" class="form-control">
                <label for="flat_name" class="input-group-text">Building Name</label>
                <input type="text" id="flat_name" name="flat_name" class="form-control">
            </div>
        </div>
        <div class="input-group mb-3">
            <label for="location" class="input-group-text">Location</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="Search for a nearby place or landmark">
        </div>
        
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
            <div class="input-group mb-3">
                <label for="area" class="input-group-text">Price/Rent per month (in INR)</label>
                <input type="number" name="price" id="price" min="10" class="form-control">
            </div>
        </div>
        <input type="submit" value="submit" name="submit">
    </form>

    <h1>Show Interested People</h1>
    <h1>Show Visit Requests</h1>


    <script src="toggleCategory.js"></script>
</body>
</html>