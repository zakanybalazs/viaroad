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
 $Postceg = $_POST['Postceg'];
 $Postrendszam = $_POST['Postrendszam'];
 $Postdatum = $_POST['Postdatum'];
 $Postdatum2 = date("Y-m-d h:i:s");
 $Postkolcsonbe = $_POST['Postkolcsonbe'];
 $Posthonnan = $_POST['Posthonnan'];
 $Posthova = $_POST['Posthova'];
 $Postcel = $_POST['Postcel'];
 $PostcelTank = "Tankolás";
 $Postkezdokm = $_POST['Postkezdokm'];
 $Postzarokm = $_POST['Postzarokm'];
 $Postkm = $_POST['Postkm'];
 $Postfogyasztas = $_POST['Postfogyasztas'];
 $Postuzemanyag = $_POST['Postuzemanyag'];
 $Postkephely = $_POST['Postkephely'];
 $Postkepnev = $_POST['Postkepnev'];
 $Posttulaj = $_POST['Posttulaj'];

switch ($Postkolcsonbe) {
  case 'Meló-Diák Dél Iskolaszövetkezet':
  $Postkolcsonbe ="md";
  break;
  case 'Dologidő Kft':
  $Postkolcsonbe ="di";
  break;
  case 'Munka Erő Kft':
  $Postkolcsonbe ="me";
  break;
  case 'Önfoglalkoztató szociális szövetkezet':
  $Postkolcsonbe ="oszoc";
  break;
  default:
  $Postkolcsonbe ='NA';
  break;
}

if (!empty($_POST['PostuserName'])) {
  if ($Posttulaj == "ceges") {
  if(ujUtCeges($PostuserName,$Postceg,$Postrendszam,$Postdatum,$Postkolcsonbe,$Posthonnan,$Posthova,$PostcelTank,$Postkezdokm,$Postzarokm,$Postkm,$Postfogyasztas, $Postuzemanyag, $Postkephely, $Postkepnev)=="ok") {
    kilometerUpdate($Postrendszam,$Postzarokm,$Postdatum,$PostuserName);
    piszkozatUpdate($PostuserName,$Postrendszam,$Postdatum2,$Postkolcsonbe,$Posthova,$Postcel,$Postzarokm);
     $json[]=array(
       "ok"
     );
   } else {
     # send something to say it didn't work
     $json[]=array(
       "failed"
     );
   }
 } else {
   if(ujUtMagan($PostuserName,$Postrendszam,$Postdatum,$Posthonnan,$Posthova,$Postcel,$Postkezdokm,$Postzarokm,$Postkm,$Postfogyasztas,$Postuzemanyag, $Postkephely, $Postkepnev)=="ok") {
     kilometerUpdate($Postrendszam,$Postzarokm,$Postdatum,$PostuserName);
     piszkozatUpdate($PostuserName,$Postrendszam,$Postdatum2,$Postkolcsonbe,$Posthova,$Postcel,$Postzarokm);
     $json[]=array(
       "ok"
     );
 } else {
   # didn't work
   $json[]=array(
     "failed"
   );
}
}
}

header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
