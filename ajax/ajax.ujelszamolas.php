<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json = array();
 $felhasznalo = $_POST['Pfelhasznalo'];
 $felhasznaloid = getUserId($felhasznalo);
 $kezdo = $_POST['Pkezdo'];
 $vege = $_POST['Pvege'];
 $kephely = $_POST['Pkephely'];
 $rendszam = $_POST['Prendszam'];
 $pdfhely = $_POST['Ppdfhely'];
 $alairoid = $_POST['Palairoid'];
 $adminid = $_POST['Padminid'];
 $statusz = "sent";

$q = "INSERT INTO elszamolasok (felhasznaloid,alairoid,irodavezetoid,rendszam,kezdo,vege,kephely,dokhely,statusz) VALUES ('{$felhasznaloid}','{$alairoid}','{$adminid}','{$rendszam}','{$kezdo}','{$vege}','{$kephely}','{$pdfhely}','{$statusz}')";
$sendQ = mysqli_query($viapanServer,$q);
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
