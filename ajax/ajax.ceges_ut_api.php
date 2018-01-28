<?php
$server = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
require_once '../functions.php';
require_once '../azaz.php';
function penz($value) {
  return number_format($value,0,',',' ');
}
/*
incoming data struct
kezdet
vegzet
rendszam
kolcson
*/
$data = $_POST['data'];
$data = $data;
$JSON = array();
for ($i=0; $i < sizeof($data); $i++) {
$temp = array(
  "auto_rendszam"       => "",
  "egysegar"            => "",
  "teljesitett_km"      => "",
  "osszeg"              => "",
  "osszeg_azaz"         => "",
  "afa"                 => "",
  "global_osszeg"       => "",
  "kolcsonbe_ado"       => "",
  "kolcsonbe_ado_telep" => "",
  "kolcsonbe_vevo"      => "",
  "kolcsonbe_vevo_telep"=> "",
  "idoszak_kezdet"      => "",
  "idoszak_vege"        => "",
  "kelt"                => ""
);
array_push($JSON, $temp);
$JSON[$i]['auto_rendszam']  = $data[$i][0]['rendszam'];
$JSON[$i]['idoszak_kezdet'] = $data[$i][0]['kezdet'];
$JSON[$i]['idoszak_vege']   = $data[$i][0]['vegzet'];
$JSON[$i]['kolcsonbe_vevo'] = $data[$i][0]['kolcson'];

$nap = $data[$i][0]['vegzet'];
$nap2 = str_replace('-', '/', $nap);
$tomorrow = date('m-d-Y',strtotime($nap2 . "+1 days"));
$JSON[$i]['kelt'] = $tomorrow;

/* Autó adatainak meghatározása a rendszám alapján */
$rendszam = $JSON[$i]['auto_rendszam'];
$q = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
$sq = mysqli_query($server, $q);
while ($sqa = mysqli_fetch_assoc($sq)) {
  $JSON[$i]['kolcsonbe_ado'] = $sqa['ceg'];
}

/* Cégek adatainak meghatározása */
$kolcsonbe_ado = mysqli_real_escape_string($server,$JSON[$i]['kolcsonbe_ado']);
$kolcsonbe_vevo = mysqli_real_escape_string($server,$JSON[$i]['kolcsonbe_vevo']);
$q = "SELECT * FROM cegek WHERE ceg = '{$kolcsonbe_ado}' OR ceg = '{$kolcsonbe_vevo}'";
$sq = mysqli_query($server, $q);
  while ($sqa = mysqli_fetch_assoc($sq)) {
    if ($JSON[$i]['kolcsonbe_ado'] == $sqa['ceg']) {
    $JSON[$i]['kolcsonbe_ado_telep'] = $sqa['telep'];
    $JSON[$i]['egysegar'] = $sqa['dij'];
  } else {
    $JSON[$i]['kolcsonbe_vevo_telep'] = $sqa['telep'];
    $kolcsonbe_vevo_id = $sqa['id'];
  }
}
/* utaks adatainak meghatározása */
$kezdet = $JSON[$i]['idoszak_kezdet'];
$vege   = $JSON[$i]['idoszak_vege'];

$teljesitett_km = 0;
$q = "SELECT * FROM utak WHERE rendszam = '{$rendszam}' AND datum >= '{$kezdet}' AND datum <= '{$vege}' AND kolcsonbe = '{$kolcsonbe_vevo_id}'";
$sq = mysqli_query($server, $q);
  while ($sqa = mysqli_fetch_assoc($sq)) {
    $km = $sqa['km'];
    $teljesitett_km += $km;
}
$JSON[$i]['teljesitett_km'] = $teljesitett_km;
// számolási műveletek elvégzése

$osszeg = $teljesitett_km * (int)$JSON[$i]['egysegar'];
$JSON[$i]['osszeg'] = penz($osszeg);
$JSON[$i]['osszeg_azaz'] = szam($osszeg);
$afa = $osszeg * 0.27;
$JSON[$i]['afa'] = penz($afa);
$JSON[$i]['global_osszeg'] = penz($osszeg + $afa);

}
header("Content-Type: text/json; charset=utf8");
echo json_encode($JSON);
$server->close();
?>
