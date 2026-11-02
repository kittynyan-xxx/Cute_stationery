<?php 
session_start();
include('connect.php');

if(!isset($_SESSION['CustomerID'])) 
{
	echo "<script>window.alert('Please Login First to Order')</script>";
	echo "<script>window.location='Customer_Login.php'</script>";
}

if(isset($_POST['btnSearch']))
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if($rdoSearchType == 1) 
	{
		$cboOrderID=$_POST['cboOrderID'];

		$query="SELECT ord.*,cus.CustomerID,cus.CustomerName 
				FROM orders ord,customer cus
				WHERE ord.OrderID='$cboOrderID'
				AND ord.CustomerID=cus.CustomerID
				";
		$ret=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 2) 
	{
		$To=date('Y-m-d',strtotime($_POST['txtTo']));
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));

		$query="SELECT ord.*,cus.CustomerID,cus.CustomerName 
				FROM orders ord,customer cus
				WHERE ord.OrderDate BETWEEN '$From' AND '$To'
				AND ord.CustomerID=cus.CustomerID
				";
		$ret=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 3) 
	{
		$cboStatus=$_POST['cboStatus'];

		$query="SELECT ord.*,cus.CustomerID,cus.CustomerName 
				FROM orders ord,customer cus
				WHERE ord.Status='$cboStatus'
				AND ord.CustomerID=cus.CustomerID
				";
		$ret=mysqli_query($connection,$query);
	}
}
elseif(isset($_POST['btnShowAll']))
{
	$query="SELECT ord.*,cus.CustomerID,cus.CustomerName 
			FROM orders ord,customer cus
			WHERE ord.CustomerID=cus.CustomerID
			";
	$ret=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	$query="SELECT ord.*,cus.CustomerID,cus.CustomerName 
			FROM orders ord,customer cus
			WHERE ord.OrderDate='$today'
			AND ord.CustomerID=cus.CustomerID
			";
	$ret=mysqli_query($connection,$query);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Order History</title>
	<link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css">
	<script type="text/javascript" src="DatePicker/datepicker.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<form action="Order_History.php" method="post">
<fieldset>
<legend>Your Order List :</legend>

<table cellpadding="5px">
<tr>
	<td>
		<input type="radio" name="rdoSearchType" value="1" checked />Search By OrderID :
		<br/>
		<select name="cboOrderID">
			<option>Choose OrderID</option>
			<?php 
			
			$CustomerID=$_SESSION['CustomerID'];

			$Oquery="SELECT * FROM orders WHERE CustomerID='$CustomerID' ";  
			$Oret=mysqli_query($connection,$Oquery);
			$Ocount=mysqli_num_rows($Oret);

			for($i=0;$i<$Ocount;$i++) 
			{ 
				$Orow=mysqli_fetch_array($Oret);

				$OrderID=$Orow['OrderID'];

				echo "<option value='$OrderID'>$OrderID</option>";
			}
			?>
		</select>
	</td>
	<td>
		<input type="radio" name="rdoSearchType" value="2" /> Search By OrderDate :
		<br/>
		From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)"/>
		To <input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" onClick="showCalender(calender,this)" />
	</td>
	<td>
		<input type="radio" name="rdoSearchType" value="3" /> Search By Status :
		<br/>
		<select name="cboStatus">
			<option>Choose Status</option>
			<option>Pending</option>
			<option>Confirmed</option>
		</select>
	</td>
	<td>
		<br/>
		<input type="submit" name="btnSearch" value="Search Now" />
		<input type="submit" name="btnShowAll" value="Show All" />
		<input type="reset" name="btnClear" value="Clear" />
	</td>
</tr>
</table>

<hr/>

<table border="1" width="100%">
<tr>
	<th>OrderID</th>
	<th>OrderDate</th>
	<th>CustomerName</th>
	<th>TotalQuantity</th>
	<th>GrandTotal</th>
	<th>Status</th>
	<th>Action</th>
</tr>
<?php

$count=mysqli_num_rows($ret);

for($i=0;$i<$count;$i++) 
{
	$row=mysqli_fetch_array($ret);

	$OrderID=$row['OrderID'];

	echo "<tr>";
		echo "<td>$OrderID</td>";
		echo "<td>" . $row['OrderDate'] . "</td>";
		echo "<td>" . $row['CustomerID'] . "</td>";
		echo "<td>" . $row['TotalQuantity'] . "</td>";
		echo "<td>" . $row['GrandTotal'] . "</td>";
		echo "<td>" . $row['Status'] . "</td>";
		echo "<td><a href='Order_Details.php?OrderID=$OrderID'>Details</a></td>";
	echo "</tr>";
}
?>
</table>
</fieldset>
</form>
</body>
</html>