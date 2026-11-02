<?php  
session_start();
include('Connect.php');

if(isset($_POST['btnLogin'])) 
{
	$txtEmail=$_POST['txtEmail'];
	$txtPassword=$_POST['txtPassword'];


	$CheckAccount="SELECT * FROM Customer
				   WHERE Email='$txtEmail'
				   AND Password='$txtPassword'
				 ";
	$result=mysqli_query($connection,$CheckAccount);
	$count=mysqli_num_rows($result);
	$arr=mysqli_fetch_array($result);

	if($count < 1) 
	{
		echo "<script>window.alert('Customer Email or Password Incorrct!')</script>";
	}
	else
	{
		$_SESSION['CustomerID']=$arr['CustomerID'];
		$_SESSION['CustomerName']=$arr['CustomerName'];
		$_SESSION['CustomerPhoto']=$arr['CustomerPhoto'];
		$_SESSION['Address']=$arr['Address'];
		$_SESSION['Phone']=$arr['Phone'];
	
		echo "<script>window.alert('Login Success!')</script>";
		echo "<script>window.location='Product_Display.php'</script>";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Customer Login</title>
</head>
<body>

<form id="contact" action="Customer_Login.php" method="post">
	<fieldset>

	<table align="center" cellpadding="8px">
	</tr>
	<tr>
		<td>Email</td>
		<td>
		<input class="form-control" type="email" name="txtEmail" placeholder="example@domain.com" required />
		</td>
	</tr>
	</tr>
	<tr>
		<td>Password</td>
		<td>
		<input class="form-control" type="password" name="txtPassword" placeholder="XXXXXXXXXXXX" required />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" name="btnLogin" value="Login" />
			<input type="reset" value="Clear" />
		</td>
	</tr>
	</table>

	</fieldset>

	</form>	


</body>
</html>