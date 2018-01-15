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
$pdf->Cell(0,48,utf8_decode("Teljesítés igazolás"),0,1,"C");

header("Content-Type: application/json; charset=UTF-8");

$kod = json_decode($_REQUEST['kod'], true);
// header("Content-Type: text/json");
// echo json_encode(array( $kod ));
$kod = $kod[0];
$rendszam = $kod['rendszam'];
$kezd = $kod['kezdet'];
$vege = $kod['vegzet'];
$kolcsonID = $kod['kolcson'];

$ceg = getCegByRendszam($rendszam);
$telep = getCegTelepByName($ceg);

$dij = getCegDijByCeg($ceg);


$kolcson = getCegNameByID($kolcsonID);
$kolcsontelep = getCegTelepById($kolcsonID);
$elso = iconv('utf-8', 'iso-8859-2',"Alulírottak hivatalosan igazoljuk, hogy a(z) $ceg $telep  a $kolcson $kolcsontelep számára a következő teljesítést végezte $kezd - $vege időszakban:");
$pdf->SetFont("LiberationMono-Regular","","9"); // mindenhol ujra kell meghatarozni a fontot
//$pdf->Cell(0,80,$elso,0,1,"L");
$pdf->MultiCell(0,0,"");
$pdf->MultiCell(0,8,$elso);
$masodik = iconv('utf-8', 'iso-8859-2',"Teljesített Km               Egységár");
$pdf->Text(80,92,$masodik);
$pdf->MultiCell(0,15,""); // Üres, csak azért kell mert a text float


$query = "SELECT * FROM utak WHERE rendszam = '{$rendszam}' AND kolcsonbe = '{$kolcsonID}'";
$result = mysqli_query($viapanServer,$query);
$km = 0;
while ($rows = mysqli_fetch_assoc($result)) {
  if ($rows["datum"] >= $kezd && $rows["datum"] <= $vege) {
    $km = $km + $rows["km"];
  }
}


$egysegar = $dij;
$osszesen = $km * $egysegar;
$osszesenPenz = penz($osszesen);
$harmadik = iconv('utf-8', 'iso-8859-2',"$rendszam Rendszámú bérelt jármű          $km Km          *          $dij Ft/Km  =   $osszesenPenz Ft");
$pdf->MultiCell(0,5,$harmadik);

$pdf->Line(8,108,182,108);
$negyedik = iconv('utf-8', 'iso-8859-2',"Nettó összesen:");
$pdf->SetFont("LiberationMono-Regular","","9"); // mindenhol ujra kell meghatarozni a fontot
$pdf->Cell(50,20,$negyedik,0,0,"L");
$netto = "$osszesenPenz Ft"; // ez majd az $osszesen lesz
$pdf->text(131,119,$netto);


$pdf->MultiCell(0,25,""); // szeparáló

$otodik = iconv('utf-8', 'iso-8859-2',"ÁFA 27%");
$pdf->MultiCell(0,8,$otodik);
$afaossz = $osszesen * 0.27;
$afa = $afaossz;
$afakerek = (integer) $afa;
$afakerekPenz = penz($afakerek);
$afakerek2 = "$afakerekPenz Ft";
$pdf->text(131,137,$afakerek2);

$pdf->Line(8,140,182,140);
$hatodik = iconv('utf-8', 'iso-8859-2',"A teljestés bruttó értéke:");
$pdf->Cell(0,30,$hatodik,0,1,"L");
$bruttoertek = $afaossz + $osszesen;
$bruttoertek2 = (integer) $bruttoertek;
$bruttoertekPenz = penz($bruttoertek2);
$brutto = "$bruttoertekPenz Ft"; // ez majd az $osszesen lesz
$pdf->text(131,152,$brutto);

$pdf->MultiCell(0,10,""); // szeparáló

$azaz = szam($osszesen);
$osszesenPenz = penz($osszesen);
$azaz2 = ($azaz);
$azaz3 = iconv('utf-8', 'iso-8859-2',"$osszesenPenz HUF azaz $azaz2 forint");
$hetedik = iconv('utf-8', 'iso-8859-2',"Összesen számlázható:");
$pdf->Cell(0,0,$hetedik,0,1,"L");
$pdf->Cell(0,20,$azaz3,0,1,"L");

$pdf->MultiCell(0,10,""); // szeparáló

$nyolcadik = "A közöttünk létrejött szerződés alapján a(z) $ceg $telep által végzett szolgáltatás határozott időre szóló elszámolásban történik, ezért a 2007. évi CXXVII. számú Áfa törvény 57-58 § alapján a(z) $ceg teljesítéséről kiállított számlán szereplő teljesítés időpontjának megegyezik a fizetési határidővel.";
$nyolcadik2 = iconv('utf-8', 'iso-8859-2',$nyolcadik);
$pdf->MultiCell(0,8,$nyolcadik2);

$pdf->MultiCell(0,20,""); // szeparáló

$kilencedik = iconv('utf-8', 'iso-8859-2',"Fizetés módja: átutalás");
$pdf->MultiCell(0,0,$kilencedik);
//$nap = date('Y.m.d.');
$nap = $kod['vegzet'];
$nap2 = str_replace('-', '/', $nap);
$tomorrow = date('m-d-Y',strtotime($nap2 . "+1 days"));
$tizedik = iconv('utf-8', 'iso-8859-2',"Kaposvár            $tomorrow ");
$pdf->MultiCell(0,15,$tizedik);

$pdf->Line(130,265,185,265);
// $tizenegyedikk = em("Cégszerű aláírás                               ");
// $tizenegyedik = urldecode($tizenegyedikk);
$tizenegyedik = iconv('utf-8','iso-8859-2',"Cégszerű aláírás            ");
$pdf->Cell(0,4,$tizenegyedik,0,1,"R");
// itt kell meghatarozni, hogy hova fog bekerulni. Ezt felvisszuk az adatbazisba
$name = "uploads/cegeselszamolasok/TIG-$rendszam-$kolcsonID-$vege.pdf";
//elhelyezzuk a file-t es rogzitjuk az adatbazisban, hogy hova raktuk

$q = "INSERT INTO cegestigek (rendszam, kezd, vege, kolcsonid, osszeg, pdfhely) VALUES ('{$rendszam}','{$kezd}','{$vege}','{$kolcsonID}','{$osszesen}','{$name}')";
$sq = mysqli_query($viapanServer, $q);


// $pdf->Output(); // ha esetleg nem akarjuk egyből letölteni
$pdf->Output("F",$name,TRUE); //ennek kell leghátul lennie (autómatikus letöltés)
 ?>
