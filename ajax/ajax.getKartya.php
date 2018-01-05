<?php
session_start();
$userName = $_SESSION['userName'];
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$idoszak = $_POST['idoszak'];
$q = "SELECT * FROM autok WHERE kategoria = 'kartyas'";
$sq = mysqli_query($viapanServer, $q);
$json = array();
$counter = 0;
while($sqa = mysqli_fetch_assoc($sq)) {
      $rendszam = $sqa['rendszam'];
      $tulaj = $sqa['tulaj'];
      $isSet = false;
      $w = "SELECT * FROM utak WHERE idoszak = '{$idoszak}' AND rendszam = '{$rendszam}'";
      $sw = mysqli_query($viapanServer, $w);
      while($swa = mysqli_fetch_assoc($sw)) {
        $isSet = "set";
      }
      $esc = array('nev' => $tulaj, 'rendszam' => $rendszam, 'isSet' => $isSet);
    $json[$counter] = $esc;
    $counter += 1;
}
header("Content-Type: text/json");
echo json_encode($json);
$viapanServer->close();
?>
