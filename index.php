<?php
    require './register.php';
    require './components/initialiseMessages.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/SignUp</title>
    <?php
        require './components/bootstrapcss.php';
    ?>
</head>
<body class="d-flex justify-content-center align-items-center p-3" style="min-height: 100vh; background: #41dae1;">
    <div class="container bg-white p-3 rounded-3 shadow-lg" style="max-width: 500px;">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php
                if(isset($_GET['login']) || ((!isset($_GET['login']) && (!isset($_GET['signup']))))) echo "active" ?>" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if(isset($_GET['signup'])) echo "active" ?>" id="pills-signup-tab" data-bs-toggle="pill" data-bs-target="#pills-signup" type="button" role="tab">Sign Up</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane <?php
                if(isset($_GET['login']) || ((!isset($_GET['login']) && (!isset($_GET['signup']))))) echo "show active" ?> p-3" id="pills-login" role="tabpanel">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" data-name="login">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="uname" id="uname" placeholder="Username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Log in" name="Login" class="btn btn-success d-block w-100 mt-4">
                </form>
            </div>
            <div class="tab-pane <?php if(isset($_GET['signup'])) echo "show active" ?> p-3" id="pills-signup" role="tabpanel">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?signup=signup' ?>" method="post" data-name="signup">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="email" class="form-control" id="email" name="email_id" placeholder="Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" <?php if(isset($_SESSION['email'])) echo "readonly"; ?>>
                        <input type="submit" class="btn btn-primary" value="Send OTP" name="send_otp" <?php if(isset($_SESSION['email'])) echo "disabled";?> >
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        <input type="number" class="form-control" name="OTP" id="OTP" placeholder="OTP" disabled>
                        <input type="submit" class="btn btn-success" value="Verify OTP" id="OTP_BUTTON" name="verify_otp" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        require './components/bootstrapjs.php';
        require './components/fontawesome.php';
        require './components/displayMessages.php';
    ?>
</body>
</html>