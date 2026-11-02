<?php  
function AddProduct($ProductID,$PurchasePrice,$PurchaseQuantity)
{
	include('connect.php');

	$query="SELECT * FROM product WHERE ProductID='$ProductID' ";  
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$row=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<p>No Product Found!</p>";
		exit();
	}

	if ($PurchaseQuantity < 1) 
	{
		echo "<script>window.alert('Please enter correct quantity.')</script>";
		echo "<script>window.location='Purchase.php'</script>";
	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$index=IndexOf($ProductID);
		
		if($index == -1) 
		{
			$size=count($_SESSION['Purchase_Functions']);
			echo $size;
			$_SESSION['Purchase_Functions'][$size]['ProductID']=$ProductID;
			$_SESSION['Purchase_Functions'][$size]['PurchasePrice']=$PurchasePrice;
			$_SESSION['Purchase_Functions'][$size]['PurchaseQuantity']=$PurchaseQuantity;

			$_SESSION['Purchase_Functions'][$size]['ProductName']=$row['ProductName'];
			$_SESSION['Purchase_Functions'][$size]['ProductImage1']=$row['ProductImage1'];			
		}
		else
		{
			$_SESSION['Purchase_Functions'][$index]['PurchaseQuantity']+=$PurchaseQuantity;

		}
	}
	else
	{
		$_SESSION['Purchase_Functions']=array();

		$_SESSION['Purchase_Functions'][0]['ProductID']=$ProductID;
		$_SESSION['Purchase_Functions'][0]['PurchasePrice']=$PurchasePrice;
		$_SESSION['Purchase_Functions'][0]['PurchaseQuantity']=$PurchaseQuantity;

		$_SESSION['Purchase_Functions'][0]['ProductName']=$row['ProductName'];
		$_SESSION['Purchase_Functions'][0]['ProductImage1']=$row['ProductImage1'];
	}
	echo "<script>window.location='Purchase.php'</script>";
}

function RemoveProduct($ProductID)
{
	$Index=IndexOf($ProductID);

	unset($_SESSION['Purchase_Functions'][$Index]);

	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase.php'</script>";
}

function ClearAll()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='Purchase.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
		$TotalAmount=$TotalAmount + ($PurchasePrice * $PurchaseQuantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
		$TotalQuantity=$TotalQuantity + ($PurchaseQuantity);
	}
	return $TotalQuantity;
}

function IndexOf($ProductID)
{
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;	
	}

	$size=count($_SESSION['Purchase_Functions']);

	if ($size < 1) 
	{
		return -1;
	}
	else
	{
		for ($i=0; $i < $size; $i++) 
		{ 
			if($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductID']) 
			{
				return $i;
			}	
		}
		return -1;
	}
}
?>