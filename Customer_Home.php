<?php  
session_start();
include('Connect.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Home</title>
</head>
<body>
<form>
<h1>
	Welcome 
	<?php echo $_SESSION['CustomerName'] ?>
	|
	<a href="Order_History.php">My Orders</a>
	|
	<a href="Customer_Logout.php">Logout</a>
</h1>

</form>
</body>
</html>