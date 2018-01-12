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
$pdf->Cell(0,20,utf8_decode("KIKÜLDETÉSI RENDELVÉNY (A hivatali, üzleti utazás költségtérítéséhez)"),0,1,"C");

$pdf->SetFont("LiberationMono-Regular","","9"); // mindenhol ujra kell meghatarozni a fontot

$rendszam = $_POST['Prendszam'];
$kezdo = $_POST['Pkezdo'];
$vege = $_POST['Pvege'];
$ceg = $_POST['Pceg'];
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
$uzemanyagQ = "SELECT * FROM uzemanyagar WHERE ervenyes < '{$kezdo}' AND tipus = '{$uzemanyag}'";
$uzemanyagSendQ = mysqli_query($viapanServer,$uzemanyagQ);
$aid = 0;
while ($uzemanyagAdatok = mysqli_fetch_assoc($uzemanyagSendQ)) {
  $ennyi = $uzemanyagAdatok['ar'];
  $bid = $uzemanyagAdatok['id'];
  if ($ennyi > $aid) {
    $aid = $ennyi;
  }
}

$sor1 = iconv('utf-8', 'iso-8859-2',"       Neve: $vezeteknev $keresztnev                          Lakcíme: $lakcim");
$pdf->Cell(0,0,$sor1,0,1,"L");

$sor2 = iconv('utf-8', 'iso-8859-2',"       Adószáma: $adoszam                          Szül.idő, hely: $szuletesiido, $szuletesihely");
$pdf->Cell(0,15,$sor2,0,1,"L");

$sor3 = iconv('utf-8', 'iso-8859-2',"       Beosztása: $beosztas                         Szolg. hely: $szolgalatihely");
$pdf->Cell(0,0,$sor3,0,1,"L");

$sor4 = iconv('utf-8', 'iso-8859-2',"       F.Rendszám: $rendszam                           Márka, típus: $marka, $tipus");
$pdf->Cell(0,15,$sor4,0,1,"L");

$sor5 = iconv('utf-8', 'iso-8859-2',"       Üzemanyag ár: $ennyi Ft/L                       Norma: $fogyasztas L/100Km");
$pdf->Cell(0,0,$sor5,0,1,"L");

$sor6 = iconv('utf-8', 'iso-8859-2',"       Löktérfogat: $terfogat cm3                         Üzemanyag: $uzemanyag");
$pdf->Cell(0,15,$sor6,0,1,"L");

$pdf->Line(10,105,200,105);
$pdf->Cell(0,10,'',0,1,"L"); // úres, hogy eltolja az alatta lévő cellákat
$fejlec1 =  iconv('utf-8', 'iso-8859-2',"Kiküldetési utasítás");
$pdf->Cell(0,8,$fejlec1,1,1,"C");
$fejlec2 =  iconv('utf-8', 'iso-8859-2'," VID       Dátum              Viszonylata                         Célja              Megtett km");
$pdf->Cell(0,8,$fejlec2,1,1,"L");


$utakQ = "SELECT * FROM utak WHERE rendszam = '{$rendszam}'";
$utakSendQ = mysqli_query($viapanServer,$utakQ);
$km = 0;
$x = 0;
while ($rows = mysqli_fetch_assoc($utakSendQ)) {
  if ($rows["datum"] >= $kezdo && $rows["datum"] <= $vege) {
    $x = $x + 1;
    $km = $km + $rows["km"];
    $utID = $rows['id'];
    $utKM = $rows["km"];
    $utDatum = $rows["datum"];
    $utHonnan = $rows["honnan"];
    $utHova = $rows["hova"];
    $utCel = $rows["cel"];

    $datumTT = date_create($utDatum);
    $datumFormat = date_format($datumTT,'Y-m-d H:i');
    $z = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->SetXY(10, $y);
    $table1 =  iconv('utf-8', 'iso-8859-2'," $utID  $datumFormat");
    $pdf->MultiCell(45,8,$table1,"TBL","J");

    $pdf->SetXY(55, $y);
    $table1 =  iconv('utf-8', 'iso-8859-2',"$utHonnan - $utHova");
    $pdf->MultiCell(65,8,$table1,"TB","C");

    $pdf->SetXY(116, $y);
    $table2 = iconv('utf-8', 'iso-8859-2',"$utCel");
    $pdf->MultiCell(59,8,$table2,"TB","C");

    $pdf->SetXY(175, $y);
    $table3 =  iconv('utf-8', 'iso-8859-2'," $utKM km");
    $pdf->MultiCell(25,8,$table3,"TBR","C");


  }
}
$osszesen =  iconv('utf-8', 'iso-8859-2',"összesen megtett km: $km");
$pdf->Cell(0,8,$osszesen,0,1,"R");
$pdf->Cell(0,10,utf8_decode("Költségelszámolás"),0,1,"L");
$keplet = ($ennyi * $fogyasztas) / 100 * $km;
$keplet2 = 9 * $km;
$osszesen2 = $keplet + $keplet2;
$keplet = round($keplet);
$keplet = penz($keplet);
$ktg1 =  iconv('utf-8', 'iso-8859-2',"$ennyi.- Ft / liter X $fogyasztas liter / 100Km X $km km   =                    $keplet Ft");
$pdf->Cell(0,8,$ktg1,1,1,"R");
$keplet2 = penz($keplet2);
$ktg2 =  iconv('utf-8', 'iso-8859-2',"9.- Ft / km X $km km  =                    $keplet2 Ft");
$pdf->Cell(0,8,$ktg2,1,1,"R");

$osszesen2 = round($osszesen2);
$osszesen2 = penz($osszesen2);
$ktg2 =  iconv('utf-8', 'iso-8859-2',"Összesen:                              $osszesen2 Ft ");
$pdf->Cell(0,8,$ktg2,0,1,"R");
$y = $pdf->GetY();
$pdf->SetXY(10, $y + 5);
$kocka1 =  iconv('utf-8', 'iso-8859-2'," A költségelszámolás végösszegét felvettem:");
$pdf->MultiCell(70,8,$kocka1,"LRT","C");

$pdf->SetXY(10, $y + 20);
$maiDatum = date("Y/m/d");
$kocka2 =  iconv('utf-8', 'iso-8859-2',"Dátum: ");
$pdf->MultiCell(70,20,$kocka2,"LR","C");
$pdf->SetXY(10, $y + 40);
$kocka3 =  iconv('utf-8', 'iso-8859-2',"$vezeteknev $keresztnev aláírása");
$pdf->MultiCell(70,6,$kocka3,1,"C");


$pdf->SetXY(130, $y + 5);
$kocka1 =  iconv('utf-8', 'iso-8859-2',"A kiküldetést elrendelő bélyegzője és aláírása:");
$pdf->MultiCell(70,8,$kocka1,"LRT","C");

$pdf->SetXY(130, $y + 20);
$maiDatum = date("Y/m/d");
$kocka2 =  iconv('utf-8', 'iso-8859-2',"");
$pdf->MultiCell(70,20,$kocka2,"LR","C");
$pdf->SetXY(130, $y + 40);
$kocka3 =  iconv('utf-8', 'iso-8859-2',"aláírás, Ph.");
$pdf->MultiCell(70,6,$kocka3,1,"C");


$name = "uploads/elszamolasok/TIG-$rendszam-$vege.pdf";
// $pdf->Output(); // ha esetleg nem akarjuk egyből letölteni
$pdf->Output("F",$name,TRUE); //ennek kell leghátul lennie (autómatikus letöltés)
?>
