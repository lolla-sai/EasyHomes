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
    
    if(isset($_SESSION['logged_id']))
    {
        $lid=$_SESSION['logged_id'];
        $up=mysqli_query($conn,"SELECT * FROM property WHERE property_id=$id and property_id NOT IN (SELECT distinct property_id FROM user_owns WHERE user_id=$lid)");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            if(mysqli_num_rows($up)==0)
            {
                echo "<script>alert('You can't proceed as you own this property')</script>";
                header('location:buy.php');
            }
        }
    }
    else
    {
        $_SESSION['from']="property";
        header('location:index.php');
    }
    
    if(!empty($_POST['submit']))
    {
        if(!isset($_SESSION['logged_id']))
        {
            $_SESSION['rating']=$_POST['rating'];
            if(!empty($_POST['comment']))
            {
                $_SESSION['comment']=$_POST['comment'];
            }
            else
            {
                $_SESSION['comment']="";
            }
            $_SESSION['from']="property";
            header('location:index.php');
        }
        else
        {
            $u_id=$_SESSION['logged_id'];
            $rating=$_POST['rating'];
            if(!empty($_POST['comment']))
            {
                $comment=$_POST['comment'];
                $insert=mysqli_query($conn,"INSERT INTO review (user_id,property_id,comment,rating) VALUES ($u_id,$id,'$comment',$rating)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
            }
            else
            {
                $insert=mysqli_query($conn,"INSERT INTO review (user_id,property_id,rating) VALUES ($u_id,$id,$rating)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
            }
            header('location:property.php');
        }
    }

    if(!empty($_POST['submitv']))
    {
        $userid=$_POST['u_id'];
        $propertyid=$_POST['p_id'];
        $date=$_POST['date'];
        $request_status=0;
        $insert=mysqli_query($conn,"INSERT INTO visits(user_id,property_id,date) VALUES($userid,$propertyid,'{$date}')");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "<script>confirm('Your Visit Request has been Booked and Sent to the Owner of the Property. You will be Notified once the request has been accepted')</script>";
            header('location:property.php');
        }
    }

    if(!empty($_POST['submitr']))
    {
        date_default_timezone_set("Asia/Calcutta");
        $user_id=$_SESSION['logged_id'];
        $p_id=$_POST['proid'];
        $r_time=date("Y/m/d H:i:s");
        $status=0;
        $no=$_POST['number'];
        $insert=mysqli_query($conn,"INSERT INTO rent_request(property_id,user_id,request_time,no_of_people,request_status) VALUES ($p_id,$user_id,'$r_time',$no,$status)");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            echo "<script>alert('Your Request for Rent has been sent to the Owner of the Property. You will be notified about the request status after the concerned Owner's approval')</script>";
            header('location:property.php');
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
        <?php
            require './components/star.php';
            require './components/bootstrapcss.php';
            require './components/showdownjs.php';
        ?>
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
            <div class="container d-md-flex justify-content-evenly d-block">
                <div>
                    <h2 class="text-center">Overview</h2>
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
                                    <th scope='row'>Price for Sale: $p</th>
                                    </tr>
                                    <tr>
                                    <th scope='row'>Price for Rent:</th> $rp / Month
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
                <div>
                    <h2 class="text-center">Owner Details:</h2>
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
            </div>
        </section>
        
        <section class="container py-3 mb-3">
            <div col="row">
                <div class="text-center">
                    <!-- Button trigger modal -->
                   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                   Book a Visit
                   </button>
    
                   <!-- Modal -->
                   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                   <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                       <h5 class="modal-title" id="staticBackdropLabel">Visit Request</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <form action="#" method="POST">
                           <div class="modal-body">
                               Property ID: 
                               <input type="number" name="p_id" id="p_id" class="mb-3" value="<?php echo $id; ?>" required><br>
                               Preferred Visit Date:
                               <input type="date" name="date" class="mb-3" required ><br>
                               Your User ID:
                               <input type="number" name="u_id" id="u_id" value="<?php echo $lid?>" required>
                               <br>
                           </div>
                           <div class="modal-footer">
                               <button type="submit" class="btn btn-primary" name="submitv" value="submitv">Submit Visit Request</button>
                           </div>
                       </form>
                       
                   </div>
                   </div>
                   </div>  
                   
                   <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#rent">
                   Take on Rent
                   </button>
    
                   <!-- Modal -->
                   <div class="modal fade" id="rent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                   <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                       <h5 class="modal-title" id="renth">Rent Request</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <form action="#" method="POST">
                           <div class="modal-body">
                               Property ID:
                               <input type="number" name="proid" id="proid" value="<?php echo $id; ?>"><br>
                               Number of People:
                               <input type="number" name="number" min="0" required><br>
                           </div>
                           <div class="modal-footer">
                               <button type="submit" class="btn btn-primary" name="submitr" value="submitr">Submit Rent Request</button>
                           </div>
                       </form>
                       
                   </div>
                   </div>
                   </div>
    
                   <form action="#" method="POST">
                        <p class="mb-3">Interested but want more details? Submit Your details and the Owner will Contact you back</p>
                        <button class="btn btn-primary" name="details" value="details" type="submit">Submit Your Details</button>
                    </form>
                </div>
                        
            </div>
        </section>

        <section class="p-3 my-3">
            <div class="container">
                <h4>Comments:</h4>
                <form method="POST" action="#" id="commentForm">
                    <fieldset class="rate" onclick="inputValue">
                        <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                        <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                        <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
                        <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                        <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
                        <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                        <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
                        <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                        <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
                        <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>
                        <input type="radio" id="rating0" name="rating" value="0" /><label for="rating0" title="No star"></label>
                    </fieldset><br>
                    <textarea name="comment" placeholder="Add Your Comment Here(Optional)" rows="5" cols="50" style="width: 90%;" class="d-block mx-auto"><?php if(isset($_SESSION['logged_id'])) { if(isset($_SESSION['comment'])) {echo $_SESSION['comment']; $_SESSION['comment']="";}} ?></textarea>
                    <br>
                    <input type="number" name="rating" min="0.0" max="5.0" style="display: none;" id="ratingField" value="<?php if(isset($_SESSION['logged_id'])) { if(isset($_SESSION['comment'])) {echo $_SESSION['rating']; $_SESSION['rating']="";}} ?>" required>
                    <button type="submit" value="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                    $getreview=mysqli_query($conn,"SELECT * FROM review WHERE property_id=$id");
                    if(mysqli_num_rows($getreview)>0)
                    {
                        while($review=$getreview->fetch_assoc())
                        {
                            ?>
                <div class="card my-4" style="width: 60%; min-width: 200px;">
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
                                $img_url = $us['dp'];
                                echo "<div class='d-flex align-items-center'>";
                                    echo "<img src='$img_url' style='width: 30px;height:30px;object-fit:cover;border-radius: 50%;' class='me-2'>";
                                    echo $us['name'];
                                echo "</div>";
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
        <script>
            let ratingField = document.querySelector('#ratingField');
            function inputValue(e) {
                let checkedInput = [...document.querySelector('.rate').querySelectorAll('input')].filter(inp => inp.checked)[0];
                // console.log(checkedInput.id.slice(6));
                let rating = parseInt(checkedInput.id.slice(6))*5/10;
                // console.log(rating);
                ratingField.value = rating;
            }
            document.querySelector("#commentForm").addEventListener('change', inputValue)
        </script>
        <?php
            require './components/footer.php';
            require './components/fontawesome.php';
            require './components/bootstrapjs.php';
        ?>
        <script>
            let output = markdownToHTML(document.querySelector('#markdown-output').innerText);
            document.querySelector('#markdown-output').innerHTML = output;
        </script>
    </body>
</html>
