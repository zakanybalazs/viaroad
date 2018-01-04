<?php
 ?>
<html>
  <head>
    <link rel="icon" type="image/png" href="../uploads/FAV.png">
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="jquery-ui-timepicker-addon" charset="utf-8"></script>
    <script src="jqueryui.js" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <script src="datetimepicker\sample in bootstrap v3\jquery/jquery-1.8.3.min.js"></script>
    <script src='datetimepicker/js/bootstrap-datetimepicker.js'></script>
    <script src="http://cdn.jsdelivr.net/alasql/0.3/alasql.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.12/xlsx.core.min.js"></script>
    <title>ViaRoad</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
  </head>
  <body>
<div class="container">
<div class="jumbotron">
<h1 align="center" >Viaroad használati útmutató</h1>
<p></p>
<div class="col-lg-1"></div>
<div class="col-lg-10">
  <?php if (empty($_GET['ir'])) { ?>
  <form class="" action="leiras.php?dg=irodavezeto" method="get">
  <button type="submit" name="ir" value="igen" class="form-control btn-success btn-md" align="center">Irodavezető vagyok, mutasd az én részem!</button>
</form>
<?php }else {?>
  <form class="" action="leiras.php" method="post">
  <button type="submit" name="ir" value="igen" class="form-control btn-success btn-md" align="center">Nem irodavezető vagyok, mutasd az én részem!</button>
</form>
  <?php }  ?>
</div>
</div>
<div class="well">
<h2>Első bejelentkezés</h2>
<h3>
  Amennyiben még sosem jelentkeztél be a Viaroad rendszerünkbe, kattints a gombra!
</h3>
<p>Ha már létrehoztad a felhasználói fiókod, olvasd el miket kell tenned, hogy mehess utadra.</p>
<?php if (!empty($_GET['ir'])) {  ?>
<a href="../firstlogindg.php" class="btn btn-warning" align="center">Felhasználó létrehozása</a>
  <?php }else {?>
<a href="../firstlogin.php" class="btn btn-info" align="center">Felhasználó létrehozása</a>
<?php } ?>
</div>
<!-- jumbotron vége -->
<?php if (!empty($_GET['ir'])) {  ?>
<button type="button" class="form-control" data-toggle="collapse" data-target="#adminElso">Irodavezetői kötelezettségek</button>
<p></p>
<div class="well collapse in" id="adminElso">
<h3>Irodavezetőként más jogosultságot kapsz a rendszerben mint a többiek, de ezzel feladatok is járnak.</h3>
<p>Autók hozzárendelése</p>
<p>
Az elsődleges különbség, hogy az adminok tudnak a felhasználókhoz hozzárendelni céges autókat. Erre azért van szükség, hogy
ha új utat szeretnének rögzíteni a felhasználók, akkor ne kelljen az összes céges autóból válogatni, csak azokből amik számára
relevánsak. Ezt úgy tudod megtenni, hogy az oldalon a felhasználók fülre navigálsz, majd a felhasználók kezelése gombra kattintva
átkerülsz a megfelelő felületre. Itt keresni tudsz a felhasználók között, illetve az autók gombra kattintva megtekinthetek a
felhasználókhoz hozzárendelt céges autókat. A fenti legördülő listából kiválasztva tudsz hozzárendelni céges autót a korábban kiválasztott felhasználóhoz.
</p>
<p>Céges teljesítésigazolások</p>
<p>
Irodavezetőként neked kell elkészíteni az irodához tartozó céges autó teljesítés igazolását. Ezt az oldalon a TIG menü
Céges autó almenüjében tudod megtenni. Itt kiválaszthatod a rendszámot, a periódust, illetve az igénybevevő céget.
Ezek alapján az oldal egy PDF dokumentumot készít. Ezt az igénybevevő cég leigazolja (pecsétlővel) és továbbítja a teljesítésigazolást kibocsájtójának.
Ez után kiszámlázásra kerül és bekerül a cég könyvelésébe.

</p>
</div>
<?php } ?>
<!-- well vege -->
<button type="button" class="form-control" data-toggle="collapse" data-target="#userElso">Autók</button>
<p></p>
<div class="well collapse <?php if (empty($_GET['ir'])) { echo 'in';} ?>" id="userElso">
<h3>
  Mielőtt útnak indulhatnál, először szükséged lesz egy autóra.
</h3>
<p>Saját autóval</p>
 <p>Ha saját autóddal szeretnél menni, akkor hozz létre egy autót, az "Autóim" menüpontban. Ezt az autót
    más nem fogja látni, de számodra mindig elérhető lesz az utak rögzítésénél. Itt meg kell adnod az
    autód rendszámát, márkáját, típusát, fogyasztását és hogy milyen üzemanyaggal megy. Ezt csak egyszer
    kell megtenned, mert innentől a számítógép manók mindig tudni fogják melyik autóra gondolsz, ha megadod
    a rendszámot. Alul meg tudod tekinteni az általad feljegyzett autókat, illetve itt tudod törölni,
    ha valamiért megváltál tőle.</p>
<p>Céges autóval</p>
<p>Amennyiben egy általunk kapott autóba kívánsz beülni, úgy szólj az irodavezetőnek, aki majd hozzád
    rendeli a megfelelő céges autót. Azért kell ezt külön kezelni, mert a céges autókat nem csak te használhatod.
    Amikor hozzád rendeltek egy autót, onnantól az utak menüpontban a rendszám listából ki tudod választani,
    azt az autót is.</p>
</div>
<!-- well vége -->
<button type="button" class="form-control" data-toggle="collapse" data-target="#userKetto">Mielőtt elindulsz</button>
<p></p>
<div class="well collapse" id="userKetto">
<h2>Útjaim rögzítése</h2>
<h3>Az oldal kialakítása miatt kivállóan lehet telefonról használni... Használd telefonról!</h3>
<br>
Amikor beülsz az autóba, lépj be az utak menübe (amikor bejelentkezel egyből ide kerülsz) és töltsd ki
azokat az adatokat amiket ki tudsz. Pipáld ki a "Jegyezd meg a következő alkalomra" dobozt ezzel jelezve,
hogy még nem végleges a rögzítés. Ha ezt nem teszed meg, nem fogja engedni, hogy lezárd a rögzítést.
Ha nem látod azt a rendszámot, amit szeretnél, nézd meg az "Autók" menüpontot feljebb. Amikor megérkezel
a célállomásodra, akkor tudod véglegesíteni az utadat. Ha feltöltötted a maradék adatokat is, akkor alul,
a "Fájl kiválasztása", gombra kattintva tudsz képet felölteni (a kilóméteróra állásról) vagy a telefonban
a kép készítése menüpontot választva tudsz képet csinálni róla.
</br>
</div>
<!-- well vége -->
<button type="button" class="form-control" data-toggle="collapse" data-target="#userHarom">Elszámolás</button>
<p></p>
<div class="well collapse" id="userHarom">
<h3>Utiköltség elszámolások leadása</h3>
<br>A hét letelte után, az Útjaim fülön generálni kell egy excel táblázatot, amely a régi, papí alapú menetlevelet helyettesíti.
Ez alapján kell elkészíteni az útnilvántartást (jelenlegi excel). Az excel export elkészítéséhez, az Útjaim menüben, a "Hozzáadás" gomb
alatt tudod paraméterezni. A tól-ig dátumot, illetve a rendszámot tudod beállítani, majd a "Mehet" gombra kattintva, a lenti
táblázatban mutatja a szűrésnek megfelelő elemeket. Ezt a táblázatot a "Táblázat exportálása excelben" gombal tudod exportálni.
A régi excelből két példányt kell nyomtatni. Mindkét példányt alá kell írnia gépkocsi vezetőnek, és a helyi kirendeltség vezetőnek.
Utána a útköltség elszámolásra az irodavezető ráírja, hogy milyen költségre kell majd könyvelni az adott költséget
(munka szerinti költség, általános költség, továbbszámlázható költség). Ezek után egy példány a nyomtatott excelből lefűzésre
kerül az irodavezetőnél, és egy példányt eredetiben el kell küldeni a megfelelő cég elszámolását végző személynek.
(pl.Gubek Katalin MD, Varga Vivien -é DI, Radocsai Diána - Öszoc , stb).
Az eredeti eljuttatása elött scannelt formában is át kell küldeni, ehhez csatold az oldalról exportált excelt is.
</br>
<br>A céges autók elszámolásával nincs dolgod, kivéve ha iroda vezető vagy.</br>
</div>
<!-- Well vége -->
</div>
<div class="jumbotron">
  <div class="container">

<h1 align="center">Készen állsz az utazásra?</h1>
<p></p>
<div class="col-lg-1">

</div>
<img src="logo3.png" alt="" align="center">
</div>
</div>

<!-- container vége -->
  </body>
</html>
