<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json  = array();
  $rendszam = $_GET['rdn'];
if($result = $viapanServer->query("SELECT * FROM autok WHERE rendszam = '$rendszam'")) {
   while ($row=$result->fetch_assoc()) {
       $json[]=array(
           $row['tulaj'],
       );
   }
}

$result->close();
header("Content-Type: text/json");
echo json_encode(array( $json ));
$viapanServer->close();
?>
