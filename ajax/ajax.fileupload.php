<?php
session_start();
$userName = $_SESSION['userName'];
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
$kilometerQuery = "SELECT * FROM piszkozat WHERE felhasznalo = '{$userName}'";
$piszkozatBetoltes = mysqli_query($viapanServer, $kilometerQuery);
while ($piszkozatResult = mysqli_fetch_assoc($piszkozatBetoltes)) {
  $rendszamPre = $piszkozatResult['rendszam'];
  $datumPre = $piszkozatResult['datum'];
}
$inputfilename = $_FILES['kep']['name'];
$kepNev = $datumPre . $rendszamPre.'.jpg';
$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
               "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
               "â€”", "â€“", ",", "<", ">", "/", "?");
$clean = trim(str_replace($strip, "", strip_tags($kepNev)));
$hely = '../uploads/' . $clean;
 $json  = array();
 // move_uploaded_file($_FILES['kep']['tmp_name'], $hely);
 rename($_FILES['kep']['tmp_name'],$hely);
 $del = "DELETE FROM piszkozat WHERE felhasznalo = '{$userName}'";
 $delsiker = mysqli_query($viapanServer,$del);
$viapanServer->close();
?>
