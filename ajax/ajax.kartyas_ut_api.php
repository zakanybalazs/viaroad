<?php
$server = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
require_once '../functions.php';
require_once '../azaz.php';
function penz($value) {
  return number_format($value,0,',',' ');
}
/* incoming data struct
data[n][rendszam, kartyaszam, idoszak, idexek[]],
csv[n][ceg,date,kartyaszam,egysegar,osszeg, kilometeroraallas]
*/
$data = $_POST['data'];
$csv = $_POST['csv'];
$amortizacio = $_POST['amortizacio'];
$JSON_ESC = [];
for ($index_g=0; $index_g < sizeof($data); $index_g++) {

$JSON = array(
  "elso_nap"		            => "", //
	"utolso_nap"			        => "", //
	"ceg"			                => "", //
	"tulaj"                   => "", //
	"tulaj_adoszam"           => "", //
	"tulaj_beosztas"          => "", //
	"tulaj_lakcim"            => "", //
	"tulaj_szul_ido"          => "", //
	"tulaj_szul_hely"         => "", //
	"tulaj_szolg_hely"        => "", //
	"auto_rendszam"           => "", //
  "auto_kartyaszam"         => "",
	"auto_terfogat"           => "", //
	"auto_marka"              => "", //
	"auto_tipus"              => "", //
	"auto_fogyasztas"         => "", //
	"auto_uzemanyag"          => "", //
	"utak"			              => "", //
  "ossz_km_uzleti" 		      => 0, //
	"ossz_koltseg_uzleti"     => 0, //
  "ossz_km_magan" 		      => 0, //
  "ossz_koltseg_magan" 		  => 0, //
	"ossz_koltseg_magan_azaz" => 0, //
	"ossz_koltseg"            => 0, //
	"ossz_km"	                => 0, //
	"ossz_amortizacio"        => 0, //
	"kelt"                    => ""  //
);


// filter the csv for using it per car
$filtered_csv = [];
$indexek = $data[$index_g]['indexek'];
for ($i=0; $i < sizeof($indexek); $i++) {
  array_push($filtered_csv, $csv[$indexek[$i]]);
}

$JSON['elso_nap'] = $filtered_csv[0]['kilometeroraallas'];
$JSON['utolso_nap'] = $filtered_csv[$i-1]['kilometeroraallas'];
$JSON['ossz_km'] = $JSON['utolso_nap'] - $JSON['elso_nap'];
$JSON['ceg'] = $filtered_csv[0]['ceg'];
$JSON['kelt'] = date("Y-m-d");
$JSON['auto_rendszam'] = $data[$index_g]['rendszam'];
$rendszam = $data[$index_g]['rendszam'];
$JSON['auto_kartyaszam'] = $filtered_csv[0]['kartyaszam'];
// ossz_koltseg
for ($z=1; $z < sizeof($filtered_csv); $z++) {
  $JSON['ossz_koltseg'] += round((float)$filtered_csv[$z]['osszeg']);
}

// tulaj es auto adatok meghatarozasa
$t = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
$st = mysqli_query($server, $t);
while ($sta = mysqli_fetch_assoc($st)) {
  $JSON["auto_rendszam"]   = $sta['rendszam'];
  $JSON["auto_terfogat"]   = $sta['terfogat'];
  $JSON["auto_marka"]      = $sta['marka'];
  $JSON["auto_tipus"]      = $sta['tipus'];
  $JSON["auto_fogyasztas"] = $sta['fogyasztas'];
  $JSON["auto_uzemanyag"]  = $sta['uzemanyag'];
  $JSON["tulaj"]           = $sta['tulaj'];
}

$safeuser = $JSON["tulaj"];
$u = "SELECT id FROM felhasznalok WHERE felhasznalo = '{$safeuser}'";
$su = mysqli_query($server, $u);
while ($sua = mysqli_fetch_assoc($su)) {
  $userID = $sua['id'];
}
/*
Üzemanyag ár meghatározása az időszak alapján
*/
$w = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$userID}'";
$sw = mysqli_query($server, $w);
while ($swa = mysqli_fetch_assoc($sw)) {
    $JSON["tulaj_adoszam"]    = $swa['adoszam'];
    $JSON["tulaj_beosztas"]   = $swa['beosztas'];
    $JSON["tulaj_lakcim"]     = $swa['lakcim'];
    $JSON["tulaj_szul_ido"]   = $swa['szuletesiido'];
    $JSON["tulaj_szul_hely"]  = $swa['szuletesihely'];
    $JSON["tulaj_szolg_hely"] = $swa['szolgalatihely'];
}


$utak = [];
$l = sizeof($filtered_csv) -1;
$counter = 0;
for ($k=0; $k < $l; $k++) {
$kezd = strtotime($filtered_csv[$k]['date']);
$veg  = strtotime($filtered_csv[$k+1]['date']);
$egysegar = $filtered_csv[$k]['egysegar'];
$fogyasztas = $JSON['auto_fogyasztas'] / 100;

$w = "SELECT * FROM utak WHERE rendszam = '{$rendszam}'";
$sw = mysqli_query($server, $w);
$ossz_km = 0;
while ($swa = mysqli_fetch_assoc($sw)) {
  if (strtotime($swa["datum"]) > $kezd && strtotime($swa["datum"]) <= $veg) {
    $counter += 1;
    $ut = array(
      "ut_id" => "",
      "ut_datum" => "",
      "ut_honnan" => "",
      "ut_hova" => "",
      "ut_cel" => "",
      "ut_kezdo_km" => "",
      "ut_zaro_km" => "",
      "ut_km" => "",
      "ut_koltseg" => "",
      "ut_amortizacio" => "",

    );
    $ut["ut_id"] = $swa['id'];
    $ut["ut_datum"] = date('Y-m-d',strtotime($swa['datum']));
    $ut["ut_honnan"] = $swa['honnan'];
    $ut["ut_hova"] = $swa['hova'];
    $ut["ut_cel"] = $swa['cel'];
    $ut["ut_kezdo_km"] = $swa['kezdokm'];
    $ut["ut_zaro_km"] = $swa['zarokm'];
    $ut["ut_km"] = $swa['km'];
    $ut["ut_koltseg"] = round((float)$egysegar * (float)$fogyasztas * (int)$ut["ut_km"]);
    $ut["ut_amortizacio"] = (int)$amortizacio * (int)$ut["ut_km"];
    $JSON['ossz_km_uzleti'] += (int)$swa['km'];
    $JSON['ossz_koltseg_uzleti'] += $ut["ut_koltseg"];
    $JSON['ossz_amortizacio'] += (int)$ut["ut_amortizacio"];
    $ut["ut_koltseg"] = penz($ut["ut_koltseg"]);
    $ut["ut_amortizacio"] = penz($ut["ut_amortizacio"]);
    array_push($utak,$ut);
  }
}
}
$JSON['utak'] = $utak;
$JSON['ossz_km_magan'] = (int)$JSON['ossz_km'] - (int)$JSON['ossz_km_uzleti'];
$JSON['ossz_koltseg_magan'] = (int)$JSON['ossz_koltseg'] - (int)$JSON['ossz_koltseg_uzleti'];
$JSON['ossz_koltseg_magan_azaz'] = szam((int)$JSON['ossz_koltseg_magan']);
$JSON['ossz_amortizacio'] = penz($JSON['ossz_amortizacio']);
$JSON['ossz_koltseg'] = penz((int)$JSON['ossz_koltseg']);
$JSON['ossz_koltseg_uzleti'] = penz((int)$JSON['ossz_koltseg_uzleti']);
$JSON['ossz_koltseg_magan'] = penz((int)$JSON['ossz_koltseg_magan']);

array_push($JSON_ESC, $JSON);
}
header("Content-Type: text/json; charset=utf8");
echo json_encode($JSON_ESC,JSON_FORCE_OBJECT);
$server->close();
?>
