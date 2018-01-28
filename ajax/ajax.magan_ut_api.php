<?php
$server = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
require_once '../functions.php';
function penz($value) {
  return number_format($value,0,',',' ');
}
/* incoming data struct
rendszam : rendszam,
tulaj    : userName,
kezdo    : kezdo,
vege     : vege,
ceg      : ceg,
*/
$JSON = array(
  "kezdet"		      => "",
	"vege"			      => "",
	"ceg"			        => "",
	"uzemanyag_ar"	  => "",
	"tulaj"           => "",
	"tulaj_adoszam"   => "",
	"tulaj_beosztas"  => "",
	"tulaj_lakcim"    => "",
	"tulaj_szul_ido"  => "",
	"tulaj_szul_hely" => "",
	"tulaj_szolg_hely"=> "",
	"auto_rendszam"   => "",
	"auto_terfogat"   => "",
	"auto_marka"      => "",
	"auto_tipus"      => "",
	"auto_fogyasztas" => "",
	"auto_uzemanyag"  => "",
	"utak"			      => "",
	"ossz_km" 		    => "",
	"ossz_koltseg"    => "",
	"amortizacio"	    => "",
	"ossz_amortizacio" => "",
	"global_osszeg"   => ""
);
$JSON['auto_rendszam'] = $_POST['rendszam'];
$JSON['tulaj']         = $_POST['tulaj'];
$JSON['kezdet']        = $_POST['kezdo'];
$JSON['vege']          = $_POST['vege'];
$JSON['ceg']           = $_POST['ceg'];

// $JSON['auto_rendszam'] = "NDN239";
// $JSON['tulaj']         = "Zákány Balázs";
// $JSON['kezdet']        = "2018-01-01";
// $JSON['vege']          = "2018-01-29";
// $JSON['ceg']           = "Meló-Diák Dél Iskolaszövetkezet";

/*
 Előre meghatarozom az adatstruktúrát, amit vissza kell majd küldeni.
 Ez után már csak minden adatot be kell illeszteni a helyére
*/

/* Autó adatainak meghatározása a rendszám alapján */
$rendszam = $JSON['auto_rendszam'];
$q = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
$sq = mysqli_query($server, $q);
while ($sqa = mysqli_fetch_assoc($sq)) {
  $JSON["auto_rendszam"]   = $sqa['rendszam'];
  $JSON["auto_terfogat"]   = $sqa['terfogat'];
  $JSON["auto_marka"]      = $sqa['marka'];
  $JSON["auto_tipus"]      = $sqa['tipus'];
  $JSON["auto_fogyasztas"] = $sqa['fogyasztas'];
  $JSON["auto_uzemanyag"]  = $sqa['uzemanyag'];
}
/*
Üzemanyag ár meghatározása az időszak alapján
*/
    $kezdet = $JSON["kezdet"];
    $uzemanyag_tipus = $JSON["auto_uzemanyag"];
$uzemanyagQ = "SELECT ar FROM uzemanyagar WHERE ervenyes < '{$kezdet}' AND tipus = '{$uzemanyag_tipus}' ORDER BY id ASC";
$uzemanyagSendQ = mysqli_query($server,$uzemanyagQ);
$aid = 0;
while ($uzemanyagAdatok = mysqli_fetch_assoc($uzemanyagSendQ)) {
  $JSON['uzemanyag_ar'] = $uzemanyagAdatok['ar'];
}
/*
Amortizációs egységár meghatározása
*/

$JSON["amortizacio"] = 10;
$a = "SELECT * FROM amortizacio ORDER BY id ASC";
$sa = mysqli_query($server, $a);
while ($saa = mysqli_fetch_assoc($sa)) {
  if (strtotime($saa['egyseg']) <= $kezdet) {
  $JSON["amortizacio"] = $saa['egyseg'];
}
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

/*
Utak kikeresése, és ut változók kiszámítása.
Az utakat egy arrayben kell tárolni, majd azt az
json"utak" ba egybe behelyezni

"ut_id"   		: "151",
"ut_datum"		: "2018-01-16 13:29:00",
"ut_honnan" 	: "Pécs",
"ut_hova"   	: "Budapest",
"ut_cel"    	: "Fejlesztés",
"ut_kezdo_km"	: "33487",
"ut_zaro_km"	: "33507",
"ut_km"			: "20"
*/
$kezdet = $JSON['kezdet'];
$vege   =  $JSON['vege']     = "2018-01-29";
$w = "SELECT * FROM utak WHERE rendszam = '{$rendszam}'";
$sw = mysqli_query($server, $w);
$utak = array();
$ossz_km = 0;
while ($swa = mysqli_fetch_assoc($sw)) {
  if ($swa["datum"] >= $kezdet && $swa["datum"] <= $vege) {
    $ut = array(
      "ut_id" => "",
      "ut_datum" => "",
      "ut_honnan" => "",
      "ut_hova" => "",
      "ut_cel" => "",
      "ut_kezdo_km" => "",
      "ut_zaro_km" => "",
      "ut_km" => "",
    );
    $ut["ut_id"] = $swa['id'];
    $ut["ut_datum"] = $swa['datum'];
    $ut["ut_honnan"] = $swa['honnan'];
    $ut["ut_hova"] = $swa['hova'];
    $ut["ut_cel"] = $swa['cel'];
    $ut["ut_kezdo_km"] = $swa['kezdokm'];
    $ut["ut_zaro_km"] = $swa['zarokm'];
    $ut["ut_km"] = $swa['km'];
    $ossz_km += $swa['km'];
    array_push($utak,$ut);
  }
}

$JSON['utak'] = $utak;
$JSON['ossz_km'] = penz($ossz_km);
$JSON['ossz_koltseg'] = penz(round((int)$JSON['uzemanyag_ar'] * ((float)$JSON['auto_fogyasztas'] / 100) * (int)$ossz_km));
$JSON['ossz_amortizacio'] = penz(round((int)$JSON['amortizacio'] * (int)$ossz_km));
$JSON['global_osszeg'] = penz(round((int)$JSON['ossz_amortizacio'] + (int)$JSON['ossz_koltseg']));

header("Content-Type: text/json; charset=utf8");
echo json_encode($JSON);
$server->close();
?>
