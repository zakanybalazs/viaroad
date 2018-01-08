<?php
session_start();
$userName = $_SESSION['userName'];
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$idoszak = $_POST['idoszak'];
$q = "SELECT * FROM amortizacio WHERE ervenyes = '{$idoszak}'";
$sq = mysqli_query($viapanServer, $q);
$json = array();
$egyseg = "nincs";
$ervenyes = $idoszak;
while($sqa = mysqli_fetch_assoc($sq)) {
  $egyseg = $sqa['egyseg'];

}

if ($egyseg != "nincs") {
  // ha nincs pont arra az idoszakra, akkor a legutolso
  $q = "SELECT * FROM amortizacio ORDER BY id ASC";
  $sq = mysqli_query($viapanServer, $q);
  while($sqa = mysqli_fetch_assoc($sq)) {
    $egyseg = $sqa['egyseg'];
    $ervenyes = $sqa['ervenyes'];
  }
}
$json[0] = array('egyseg' => $egyseg, 'ervenyes' => $ervenyes);
header("Content-Type: text/json");
echo json_encode($json);
$viapanServer->close();
?>
