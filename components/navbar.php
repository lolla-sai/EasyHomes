<style>
    .profile img {
        display: block;
        width: 50px;
        height: 50px;
        object-fit: cover;
        max-width: 100%;
        border-radius: 50%;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="./media/icons8-home-240.png" alt="Home Icon" width="30" height="24" class="d-inline-block align-text-top">
                EasyHomes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="buy.php">Buy</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="sell.php">Sell</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="packersandmovers.php">Packers and Movers</a>
                    </li>
                </ul>
                <?php 
                if(isset($_SESSION['logged_id']))
                {
                    ?>
                        <div class="dropdown profile">
                            <div class="d-flex" data-bs-toggle="dropdown">
                            <img src="<?php echo $_SESSION['logged_dp']; ?>" alt="DP">
                            <a class="nav-link dropdown-toggle" role="button" id="profileDropdownLink"><?php echo $_SESSION['logged_username']; ?></a>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="userpage.php">Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                    <form action="index.php" method="GET">
                        <button type="submit" class="btn" name="login" value="login">Login</button>
                        <button type="submit" class="btn btn-primary " name="signup" value="signup">Sign Up</button>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </nav>