<?php  
include('connect.php');

if(isset($_POST['btnSave'])) 
{
	$txtRoleName=$_POST['txtRoleName'];
	$cboStatus=$_POST['cboStatus'];

	$CheckRole="SELECT * FROM role WHERE RoleName='$txtRoleName' ";
	$ret=mysqli_query($connection,$CheckRole);
	$count=mysqli_num_rows($ret);

	if ($count > 0) 
	{
		echo "<script>window.alert('Role Name Already Exist.')</script>";
		echo "<script>window.location='Role_Entry.php'</script>";
	}
	else
	{
		$Insert="INSERT INTO Role
				(RoleName,Status)
				VALUES
				('$txtRoleName','$cboStatus')";
		$ret=mysqli_query($connection,$Insert);

		if($ret) 
		{
			echo "<script>window.alert('Successfully Save.')</script>";
			echo "<script>window.location='Role_Entry.php'</script>";
		}
		else
		{
			echo "<p>Something went wrong in Role Entry." . mysqli_error($connection) . "</p>";
		}
	}


}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Role Entry</title>
</head>
<body>
<form action="Role_Entry.php" method="post">
<fieldset>
<legend>Enter Role Informations:</legend>
<table cellpadding="5px" align="center">
<tr>
	<td>Role Name</td>
	<td>
		<input type="text" name="txtRoleName" placeholder="Enter Role Name" required />
	</td>
</tr>
<tr>
	<td>Status</td>
	<td>
		<select name="cboStatus">
		<option>Choose Status</option>
			<option>Active</option>
			<option>InActive</option>
		</select>
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

<?php  
$query="SELECT * FROM Role";
$result=mysqli_query($connection,$query);
$count=mysqli_num_rows($result);

if($count<1) 
{
	echo "<p>No Data Found!</p>";
}
else
{
?>
	<table border="1" align="center" cellpadding="5px" cellspacing="3px">
	<tr>
		<th>RoleID</th>
		<th>RoleName</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php  
	for ($i=0; $i < $count; $i++) 
	{ 
		$row=mysqli_fetch_array($result);
		$RoleID=$row['RoleID'];

		echo "<tr>";
		echo "<td>$RoleID</td>";
		echo "<td>" . $row['RoleName'] . "</td>";
		echo "<td>" . $row['Status'] . "</td>";
		echo "<td>
				<a href='Role_Update.php?RoleID=$RoleID'>Edit</a>
				|
				<a href='Role_Delete.php?RoleID=$RoleID'>Delete</a>
			  </td>";
		echo "</tr>";	
	}
	?>
	</table>
<?php
}
?>

</fieldset>

</form>
</body>
</html>