<?php
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
    $location=$row['location'];
    $coordinates=explode(",",$location);
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
    else
    {
        $for="Rent";
        $get_price=mysqli_query($conn,"SELECT rprice FROM rent_price WHERE property_id=$id");
        $price=mysqli_fetch_assoc($get_price);
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
        const location = { lat: <?php echo $coordinates[0] ?>, lng: <?php echo $coordinates[1] ?> };
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
            else
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

    <h4>Owner Details:</h4>
    <div>
        Name: <?php echo $user['name'] ?>
    </div>
    <div>
        Gender: <?php
            if($user['gender']==1)
            {
                echo "Male";
            }
            else if($user['gender']==2)
            {
                echo "Female";
            }
            else
            {
                echo "NA";
            }
         ?>
    </div>
    <div>
        Phone Number: <?php echo $user['phone_number'] ?>
    </div>
    <div>
        Email ID: <?php echo $user['email'] ?>
    </div> 
    <br><br>

    <div col="row">
        <form action="#" method="POST">
            <button class="btn btn-primary" name="visit" value="visit" type="submit">Book a Visit</button>
            <?php
                if($for=="Rent" || $for=="Sale and Rent")
                {
                    ?>
                    <button class="btn btn-primary" name="rent" value="rent" type="submit">Take on Rent</button>
                    <?php
                }
            ?>
            <br>
            Interested? Submit Your details and the Owner will Contact you back<br>
            <button class="btn btn-primary" name="details" value="details" type="submit">Submit Your Details</button>
        </form>

    </div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>
<?php
    if(!empty($_POST['visit']))
    {
        header('location:visit.php');
    }
    if(!empty($_POST['rent']))
    {
        header('location:rent.php');
    }
    if(!empty($_POST['details']))
    {
        header('location:details.php');
    }
?>