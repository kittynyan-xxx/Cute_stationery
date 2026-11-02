<?php  
session_start();
include('connect.php');
include('Shopping_Cart_Functions.php');
include('AutoID_Functions.php');

if (isset($_POST['btnCheckout'])) 
{
	$CustomerID=$_SESSION['CustomerID'];

	$txtOrderID=$_POST['txtOrderNo'];
	$txtOrderDate=$_POST['txtOrderDate'];
	$rdoDeliveryType=$_POST['rdoDeliveryType'];
	$rdoPaymentType=$_POST['rdoPaymentType'];
	$txtCardNo=$_POST['txtCardNo'];

	$TotalAmount=CalculateTotalAmount();
	$TotalQuantity=CalculateTotalQuantity();
	$VAT=CalculateTotalAmount() * 0.05;
	$GrandTotal=CalculateTotalAmount() + (CalculateTotalAmount() * 0.05);

	$Status="Pending";
	$DeliveryStatus="Pending";

	if ($rdoDeliveryType == "SAME") 
	{
		$txtCustomerName=$_SESSION['CustomerName'];
		$txtCustomerPhone=$_SESSION['Phone'];
		$txtCustomerAddress=$_SESSION['Address'];
		$txtDirection=$_POST['txtDirection1'];
	}
	else
	{
		$txtCustomerName=$_POST['txtCustomerName'];
		$txtCustomerPhone=$_POST['txtCustomerPhone'];
		$txtCustomerAddress=$_POST['txtCustomerAddress'];
		$txtDirection=$_POST['txtDirection2'];
	}

	$Insert1="INSERT INTO `orders`
			(`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`, `DeliveryStatus`)
			VALUES
			('$txtOrderID','$txtOrderDate','$CustomerID','$rdoDeliveryType','$rdoPaymentType','$txtCustomerName','$txtCustomerPhone','$txtCustomerAddress','$txtDirection','$txtCardNo','$TotalQuantity','$TotalAmount','$VAT','$GrandTotal','$Status','$DeliveryStatus')
			";
	$result=mysqli_query($connection,$Insert1);

	$size=count($_SESSION['Shopping_Cart']);

	for ($i=0; $i < $size; $i++) 
	{ 
		$ProductID=$_SESSION['Shopping_Cart'][$i]['ProductID'];
		$Price=$_SESSION['Shopping_Cart'][$i]['Price'];
		$Quantity=$_SESSION['Shopping_Cart'][$i]['BuyQuantity'];

		$Insert2="INSERT INTO `orderdetails`
				  (`OrderID`, `ProductID`, `Price`, `Quantity`) 
				  VALUES
				  ('$txtOrderID','$ProductID','$Price','$Quantity')
				  ";
		$result=mysqli_query($connection,$Insert2);
	}

	if($result) //True 
	{
		unset($_SESSION['Shopping_Cart']);
		echo "<script>window.alert('Successfully Checkout!')</script>";
		echo "<script>window.location='Customer_Home.php'</script>";
	}
	else
	{
		echo "<p>Something Went Wrong in Checkout " . mysqli_error($connection) .  "</p>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Check Out Form</title>

	<script type="text/javascript">
	function SameAddress()	
	{
		document.getElementById('SameAddress').style.display="block";
		document.getElementById('OtherAddress').style.display="none";
	}
	function OtherAddress()	
	{
		document.getElementById('SameAddress').style.display="none";
		document.getElementById('OtherAddress').style.display="block";
	}

	function COD()	
	{
		document.getElementById('KPAY').style.display="none";
		document.getElementById('CARD').style.display="none";
	}

	function KPAY()	
	{
		document.getElementById('KPAY').style.display="block";
		document.getElementById('CARD').style.display="none";
	}

	function CARD()	
	{
		document.getElementById('KPAY').style.display="none";
		document.getElementById('CARD').style.display="block";
	}
	</script>
</head>
<body>
<form action="Checkout.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Check Out Form</legend>
<table cellpadding="5px">
<tr>
	<td>Order No :</td>
	<td>
		<input type="text" name="txtOrderNo"value="<?php echo AutoID('orders','OrderID','ORD-',6) ?>" readonly />
	</td>
	<td>Total Amount :</td>
	<td>
		<input type="number" name="txtTotalAmount" value="<?php echo CalculateTotalAmount(); ?>" readonly /> USD
	</td>
	<td>VAT(5%) :</td>
	<td>
		<input type="number" name="txtVAT" value="<?php echo CalculateTotalAmount() * 0.05; ?>" readonly /> USD
	</td>
</tr>
<tr>
	<td>Order Date :</td>
	<td>
		<input type="text" name="txtOrderDate" value="<?php echo date('Y-m-d') ?>" readonly />
	</td>
	<td>Total Quantity :</td>
	<td>
		<input type="number" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity(); ?>" readonly /> pcs
	</td>
	<td>Grand Total :</td>
	<td>
		<input type="number" name="txtGrandTotal" value="<?php echo CalculateTotalAmount() + (CalculateTotalAmount() * 0.05); ?>" readonly /> USD
	</td>
</tr>
</table>
<hr/>

<p><b><u>Delivery Details :</u></b></p>

<input type="radio" name="rdoDeliveryType" value="SAME" checked onClick="SameAddress()" />Same Address
<input type="radio" name="rdoDeliveryType" value="OTHER" onClick="OtherAddress()" />Other Address

<div id="SameAddress" style="display: block;">
<table cellpadding="5px">
<tr>
	<td>Customer Name</td>
	<td>
		<b><?php echo $_SESSION['CustomerName'] ?></b>
	</td>
</tr>
<tr>
	<td>Customer Phone</td>
	<td>
		<b><?php echo $_SESSION['Phone'] ?></b>
	</td>
</tr>
<tr>
	<td>Customer Address</td>
	<td>
		<b><?php echo $_SESSION['Address'] ?></b>
	</td>
</tr>
<tr>
	<td>Direction</td>
	<td>
		<textarea name="txtDirection1" placeholder="Eg. Near Maharmyine Bus-stop"></textarea>
	</td>
</tr>
</table>
</div>

<div id="OtherAddress" style="display: none;">
<table cellpadding="5px">
<tr>
	<td>Customer Name</td>
	<td>
		<input type="text" name="txtCustomerName" placeholder="Enter Customer Name" />
	</td>
</tr>
<tr>
	<td>Customer Phone</td>
	<td>
		<input type="text" name="txtCustomerPhone" placeholder="Enter Customer Phone" />
	</td>
</tr>
<tr>
	<td>Customer Name</td>
	<td>
		<textarea name="txtCustomerAddress" placeholder="Home No/ Street Name / Township"></textarea>
	</td>
</tr>
<tr>
	<td>Direction</td>
	<td>
		<textarea name="txtDirection2" placeholder="Eg. Near Maharmyine Bus-stop"></textarea>
	</td>
</tr>
</table>
</div>

<hr/>

<p><b><u>Payment Details :</u></b></p>

<input type="radio" name="rdoPaymentType" value="COD" checked onClick="COD()" />Cash on Delivery
<input type="radio" name="rdoPaymentType" value="CARD"  onClick="CARD()" />Card Payment
<input type="radio" name="rdoPaymentType" value="KPAY"  onClick="KPAY()" />K Pay

<div id="CARD" style="display: none;">
<table cellpadding="5px">
<tr>
	<td>
		<input type="text" name="txtCardNo" placeholder="Enter Card Number">
	</td>
	<td>
		<input type="text" name="txtSecurityNo" placeholder="Enter Security No">
	</td>
	<td>
		<input type="text" name="txtMonth" placeholder="JAN" size="6">
	</td>
	<td>
		<input type="text" name="txtYear" placeholder="2023" size="6">
	</td>
</tr>
</table>
</div>

<div id="KPAY" style="display: none;">
<table cellpadding="5px">
<tr>
	<td align="center">
		<img src="images/Kpay.png" width="150px" height="150px" />
		<br/>
		<b>KPAY NO : 1934848392</b>
	</td>
</tr>
</table>
</div>

<hr/>

<input type="submit" name="btnCheckout" value="Checkout Now" />

</fieldset>
</form>
</body>
</html>