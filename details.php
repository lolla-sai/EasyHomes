<?php
	require './components/bootstrapcss.php';
	require './components/runSQLQuery.php';
	session_start();
	$conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
	if(!isset($_SESSION['logged_id']))
	{
		$_SESSION['from']="details";
		header('location:index.php');
	}
	else
	{
		$p_id=$_SESSION['property_id'];
		$user_id=$_SESSION['logged_id'];
        $get=sql_query($conn,"SELECT * from property WHERE property_id=$p_id and property_id NOT IN (SELECT distinct property_id FROM user_owns WHERE user_id=$user_id)");
        if(mysqli_num_rows($get)==0)
        {
            echo "<script>alert('You can't proceed as you own this property')</script>";
            header('location:buy.php');
        }
	}

	if(!empty($_POST['submit']))
	{
		$pid=$_POST['property_id'];
		$uid=$_POST['user_id'];
		$phno=$_POST['phonenumber'];
		$altphno=$_POST['altphno'];
		$email=$_POST['email'];
		$insert=sql_query($conn,"INSERT INTO interested(property_id,user_id,phone_number,alt_phone_number,email_id) VALUES ($pid,$uid,$phno,$altphno,'$email')");
		echo "<script>alert('Your Details have been sent to the owner of the property. You will be contacted back by the owner')</script>";
		header('location:property.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Registration | PHP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body{
			background-image:url(house.jpg);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			max-width: 100%;
			min-width: 100%;
			min-height: 100%;
		}
		form {
			font-size: 15px;
			color: white;
		}
		.subLanding {
            min-height: 90vh;
        }
	</style>
	
</head>
<body>
<?php
	require './components/navbar.php';
?>
<section class="subLanding py-4 px-2 text-dark bg-light d-flex align-items-center">
	<div class="container">
		<div class="row align-items-center justify-content-between">
			<div class="col-12 col-md-5 py-2 order-2 order-md-1">
				<h1>Drop your details and the owner will get back to you!</h1>
				<p class="lead">Human touch is very essential in knowing something inside out. With that in mind, we provided this facility to request direct callback from the owner.</p>
			</div>
			<div class="col-10 mx-auto col-md-6 my-4 order-1 order-md-2 my-4">
				<img src='./customer_support.jpg' alt="" class="img-fluid">
			</div>
		</div>
	</div>
</section>
<div>
	<?php
	if(isset($_PSOT['create'])){
        echo "user submited";
    }
	?>	
</div>
<div class="p-2">
	<form action="#" method="post" class="px-3 py-4">
		<div class="container">
					<h1>Submit your Preferred Contact Details</h1>
					<label for="propertyid"><b>Property ID</b></label>
					<input class="form-control" id="propertyid" type="text" name="property_id" value="<?php echo $p_id ?>" required>

					<label for="userid"><b>User ID</b></label>
					<input class="form-control" id="userid"  type="text" name="user_id" value="<?php echo $user_id ?>" required>

					<label for="email"><b>Email Address</b></label>
					<input class="form-control" id="email"  type="email" name="email" required>

					<label for="phonenumber"><b>Phone Number</b></label>
					<input class="form-control" id="phonenumber"  type="number" name="phonenumber" required>

					<label for="altphonenumber"><b>Alternate Phone Number</b></label>
					<input class="form-control" id="altphno"  type="number" name="altphno" required></br>
					<button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
				
			
		</div>
	</form>
</div>
<?php
	require './components/footer.php';
	require './components/fontawesome.php';
?>

</body>
<?php
	require './components/bootstrapjs.php';
?>
</html>