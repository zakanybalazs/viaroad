<?php
function penz($value) {
  return number_format($value,0,',',' ');
}
$viapanServer = mysqli_connect("localhost","promothe_sqlu","B4l4Zs","promothe_sql");
require_once "fpdf/fpdf.php";
require_once 'functions.php';
require_once 'azaz.php';
require_once 'fpdf/makefont/makefont.php';
//require_once("fpdf/fpdf.css");
$pdf=new FPDF(); // itt csinaljuk a pdf hivatkozasokat
$pdf->AddPage(); //csinalunk egy pdf dokumentumot
$pdf->AddFont("LiberationMono-Regular","","LiberationMono-Regular.php"); //kell neki egy font set font stilus narrow 12 meret
$pdf->SetFont("LiberationMono-Regular","","10");
$pdf->Cell(0,20,utf8_decode("ÚTNYILVÁNTARTÁS"),0,1,"C");

$pdf->SetFont("LiberationMono-Regular","","9"); // mindenhol ujra kell meghatarozni a fontot

$rendszam = $_POST['rendszam'];
// $rendszam = "VIA123";
$idoszak = $_POST['idoszak'];
// $idoszak = "2018-02";
$idoszak = date("Y-m",strtotime($idoszak));
$idoszakk = strtotime($idoszak);
$idoszakMinusz = date('Y-m',strtotime("- 1 month",$idoszakk));
$kartyaszam = $_POST['kartyaszam'];
// $kartyaszam = "7081678014337919";
$indexek = json_decode($_POST['indexek']);
// $indexek = [0,1,2];
$csv = json_decode($_POST['csv']);
// $csv = array(
//   0 => [
//     'date' => '2017-12-31',
//     'kartyaszam' => '7081678014337919',
//     'ceg' => 'Duna-Humán KFt.',
//     'kilometeroraallas' => 13400,
//     'egysegar' => '360,59',
//     'osszeg' => '56629,01',
//   ],
//   1 => [
//     'date' => '2018-01-08',
//     'kartyaszam' => '7081678014337919',
//     'ceg' => 'Duna-Humán KFt.',
//     'kilometeroraallas' => 13507,
//     'egysegar' => '420',
//     'osszeg' => '30300',
//   ],
//   2 => [
//     'date' => '2018-01-31',
//     'kartyaszam' => '7081678014337919',
//     'ceg' => 'Duna-Humán KFt.',
//     'kilometeroraallas' => 13599,
//     'egysegar' => '400',
//     'osszeg' => '46629,01',
//   ],
// );

// Ehhez igazitva létre kell hozni egy MOLos csv-t, hogy ki lehessen próbálni.

$ceg = $csv[0]['ceg'];
$pdf->Cell(0,5,iconv('utf-8', 'iso-8859-2',"$ceg"),0,1,"C");

$pdf->Line(10,40,200,40);
$pdf->Line(10,40,10,105);
$pdf->Line(200,40,200,105);
$elso = iconv('utf-8', 'iso-8859-2',"A kiküldött");
$pdf->Cell(0,22,$elso,0,1,"C");
$tulajQ = "SELECT * FROM autok WHERE rendszam = '{$rendszam}'";
$tulajSendQ = mysqli_query($viapanServer, $tulajQ);
while ($autoAdatok = mysqli_fetch_assoc($tulajSendQ)) {
  $userName = $autoAdatok['tulaj'];
  $marka = $autoAdatok['marka'];
  $tipus = $autoAdatok['tipus'];
  $uzemanyag = $autoAdatok['uzemanyag'];
  if ($uzemanyag == "diesel") {
    $uzemanyagNev = "Gázolaj";
  } else {
    $uzemanyagNev = "Benzin";
  }
  $fogyasztas = $autoAdatok['fogyasztas'];
  $terfogat = $autoAdatok['terfogat'];
}
$q = "SELECT * FROM autok WHERE kartyaszam = '{$kartyaszam}'";
$sq = mysqli_query($viapanServer, $q);
while($sqa = mysqli_fetch_assoc($sq)) {
      $userName = $sqa['tulaj'];
}
$userName = mysqli_real_escape_string($viapanServer, $userName);
$userID = getUserId($userName);

$szemelyQ = "SELECT * FROM szemelyadatok WHERE felhasznaloid = '{$userID}'";
$szemelySendQ = mysqli_query($viapanServer, $szemelyQ);
while ($szemelyAdatok = mysqli_fetch_assoc($szemelySendQ)) {
  $vezeteknev = $szemelyAdatok['vezeteknev'];
  $keresztnev = $szemelyAdatok['keresztnev'];
  $adoszam = $szemelyAdatok['adoszam'];
  $beosztas = $szemelyAdatok['beosztas'];
  $lakcim = $szemelyAdatok['lakcim'];
  $szuletesiido = $szemelyAdatok['szuletesiido'];
  $szuletesihely = $szemelyAdatok['szuletesihely'];
  $szolgalatihely = $szemelyAdatok['szolgalatihely'];
}

$sor1 = iconv('utf-8', 'iso-8859-2',"       Neve: $vezeteknev $keresztnev                          Lakcíme: $lakcim");
$pdf->Cell(0,8,$sor1,0,1,"L");

$sor2 = iconv('utf-8', 'iso-8859-2',"       Adószáma: $adoszam                          Szül.idő, hely: $szuletesiido, $szuletesihely");
$pdf->Cell(0,8,$sor2,0,1,"L");

$sor3 = iconv('utf-8', 'iso-8859-2',"       Beosztása: $beosztas                         Szolg. hely: $szolgalatihely");
$pdf->Cell(0,8,$sor3,0,1,"L");

$sor4 = iconv('utf-8', 'iso-8859-2',"       F.Rendszám: $rendszam                           Márka, típus: $marka, $tipus");
$pdf->Cell(0,8,$sor4,0,1,"L");

$sor6 = iconv('utf-8', 'iso-8859-2',"       Löktérfogat: $terfogat cm3                         Üzemanyag: $uzemanyag");
$pdf->Cell(0,8,$sor6,0,1,"L");

$pdf->Line(10,105,200,105);

$q = "SELECT * FROM utak WHERE idoszak = '{$idoszakMinusz}'";
$sq = mysqli_query($viapanServer, $q);
while($sqa = mysqli_fetch_assoc($sq)) {
      $elsoNapKm = $sqa['zarokm'];
}

$pdf->Cell(0,10,'',0,1,"L"); // úres, hogy eltolja az alatta lévő cellákat

$elsonap = iconv('utf-8', 'iso-8859-2',"Első nap km: ".$elsoNapKm);
$pdf->Text(15,112,$elsonap);

$q = "SELECT * FROM utak WHERE idoszak = '{$idoszak}'";
$sq = mysqli_query($viapanServer, $q);
while($sqa = mysqli_fetch_assoc($sq)) {
      $utolsoNapKm = $sqa['zarokm'];
}

$utolsonap = iconv('utf-8', 'iso-8859-2',"Utolsó nap km: ".$utolsoNapKm);
$pdf->Text(125,112,$utolsonap);


$pdf->Cell(0,10,'',0,1,"L"); // úres, hogy eltolja az alatta lévő cellákat
$fejlec1 =  iconv('utf-8', 'iso-8859-2',"Kiküldetési utasítás");
$pdf->Cell(0,8,$fejlec1,1,1,"C");
$pdf->SetFont("LiberationMono-Regular","","7"); // mindenhol ujra kell meghatarozni a fontot
$fejlec2 =  iconv('utf-8', 'iso-8859-2'," VID    Dátum           Viszonylata         Induló/Érkező/Megtett km       Célja          Üzemanyag költség    Amortizációs díj ");
$pdf->Cell(0,8,$fejlec2,1,1,"L");

$q = "SELECT * FROM amortizacio WHERE ervenyes = '{$idoszak}'";
$sq = mysqli_query($viapanServer, $q);
while($sqa = mysqli_fetch_assoc($sq)) {
      $amort_szorzo = $sqa['egyseg'];
}

$utakQ = "SELECT * FROM utak WHERE rendszam = '{$rendszam}'";
$utakSendQ = mysqli_query($viapanServer,$utakQ);
$km = 0;
$x = 0;
$uzleti_km = 0;
$uzleti_osszeg = 0;
$amortizacio_osszeg = 0;
$global_osszeg = 0;
while ($rows = mysqli_fetch_assoc($utakSendQ)) {
  if ($rows["datum"] >= $idoszakMinusz && $rows["datum"] <= $idoszak) {
    $x = $x + 1;
    $km = $km + $rows["km"];
    $utID = $rows['id'];
    $kezdokm = $rows['kezdokm'];
    $zarokm = $rows['zarokm'];
    $utKM = $rows["km"];
    $uzleti_km += $utKM;
    $utDatum = $rows["datum"];
    $utHonnan = $rows["honnan"];
    $utHova = $rows["hova"];
    $utCel = $rows["cel"];
    $amortizacios_koltseg = $utKM * $amort_szorzo;
    $amortizacio_osszeg += $amortizacios_koltseg;

    $datumTT = date_create($utDatum);
    $datumFormat = date_format($datumTT,'Y-m-d');
    $datumFormatCount = strtotime($utDatum);
    $km_egysegar = $csv[0]['egysegar'];
    for ($i=1; $i < sizeof($csv); $i++) {
      $csv_datum = strtotime($csv[$i]['date']);
      $csv_datum = $csv_datum + 86400;
        if ($datumFormatCount > $csv_datum) {
          $km_egysegar = $csv[$i]['egysegar'];
        } else {
        }
    }

    $ut_ktg = (float)$km_egysegar * $utKM;
    $uzleti_osszeg += $ut_ktg;

    $z = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->SetXY(10, $y);
    $table1 =  iconv('utf-8', 'iso-8859-2'," $utID  $datumFormat");
    $pdf->MultiCell(45,8,$table1,"TBL","J");

    $pdf->SetXY(25, $y);
    $table1 =  iconv('utf-8', 'iso-8859-2',"$utHonnan - $utHova");
    $pdf->MultiCell(60,8,$table1,"TB","C");

    $pdf->SetXY(70, $y);
    $table2 = iconv('utf-8', 'iso-8859-2',"$kezdokm / $zarokm / $utKM");
    $pdf->MultiCell(50,8,$table2,"TB","C");

    $pdf->SetXY(110, $y);
    $table2 = iconv('utf-8', 'iso-8859-2',"$utCel");
    $pdf->MultiCell(35,8,$table2,"TB","C");

    $pdf->SetXY(145, $y);
    $table2 = iconv('utf-8', 'iso-8859-2',"$utCel");
    $ut_ktgPenz = penz($ut_ktg);
    $pdf->MultiCell(30,8,"$ut_ktgPenz Ft","TB","C");

    $pdf->SetXY(175, $y);
    $table3 =  iconv('utf-8', 'iso-8859-2'," $utKM km");
    $amortizacios_koltsegPenz = penz($amortizacios_koltseg);
    $pdf->MultiCell(25,8,"$amortizacios_koltsegPenz Ft","TBR","C");

    $pdf->Line(10,$y,200,$y);
    $pdf->Line(10,$y - 8,200,$y - 8);
    $pdf->Line(10,$y + 8,200,$y + 8);
    $global_osszeg += $amortizacios_koltseg;
    $global_osszeg += $ut_ktg;

  }
}


$tankolasOsszeg = 0;
for ($i=1; $i < sizeof($csv); $i++) {
  $tankolasOsszeg += (float)$csv[$i]['osszeg'];
}
$ossz_km = $utolsoNapKm - $elsoNapKm;
$magan_km = $ossz_km - $uzleti_km;
$magan_oszeg = $tankolasOsszeg - $uzleti_osszeg;
$tankolasOsszegPenz = penz($tankolasOsszeg);

$uzleti_osszegPenz = penz($uzleti_osszeg);
$amortizacio_osszegPenz = penz($amortizacio_osszeg);
$osszegzes = iconv('utf-8', 'iso-8859-2',"Összesen:     $uzleti_osszegPenz      -     $amortizacio_osszegPenz Ft  ");
$pdf->Cell(0,8,$osszegzes,0,1,"R");
$pdf->SetFont("LiberationMono-Regular","","7"); // mindenhol ujra kell meghatarozni a fontot

$pdf->Cell(0,2,"",0,1,"R");
$ossz_kmek = iconv('utf-8', 'iso-8859-2',"Üzleti kilométer: $uzleti_km km\nMagán kilométer: $magan_km km\nÖsszesen: $ossz_km km");
$pdf->MultiCell(50,4,"$ossz_kmek","TBRL","L");

$y += 17;
$pdf->SetXY(120, $y);
$magan_oszegPenz = penz($magan_oszeg);
$ossz_kmek = iconv('utf-8', 'iso-8859-2',"Összes üzemanyagköltség: $tankolasOsszegPenz Ft
Üzleti üzemanyagköltség összesen: $uzleti_osszegPenz Ft
Magán üzemanyagköltség összesen: $magan_oszegPenz Ft
Amortizációs költség összesen: $amortizacio_osszegPenz Ft");
$pdf->MultiCell(80,4,"$ossz_kmek","TBRL","L");

$pdf->SetFont("LiberationMono-Regular","","9"); // mindenhol ujra kell meghatarozni a fontot

$y += 20;
$pdf->SetXY(10, $y);
$magan_osszeg_azaz = szam($magan_oszeg);
$szamlazandok = iconv('utf-8', 'iso-8859-2',"Bruttó számlázandó:  $magan_oszegPenz Ft azaz $magan_osszeg_azaz Ft");
$pdf->MultiCell(0,8,"$szamlazandok","","L");
$pdf->Cell(0,10,"",0,1,"R");
$y += 20;
$pdf->SetXY(15, $y);
$kartyabirtokos = iconv('utf-8', 'iso-8859-2',"Kártyabirtokos");
$pdf->Cell(50,10,"$kartyabirtokos","T",1,"C");
$pdf->SetXY(135, $y);
$utalvanyozo = iconv('utf-8', 'iso-8859-2',"Utalványozó");
$pdf->Cell(50,10,"$utalvanyozo","T",1,"C");
$y += 25;
$pdf->SetXY(15, $y);
$ma = date("Y-m-d",strtotime("now"));
$dateing = iconv('utf-8', 'iso-8859-2',"Dátum: $ma");
$pdf->Cell(50,5,"$dateing","B",1,"L");
// $name = "uploads/elszamolasok/TIG $rendszam $vege.pdf";
 $pdf->Output(); // ha esetleg nem akarjuk egyből letölteni
//$pdf->Output("F",$name,TRUE); //ennek kell leghátul lennie (autómatikus letöltés)
?>
