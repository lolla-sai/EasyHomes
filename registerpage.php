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
    <style>
        input {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php
        date_default_timezone_set("Asia/Kolkata");

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "easyhomessai";
        $conn = mysqli_connect($servername, $username, $password, $dbname, 3306);

        function clean_input($input) {
            return htmlspecialchars(stripslashes(trim($input)));
        }

        if(!isset($_SESSION['email'])) {
            // $randomno = rand(0, 10000);
            // $_SESSION['email']="no-name$randomno@gmail.com";
            die("Invalid session. go back to login page.");
        }
        if(!isset($_SESSION['messages'])) {
            $_SESSION['messages']=array();
        }
        // if(!isset($_SESSION['logs'])) {
        //     $_SESSION['logs']=array();
        // }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $uname = htmlspecialchars($_POST['uname']);
            $name = htmlspecialchars($_POST['name']);
            $age = htmlspecialchars($_POST['age']);
            $phno = htmlspecialchars($_POST['phno']);
            $gender = htmlspecialchars($_POST['gender']);
            $email = $_SESSION['email'];
            echo $_POST['password1'] . "<br>";
            echo $_POST['password2'] . "<br>";
            if($_POST['password1'] !== $_POST['password2']) {
                echo("Passwords do not match!!");
            }
            $password = $_POST['password1'];
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                die('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
            }else{
                echo 'Strong password.';
            }
            $password =  password_hash($_POST['password1'], PASSWORD_DEFAULT);

            if(!is_dir("media/$uname/")) {
                if(!mkdir("media/$uname/")) {
                    die("Invalid username<br>");
                }
            }
            $target_dir = "media/$uname/";

            $d = date("YmdHis");
            $target_file = $target_dir . basename($_FILES["dp"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $target_file = $target_dir . "dp$d." . $imageFileType;

            // $d=date("Y");
            $uploadOk = 1;

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["dp"]["tmp_name"]);
                if($check !== false) {
                    // echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check file size
            echo $_FILES['dp']['size'] . "<br>";
            if ($_FILES["dp"]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["dp"]["tmp_name"], $target_file)) {
                    // echo "The file ". htmlspecialchars( basename( $_FILES["dp"]["name"])). " has been uploaded.";
                    $sql = mysqli_query($conn, "INSERT INTO users (username, name, age, dp, email, gender, phone_number, password) VALUES ('$uname', '$name', $age, '$target_file', '$email', $gender, '$phno', '$password')");
                    if(mysqli_error($conn)) 
                        echo mysqli_error($conn);
                    else {
                        session_destroy();
                        header('location:index.php');
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    ?>
    <div class="messages">
        <?php
            foreach ($_SESSION['messages'] as $msg) {
                echo "<p>$msg</p>";
            }
            $_SESSION['messages'] = array();
        ?>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data" onsubmit="submitHandler">
        Username: <input type="text" name="uname"><br>
        Full Name: <input type="text" name="name"><br>
        Age: <input type="number" name="age" id="age" min="0" max="150"><br>
        Email: <input type="email" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" disabled><br>
        DP: <input type="file" name="dp" id="dp"><br>
        Phone Number: <input type="tel" name="phno" id="phno"><br>
        Gender: <input type="radio" name="gender" id="male" value="1" checked> Male <br>
        <input type="radio" name="gender" id="male" value="2"> Female <br>
        <input type="radio" name="gender" id="male" value="3"> Other <br>
        Password: <input type="password" name="password1" id="password1"><br>
        Confirm Password: <input type="password" name="password2" id="password2"><br>
        <input type="submit" value="Sign Up" name="submit">
    </form>

    <script>
        function submitHandler() {
            let password1 = document.querySelector("#password1");
            let password2 = document.querySelector("#password2");
            if(password1.value !== password2.value) {
                alert("passwords do not match");
                return false;
            }
            return true;
        }
    </script>

</body>
</html>