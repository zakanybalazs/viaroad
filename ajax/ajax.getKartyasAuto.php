<?php
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$kartyak = json_decode($_POST['array']);
$json = array();
  for ($i=0; $i < sizeof($kartyak); $i++) {
    $kartyaszam = $kartyak[$i];
    $kartyaszam = (string)$kartyaszam;
    $q = "SELECT * FROM autok WHERE kartyaszam = '{$kartyaszam}'";
    $sq = mysqli_query($viapanServer, $q);
      while($sqa = mysqli_fetch_assoc($sq)) {
        $rendszam = $sqa['rendszam'];
        array_push($json, array('rendszam' => $rendszam, 'kartyaszam' => $kartyaszam));
      }
  }
header("Content-Type: text/json");
echo json_encode($json);
$viapanServer->close();
?>
