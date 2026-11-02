<?php  
session_start();
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Product Display</title>
</head>
<body>
<form action="Product_Display.php" method="post">
<fieldset>
<legend>Product List:</legend>
<table align="right">
<tr>
	<td>
		<input type="text" name="txtData" placeholder="Enter Data to Search" />
		<input type="submit" name="btnSearch" value="Search" />
	</td>
</tr>
</table>

<table>
<?php

if (isset($_POST['btnSearch'])) 
{
	$txtData=$_POST['txtData'];

	$query1="SELECT * FROM Product
			 WHERE ProductName LIKE '%$txtData%' 
			 OR Price='$txtData'
			 ";
	$ret1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($ret1);

	for ($i=0; $i < $count1; $i+=4) 
	{ 
		$query2="SELECT * FROM Product
				 WHERE ProductName LIKE '%$txtData%' 
				 OR Price='$txtData'
				 LIMIT $i,4 ";
		$ret2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($ret2);

		echo "<tr>";
		for ($x=0; $x < $count2; $x++) 
		{ 
			$row=mysqli_fetch_array($ret1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$Price=$row['Price'];
			$ProductImage1=$row['ProductImage1'];

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td>
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w; ?>" height="<?php echo $h ?>" />
				<br/>
				<h2><?php echo $ProductName ?></h2>
				<b><?php echo $Price ?> USD</b>
				<br/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>	
			</td>
		<?php
		}
		echo "</tr>";
	}
} 
else
{
	$query1="SELECT * FROM Product";
	$ret1=mysqli_query($connection,$query1);
	$count1=mysqli_num_rows($ret1);

	for ($i=0; $i < $count1; $i+=4) 
	{ 
		$query2="SELECT * FROM Product
				 LIMIT $i,4 ";
		$ret2=mysqli_query($connection,$query2);
		$count2=mysqli_num_rows($ret2);

		echo "<tr>";
		for ($x=0; $x < $count2; $x++) 
		{ 
			$row=mysqli_fetch_array($ret1);

			$ProductID=$row['ProductID'];
			$ProductName=$row['ProductName'];
			$Price=$row['Price'];
			$ProductImage1=$row['ProductImage1'];

			list($width,$height)=getimagesize($ProductImage1);
			$w=$width/2;
			$h=$height/2;
		?>
			<td>
				<img src="<?php echo $ProductImage1 ?>" width="<?php echo $w; ?>" height="<?php echo $h ?>" />
				<br/>
				<h2><?php echo $ProductName ?></h2>
				<b><?php echo $Price ?> USD</b>
				<br/>
				<a href="Product_Details.php?ProductID=<?php echo $ProductID ?>">Details</a>	
			</td>
		<?php
		}
		echo "</tr>";
	}
} 
?>
</table>

</fieldset>
</form>
</body>
</html>



