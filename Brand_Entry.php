<?php 
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtBrandName=$_POST['txtBrandName'];
	
	$txtStatus=$_POST['txtStatus'];
	

	

	$checkBrandName="SELECT * FROM supplier WHERE BrandName='$txtBrandName'";
	$result=mysqli_query($connection,$checkEmail);
	$count=mysqli_num_rows($result);

	if ($count != 0) 
	{
		echo "<script>window.alert('Brand Already Exist!')</script>";
		echo "<script>window.location='Staff_Home.php'</script>";
	}
	else
{
	$query="INSERT INTO `Brand`(`BrandName`,'Status') 
		VALUES
		('$txtSupplierName', '$txtBrandName', '$txtStatus')";
	$result=mysqli_query($connection, $query);

	if ($result) 
	{
		echo "<script>window.alert('Brand is registered'')</script>";
		echo "<script>window.location='Staff_Home.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in brand entry :" . mysqli_error($connection) . "</p>";
	}
}

}
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Brand Entry</title>
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
              <h1>Brand Entry</h1>
            </div>
          </div>
          <div class="col-md-12">
		  <form id="contact" action="Brand_Entry.php" method="post" enctype="multipart/form-data">
			<fieldset>
			<table align="center" cellpadding="8px">
				<tr>
					<td>SupplierName</td>
					<td>
						<input class="form-control" type="text" name="txtBrandName" placeholder="Eg. Joseph Vincent" required />
					</td>
				</tr>
				<tr>
					<tr>
					<td>CompanyName</td>
					<td>
						<input class="form-control" type="text" name="txtStatus" placeholder="Eg. Joseph Vincent" required />
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
