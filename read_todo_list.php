<?php
require_once "functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}

 $json  = array();
 /* ----  ehhez még be kell állitani egy igazi queryt -----  */
if($result = $viapanServer->query("SELECT * FROM utak")) {
   while ($row=$result->fetch_assoc()) {
       $json[]=array(
           'rendszam'=>$row['rendszam'],
       );
   }
}

$result->close();
header("Content-Type: text/json");
echo json_encode(array( 'rendszam'  =>   $json ));
$viapanServer->close();
?>
