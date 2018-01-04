<?php
/*
Ez a fájl lesz felelős az apptóól begyűjteni a login infót,
Lefuttatja az ellenőrzési folyamatokat és JSON választ ad.
*/
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
 $json  = array();
 $user = $_GET['felhasznalo'];
 $jelszo = $_GET['pass'];
// if($result = $viapanServer->query("SELECT * FROM kilometer WHERE rendszam = '$rendszam'")) {
//    while ($row=$result->fetch_assoc()) {
//        $json[]=array(
//            $row['kilometer'],
//        );
//    }
// }
$siker = login($user, $jelszo);
if ($siker) {
$userId = getUserId($user);
$auth = getUserAuth($userId);
$json[]=array(
  'id' => $userId,
  'felhasznalo' => $user,
  'auth' => $auth,
);
} else {
  $json[]=array(
    'id' => 'false',
    'felhasznalo' => 'false',
    'auth' => 'false',
  );
}

// $result->close();
header("Content-Type: text/json");
echo json_encode(array( $json ));
$viapanServer->close();
?>
