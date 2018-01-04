<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
$json  = array();
$id = $_POST['di'];
$rendszamKeres = "SELECT * FROM utak WHERE id = '{$id}'";
$megKeresem = mysqli_query($viapanServer, $rendszamKeres);
while ($keres = mysqli_fetch_assoc($megKeresem)) {
  $rendszam = $keres['rendszam'];
}

$submitQ = "DELETE FROM utak WHERE id = '{$id}'";
if ($submit = mysqli_query($viapanServer, $submitQ)) {
  $json = array('ok');
  ujKilometerMax($rendszam);
} else {
  $json = array('not ok');
}


header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
