<?php  
session_start();
session_destroy();
session_regenerate_id();

//unset($_SESSION['StaffName']);

echo "<script>window.alert('Logout Success.')</script>";
echo "<script>window.location='Customer_Login.php'</script>";
?>