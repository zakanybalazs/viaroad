<?php
require_once 'functions.php';
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
$todo = isset($_POST['todo']) ? $_POST["todo"] : "";
$insert="INSERT INTO utak (rendszam) VALUES ('$rendszam')";
$mysqli->query($insert);
printf("Thanks for the new element! \n");
$mysqli->close();
?>

 ?>
