<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $felhasznalo = $_POST['felhasznalo_nev'];
 $felhasznalo = mysqli_real_escape_string($viapanServer,$felhasznalo);
 $auth = $_POST['auth'];

$q = "UPDATE felhasznalok SET authority = '{$auth}' WHERE felhasznalo = '{$felhasznalo}'";
$sq = mysqli_query($viapanServer, $q);
header("Content-Type: text/json");

?>
