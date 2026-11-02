<?php  
session_start();
include('connect.php');

if(isset($_POST['btnconfirmed'])) 
{
	$txtPurchaseID=$_POST['txtPurchaseID'];

	$result=mysqli_query($connection,"SELECT * FROM purchasedetails WHERE PurchaseID='$txtPurchaseID' ");

	while($arr=mysqli_fetch_array($result)) 
	{
		$ProductID=$arr['ProductID'];
		$PurchaseQuantity=$arr['PurchaseQuantity'];

		$updateQty="UPDATE product
					SET Quantity = Quantity + '$PurchaseQuantity'
					WHERE ProductID='$ProductID'
					 ";
		$ret=mysqli_query($connection,$updateQty);
	}

	$updateStatus="UPDATE purchase
				   SET Status='Confirmed'
				   WHERE PurchaseID='$txtPurchaseID'
				   ";
	$ret=mysqli_query($connection,$updateStatus);		

	if($ret) 
	{
		echo "<script>window.alert('Successfully Confirmed.')</script>";
		echo "<script>window.location='Purchase_Search.php'</script>";
	}
	else
	{
		echo "<p>Something went wrong in Purchase_Search." . mysqli_error($connection) . "</p>";
	}
}

$PurchaseID=$_GET['PurchaseID'];

//Single------------------------------------------------------
$query1="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
		FROM purchase pur,Staff st,Supplier sup
		WHERE pur.PurchaseID='$PurchaseID'
		AND pur.StaffID=st.StaffID
		AND pur.SupplierID=sup.SupplierID";
$ret1=mysqli_query($connection,$query1);
$row1=mysqli_fetch_array($ret1);

//Repeat------------------------------------------------------
$query2="SELECT pur.*,purd.*,p.ProductID,p.ProductName
		FROM purchase pur,purchasedetails purd,product p
		WHERE purd.PurchaseID='$PurchaseID' 
		AND pur.PurchaseID=purd.PurchaseID
		AND purd.ProductID=p.ProductID";
$ret2=mysqli_query($connection,$query2);
$count=mysqli_num_rows($ret2);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Purchase_Details</title>
</head>
<body>
<form action="Purchase_Details.php" method="post">
<fieldset>
<legend>Purchase Detail Report</legend>
<table cellpadding="5px" align="center" border="1">
<tr>
	<td>PurchaseID</td>
	<td>
		<b><?php echo $row1['PurchaseID'] ?></b>
	</td>
	<td>Status</td>
	<td>
		<b><?php echo $row1['Status'] ?></b>
	</td>
</tr>
<tr>
	<td>PurchaseDate</td>
	<td>
		<b><?php echo $row1['PurchaseDate'] ?></b>
	</td>
	<td>ReportDate</td>
	<td>
		<b><?php echo date('Y-m-d') ?></b>
	</td>
</tr>
<tr>
	<td>SupplierName</td>
	<td>
		<b><?php echo $row1['SupplierName'] ?></b>
	</td>
	<td>StaffName</td>
	<td>
		<b><?php echo $row1['StaffName'] ?></b>
	</td>
</tr>
<tr>
	<td colspan="4">
	<table align="center" width="100%" border="1">
	<tr>
		<th>ProductID</th>
		<th>ProductName</th>
		<th>PurchasePrice</th>
		<th>PurchaseQuantity</th>
		<th>Sub-Total</th>
	</tr>
	<?php  
	for($i=0;$i<$count;$i++) 
	{ 
		$row2=mysqli_fetch_array($ret2);

		echo "<tr>";
			echo "<td>" . $row2['ProductID'] . "</td>";
			echo "<td>" . $row2['ProductName'] . "</td>";
			echo "<td>" . $row2['PurchasePrice'] . "</td>";
			echo "<td>" . $row2['PurchaseQuantity'] . "</td>";
			echo "<td>" . $row2['PurchasePrice'] * $row2['PurchaseQuantity'] . "</td>";
		echo "</tr>";	
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td colspan="4" align="right">
	Total Quantity : <b><?php echo $row1['TotalQuantity'] ?></b><hr/>
	Total Amount : <b><?php echo $row1['TotalAmount'] ?></b><hr/>
	VAT(5%) : <b><?php echo $row1['VAT'] ?></b><hr/>
	GrandTotal : <b><?php echo $row1['GrandTotal'] ?></b><hr/>

	<input type="hidden" name="txtPurchaseID" value="<?php echo $row1['PurchaseID'] ?>"/>

	<?php  
	if($row1['Status'] == 'Pending') 
	{
		echo "<input type='submit' name='btnconfirmed' value='Confirmed' />";	
	}
	else
	{
		echo "<input type='submit' name='btnconfirmed' value='Confirmed' disabled />";	
	}
	?>
	
	</td>
</tr>
</table>
</fieldset>	
</form>
</body>
</html>