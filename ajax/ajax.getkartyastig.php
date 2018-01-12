<?php
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$idoszak = $_POST['idoszak'];
$json = array();
$q = "SELECT * FROM kartyastig WHERE idoszak = '{$idoszak}'";
$sq = mysqli_query($viapanServer, $q);
$i = 0;
while($sqa = mysqli_fetch_assoc($sq)) {
      $kartyaszam = $sqa['kartyaszam'];
      $szamlazando = $sqa['szamlazando'];
      $pdf_nev = $sqa['pdf_nev'];
      $pdf_hely = $sqa['pdf_hely'];
      $sm_array = array('kartyaszam' => $kartyaszam, 'szamlazando' => $szamlazando, 'pdf_nev' => $pdf_nev, 'pdf_hely' => $pdf_hely);
      array_push($json,$sm_array);
}
header("Content-Type: text/json");
echo json_encode($json);
$viapanServer->close();
?>
