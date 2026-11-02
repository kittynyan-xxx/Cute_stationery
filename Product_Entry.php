<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtProductName=$_POST['txtProductName'];
	$cboBrandID=$_POST['cboBrandID'];
	$cboCategoryID=$_POST['cboCategoryID'];
	$txtProductType=$_POST['txtProductType'];
	$txtSize=$_POST['txtSize'];
	$txtColor=$_POST['txtColor'];
	$txtPrice=$_POST['txtPrice'];
	$txtQuantity=$_POST['txtQuantity'];
	$txtDescription=$_POST['txtDescription'];

	//Image Upload--------------------------------------
	$Image1=$_FILES['filImage1']['name']; 			// abc.jpg
	$FolderName="ProductImage/"; 					// ProductImage/
	$FileName1=	$FolderName . '_' . $Image1;		// ProductImage/_abc.jpg

	$copied=copy($_FILES['filImage1']['tmp_name'], $FileName1);

	if(!$copied) 
	{
		echo "<p>Cannot Upload Front Image.</p>";
		exit();
	}
	//--------------------------------------------------

	$check="SELECT * FROM product WHERE ProductName='$txtProductName' ";
	$result=mysqli_query($connection,$check);
	$count=mysqli_num_rows($result);

	if($count != 0) 
	{
		echo "<script>window.alert('ProductName $txtProductName Already Exist.')</script>";
		echo "<script>window.location='Product_Entry.php'</script>";
	}
	else
	{

		$query="INSERT INTO `product`
				(`ProductName`, `ProductType`, `Size`, `Color`, `Price`, `Quantity`, `BrandID`, `CategoryID`, `Description`, `ProductImage1`) 
				VALUES
				('$txtProductName','$txtProductType','$txtSize','$txtColor','$txtPrice','$txtQuantity','$cboBrandID','$cboCategoryID','$txtDescription','$FileName1')
				";
		$result=mysqli_query($connection,$query);
	}
	
	if($result) //True 
	{
		echo "<script>window.alert('Successfully Save!')</script>";
		echo "<script>window.location='Product_Entry.php'</script>";
	}
	else
	{
		echo "<p>Something Went Wrong in Product Entry " . mysqli_error($connection) .  "</p>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Product Entry</title>
</head>
<body>
<form action="Product_Entry.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Enter Product Details:</legend>	
<table>
<tr>
	<td>Product Name :</td>
	<td>
		<input type="text" name="txtProductName" placeholder="Enter Product Name" required />
	</td>
</tr>
<tr>
	<td>Brand :</td>
	<td>
		<select name="cboBrandID">
		<option>---Choose Brand Info---</option>
		<?php  
		$Bquery="SELECT * FROM brand";
		$Bresult=mysqli_query($connection,$Bquery);
		$BCount=mysqli_num_rows($Bresult);

		for($i=0;$i<$BCount;$i++) 
		{ 
			$Brow=mysqli_fetch_array($Bresult);
			$BrandID=$Brow['BrandID'];
			$BrandName=$Brow['BrandName'];

			echo "<option value='$BrandID'>$BrandID - $BrandName</option>";
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td>Category :</td>
	<td>
		<select name="cboCategoryID">
		<option>--Choose Category Info--</option>
		<?php  
		$Cquery="SELECT * FROM category";
		$Cresult=mysqli_query($connection,$Cquery);
		$CCount=mysqli_num_rows($Cresult);

		for($j=0;$j<$CCount;$j++) 
		{ 
			$Crow=mysqli_fetch_array($Cresult);
			$CategoryID=$Crow['CategoryID'];
			$CategoryName=$Crow['CategoryName'];

			echo "<option value='$CategoryID'>$CategoryID - $CategoryName</option>";
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td>Product Type :</td>
	<td>
		<input type="text" name="txtProductType" placeholder="Enter Product Type" required />
	</td>
</tr>
<tr>
	<td>Size :</td>
	<td>
		<input type="text" name="txtSize" placeholder="Eg. S M L XL" required />
	</td>
</tr>
<tr>
	<td>Color :</td>
	<td>
		<input type="text" name="txtColor" placeholder="Eg. Blue, Grey" required />
	</td>
</tr>
<tr>
	<td>Price :</td>
	<td>
		<input type="number" name="txtPrice" placeholder="Eg. 100" required /> USD
	</td>
</tr>
<tr>
	<td>Quantity :</td>
	<td>
		<input type="number" name="txtQuantity" placeholder="Eg. 1" required /> pcs
	</td>
</tr>
<tr>
	<td>Front Image :</td>
	<td>
		<input type="file" name="filImage1" required />
	</td>
</tr>
<tr>
	<td>Description :</td>
	<td>
		<textarea name="txtDescription" placeholder="Enter Description" cols="30"></textarea>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnSave" value="Save" />
		<input type="reset" name="btnReset" value="Clear" />
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>