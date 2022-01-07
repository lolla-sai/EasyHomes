<?php
    require './components/runSQLQuery.php';
    require './components/bootstrapcss.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
            height: 90vw;
            max-height: 400px;
            /* The height is 400 pixels */
            width: 90vw;
            max-width: 400px;
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
  </head>
  <body>
      <?php
            require './components/navbar.php';
        ?>
        <section class="py-3 mb-2">
            <div class="container">
                <h1 class="mb-5"><?php echo str_replace("# ","",explode(PHP_EOL,$row['description'])[0]);?></h1>

                <div id="propertyPicsCarousal" class="carousel slide carousel-dark" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                        $imagesArr = explode(',', $row['images']);
                        $active = 'active';
                        foreach ($imagesArr as $img) {
                            echo "<div class='carousel-item $active'>
                                <img src='$img' class='d-block mx-auto w-100' style='width: 80vh; height: 80vh; object-fit: contain;' alt='...'>
                            </div>";
                            $active = '';
                        }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#propertyPicsCarousal" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#propertyPicsCarousal" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                </div>
            </div>
        </section>

        <section id="overview" class="py-3 my-3">
            <div class="container">
                <h2 class="my-3">Overview</h2>
                <div class="container">
                    <table class="table table-bordered mx-auto" style="max-width: 600px;">
                        <tbody>
                            <tr>
                                <th scope="row">Category</th>
                                <td><?php echo $for ?></td>
                            </tr>
                            <!-- <tr>
                                <th scope="row">Description: </th>
                                <td><?php echo $row['description'] ?></td>
                            </tr> -->
                            <tr>
                                <th scope="row">Area: </th>
                                <td><?php echo $row['area'] ?> sq.ft</td>
                            </tr>
                            <?php
                                if($row['age'] != NULL) {
                                    $age = $row['age'];
                                    echo "<tr>
                                        <th scope='row'>Property Age: </th><td>$age Years</td>
                                    </tr>";
                                }
                                if($for=="Sale and Rent")
                                {
                                    $p = $price['price'];
                                    $rp = $rprice['rprice'];
                                    echo "<tr>
                                    <th scope='row'>Price for Sale: </th>
                                    <td>$p</td>
                                    </tr>
                                    <tr>
                                    <th scope='row'>Price for Rent:</th> 
                                    <td>$rp / Month</td>
                                    </tr>";
                                }
                                else if($for=="Sale")
                                {
                                    $p = $price['price'];
                                    echo "<tr>
                                    <th scope='row'>Price for Sale: </th>
                                    <td>$p</td>
                                    </tr>";
                                }
                                else if($for=="Rent")
                                {
                                    $rp = $price['rprice'];
                                    echo "<tr>
                                        <th scope='row'>Price for Rent:</th> <td>$rp / Month</td>
                                    </div>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="description">
            <div class="container">
                <div id="markdown-output" class="bg-light p-3 border"><?php
                    echo implode('<br>', explode(PHP_EOL, $row['description'])); 
                ?></div>

                <div class="py-3">
                    <h3 class="mb-4">Location:</h3>
                    <div id="map"></div>
                </div><br><br><br>

                <h4 class="text-center">Owner Details:</h4>
                <table class="table table-bordered mx-auto" style="max-width: 600px;">
                    <tbody>
                        <tr>
                            <th scope="row">Name:</th>
                            <td><?php echo $user['name'] ?></td>
                        </tr>

                        <tr>
                            <th scope="row">Gender</th>
                            <td><?php
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
                            ?></td>
                        </tr>

                        <tr>
                            <th scope="row">Phone Number:</th>
                            <td><?php echo $user['phone_number'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email ID:</th>
                            <td><?php echo $user['email'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <?php
        if($for!="Sold")
        {
            ?>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary d-block mx-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
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
        <button type="submit" name="delete" class="btn btn-danger d-block mx-auto" value="delete">Delete Property</button>
    </form>
        

        <section class="p-3 my-3">
            <div class="container">
                <h4>Comments:</h4>
                <?php
                    $getreview=mysqli_query($conn,"SELECT * FROM review WHERE property_id=$id");
                    if(mysqli_num_rows($getreview)>0)
                    {
                        while($review=$getreview->fetch_assoc())
                        {
                            ?>
                <div class="card my-4">
                    <h5 class="card-header">
                        <?php
                            $us=$review['user_id'];
                            $getuser=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$us");
                            if(mysqli_error($conn))
                            {
                                echo mysqli_error($conn);
                            }
                            else
                            {
                                $us=mysqli_fetch_assoc($getuser);
                                echo $us['name'];
                            }
                            ?>
                    </h5>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $review['rating']." / 5" ?></h5>
                        <p class="card-text"><?php echo $review['comment'] ?></p>
                    </div>
                </div>
                <?php
                    }
                    }
                    else
                    {
                    ?>
                <div class="card">
                    <div class="card-body">
                        No Comments
                    </div>
                </div>
                <?php
                    }
                    ?>
            </div>
        </section>
        <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE&callback=initMap&libraries=&v=weekly"
            async
        ></script>
        <?php
            require './components/footer.php';
            require './components/fontawesome.php';
            require './components/showdownjs.php';
        ?>
        <script>
            let output = markdownToHTML(document.querySelector('#markdown-output').innerText);
            document.querySelector('#markdown-output').innerHTML = output;
        </script>


    


    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
  </body>
  <?php
        require './components/bootstrapjs.php';
    ?>
</html>
