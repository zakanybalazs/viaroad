<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $vezeteknev = $_POST['Postvezeteknev'];
 $keresztnev = $_POST['Postkeresztnev'];
 $adoszam = $_POST['Postadoszam'];
 $beosztas = $_POST['Postbeosztas'];
 $lakcim = $_POST['Postlakcim'];
 $szuletesiido = $_POST['Postszuletesiido'];
 $szuletesihely = $_POST['Postszuletesihely'];
 $szolgalatihely = $_POST['Postszolgalatihely'];
 $alairo = $_POST['Postalairo'];
 $adminisztrator = $_POST['Postadminisztrator'];
 $userName = $_POST['PostUserName'];
 $email = $_POST['Postemail'];

$safeUser = mysqli_real_escape_string($viapanServer,$userName);
$id = getUserId($safeUser);
$json = array();
$res = ujSzemelyAdat($vezeteknev,$keresztnev,$adoszam,$beosztas,$lakcim,$szuletesiido,$szuletesihely,$szolgalatihely,$alairo,$adminisztrator,$id,$email);
  if($res =="ok") {
     $json[]=array(
       "ok"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "not ok"
     );
   }

header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
