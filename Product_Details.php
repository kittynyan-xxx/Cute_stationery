<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');

if(isset($_POST['btnAdd'])) 
{
	$ProductID=$_POST['txtProductID'];
	$BuyQuantity=$_POST['txtBuyQuantity'];

	AddProduct($ProductID,$BuyQuantity);
}

$ProductID=$_GET['ProductID'];

$query="SELECT p.*,b.BrandID,b.BrandName,c.CategoryID,c.CategoryName
		FROM product p,brand b,category c
		WHERE p.ProductID='$ProductID' 
		AND p.BrandID=b.BrandID
		AND p.CategoryID=c.CategoryID
		";
$ret=mysqli_query($connection,$query);
$row=mysqli_fetch_array($ret);

$ProductImage1=$row['ProductImage1'];
$ProductImage2=$row['ProductImage2'];
$ProductImage3=$row['ProductImage3'];

list($width,$height)=getimagesize($ProductImage1);
$w=$width/1.5;
$h=$height/1.5;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Product Details :</title>
</head>
<body>
<form action="Product_Details.php" method="post">
<fieldset>
<legend>Product Details:</legend>
<table align="center">
<tr>
	<td>
		<img id="PImage" src="<?php echo $ProductImage1 ?>" width="<?php echo $w; ?>" height="<?php echo $h ?>" />
		<hr/>
		<img src="<?php echo $ProductImage1 ?>" width="108px" height="140px" 
		OnClick="document.getElementById('PImage').src='<?php echo $row['ProductImage1'] ?>' " />
		<img src="<?php echo $ProductImage2 ?>" width="108px" height="140px" 
		OnClick="document.getElementById('PImage').src='<?php echo $row['ProductImage2'] ?>' " />
		<img src="<?php echo $ProductImage3 ?>" width="108px" height="140px" 
		OnClick="document.getElementById('PImage').src='<?php echo $row['ProductImage3'] ?>' "/>
	</td>
	<td>
		<table>
		<tr>
			<td>ProductName :</td>
			<td>
				<b><?php echo $row['ProductName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>BrandName :</td>
			<td>
				<b><?php echo $row['BrandName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>CategoryName :</td>
			<td>
				<b><?php echo $row['CategoryName'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Size :</td>
			<td>
				<b><?php echo $row['Size'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Color :</td>
			<td>
				<b><?php echo $row['Color'] ?></b>
			</td>
		</tr>
		<tr>
			<td>Price :</td>
			<td>
				<b><?php echo $row['Price'] ?> USD</b>
			</td>
		</tr>
		<tr>
			<td>Available Qty :</td>
			<td>
				<b><?php echo $row['Quantity'] ?> pcs</b>
			</td>
		</tr>
		<tr>
			<td>Buy Qty :</td>
			<td>
				<input type="hidden" name="txtProductID" value="<?php echo $row['ProductID'] ?>" />
				<input type="text" name="txtBuyQuantity" value="1" size="3" />
				<input type="submit" name="btnAdd" value="Add to Cart">
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>