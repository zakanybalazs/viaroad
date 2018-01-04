<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json = array();

$id = $_POST['Pid'];
$section = $_POST['Psection'];
if ($section == "alairo") {
  # code...
  $q = "UPDATE elszamolasok SET statusz = 'allowed' WHERE id = $id";
  $sendQ = mysqli_query($viapanServer,$q);

}
if ($section == "admin") {
  $q = "UPDATE elszamolasok SET statusz = 'done' WHERE id = $id";
  $sendQ = mysqli_query($viapanServer,$q);

}

  if(!$sendQ) {
     $json[]=array(
       "failed"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "ok"
     );
   }

header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
