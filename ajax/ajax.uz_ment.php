<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging, error: " .mysqli_get_connection_stats();
  exit;
}
// construct empty array for the response
$json  = array();
$tipus = $_POST['tipus'];
$ervenyes = $_POST['ervenyes'];
$ar = $_POST['ar'];

$q = "INSERT INTO uzemanyagar (tipus, ervenyes, ar) VALUES ('{$tipus}','{$ervenyes}','{$ar}')";
$sq = mysqli_query($server, $q);


//visszaküldjük az arrayt, hogy ki tudja irni, amit kell
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
