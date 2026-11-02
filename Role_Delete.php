<?php  
include('connect.php');

$RoleID=$_GET['RoleID'];

$Delete="DELETE FROM Role WHERE RoleID='$RoleID' ";
$ret=mysqli_query($connection,$Delete);

if($ret) 
{
	echo "<script>window.alert('Successfully Deleted.')</script>";
	echo "<script>window.location='Role_Entry.php'</script>";
}
else
{
	echo "<p>Something went wrong in Role Delete." . mysqli_error($connection) . "</p>";
}
?>