<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");

$ervenyes = $_POST['ervenyes'];
$dij = $_POST['dij'];

$q = "INSERT INTO amortizacio (ervenyes, egyseg) VALUES ('{$ervenyes}', '{$dij}')";
$sq = mysqli_query($viapanServer, $q);

  if($sq) {
     $json[]=array(
       "ok"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "failed"
     );
   }

header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
