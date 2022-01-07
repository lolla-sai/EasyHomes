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