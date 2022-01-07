<?php 
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    $user_id=$_SESSION['logged_id'];

    //require './components/runSQLQuery.php';
    

    if(!empty($_POST['accept']))
    {
        $vid=$_POST['accept'];
        $update=mysqli_query($conn,"UPDATE visits SET request_status=1 WHERE visit_id=$vid");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }
    if(!empty($_POST['deny']))
    {
        $vid=$_POST['deny'];
        $update=mysqli_query($conn,"UPDATE visits SET request_status=2 WHERE visit_id=$vid");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }
    if(!empty($_POST['deletev']))
    {
        $vid=$_POST['deletev'];
        $update=mysqli_query($conn,"DELETE FROM visits WHERE visit_id=$vid");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }

    if(!empty($_POST['submitdate']))
    {
        $request_id=$_POST['rid'];
        $request=mysqli_query($conn,"UPDATE rent_request SET request_status=1 WHERE rr_id=$request_id");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            $getrequest=mysqli_query($conn,"SELECT * FROM rent_request WHERE rr_id=$request_id");
            $req=mysqli_fetch_assoc($getrequest);
            $p_id=$req['property_id'];
            $u_id=$req['user_id'];
            $date=$_POST['date'];
            echo "Date: $date<br>";
            $nop=$req['no_of_people'];
            $getprice=mysqli_query($conn,"SELECT * from rent_price WHERE property_id=$p_id");
            $price=mysqli_fetch_assoc($getprice);
            $rprice=$price['rprice'];
            $insert_tenant=mysqli_query($conn,"INSERT INTO tenant (property_id,tenant_id,rprice,start_date,no_of_people) VALUES ($p_id,$u_id,$rprice,'$date',$nop)");
            if(mysqli_error($conn))
            {
                echo mysqli_error($conn);
            }
            else
            {
                $delete_request=mysqli_query($conn,"DELETE FROM rent_request WHERE rr_id=$request_id");
            }
            header('location:userpage.php');
        }
    }

    if(!empty($_POST['deleter']))
    {
        $request_id=$_POST['deleter'];
        echo $request_id;
        $deleter=mysqli_query($conn,"DELETE FROM rent_request WHERE rr_id=$request_id");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }

    if(!empty($_POST['done']))
    {
        $r_id=$_POST['done'];
        $updater=mysqli_query($conn,"UPDATE books SET request_status=2 WHERE request_id=$r_id");
        if(mysqli_error($conn))
        {
            echo mysqli_error($conn);
        }
        else
        {
            header('location:userpage.php');
        }
    }

    if(!empty($_POST['view']))
    {
        $_SESSION['property_id']=$_POST['view'];
        header('location:userproperty.php');
    }

    if(!empty($_POST['leaverent']))
    {
        $rid=$_POST['r_id'];
        $edate=$_POST['edate'];
        $updaterent=mysqli_query($conn,"UPDATE tenant SET end_date='$edate' WHERE rent_id=$rid");
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
<html>
    <head>
        <title>
            Profile Page
        </title>
        <?php
            require "./components/bootstrapcss.php";
        ?>
    </head>
    <body>

    <script>
        function sendData(id)
        {
            document.querySelector("#rid").value=id;
        }
        function sendid(r_id)
        {
            document.querySelector("#r_id").value=r_id;
        }
    </script>

    <div class="d-flex align-items-start">
    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"><a href="home.php" style="text-decoration: none;">Go Back</a></button>
        <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile">My Profile</button>
        <button class="nav-link" id="v-pills-properties-tab" data-bs-toggle="pill" data-bs-target="#v-pills-properties" type="button" role="tab" aria-controls="v-pills-messages">My Properties</button>
        <button class="nav-link" id="v-pills-rented-tab" data-bs-toggle="pill" data-bs-target="#v-pills-rented" type="button" role="tab" aria-controls="v-pills-settings">Rented Properites</button>
        <button class="nav-link" id="v-pills-visit-tab" data-bs-toggle="pill" data-bs-target="#v-pills-visit" type="button" role="tab" aria-controls="v-pills-settings">Visit Requests</button>
        <button class="nav-link" id="v-pills-interested-tab" data-bs-toggle="pill" data-bs-target="#v-pills-interested" type="button" role="tab" aria-controls="v-pills-settings">Interested Users</button>
        <button class="nav-link" id="v-pills-rentreq-tab" data-bs-toggle="pill" data-bs-target="#v-pills-rentreq" type="button" role="tab" aria-controls="v-pills-settings">Rent Requests</button>
        <button class="nav-link" id="v-pills-pm-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pm" type="button" role="tab" aria-controls="v-pills-settings">Packers and Movers</button>
        <button class="nav-link" id="v-pills-tenants-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tenants" type="button" role="tab" aria-controls="v-pills-settings">Your Tenants</button>
        <button class="nav-link" id="v-pills-yvisit-tab" data-bs-toggle="pill" data-bs-target="#v-pills-yvisit" type="button" role="tab" aria-controls="v-pills-settings">Your Visit Requests</button>
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"></div>

        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

            <?php
                $getus=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$user_id");
                $userde=mysqli_fetch_assoc($getus);
                if($userde['gender']==1)
                {
                    $gender="Male";
                }
                else if($userde['gender']==2)
                {
                    $gender="Female";
                }
                else
                {
                    $gender="Others";
                }
            ?>
            <h5>User ID: <?php echo $userde['user_id'] ?></h5><br><br>
            Profile Picture:
            <div>
                <img src="<?php echo $userde['dp']; ?>" class="img-circle" alt="Profile Picture" width="304" height="236">
            </div>
            <br><br>
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $userde['name']; ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Age</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $userde['age']; ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $userde['email']; ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Gender</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $gender; ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $userde['username']; ?>">
                    </div>
                </div>
                <br>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Phone Number</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="staticEmail" value="<?php echo $userde['phone_number']; ?>">
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div> -->
            </form>
        </div>

        <div class="tab-pane fade" id="v-pills-properties" role="tabpanel" aria-labelledby="v-pills-messages-tab">
            <?php
            require './components/runSQLQuery.php';
                $select=sql_query($conn,"SELECT * FROM property WHERE property_id IN (SELECT property_id from user_owns WHERE user_id=$user_id)");
                if(mysqli_num_rows($select)>0)
                {
                    ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Property ID</th>
                                <th scope="col">Property Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Area</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total=0;
                            while($property=$select->fetch_assoc())
                            {
                                ?>
                                <tr>
                                <th scope="row"><?php echo $property['property_id'] ?></th>
                                <td><?php echo "Property Name" ?></td>
                                <td><?php echo $property['category'] ?></td>
                                <td><?php echo $property['area'] ?></td>
                                <td>
                                <form action="#" method="POST">
                                    <button type="submit" class="btn btn-primary" name="view" value="<?php echo $property['property_id'] ?>">View</button>
                                </form>
                                </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php

                }
                else
                {
                    ?>
                    <br>
                    <div class="card">
                    <div class="card-body">
                        You don't own any properties as of now
                    </div>
                    </div>
                    <?php
                }
                ?>
        </div>
        <div class="tab-pane fade" id="v-pills-rented" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            Requested Properties:
            <?php
                $rent=sql_query($conn,"SELECT * FROM property WHERE property_id IN (SELECT property_id FROM rent_request WHERE user_id=$user_id)");
                $rent_num=mysqli_num_rows($rent);
                if($rent_num<=0)
                {
                    ?>
                    <br>
                    <div class="card">
                    <div class="card-body">
                        You have not Requested any properties currently
                    </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Property ID</th>
                            <th scope="col">Property Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Area</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($rproperty=$rent->fetch_assoc())
                        {
                            ?>
                            <tr>
                            <th scope="row"><?php echo $rproperty['property_id'] ?></th>
                            <td><?php echo "Property Name" ?></td>
                            <td><?php echo $rproperty['category'] ?></td>
                            <td><?php echo $rproperty['area'] ?></td>
                            <td>
                            <form action="#" method="POST">
                                <button type="submit" class="btn btn-primary" name="pview" value="<?php echo $rproperty['property_id'] ?>">View</button>
                            </form>
                            </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <?php
                }
            ?>
            <br><br>
            Rented Properties:
            <?php
                $rented=sql_query($conn,"SELECT * FROM tenant WHERE tenant_id=$user_id");
                $rented_num=mysqli_num_rows($rented);
                if($rented_num<=0)
                {
                    ?>
                    <br>
                    <div class="card">
                    <div class="card-body">
                        You have not taken any properties on Rent
                    </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Property ID</th>
                            <!-- <th scope="col">Property Name</th> -->
                            <th scope="col">Area</th>
                            <th scope="col">Number of People</th>
                            <th scope="col">Rent Price</th>
                            <th scope="col">Owner Name</th>
                            <th scope="col">Owner Contact Number</th>
                            <th scope="col">Owner Email ID</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($r_property=$rented->fetch_assoc())
                        {
                            $pr_id=$r_property['property_id'];
                            $getpr=sql_query($conn,"SELECT * FROM property WHERE property_id=$pr_id");
                            $pr=mysqli_fetch_assoc($getpr);
                            $getur=sql_query($conn,"SELECT * FROM users WHERE user_id=(SELECT user_id FROM user_owns WHERE property_id=$pr_id)");
                            $ur=mysqli_fetch_assoc($getur)
                            ?>
                            <tr>
                            <th scope="row"><?php echo $r_property['property_id'] ?></th>
                            <!-- <td><?php //echo "Property Name" ?></td> -->
                            <td><?php echo $pr['area'] ?></td>
                            <td><?php echo $r_property['no_of_people'] ?></td>
                            <td><?php echo $r_property['rprice'] ?></td>
                            <td><?php echo $ur['name'] ?></td>
                            <td><?php echo $ur['phone_number'] ?></td>
                            <td><?php echo $ur['email'] ?></td>
                            <td><?php echo $r_property['start_date'] ?></td>
                            <td><?php echo $r_property['end_date'] ?></td>
                            <td>
                                <?php
                                    if($r_property['end_date']==NULL)
                                    {
                                        ?>
                                        <!-- Button trigger modal -->
                                        <!-- <form method="POST" action=""> -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#endrent" name="modalb" onclick="sendid(<?php echo $r_property['rent_id'] ?>)">
                                            Leave House
                                            </button>
                                        <?php
                                    }
                                ?>
                                <!-- </form> -->

                                <!-- Modal -->
                                <div class="modal fade" id="endrent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="leavehouse">Leaving Date</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="modal-body">
                                            ID:
                                            <input type="number" name="r_id" id="r_id">
                                            End Date:
                                            <input type="date" name="edate">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="leaverent" value="<?php echo $r_property['rent_id'] ?>">Submit</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <?php
                }
            ?>

        </div>
        <div class="tab-pane fade" id="v-pills-visit" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            <?php
                $visit=sql_query($conn,"SELECT * from visits WHERE property_id IN (SELECT property_id FROM user_owns WHERE user_id=$user_id)");
                if(mysqli_num_rows($visit)>0)
                {
                    ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Property ID</th>
                                <th scope="col">User ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">User Contact</th>
                                <th scope="col">User Email ID</th>
                                <th scope="col">Visit Date</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
    
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($row=$visit->fetch_assoc())
                            {
                                ?>
                                <tr>
                                <th scope="row"><?php echo $row['property_id'] ?></th>
                                <td><?php echo $row['user_id'] ?></td>
                                <td>
                                    <?php 
                                        $uid=$row['user_id'];
                                        $getuser=sql_query($conn,"SELECT * from users WHERE user_id=$uid");
                                        $user=mysqli_fetch_assoc($getuser);
                                        echo $user['name'];
                                    ?>
                                </td>
                                <td><?php echo $user['phone_number'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td>
                                    <?php
                                        if($row['request_status']==0)
                                        {
                                            echo "Pending";
                                        }
                                        else
                                        {
                                            echo "Accepted";
                                        }
                                    ?>
                                </td>
                                <?php
                                    if($row['request_status']==0)
                                    {
                                        ?>
                                        <td>
                                        <form action="#" method="POST">
                                            <button type="submit" class="btn btn-primary" name="accept" value="<?php echo $row['visit_id'] ?>">Accept</button>
                                        </form>
                                        </td>
                                        <td>
                                        <form action="#" method="POST">
                                            <button type="submit" class="btn btn-primary" name="deny" value="<?php echo $row['visit_id'] ?>">Deny</button>
                                        </form>
                                        </td>
                                        <?php
                                    }
                                ?>
                            
                                <td>
                                    <form action="#" method="POST">
                                        <button type="submit" class="btn btn-primary" name="deletev" value="<?php echo $row['visit_id'] ?>">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
                else
                {
                    $ifprop=sql_query($conn,"SELECT * FROM user_owns WHERE user_id=$user_id");
                    if(mysqli_num_rows($ifprop)>0)
                    {
                        ?>
                        <br>
                        <div class="card">
                        <div class="card-body">
                            You don't have any Visit Requests Currently
                        </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <br>
                        <div class="card">
                        <div class="card-body">
                            You don't own any propeties as of now
                        </div>
                        </div>
                        <?php
                    }
                }
                ?>
        </div>
        <div class="tab-pane fade" id="v-pills-interested" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            <?php
                $interested=mysqli_query($conn,"SELECT * from interested WHERE property_id IN (SELECT DISTINCT property_id FROM user_owns where user_id=$user_id)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
                else
                {
                    if(mysqli_num_rows($interested)>0)
                    {
                        ?>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Property ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Alternate Phone Number</th>
                            <th scope="col">Email ID</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($irow=$interested->fetch_assoc())
                        {
                            ?>
                            <tr>
                            <th scope="row"><?php echo $irow['property_id'] ?></th>
                            <td><?php echo $irow['user_id'] ?></td>
                            <td>
                                <?php 
                                    $uid=$irow['user_id'];
                                    $getuser=sql_query($conn,"SELECT * from users WHERE user_id=$uid");
                                    $user=mysqli_fetch_assoc($getuser);
                                    echo $user['name'];
                                ?>
                            </td>
                            <td><?php echo $irow['phone_number'] ?></td>
                            <td><?php echo $irow['alt_phone_number'] ?></td>
                            <td><?php echo $irow['email_id'] ?></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                    </table>
                        <?php
                    }
                    else
                    {
                        $selectp=mysqli_query($conn,"SELECT * from user_owns WHERE user_id=$user_id");
                        if(mysqli_num_rows($selectp)>0)
                        {
                            ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                No Interested Users for Your Properties Currently
                            </div>
                            </div>
                            <?php      
                        }
                        else
                        {
                            ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                You don't own any properties yet
                            </div>
                            </div>
                            <?php
                           
                        }
                    } 
                }
            ?>
        </div>
        <div class="tab-pane fade" id="v-pills-rentreq" role="tabpanel" aria-labelledby="v-pills-rentreq-tab">
            <?php
                $rentr=mysqli_query($conn,"SELECT * from rent_request WHERE property_id IN (SELECT property_id FROM user_owns WHERE user_id=$user_id)");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
                else
                {
                    if(mysqli_num_rows($rentr)>0)
                    {
                        ?>
                        <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Property ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">Request Date-Time</th>
                            <th scope="col">Number of People</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($rrow=$rentr->fetch_assoc())
                        {
                            ?>
                            <tr>
                            <th scope="row"><?php echo $rrow['property_id'] ?></th>
                            <td><?php echo $rrow['user_id'] ?></td>
                            <td>
                                <?php 
                                    $uid=$rrow['user_id'];
                                    $getuser=sql_query($conn,"SELECT * from users WHERE user_id=$uid");
                                    $user=mysqli_fetch_assoc($getuser);
                                    echo $user['name'];
                                ?>
                            </td>
                            <td><?php echo $user['phone_number'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $rrow['request_time'] ?></td>
                            <td><?php echo $rrow['no_of_people'] ?></td>
                            <td>
                                <?php 
                                    if($rrow['request_status']==0)
                                    {
                                        echo "Pending";
                                    }
                                    else
                                    {
                                        echo "Accepted";
                                    }
                                ?>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <!-- <form method="POST" action=""> -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" value="<?php echo $rrow['rr_id'] ?>" name="modalb" onclick="sendData(<?php echo $rrow['rr_id']?>)">
                                    Accept
                                    </button>
                                <!-- </form> -->

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Rent Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="modal-body">
                                            Reuqest ID:
                                            <input type="number" name="rid" id="rid"><br>
                                            Start Date:
                                            <input type="date" name="date">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="submitdate" value="<?php echo $rrow['rr_id'] ?>">Submit</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td>
                                <form action="#" method="POST">
                                    <button class="btn btn-primary" type="submit" name="deleter" value="<?php echo $rrow['rr_id']?>">Delete</button>
                                </form>
                            </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                    </table>
                        <?php
                    }
                    else
                    {
                        $selectp=mysqli_query($conn,"SELECT * from user_owns WHERE user_id=$user_id");
                        if(mysqli_num_rows($selectp)>0)
                        {
                            ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                No Rent Requests for your properties currently
                            </div>
                            </div>
                            <?php
                            
                        }
                        else
                        {
                            ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                You don't own any properties
                            </div>
                            </div>
                            <?php
                        }
                    } 
                }
            ?>
        </div>
        <div class="tab-pane fade" id="v-pills-pm" role="tabpanel" aria-labelledby="v-pills-pm-tab">
            <?php
                $pm=mysqli_query($conn,"SELECT * from books WHERE user_id=$user_id");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
                else
                {
                    if(mysqli_num_rows($pm)>0)
                    {
                        ?>
                        <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Request ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Category ID</th>
                            <th scope="col">Booking Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Truck ID</th>
                            <th scope="col">Driver Contact Number</th>
                            <th scope="col">Pickup Date</th>
                            <th scope="col">Pickup Time</th>
                            <th scope="col">Number of Trucks</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($prow=$pm->fetch_assoc())
                        {
                            ?>
                            <tr>
                            <th scope="row"><?php echo $prow['request_id'] ?></th>
                            <td><?php echo $prow['user_id'] ?></td>
                            <td><?php echo $prow['category_id'] ?></td>
                            <td><?php echo $prow['booking_time'] ?></td>
                            <td>
                                <?php 
                                    if($prow['status']==0)
                                    {
                                        echo "Pending";
                                    } 
                                    else if($prow['status']==1)
                                    {
                                        echo "Assigned";
                                    }
                                    else
                                    {
                                        echo "Completed";
                                    }
                                ?>
                            </td>
                            <td><?php echo $prow['truck_id'] ?></td>
                            <td><?php echo $prow['driver_contactno'] ?></td>
                            <td><?php echo $prow['pickup_date'] ?></td>
                            <td><?php echo $prow['pickup_time'] ?></td>
                            <td><?php echo $prow['no_of_trucks'] ?></td>
                            <?php
                            if($prow['status']==1)
                            {
                                ?>
                                <td>
                                <form action="#" method="post">
                                    <button type="submit" class="btn btn-primary" name="done" value="<?php echo $prow['request_id'] ?>">Mark as Complete</button>
                                </form>
                                </td>
                                <?php
                            }
                            ?>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                    </table>
                        <?php
                    }
                    else
                    {
                        ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                You have not booked any Packers and Movers
                            </div>
                            </div>
                            <?php
                    } 
                }
            ?>
        </div>
        <div class="tab-pane fade" id="v-pills-tenants" role="tabpanel" aria-labelledby="v-pills-tenants-tab">
            <?php
                $gettenants=mysqli_query($conn,"SELECT * FROM tenant WHERE property_id IN (SELECT property_id FROM property WHERE category!='sale' AND property_id IN (SELECT property_id FROM user_owns WHERE user_id=$user_id))");
            // $gettenants=mysqli_query($conn,"SELECT * FROM users WHERE user_id IN (SELECT tenant_id FROM tenant WHERE property_id IN (SELECT property_id FROM user_owns WHERE user_id=$user_id))");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
                else
                {
                    if(mysqli_num_rows($gettenants)>0)
                    {   
                        ?>
                        
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Property ID</th>
                                    <th scope="col">Tenant ID</th>
                                    <th scope="col">Tenant Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Email ID</th>
                                    <th scope="col">Rent Price</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col"></th>
        
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while($tenant=$gettenants->fetch_assoc())
                                {
                                    $pid=$tenant['property_id'];
                                    $getprice=mysqli_query($conn,"SELECT * FROM rent_price WHERE property_id=$pid");
                                    if(mysqli_error($conn))
                                    {
                                        echo mysqli_error($conn);
                                    }
                                    else
                                    {
                                        $rprice=mysqli_fetch_assoc($getprice);   
                                        $us=$tenant['tenant_id'];
                                        $getu=mysqli_query($conn,"SELECT * FROM users WHERE user_id=$us");
                                        if(mysqli_error($conn))
                                        {
                                            echo mysqli_error($conn);
                                        }
                                        else
                                        {
                                            $userd=mysqli_fetch_assoc($getu);
                                            ?>
                                            <tr>
                                            <th scope="row">
                                                <?php 
                                                    echo $pid;
                                                ?>
                                            </th>
                                            <td><?php echo $userd['user_id'] ?></td>
                                            <td><?php echo $userd['name'] ?></td>
                                            <td><?php echo $userd['phone_number'] ?></td>
                                            <td><?php echo $userd['email'] ?></td>
                                            <td>
                                                <?php
                                                    echo $rprice['rprice'];
                                                ?>
                                            </td>
                                            <td><?php echo $tenant['start_date'] ?></td>
                                            <td><?php echo $tenant['end_date'] ?></td>
                                            </tr>
                                        
                                    <?php        
                                        }
                                    }
                                }
                                    ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    else
                    {
                        ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                You don't have any Tenants
                            </div>
                            </div>
                            <?php
                    }
                }
            ?>
        </div>
        <div class="tab-pane fade" id="v-pills-yvisit" role="tabpanel" aria-labelledby="v-pills-yvisit-tab">
            <?php
                $getvisits=mysqli_query($conn,"SELECT * FROM visits WHERE user_id=$user_id");
                if(mysqli_error($conn))
                {
                    echo mysqli_error($conn);
                }
                else
                {
                    if(mysqli_num_rows($getvisits)>0)
                    {
                        ?>
                        <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Visit ID</th>
                                <th scope="col">Property ID</th>
                                <th scope="col">Preferred Visit Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Owner Name</th>
                                <th scope="col">Owner Contact Number</th>
                                <th scope="col">Owner Email ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($vrow=$getvisits->fetch_assoc())
                            {
                                ?>
                                <tr>
                                <th scope="row"><?php echo $vrow['visit_id'] ?></th>
                                <td><?php echo $vrow['property_id'] ?></td>
                                <td>
                                    <?php 
                                        echo $vrow['date'];
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($vrow['request_status']==0)
                                        {
                                            echo "Pending";
                                        } 
                                        else
                                        {
                                            echo "Accepted";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $prop_id=$vrow['property_id'];
                                        $getuser=mysqli_query($conn,"SELECT * FROM users WHERE user_id=(SELECT user_id FROM user_owns WHERE property_id=$prop_id)");
                                        if(mysqli_error($conn))
                                        {
                                            echo mysqli_error($conn);
                                        }
                                        else
                                        {
                                            $use=mysqli_fetch_assoc($getuser);
                                            echo $use['name'];
                                        }
                                    ?>
                                </td>
                                <td><?php echo $use['phone_number'] ?></td>
                                <td><?php echo $use['email'];  ?> </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    }
                    else
                    {
                        ?>
                            <br>
                            <div class="card">
                            <div class="card-body">
                                You have not made any visit requests
                            </div>
                            </div>
                            <?php
                    }
                }
            ?>
        </div>
    </div>
    </div>
    <?php
            require "./components/bootstrapjs.php";
        ?>
    </body>
</html>