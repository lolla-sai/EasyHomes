<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
    </style>
</head>
<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: #41dae1;">
    <?php
        require './sendmail.php';

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "easyhomessai";
        $conn = mysqli_connect($servername, $username, $password, $dbname, 3306);

        function clean_input($input) {
            return htmlspecialchars(stripslashes(trim($input)));
        }

        if(!isset($_SESSION['email'])) {
            set_alert("Invalid session. Go back to login page", "danger");
            goto endpoint;
        }
        if(!isset($_SESSION['messages'])) {
            $_SESSION['messages']=array();
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $uname = htmlspecialchars($_POST['uname']);
            $name = htmlspecialchars($_POST['name']);
            $age = htmlspecialchars($_POST['age']);
            $phno = htmlspecialchars($_POST['phno']??"");
            $gender = htmlspecialchars($_POST['gender']);
            $email = $_SESSION['email'];

            $sql = mysqli_query($conn, "SELECT * from users WHERE username='$uname'");
            if(mysqli_error($conn)) {
                set_alert(mysqli_error($conn), "danger");
                goto endpoint;
            }
            else {
                if(mysqli_num_rows($sql)) {
                    set_alert("User with the same username already exists! Select some other username.", "info");
                    goto endpoint;
                }
            }

            if($_POST['password1'] !== $_POST['password2']) {
                set_alert("Passwords do not match!", "danger");
                goto endpoint;
            }
            $password = $_POST['password1'];
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                set_alert('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character', 'danger');
                goto endpoint;
            }
            $password =  password_hash($_POST['password1'], PASSWORD_DEFAULT);

            $dp_provided = true;

            if(!$_FILES["dp"]["tmp_name"]) {
                // set_alert('Blank File Name', 'danger');
                $target_file = 'media/default.jpg';
                $dp_provided = false;
            }

            if($dp_provided and !is_dir("media/$uname/")) {
                if(!mkdir("media/$uname/")) {
                    set_alert("Invalid username", "danger");
                    goto endpoint;
                }
                $target_dir = "media/$uname/";
    
                $d = date("YmdHis");
                $target_file = $target_dir . basename($_FILES["dp"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $target_file = $target_dir . "dp$d." . $imageFileType;
            }
            $uploadOk = 1;

            // Check file size
            // echo $_FILES['dp']['size'] . "<br>";
            if ($dp_provided and $_FILES["dp"]["size"] > 5000000) {
                set_alert("File is too large. Please ensure dp size is less than 4.67Mb", "danger");
                $uploadOk = 0;
                // goto endpoint;
            }

            // Check if image file is a actual image or fake image
            if($dp_provided and isset($_POST["submit"])) {
                $check = getimagesize($_FILES["dp"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    set_alert("File is not an image", "danger");
                    // goto endpoint;
                    $uploadOk = 0;
                }
            }

            // Allow certain file formats
            if($dp_provided and $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                set_alert("Invalid File Format: Only JPG, JPEG, PNG & GIF files are allowed.", "danger");
                // goto endpoint;
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                set_alert("There was an error uploading your file", "danger");
                goto endpoint;
                // unlink($target_file);
            } else {
                if (!$dp_provided or move_uploaded_file($_FILES["dp"]["tmp_name"], $target_file)) {
                    $sql = mysqli_query($conn, "INSERT INTO users (username, name, age, dp, email, gender, phone_number, password) VALUES ('$uname', '$name', $age, '$target_file', '$email', $gender, '$phno', '$password')");
                    if(mysqli_error($conn)) {
                        set_alert(mysqli_error($conn), "danger");
                        goto endpoint;
                    }
                    else {
                        session_destroy();
                        session_start();
                        $_SESSION['messages'] = array();
                        set_alert("Account Created successfully! You can login now.", "success");
                        header('location:index.php');
                    }
                } else {
                    set_alert("There was an error uploading your file! Check your file size and see that its not corrupted!", "danger");
                    if($dp_provided) {
                        unlink($target_file);
                    }
                }
            }
        }
        endpoint:
    ?>
    <div class="messages" style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 90%;">
        <?php
            foreach ($_SESSION['messages'] as $msg) {
                // echo "<p>$msg</p>";
                $msgArr = explode("-->", $msg, 2);
                echo "<div class='alert alert-$msgArr[0] alert-dismissible fade show' role='alert'>
                        <span>$msgArr[1]</span>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
            $_SESSION['messages'] = array();
        ?>
    </div>

    <div class="container rounded my-3 mx-auto p-4 bg-white rounded-3 shadow-lg w-80" style="max-width: 800px;">
        <h1 class="mb-4">Sign Up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data" onsubmit="submitHandler">
            <div class="d-md-flex d-block gap-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    <input type="text" name="uname" id="uname" placeholder="Username" class="form-control">
                    <input type="text" name="name" placeholder="Full Name" class="form-control">
                </div>
                <div class="input-group mb-3">
                    <input type="number" name="age" id="age" min="0" max="150" placeholder="Age" class="form-control"> <!--style="max-width: 100px;"-->
                    <select class="form-select" name="gender"> <!--style="max-width: 200px;"-->
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
            </div>
            <div class="d-md-flex d-block gap-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" disabled placeholder="Email">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone-alt"></i></span>
                    <input type="tel" name="phno" id="phno" class="form-control" placeholder="Phone Number">
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="dp" id="dp">
                <label class="input-group-text" for="dp">DP</label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input class="form-control" type="password" name="password1" id="password1" placeholder="Password"><br>
                <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm Password"><br>
            </div>
            <input type="submit" value="Sign Up" name="submit" class="btn btn-primary mt-2">
        </form>
    </div>

    <script>
        function submitHandler() {
            let password1 = document.querySelector("#password1");
            let password2 = document.querySelector("#password2");
            if(password1.value !== password2.value) {
                // alert("passwords do not match");
                return false;
            }
            return true;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script
      src="https://kit.fontawesome.com/529db58a1d.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>