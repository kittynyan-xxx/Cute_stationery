<?php  
session_start();
include('connect.php');
include('Purchase_Functions.php');
include('AutoID_Functions.php');

if(isset($_POST['btnSave'])) 
{
	$txtPurchaseID=$_POST['txtPurchaseID'];
	$txtPurchaseDate=$_POST['txtPurchaseDate'];
	$cboSupplierID=$_POST['cboSupplierID'];
	$txtTotalQuantity=$_POST['txtTotalQuantity'];
	$txtTotalAmount=$_POST['txtTotalAmount'];
	$txtVAT=$_POST['txtVAT'];
	$txtGrandTotal=$_POST['txtGrandTotal'];

	$Status="Pending";
	$StaffID=$_SESSION['StaffID'];

	$Insert1="INSERT INTO `purchase`
			  (`PurchaseID`, `PurchaseDate`, `SupplierID`, `StaffID`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`) 
			  VALUES
			  ('$txtPurchaseID','$txtPurchaseDate','$cboSupplierID','$StaffID','$txtTotalQuantity','$txtTotalAmount','$txtVAT','$txtGrandTotal','$Status')
			  ";
	$ret=mysqli_query($connection,$Insert1);

	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];

		$Insert2="INSERT INTO `purchasedetails`
				(`PurchaseID`, `ProductID`, `PurchasePrice`, `PurchaseQuantity`) 
				VALUES
				('$txtPurchaseID','$ProductID','$PurchasePrice','$PurchaseQuantity')
				";
		$ret=mysqli_query($connection,$Insert2);
	}

	if($ret) 
	{
		unset($_SESSION['Purchase_Functions']);
		
		echo "<script>window.alert('Successfully Purchased.')</script>";
		echo "<script>window.location='Purchase.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase Form." . mysqli_error($connection) . "</p>";
	}
}

if(isset($_GET['action'])) 
{
	$action=$_GET['action'];

	if($action == "remove") 
	{
		$ProductID=$_GET['ProductID'];
		RemoveProduct($ProductID);
	}
	elseif($action == "clearall")
	{
		ClearAll();
	}
}

if(isset($_POST['btnAdd'])) 
{
	$ProductID=$_POST['cboProductID'];
	$PurchasePrice=$_POST['txtPurchasePrice'];
	$PurchaseQuantity=$_POST['txtPurchaseQuantity'];

	AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity);	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Purchase Form</title>
</head>
<body>
<form action="Purchase.php" method="post">
<fieldset>
<legend>Enter Purchase Informations:</legend>
<table>
<tr>
	<td>PurchaseID</td>
	<td>
		<input type="text" name="txtPurchaseID" value="<?php echo AutoID('purchase','PurchaseID','PUR-',6) ?>" readonly />
	</td>
</tr>
<tr>
	<td>PurchaseDate</td>
	<td>
		<input type="text" name="txtPurchaseDate" value="<?php echo date('Y-m-d') ?>" readonly />
	</td>
</tr>
<tr>
	<td>Staff Info</td>
	<td>
		<input type="text" name="txtStaffName" value="<?php echo $_SESSION['StaffName'] ?>" readonly />
	</td>
</tr>
<tr>
	<td colspan="2">
		<hr/>
	</td>
</tr>
<tr>
	<td>TotalQuantity</td>
	<td>
		<input type="number" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity(); ?>" readonly /> pcs
	</td>
</tr>
<tr>
	<td>TotalAmount</td>
	<td>
		<input type="number" name="txtTotalAmount" value="<?php echo CalculateTotalAmount(); ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>VAT</td>
	<td>
		<input type="number" name="txtVAT" value="<?php echo CalculateTotalAmount()*0.05 ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>GrandTotal</td>
	<td>
		<input type="number" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() + (CalculateTotalAmount()*0.05) ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td colspan="2">
		<hr/>
	</td>
</tr>
<tr>
	<td>ProductInfo</td>
	<td>
		<select name="cboProductID">
		<option>Choose Product</option>
		<?php  
		$query="SELECT * FROM product";  
		$ret=mysqli_query($connection,$query);
		$count=mysqli_num_rows($ret);

		for($i=0;$i<$count;$i++) 
		{ 
			$row=mysqli_fetch_array($ret);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];

			echo "<option value='$ProductID'>$ProductID - $ProductName</option>";
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td>PurchasePrice</td>
	<td>
		<input type="number" name="txtPurchasePrice" value="0"  /> USD
	</td>
</tr>
<tr>
	<td>PurchaseQuantity</td>
	<td>
		<input type="number" name="txtPurchaseQuantity" value="0"  /> pcs
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<input type="submit" name="btnAdd" value="Add" />
		|
		<a href="#">Cancel</a>
	</td>
</tr>
</table>

<?php  
if(!isset($_SESSION['Purchase_Functions']))
{
	echo "<p>No Purchase Record Found.</p>";
	exit();
}
else
{
?>
	<table border="1">
	<tr>
		<th>ProductImage</th>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>PurchasePrice</th>
		<th>PurchaseQuantity</th>
		<th>Sub-Total</th>
		<th>Action</th>
	</tr>
	<?php  
	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
		$ProductName=$_SESSION['Purchase_Functions'][$i]['ProductName'];
		$ProductImage1=$_SESSION['Purchase_Functions'][$i]['ProductImage1'];
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
		$SubTotal=$PurchasePrice * $PurchaseQuantity;

		echo "<tr>";
			echo "<td><img src='$ProductImage1' width='100px' height='120px'/></td>";
			echo "<td>$ProductID</td>";
			echo "<td>$ProductName</td>";
			echo "<td>$PurchasePrice</td>";
			echo "<td>$PurchaseQuantity</td>";
			echo "<td>$SubTotal</td>";
			echo "<td><a href='Purchase.php?action=remove&ProductID=$ProductID'>Remove</a></td>";
		echo "</tr>";

	}
	?>
	<tr>
		<td colspan="7" align="right">
		<a href="Purchase.php?action=clearall">Clear All</a>
		|
		<select name="cboSupplierID">
		<option>Choose Supplier</option>
		<?php  
		$Squery="SELECT * FROM supplier";  
		$Sret=mysqli_query($connection,$Squery);
		$Scount=mysqli_num_rows($Sret);

		for($i=0;$i<$Scount;$i++) 
		{ 
			$Srow=mysqli_fetch_array($Sret);

			$SupplierID=$Srow['SupplierID'];
			$SupplierName=$Srow['SupplierName'];

			echo "<option value='$SupplierID'>$SupplierID - $SupplierName</option>";
		}
		?>
		</select>
		|
		<input type="submit" name="btnSave" value="Save" />
		</td>
	</tr>
	</table>
<?php
}
?>

</fieldset>
</form>
</body>
</html>