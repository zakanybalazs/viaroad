<?php
require_once "../functions.php";
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
if ( !$viapanServer ) {
  echo "Nem tudok kapcsolódni a szerverhez" . PHP_EOL;
  echo "Dubugging error: " .mysqli_get_connection_stats();
  exit;
}
// construct empty array for the response
$json  = array();
// get sent data
$kezd = $_POST['Pkezd'];
$vege = $_POST['Pvege'];
$x = 0;
// select all rendszam, for going through it
$q1 = "SELECT * FROM autok WHERE tulaj = 'ceges'";
$sq1 = mysqli_query($viapanServer,$q1);
while ($sqa1 = mysqli_fetch_assoc($sq1)) {
  $rendszam = $sqa1['rendszam'];
  // kilistazzuk a cegeket, figyleni kell hogy csak real escape nevekeet fogad el!
  $q2 = "SELECT * FROM cegek WHERE dij is null";
  $sq2 = mysqli_query($viapanServer, $q2);
  while ($sqa2 = mysqli_fetch_assoc($sq2)) {
    $ceg = $sqa2['id'];
    // $ceg = mysqli_real_escape_string($viapanServer, $ceg);
// itt kell megadni a szamlalot, hogy legyen 0.
  $kmo = 0;
  $x = $x + 1;
// ez lesz az indexe a dolognak
    //  megnezk hol van ilyen az takban
  $q3 = "SELECT * FROM utak WHERE rendszam = '{$rendszam}' AND kolcsonbe = '{$ceg}' AND datum BETWEEN '{$kezd}' AND '{$vege}'";
  $sq3 = mysqli_query($viapanServer, $q3);
  while ($sqa3 = mysqli_fetch_assoc($sq3)) {
    $km = $sqa3['km'];
    $kmo = $kmo + $km;
} // level 3 utak
$cegNev = getCegNameByID($ceg);
array_push($json, ['rendszam' => $rendszam, 'ceg' => $ceg, 'cegnev' => $cegNev, 'km' => $kmo]);
}// level 2 cegek

} // level 1 rendszamok

array_push($json, ['rendszam' => 'end', 'ceg' => 'end', 'km' => 'end']);
//visszaküldjük az arrayt, hogy ki tudja irni, amit kell
header("Content-Type: text/json");
echo json_encode(array( $json ));

?>
