<?php
session_start();
$userName = $_SESSION['userName'];
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$kilometerQuery = "SELECT * FROM autok WHERE tulaj = '{$userName}' ORDER BY id";
$piszkozatBetoltes = mysqli_query($viapanServer, $kilometerQuery);
$idMax = 0;
$rendszam = "igazan mindegy mi van itt";
while ($piszkozatResult = mysqli_fetch_assoc($piszkozatBetoltes)) {
  $rendszamPre = $piszkozatResult['rendszam'];
  $GetID = $piszkozatResult['id'];
  if ($GetID > $idMax) {
    $$idMax = $GetID;
    $rendszam = $rendszamPre;
  }
}
$inputfilename = $_FILES['kep2']['name'];
$ext = pathinfo($inputfilename, PATHINFO_EXTENSION);
$ext = strtolower($ext);
$kepNev = $rendszam.'szerzodes.'.$ext;
$hely = '../uploads/autok/kolcsonadasi/' . $kepNev;
 $json  = array();
 // move_uploaded_file($_FILES['kep']['tmp_name'], $hely);
 rename($_FILES['kep2']['tmp_name'],$hely);

$viapanServer->close();
?>
