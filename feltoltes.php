<?php
session_start();
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
include "functions.php";
$userName = $_SESSION['userName'];
$userId = $_SESSION['userName'];
$userAuth = $_SESSION['auth'];
if (!isset($userName)) {
  ?>
  <script type="text/javascript">
    window.location="index.php";
  </script>
<?php } ?>
<?php
//itt kezdodik a function
$hely = "uploads";
$helyVeg = $hely . basename( $_FILES['kep']['name']);
$feltoltendoKep = ($_FILES['kep']['name']);
move_uploaded_file(['kep']['tmp_name'], $helyVeg);
 ?>
