<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json  = array();
 $PostuserName = $_POST['PostuserName'];
 $Postrendszam = $_POST['Postrendszam'];
 $Postkategoria = $_POST['Postkategoria'];
 $Postmarka = $_POST['Postmarka'];
 $Posttipus = $_POST['Posttipus'];
 $Postterfogat = $_POST['Postterfogat'];
 $Postfogyasztas = $_POST['Postfogyasztas'];
 $Postuzemanyag = $_POST['Postuzemanyag'];
 $Postforgalmihely = $_POST['Postforgalmihely'];
 $Postforgalminev = $_POST['Postforgalminev'];
 $Postszerzodeshely = $_POST['Postszerzodeshely'];
 $Postszerzodesnev = $_POST['Postszerzodesnev'];
if (!empty($_POST['PostuserName'])) {
  if(ujSajatAuto($PostuserName,$Postrendszam,$Postkategoria,$Postmarka,$Posttipus,$Postterfogat,$Postfogyasztas,$Postuzemanyag,$Postforgalmihely,$Postforgalminev,$Postszerzodeshely,$Postszerzodesnev)=="ok") {
     $json[]=array(
       "ok"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "failed"
     );
   }
}
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
