<?php 
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtCustomerName=$_POST['txtCustomerName'];
	$rdoGender=$_POST['rdoGender'];
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];
	$txtPhone=$_POST['txtPhone'];
	$txtAddress=$_POST['txtAddress'];

	$filCustomerPhoto=$_FILES['filCustomerPhoto'] ['name'];
	$Folder="CustomerPhoto/";

	$FileName=$Folder . '_' . $filCustomerPhoto;

	$copied=copy($_FILES['filCustomerPhoto']['tmp_name'], $FileName);

	if (!$copied) 
	{
		echo "<p>Image Cannot Upload.</p>";
		exit();
	}

	$checkEmail="SELECT * FROM customer WHERE Email='$txtEmail'";
	$result=mysqli_query($connection,$checkEmail);
	$count=mysqli_num_rows($result);

	if ($count != 0) 
	{
		echo "<script>window.alert('Customer Email Already Exist!')</script>";
		echo "<script>window.location='Customer_Entry.php'</script>";
	}
	else
{
	$query="INSERT INTO `customer`(`CustomerName`, `Gender`, `Email`, `Password`, `Phone`, `Address`, `CustomerPhoto`) 
		VALUES
		('$txtCustomerName', '$rdoGender', '$txtEmail', '$txtPassword', '$txtPhone', '$txtAddress', '$FileName')";
	$result=mysqli_query($connection, $query);

	if ($result) 
	{
		echo "<script>window.alert('Customer Account is created!'')</script>";
		echo "<script>window.location='Customer_Login.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in customer entry :" . mysqli_error($connection) . "</p>";
	}
}

}
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Entry</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


<!-- Additional CSS Files -->
<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/tooplate-main.css">
<link rel="stylesheet" href="assets/css/owl.css">
</head>
<body>




    <!-- Page Content -->
    <!-- About Page Starts Here -->
    <div class="contact-page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <div class="line-dec"></div>
              <h1>Customer Entry</h1>
            </div>
          </div>
          <div class="col-md-12">
		  <form id="contact" action="Customer_Entry.php" method="post" enctype="multipart/form-data">
			<fieldset>
			<table align="center" cellpadding="8px">
				<tr>
					<td>CustomerName</td>
					<td>
						<input class="form-control" type="text" name="txtCustomerName" placeholder="Eg. Joseph Vincent" required />
					</td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>
						<input type="radio" name="rdoGender" value="Male" checked /> Male
						<input type="radio" name="rdoGender" value="Female" /> Female
					</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>
						<input class="form-control" type="email" name="txtEmail" placeholder="example@email.com" required />
					</td>
				</tr>
				<tr>
				<td>Password</td>
				<td>
					<input class="form-control" type="password" name="txtPassword" placeholder="XXXXXXXXXXXXXXX" required />
				</td>
			</tr>
			<tr>
				<td>Phone</td>
				<td>
					<input class="form-control" type="text" name="txtPhone" placeholder="+95-------------" required />
				</td>
			</tr>
			<tr>
				<td>CustomerPhoto</td>
				<td>
					<input class="form-control" type="file" name="filCustomerPhoto" required />
				</td>
			</tr>
			<tr>
				<td>Address</td>
				<td>
					<textarea class="form-control" name="txtAddress" placeholder="Room No/ Street / Township / City / Country" rows="3" cols="50"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" name="btnClear" value="Clear" />
				</td>
			</tr>
			</table>
			<hr/>

		
			</fieldset>
			</form>

          </div>

        

        </div>
      </div>
    </div>
    <!-- About Page Ends Here -->




</body>
</html>
