<?php  
session_start();
include('connect.php');

if(isset($_POST['btnSearch']))
{
	$rdoSearchType=$_POST['rdoSearchType'];

	if($rdoSearchType == 1) 
	{
		$cboPurchaseID=$_POST['cboPurchaseID'];

		$query="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
				FROM purchase pur,Staff st,Supplier sup
				WHERE pur.PurchaseID='$cboPurchaseID'
				AND pur.StaffID=st.StaffID
				AND pur.SupplierID=sup.SupplierID
				";
		$ret=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 2) 
	{
		$To=date('Y-m-d',strtotime($_POST['txtTo']));
		$From=date('Y-m-d',strtotime($_POST['txtFrom']));

		$query="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
				FROM purchase pur,Staff st,Supplier sup
				WHERE pur.PurchaseDate BETWEEN '$From' AND '$To'
				AND pur.StaffID=st.StaffID
				AND pur.SupplierID=sup.SupplierID
				";
		$ret=mysqli_query($connection,$query);
	}
	elseif($rdoSearchType == 3) 
	{
		$cboStatus=$_POST['cboStatus'];

		$query="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
				FROM purchase pur,Staff st,Supplier sup
				WHERE pur.Status='$cboStatus'
				AND pur.StaffID=st.StaffID
				AND pur.SupplierID=sup.SupplierID
				";
		$ret=mysqli_query($connection,$query);
	}
}
elseif(isset($_POST['btnShowAll']))
{
	$query="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
			FROM purchase pur,Staff st,Supplier sup
			WHERE pur.StaffID=st.StaffID
			AND pur.SupplierID=sup.SupplierID
			";
	$ret=mysqli_query($connection,$query);
}
else
{
	$today=date('Y-m-d');

	$query="SELECT pur.*,sup.SupplierID,sup.SupplierName,st.StaffID,st.StaffName 
			FROM purchase pur,Staff st,Supplier sup
			WHERE pur.PurchaseDate='$today'
			AND pur.StaffID=st.StaffID
			AND pur.SupplierID=sup.SupplierID
			";
	$ret=mysqli_query($connection,$query);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Purchase Search & Report</title>
</head>
<body>
<form action="Purchase_Search.php" method="post">
<fieldset>
<legend>Search Criteria:</legend>

<table cellpadding="5px">
<tr>
	<td>
		<input type="radio" name="rdoSearchType" value="1" checked />Search By PurchaseID :
		<br/>
		<select name="cboPurchaseID">
			<option>Choose PurchaseID</option>
			<?php  
			$Pquery="SELECT * FROM purchase";  
			$Pret=mysqli_query($connection,$Pquery);
			$Pcount=mysqli_num_rows($Pret);

			for($i=0;$i<$Pcount;$i++) 
			{ 
				$Prow=mysqli_fetch_array($Pret);

				$PurchaseID=$Prow['PurchaseID'];

				echo "<option value='$PurchaseID'>$PurchaseID</option>";
			}
			?>
		</select>
	</td>
	<td>
		<input type="radio" name="rdoSearchType" value="2" /> Search By PurchaseDate :
		<br/>
		From <input type="text" name="txtFrom" value="<?php echo date('Y-m-d') ?>" />
		To <input type="text" name="txtTo" value="<?php echo date('Y-m-d') ?>" />
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
	<th>PurchaseID</th>
	<th>PurchaseDate</th>
	<th>SupplierName</th>
	<th>StaffName</th>
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

	$PurchaseID=$row['PurchaseID'];

	echo "<tr>";
		echo "<td>$PurchaseID</td>";
		echo "<td>" . $row['PurchaseDate'] . "</td>";
		echo "<td>" . $row['SupplierName'] . "</td>";
		echo "<td>" . $row['StaffName'] . "</td>";
		echo "<td>" . $row['TotalQuantity'] . "</td>";
		echo "<td>" . $row['GrandTotal'] . "</td>";
		echo "<td>" . $row['Status'] . "</td>";
		echo "<td><a href='Purchase_Details.php?PurchaseID=$PurchaseID'>Details</a></td>";
	echo "</tr>";
}
?>
</table>

</fieldset>
</form>
</body>
</html>