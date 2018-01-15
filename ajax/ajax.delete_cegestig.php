<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
$json  = array();
$id = $_POST['id'];

$q = "DELETE FROM cegestigek WHERE id = '{$id}'";
$sq = mysqli_query($viapanServer, $q);

if ($sq) {
  $json = "ok";
} else {
  $json = "error";
}
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
