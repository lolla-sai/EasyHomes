<?php
    require './components/runSQLQuery.php';
    session_start();
    $id=$_SESSION['property_id'];
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    $select=mysqli_query($conn,"SELECT * FROM property WHERE property_id=$id");
    $search_user=mysqli_query($conn,"SELECT user_id FROM user_owns WHERE property_id=$id");
    $row=mysqli_fetch_assoc($select);
    $user_id=mysqli_fetch_assoc($search_user);
    $uid=$user_id['user_id'];
    $get_user=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$uid");
    $user=mysqli_fetch_assoc($get_user);
    $latitude=$row['latitude'];
    $longitude=$row['longitude'];
    if($row['category']=="both")
    {
        $for="Sale and Rent";
        $get_price=mysqli_query($conn,"SELECT price FROM sale_price WHERE property_id=$id");
        $get_rprice=mysqli_query($conn,"SELECT rprice FROM rent_price WHERE property_id=$id");
        $price=mysqli_fetch_assoc($get_price);
        $rprice=mysqli_fetch_assoc($get_rprice);
    }
    else if($row['category']=="sale")
    {
        $for="Sale";
        $get_price=mysqli_query($conn,"SELECT price FROM sale_price WHERE property_id=$id");
        $price=mysqli_fetch_assoc($get_price);
    }
    else if($row['category']=="rent")
    {
        $for="Rent";
        $get_price=mysqli_query($conn,"SELECT rprice FROM rent_price WHERE property_id=$id");
        $price=mysqli_fetch_assoc($get_price);
    }    
    else
    {
        $for="Sold";
    }

    if(!empty($_POST['submit']))
    {
        $bid=$_POST['uid'];
        $date=$_POST['date'];
        $price=$_POST['price'];
        $update=sql_query($conn,"UPDATE property SET category='none' WHERE property_id=$id");
        $updateowner=sql_query($conn,"UPDATE user_owns SET user_id=$bid WHERE property_id=$id");
        $updateprice=sql_query($conn,"UPDATE sale_price SET price=$price WHERE property_id=$id");
        $insert=sql_query($conn,"INSERT INTO user_buys (seller_id,property_id,price,buys_on,buyer_id) VALUES ($uid,$id,$price,'$date',$bid)");
        echo "<script>alert('Property has been Sold. Thank You for using EasyHomes!')</script>";
        header('location:userpage.php');
    }

    if(!empty($_POST['delete']))
    {
        $delete=mysqli_query($conn,"DELETE from property WHERE property_id=$id");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Property <?php echo $id ?></title>

    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 400px;
        /* The width is the width of the web page */
      }
      img{
          max-height: 100%;
          max-width: 100%;
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const location = { lat: <?php echo $latitude ?>, lng: <?php echo $longitude ?> };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 20,
          center: location,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: location,
          map: map,
        });

      }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
      <h1><?php echo $id ?></h1>
      <div style="width:600px; height: 600px;">
        <img src="<?php echo $row['images'] ?>">
      </div>
      <div>
          Category: <?php echo $for ?>
      </div>
      <div>
          Description: <?php echo $row['description'] ?>
      </div>
      <div>
          Area: <?php echo $row['area'] ?> sq.ft
      </div>
        <?php 
            if($row['age']!=NULL)
            {
                ?>
                <div>
                    Property Age: <?php echo $row['age'] ?> Years
                </div>
                <?php
            }
            if($for=="Sale and Rent")
            {
                ?>
                <div>
                    Price for Sale: <?php echo $price['price'] ?>
                </div>
                <div>
                    Price for Rent: <?php echo $rprice['rprice'] ?> / Month
                </div>
                <?php
            }
            else if($for=="Sale")
            {
                ?>
                <div>
                    Price for Sale: <?php echo $price['price'] ?>
                </div>
                <?php
            }
            else if($for=="Rent")
            {
                ?>
                <div>
                    Price for Rent: <?php echo $price['rprice'] ?> / Month
                </div>
                <?php
            }

        ?>


    <h3>Location:</h3>
    <!--The div element for the map -->
    <div id="map"></div>

    <br><br>

    <?php
        if($for!="Sold")
        {
            ?>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Mark as Sold
            </button>
            <?php
        }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Buyer Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post">
        <div class="modal-body">
            Buyer ID: <input type="number" name="uid" required><br>
            Bought on Date: <input type="date" name="date" required><br>
            Price: <input type="number" name="price" required>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <br><br>
    <form action="#" method="POST">
        <button type="submit" name="delete" class="btn btn-primary" value="delete">Delete Property</button>
    </form>


    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>
