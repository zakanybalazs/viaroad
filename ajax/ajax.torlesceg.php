<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
$json  = array();
$id = $_POST['PostId'];

$submitQ = "DELETE FROM cegek WHERE id = '{$id}'";
if ($submit = mysqli_query($viapanServer, $submitQ)) {
  $json = array('ok');
} else {
  $json = array('not ok');
}
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
